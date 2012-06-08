<?php

namespace Dime\TimetrackerBundle\Tests\Parser;

use Dime\TimetrackerBundle\Parser\TimeRange;

class TimeRangeTest extends \PHPUnit_Framework_TestCase
{
    public function testRun()
    {
        $parser = new TimeRange();

        // 10:00-12:00
        $parser->setResult(array());
        $result = $parser->run('10:00-12:00');
        $this->assertArrayHasKey('range', $result);
        $this->assertArrayHasKey('start', $result['range']);
        $this->assertArrayHasKey('stop', $result['range']);
        $this->assertEquals('10:00', $result['range']['start']);
        $this->assertEquals('12:00', $result['range']['stop']);

        // 10-12
        $parser->setResult(array());
        $result = $parser->run('10-12');
        $this->assertEquals('10:00', $result['range']['start']);
        $this->assertEquals('12:00', $result['range']['stop']);

        // 10:00-
        $parser->setResult(array());
        $result = $parser->run('10:00-');
        $this->assertEquals('10:00', $result['range']['start']);
        $this->assertEquals('', $result['range']['stop']);

        // -12:00
        $parser->setResult(array());
        $result = $parser->run('-12:00');
        $this->assertEquals('', $result['range']['start']);
        $this->assertEquals('12:00', $result['range']['stop']);

        // 10-
        $parser->setResult(array());
        $result = $parser->run('10-');
        $this->assertEquals('10:00', $result['range']['start']);
        $this->assertEquals('', $result['range']['stop']);

        // -12
        $parser->setResult(array());
        $result = $parser->run('-12');
        $this->assertEquals('', $result['range']['start']);
        $this->assertEquals('12:00', $result['range']['stop']);

        // Empty
        $parser->setResult(array());
        $result = $parser->run('');
        $this->assertEmpty($result);
    }

    public function testClean()
    {
        $parser = new TimeRange();
        $input = '10:00-12:00';

        $parser->run($input);

        $output = $parser->clean($input);

        $this->assertEquals('', $output);
    }
}
