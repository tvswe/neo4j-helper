<?php declare(strict_types=1);

namespace Tvswe\Neo4j\Entity;

abstract class AbstractNeo4jEntity implements Neo4jEntityInterface
{
    /** @var int|null */
    private $id;

    /**
     * AbstractNeo4jEntity constructor.
     * @param int|null $id
     */
    public function __construct(int $id = null)
    {
        $this->id = $id;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return array
     */
    public function getProperties(): array
    {
        return [];
    }
}
