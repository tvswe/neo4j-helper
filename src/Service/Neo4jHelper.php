<?php declare(strict_types=1);

namespace Tvswe\Neo4j\Service;

use GraphAware\Common\Type\Node;
use GraphAware\Common\Result\Result;
use GraphAware\Neo4j\Client\ClientBuilder;
use GraphAware\Neo4j\Client\ClientInterface;
use Tvswe\Neo4j\Entity\Neo4jEntityInterface;
use Tvswe\Neo4j\Entity\Neo4jNodeEntityInterface;
use Tvswe\Neo4j\Entity\Neo4jRelationshipEntityInterface;

class Neo4jHelper extends AbstractNeo4jHelper
{
    /** @var Neo4jNodeHelper */
    private $nodeHelper;

    /** @var Neo4jRelationshipHelper */
    private $relationshipHelper;

    /**
     * Neo4jClient constructor.
     * @param array $connections
     */
    public function __construct(array $connections)
    {
        parent::__construct($this->initNeo4jClient($connections));

        $this->nodeHelper = new Neo4jNodeHelper($this->Client());
        $this->relationshipHelper = new Neo4jRelationshipHelper($this->Client());
    }

    private function initNeo4jClient(array $connections)
    {
        $clientBuilder = ClientBuilder::create();

        foreach ($connections as $alias => $url) {
            $clientBuilder->addConnection($alias, $url);
        }

        return $clientBuilder->build();
    }

    /**
     * @return Neo4jNodeHelper
     */
    public function Node(): Neo4jNodeHelper
    {
        return $this->nodeHelper;
    }

    /**
     * @return Neo4jRelationshipHelper
     */
    public function Relationship(): Neo4jRelationshipHelper
    {
        return $this->relationshipHelper;
    }
}
