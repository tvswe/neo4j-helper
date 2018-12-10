<?php declare(strict_types=1);

namespace Tvswe\Neo4j\Entity;

use GraphAware\Common\Type\Node;

interface Neo4jNodeEntityInterface
{
    public static function createByNode(Node $node);
}
