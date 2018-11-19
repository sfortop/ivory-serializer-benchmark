<?php

namespace PhpSerializers\Benchmarks;

use PhpBench\DependencyInjection\Container;
use PhpBench\DependencyInjection\ExtensionInterface;
use PhpSerializers\Benchmarks\Command\InfoCommand;

/**
 * @author Tales Santos <tales.augusto.santos@gmail.com>
 */
class BenchExtension implements ExtensionInterface
{
    public function load(Container $container)
    {
        $container->register('serializer.vendor_command', function (Container $container) {
            return new InfoCommand(
                $container->get('benchmark.benchmark_finder'),
                $container->getParameter('path')
            );
        }, ['console.command' => []]);
    }

    public function getDefaultConfig()
    {
        return [];
    }
}
