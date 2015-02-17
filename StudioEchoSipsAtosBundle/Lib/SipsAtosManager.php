<?php

namespace StudioEchoBundles\StudioEchoSipsAtosBundle\Lib;

use Symfony\Component\DependencyInjection;
use Symfony\Component\HttpKernel\Log\LoggerInterface;

/**
 *
 * @author Studio Echo / Lionel Bouzonville
 */
class SipsAtosManager {
    // container & propel query instance & monolog service
    private $serviceContainer;
    private $orderQuery;
    private $logger;
    
    // Atos SIPS parameters
    private $pathfile;
    private $binRequest;
    private $binResponse;
    private $merchantId;
    private $merchantCountry;
    private $currencyCode;
    private $normalReturnUrl;
    private $cancelReturnUrl;
    private $automaticResponseUrl;
    private $language;
    private $paymentMeans;
    private $headerFlag;
    private $bgcolor;
    private $blockAlign;
    private $blockOrder;
    private $textcolor;
    private $logoId;
    private $logoId2;
    private $advert;
    private $backgroundId;
    private $templatefile;
    
    // Atos request & response array
    private $requestInfos;
    private $responseInfos;
    
    // order status (version simplifiée)
    private $orderStatus;
    
    const PAID = 'PAID';
    const WAITING = 'WAITING';
    const REJECTED = 'REJECTED';
    
    /**
     *
     * @param DependencyInjection\ContainerInterface $container
     * @param OrderQuery $orderQuery
     * @param LoggerInterface $logger
     */
    function __construct(DependencyInjection\ContainerInterface $container, \StudioEchoBundles\StudioEchoSipsAtosBundle\Lib\OrderQueryInterface $orderQuery, LoggerInterface $logger = null)
    {
        $this->serviceContainer =& $container;
        $this->orderQuery = $orderQuery;
        $this->logger = $logger;

        // Get Atos SIPS module parameters
        $studioEchoSipsAtos = $this->serviceContainer->getParameter('studio_echo_sips_atos');
        $this->pathfile = $studioEchoSipsAtos['pathfile'];
        $this->binRequest = $studioEchoSipsAtos['bin_request'];
        $this->binResponse = $studioEchoSipsAtos['bin_response'];
        $this->merchantId = $studioEchoSipsAtos['merchant_id'];
        $this->merchantCountry = $studioEchoSipsAtos['merchant_country'];
        $this->currencyCode = $studioEchoSipsAtos['currency_code'];
        $this->normalReturnUrl = $studioEchoSipsAtos['normal_return_url'];
        $this->cancelReturnUrl = $studioEchoSipsAtos['cancel_return_url'];
        $this->automaticResponseUrl = $studioEchoSipsAtos['automatic_response_url'];
        $this->language = $studioEchoSipsAtos['language'];
        $this->paymentMeans = $studioEchoSipsAtos['payment_means'];
        $this->headerFlag = $studioEchoSipsAtos['header_flag'];
        $this->bgcolor = $studioEchoSipsAtos['bgcolor'];
        $this->blockAlign = $studioEchoSipsAtos['block_align'];
        $this->blockOrder = $studioEchoSipsAtos['block_order'];
        $this->textcolor = $studioEchoSipsAtos['textcolor'];
        $this->logoId = $studioEchoSipsAtos['logo_id'];
        $this->logoId2 = $studioEchoSipsAtos['logo_id2'];
        $this->advert = $studioEchoSipsAtos['advert'];
        $this->backgroundId = $studioEchoSipsAtos['background_id'];
        $this->templatefile = $studioEchoSipsAtos['templatefile'];
    }
    
    /**
     * Appel le binaire initialisant la requête de paiement.
     * 
     * @param $orderId      Identifiant de la commande
     * @return string       Formulaire / Code généré
     */
    public function computeAtosRequest($orderId) {
        if (null !== $this->logger) {
            $this->logger->debug('*** computeAtosRequest');
        }

        // get total order to pay
        $order = $this->orderQuery->findPk($orderId);
        
        // Méthode requise sur objet Order
        $amount = $order->getTotalPaid() * 100;

        // Affectation des paramètres obligatoires
	    $parm = 'merchant_id='.$this->merchantId;
	    $parm .= ' merchant_country='.$this->merchantCountry;
	    $parm .= ' amount='.$amount;
	    $parm .= ' currency_code='.$this->currencyCode;
	    $parm .= ' pathfile='.$this->pathfile;
        $parm .= ' transaction_id='.$orderId;

        if (null !== $this->logger) {
            $this->logger->debug('$parm = '.print_r($parm, true));
        }
        
        // Affectation des paramètres optionnels
        $parm .= ' normal_return_url='.$this->normalReturnUrl;
        $parm .= ' cancel_return_url='.$this->cancelReturnUrl;
        $parm .= ' automatic_response_url='.$this->automaticResponseUrl;
        $parm .= ' language='.$this->language;
        $parm .= ' payment_means='.$this->paymentMeans;
        $parm .= ' header_flag='.$this->headerFlag;
        $parm .= ' bgcolor='.$this->bgcolor;
        $parm .= ' block_align='.$this->blockAlign;
        $parm .= ' block_order='.$this->blockOrder;
        $parm .= ' textcolor='.$this->textcolor;
        $parm .= ' logo_id='.$this->logoId;
        $parm .= ' logo_id2='.$this->logoId2;
        $parm .= ' advert='.$this->advert;
        $parm .= ' background_id='.$this->backgroundId;
        $parm .= ' templatefile='.$this->templatefile;
        
        if (null !== $this->logger) {
            $this->logger->debug('$parm = '.print_r($parm, true));
        }
        
	   // Appel du binaire request
	   $parm = escapeshellcmd($parm);	
	   $result=exec("$this->binRequest $parm");

        if (null !== $this->logger) {
            $this->logger->debug('appel = '.print_r("$this->binRequest $parm", true));
            $this->logger->debug('result = '.print_r($result, true));
        }

	    // sortie de la fonction : $result=!code!error!buffer!
	    //	- code=0	: la fonction génère une page html contenue dans la variable buffer
	    //	- code=-1 	: La fonction retourne un message d'erreur dans la variable error
        $this->requestInfos = explode ("!", $result);
        if (null !== $this->logger) {
            $this->logger->debug('requestInfos = '.print_r($this->requestInfos, true));
        }
        
        // Check return validity
        $code = isset($this->requestInfos[1])?$this->requestInfos[1]:'';
	    $error = isset($this->requestInfos[2])?$this->requestInfos[2]:'';
	    $message = isset($this->requestInfos[3])?$this->requestInfos[3]:'';
        if ($code == "" && $error == "") {
            throw new \Exception('Code retour et message erreur vide / erreur appel script/chemin request atos.');
 	    }
        
        // Check API Error
        if ($code == -1) {
            throw new \Exception('Erreur appel API - message = '.$error);
        }
        
        $form = "<br><br>";
        # OK, affichage du mode DEBUG si activé
        $form .= " $error <br>";
        $form .= "  $message <br>";
        
        return $form;
    }
    
