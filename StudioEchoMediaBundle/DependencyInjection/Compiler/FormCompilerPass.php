<?php

namespace Avocode\FormExtensionsBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;

/**
 * TODO: chargement dynamique ne marche pas
 * Nécessite toujours la config au niveau config.yml:
 *
 *        twig 
 *            form:
 *                resources:
 *                    - 'StudioEchoMediaBundle:Form:fields.html.twig'
 *
 *
 * @author Lionel Bouzonville / Studio Echo
 */
class FormCompilerPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        $resources = $container->getParameter('twig.form.resources');
        $alreadyImported = in_array('StudioEchoMediaBundle:Form:fields.html.twig', $resources);

        if (!$alreadyImported) {
            // Insert right after form_div_layout.html.twig if exists
            // if (($key = array_search('form_div_layout.html.twig', $resources)) !== false) {
            //     array_splice($resources, ++$key, 0, array(
            //         'StudioEchoMediaBundle:Form:fields.html.twig',
            //     ));
            // } else {
                // Put it in first position
                array_unshift($resources, array(
                    'StudioEchoMediaBundle:Form:fields.html.twig',
                ));
            // }

            $container->setParameter('twig.form.resources', $resources);
        }
    }
}
