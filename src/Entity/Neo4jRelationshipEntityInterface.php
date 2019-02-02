<?php declare(strict_types=1);

namespace Tvswe\Neo4j\Entity;

use GraphAware\Common\Type\Relationship as Neo4jRelationship;

/**
 * Interface Neo4jRelationshipEntityInterface
 * @package Tvswe\Neo4j\Entity
 */
interface Neo4jRelationshipEntityInterface extends Neo4jEntityInterface
{
    /**
     * @param Neo4jRelationship $relationship
     * @param Neo4jNodeEntityInterface $from
     * @param Neo4jNodeEntityInterface $to
     * @return Neo4jRelationshipEntityInterface
     */
    public static function createByRelationship(
        Neo4jRelationship $relationship,
        Neo4jNodeEntityInterface $from,
        Neo4jNodeEntityInterface $to
    ): Neo4jRelationshipEntityInterface;

    /**
     * @return Neo4jNodeEntityInterface
     */
    public function getFrom(): Neo4jNodeEntityInterface;

    /**
     * @return Neo4jNodeEntityInterface
     */
    public function getTo(): Neo4jNodeEntityInterface;

    /**
     * @return string
     */
    public static function getType(): string;
}
