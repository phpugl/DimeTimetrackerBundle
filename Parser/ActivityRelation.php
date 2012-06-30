<?php

namespace Dime\TimetrackerBundle\Parser;

class ActivityRelation extends Parser
{
  protected $regex = '/([@:\/])(\w+)/';
  protected $matches = array();

  public function clean($input)
  {
    if (!empty($this->matches)) {
      foreach ($this->matches[0] as $token) {
        $input = trim(str_replace($token, '', $input));
      }
    }

    return $input;
  }

  public function run($input)
  {
    // customer - project - serive (@ / :)
    if (preg_match_all('/([@:\/])(\w+)/', $input, $this->matches)) {
      foreach ($this->matches[1] as $key => $token) {
        switch ($token) {
          case '@':
            $this->result['customer'] = $this->matches[2][$key];
            break;
          case ':':
            $this->result['service'] = $this->matches[2][$key];
            break;
          case '/':
            $this->result['project'] = $this->matches[2][$key];
            break;
        }
      }
    }

    return $this->result;
  }

}
