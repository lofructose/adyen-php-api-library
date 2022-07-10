<?php

namespace Adyen\Service\ResourceModel\Account;

use Adyen\Service;

class CheckAccountHolder extends \Adyen\Service\AbstractResource
{
    /**
     * @var string
     */
    protected $endpoint;

    /**
     *
     * @param Service $service
     */
    public function __construct($service)
    {
        $this->endpoint = $service->getConfiguration()->getConfig()->get('endpointAccount') .
            '/' . $service->getConfiguration()->getApiAccountVersion() . '/checkAccountHolder';
        parent::__construct($service, $this->endpoint);
    }
}
