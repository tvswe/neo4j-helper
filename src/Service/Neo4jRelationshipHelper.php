<?php declare(strict_types=1);

namespace Tvswe\Neo4j\Service;

use GraphAware\Common\Type\Node;
use GraphAware\Common\Result\Result;
use GraphAware\Common\Type\Relationship;
use GraphAware\Neo4j\Client\ClientBuilder;
use GraphAware\Neo4j\Client\ClientInterface;
use Tvswe\Neo4j\Entity\Neo4jEntityInterface;
use Tvswe\Neo4j\Entity\Neo4jNodeEntityInterface;
use Tvswe\Neo4j\Entity\Neo4jRelationshipEntityInterface;

class Neo4jRelationshipHelper extends AbstractNeo4jHelper implements Neo4jHelperInterface
{
    private const CREATE_QUERY = 'MATCH (from), (to) WHERE id(from) = %d AND id(to) = %d
                                  CREATE (from)-[relationship%s %s]->(to) RETURN relationship';

    public function create(Neo4jEntityInterface $relationshipEntity): ?Neo4jEntityInterface
    {
        if (!$relationshipEntity instanceof Neo4jRelationshipEntityInterface) {
            return null;
        }

        $from = $relationshipEntity->getFrom();
        $fromId = $from->getId();

        $to = $relationshipEntity->getTo();
        $toId = $to->getId();

        $label = ':' . $relationshipEntity::getType();
        $properties = $this->getPropertiesCreateString($relationshipEntity->getProperties());
        $result = $this->run(self::CREATE_QUERY, $fromId, $toId, $label, $properties);
        $relationship = $this->getRelationshipFromResult($result);

        return $relationship ? $relationshipEntity::createByRelationship($relationship, $from, $to) : null;
    }

    public function findAll(string $entityClass): array
    {
        // TODO: Implement findAll() method.
    }

    public function findOneById(int $id, string $entityClass): ?Neo4jEntityInterface
    {
        // TODO: Implement findOneById() method.
    }

    public function findOneByProperties(array $properties, string $entityClass): ?Neo4jEntityInterface
    {
        // TODO: Implement findOneByProperties() method.
    }

    public function update(Neo4jEntityInterface $entity): ?Neo4jEntityInterface
    {
        // TODO: Implement update() method.
    }

    public function remove(Neo4jEntityInterface $entity)
    {
        // TODO: Implement remove() method.
    }

    /**
     * @param string $entityClass
     * @return bool
     */
    private function isNeo4jRelationshipEntityClass(string $entityClass): bool
    {
        $interfaces = class_implements($entityClass);

        return is_array($interfaces) && in_array(Neo4jRelationshipEntityInterface::class, $interfaces);
    }

    /**
     * @param Result $result
     * @param string $alias
     * @return Relationship|null
     */
    private function getRelationshipFromResult(Result $result, $alias = 'relationship'): ?Relationship
    {
        $record = $result->firstRecordOrDefault(null);

        return $record ? $record->relationshipValue($alias) : null;
    }

    /**
     * @param array $properties
     * @return string
     */
    private function getPropertiesCreateString(array $properties): string
    {
        if (!$properties) {
            return '';
        }

        $json = json_encode($properties);

        $regex = '/\"([a-z]\w+)\":/';

        return preg_replace($regex, ' $1: ', $json);
    }
}
