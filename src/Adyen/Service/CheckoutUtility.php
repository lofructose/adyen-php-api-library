<?php

namespace Adyen\Service;

use Adyen\ApiKeyAuthenticated;
use Adyen\Service;

class CheckoutUtility extends Service
{
    use ApiKeyAuthenticated;

    /**
     * @var ResourceModel\CheckoutUtility\OriginKeys
     */
    protected $originKeys;

    /**
     * CheckoutUtility constructor.
     *
     * @param \Adyen\APIConfiguration $APIConfiguration
     * @throws \Adyen\AdyenException
     */
    public function __construct(\Adyen\APIConfiguration $APIConfiguration)
    {
        parent::__construct($APIConfiguration);
        $this->originKeys = new \Adyen\Service\ResourceModel\CheckoutUtility\OriginKeys($this);
    }

    /**
     * @param $params
     * @return mixed
     * @throws \Adyen\AdyenException
     */
    public function originKeys($params)
    {
        $result = $this->originKeys->request($params);
        return $result;
    }
}
