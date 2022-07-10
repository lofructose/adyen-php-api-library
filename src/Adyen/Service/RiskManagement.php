<?php

namespace Adyen\Service;

class RiskManagement extends \Adyen\Service
{
    /**
     * @var ResourceModel\RiskManagement\SubmitReferrals
     */
    protected $submitReferrals;

    /**
     * RiskManagement constructor.
     *
     * @param \Adyen\APIConfiguration $APIConfiguration
     * @throws \Adyen\AdyenException
     */
    public function __construct(\Adyen\APIConfiguration $APIConfiguration)
    {
        parent::__construct($APIConfiguration);
        $this->submitReferrals = new \Adyen\Service\ResourceModel\RiskManagement\SubmitReferrals($this);
    }

    /**
     * @param $params
     * @param null $requestOptions
     * @return mixed
     * @throws \Adyen\AdyenException
     */
    public function submitReferrals($params, $requestOptions = null)
    {
        return $this->submitReferrals->request($params, $requestOptions);
    }
}
