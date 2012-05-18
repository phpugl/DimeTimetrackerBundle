<?php

namespace Dime\TimetrackerBundle\Tests\Controller;

class ParsersControllerTest extends DimeTestCase
{
    public function testProcess()
    {
        $response = $this->request('POST', '/api/process', '10:00-12:00 @cc/CWE2011:testing new magic oneline input');
        $this->assertEquals(200, $response->getStatusCode(), $response->getContent());
        $content = json_decode($response->getContent(), true);

        $this->assertEquals($content['description'], 'new magic oneline input');
        $this->assertEquals($content['customer']['alias'], 'CC');
        $this->assertEquals($content['project']['name'], 'CWE2011');
        $this->assertEquals($content['service']['name'], 'testing');
        $this->assertEquals($content['timeslices'][0]['duration'], 7200);
    }
}