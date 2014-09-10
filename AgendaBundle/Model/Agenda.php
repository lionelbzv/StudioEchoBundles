<?php
namespace StudioEchoBundles\AgendaBundle\Model;

use StudioEchoBundles\AgendaBundle\Model\AgendaMonth;
use StudioEchoBundles\AgendaBundle\Model\AgendaEventInterface;

/**
 * Modélisation d'un agenda
 *
 * @author Studio Echo / Lionel Bouzonville
 */
class Agenda {
    
    private $logger;

    /*
	   * Structure du tableau de retour:
	   * [YYYY-MM] => AgendaMonth
	   * [YYYY-MM] => ...
	   * ...
	   * [YYYY-MM] => ...
	*/
    private $months;

    public function __construct($logger =  null) {
        $this->logger = $logger;
    }

    public function getMonths() {
    	return $this->months;
    }

	  /**
	   *Initialise l'agenda
	   * 
	   */
	public function init($day = 1, $month = 1, $year = 2013, $nbPrevMonth = 6, $nbNextMonth = 6) {
	    // if ($this->logger) $this->logger->info('*** init');
	    // if ($this->logger) $this->logger->info('$day = '.print_r($day, true));
	    // if ($this->logger) $this->logger->info('$month = '.print_r($month, true));
	    // if ($this->logger) $this->logger->info('$year = '.print_r($year, true));
	    
	    $this->months = array();
	    
	    // init agenda avec les X mois précédents le mois courant
	    for ($i = $nbPrevMonth; $i > 0; $i--) {
			$prevMonth = $month - $i;
			$prevYear = $year;
			if ($prevMonth <= 0) {
				$prevMonth += 12;
				$prevYear--;
			}

			$agendaMonth = new AgendaMonth($prevMonth, $prevYear);
	      	$this->months[$prevYear . '-' . sprintf("%02s", $prevMonth)] = $agendaMonth;
	    }
	    
	    // init agenda avec le mois courant
		$agendaMonth = new AgendaMonth($month, $year);
      	$this->months[$year . '-' . sprintf("%02s", $month)] = $agendaMonth;

      	// if ($this->logger) $this->logger->info('$agendaMonth = '.print_r($agendaMonth, true));
	    
	    // init agenda avec les X mois suivants le mois courant
	    for ($i = 1; $i <= $nbNextMonth; $i++) {
			$nextMonth = $month + $i;
			$nextYear = $year;
			if ($nextMonth >= 13) {
				$nextMonth -= 12;
				$nextYear++;
			}

			$agendaMonth = new AgendaMonth($nextMonth, $nextYear);
	      	$this->months[$nextYear . '-' . sprintf("%02s", $nextMonth)] = $agendaMonth;
	    }
	    
	    return $this->months;
	}
	  

	/**
	 *	Remplit l'agenda avec les évènements passés en argument.
	 *
	 * 	@param $events 	Liste d'objets implémentant AgendaEventInterface
	 */
	public function fill($events) {
	    if ($this->logger) $this->logger->info('*** fill');
	    // if ($this->logger) $this->logger->info('$agenda = '.print_r($agenda, true));
	    // if ($this->logger) $this->logger->info('$events = '.print_r($events, true));

	    foreach ($events as $event) {
	    	if (! $event instanceof AgendaEventInterface) throw new \Exception('Event object has to implement AgendaEventInterface.');

	    	$beginAt = $event->getAgendaBeginAt();
	    	$endAt = $event->getAgendaEndAt();

	    	$this->addEvent($event, $beginAt);

	    	if ($endAt > $beginAt) {
	    		$rangeAt = $beginAt;

	    		while ($rangeAt < $endAt) {
	    			$rangeAt->modify('+1 day');
	    			$this->addEvent($event, $rangeAt);
	    		}
	    	}
	    }

	}

	/**
	 *
	 */
	public function getAgendaMonth($key) {
		if (isset($this->months[$key])) {
			return $this->months[$key];
		}
	}

	public function addEvent($event, $date) {
    	if ($agendaMonth = $this->getAgendaMonth($date->format('Y-m'))) {
    		if ($agendaDay = $agendaMonth->getAgendaDay($date->format('j'))) {
    			$agendaDay->addEvent($event);
    		}
    	}
	}
}
