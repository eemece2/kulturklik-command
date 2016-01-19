<?php

namespace AppBundle\Service;

use \DOMDocument;
use \DOMXPath;

class AgendaLoader {

    public function __construct() {
    }

    public function load($url) {

        $doc = new DOMDocument();
        if(@$doc->load($url) === false) {
            throw new \Exception('DOMDocument load error');
        }

        $domXPath = new DOMXPath($doc);
        $eventElements = $domXPath->query('//row');
        foreach($eventElements as $eventElement) {
            $this->loadEvent($eventElement);
        }

        return $eventElements->length;
    }

    protected function loadEvent($eventElement)
    {
    }
}
