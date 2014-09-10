<?php

namespace StudioEchoBundles\StudioEchoMediaBundle\Model;

use StudioEchoBundles\StudioEchoMediaBundle\Model\om\BaseSeMediaObject;

use StudioEchoBundles\StudioEchoMediaBundle\Model\SeMediaObjectQuery;
use StudioEchoBundles\StudioEchoMediaBundle\Model\SeMediaFileQuery;

use StudioEchoBundles\StudioEchoMediaBundle\Model\SeMediaFile;

class SeMediaObject extends BaseSeMediaObject
{
  
  /**
   * Return associated collection of media files
   * 
   * @return collection of StudioEchoBundles\StudioEchoMediaBundle\Model\SeMediaFile
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
