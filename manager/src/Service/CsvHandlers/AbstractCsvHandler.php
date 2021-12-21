<?php
declare(strict_types=1);

namespace App\Service\CsvHandlers;

use App\Dto\ProductCsvHandlerInfo;
use Doctrine\ORM\EntityManagerInterface;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

abstract class AbstractCsvHandler
{
    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(protected EntityManagerInterface $entityManager)
    {
    }

    /**
     * @param string $file
     * @param bool $isTest
     * @return ProductCsvHandlerInfo
     */
    abstract function handle(string $file, bool $isTest): ProductCsvHandlerInfo;

    /**
     * @param string $file
     * @return Worksheet
     */
    protected function getCsvSheet(string $file): Worksheet
    {
        // Method will test the file before actually executing the load: so if (for example)
        // the file is actually a CSV file or contains HTML markup, but that has been given a .xls extension,
        // it will reject the Xls loader that it would normally use for a .xls file; and test the file using
        // the other loaders until it finds the appropriate loader, and then use that to read the file.
        $spreadsheet = IOFactory::load($file);

        return $spreadsheet->getActiveSheet();
    }
}