<?php
namespace StudioEcho\Lib;
/**
 * Description of StudioEchoUtils
 *
 * @author Studio Echo / Lionel Bouzonville
 */
class StudioEchoUtils {

	/**
	 *	Transforme les lettres avec accents vers la lettre sans accents.
	 *
	 *	@param $txt
 	 */
	public static function transliterateString($txt) {
	$transliterationTable = array('á' => 'a', 'Á' => 'A', 'à' => 'a', 'À' => 'A', 'ă' => 'a', 'Ă' => 'A', 'â' => 'a', 'Â' => 'A', 'å' => 'a', 'Å' => 'A', 'ã' => 'a', 'Ã' => 'A', 'ą' => 'a', 'Ą' => 'A', 'ā' => 'a', 'Ā' => 'A', 'ä' => 'ae', 'Ä' => 'AE', 'æ' => 'ae', 'Æ' => 'AE', 'ḃ' => 'b', 'Ḃ' => 'B', 'ć' => 'c', 'Ć' => 'C', 'ĉ' => 'c', 'Ĉ' => 'C', 'č' => 'c', 'Č' => 'C', 'ċ' => 'c', 'Ċ' => 'C', 'ç' => 'c', 'Ç' => 'C', 'ď' => 'd', 'Ď' => 'D', 'ḋ' => 'd', 'Ḋ' => 'D', 'đ' => 'd', 'Đ' => 'D', 'ð' => 'dh', 'Ð' => 'Dh', 'é' => 'e', 'É' => 'E', 'è' => 'e', 'È' => 'E', 'ĕ' => 'e', 'Ĕ' => 'E', 'ê' => 'e', 'Ê' => 'E', 'ě' => 'e', 'Ě' => 'E', 'ë' => 'e', 'Ë' => 'E', 'ė' => 'e', 'Ė' => 'E', 'ę' => 'e', 'Ę' => 'E', 'ē' => 'e', 'Ē' => 'E', 'ḟ' => 'f', 'Ḟ' => 'F', 'ƒ' => 'f', 'Ƒ' => 'F', 'ğ' => 'g', 'Ğ' => 'G', 'ĝ' => 'g', 'Ĝ' => 'G', 'ġ' => 'g', 'Ġ' => 'G', 'ģ' => 'g', 'Ģ' => 'G', 'ĥ' => 'h', 'Ĥ' => 'H', 'ħ' => 'h', 'Ħ' => 'H', 'í' => 'i', 'Í' => 'I', 'ì' => 'i', 'Ì' => 'I', 'î' => 'i', 'Î' => 'I', 'ï' => 'i', 'Ï' => 'I', 'ĩ' => 'i', 'Ĩ' => 'I', 'į' => 'i', 'Į' => 'I', 'ī' => 'i', 'Ī' => 'I', 'ĵ' => 'j', 'Ĵ' => 'J', 'ķ' => 'k', 'Ķ' => 'K', 'ĺ' => 'l', 'Ĺ' => 'L', 'ľ' => 'l', 'Ľ' => 'L', 'ļ' => 'l', 'Ļ' => 'L', 'ł' => 'l', 'Ł' => 'L', 'ṁ' => 'm', 'Ṁ' => 'M', 'ń' => 'n', 'Ń' => 'N', 'ň' => 'n', 'Ň' => 'N', 'ñ' => 'n', 'Ñ' => 'N', 'ņ' => 'n', 'Ņ' => 'N', 'ó' => 'o', 'Ó' => 'O', 'ò' => 'o', 'Ò' => 'O', 'ô' => 'o', 'Ô' => 'O', 'ő' => 'o', 'Ő' => 'O', 'õ' => 'o', 'Õ' => 'O', 'ø' => 'oe', 'Ø' => 'OE', 'ō' => 'o', 'Ō' => 'O', 'ơ' => 'o', 'Ơ' => 'O', 'ö' => 'oe', 'Ö' => 'OE', 'ṗ' => 'p', 'Ṗ' => 'P', 'ŕ' => 'r', 'Ŕ' => 'R', 'ř' => 'r', 'Ř' => 'R', 'ŗ' => 'r', 'Ŗ' => 'R', 'ś' => 's', 'Ś' => 'S', 'ŝ' => 's', 'Ŝ' => 'S', 'š' => 's', 'Š' => 'S', 'ṡ' => 's', 'Ṡ' => 'S', 'ş' => 's', 'Ş' => 'S', 'ș' => 's', 'Ș' => 'S', 'ß' => 'SS', 'ť' => 't', 'Ť' => 'T', 'ṫ' => 't', 'Ṫ' => 'T', 'ţ' => 't', 'Ţ' => 'T', 'ț' => 't', 'Ț' => 'T', 'ŧ' => 't', 'Ŧ' => 'T', 'ú' => 'u', 'Ú' => 'U', 'ù' => 'u', 'Ù' => 'U', 'ŭ' => 'u', 'Ŭ' => 'U', 'û' => 'u', 'Û' => 'U', 'ů' => 'u', 'Ů' => 'U', 'ű' => 'u', 'Ű' => 'U', 'ũ' => 'u', 'Ũ' => 'U', 'ų' => 'u', 'Ų' => 'U', 'ū' => 'u', 'Ū' => 'U', 'ư' => 'u', 'Ư' => 'U', 'ü' => 'ue', 'Ü' => 'UE', 'ẃ' => 'w', 'Ẃ' => 'W', 'ẁ' => 'w', 'Ẁ' => 'W', 'ŵ' => 'w', 'Ŵ' => 'W', 'ẅ' => 'w', 'Ẅ' => 'W', 'ý' => 'y', 'Ý' => 'Y', 'ỳ' => 'y', 'Ỳ' => 'Y', 'ŷ' => 'y', 'Ŷ' => 'Y', 'ÿ' => 'y', 'Ÿ' => 'Y', 'ź' => 'z', 'Ź' => 'Z', 'ž' => 'z', 'Ž' => 'Z', 'ż' => 'z', 'Ż' => 'Z', 'þ' => 'th', 'Þ' => 'Th', 'µ' => 'u', 'а' => 'a', 'А' => 'a', 'б' => 'b', 'Б' => 'b', 'в' => 'v', 'В' => 'v', 'г' => 'g', 'Г' => 'g', 'д' => 'd', 'Д' => 'd', 'е' => 'e', 'Е' => 'e', 'ё' => 'e', 'Ё' => 'e', 'ж' => 'zh', 'Ж' => 'zh', 'з' => 'z', 'З' => 'z', 'и' => 'i', 'И' => 'i', 'й' => 'j', 'Й' => 'j', 'к' => 'k', 'К' => 'k', 'л' => 'l', 'Л' => 'l', 'м' => 'm', 'М' => 'm', 'н' => 'n', 'Н' => 'n', 'о' => 'o', 'О' => 'o', 'п' => 'p', 'П' => 'p', 'р' => 'r', 'Р' => 'r', 'с' => 's', 'С' => 's', 'т' => 't', 'Т' => 't', 'у' => 'u', 'У' => 'u', 'ф' => 'f', 'Ф' => 'f', 'х' => 'h', 'Х' => 'h', 'ц' => 'c', 'Ц' => 'c', 'ч' => 'ch', 'Ч' => 'ch', 'ш' => 'sh', 'Ш' => 'sh', 'щ' => 'sch', 'Щ' => 'sch', 'ъ' => '', 'Ъ' => '', 'ы' => 'y', 'Ы' => 'y', 'ь' => '', 'Ь' => '', 'э' => 'e', 'Э' => 'e', 'ю' => 'ju', 'Ю' => 'ju', 'я' => 'ja', 'Я' => 'ja');
	$txt = str_replace(array_keys($transliterationTable), array_values($transliterationTable), $txt);
	return $txt;
	} 

