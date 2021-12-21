<?php
declare(strict_types=1);

namespace App\Command;

use App\Service\CsvHandlers\ProductCsvHandlerService;
use App\Trait\CheckExtensionTrait;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Exception;
use Symfony\Component\HttpKernel\KernelInterface;

class ImportProductCsvCommand extends Command
{
    use CheckExtensionTrait;

    protected static $defaultName = 'app:import:csv';

    /**
     * @param ProductCsvHandlerService $productCsvHandlerService
     * @param KernelInterface $appKernel
     */
    public function __construct(private ProductCsvHandlerService $productCsvHandlerService, private KernelInterface $appKernel)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->addArgument('file', InputArgument::REQUIRED, 'Please indicate csv file to import');
        $this->addOption(name: 'test', mode: InputOption::VALUE_REQUIRED, description: 'Indicate whether this is a test mode (true or false)');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            $file = $input->getArgument('file');

            // Checking the extension of the file
            $this->checkExtension($file, 'csv');

            $isTest = $input->getOption('test') === 'true';

            // Handler for product csv
            $productHandlerInfo = $this->productCsvHandlerService->handle($file, $isTest);

            $output->writeln(PHP_EOL . 'Import is completed!' . PHP_EOL);

            $output->writeln('Rows was handled:            ' . $productHandlerInfo->getImportRowsCount());
            $output->writeln('Rows was handled successful: ' . $productHandlerInfo->getImportRowsSuccessCount());
            $output->writeln('Rows was missed:             ' . $productHandlerInfo->getImportRowsMissedCount() . PHP_EOL);

            $output->writeln('Rows was handled failure (' . $productHandlerInfo->getImportRowsFailureCount() . '): ');

            // Showing rows which was not imported
            foreach ($productHandlerInfo->getImportFailureRows() as $rows) {
                $output->writeln($rows . "\r");
            }

            return Command::SUCCESS;

        } catch (Exception $exception) {

            $output->writeln($exception->getMessage());

            return Command::FAILURE;
        }
    }
}