<?php

namespace Adyen\Service\ResourceModel\Recurring;

class Disable extends \Adyen\Service\AbstractResource
{
    /**
     * @var string
     */
    protected $endpoint;

    /**
     * Disable constructor.
     *
     * @param \Adyen\Service $service
     */
    public function __construct($service)
    {
        $this->endpoint = $service->getConfiguration()->getConfig()->get('endpoint') .
            '/pal/servlet/Recurring/' . $service->getConfiguration()->getApiRecurringVersion() . '/disable';
        parent::__construct($service, $this->endpoint);
    }
}
