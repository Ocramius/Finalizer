<?php

namespace Finalizer\Scanner;

final class DirectoryClassScanner
{
    /**
     * @param string[]|\Traversable $files
     *
     * @return \ReflectionClass[] all classes defined in this directory
     */
    public function __invoke($files)
    {
        return $this->getClassesDeclaredInFiles($this->includeFiles($files), get_declared_classes());
    }

    /**
     * @param string[]|\Traversable $files
     *
     * @return bool[] the files that were loaded, indexed by file name
     */
    private function includeFiles($files)
    {
        $loadedFiles = [];

        foreach ($files as $file) {
            require_once $file;

            $loadedFiles[realpath($file)] = true;
        }

        return $loadedFiles;
    }

    /**
     * @param string[] $files
     * @param string[] $classes
     *
     * @return \ReflectionClass[]
     */
    private function getClassesDeclaredInFiles(array $files, array $classes)
    {
        return array_filter(
            array_map(
                function ($className) {
                    return new \ReflectionClass($className);
                },
                $classes
            ),
            function (\ReflectionClass $class) use ($files) {
                return isset($files[realpath($class->getFileName())]);
            }
        );
    }
}
