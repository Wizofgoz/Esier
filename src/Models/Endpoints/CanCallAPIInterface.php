<?php

namespace Esier\Models\Endpoints;

interface CanCallAPIInterface
{
    protected $manager;

    protected $requiredScopes;

    public function __construct();
}
