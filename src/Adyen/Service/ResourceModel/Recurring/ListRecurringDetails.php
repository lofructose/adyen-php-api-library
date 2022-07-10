<?php

namespace Adyen\Service\ResourceModel\Recurring;

class ListRecurringDetails extends \Adyen\Service\AbstractResource
{
    /**
     * @var string
     */
    protected $endpoint;

    /**
     * ListRecurringDetails constructor.
     *
     * @param \Adyen\Service $service
     */
    public function __construct($service)
    {
        $this->endpoint = $service->getConfiguration()->getConfig()->get('endpoint') .
            '/pal/servlet/Recurring/' . $service->getConfiguration()->getApiRecurringVersion() . '/listRecurringDetails';
        parent::__construct($service, $this->endpoint);
    }
}
