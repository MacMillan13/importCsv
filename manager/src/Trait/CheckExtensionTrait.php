<?php
declare(strict_types=1);

namespace App\Trait;

use DomainException;

trait CheckExtensionTrait
{
    /**
     * @throws DomainException
     */
    public function checkExtension(string $file, string $format): void
    {
        $arrFile = explode('.', $file);

        $extension = end($arrFile);

        if ($extension !== $format) {
            throw new DomainException('Please select the file with correct type.');
        }
    }
}