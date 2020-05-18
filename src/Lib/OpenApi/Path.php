<?php

namespace SwaggerBake\Lib\OpenApi;

use JsonSerializable;

/**
 * Class Path
 * @package SwaggerBake\Lib\OpenApi
 * @see https://swagger.io/docs/specification/paths-and-operations/
 */
class Path implements JsonSerializable
{
    /**
     * The endpoint (resource) for the path
     * @var string
     */
    private $resource = '';

    /**
     * @var Operation[]
     */
    private $operations = [];

    public function toArray(): array
    {
        $vars = get_object_vars($this);
        unset($vars['resource']);
        unset($vars['operations']);

        foreach ($this->getOperations() as $operation) {
            $vars[strtolower($operation->getHttpMethod())] = $operation;
        }

        return $vars;
    }

    /**
     * @return array|mixed
     */
    public function jsonSerialize()
    {
        return $this->toArray();
    }

    /**
     * @return string
     */
    public function getResource(): string
    {
        return $this->resource;
    }

    /**
     * @param string $resource
     * @return Path
     */
    public function setResource(string $resource): Path
    {
        $this->resource = $resource;
        return $this;
    }

    /**
     * @return Operation[]
     */
    public function getOperations(): array
    {
        return $this->operations;
    }

    /**
     * @param Operation[] $operations
     * @return Path
     */
    public function setOperations(array $operations): Path
    {
        $this->operations = [];
        foreach ($operations as $operation) {
            $this->pushOperation($operation);
        }
        return $this;
    }

    /**
     * @param Operation $operation
     * @return $this
     */
    public function pushOperation(Operation $operation) : Path
    {
        $httpMethod = strtolower($operation->getHttpMethod());
        $this->operations[$httpMethod] = $operation;
        return $this;
    }
}
