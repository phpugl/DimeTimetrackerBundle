<?php
namespace Dime\TimetrackerBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Finder\Finder;

class RebuildCommand extends ContainerAwareCommand
{
    public function __construct($name = null)
    {
        parent::__construct($name);
        
    }

    protected function configure()
    {
        $this
            ->setName('dime:rebuild')
            ->setDescription('Rebuild database')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $returnCode = $this->runExternalCommand('doctrine:schema:drop', $output, array('--force' => true));
        $returnCode = $this->runExternalCommand('doctrine:schema:create', $output);
        $returnCode = $this->runExternalCommand('doctrine:fixtures:load', $output);
    }

    protected function runExternalCommand($name, $output, array $input = array())
    {
        $command = $this->getApplication()->find($name);

        if ($command) {
          $args = array_merge(array('command' => $name), $input);
          $input = new ArrayInput($args);
          return $command->run($input, $output);
        } else {
          return false;
        }
    }
}