	/**
	 *	Génère une chaîne aléatoire
	 *
	 *	@param $length
 	 */
	public static function randomString($length = 6) {
		//$str = "";
		//$characters = array_merge(range('A','Z'), range('a','z'), range('0','9'));
		//$max = count($characters) - 1;
		//
		//for ($i = 0; $i < $length; $i++) {
		//	$rand = mt_rand(0, $max);
		//	$str .= $characters[$rand];
		//}

		$str = substr(str_shuffle(MD5(microtime())), 0, $length);

		return $str;
	}

	/**
	 *	Renvoit les identifiants des objets précédents et suivants à l'objet courant dans la PropelCollection fournie.
	 *
	 *	@param PropelCollection $collection
	 *	@param integer 			$currentId
	 */
	public static function prevNextIds($collection, $currentId) {
        // compute prev/next links
        $prevId = null;
        $nextId = null;
        $prevFound = false;

        foreach ($collection as $object) {
          if ($prevFound) {
            $nextId = $object->getId();
            break;
          }
          if ($object->getId() == $currentId) {
            $prevFound = true;
          }
          if (!$prevFound) {
            $prevId = $object->getId();
          }
        }
        if ($nextId == $currentId) {
          $nextId = null;
        }

        return array(0 => $prevId, 1 => $nextId);
	}

