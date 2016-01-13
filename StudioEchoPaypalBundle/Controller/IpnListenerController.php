<?php

namespace StudioEchoBundles\StudioEchoPaypalBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use StudioEchoBundles\StudioEchoPaypalBundle\Lib\PaypalIpnManager;

use SlaviaVintage\FrontBundle\Event\OrderEmailEvent;

/**
 *  Sample listener controller for IPN messages
 */
class IpnListenerController extends Controller
{
    /**
     *
     */
    public function indexAction()
    {
        $logger = $this->get('logger');
        $logger->debug('*** IpnListenerController');

        // getting ipn service registered in container
        $paypalManager = $this->get('studio_echo_paypal');
        
        //validate ipn (generating response on PayPal IPN request)
        try {
            $validateIpn = $paypalManager->validateIPN();
        } catch (\Exception $e) {
            // TODO: envoi mail admin
            // Log error
            $logger->err('IpnListenerController - updatePaymentOrderStatus exception - message = '.print_r($e->getMessage(), true));
        }

        if ($validateIpn) {
            $logger->debug('validateIPN ok');
            try {
                // update payment status
                $paypalManager->updatePaymentOrderStatus();
            } catch (\Exception $e) {
                // TODO: envoi mail admin
                // Log error
                $logger->err('IpnListenerController - updatePaymentOrderStatus exception - message = '.print_r($e->getMessage(), true));
            }

            try {
                // Send email
                // TODO: refactor w. GenericEvent
                $event = new OrderEmailEvent($paypalManager->getOrderId(), $this->get('mailer'), $this->get('templating'), $this->get('logger'));
                $dispatcher = $this->get('event_dispatcher');
                $dispatcher->dispatch('order.email', $event);
            } catch (\Exception $e) {
                // TODO: envoi mail admin
                // Log error
                $logger->err('IpnListenerController - updatePaymentOrderStatus exception - message = '.print_r($e->getMessage(), true));
            }
        }

        $response = new Response();
        $response->setStatusCode(200);
        
        return $response;
    }
}
