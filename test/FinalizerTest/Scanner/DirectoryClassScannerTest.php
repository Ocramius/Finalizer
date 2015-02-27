<?php

namespace FinalizerTest\Scanner;

use Finalizer\Scanner\DirectoryClassScanner;

/**
 * @covers \Finalizer\Scanner\DirectoryClassScanner
 */
class DirectoryClassScannerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider pathsProvider
     *
     * @param string[]|\Traversable $paths
     * @param string[]              $expectedClasses
     */
    public function testDirectoryScannerWithPaths($paths, $expectedClasses)
    {
        $found = array_values(array_map(
            function (\ReflectionClass $class) {
                return $class->getName();
            },
            (new DirectoryClassScanner())->__invoke($paths)
        ));

        sort($found);

        $this->assertEquals($expectedClasses, $found);
    }

    /**
     * @dataProvider pathsProvider
     *
     * @param string[]|array $paths
     * @param string[]       $expectedClasses
     */
    public function testDirectoryScannerWithIterator(array $paths, $expectedClasses)
    {
        $this->testDirectoryScannerWithPaths(new \ArrayIterator($paths), $expectedClasses);
    }

    /**
     * @return string[][][]
     */
    public function pathsProvider()
    {
        return [
            [
                [__FILE__],
                [__CLASS__],
            ],
            [
                [__FILE__, __DIR__ . '/DirectoryFileScannerTest.php'],
                [__CLASS__, DirectoryFileScannerTest::class],
            ],
            [
                [
                    __FILE__,
                    __DIR__ . '/../../FinalizerTestAsset/Scanner/DirectoryFileScanner/DirWithOnePhpFile/1.php'
                ],
                [__CLASS__],
            ],
        ];
    }
}
