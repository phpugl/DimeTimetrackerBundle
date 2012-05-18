<?php

namespace Dime\TimetrackerBundle\Tests\Controller;

class ParsersControllerTest extends DimeTestCase
{
    public function testProcess()
    {
        $response = $this->request('POST', '/api/process', '10:00-12:00 @cc/CWE2011:testing new magic oneline input');

        $this->assertEquals(200, $response->getStatusCode(), $response->getContent());
    }
}