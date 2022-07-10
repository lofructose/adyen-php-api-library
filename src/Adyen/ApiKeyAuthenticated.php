<?php

namespace Adyen;

trait ApiKeyAuthenticated
{
    /**
     * @var bool
     */
    protected $requiresApiKey = true;
}
