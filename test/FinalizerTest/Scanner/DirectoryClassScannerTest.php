<?php

namespace FinalizerTest\Scanner;

use Finalizer\Scanner\DirectoryClassScanner;

/**
 * @covers \Finalizer\Scanner\DirectoryClassScanner
 */
class DirectoryClassScannerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider testPathsProvider
     *
     * @param string[]|\Traversable $paths
     * @param string[]              $expectedClasses
     */
    public function testDirectoryScannerWithPaths($paths, $expectedClasses)
    {
        $this->assertEquals(
            $expectedClasses,
            array_values(array_map(
                function (\ReflectionClass $class) {
                    return $class->getName();
                },
                (new DirectoryClassScanner())->__invoke($paths)
            ))
        );
    }

    /**
     * @return string[][][]
     */
    public function testPathsProvider()
    {
        return [
            [
                [__FILE__],
                [__CLASS__],
            ]
        ];
    }
}
