<?php

namespace Adyen\Service;

class Recurring extends \Adyen\Service
{
    /**
     * @var ResourceModel\Recurring\ListRecurringDetails
     */
    protected $listRecurringDetails;

    /**
     * @var ResourceModel\Recurring\Disable
     */
    protected $disable;

    /**
     * @var ResourceModel\Recurring\NotifyShopper
     */
    protected $notifyShopper;

    /**
     * Recurring constructor.
     *
     * @param \Adyen\APIConfiguration $APIConfiguration
     * @throws \Adyen\AdyenException
     */
    public function __construct(\Adyen\APIConfiguration $APIConfiguration)
    {
        parent::__construct($APIConfiguration);
        $this->listRecurringDetails = new \Adyen\Service\ResourceModel\Recurring\ListRecurringDetails($this);
        $this->notifyShopper = new \Adyen\Service\ResourceModel\Recurring\NotifyShopper($this);
        $this->disable = new \Adyen\Service\ResourceModel\Recurring\Disable($this);
    }

    /**
     * @param $params
     * @return mixed
     * @throws \Adyen\AdyenException
     */
    public function listRecurringDetails($params)
    {
        $result = $this->listRecurringDetails->request($params);
        return $result;
    }

    /**
     * @param $params
     * @return mixed
     * @throws \Adyen\AdyenException
     */
    public function notifyShopper($params)
    {
        $result = $this->notifyShopper->request($params);
        return $result;
    }
    /**
     * @param $params
     * @return mixed
     * @throws \Adyen\AdyenException
     */
    public function disable($params)
    {
        $result = $this->disable->request($params);
        return $result;
    }
}