	  /**
	   * 
	   * Contenu: 5 mois précédent le mois courant, mois courant, 6 mois suivant le mois courant
	   * 
	   * Structure du tableau de retour:
	   * [YYYY-MM] => [
	   *    'month' => num du mois,
	   *    'year' => année,
	   *    'month_label' => nom du mois,
	   *    'div_id' => id du div / nom du mois,
	   *    'days_number' => 28/29/30/31,
	   *    'class_ul' => thirtydays / nombre du jour du mois,
	   *    'days' => [
	   *      1 (numéro du jour) => [
	   *          'events' => array(),
	   *          'current' => true/false
	   *      ]
	   *    ]
	   * [YYYY-MM] => ...
	   * ...
	   * [YYYY-MM] => ...
	   * 
	   * @return array
	   */
	public static function initAgenda($day = 1, $month = 1, $year = 2013) {
	//    sfContext::getInstance()->getLogger()->log('*** getHomepageAgenda');
	//    sfContext::getInstance()->getLogger()->log('$day = '.print_r($day, true));
	//    sfContext::getInstance()->getLogger()->log('$month = '.print_r($month, true));
	//    sfContext::getInstance()->getLogger()->log('$year = '.print_r($year, true));
	    
	    $agenda = array();
	    
	    // set 5 previous month
	    for ($i = 5; $i > 0; $i--) {
	      $prev_month = $month - $i;
	      $prev_year = $year;
	      if ($prev_month <= 0) {
	        $prev_month += 12;
	        $prev_year--;
	      }
	      
	      $days_number = cal_days_in_month(CAL_GREGORIAN, $prev_month, $prev_year);
	      $agenda[$prev_year . '-' . StudioEchoUtils::TwoDigits($prev_month)] = array(
	          'month' => $prev_month,
	          'year' => $prev_year,
	          'month_label' => StudioEchoUtils::getMonthLabelFromMonthNum($prev_month),
	          'div_id' => StudioEchoUtils::getDivIdFromMonthNum($prev_month),
	          'days_number' => $days_number,
	          'class_ul' => StudioEchoUtils::getClassUlFromDaysNumber($days_number),
	          'days' => StudioEchoUtils::initEventDaysArray($prev_month, $prev_year, $days_number, $day, $month, $year),
	      );
	    }
	    
	    // set current month
	    $days_number = cal_days_in_month(CAL_GREGORIAN, $month, $year);
	    $agenda[$year . '-' . StudioEchoUtils::TwoDigits($month)] = array(
	        'month' => $month,
	        'year' => $year,
	        'month_label' => StudioEchoUtils::getMonthLabelFromMonthNum($month),
	        'div_id' => StudioEchoUtils::getDivIdFromMonthNum($month),
	        'days_number' => $days_number,
	        'class_ul' => StudioEchoUtils::getClassUlFromDaysNumber($days_number),
	        'days' => StudioEchoUtils::initEventDaysArray($month, $year, $days_number, $day, $month, $year),
	    );
	    
	    // set 6 next month
	    for ($i = 1; $i <= 6; $i++) {
	      $next_month = $month + $i;
	      $next_year = $year;
	      if ($next_month >= 13) {
	        $next_month -= 12;
	        $next_year++;
	      }
	      $days_number = cal_days_in_month(CAL_GREGORIAN, $next_month, $next_year);
	      $agenda[$next_year . '-' . StudioEchoUtils::TwoDigits($next_month)] = array(
	          'month' => $next_month,
	          'year' => $next_year,
	          'month_label' => StudioEchoUtils::getMonthLabelFromMonthNum($next_month),
	          'div_id' => StudioEchoUtils::getDivIdFromMonthNum($next_month),
	          'days_number' => $days_number,
	          'class_ul' => StudioEchoUtils::getClassUlFromDaysNumber($days_number),
	          'days' => StudioEchoUtils::initEventDaysArray($next_month, $next_year, $days_number, $day, $month, $year),
	      );
	    }
	    
	    
	//    sfContext::getInstance()->getLogger()->log('$agenda = '.print_r($agenda, true));
	    
	    return $agenda;
	  }
	  
