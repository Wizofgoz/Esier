<?php

namespace Esier\Core;

use Esier\Core\Manager;

interface CanCallAPIInterface
{
    public function __construct(Manager $manager, array $args);

    private function call();
}
