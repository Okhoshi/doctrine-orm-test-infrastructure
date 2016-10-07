<?php

namespace Webfactory\Doctrine\Config;

use Webfactory\Doctrine\ORMTestInfrastructure\ORMInfrastructure;
use Webfactory\Doctrine\ORMTestInfrastructure\ORMInfrastructureTest\TestEntity;

class FileDatabaseConnectionConfigurationTest extends \PHPUnit_Framework_TestCase
{
    public function testKeepsProvidedFilePath()
    {
        $path = __DIR__ . '/_files/my-db.sqlite';
        $configuration = new FileDatabaseConnectionConfiguration($path);

        $this->assertEquals($path, $configuration->getDatabaseFile());
    }

    public function testGeneratedFileNameIsNotChangedForExistingConfigurationObject()
    {
        $configuration = new FileDatabaseConnectionConfiguration();

        $this->assertEquals($configuration->getDatabaseFile(), $configuration->getDatabaseFile());
    }

    public function testGeneratesUniqueFileNameIfFilePathIsOmitted()
    {
        $firstConfiguration = new FileDatabaseConnectionConfiguration();
        $secondConfiguration = new FileDatabaseConnectionConfiguration();

        $this->assertNotEquals($firstConfiguration->getDatabaseFile(), $secondConfiguration->getDatabaseFile());
    }

    public function testCleanUpRemovesTheDatabaseFileIfItExists()
    {
        $configuration = new FileDatabaseConnectionConfiguration();
        touch($configuration->getDatabaseFile());

        $configuration->cleanUp();

        $this->assertFileNotExists($configuration->getDatabaseFile());
    }

    public function testCleanUpDoesNothingIfTheDatabaseFileDoesNotExistYet()
    {
        $configuration = new FileDatabaseConnectionConfiguration();

        $this->assertFileNotExists($configuration->getDatabaseFile());

        $this->setExpectedException(null);
        $configuration->cleanUp();
    }

    /**
     * Checks if the connection configuration *really* works with the infrastructure.
     */
    public function testWorksWithInfrastructure()
    {
        $configuration = new FileDatabaseConnectionConfiguration();
        $infrastructure = $this->createInfrastructure($configuration);

        $this->setExpectedException(null);
        $infrastructure->import(new TestEntity());
    }

    public function testDatabaseFileIsCreated()
    {
        $configuration = new FileDatabaseConnectionConfiguration();

        $infrastructure = $this->createInfrastructure($configuration);
        $infrastructure->import(new TestEntity());

        $this->assertFileExists($configuration->getDatabaseFile());
    }

    /**
     * Creates a new infrastructure with the given connection configuration.
     *
     * @param ConnectionConfiguration $configuration
     * @return ORMInfrastructure
     */
    private function createInfrastructure(ConnectionConfiguration $configuration)
    {
        $infrastructure = ORMInfrastructure::createOnlyFor(
            array(
                'Webfactory\Doctrine\ORMTestInfrastructure\ORMInfrastructureTest\TestEntity'
            ),
            $configuration
        );
        return $infrastructure;
    }
}
