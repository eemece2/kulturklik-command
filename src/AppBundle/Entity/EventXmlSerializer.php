<?php

namespace AppBundle\Entity;

class EventXmlSerializer {

    protected $dateTextFormat = 'd/m/Y';
    protected $booleanTextOptions = array(
        'No' => false,
        'Sí' => true
    );

    public function deserialize($eventElement)
    {
        $documentname = $eventElement->getElementsByTagName('documentname')->item(0)->textContent;
        $documentdescription = $eventElement->getElementsByTagName('documentdescription')->item(0)->textContent;
        $eventenddate = $this->deserializeDate($eventElement->getElementsByTagName('eventenddate')->item(0)->textContent);
        $eventonline = $this->deserializeBoolean($eventElement->getElementsByTagName('eventonline')->item(0)->textContent);

        $e = new Event();
        $e->setDocumentname($documentname);
        $e->setDocumentdescription($documentdescription);
        $e->setEventenddate($eventenddate);
        $e->setEventonline($eventonline);
        $e->setEventregistrationenddate(new \DateTime());
        $e->setEventregistrationstartdate(new \DateTime());
        $e->setEventstartdate(new \DateTime());
        $e->setEventtype('prueba');
        $e->setFriendlyurl('prueba');
        $e->setPhysicalurl('prueba');
        $e->setDataxml('prueba');
        $e->setMetadataxml('prueba');

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
