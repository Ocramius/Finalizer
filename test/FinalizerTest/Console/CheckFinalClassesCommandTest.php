<?php

namespace FinalizerTest\Console;

use Finalizer\Console\CheckFinalClassesCommand;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Tests\Fixtures\DummyOutput;
use function count;
use function explode;

/**
 * @covers \Finalizer\Console\CheckFinalClassesCommand
 */
class CheckFinalClassesCommandTest extends TestCase
{
    /**
     * @dataProvider pathsProvider
     *
     * @param string[] $paths
     * @param string   $expectedOutput
     */
    public function testCheckFinalClassesCommand(array $paths, string $expectedOutput, int $expectedExitCode) : void
    {
        $output = new DummyOutput();

        $exitCode = (new CheckFinalClassesCommand())->run(new ArrayInput(['directories' => $paths]), $output);

        $this->assertCount(count(explode("\n", $expectedOutput)), explode(PHP_EOL, $output->fetch()));
        $this->assertSame($expectedExitCode, $exitCode);
    }

    /**
     * Data provider
     *
     * @return mixed[][]
     */
    public function pathsProvider() : array
    {
        return [
            [
                [__DIR__ . '/../../../src'],
                '',
                0,
            ],
            [
                [__DIR__ . '/../../FinalizerTestAsset'],
                <<<'OUTPUT'
Following classes need to be made final:
+--------------------------------------------------------------+
| FinalizerTestAsset\Finalizable\ClassWithConstructor          |
| FinalizerTestAsset\Finalizable\ClassWithNoMethods            |
| FinalizerTestAsset\Finalizable\ClassWithPrivateMethod        |
| FinalizerTestAsset\Finalizable\ClassWithProtectedMethod      |
| FinalizerTestAsset\Finalizable\EmptyChildClass               |
| FinalizerTestAsset\Finalizable\FooBarConstructorMethodClass  |
| FinalizerTestAsset\Finalizable\FooBarMethodClass             |
| FinalizerTestAsset\Finalizable\FooMethodClass                |
| FinalizerTestAsset\Finalizable\InvokableClass                |
| FinalizerTestAsset\Finalizable\InvokableClassWithConstructor |
+--------------------------------------------------------------+
Following classes are final and need to be made extensible again:
+-----------------------------------------------------------+
| FinalizerTestAsset\InvalidFinal\ClassThatShouldNotBeFinal |
+-----------------------------------------------------------+

OUTPUT
                ,
                1
            ],
            [
                [__DIR__ . '/../../../src', __DIR__ . '/../../FinalizerTestAsset'],
                <<<'OUTPUT'
Following classes need to be made final:
+--------------------------------------------------------------+
| FinalizerTestAsset\Finalizable\ClassWithConstructor          |
| FinalizerTestAsset\Finalizable\ClassWithNoMethods            |
| FinalizerTestAsset\Finalizable\ClassWithPrivateMethod        |
| FinalizerTestAsset\Finalizable\ClassWithProtectedMethod      |
| FinalizerTestAsset\Finalizable\EmptyChildClass               |
| FinalizerTestAsset\Finalizable\FooBarConstructorMethodClass  |
| FinalizerTestAsset\Finalizable\FooBarMethodClass             |
| FinalizerTestAsset\Finalizable\FooMethodClass                |
| FinalizerTestAsset\Finalizable\InvokableClass                |
| FinalizerTestAsset\Finalizable\InvokableClassWithConstructor |
+--------------------------------------------------------------+
Following classes are final and need to be made extensible again:
+-----------------------------------------------------------+
| FinalizerTestAsset\InvalidFinal\ClassThatShouldNotBeFinal |
+-----------------------------------------------------------+

OUTPUT
                ,
                1
            ],
            [
                [
                    __DIR__ . '/../../FinalizerTestAsset/Finalizable',
                    __DIR__ . '/../../FinalizerTestAsset/InvalidFinal',
                ],
                <<<'OUTPUT'
Following classes need to be made final:
+--------------------------------------------------------------+
| FinalizerTestAsset\Finalizable\ClassWithConstructor          |
| FinalizerTestAsset\Finalizable\ClassWithNoMethods            |
| FinalizerTestAsset\Finalizable\ClassWithPrivateMethod        |
| FinalizerTestAsset\Finalizable\ClassWithProtectedMethod      |
| FinalizerTestAsset\Finalizable\EmptyChildClass               |
| FinalizerTestAsset\Finalizable\FooBarConstructorMethodClass  |
| FinalizerTestAsset\Finalizable\FooBarMethodClass             |
| FinalizerTestAsset\Finalizable\FooMethodClass                |
| FinalizerTestAsset\Finalizable\InvokableClass                |
| FinalizerTestAsset\Finalizable\InvokableClassWithConstructor |
+--------------------------------------------------------------+
Following classes are final and need to be made extensible again:
+-----------------------------------------------------------+
| FinalizerTestAsset\InvalidFinal\ClassThatShouldNotBeFinal |
+-----------------------------------------------------------+

OUTPUT
                ,
                1
            ],
        ];
    }
}
