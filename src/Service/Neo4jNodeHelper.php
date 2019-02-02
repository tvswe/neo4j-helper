<?php declare(strict_types=1);

namespace Tvswe\Neo4j\Service;

use GraphAware\Common\Type\Node;
use GraphAware\Common\Result\Result;
use GraphAware\Neo4j\Client\ClientBuilder;
use GraphAware\Neo4j\Client\ClientInterface;
use Tvswe\Neo4j\Entity\Neo4jEntityInterface;
use Tvswe\Neo4j\Entity\Neo4jNodeEntityInterface;
use Tvswe\Neo4j\Entity\Neo4jRelationshipEntityInterface;
use Tvswe\Neo4j\Exception\RequireNeo4jNodeEntityClassException;

class Neo4jNodeHelper extends AbstractNeo4jHelper implements Neo4jHelperInterface
{
    private const CREATE_QUERY = 'CREATE (node%s %s) RETURN node';
    private const FIND_ALL_QUERY = 'MATCH (node%s) RETURN node';
    private const FIND_ONE_BY_ID_QUERY = 'MATCH (node) WHERE id(node) = %d RETURN node';
    private const FIND_ONE_BY_PROPERTIES_QUERY = 'MATCH (node%s %s) RETURN node';
    private const UPDATE_QUERY = 'MATCH (node%s) WHERE id(node) = %d SET %s RETURN node';
    private const DELETE_QUERY = 'DELETE (node) WHERE id(node) = %d';

    /**
     * @param Neo4jEntityInterface|Neo4jNodeEntityInterface $nodeEntity
     * @return Neo4jEntityInterface|Neo4jNodeEntityInterface|null
     */
    public function create(Neo4jEntityInterface $nodeEntity): ?Neo4jEntityInterface
    {
        if (!$nodeEntity instanceof Neo4jNodeEntityInterface) {
            return null;
        }

        $labels = $this->getLabelsString($nodeEntity::getLabels());
        $properties = $this->getPropertiesCreateString($nodeEntity->getProperties());
        $result = $this->run(self::CREATE_QUERY, $labels, $properties);
        $node = $this->getNodeFromResult($result);

        return $node ? $nodeEntity::createByNode($node) : null;
    }

    /**
     * @param string $entityClass
     * @return Neo4jNodeEntityInterface[]
     */
    public function findAll(string $entityClass): array
    {
        if (!$this->isNeo4jNodeEntityClass($entityClass)) {
            throw new RequireNeo4jNodeEntityClassException();
        }

        /** @var Neo4jNodeEntityInterface $entityClass */
        $labels = $this->getLabelsString($entityClass::getLabels());
        $result = $this->run(self::FIND_ALL_QUERY, $labels);
        $records = $result->records();
        $entities = [];

        foreach ($records as $record) {
            $node = $record->nodeValue('node');
            $entities[$node->identity()] = $entityClass::createByNode($node);
        }

        return $entities;
    }

    /**
     * @param int $id
     * @param string $entityClass
     * @return Neo4jEntityInterface|null
     */
    public function findOneById(int $id, string $entityClass): ?Neo4jEntityInterface
    {
        if (!$this->isNeo4jNodeEntityClass($entityClass)) {
            throw new RequireNeo4jNodeEntityClassException();
        }

        /** @var Neo4jNodeEntityInterface $entityClass */
        $result = $this->run(self::FIND_ONE_BY_ID_QUERY, $id);
        $node = $this->getNodeFromResult($result);

        return $node ? $entityClass::createByNode($node) : null;
    }

    /**
     * @param array $properties
     * @param string $entityClass
     * @return Neo4jEntityInterface|null
     */
    public function findOneByProperties(array $properties, string $entityClass): ?Neo4jEntityInterface
    {
        if (!$this->isNeo4jNodeEntityClass($entityClass)) {
            throw new RequireNeo4jNodeEntityClassException();
        }

        /** @var Neo4jNodeEntityInterface $entityClass */
        $labels = $this->getLabelsString($entityClass::getLabels());
        $properties = $this->getPropertiesCreateString($properties);
        $result = $this->run(self::FIND_ONE_BY_PROPERTIES_QUERY, $labels, $properties);

        return $this->getNodeFromResult($result);
    }

    public function update(Neo4jEntityInterface $nodeEntity): ?Neo4jEntityInterface
    {
        if (!$nodeEntity instanceof Neo4jNodeEntityInterface) {
            return null;
        }

        $labels = $this->getLabelsString($nodeEntity::getLabels());
        $properties = $this->getPropertiesUpdateString($nodeEntity->getProperties());
        $result = $this->run(self::UPDATE_QUERY, $labels, $nodeEntity->getId(), $properties);
        $node = $this->getNodeFromResult($result);

        return $node ? $nodeEntity::createByNode($node) : null;
    }

    public function remove(Neo4jEntityInterface $nodeEntity)
    {
        if (!$nodeEntity instanceof Neo4jNodeEntityInterface) {
            return null;
        }

        $result = $this->run(self::DELETE_QUERY, $nodeEntity->getId());
    }

    /**
     * @param string $entityClass
     * @return bool
     */
    private function isNeo4jNodeEntityClass(string $entityClass): bool
    {
        $interfaces = class_implements($entityClass);

        return is_array($interfaces) && in_array(Neo4jNodeEntityInterface::class, $interfaces);
    }

    /**
     * @param Result $result
     * @param string $alias
     * @return Node|null
     */
    private function getNodeFromResult(Result $result, $alias = 'node'): ?Node
    {
        $record = $result->firstRecordOrDefault(null);

        return $record ? $record->nodeValue($alias) : null;
    }

    /**
     * @param array $labels
     * @return string
     */
    private function getLabelsString(array $labels): string
    {
        return ':' . implode(':', $labels);
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

    private function getPropertiesUpdateString(array $properties): string
    {
        $sets = [];

        foreach ($properties as $property => $value) {
            if (is_string($value)) {
                $value = '"'.$value.'"';
            }

            $sets[] = 'node.'.$property.' = '.$value;
        }

        return implode(', ', $sets);
    }
}
