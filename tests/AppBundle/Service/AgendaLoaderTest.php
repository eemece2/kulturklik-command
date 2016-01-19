<?php

namespace Tests\AppBundle\Service;

use AppBundle\Service\AgendaLoader;

class AgendaLoaderTest extends \PHPUnit_Framework_TestCase
{
    protected $demoAgendaPath;
    protected $demoAgendaLength;

    protected function setUp()
    {
        $this->demoAgendaPath = dirname(__FILE__) . '/../demoAgenda.xml';
        $this->demoAgendaLength = 2;
    }


    /**
     * @expectedException Exception
     * @expectedExceptionMessage DOMDocument load error
     */
    public function testNonExistentLoad()
    {
        $agendaLoader = new AgendaLoader();

        $agendaLoader->load('not_exist.xml');
    }

    // Test demo load
    public function testDemoLoad()
    {
        $agendaLoader = new AgendaLoader();

        $eventsNumber = $agendaLoader->load($this->demoAgendaPath);

        $this->assertEquals($eventsNumber, $this->demoAgendaLength);
    }
}
