<?php
# Test/MyBundle/Twig/Extension/MyBundleExtension.php

namespace StudioEcho\StudioEchoPaypalBundle\Twig\Extension;

use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class PaypalExtension extends \Twig_Extension
{
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return array(
            'cartUploadForm' => new \Twig_Function_Method($this, 'cartUploadForm')
        );
    }
    
    /**
     * 
     */
    public function cartUploadForm($orderId)
    {
        $paypalManager = $this->container->get('studio_echo_paypal');
        try {
            $form = $paypalManager->computeAtosRequest($orderId);
        } catch (\Exception $e) {
            // TODO: envoi mail admin
            
            // MAJ form
            $form =
                'Une erreur technique est apparu lors de l\'appel de notre partenaire Paypal.<br/><br/>
                Merci de nous contacter pour nous préciser votre problème.<br/><br/>
                Votre numéro de commande est le : ' . $orderId . '
                ';
        }
        
        return $form;
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'paypalextension';
    }
}