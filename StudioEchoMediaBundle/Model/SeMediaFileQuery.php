<?php

namespace StudioEchoBundles\StudioEchoMediaBundle\Model;

use StudioEchoBundles\StudioEchoMediaBundle\Model\om\BaseSeMediaFileQuery;

class SeMediaFileQuery extends BaseSeMediaFileQuery
{

	/**
	 *	Filtre online par locale
	 */
	public function filterByOnline($locale) {
		return  $this->useSeMediaFileI18nQuery()
                    ->filterByOnline(true)
                ->endUse();
	}
}
