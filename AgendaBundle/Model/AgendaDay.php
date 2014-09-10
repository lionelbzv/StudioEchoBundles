<?php
namespace StudioEchoBundles\AgendaBundle\Model;

use StudioEchoBundles\AgendaBundle\Model\AgendaEventInterface;

/**
 * Modélisation d'un jour de l'agenda
 *
 * @author Studio Echo / Lionel Bouzonville
 */
class AgendaDay {

	// DateTime object
	public $current;

	// Objets events
	public $events;		// tableau d'objets AgendaEvents associé au jour

	/**
	 *	Constructeur
	 *
	 */
	public function __construct($day, $month, $year) {
		$this->current = \DateTime::createFromFormat('!Y-n-j', $year . '-' . $month . '-' . $day);
		$this->events = array();
	}

	/**
	 *
	 */
	public function addEvent(AgendaEventInterface $event) {
		$this->events[] = $event;
	}

}