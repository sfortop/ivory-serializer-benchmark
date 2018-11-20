<?php

namespace PhpSerializers\Benchmarks\Command;

use PhpSerializers\Benchmarks\BenchFinder;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Helper\TableCell;
use Symfony\Component\Console\Helper\TableSeparator;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @author Tales Santos <tales.augusto.santos@gmail.com>
 */
class InfoCommand extends Command
{
    /**
     * @var BenchFinder
     */
    private $finder;

    /**
     * InfoCommand constructor.
     * @param BenchFinder $finder
     */
    public function __construct(BenchFinder $finder)
    {
        parent::__construct();
        $this->finder = $finder;
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

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->displayAll($output);
    }

    private function displayAll(OutputInterface $output): void
    {
        $rows = [];

        foreach ($this->finder->findAll() as $benchmarks) {
            foreach ($benchmarks as $i => $benchmark) {
                $row = [
                    $benchmark['name'],
                ];

                if ($i === 0) {
                    $row[] = new TableCell($benchmark['version'], ['rowspan' => count($benchmarks)]);
                }

                $row[] = $benchmark['note'];
                $rows[] = $row;
            }

            $rows[] = new TableSeparator();
        }

        array_pop($rows);

        $table= new Table($output);
        $table->setHeaders(['Benchmark', 'Version', 'Note']);
        $table->setRows($rows);
        $table->render();
    }
}
