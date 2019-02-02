<?php declare(strict_types=1);

namespace Tvswe\Neo4j\Entity;

use GraphAware\Common\Type\Relationship as Neo4jRelationship;

abstract class AbstractNeo4jRelationshipEntity extends AbstractNeo4jEntity implements Neo4jRelationshipEntityInterface
{
    /** @var Neo4jNodeEntityInterface */
    private $from;

    /** @var Neo4jNodeEntityInterface */
    private $to;

    /**
     * AbstractNeo4jRelationshipEntity constructor.
     * @param Neo4jNodeEntityInterface $from
     * @param Neo4jNodeEntityInterface $to
     * @param int|null $id
     */
    public function __construct(Neo4jNodeEntityInterface $from, Neo4jNodeEntityInterface $to, int $id = null)
    {
        parent::__construct($id);

        $this->from = $from;
        $this->to = $to;
    }

    /**
     * @param Neo4jRelationship $relationship
     * @param Neo4jNodeEntityInterface $from
     * @param Neo4jNodeEntityInterface $to
     * @return AbstractNeo4jRelationshipEntity|Neo4jRelationshipEntityInterface
     */
    public static function createByRelationship(
        Neo4jRelationship $relationship,
        Neo4jNodeEntityInterface $from,
        Neo4jNodeEntityInterface $to
    ): Neo4jRelationshipEntityInterface {
        return new static($from, $to, $relationship->identity());
    }

    /**
     * @return Neo4jNodeEntityInterface
     */
    public function getFrom(): Neo4jNodeEntityInterface
    {
        return $this->from;
    }

    /**
     * @return Neo4jNodeEntityInterface
     */
    public function getTo(): Neo4jNodeEntityInterface
    {
        return $this->to;
    }

    /**
     * @return string
     */
    public abstract static function getType(): string;
}
