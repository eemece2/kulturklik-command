<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Event
 *
 * @ORM\Table(name="event")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\EventRepository")
 */
class Event
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="documentname", type="string", length=255)
     */
    private $documentname;

    /**
     * @var string
     *
     * @ORM\Column(name="documentdescription", type="string", length=255)
     */
    private $documentdescription;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="eventenddate", type="date")
     */
    private $eventenddate;

    /**
     * @var bool
     *
     * @ORM\Column(name="eventonline", type="boolean")
     */
    private $eventonline;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="eventregistrationenddate", type="date")
     */
    private $eventregistrationenddate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="eventregistrationstartdate", type="date")
     */
    private $eventregistrationstartdate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="eventstartdate", type="date")
     */
    private $eventstartdate;

    /**
     * @var string
     *
     * @ORM\Column(name="eventtype", type="string", length=255)
     */
    private $eventtype;

    /**
     * @var string
     *
     * @ORM\Column(name="friendlyurl", type="string", length=255)
     */
    private $friendlyurl;

    /**
     * @var string
     *
     * @ORM\Column(name="physicalurl", type="string", length=255)
     */
    private $physicalurl;

    /**
     * @var string
     *
     * @ORM\Column(name="dataxml", type="string", length=255)
     */
    private $dataxml;

    /**
     * @var string
     *
     * @ORM\Column(name="metadataxml", type="string", length=255)
     */
    private $metadataxml;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set documentname
     *
     * @param string $documentname
     *
     * @return Event
     */
    public function setDocumentname($documentname)
    {
        $this->documentname = $documentname;

        return $this;
    }

    /**
     * Get documentname
     *
     * @return string
     */
    public function getDocumentname()
    {
        return $this->documentname;
    }

    /**
     * Set documentdescription
     *
     * @param string $documentdescription
     *
     * @return Event
     */
    public function setDocumentdescription($documentdescription)
    {
        $this->documentdescription = $documentdescription;

        return $this;
    }

    /**
     * Get documentdescription
     *
     * @return string
     */
    public function getDocumentdescription()
    {
        return $this->documentdescription;
    }

    /**
     * Set eventenddate
     *
     * @param \DateTime $eventenddate
     *
     * @return Event
     */
    public function setEventenddate($eventenddate)
    {
        $this->eventenddate = $eventenddate;

        return $this;
    }

    /**
     * Get eventenddate
     *
     * @return \DateTime
     */
    public function getEventenddate()
    {
        return $this->eventenddate;
    }

    /**
     * Set eventonline
     *
     * @param boolean $eventonline
     *
     * @return Event
     */
    public function setEventonline($eventonline)
    {
        $this->eventonline = $eventonline;

        return $this;
    }

    /**
     * Get eventonline
     *
     * @return bool
     */
    public function getEventonline()
    {
        return $this->eventonline;
    }

    /**
     * Set eventregistrationenddate
     *
     * @param \DateTime $eventregistrationenddate
     *
     * @return Event
     */
    public function setEventregistrationenddate($eventregistrationenddate)
    {
        $this->eventregistrationenddate = $eventregistrationenddate;

        return $this;
    }

    /**
     * Get eventregistrationenddate
     *
     * @return \DateTime
     */
    public function getEventregistrationenddate()
    {
        return $this->eventregistrationenddate;
    }

    /**
     * Set eventregistrationstartdate
     *
     * @param \DateTime $eventregistrationstartdate
     *
     * @return Event
     */
    public function setEventregistrationstartdate($eventregistrationstartdate)
    {
        $this->eventregistrationstartdate = $eventregistrationstartdate;

        return $this;
    }

    /**
     * Get eventregistrationstartdate
     *
     * @return \DateTime
     */
    public function getEventregistrationstartdate()
    {
        return $this->eventregistrationstartdate;
    }

    /**
     * Set eventstartdate
     *
     * @param \DateTime $eventstartdate
     *
     * @return Event
     */
    public function setEventstartdate($eventstartdate)
    {
        $this->eventstartdate = $eventstartdate;

        return $this;
    }

    /**
     * Get eventstartdate
     *
     * @return \DateTime
     */
    public function getEventstartdate()
    {
        return $this->eventstartdate;
    }

    /**
     * Set eventtype
     *
     * @param string $eventtype
     *
     * @return Event
     */
    public function setEventtype($eventtype)
    {
        $this->eventtype = $eventtype;

        return $this;
    }

    /**
     * Get eventtype
     *
     * @return string
     */
    public function getEventtype()
    {
        return $this->eventtype;
    }

    /**
     * Set friendlyurl
     *
     * @param string $friendlyurl
     *
     * @return Event
     */
    public function setFriendlyurl($friendlyurl)
    {
        $this->friendlyurl = $friendlyurl;

        return $this;
    }

    /**
     * Get friendlyurl
     *
     * @return string
     */
    public function getFriendlyurl()
    {
        return $this->friendlyurl;
    }

    /**
     * Set physicalurl
     *
     * @param string $physicalurl
     *
     * @return Event
     */
    public function setPhysicalurl($physicalurl)
    {
        $this->physicalurl = $physicalurl;

        return $this;
    }

    /**
     * Get physicalurl
     *
     * @return string
     */
    public function getPhysicalurl()
    {
        return $this->physicalurl;
    }

    /**
     * Set dataxml
     *
     * @param string $dataxml
     *
     * @return Event
     */
    public function setDataxml($dataxml)
    {
        $this->dataxml = $dataxml;

        return $this;
    }

    /**
     * Get dataxml
     *
     * @return string
     */
    public function getDataxml()
    {
        return $this->dataxml;
    }

    /**
     * Set metadataxml
     *
     * @param string $metadataxml
     *
     * @return Event
     */
    public function setMetadataxml($metadataxml)
    {
        $this->metadataxml = $metadataxml;

        return $this;
    }

    /**
     * Get metadataxml
     *
     * @return string
     */
    public function getMetadataxml()
    {
        return $this->metadataxml;
    }
}

