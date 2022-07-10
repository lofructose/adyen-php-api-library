<?php

namespace Adyen\Service\ResourceModel\Payout\ThirdParty;

class SubmitThirdParty extends \Adyen\Service\AbstractResource
{
    /**
     * @var string
     */
    protected $endpoint;

    /**
     * SubmitThirdParty constructor.
     *
     * @param \Adyen\Service $service
     */
    public function __construct($service)
    {
        $this->endpoint = $service->getConfiguration()->getConfig()->get('endpoint') .
            '/pal/servlet/Payout/' . $service->getConfiguration()->getApiPayoutVersion() . '/submitThirdParty';
        parent::__construct($service, $this->endpoint);
    }
}
