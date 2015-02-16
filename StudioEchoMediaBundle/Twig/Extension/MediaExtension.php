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
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return array(
            'seMediaGetName' => new \Twig_Function_Method($this, 'seMediaGetName'),
            'seMediaGetList' => new \Twig_Function_Method($this, 'seMediaGetList'),
            'seMediaGetFileNames' => new \Twig_Function_Method($this, 'seMediaGetFileNames')
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
        foreach($seMediaList as $media) {
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