<?php

namespace Dime\TimetrackerBundle\Parser;

/**
 * a duration parser
 *
 * Example:
 * [+-]02:30:15    => [sign: [+-], number: 9015]
 * [+-]2h 30m 15s  => [sign: [+-], number: 9015]
 * [+-]2,5h        => [sign: [+-], number: 9000]
 * [+-]2.5h        => [sign: [+-], number: 9000]
 */
class Duration extends Parser
{
  protected $regex = '/(?P<sign>[+-])?(?P<duration>(\d+((:\d+)?(:\d+)?)?[hms]?([,\.]\d+[h])?(\s+)?(\d+[ms])?(\s+)?(\d+[s])?)?)/';
  protected $matches = array();

  public function clean($input)
  {
    if (isset($this->matches[0])) {
      $input = trim(str_replace($this->matches[0], '', $input));
    }

    return $input;
  }

  public function run($input)
  {
    if (!empty($input) && preg_match($this->regex, $input, $this->matches)) {
      if (!empty($this->matches[0])) {
        $duration = 0;
        print_r($this->matches);
        if (preg_match_all('/(?P<number>(\d+([,\.]\d+)?))(?P<unit>[hms])/', $this->matches['duration'], $items)) {
            foreach ($items['unit'] as $key => $unit) {
                $items['number'][$key] = str_replace(',','.', $items['number'][$key]);
                switch ($unit) {
                    case 'h':
                        $duration += $items['number'][$key]*3600;
                    break;
                    case 'm':
                        $duration += $items['number'][$key]*60;
                    break;
                    case 's':
                        $duration += $items['number'][$key];
                    break;
                }
            }
        } else {
            $time = explode(':', $this->matches['duration']);
            if (isset($time[0])) {
                $duration += $time[0]*3600;
            }
            if (isset($time[1])) {
                $duration += $time[1]*60;
            }
            if (isset($time[2])) {
                $duration += $time[2];
            }
        }

        // check if already set and run operation
        if (isset($this->result['duration'])) {
          if ($this->matches['sign'] == '-') {
            $duration *= -1;
          }

          if ($this->result['duration']['sign'] == '-') {
            $duration -= $this->result['duration']['number'];
          } else {
            $duration += $this->result['duration']['number'];
          }
        }

        $this->result['duration'] = array(
            'sign' => $this->matches['sign'],
            'number' => $duration
        );
      }
    }

    return $this->result;
  }
}
