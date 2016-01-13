<?php

namespace StudioEchoBundles\StudioEchoSipsAtosBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\EventDispatcher\GenericEvent;
use SlaviaVintage\FrontBundle\Event\OrderEmailEvent;

/**
 *  Sample listener controller teh "Call_AutoResponse"
 */
class AutoResponseListenerController extends Controller
{
    /**
     *
     */
    public function indexAction()
    {
        $logger = $this->get('logger');
        $logger->debug('*** AutoResponseListenerController');
        
        // getting manager registered in container
        $sipsAtosManager = $this->get('studio_echo_sips_atos');
        
        // Compute Atos AutoResponse
        try {
            $sipsAtosManager->computeAtosResponse();
        } catch (\Exception $e) {
            // TODO: envoi mail admin
            // Log error
            $logger->err('AutoResponseListenerController - computeAtosResponse exception - message = '.print_r($e->getMessage(), true));
        }
            
        // Update payment order status
        try {
            $sipsAtosManager->updatePaymentOrderStatus();
        } catch (\Exception $e) {
            // TODO: envoi mail admin
            // Log error
            $logger->err('AutoResponseListenerController - updatePaymentOrderStatus exception - message = '.print_r($e->getMessage(), true));
        }

        try {
            // Send email
            // TODO: to refactor w. GenericEvent
            $event = new OrderEmailEvent($sipsAtosManager->getOrderId(), $this->get('mailer'), $this->get('templating'), $this->get('logger'));
            $dispatcher = $this->get('event_dispatcher');
            $dispatcher->dispatch('order.email', $event);
        } catch (\Exception $e) {
            // TODO: envoi mail admin
            // Log error
            $logger->err('AutoResponseListenerController - dispatch order_email_listener exception - message = '.print_r($e->getMessage(), true));
        }

        $response = new Response();
        $response->setStatusCode(200);
        
        return $response;
    }
}
