<?php

namespace Dime\TimetrackerBundle\Tests\Controller;

class ParsersControllerTest extends DimeTestCase
{
    public function setUp()
    {
        $this->client = static::createClient();
    }

    public function testAuthentification()
    {
        $this->assertEquals(401, $this->request('GET', '/api/process', null, array(), array(), array())->getStatusCode());
        $this->assertEquals(200, $this->request('GET', '/api/process')->getStatusCode());
    }

    public function testProcess()
    {
        $response = $this->request('POST', '/api/process', '10:00-12:00 @cc/CWE2011:testing new magic oneline input');

        $this->assertEquals(200, $response->getStatusCode());
    }

}