<?php
declare(strict_types=1);

namespace App\Tests\Unit;

use Doctrine\ORM\Tools\SchemaTool;
use LogicException;
use Symfony\Component\HttpKernel\KernelInterface;

trait DatabaseInitTrait
{
    /**
     * @param KernelInterface $kernel
     * @return void
     */
    private function initDatabase(KernelInterface $kernel): void
    {
        $entityManager = $kernel->getContainer()->get('doctrine.orm.entity_manager');
        $metaData = $entityManager->getMetadataFactory()->getAllMetadata();

        $schemaTool = new SchemaTool($entityManager);
        $schemaTool->updateSchema($metaData);
    }

    private function checkIsTestEnvironment(KernelInterface $kernel)
    {
        if ('test' !== $kernel->getEnvironment()) {
            throw new LogicException('Execution DB only in Test environment possible!');
        }
    }
}