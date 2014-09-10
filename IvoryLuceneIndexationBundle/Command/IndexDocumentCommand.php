<?php

/*
 * This file is part of the FOSUserBundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace StudioEchoBundles\IvoryLuceneIndexationBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;


use StudioEchoBundles\IvoryLuceneIndexationBundle\Lib\IvoryLuceneIndexation;


/**
 * @author Lionel Bouzonville / Studio Echo
 */
class IndexDocumentCommand extends ContainerAwareCommand
{
    /**
     * @see Command
     */
    protected function configure()
    {
        $this
            ->setName('studioecho:lucene:index')
            ->setDescription('Lucene indexation using Ivory Search Bundle')
            ;   
    }

    /**
     * @see Command
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // $username = $input->getArgument('username');

        // $manipulator = $this->getContainer()->get('fos_user.util.user_manipulator');
        // $manipulator->activate($username);

        $logger = $this->getContainer()->get('logger');
        $logger->info('*** execute');

        // Indexation
        $ivoryIndexation = $this->getContainer()->get('ivory_lucene_indexation');
        $ivoryIndexation->updateAll($output);

        $output->writeln('');
        $output->writeln('Indexation has been successfully completed!');
    }

}
