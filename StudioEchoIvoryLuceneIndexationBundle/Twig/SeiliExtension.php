<?php
// src/Acme/DemoBundle/Twig/AcmeExtension.php
namespace StudioEcho\StudioEchoIvoryLuceneIndexationBundle\Twig;

class SeiliExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return array(
            'highlight' => new \Twig_Filter_Method($this, 'highlightFilter'),
        );
    }

    public function highlightFilter($input, $queryStr, $bgcolor = '#FFFF00')
    {
        $output = $input;

        // $queryStrArray = explode(' ', $queryStr);
        // foreach($queryStrArray as $queryStr) {
        //     $output = $this->highlightKeyword($output, $queryStr, $bgcolor);
        // }

        $output = $this->highlightKeyword($output, $queryStr, $bgcolor);
        
        return $output;
    }

    public function getName()
    {
        return 'seili_extension';
    }

    private function highlightKeyword($haystack, $needle, $bgcolor = '#FFFF00')
    {
        return preg_replace("/($needle)/i", sprintf('<span style="background-color: %s">$1</span>', $bgcolor), $haystack);
    }

}