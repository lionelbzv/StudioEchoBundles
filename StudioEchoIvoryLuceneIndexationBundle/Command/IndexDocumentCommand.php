<?php

/*
 * This file is part of the FOSUserBundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace StudioEchoBundles\StudioEchoIvoryLuceneIndexationBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

use StudioEchoBundles\StudioEchoIvoryLuceneIndexationBundle\Lib\IvoryLuceneIndexation;

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
            ->addOption(
                'class-name',
                null,
                InputOption::VALUE_REQUIRED,
                'Object class name to index',
                null
            )
            ;
    }

    /**
     * @see Command
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $isVerbose = (OutputInterface::VERBOSITY_VERBOSE <= $output->getVerbosity());
        $isQuiet = (OutputInterface::VERBOSITY_QUIET === $output->getVerbosity());

        $className = $input->getOption('class-name');
        if ($className && (!class_exists($className))) {
            throw new \Exception(sprintf('%s is not a valid namespaced class name.', $className));
        }

        // Indexation
        $ivoryIndexation = $this->getContainer()->get('ivory_lucene_indexation');

        $nbIndexed = 0;
        if ($className) {
            // Récupération de tous les objets de la classe fournie
            $query = call_user_func($className.'Query' . "::create");
            $results = $query->find();

            foreach ($results as $instance) {
                if ($isVerbose) {
                    $output->writeln(sprintf('Indexation de "%s" de la classe "%s"', $instance->__toString(), $className));
                }
                $ivoryIndexation->updateDocument($instance, $className);
                $nbIndexed++;
            }
        } else {
            $nbIndexed = $ivoryIndexation->updateAll($output);
        }

        $output->writeln('<info>L\'indexation est terminée.</info>');
        $output->writeln(sprintf('<info>Nombre d\'objets indexés: %d</info>', $nbIndexed));
    }
}
