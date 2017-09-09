<?php
# Test/MyBundle/Twig/Extension/MyBundleExtension.php

namespace StudioEchoBundles\StudioEchoMediaBundle\Twig\Extension;

use Symfony\Component\HttpKernel\KernelInterface;

use StudioEchoBundles\StudioEchoMediaBundle\Lib\StudioEchoMediaManager;

class MediaExtension extends \Twig_Extension
{
    public function __construct()
    {
    }

    /**
     *  Renvoie la liste des fonctions
     */
    public function getFunctions()
    {
        return array(
            'seMediaGetName'  => new \Twig_SimpleFunction(
                'seMediaGetName',
                array($this, 'seMediaGetName'),
                array('is_safe' => array('html'), 'needs_environment' => true)
            ),
            'seMediaGetList'  => new \Twig_SimpleFunction(
                'seMediaGetList',
                array($this, 'seMediaGetList'),
                array('is_safe' => array('html'), 'needs_environment' => true)
            ),
            'seMediaGetFileNames'  => new \Twig_SimpleFunction(
                'seMediaGetFileNames',
                array($this, 'seMediaGetFileNames'),
                array('is_safe' => array('html'), 'needs_environment' => true)
            ),
        );
    }

    /**
     *
     */
    public function seMediaGetName($objectId = 1, $objectClassname = 'My\Object\Model', $locale = 'fr', $categoryId = 1, $rank = null)
    {
        $seMediaFile = StudioEchoMediaManager::getMedia($objectId, $objectClassname, $locale, $categoryId, $rank);
        
        if ($seMediaFile) {
            return $seMediaFile->getName();
        } else {
            return '';
        }
    }

    /**
     *
     */
    public function seMediaGetList($objectId = 1, $objectClassname = 'My\Object\Model', $locale = 'fr', $categoryId = 1)
    {
        $seMediaList = StudioEchoMediaManager::getMediaList($objectId, $objectClassname, $locale, $categoryId);
        
        return $seMediaList;
    }

    /**
     *
     */
    public function seMediaGetFileNames($objectId = 1, $objectClassname = 'My\Object\Model', $locale = 'fr', $categoryId = 1)
    {
        $seMediaList = StudioEchoMediaManager::getMediaList($objectId, $objectClassname, $locale, $categoryId);

        $fileNames = array();
        foreach ($seMediaList as $media) {
            $fileNames[] = $media->getName();
        }
        
        return $fileNames;
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'mediaextension';
    }
}
