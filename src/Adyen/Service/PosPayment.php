<?php

namespace Adyen\Service;

use Adyen\ApiKeyAuthenticated;
use Adyen\Service;

class PosPayment extends Service
{
    use ApiKeyAuthenticated;

    /**
     * @var ResourceModel\Payment\TerminalCloudAPI
     */
    protected $runTenderSync;

    /**
     * @var ResourceModel\Payment\TerminalCloudAPI
     */
    protected $runTenderAsync;

    /**
     * @var
     */
    protected $txType;

    /**
     * @var ResourceModel\Payment\ConnectedTerminals
     */
    protected $connectedTerminals;

    /**
     * PosPayment constructor.
     *
     * @param \Adyen\APIConfiguration $APIConfiguration
     * @throws \Adyen\AdyenException
     */
    public function __construct(\Adyen\APIConfiguration $APIConfiguration)
    {
        parent::__construct($APIConfiguration);
        $this->runTenderSync = new \Adyen\Service\ResourceModel\Payment\TerminalCloudAPI($this, false);
        $this->runTenderAsync = new \Adyen\Service\ResourceModel\Payment\TerminalCloudAPI($this, true);
        $this->connectedTerminals = new \Adyen\Service\ResourceModel\Payment\ConnectedTerminals($this);
    }

    /**
     * @param $params
     * @return mixed
     * @throws \Adyen\AdyenException
     */
    public function runTenderSync($params)
    {
        $result = $this->runTenderSync->request($params);
        return $result;
    }

    /**
     * @param $params
     * @return mixed
     * @throws \Adyen\AdyenException
     */
    public function runTenderAsync($params)
    {
        $result = $this->runTenderAsync->request($params);
        return $result;
    }

    /**
     * @param $request
     * @return null
     */
    public function getServiceId($request)
    {
        if (isset($request['SaleToPOIRequest']['MessageHeader']['ServiceID'])) {
            return $request['SaleToPOIRequest']['MessageHeader']['ServiceID'];
        }
        return null;
    }

    /**
     * @param $params
     * @return mixed
     * @throws \Adyen\AdyenException
     */
    public function getConnectedTerminals($params)
    {
        $result = $this->connectedTerminals->request($params);
        return $result;
    }
}
