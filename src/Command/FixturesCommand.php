<?php

namespace App\Command;

use App\Entity\Talk;
use App\Repository\TalkRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class FixturesCommand extends Command
{
    /**
     * @var TalkRepository
     */
    private $repository;

    public function __construct(TalkRepository $repository)
    {
        parent::__construct();

        $this->repository = $repository;
    }

    protected function configure()
    {
        $this->setName('dpc:fixtures');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $ui = new SymfonyStyle($input, $output);

        $ui->title('Loading fixtures...');

        $this->repository->add(Talk::create('Best practices for crafting high quality PHP apps', 'James Titcumb'));
        $this->repository->add(Talk::create('Hack this workshop!', 'Chris Riley'));
        $this->repository->add(Talk::create('Getting started with Symfony 4 and Flex', 'Denis Brumann'));

        $ui->success('Done.');
    }

}
