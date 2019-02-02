<?php declare(strict_types=1);

namespace Tvswe\Neo4j\Service;

use Tvswe\Neo4j\Entity\Neo4jEntityInterface;

interface Neo4jHelperInterface
{
    /**
     * @param Neo4jEntityInterface $entity
     * @return Neo4jEntityInterface|null
     */
    public function create(Neo4jEntityInterface $entity): ?Neo4jEntityInterface;

    /**
     * @param string $entityClass
     * @return Neo4jEntityInterface[]
     */
    public function findAll(string $entityClass): array;

    /**
     * @param int $id
     * @param string $entityClass
     * @return Neo4jEntityInterface|null
     */
    public function findOneById(int $id, string $entityClass): ?Neo4jEntityInterface;

    /**
     * @param array $properties
     * @param string $entityClass
     * @return Neo4jEntityInterface|null
     */
    public function findOneByProperties(array $properties, string $entityClass): ?Neo4jEntityInterface;

    /**
     * @param Neo4jEntityInterface $entity
     * @return Neo4jEntityInterface|null
     */
    public function update(Neo4jEntityInterface $entity): ?Neo4jEntityInterface;

    /**
     * @param Neo4jEntityInterface $entity
     * @return mixed
     */
    public function remove(Neo4jEntityInterface $entity);
}
