<?php

namespace Esier\Models\Endpoints;

use Esier\Exceptions\InvalidFunctionNameException;

trait ChecksScopes
{
    protected function checkScope(string $functionName): bool
    {
        if (!isset($this->requiredScopes[$functionName])) {
            throw new InvalidFunctionNameException('That function is not mapped for this class');
        }

        return in_array($this->requiredScopes[$functionName], $this->manager->getAuthedScopes());
    }
}
