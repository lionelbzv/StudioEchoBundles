<?php
namespace StudioEchoBundles\StudioEchoBundlesAgendaBundle\Twig\Extension;

class AgendaExtension extends \Twig_Extension
{
    private $logger;

    public function __construct($service_container) {
        $this->logger = $service_container->get('logger');
    }

    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('agendaMonthClass', array($this, 'agendaMonthClassFilter')),
            new \Twig_SimpleFilter('currentDayClass', array($this, 'currentDayClassFilter')),
        );
    }

    public function agendaMonthClassFilter($daysNumber)
    {
        // $this->logger->info('*** agendaMonthClassFilter');

        switch($daysNumber) {
            case 28: return 'twentyeightdays'; break;
            case 29: return 'twentyninedays'; break;
            case 30: return 'thirtydays'; break;
            case 31: return 'thirtyonedays'; break;
        }

        return 'thirtyonedays';
    }

    public function currentDayClassFilter($date)
    {
        // $this->logger->info('*** currentDayClassFilter');
        // $this->logger->info('$date = '.print_r($date, true));

        $today = new \DateTime('now');

        $today = $today->format('Y-m-d');
        $date = $date->format('Y-m-d');

        if ($today == $date)    return 'current_day';

        return '';
    }

    public function getName()
    {
        return 'agenda';
    }
}
