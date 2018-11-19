<?php

namespace PhpSerializers\Benchmarks\Command;

use PhpBench\Benchmark\BenchmarkFinder;
use PhpBench\Benchmark\Metadata\BenchmarkMetadata;
use PhpSerializers\Benchmarks\AbstractBench;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * @author Tales Santos <tales.augusto.santos@gmail.com>
 */
class InfoCommand extends Command
{
    /**
     * @var BenchmarkFinder
     */
    private $finder;

    /**
     * @var string
     */
    private $path;

    /**
     * @var array
     */
    private $packages;

    /**
     * VendorCommand constructor.
     * @param BenchmarkFinder $finder
     * @param string $path
     */
    public function __construct(BenchmarkFinder $finder, string $path)
    {
        parent::__construct();
        $this->finder = $finder;
        $this->path = $path;
    }

    protected function configure()
    {
        $this
            ->setName('info')
            ->addArgument('serializer', InputArgument::OPTIONAL, 'Serializer name to inspect')
            ->setDescription('Show information about available serializers.')
            ->setHelp(
                'The <info>%command.name%</info> displays detailed information about a serializer (e.g. version, capabilities and notes), 
                       or lists all serialized available'
            );
    }

    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        if (!file_exists($lockFile = __DIR__ . '/../../composer.lock')) {
            throw new \RuntimeException(
                'File composer.lock was not found. You should install the dependencies before running this command'
            );
        }

        $this->packages = json_decode(file_get_contents($lockFile), true);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $benchmarks = $this->finder->findBenchmarks($this->path);

        $rows = [];

        /** @var BenchmarkMetadata $benchmark */
        foreach ($benchmarks as $benchmark) {

            $ref = new \ReflectionClass($benchmark->getClass());

            if (!$ref->isSubclassOf(AbstractBench::class)) {
                continue;
            }

            $instance = $ref->newInstanceWithoutConstructor();

            $rows[] = [$ref->getShortName(), $this->getVersion($instance->getPackageName())];
        }

        $style = new SymfonyStyle($input, $output);
        $style->table(['name', 'version'], $rows);
    }

    private function getVersion(?string $package): string
    {
        if (null === $package) {
            return 'N/A';
        }

        foreach ($this->packages['packages'] as $pck) {
            if ($pck['name'] === $package) {
                return $pck['version'];
            }
        }

        return 'N/A';
    }
}
