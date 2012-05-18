<?php

namespace Dime\TimetrackerBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DimeTestCase extends WebTestCase
{
    protected $client;

    public function setUp()
    {
        $this->client = static::createClient();
    }

    /**
     * do a request using HTTP authentification 
     */
    protected function request(
        $method,
        $uri,
        $content = null,
        array $parameters = array(),
        array $files = array(),
        array $server = null,
        $changeHistory = true
    ) {
        if (is_null($server)) {
            $server = array('PHP_AUTH_USER' => 'admin', 'PHP_AUTH_PW' => 'kitten');
        }
        $this->client->restart();

        // make get request with authentifaction 
        $this->client->request($method, $uri, $parameters, $files, $server, $content, $changeHistory);
        return $this->client->getResponse();
    }
}
