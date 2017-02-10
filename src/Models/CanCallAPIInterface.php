<?php

namespace Esier\Models;

use Esier\Manager;

interface CanCallAPIInterface
{
    public function __construct(Manager $manager, array $args);

    private function call();
}
