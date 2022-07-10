<?php

namespace Adyen\Service;

use Adyen\Service;

class AbstractCheckoutResource extends AbstractResource
{
    /**
     * Return Checkout endpoint
     *
     * @param Service $service
     * @return mixed
     * @throws \Adyen\AdyenException
     */
    public function getCheckoutEndpoint(Service $service)
    {
        // check if endpoint is set
        if ($service->getConfiguration()->get('endpointCheckout') == null) {
            $logger = $service->getConfiguration()->getLogger();
            $msg = 'Please provide your unique live url prefix on the' .
                ' setEnvironment() call on the Client or provide endpointCheckout' .
                ' in your config object.';
            $logger->error($msg);
            throw new \Adyen\AdyenException($msg);
        }

        return $service->getConfiguration()->get('endpointCheckout');
    }
}
