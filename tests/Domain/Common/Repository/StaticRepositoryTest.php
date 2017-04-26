<?php

namespace App\Tests\Domain\Common\Repository;

use App\Tests\AbstractTestCase as TestCase;
use App\Tests\Domain\Common\Repository\Fixtures\SampleEntity;
use App\Tests\Domain\Common\Repository\Fixtures\SampleRepository;
use Illuminate\Contracts\Config\Repository as Config;
use Mockery;

/**
 * @group domain
 * @group domain.common
 * @group domain.common.repository
 * @group domain.common.repository.static
 */
class StaticRepositoryTest extends TestCase
{
    private function getSampleEntities()
    {
        return [
            'id-1' => [
                'title' => 'Title One',
            ],
            'id-2' => [
                'title' => 'Title Two',
            ],
            'id-3' => [
                'title' => 'Title Three',
            ],
            'id-4' => [
                'title' => 'Title Four',
            ],
        ];
    }

    private function getSampleRepository($entities = [])
    {
        $config = Mockery::mock(Config::class);
        $config
            ->shouldReceive('get')
            ->with('sample.entities', [])
            ->andReturn($entities)
            ->once();

        return new SampleRepository($config);
    }

    public function testEmpty()
    {
        $repository = $this->getSampleRepository();

        $this->assertEquals(0, $repository->getCount());
        $this->assertCount(0, $repository->getAll());
    }

    public function testGetAll()
    {
        $repository = $this->getSampleRepository(
            $this->getSampleEntities()
        );

        $entities = $repository->getAll();

        foreach ($entities as $id => $entity) {
            $this->assertInstanceOf(SampleEntity::class, $entity);
        }

        $this->assertCount(4, $entities);
    }

    public function testGetLimit()
    {
        $repository = $this->getSampleRepository(
            $this->getSampleEntities()
        );

        $entities = $repository->getLimit(2);

        foreach ($entities as $id => $entity) {
            $this->assertInstanceOf(SampleEntity::class, $entity);
        }

        $this->assertCount(2, $entities);
    }

    public function testGetFirst()
    {
        $repository = $this->getSampleRepository(
            $this->getSampleEntities()
        );

        $entity = $repository->getFirst();

        $this->assertInstanceOf(SampleEntity::class, $entity);
        $this->assertEquals($entity->getId(), 'id-1');
    }

    public function testGetLast()
    {
        $repository = $this->getSampleRepository(
            $this->getSampleEntities()
        );

        $entity = $repository->getLast();

        $this->assertInstanceOf(SampleEntity::class, $entity);
        $this->assertEquals($entity->getId(), 'id-4');
    }

    public function testGetById()
    {
        $repository = $this->getSampleRepository(
            $this->getSampleEntities()
        );

        $this->assertInstanceOf(SampleEntity::class, $repository->getById('id-1'));
    }

    /**
     * @expectedException \App\Domain\Common\Exception\EntityNotFoundException
     * @expectedExceptionMessage Unable to find entity "does-not-exist"
     */
    public function testGetByIdThrowsExceptionWhenNotFound()
    {
        $repository = $this->getSampleRepository(
            $this->getSampleEntities()
        );

        $repository->getById('does-not-exist');
    }

    public function testGetByIds()
    {
        $entityIds = ['id-1', 'id-4'];

        $repository = $this->getSampleRepository(
            $this->getSampleEntities()
        );

        $entities = $repository->getByIds($entityIds);

        $this->assertInternalType('array', $entities);
        $this->assertEquals(array_keys($entities), $entityIds);
        $this->assertCount(2, $entities);
    }

    /**
     * @expectedException \App\Domain\Common\Exception\EntityNotFoundException
     * @expectedExceptionMessage Unable to find entity "not"
     */
    public function testGetByIdsThrowExceptionWhenNotFound()
    {
        $entityIds = ['not', 'found'];

        $repository = $this->getSampleRepository(
            $this->getSampleEntities()
        );

        $repository->getByIds($entityIds);
    }

    public function testGetCount()
    {
        $repository = $this->getSampleRepository(
            $this->getSampleEntities()
        );

        $this->assertCount(4, $repository->getAll());
    }
}
