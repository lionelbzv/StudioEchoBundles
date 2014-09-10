<?php

namespace StudioEchoBundles\MediaBundle\Model;

use StudioEchoBundles\MediaBundle\Model\om\BaseSeMediaFile;

class SeMediaFile extends BaseSeMediaFile
{
    public function __toString() {
        $this->setLocale('fr');
        return $this->getName();
    }
    
    public function isLandscape() {
        if ($this->width >= $this->height) {
            return true;
        }
        
        return false;
    }
    
    public function isPortrait() {
        if ($this->height >= $this->width) {
            return true;
        }
        
        return false;
    }
}