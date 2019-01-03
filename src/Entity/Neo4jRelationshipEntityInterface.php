<?php declare(strict_types=1);

namespace Tvswe\Neo4j\Entity;

use GraphAware\Common\Type\Relationship;

/**
 * Interface Neo4jRelationshipEntityInterface
 * @package Tvswe\Neo4j\Entity
 */
interface Neo4jRelationshipEntityInterface extends Neo4jEntityInterface
{
    /**
     * @param Relationship $relationship
     * @return Neo4jRelationshipEntityInterface
     */
    public static function createByRelationship(Relationship $relationship);
}
