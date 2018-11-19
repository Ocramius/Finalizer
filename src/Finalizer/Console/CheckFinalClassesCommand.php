<?php

namespace Finalizer\Console;

use function count;
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
    public function execute(InputInterface $input, OutputInterface $output) : int
    {
        $classScanner = new DirectoryClassScanner();
        $fileScanner  = new DirectoryFileScanner();
        $classes      = $classScanner($fileScanner($input->getArgument('directories')));

        $finalizeStatusCode = $this->renderClassesToFinalize($classes, $output);
        $deFinalizeStatusCode = $this->renderClassesToDeFinalize($classes, $output);

        return max($finalizeStatusCode, $deFinalizeStatusCode);
    }

    /**
     * @param \ReflectionClass[] $classes
     */
    private function renderClassesToFinalize(array $classes, OutputInterface $output) : int
    {
        $tableHelper = new Table($output);

        $toFinalize = $this->getClassesToFinalize($classes);
        if (count($toFinalize) > 0) {
            $output->writeln('<info>Following classes need to be made final:</info>');

            $tableHelper->addRows(array_map(
                function (\ReflectionClass $class) {
                    return [$class->getName()];
                },
                $toFinalize
            ));

            $tableHelper->render();

            return 1;
        }

        return 0;
    }

    /**
     * @param \ReflectionClass[] $classes
     */
    private function renderClassesToDeFinalize(array $classes, OutputInterface $output) : int
    {
        $tableHelper = new Table($output);

        $toDeFinalize = $this->getClassesToDeFinalize($classes);
        if (count($toDeFinalize) > 0) {
            $output->writeln('<error>Following classes are final and need to be made extensible again:</error>');

            $tableHelper->addRows(array_map(
                function (\ReflectionClass $class) {
                    return [$class->getName()];
                },
                $toDeFinalize
            ));

            $tableHelper->render();

            return 1;
        }

        return 0;
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
