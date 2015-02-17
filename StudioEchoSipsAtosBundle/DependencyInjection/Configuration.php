<?php

namespace StudioEchoBundles\StudioEchoSipsAtosBundle\DependencyInjection;

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
        $rootNode = $treeBuilder->root('studio_echo_sips_atos');

        $rootNode
            ->children()
                ->scalarNode('pathfile')
                    ->info('Chemin absolu du fichier pathfile.')
                    ->isRequired()
                ->end()
                ->scalarNode('bin_request')
                    ->info('Chemin absolu de l\'exécutable request.')
                    ->isRequired()
                ->end()
                ->scalarNode('bin_response')
                    ->info('Chemin absolu de l\'exécutable response.')
                    ->isRequired()
                ->end()
                ->scalarNode('merchant_id')
                    ->info('La valeur de ce champ est fournie au commerçant, lors de l’inscription de sa boutique. Il permet l’identification d’une boutique . Il correspond généralement au SIRET précédé de 0.')
                    ->isRequired()
                ->end()
                ->scalarNode('merchant_country')
                    ->info('Contient le code du pays du commerçant.')
                    ->isRequired()
                    ->defaultValue('fr')
                ->end()
                ->scalarNode('currency_code')
                    ->info('Contient le code de la devise de la transaction. Ce code est compatible ISO-IS 4217.')
                    ->isRequired()
                    ->defaultValue(978)
                ->end()
                ->scalarNode('normal_return_url')
                    ->info('Contient l’URL du commerçant pour le retour à la boutique en cas d’acceptation de la transaction.')
                    ->isRequired()
                ->end()
                ->scalarNode('cancel_return_url')
                    ->info('Contient l’URL du commerçant pour le retour à la boutique en cas d’annulation de la transaction de la part de l’internaute ou en cas de refus de la transaction.')
                    ->isRequired()
                ->end()
                ->scalarNode('automatic_response_url')
                    ->info('Contient l’URL du commerçant pour l’envoi de la réponse automatique, à la fin d’une transaction.')
                    ->isRequired()
                ->end()
                ->scalarNode('language')
                    ->info('Contient le code de la langue utilisée pour l’affichage des pages de paiement.')
                    ->isRequired()
                    ->defaultValue('fr')
                ->end()
                ->scalarNode('payment_means')
                    ->info('Dans la requête de paiement, contient la liste des moyens de paiement et le numéro des phrases de commentaires affichés par l’API en fonction du moyen de paiement. Dans la réponse, contient le moyen de paiement choisi par l’internaute pour la transaction.')
                    ->isRequired()
                    ->defaultValue('CB,2,VISA,2,MASTERCARD,2')
                ->end()
                ->scalarNode('header_flag')
                    ->validate()
                        ->ifNotInArray(array('yes', 'no'))
                        ->thenInvalid('Invalid type %s')
                    ->end()
                    ->info('Ce champ indique si l’API doit afficher ou non une phrase de commentaire au-dessus des logos de moyens de paiement. Deux valeurs sont acceptées : yes ou no.')
                    ->defaultValue('yes')
                ->end()
                ->scalarNode('bgcolor')
                    ->info('Contient le code couleur RGB commençant par # du fond d’écran des pages de paiement.')
                    ->defaultValue('#ffffff')
                ->end()
                ->scalarNode('block_align')
                    ->validate()
                        ->ifNotInArray(array('left', 'center', 'right'))
                        ->thenInvalid('Invalid type %s')
                    ->end()
                    ->info('Contient la valeur left, center ou right. Ce champ précise la position de la phrase de commentaire précédant les logos des moyens de paiement et la position des logos des moyens de paiement affichés par l’API. Par défaut, ce champ est initialisé à center.')
                    ->defaultValue('center')
                ->end()
                ->scalarNode('block_order')
                    ->info('Contient l’ordre d’affichage des blocs de paiement (logo(s) et phrase de commentaire associée) affichés par l’API. Par défaut, ce champ est initialisé à 1,2,3,4,5,6,7,8,9.')
                    ->defaultValue('1,2,3,4,5,6,7,8')
                ->end()
                ->scalarNode('textcolor')
                    ->info('Contient le code couleur RGB commençant par # du texte affiché sur les pages de paiement. Si ce champ n’est pas renseigné, le texte sera affiché en noir.')
                    ->defaultValue('#000000')
                ->end()
                ->scalarNode('logo_id')
                    ->info('Contient le nom du fichier du logo de la boutique affiché en haut à gauche des pages de paiement.')
                ->end()
                ->scalarNode('logo_id2')
                    ->info('Contient le nom du fichier du logo de la boutique affiché en haut à droite des pages de paiement.')
                ->end()
                ->scalarNode('advert')
                    ->info('Contient le nom de fichier d’une bannière affichée au centre en haut des pages de paiement.')
                ->end()
                ->scalarNode('background_id')
                    ->info('Contient le nom de l’image en fond d’écran des pages de paiement.')
                ->end()
                ->scalarNode('templatefile')
                    ->info('Contient le nom de fichier du template (feuille de style) utilisé pour la personnalisation des pages de paiement.')
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
