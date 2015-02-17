<?php

namespace StudioEchoBundles\StudioEchoSipsAtosBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

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
        } catch (Exception $e) {
            // TODO: envoi mail admin
            // Log error
            $logger->err('AutoResponseListenerController - computeAtosResponse exception - message = '.print_r($e->getMessage(), true));
        }
            
        // Update payment order status
        try {
            $sipsAtosManager->updatePaymentOrderStatus();
        } catch (Exception $e) {
            // TODO: envoi mail admin
            // Log error
            $logger->err('AutoResponseListenerController - updatePaymentOrderStatus exception - message = '.print_r($e->getMessage(), true));
        }

        // Envoi de l'email via event dispatcher > event 'order_email' existant et configuré pour gérer un GenericEvent contenant l'ID de la commande
        $dispatcher = $this->get('event_dispatcher')->dispatch('order_email', new GenericEvent($sipsAtosManager->getOrderId()));
        
        $response = new Response();
        $response->setStatusCode(200);
        
        return $response;
    }
}