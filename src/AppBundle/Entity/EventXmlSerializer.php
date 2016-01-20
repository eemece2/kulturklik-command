<?php

namespace AppBundle\Entity;

use  \DOMNode;

class EventXmlSerializer {

    protected $dateTextFormat = 'd/m/Y';
    protected $booleanTextOptions = array(
        'No' => false,
        'Sí' => true
    );

    public function deserialize(DOMNode $eventElement)
    {
        $documentname = $eventElement->getElementsByTagName('documentname')->item(0)->textContent;
        $documentdescription = $eventElement->getElementsByTagName('documentdescription')->item(0)->textContent;
        $eventenddate = $this->deserializeDate($eventElement->getElementsByTagName('eventenddate')->item(0)->textContent);
        $eventonline = $this->deserializeBoolean($eventElement->getElementsByTagName('eventonline')->item(0)->textContent);
        $eventregistrationenddate = $this->deserializeDate($eventElement->getElementsByTagName('eventregistrationenddate')->item(0)->textContent);
        $eventregistrationstartdate = $this->deserializeDate($eventElement->getElementsByTagName('eventregistrationstartdate')->item(0)->textContent);
        $eventstartdate = $this->deserializeDate($eventElement->getElementsByTagName('eventstartdate')->item(0)->textContent);
        $eventtype = $eventElement->getElementsByTagName('eventtype')->item(0)->textContent;
        $friendlyurl = $eventElement->getElementsByTagName('friendlyurl')->item(0)->textContent;
        $physicalurl = $eventElement->getElementsByTagName('physicalurl')->item(0)->textContent;
        $dataxml = $eventElement->getElementsByTagName('dataxml')->item(0)->textContent;
        $metadataxml = $eventElement->getElementsByTagName('metadataxml')->item(0)->textContent;


        $e = new Event();
        $e->setDocumentname($documentname);
        $e->setDocumentdescription($documentdescription);
        $e->setEventenddate($eventenddate);
        $e->setEventonline($eventonline);
        $e->setEventregistrationenddate($eventregistrationenddate);
        $e->setEventregistrationstartdate($eventregistrationstartdate);
        $e->setEventstartdate($eventstartdate);
        $e->setEventtype($eventtype);
        $e->setFriendlyurl($friendlyurl);
        $e->setPhysicalurl($physicalurl);
        $e->setDataxml($dataxml);
        $e->setMetadataxml($metadataxml);

        return $e;
    }

    public function deserializeDate($dateText)
    {
        return \DateTime::createFromFormat('!d/m/Y', $dateText);
    }

    public function deserializeBoolean($booleanText)
    {
        return $this->booleanTextOptions[$booleanText];
    }
}
