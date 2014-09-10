<?php

namespace StudioEchoBundles\StudioEchoBundlesMediaBundle\Model;

use StudioEchoBundles\StudioEchoBundlesMediaBundle\Model\om\BaseSeMediaObject;

use StudioEchoBundles\StudioEchoBundlesMediaBundle\Model\SeMediaObjectQuery;
use StudioEchoBundles\StudioEchoBundlesMediaBundle\Model\SeMediaFileQuery;

use StudioEchoBundles\StudioEchoBundlesMediaBundle\Model\SeMediaFile;

class SeMediaObject extends BaseSeMediaObject
{
  
  /**
   * Return associated collection of media files
   * 
   * @return collection of StudioEchoBundles\StudioEchoBundlesMediaBundle\Model\SeMediaFile
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
