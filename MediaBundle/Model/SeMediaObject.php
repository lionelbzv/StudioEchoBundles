<?php

namespace StudioEchoBundles\MediaBundle\Model;

use StudioEchoBundles\MediaBundle\Model\om\BaseSeMediaObject;

use StudioEchoBundles\MediaBundle\Model\SeMediaObjectQuery;
use StudioEchoBundles\MediaBundle\Model\SeMediaFileQuery;

use StudioEchoBundles\MediaBundle\Model\SeMediaFile;

class SeMediaObject extends BaseSeMediaObject
{
  
  /**
   * Return associated collection of media files
   * 
   * @return collection of StudioEchoBundles\MediaBundle\Model\SeMediaFile
   */
  public function getSortedSeMediaFiles($locale = 'fr', $category_id = 1) {
    return SeMediaFileQuery::create()
            ->joinWithI18n($locale)
            ->filterByCategoryId($category_id)
            ->useSeObjectHasFileQuery()
                ->filterBySeMediaObjectId($this->getId())
            ->orderByRank()
            ->endUse()
            ->find();
  }
}
