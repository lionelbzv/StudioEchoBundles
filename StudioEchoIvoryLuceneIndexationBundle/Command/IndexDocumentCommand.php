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

        $config = $this->getContainer()->getParameter('studio_echo_ivory_lucene_indexation');
        if (!$className) {
            $classNames = $this->getContainer()->getParameter('studio_echo_ivory_lucene_indexation');
        } else {
            $classNames = [ $className => $className ];
        }

        $nbIndexed = 0;
        foreach ($classNames as $className => $parameters) {
            $output->writeln('----------------------------------------------');
            $output->writeln(sprintf('Indexation des instances de la classe "%s"', $className));
            $query = call_user_func($className.'Query' . "::create");
            $results = $query->find();

            foreach ($results as $instance) {
                $output->writeln('***************************************************');
                $output->writeln(sprintf('%s', $instance->__toString()));
                $ivoryIndexation->updateDocument($instance, $className);
                $nbIndexed++;
            }
        }

        $output->writeln('<info>L\'indexation est terminée.</info>');
        $output->writeln(sprintf('<info>Nombre d\'objets indexés: %d</info>', $nbIndexed));
    }
}
