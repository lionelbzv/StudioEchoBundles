<?php

namespace StudioEchoBundles\StudioEchoPaypalBundle\Lib;

use Symfony\Component\DependencyInjection;
use Symfony\Component\HttpKernel\Log\LoggerInterface;

/**
 * Description of PaypalManager
 * 
 * docs paypal:
 * https://www.x.com/developers/paypal/documentation-tools/paypal-payments-standard/integration-guide/cart_upload
 * https://www.x.com/developers/paypal/documentation-tools/paypal-payments-standard/integration-guide/Appx_websitestandard_htmlvariables#id08A6HH0D0TA
 * 
 * @author Studio Echo / Lionel Bouzonville w./ help from https://github.com/orderly/symfony2-paypal-ipn
 */
class PaypalManager {
    // container & propel query instance & monolog service
    private $serviceContainer;
    private $orderQuery;
    private $logger;

    // IPN datas
    private $ipnData = array();
    private $orderStatus;

    // Base Paypal configuration
    private $paypalUrl;
    private $notifyUrl;
    private $currencyCode;
    private $business;
    private $pageStyle;
    private $imageUrl;
    private $lc;
    private $noNote;
    private $cn;
    private $noShipping;
    private $returnUrl;
    private $rm;
    private $cbt;
    private $cancelReturn;
    private $charset;

    // Payment status constants we use, more user-friendly than the PayPal ones
    const PAID = 'PAID';
    const WAITING = 'WAITING';
    const REJECTED = 'REJECTED';

    /**
     *
     * @param DependencyInjection\ContainerInterface $container
     * @param OrderQuery $orderQuery
     * @param LoggerInterface $logger
     */
    function __construct(DependencyInjection\ContainerInterface $container, \StudioEcho\StudioEchoPaypalBundle\Lib\OrderQueryInterface $orderQuery, LoggerInterface $logger = null)
    {
        $this->serviceContainer =& $container;
        $this->orderQuery = $orderQuery;
        $this->logger = $logger;

        // Get param settings
        $studio_echo_paypal = $this->serviceContainer->getParameter('studio_echo_paypal');
        $this->paypalUrl = $studio_echo_paypal['paypal_url'];
        $this->notifyUrl = $studio_echo_paypal['notify_url'];
        $this->currencyCode = $studio_echo_paypal['currency_code'];
        $this->business = $studio_echo_paypal['business'];
        $this->pageStyle = $studio_echo_paypal['page_style'];
        $this->imageUrl = $studio_echo_paypal['image_url'];
        $this->lc = $studio_echo_paypal['lc'];
        $this->noNote = $studio_echo_paypal['no_note'];
        $this->cn = $studio_echo_paypal['cn'];
        $this->noShipping = $studio_echo_paypal['no_shipping'];
        $this->returnUrl = $studio_echo_paypal['return'];
        $this->rm = $studio_echo_paypal['rm'];
        $this->cbt = $studio_echo_paypal['cbt'];
        $this->cancelReturn = $studio_echo_paypal['cancel_return'];
        $this->charset = $studio_echo_paypal['charset'];
   }

