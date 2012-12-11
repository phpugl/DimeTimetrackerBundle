<?php

namespace Dime\TimetrackerBundle\Tests\Controller;

use Symfony\Component\BrowserKit\Cookie;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class DimeTestCase extends WebTestCase
{
    /* @var $client Client */
    protected $client;
    const FIREWALL_NAME = 'main';

    public function setUp()
    {
        $this->client = self::createClient();
    }

    /**
     * do a request using HTTP authentification
     */
//    protected function request(
//        $method,
//        $uri,
//        $content = null,
//        array $parameters = array(),
//        array $files = array(),
//        array $server = null,
//        $changeHistory = true
//    ) {
//        if (is_null($server)) {
//            $server = array('PHP_AUTH_USER' => 'admin', 'PHP_AUTH_PW' => 'kitten');
//        }
//        $this->client->restart();
//
//        // make get request with authentifaction
//        $this->client->request($method, $uri, $parameters, $files, $server, $content, $changeHistory);
//
//        return $this->client->getResponse();
//    }

    protected function request(
        $method,
        $uri,
        $content = null,
        array $parameters = array(),
        array $files = array(),
        array $server = array(),
        $changeHistory = true
    )
    {
        $this->client->request($method, $uri, $parameters, $files, $server, $content, $changeHistory);
        return $this->client->getResponse();
    }

    /**
     * User with auth.
     *
     * @param $firewallName
     * @param array $options
     * @param array $server
     *
     * @return Client
     */
    protected function loginAs($user, $password = null)
    {
        $this->client->restart();

        $container = $this->client->getContainer();
        $doctrine = $container->get('doctrine');

        $user = $doctrine->getRepository('DimeTimetrackerBundle:User')->findOneBy(array('username' => $user));

        if ($user) {
            $this->client->getCookieJar()->set(new Cookie(session_name(), false));

            // dummy call to bypass the hasPreviousSession check
            $crawler = $this->client->request('GET', '/');

            $token = new UsernamePasswordToken($user, $password, self::FIREWALL_NAME, $user->getRoles());
            $this->client->getContainer()->get('security.context')->setToken($token);

            $session = $this->client->getContainer()->get('session');
            $session->set('_security_' . self::FIREWALL_NAME, serialize($token));
            $session->save();
        }
    }
}
