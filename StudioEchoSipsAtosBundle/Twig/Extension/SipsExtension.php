<?php
namespace StudioEchoBundles\StudioEchoSipsAtosBundle\Twig\Extension;

use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class SipsExtension extends \Twig_Extension
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
            'cartSipsForm' => new \Twig_Function_Method($this, 'cartSipsForm')
        );
    }
    
    /**
     * 
     */
    public function cartSipsForm($orderId)
    {
        $sipsAtosManager = $this->container->get('studio_echo_sips_atos');
        try {
            $form = $sipsAtosManager->computeAtosRequest($orderId);
        } catch (\Exception $e) {
            // TODO: envoi mail admin
            
            // MAJ form
            $form =
                'Une erreur technique est apparu lors de l\'appel de notre partenaire BNP Paribas.<br/><br/>
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
        return 'sipsextension';
    }
}