    /**
     * Construit le form d'appel paypal.
     * 
     * @param $orderId      Identifiant de la commande
     * 
     * @return string       Formulaire / Code généré
     */
    public function computePaypalRequest($orderId) {
        if (null !== $this->logger) {
            $this->logger->debug('*** computePaypalRequest');
        }

        // get total order to pay
        $order = $this->orderQuery->findPk($orderId);
        if (!$order) {
            throw new \Exception('Erreur, la commande n\' pas été créée.');
        }

        // Affectation des paramètres obligatoires
        $form = '<form action="'.$this->paypalUrl.'" id="form_paypal" method="post">
              <input type="hidden" name="cmd" value="_cart">
              <input type="hidden" name="upload" value="1">
              <input type="hidden" name="invoice" value="'.$orderId.'">
              <input type="hidden" name="currency_code" value="'.$this->currencyCode.'">
              <input type="hidden" name="notify_url" value="'.$this->notifyUrl.'">
              <input type="hidden" name="business" value="'.$this->business.'">
              <input type="hidden" name="page_style" value="'.$this->pageStyle.'">
              <input type="hidden" name="image_url" value="'.$this->imageUrl.'">
              <input type="hidden" name="lc" value="'.$this->lc.'">
              <input type="hidden" name="no_note" value="'.$this->noNote.'">
              <input type="hidden" name="cn" value="'.$this->cn.'">
              <input type="hidden" name="no_shipping" value="'.$this->noShipping.'">
              <input type="hidden" name="return" value="'.$this->returnUrl.'">
              <input type="hidden" name="rm" value="'.$this->rm.'">
              <input type="hidden" name="cbt" value="'.$this->cbt.'">
              <input type="hidden" name="cancel_return" value="'.$this->cancelReturn.'">
              <input type="hidden" name="charset" value="'.$this->charset.'">
              ';
        
        // Paramètres du panier
        // TODO: order devrait implémenter une interface définie dans le bundle
        $form .= '<input type="hidden" name="handling_cart" value="'.$order->getTotalShipping().'">';
            
        if (($global_discount = $order->getPromotionShipping()) > 0) {
            $form .= '<input type="hidden" name="discount_amount_cart" value="'.$global_discount.'">';
        }
        
        $i = 1;
        foreach ($orderDetails = $order->getOrderDetails() as $orderDetail) {
            // quantity
            $form .= '<input type="hidden" name="quantity_'.$i.'" value="'.$orderDetail->getProductQuantity().'">';

            // price
            $amount_val = $orderDetail->getProductPrice();
            $form .= '<input type="hidden" name="amount_'.$i.'" value="'.$amount_val.'">';
            
            // label
            $item_name = $orderDetail->getProductName();
            $form .= '<input type="hidden" name="item_name_'.$i.'" value="'.$item_name.'">';
           
            $i++;
        }
        
        $form .= '<div align="center">
            Vous allez utiliser le formulaire sécurisé standard SSL, cliquez sur le logo Paypal ci-dessous
            <img border="0" src="/bundles/studioechopaypal/images/logo-clef.gif">
            :
            <br>
            <br>
            </div>';
        $form .= '<div align=center><input type="image" border="0" src="/bundles/studioechopaypal/images/logo-paypal.jpg" name="PAYPAL" /></div>';
        $form .= '</form>
            ';
        
        return $form;
    }
    
    /**
     * Validate the IPN received signal
     * 
     * @return bool
     */
    public function validateIPN()
    {
        if (null !== $this->logger) {
            $this->logger->debug('*** validateIPN');
        }
        
        $request = $this->serviceContainer->get('request');

        //get post parameters
        $parameters = $request->request->all();
        if ($request->getMethod() == 'POST' && !empty($parameters)) {
            $ipnDataRaw = $parameters;
        } else {
            return false;
        }

        // clean up post datas
        foreach (array_keys($ipnDataRaw) as $field) {
            $value = $request->request->get($field);
            
            // Put line feeds back to \r\n for PayPal otherwise multi-line data will be rejected as INVALID
            $ipnDataRaw[$field] = str_replace("\n", "\r\n", $value);

            $this->ipnData[$field] = $ipnDataRaw[$field];
        }
        if (null !== $this->logger) {
            $this->logger->info('$this->ipnData = '.print_r($this->ipnData, true));
        }
        
        // Log transaction type/id
        $transactionId = (isset($this->ipnData['txn_id']) ? $this->ipnData['txn_id'] : null);
        $transactionType = (isset($this->ipnData['txn_type']) ? $this->ipnData['txn_type'] : null);
        if (null !== $this->logger) {
            $this->logger->info('Transaction ID = '.$transactionId);
            $this->logger->info('Transaction TYPE = '.$transactionType);
        }

        // Send a POST to Paypal URL to control the validity of received datas
        $ipnResponse = $this->postData($this->paypalUrl, array_merge(array('cmd' => '_notify-validate'), $ipnDataRaw));
        if ($ipnResponse === false) { // Bail out if we have an error.
            return false;
        }

        // Check that PayPal says that the IPN call we received is not invalid
        if (stristr("INVALID", $ipnResponse)) {
            // Invalid IPN transaction.  Check the log for details.
            if (null !== $this->logger) {
                $this->logger->err('ERROR - PayPal rejected the IPN call as invalid - potentially call was spoofed or was not checked within 30s');
                $this->logger->err('ERROR - $ipnResponse = '.print_r($ipnResponse, true));
            }
            return false;
        }

        // Check that the receiver email / business matches our email address.
        if (($this->ipnData['receiver_email'] || $this->ipnData['business']) != $this->business ) {
            if (null !== $this->logger) {
                $this->logger->err('ERROR - Receiver email ' . $this->ipnData['receiver_email'] . ' nor business login  ' . $this->ipnData['business'] . ' does not match merchant\'s');
                $this->logger->err('ERROR - $ipnResponse = '.print_r($ipnResponse, true));
            }
            return false;
        }

        // Update payment status => PAID / WAITING / REJECTED
        switch ($this->ipnData['payment_status']) {
            case "Completed": // Order has been paid for
                $this->orderStatus = self::PAID;
                break;
            case "Pending": // Payment is still waiting to go through
            case "Processed": // Mostly used to indicate that a cheque has been received and is currently going through the verification process
                $this->orderStatus = self::WAITING;
                break;
            case "Voided": // Bounced or cancelled check
            case "Expired": // Credit card company didn't recognise card
            case "Reversed": // Credit card holder has got the credit card co to reverse the charge
                $this->orderStatus = self::REJECTED;
                break;
            default:
                if (null !== $this->logger) {
                    $this->logger->err('ERROR - Payment status of ' . $this->ipnData['payment_status'] . ' is not recognised');
                    $this->logger->err('ERROR - $ipnResponse = '.print_r($ipnResponse, true));
                }
                return false;
        }

        // validation ok
        if (null !== $this->logger) {
            $this->logger->info('Parsing, authentication and validation complete.');
            $this->logger->info('$ipnResponse = '.print_r($ipnResponse, true));
        }
        
        return true;
    }
    
