<?php declare(strict_types=1);

namespace Tvswe\Neo4j\Entity;

use GraphAware\Common\Type\Relationship;

interface Neo4jRelationshipEntityInterface
{
    public static function createByRelationship(Relationship $relationship);
}
