<?php

declare(strict_types=1);

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;

class CrudGeneratorCommand extends Command
{
    const COMMAND_VERSION = '0.21.0';

    public function __construct($app)
    {
        parent::__construct();
        $this->container = $app->getContainer();
    }

    // protected function configure()
    // {
    //     $this->setName('api:generate:endpoints')
    //         ->setDescription('Given an entity, auto-generate CRUD endpoints.')
    //         ->setHelp('This command generate CRUD services to manage any simple entity/table, in a RESTful API. Version: ' . self::COMMAND_VERSION)
    //         ->addArgument(
    //             'entity',
    //             InputArgument::REQUIRED,
    //             'Enter the name for the entity or table, to generate endpoints.'
    //         );
    // }

    // protected function execute(InputInterface $input, OutputInterface $output)
    // {
    //     $db = $this->container->get('db');
    //     $entity = $input->getArgument('entity');
    //     $generator = new CrudGeneratorService();
    //     $generator->generateCrud($db, $entity);
    //     $output->writeln('OK - Generated endpoints for entity: ' . $entity);
    // }

    protected function configure()
    {
        $this->setName('api:generate:endpoints')
            ->setDescription('Given an entity and a table, auto-generate CRUD endpoints.')
            ->setHelp('This command generates CRUD services to manage any simple entity/table in a RESTful API. Version: ' . self::COMMAND_VERSION)
            ->addArgument(
                'entity',
                InputArgument::REQUIRED,
                'Enter the name for the entity to generate endpoints.'
            )
            ->addArgument(
                'table',
                InputArgument::REQUIRED,
                'Enter the name for the table to generate endpoints.'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $db = $this->container->get('db');
        $entity = $input->getArgument('entity');
        $table = $input->getArgument('table');
        $generator = new CrudGeneratorService();
        $generator->generateCrud($db, $entity, $table);
        $output->writeln('OK - Generated endpoints for entity/table: ' . $entity . '/' . $table);
    }
}
