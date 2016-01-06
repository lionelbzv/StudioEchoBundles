<?php

namespace StudioEchoBundles\StudioEchoPaypalBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('studio_echo_paypal');

        $rootNode
            ->children()
                ->scalarNode('internal_submit_url')
                    ->info('Value is an internal url which handle the original "pay with paypal" action. This action is intended to submit values to paypal url.')
                ->end()
                ->scalarNode('paypal_url')
                    ->defaultValue('https://www.sandbox.paypal.com/cgi-bin/webscr')
                    ->isRequired()
                    ->validate()
                        ->ifNotInArray(array('https://www.sandbox.paypal.com/cgi-bin/webscr', 'https://www.paypal.com/cgi-bin/webscr'))
                        ->thenInvalid('Invalid type %s')
                    ->end()
                    ->info('Value has to be URL for implementing cart_upload_command (sandbox or real).')
                ->end()
                ->scalarNode('notify_url')
                    ->info('The URL to which PayPal posts information about the payment, in the form of Instant Payment Notification messages.')
                ->end()
                ->scalarNode('currency_code')
                    ->defaultValue('EUR')
                    ->isRequired()
                    ->info('The currency of the payment.')
                ->end()
                ->scalarNode('business')
                    ->isRequired()
                    ->info('Your PayPal ID or an email address associated with your PayPal account.')
                ->end()
                ->scalarNode('page_style')
                    ->info('The custom payment page style for checkout pages. ')
                ->end()
                ->scalarNode('image_url')
                    ->info('The URL of the 150x50-pixel image displayed as your logo in the upper left corner of the PayPal checkout pages. ')
                ->end()
                ->scalarNode('lc')
                    ->info('The locale of the login or sign-up page, which may have the specific country s language available, depending on localization. ')
                ->end()
                ->scalarNode('no_note')
                    ->validate()
                        ->ifNotInArray(array(0, 1))
                        ->thenInvalid('Invalid type %s')
                    ->end()
                    ->info('Do not prompt buyers to include a note with their payments.')
                ->end()
                ->scalarNode('cn')
                    ->info('Label that appears above the note field.')
                ->end()
                ->scalarNode('no_shipping')
                    ->info('Do not prompt buyers for a shipping address.')
                ->end()
                ->scalarNode('return')
                    ->info('The URL to which PayPal redirects buyers browser after they complete their payments.')
                ->end()
                ->scalarNode('rm')
                    ->validate()
                        ->ifNotInArray(array(0, 1, 2))
                        ->thenInvalid('Invalid type %s')
                    ->end()
                    ->info('Return method. The FORM METHOD used to send data to the URL specified by the return variable.')
                ->end()
                ->scalarNode('cbt')
                    ->info('Sets the text for the Return to Merchant button on the PayPal Payment Complete page. ')
                ->end()
                ->scalarNode('cancel_return')
                    ->info('A URL to which PayPal redirects the buyers browsers if they cancel checkout before completing their payments.')
                ->end()
                ->scalarNode('charset')
                    ->defaultValue('UTF-8')
                    ->info('Sets the character set and character encoding for the billing information/log-in page on the PayPal website.')
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
