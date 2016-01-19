<?php

namespace AppBundle\Service;

use \DOMDocument;
use \DOMXPath;

use AppBundle\Entity\Event;
use AppBundle\Entity\EventXmlSerializer;


class AgendaLoader {
    protected $em;

    public function __construct() {
    }

    public function load($url, $em) {
        $this->em = $em;

        $doc = new DOMDocument();
        if(@$doc->load($url) === false) {
            throw new \Exception('DOMDocument load error');
        }

        $domXPath = new DOMXPath($doc);
        $eventElements = $domXPath->query('//row');
        foreach($eventElements as $eventElement) {
            $this->loadEvent($eventElement);
        }

        $this->em->flush();

        return $eventElements->length;
    }

    protected function loadEvent($eventElement)
    {
        $event = $this->deserializeEvent($eventElement);
        $this->persistEvent($event);
    }

    protected function deserializeEvent($eventElement)
    {
        $serializer = new EventXmlSerializer();

        return $serializer->deserialize($eventElement);
    }

    protected function persistEvent($event)
    {
        $this->em->persist($event);
    }
}
