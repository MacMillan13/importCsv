<?php
declare(strict_types=1);

namespace App\Tests\Unit\Service;

use App\Service\CsvHandlers\ProductCsvHandlerService;
use App\Tests\Unit\DatabaseInitTrait;
use LogicException;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use UnexpectedValueException;

class ProductCsvHandlerServiceTest extends KernelTestCase
{
    use DatabaseInitTrait;

    private ProductCsvHandlerService $productCsvHandlerService;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();

        $this->checkIsTestEnvironment($kernel);

        $container = static::getContainer();

        $this->productCsvHandlerService = $container->get(ProductCsvHandlerService::class);

        $this->initDatabase($kernel);
    }

    /**
     * @throws \Exception
     */
    public function testHandle(): void
    {
        $handle = $this->productCsvHandlerService->handle('stock.csv', true);

        $this->assertEquals(29, $handle->getImportRowsCount());
        $this->assertEquals(15, $handle->getImportRowsSuccessCount());
        $this->assertEquals(2, $handle->getImportRowsMissedCount());
        $this->assertEquals(12, $handle->getImportRowsFailureCount());

        $this->expectException(UnexpectedValueException::class);
        $this->productCsvHandlerService->handle('tests/file/test.csv', true);
    }
}