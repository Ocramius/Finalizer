<?php

namespace Finalizer\Console;

use Finalizer\Constraint\IsFinalizable;
use Finalizer\Scanner\DirectoryClassScanner;
use Finalizer\Scanner\DirectoryFileScanner;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CheckFinalClassesCommand extends Command
{
    /**
     * {@inheritDoc}
     */
    public function __construct()
    {
        parent::__construct('finalizer:check-final-classes');

        $this
            ->setDescription(
                'Checks the given paths for classes that should or shouldn\'t be final'
            )
            ->setDefinition([new InputArgument(
                'directories',
                InputArgument::REQUIRED | InputArgument::IS_ARRAY,
                'Paths to be checked for existing classes'
            )]);
        $this->setHelp(<<<EOT
The <info>%command.name%</info> command generates a short report
of classes that should be final and classes that shouldn't be final.

You can use this command as following:
<info>%command.name% path/to/sources</info>
<info>%command.name% path/to/first/sources/dir path/to/second/sources/dir</info>
EOT
        );
    }

    /**
     * {@inheritDoc}
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $classScanner = new DirectoryClassScanner();
        $fileScanner  = new DirectoryFileScanner();
        $classes      = $classScanner($fileScanner($input->getArgument('directories')));

        $this->renderClassesToFinalize($classes, $output);
        $this->renderClassesToDeFinalize($classes, $output);
    }

    /**
     * @param \ReflectionClass[] $classes
     * @param OutputInterface    $output
     */
    private function renderClassesToFinalize(array $classes, OutputInterface $output)
    {
        $tableHelper = new Table($output);

        if ($toFinalize = $this->getClassesToFinalize($classes)) {
            $output->writeln('<info>Following classes need to be made final:</info>');

            $tableHelper->addRows(array_map(
                function (\ReflectionClass $class) {
                    return [$class->getName()];
                },
                $toFinalize
            ));

            $tableHelper->render();
        }
    }

    /**
     * @param \ReflectionClass[] $classes
     * @param OutputInterface    $output
     */
    private function renderClassesToDeFinalize(array $classes, OutputInterface $output)
    {
        $tableHelper = new Table($output);

        if ($toDeFinalize = $this->getClassesToDeFinalize($classes)) {
            $output->writeln('<error>Following classes are final and need to be made extensible again:</error>');

            $tableHelper->addRows(array_map(
                function (\ReflectionClass $class) {
                    return [$class->getName()];
                },
                $toDeFinalize
            ));

            $tableHelper->render();
        }
    }

    /**
     * @param \ReflectionClass[] $classes
     *
     * @return \ReflectionClass[]
     */
    private function getClassesToFinalize(array $classes)
    {
        $isFinalizable = new IsFinalizable();
        $toFinalize    = [];

        foreach ($classes as $class) {
            if ($isFinalizable($class, ...$classes) && ! $class->isFinal()) {
                $toFinalize[] = $class;
            }
        }

        return $toFinalize;
    }

    /**
     * @param \ReflectionClass[] $classes
     *
     * @return \ReflectionClass[]
     */
    private function getClassesToDeFinalize(array $classes)
    {
        $isFinalizable = new IsFinalizable();
        $toDeFinalize  = [];

        foreach ($classes as $class) {
            if ((! $isFinalizable($class, ...$classes)) && $class->isFinal()) {
                $toDeFinalize[] = $class;
            }
        }

        return $toDeFinalize;
    }
}