	  /**
	   * 
	   * @param type $month_num
	   */
	  public static function getDivIdFromMonthNum($month_num = 1) {
	    switch ($month_num) {
	      case 1: $div_id = 'janv'; break;
	      case 2: $div_id = 'fev'; break;
	      case 3: $div_id = 'mars'; break;
	      case 4: $div_id = 'avr'; break;
	      case 5: $div_id = 'mai'; break;
	      case 6: $div_id = 'juin'; break;
	      case 7: $div_id = 'juil'; break;
	      case 8: $div_id = 'aout'; break;
	      case 9: $div_id = 'sept'; break;
	      case 10: $div_id = 'oct'; break;
	      case 11: $div_id = 'nov'; break;
	      case 12: $div_id = 'dec'; break;
	    }
	    
	    return $div_id;
	  }
	  
	  /**
	   * 
	   * @param type $month_num
	   */
	  public static function getClassUlFromDaysNumber($days_number = 31) {
	    switch ($days_number) {
	      case 28: $class_ul = 'twentyeightdays'; break;
	      case 29: $class_ul = 'twentyninedays'; break;
	      case 30: $class_ul = 'thirtydays'; break;
	      case 31: $class_ul = 'thirtyonedays'; break;
	    }
	    
	    return $class_ul;
	  }
	  
	  /**
	   * Init days array of agenda.
	   * 
	   * @param type $init_month
	   * @param type $init_year
	   * @param type $days_month
	   * @param type $current_day
	   * @param type $current_month
	   * @param type $current_year
	   * @return boolean
	   */
	  public static function initEventDaysArray($init_month = 1, $init_year = 2013, $days_month = 31, $current_day = 1, $current_month = 1, $current_year = 2013) {
	    $event_days = array();
	    
	    $days_number = range(1, $days_month);
	    $days_number = array_fill(1, count($days_number), array(
	                'events' => array(), 
	                'current' => false
	                ));
	    
	    if ($init_month == $current_month && $init_year == $current_year) {
	      $days_number[$current_day]['current'] = true;
	    }
	    
	    return $days_number;
	  }
	  
	  /**
	   * Compute all key/dates between begin_at (or first date of agenda & end_at (or last date of agenda) for an event
	   * 
	   * @param type $event
	   * @param type $agenda_begin_key
	   * @param type $agenda_end_key
	   * @return null|array
	   */
	  public static function computeEventDates($event = null, $agenda_begin_key = '2013-01', $agenda_end_key = '2013-12') {
	//    sfContext::getInstance()->getLogger()->log('*** computeEventDates');
	//    sfContext::getInstance()->getLogger()->log('$agenda_begin_key = '.print_r($agenda_begin_key, true));
	//    sfContext::getInstance()->getLogger()->log('$agenda_end_key = '.print_r($agenda_end_key, true));
	    
	    if (!$event) {
	      return null;
	    } else {
	      $event_dates = array();
	      
	      // get begin/end date of event
	      $begin_at = $event->getBeginAt('Y-m');
	      $end_at = $event->getEndAt('Y-m');
	      $begin_day_at = $event->getBeginAt('d');
	      $end_day_at = $event->getEndAt('d');
	//      sfContext::getInstance()->getLogger()->log('$begin_at = '.print_r($begin_at, true));
	//      sfContext::getInstance()->getLogger()->log('$end_at = '.print_r($end_at, true));
	//      sfContext::getInstance()->getLogger()->log('$begin_day_at = '.print_r($begin_day_at, true));
	//      sfContext::getInstance()->getLogger()->log('$end_day_at = '.print_r($end_day_at, true));
	      
	      // adapt begin/end to the current calendar
	      if (strtotime($begin_at) < strtotime($agenda_begin_key)) {
	        $begin_ref = $agenda_begin_key.'-01';
	      } else {
	        $begin_ref = $begin_at.'-'.$begin_day_at;
	      }
	      if (strtotime($end_at) > strtotime($agenda_end_key)) {
	        $days_number = cal_days_in_month(CAL_GREGORIAN, substr($agenda_end_key, 5, 2), substr($agenda_end_key, 0, 4));
	        $end_ref = $agenda_end_key.'-'.$days_number;
	      } else {
	        $end_ref = $end_at.'-'.$end_day_at;
	      }
	//      sfContext::getInstance()->getLogger()->log('$begin_ref = '.print_r($begin_ref, true));
	//      sfContext::getInstance()->getLogger()->log('$end_ref = '.print_r($end_ref, true));
	      
	      // get all dates of event $agenda_key['month'] + $agenda_key['day']
	      $date_loop = $begin_ref;
	      while (strtotime($date_loop) <= strtotime($end_ref)) {
	        $event_date = array('agenda_month_key' => substr($date_loop, 0, 4) . '-' . substr($date_loop, 5, 2), 'day' => StudioEchoUtils::OneDigit(substr($date_loop, 8, 2)));
	        array_push($event_dates, $event_date);
	        $date_loop = date ("Y-m-d", strtotime("+1 day", strtotime($date_loop)));
	      }
	      
	//      sfContext::getInstance()->getLogger()->log('$event_dates = '.print_r($event_dates, true));
	      return $event_dates;
	    }
	  }
	  
