<?php

namespace Adyen\Service\ResourceModel\DirectoryLookup;

class Directory extends \Adyen\Service\AbstractResource
{
    /**
     * @var string
     */
    protected $endpoint;

    /**
     * Directory constructor.
     * https://test.adyen.com/hpp/directory.shtml
     *
     * @param \Adyen\Service $service
     */
    public function __construct($service)
    {
        $this->endpoint = $service->getConfiguration()->getConfig()->get('endpointDirectoryLookup');
        parent::__construct($service, $this->endpoint);
    }
}
