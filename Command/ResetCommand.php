<?php

namespace Dtc\QueueBundle\Command;

use Dtc\QueueBundle\Manager\JobManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ResetCommand extends Command
{
    private $jobManager;

    public function __construct(JobManagerInterface $jobManager, string $name = null)
    {
        $this->jobManager = $jobManager;

        parent::__construct($name);
    }

    protected function configure()
    {
        $this
            ->setName('dtc:queue:reset')
            ->setDescription('Reset jobs with exception or stalled status');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $countException = $this->jobManager->resetExceptionJobs();
        $countStalled = $this->jobManager->resetStalledJobs();
        $output->writeln("$countException job(s) in status 'exception' reset");
        $output->writeln("$countStalled job(s) stalled (in status 'running') reset");
    }
}
