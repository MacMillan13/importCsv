<?php
declare(strict_types=1);

namespace App\Dto;

class ProductCsvHandlerInfo
{
    /**
     * @var int
     */
    private int $importRowsCount;

    /**
     * @var int
     */
    private int $importRowsSuccessCount;


    /**
     * @var int
     */
    private int $importRowsMissedCount;

    /**
     * @var array
     */
    private array $importFailureRows;

    /**
     * @param int $importRowsCount
     * @return $this
     */
    public function setImportRowsCount(int $importRowsCount): self
    {
        $this->importRowsCount = $importRowsCount;

        return $this;
    }

    /**
     * @return int
     */
    public function getImportRowsCount(): int
    {
        return $this->importRowsCount;
    }

    /**
     * @param int $importRowsSuccessCount
     * @return $this
     */
    public function setImportRowsSuccessCount(int $importRowsSuccessCount): self
    {
        $this->importRowsSuccessCount = $importRowsSuccessCount;

        return $this;
    }

    /**
     * @return int
     */
    public function getImportRowsSuccessCount(): int
    {
        return $this->importRowsSuccessCount;
    }


    /**
     * @param int $importRowsMissedCount
     * @return $this
     */
    public function setImportRowsMissedCount(int $importRowsMissedCount): self
    {
        $this->importRowsMissedCount = $importRowsMissedCount;

        return $this;
    }

    /**
     * @return int
     */
    public function getImportRowsMissedCount(): int
    {
        return $this->importRowsMissedCount;
    }

    /**
     * @return int
     */
    public function getImportRowsFailureCount(): int
    {
        return count($this->getImportFailureRows());
    }

    /**
     * @param array $importFailureRows
     * @return $this
     */
    public function setImportFailureRows(array $importFailureRows): self
    {
        $this->importFailureRows = $importFailureRows;

        return $this;
    }

    /**
     * @return array
     */
    public function getImportFailureRows(): array
    {
        return $this->importFailureRows;
    }
}