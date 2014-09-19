<?php

// src/Acme/DemoBundle/Form/Type/GenderType.php
namespace StudioEchoBundles\StudioEchoMediaBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormBuilderInterface;

/**
 *
 */
class StudioEchoMediaType extends AbstractType
{
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'object_name' => 'My\\Model\\Object',
            'object_id' => null,
            'media_key' => 'object_example_images',
            'culture' => 'fr',
        ));
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['object_name'] = $options['object_name'];
        $view->vars['object_id'] = $options['object_id'];
        $view->vars['media_key'] = $options['media_key'];
        $view->vars['culture'] = $options['culture'];
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->setAttribute('object_name', $options['object_name'])
            ->setAttribute('object_id', $options['object_id'])
            ->setAttribute('media_key', $options['media_key'])
            ->setAttribute('culture', $options['culture'])
        ;
    }

    public function getName()
    {
        return 'studio_echo_media';
    }
}
