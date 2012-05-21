<?php

namespace Dime\TimetrackerBundle\Tests\Parser;

use Dime\TimetrackerBundle\Parser\ActivityDescription;

class ActivityDescriptionTest extends \PHPUnit_Framework_TestCase
{
    public function testRun() {
        $parser = new ActivityDescription();

        $result = $parser->run('do something');
        $this->assertArrayHasKey('description', $result);
        $this->assertEquals('do something', $result['description']);
    }

    public function testClean() {
        $parser = new ActivityDescription();
        $input = 'do something';

        $parser->run($input);

        $output = $parser->clean($input);

        $this->assertEquals('', $output);
    }
}
