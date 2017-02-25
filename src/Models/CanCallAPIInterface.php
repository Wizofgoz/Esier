<?php

namespace Esier\Models;

interface CanCallAPIInterface
{
    protected $manager;

    protected $requiredScopes;

    public function __construct();
}
