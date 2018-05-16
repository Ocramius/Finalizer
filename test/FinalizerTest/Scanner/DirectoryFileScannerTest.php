<?php

namespace FinalizerTest\Scanner;

use Finalizer\Scanner\DirectoryClassScanner;
use Finalizer\Scanner\DirectoryFileScanner;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Finalizer\Scanner\DirectoryFileScanner
 */
class DirectoryFileScannerTest extends TestCase
{
    /**
     * @dataProvider pathsProvider
     *
     * @param string[] $paths
     */
    public function testProducesStringsIterator(array $paths)
    {
        $this->assertInstanceOf(\Traversable::class, (new DirectoryFileScanner())->__invoke($paths));

        foreach ((new DirectoryFileScanner())->__invoke($paths) as $path) {
            $this->assertInternalType('string', $path);
        }
    }

    /**
     * @dataProvider pathsProvider
     *
     * @param string[] $paths
     */
    public function testDiscoversCorrectAmountOfFiles(array $paths, $count)
    {
        $this->assertCount($count, iterator_to_array((new DirectoryFileScanner())->__invoke($paths)));
    }

    /**
     * Data provider
     *
     * @return string[][][]|int[][]
     */
    public function pathsProvider()
    {
        return [
            [
                [__DIR__ . '/../../FinalizerTestAsset/Scanner/DirectoryFileScanner'],
                4
            ],
            [
                [__DIR__ . '/../../FinalizerTestAsset/Scanner/DirectoryFileScanner/EmptyDirectory'],
                0
            ],
            [
                [__DIR__ . '/../../FinalizerTestAsset/Scanner/DirectoryFileScanner/DirWithOnePhpFile'],
                1
            ],
            [
                [__DIR__ . '/../../FinalizerTestAsset/Scanner/DirectoryFileScanner/DirWithTwoPhpFiles'],
                2
            ],
            [
                [__DIR__ . '/../../FinalizerTestAsset/Scanner/DirectoryFileScanner/DirWithOneHhFile'],
                1
            ],
            [
                [
                    __DIR__ . '/../../FinalizerTestAsset/Scanner/DirectoryFileScanner/DirWithOnePhpFile',
                    __DIR__ . '/../../FinalizerTestAsset/Scanner/DirectoryFileScanner/DirWithOneHhFile',
                ],
                2
            ],
            [
                [
                    __DIR__ . '/../../FinalizerTestAsset/Scanner/DirectoryFileScanner/DirWithOnePhpFile',
                    __DIR__ . '/../../FinalizerTestAsset/Scanner/DirectoryFileScanner/DirWithOneHhFile',
                    __DIR__ . '/../../FinalizerTestAsset/Scanner/DirectoryFileScanner/DirWithTwoPhpFiles',
                ],
                4
            ],
        ];
    }
}
