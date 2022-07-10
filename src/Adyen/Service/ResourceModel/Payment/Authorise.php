<?php

namespace Adyen\Service\ResourceModel\Payment;

class Authorise extends \Adyen\Service\AbstractResource
{
    /**
     * @var string
     */
    protected $endpoint;

    /**
     * Include applicationInfo key in the request parameters
     *
     * @var bool
     */
    protected $allowApplicationInfo = true;

    /**
     * Authorise constructor.
     *
     * @param \Adyen\Service $service
     */
    public function __construct($service)
    {
        $this->endpoint = $service->getConfiguration()->getConfig()->get('endpoint') .
            '/pal/servlet/Payment/' . $service->getConfiguration()->getApiPaymentVersion() . '/authorise';
        parent::__construct($service, $this->endpoint, $this->allowApplicationInfo);
    }
}
