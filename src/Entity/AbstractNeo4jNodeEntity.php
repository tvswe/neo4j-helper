<?php declare(strict_types=1);

namespace Tvswe\Neo4j\Entity;

use GraphAware\Common\Type\Node;

abstract class AbstractNeo4jNodeEntity extends AbstractNeo4jEntity implements Neo4jNodeEntityInterface
{
    /**
     * AbstractNeo4jNodeEntity constructor.
     * @param int|null $id
     */
    public function __construct(int $id = null)
    {
        parent::__construct($id);
    }

    /**
     * @param Node $node
     * @return Neo4jNodeEntityInterface
     */
    public static function createByNode(Node $node): Neo4jNodeEntityInterface
    {
        return new static($node->identity());
    }

    /**
     * @return array
     */
    public abstract static function getLabels(): array;
}
