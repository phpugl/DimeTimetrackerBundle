<?php

namespace Dime\TimetrackerBundle\Tests\Parser;

use Dime\TimetrackerBundle\Parser\ActivityRelation;

class ActivityRelationTest extends \PHPUnit_Framework_TestCase
{
    public function testRun() {
        $parser = new ActivityRelation();

        // Customer
        $result = $parser->run('@customer do something');
        $this->assertArrayHasKey('customer', $result);
        $this->assertEquals('customer', $result['customer']);

        $result = $parser->run('do @customer something');
        $this->assertArrayHasKey('customer', $result);
        $this->assertEquals('customer', $result['customer']);

        $result = $parser->run('do something @customer');
        $this->assertArrayHasKey('customer', $result);
        $this->assertEquals('customer', $result['customer']);

        // Project
        $result = $parser->run('/project do something');
        $this->assertArrayHasKey('project', $result);
        $this->assertEquals('project', $result['project']);

        // Customer / Project
        $result = $parser->run('@customer/project do something');
        $this->assertArrayHasKey('project', $result);
        $this->assertEquals('project', $result['project']);
        $this->assertArrayHasKey('customer', $result);
        $this->assertEquals('customer', $result['customer']);

        $result = $parser->run('@customer do something /project');
        $this->assertArrayHasKey('project', $result);
        $this->assertEquals('project', $result['project']);
        $this->assertArrayHasKey('customer', $result);
        $this->assertEquals('customer', $result['customer']);

        // Service
        $result = $parser->run(':service do something');
        $this->assertArrayHasKey('service', $result);
        $this->assertEquals('service', $result['service']);

        // Customer / Service
        $result = $parser->run('@customer:service do something');
        $this->assertArrayHasKey('service', $result);
        $this->assertEquals('service', $result['service']);
        $this->assertArrayHasKey('customer', $result);
        $this->assertEquals('customer', $result['customer']);

        $result = $parser->run('@customer do something :service');
        $this->assertArrayHasKey('service', $result);
        $this->assertEquals('service', $result['service']);
        $this->assertArrayHasKey('customer', $result);
        $this->assertEquals('customer', $result['customer']);

        // Project / Service
        $result = $parser->run('/project :service do something');
        $this->assertArrayHasKey('project', $result);
        $this->assertEquals('project', $result['project']);
        $this->assertArrayHasKey('service', $result);
        $this->assertEquals('service', $result['service']);

        // Customer / Project / Service
        $result = $parser->run('@customer /project :service do something');
        $this->assertArrayHasKey('project', $result);
        $this->assertEquals('project', $result['project']);
        $this->assertArrayHasKey('service', $result);
        $this->assertEquals('service', $result['service']);
        $this->assertArrayHasKey('customer', $result);
        $this->assertEquals('customer', $result['customer']);
    }

    public function testClean() {
        $parser = new ActivityRelation();
        $input = '@customer do something';

        $parser->run($input);

        $output = $parser->clean($input);

        $this->assertEquals('do something', $output);
    }
}
