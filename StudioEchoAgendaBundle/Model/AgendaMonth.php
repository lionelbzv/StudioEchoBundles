<?php
namespace StudioEcho\StudioEchoAgendaBundle\Model;

use StudioEcho\StudioEchoAgendaBundle\Model\AgendaDay;
/**
 * Modélisation d'un jour de l'agenda
 *
 * @author Studio Echo / Lionel Bouzonville
 */
class AgendaMonth {

	// DateTime object
	public $current;	// mois courant format DateTime

	// libellés
	public $monthNum;	// numéro du mois dans l'année
	public $daysNumber; // nombre de jours dans le mois: 28|29|30|31

	// Objets jours
	public $days;		// tableau d'objets AgendaDay composant le mois

	/**
	 *	Constructeur
	 *
	 *	@month 	Numéro du mois
	 *  @year   Année
	 */
	public function __construct($month, $year) {
		$this->current = \DateTime::createFromFormat('!Y-n', $year . '-' . $month);
    	$this->monthNum = $month;
    	$this->daysNumber = cal_days_in_month(CAL_GREGORIAN, $month, $year);

    	$this->days[] = array();
    	for($i = 1; $i <= $this->daysNumber; $i++) {
    		$agendaDay = new AgendaDay($i, $month, $year);

    		$this->days[$i] = $agendaDay;
    	}
    	unset($this->days[0]);
	}

	/**
	 *
	 */
	public function getAgendaDay($key) {
		if (isset($this->days[$key])) {
			return $this->days[$key];
		}
	}
}