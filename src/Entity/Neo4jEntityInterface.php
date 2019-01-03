<?php declare(strict_types=1);

namespace Tvswe\Neo4j\Entity;

/**
 * Interface Neo4jEntityInterface
 * @package Tvswe\Neo4j\Entity
 */
interface Neo4jEntityInterface
{
    /**
     * @return string[]
     */
    public static function getLabels(): array;

    /**
     * @return array
     */
    public function getProperties(): array;
}
