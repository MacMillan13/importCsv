<?php
declare(strict_types=1);

namespace App\Service\CsvHandlers;

use App\Dto\ProductCsvHandlerInfo;
use App\Entity\Product;
use DateTime;
use Exception;
use UnexpectedValueException;

class ProductCsvHandlerService extends AbstractCsvHandler
{
    private const CODE_INDEX         = 0;
    private const NAME_INDEX         = 1;
    private const DESCRIPTION_INDEX  = 2;
    private const STOCK_INDEX        = 3;
    private const COST_INDEX         = 4;
    private const DISCONTINUED_INDEX = 5;

    private const PRICE_OVER = 1000;
    private const PRICE_LESS = 5;
    private const STOCK_LESS = 10;

    /**
     * @param string $file
     * @param bool $isTest
     * @return ProductCsvHandlerInfo
     * @throws Exception
     */
    public function handle(string $file, bool $isTest): ProductCsvHandlerInfo
    {
        $csvSheet = $this->getCsvSheet($file);

        // Check is empty csv file.
        if (empty($csvSheet->getCoordinates())) {
            throw new UnexpectedValueException('Empty file.');
        }

        $csvArray = $csvSheet->toArray($file);

        $importFailureRows = [];
        // -1 that means minus titles row.
        $importCount = count($csvArray) - 1;
        $importSuccessCount = 0;
        $importMissedCount = 0;

        $productRep = $this->entityManager->getRepository(Product::class);

        for ($i = 1; $i <= $importCount; $i++) {

            $code = $csvArray[$i][self::CODE_INDEX];

            // Checking on having current product by code
            if ($productRep->findOneBy(['code' => $code])) {
                continue;
            }

            $stock        = $csvArray[$i][self::STOCK_INDEX];
            $cost         = $csvArray[$i][self::COST_INDEX];
            $name         = $csvArray[$i][self::NAME_INDEX];
            $description  = $csvArray[$i][self::DESCRIPTION_INDEX];
            $discontinued = $csvArray[$i][self::DISCONTINUED_INDEX];

            // Checking is correct type of fields
            if (!is_string($code) || !is_string($name) || !is_string($description) ||
                !is_int($stock) || !is_float($cost)) {
                $importFailureRows[] = implode(',', $csvArray[$i]);
                continue;
            }

            // Checking price and stock how is in the business logic.
            if (($cost < self::PRICE_LESS && $stock < self::STOCK_LESS) || $cost > self::PRICE_OVER) {
                $importMissedCount++;
                continue;
            }

            // Creating the new Product.
            $productData = new Product();

            $productData->setName($name)->setDescription($description)->setCode($code)
                ->setPrice($cost)->setStockLevel($stock);

            // Check if discontinued so we set current date.
            if (!empty($discontinued) && $discontinued === 'yes') {
                $productData->setDiscontinuedAt(new DateTime());
            }

            $this->entityManager->persist($productData);

            $importSuccessCount++;
        }

        // If option `test` is true - we don't save products
        if (!$isTest) {
            $this->entityManager->flush();
        }

        $productHandlerInfo = new ProductCsvHandlerInfo();

         return $productHandlerInfo->setImportRowsCount($importCount)->setImportRowsSuccessCount($importSuccessCount)
            ->setImportRowsMissedCount($importMissedCount)->setImportFailureRows($importFailureRows);
    }
}