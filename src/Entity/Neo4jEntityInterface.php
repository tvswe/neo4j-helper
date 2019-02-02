<?php declare(strict_types=1);

namespace Tvswe\Neo4j\Entity;

/**
 * Interface Neo4jNodeEntityInterface
 * @package Tvswe\Neo4j\Entity
 */
interface Neo4jEntityInterface
{
    /**
     * @return int|null
     */
    public function getId(): ?int;

    /**
     * @return array
     */
    public function getProperties(): array;
}
