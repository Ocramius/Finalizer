<?php

namespace Finalizer\Scanner;

use Finalizer\Iterator\MapIterator;

final class DirectoryFileScanner
{
    /**
     * @param string[] $directories

     * @return \Traversable|string[] paths of all the existing PHP files in the given directories
     */
    public function __invoke(array $directories)
    {
        $appendIterator = new \AppendIterator();

        array_map(
            [$appendIterator, 'append'],
            array_map(
                function ($path) {
                    return new \RegexIterator(
                        new \RecursiveIteratorIterator(
                            new \RecursiveDirectoryIterator($path, \FilesystemIterator::SKIP_DOTS),
                            \RecursiveIteratorIterator::LEAVES_ONLY
                        ),
                        '/^.+(\.php|\.hh)$/i',
                        \RecursiveRegexIterator::GET_MATCH
                    );
                },
                $directories
            )
        );

        return new MapIterator(
            $appendIterator,
            function (array $fileInfo) {
                return $fileInfo[0];
            }
        );
    }
}
