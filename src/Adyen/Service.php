<?php

namespace Adyen;

class Service
{
    /**
     * @var APIConfiguration
     */
    private $configuration;

    /**
     * @var bool
     */
    protected $requiresApiKey = false;

    /**
     * Service constructor.
     *
     * @param APIConfiguration $APIConfiguration
     * @throws AdyenException
     */
    public function __construct(\Adyen\APIConfiguration $APIConfiguration)
    {
        // validate if client has all the configuration we need
        if (!$APIConfiguration->getEnvironment()) {
            // throw exception
            $msg = 'The Client does not have a correct environment, use ' .
                \Adyen\Environment::TEST . ' or ' . \Adyen\Environment::LIVE;
            throw new \Adyen\AdyenException($msg);
        }

        $this->configuration = $APIConfiguration;
    }

    /**
     * @return APIConfiguration
     */
    public function getConfiguration(): APIConfiguration
    {
        return $this->configuration;
    }

    /**
     * @return bool
     */
    public function requiresApiKey()
    {
        return $this->requiresApiKey;
    }
}