    /**
     * Récupère la réponse de paiement et fait les maj appropriées.
     */
    public function computeAtosResponse() {
        if (null !== $this->logger) {
            $this->logger->debug('*** computeAtosResponse');
        }

        // get request 'DATA' from atos
        $request = $this->serviceContainer->get('request');
        $data = "message=".$request->request->get('DATA');

        // Appel du binaire response
        $pathfile="pathfile=$this->pathfile";
        $data = escapeshellcmd($data);
        $result = exec("$this->binResponse $pathfile $data");

        // Sortie de la fonction : !code!error!v1!v2!v3!...!v29
        //  - code=0	: la fonction retourne les données de la transaction dans les variables v1, v2, ...
        //              : Ces variables sont décrites dans le GUIDE DU PROGRAMMEUR
        //  - code=-1 	: La fonction retourne un message d'erreur dans la variable error
        $this->responseInfos = explode ("!", $result);
        if (null !== $this->logger) {
            $this->logger->debug('responseInfos = '.print_r($this->responseInfos, true));
        }
        
        // Check return validity
        $code = $this->responseInfos[1];
        $error = $this->responseInfos[2];
        if ($code == "" && $error == "") {
            throw new \Exception('Code retour et message erreur vide / erreur appel script/chemin response atos.');
        }
        
        // Check API Error
        if ($code == -1) {
            throw new \Exception('Erreur appel API - message = '.$error);
        }

        // 3D Secure?
        $secure = $this->responseInfos[34];
        switch($secure) {
            case 'SSL': break; // 3D Secure non activé
            case '3D_SUCCESS': break;
            case '3D_FAILURE':
                $this->orderStatus = self::REJECTED;
                break;
            case '3D_ERROR': break; // Erreur sur les serveurs 3D Secure > client non fautif, on ne rejette pas le paiement
            case '3D_NOTENROLLED': break;
            case '3D_ATTEMPT': break;
        }
        
        // Si le test 3D Secure n'a pas eu lieu ou n'a pas été refusé, on contrôle le code retour classique
        if ($this->orderStatus != self::REJECTED) {
            // Update payment status => PAID / WAITING / REJECTED
            $responseCode = $this->responseInfos[11];

            switch($responseCode) {
                case 0:
                    $this->orderStatus = self::PAID;
                    break;
                case 2:
                    $this->orderStatus = self::WAITING;
                    break;
                case 3:
                    $this->orderStatus = self::REJECTED;
                    break;
                case 5:
                    $this->orderStatus = self::REJECTED;
                    break;
                case 12:
                    $this->orderStatus = self::REJECTED;
                    break;
                case 17:
                    $this->orderStatus = self::REJECTED;
                    break;
                case 30:
                    $this->orderStatus = self::REJECTED;
                    break;
                case 34:
                    $this->orderStatus = self::REJECTED;
                    break;
                case 75:
                    $this->orderStatus = self::REJECTED;
                    break;
                case 90:
                    $this->orderStatus = self::REJECTED;
                    break;
                default:
                    $this->orderStatus = self::WAITING;
                    break;
            }
        }
        
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
        return $this->responseInfos[6];
    }
    
    /**
     * 
     */
    public function updatePaymentOrderStatus() {
        $orderId = $this->responseInfos[6];
        if ($this->orderStatus == self::PAID) {
            $this->orderQuery->atos_updateOrderStatusAfterPaymentAccepted($orderId);
            $this->orderQuery->atos_updateProductsAfterOrderCompleted($orderId);
        } elseif ($this->orderStatus == self::REJECTED) {
            $this->orderQuery->atos_updateOrderStatusAfterPaymentRejected($orderId);
        }
    }
}