	  /**
	   * Transform one digit month/day => two digits
	   * 
	   * @param type $value
	   * @return type
	   */
	  public static function TwoDigits($value = 1) {
	    if (strlen($value) == 1) {
	      return '0'.$value;
	    }
	    else return $value;
	  }
	  
	  /**
	   * Transform two digits month/day => one digit
	   * 
	   * @param type $month
	   * @return type
	   */
	  public static function OneDigit($value = 1) {
	    if (strlen($value) == 2 && substr($value, 0, 1) == '0') {
	      return substr($value, 1, 1);
	    }
	    else return $value;
	  }
	  
	/**
	* 
	* @param type $month_num
	*/
	public static function getMonthLabelFromMonthNum($month_num, $locale = 'fr') {
		if($locale == 'fr') {
		  switch ($month_num) {
		    case 1: $month_label = 'Janvier'; break;
		    case 2: $month_label = 'Février'; break;
		    case 3: $month_label = 'Mars'; break;
		    case 4: $month_label = 'Avril'; break;
		    case 5: $month_label = 'Mai'; break;
		    case 6: $month_label = 'Juin'; break;
		    case 7: $month_label = 'Juillet'; break;
		    case 8: $month_label = 'Août'; break;
		    case 9: $month_label = 'Septembre'; break;
		    case 10: $month_label = 'Octobre'; break;
		    case 11: $month_label = 'Novembre'; break;
		    case 12: $month_label = 'Décembre'; break;
		  }
		} elseif($locale == 'es') {
		  switch ($month_label) {
		    case 1: $month_label = 'Enero'; break;
		    case 2: $month_label = 'Febrero'; break;
		    case 3: $month_label = 'Marzo'; break;
		    case 4: $month_label = 'Abril'; break;
		    case 5: $month_label = 'Mayo'; break;
		    case 6: $month_label = 'Junio'; break;
		    case 7: $month_label = 'Julio'; break;
		    case 8: $month_label = 'Agosto'; break;
		    case 9: $month_label = 'Septiembre'; break;
		    case 10: $month_label = 'Octubre'; break;
		    case 11: $month_label = 'Noviembre'; break;
		    case 12: $month_label = 'Diciembre'; break;
		  }
		} elseif($locale = 'en') {
		  switch ($month_label) {
		    case 1: $month_label = 'January'; break;
		    case 2: $month_label = 'February'; break;
		    case 3: $month_label = 'March'; break;
		    case 4: $month_label = 'April'; break;
		    case 5: $month_label = 'May'; break;
		    case 6: $month_label = 'June'; break;
		    case 7: $month_label = 'July'; break;
		    case 8: $month_label = 'August'; break;
		    case 9: $month_label = 'September'; break;
		    case 10: $month_label = 'October'; break;
		    case 11: $month_label = 'November'; break;
		    case 12: $month_label = 'December'; break;
		  }
		}

		return $month_label;

	}


}
