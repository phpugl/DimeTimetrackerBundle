<?php

namespace Dime\TimetrackerBundle\Parser;

class ActivityDescription extends Parser
{
  protected $regex = '/([@:\/])(\w+)/';
  protected $matches = array();

  public function clean($input)
  {
    return trim(str_replace($input, '', $input));
  }

  public function run($input)
  {
    $this->result['description'] = $input;
    return $this->result;
  }

}