    /**
     * Sending post data to PayPal IPN service
     * 
     * @param string $url
     * @param array $postData
     * 
     * @return string
     */
    private function postData($url, $postData)
    {
        // Put the postData into a string
        $postString = '';
        foreach ($postData as $field=>$value) {
            $postString .= $field . '=' . urlencode(stripslashes($value)) . '&'; // Trailing & at end of post string is forgivable
        }

        $parsedURL = parse_url($url);

        // fsockopen is a bit odd - it just takes the host without the scheme - unless you want to use
        // ssl, in which case you need to use ssl://, not http://
        $ipnURL = ($parsedURL['scheme'] == "https") ? "ssl://" . $parsedURL['host'] : $parsedURL['host'];
        // Likewise, if using ssl, then need to change port from 80 to 443
        $ipnPort = ($parsedURL['scheme'] == "https") ? 443 : 80;
        
        $fp = @fsockopen($ipnURL, $ipnPort);

        if (!$fp) {
            return false;
        }

        fputs($fp, "POST $parsedURL[path] HTTP/1.1\r\n");
        fputs($fp, "Host: $parsedURL[host]\r\n");
        fputs($fp, "Content-type: application/x-www-form-urlencoded\r\n");
        fputs($fp, "Content-length: " . strlen($postString) . "\r\n");
        fputs($fp, "Connection: close\r\n\r\n");
        fputs($fp, $postString . "\r\n\r\n");

        $response = '';
        while (!feof($fp)) {
            $response .= fgets($fp, 1024);
        }
        fclose($fp); // Close connection

        if (strlen($response) == 0) {
            if (null !== $this->logger) {
                $this->logger->err('ERROR - Response from PayPal was empty');
            }
            
            return false;
        }

        return $response;
    }

    /**
     * Get orderStatus
     *
     * @return string 
     */
    public function getOrderStatus()
    {
        return $this->orderStatus;
    }
    
    /**
     * Get orderStatus
     *
     * @return string 
     */
    public function getOrderId()
    {
        return $this->ipnData['invoice'];
    }
    
    /**
     * 
     */
    public function updatePaymentOrderStatus() {
        $orderId = $this->ipnData['invoice'];
        if ($this->orderStatus == self::PAID) {
            $this->orderQuery->pp_updateOrderStatusAfterPaymentAccepted($orderId);
            $this->orderQuery->pp_updateProductsAfterOrderCompleted($orderId);
        } elseif ($this->orderStatus == self::REJECTED) {
            $this->orderQuery->pp_updateOrderStatusAfterPaymentRejected($orderId);
        }
    }
    
}
