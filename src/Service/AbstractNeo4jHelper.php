<?php declare(strict_types=1);

namespace Tvswe\Neo4j\Service;

use GraphAware\Common\Result\Result;
use GraphAware\Neo4j\Client\ClientInterface;

abstract class AbstractNeo4jHelper
{
    /** @var ClientInterface */
    private $neo4jClient;

    public function __construct(ClientInterface $neo4jClient)
    {
        $this->neo4jClient = $neo4jClient;
    }

    protected function Client(): ClientInterface
    {
        return $this->neo4jClient;
    }

    /**
     * @param string $cypherQuery
     * @param mixed ...$params
     * @return Result
     */
    public function run(string $cypherQuery, ...$params): Result
    {
        $query = sprintf($cypherQuery, ...$params);

        return $this->neo4jClient->run($query);
    }
}
