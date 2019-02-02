<?php declare(strict_types=1);

namespace Tvswe\Neo4j\Entity;

use GraphAware\Common\Type\Node;

/**
 * Interface Neo4jNodeEntityInterface
 * @package Tvswe\Neo4j\Entity
 */
interface Neo4jNodeEntityInterface extends Neo4jEntityInterface
{
    /**
     * @param Node $node
     * @return Neo4jNodeEntityInterface
     */
    public static function createByNode(Node $node): Neo4jNodeEntityInterface;

    /**
     * @return string[]
     */
    public static function getLabels(): array;
}
