<?php

namespace Tests\AppBundle\Entity;

use \DOMDocument;
use \DOMXPath;
use \DateTime;
use AppBundle\Entity\Event;
use AppBundle\Entity\EventXmlSerializer;

class EventXmlSerializerTest extends \PHPUnit_Framework_TestCase
{
    public function testDeserializeDate()
    {
        $serializer = new EventXmlSerializer();
        $deserializedDate = $serializer->deserializeDate('27/12/2016');
        $date = new DateTime('2016-12-27 0:0:0');
    }

    public function testDeserializeBoolean()
    {
        $serializer = new EventXmlSerializer();
        $deserializedBoolean = $serializer->deserializeBoolean('Sí');
        $this->assertTrue($deserializedBoolean);
    }

    public function testDeserialize()
    {
        $event = $this->createDemoEvent();

        $serializer = new EventXmlSerializer();
        $eventXmlElement =  $this->getDemoEventElement();
        $eventFromXml = $serializer->deserialize($eventXmlElement);

        $this->assertEquals($event->getDocumentname(), $eventFromXml->getDocumentname());
        $this->assertEquals($event->getDocumentdescription(), $eventFromXml->getDocumentdescription());
        $this->assertEquals($event->getEventenddate(), $eventFromXml->getEventenddate());
        $this->assertEquals((bool)$event->getEventonline(), (bool)$eventFromXml->getEventonline());
    }

    protected function createDemoEvent()
    {
        $event = new Event();
        $event->setDocumentname('Demo event');
        $event->setDocumentdescription('');
        $event->setEventenddate(new \DateTime('2016-12-27'));
        $event->setEventonline(true);
        $event->setEventregistrationenddate(new \DateTime('2015-11-25'));
        $event->setEventregistrationstartdate(new \DateTime('2015-11-24'));
        $event->setEventstartdate(new \DateTime('2016-12-27'));
        $event->setEventtype('012');
        $event->setFriendlyurl('http://opendata.euskadi.eus/catalogo/-/evento/20151117142228/-faboo-/kulturklik/es/');
        $event->setPhysicalurl('http://opendata.euskadi.eus/catalogo/-/contenidos/evento/20151117142228/es_def/index.shtml');
        $event->setDataxml('http://opendata.euskadi.eus/contenidos/evento/20151117142228/es_def/data/es_r01dtpd151159c5ffe1a48b14ba55eb3c450a81360');
        $event->setMetadataxml('http://opendata.euskadi.eus/contenidos/evento/20151117142228/r01Index/20151117142228-idxContent.xml');

        return $event;
    }

    protected function getDemoEventElement()
    {
        $path = dirname(__FILE__) . '/../demoAgenda.xml';
        $doc = new DOMDocument();
        if(@$doc->load($path) === false) {
            throw new \Exception('DOMDocument load error');
        }
        $domXPath = new DOMXPath($doc);
        $eventElement = $domXPath->query('//row')->item(0);

        return $eventElement;
    }
}
