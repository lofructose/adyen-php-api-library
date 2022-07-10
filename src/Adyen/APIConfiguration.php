<?php

namespace Adyen;

use Adyen\HttpClient\ClientInterface;
use Adyen\HttpClient\CurlClient;
use Psr\Log\LoggerInterface;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class APIConfiguration
{
    const LIB_VERSION = "13.0.0";
    const LIB_NAME = "adyen-php-api-library";
    const USER_AGENT_SUFFIX = "adyen-php-api-library/";
    const ENDPOINT_TEST = "https://pal-test.adyen.com";
    const ENDPOINT_LIVE = "https://pal-live.adyen.com";
    const ENDPOINT_LIVE_SUFFIX = "-pal-live.adyenpayments.com";
    const ENDPOINT_TEST_DIRECTORY_LOOKUP = "https://test.adyen.com/hpp/directory/v2.shtml";
    const ENDPOINT_LIVE_DIRECTORY_LOOKUP = "https://live.adyen.com/hpp/directory/v2.shtml";
    const API_PAYMENT_VERSION = "v51";
    const API_BIN_LOOKUP_VERSION = "v50";
    const API_PAYOUT_VERSION = "v51";
    const API_RECURRING_VERSION = "v49";
    const API_CHECKOUT_VERSION = "v69";
    const API_CHECKOUT_UTILITY_VERSION = "v1";
    const API_NOTIFICATION_VERSION = "v6";
    const API_ACCOUNT_VERSION = "v6";
    const API_FUND_VERSION = "v6";
    const API_DISPUTE_SERVICE_VERSION = "v30";
    const API_HOP_VERSION = "v6";
    const ENDPOINT_TERMINAL_CLOUD_TEST = "https://terminal-api-test.adyen.com";
    const ENDPOINT_TERMINAL_CLOUD_LIVE = "https://terminal-api-live.adyen.com";
    const ENDPOINT_CHECKOUT_TEST = "https://checkout-test.adyen.com/checkout";
    const ENDPOINT_CHECKOUT_LIVE_SUFFIX = "-checkout-live.adyenpayments.com/checkout";
    const ENDPOINT_PROTOCOL = "https://";
    const ENDPOINT_NOTIFICATION_TEST = "https://cal-test.adyen.com/cal/services/Notification";
    const ENDPOINT_NOTIFICATION_LIVE = "https://cal-live.adyen.com/cal/services/Notification";
    const ENDPOINT_ACCOUNT_TEST = "https://cal-test.adyen.com/cal/services/Account";
    const ENDPOINT_ACCOUNT_LIVE = "https://cal-live.adyen.com/cal/services/Account";
    const ENDPOINT_FUND_TEST = "https://cal-test.adyen.com/cal/services/Fund";
    const ENDPOINT_FUND_LIVE = "https://cal-live.adyen.com/cal/services/Fund";
    const ENDPOINT_DISPUTE_SERVICE_TEST = "https://ca-test.adyen.com/ca/services/DisputeService";
    const ENDPOINT_DISPUTE_SERVICE_LIVE = "https://ca-live.adyen.com/ca/services/DisputeService";
    const ENDPOINT_CUSTOMER_AREA_TEST = "https://ca-test.adyen.com";
    const ENDPOINT_CUSTOMER_AREA_LIVE = "https://ca-live.adyen.com";
    const ENDPOINT_HOP_TEST = "https://cal-test.adyen.com/cal/services/Hop";
    const ENDPOINT_HOP_LIVE = "https://cal-live.adyen.com/cal/services/Hop";
    const MANAGEMENT_API_TEST = "https://management-test.adyen.com/";
    const MANAGEMENT_API_LIVE = "https://management-live.adyen.com/";
    const MANAGEMENT_API = "v1";

    /**
     * @var array
     */
    protected $data = [];

    /**
     * @var array
     */
    protected $allowedInput = ['array', 'json'];

    /**
     * @var string
     */
    protected $defaultInput = 'array';

    /**
     * @var array
     */
    protected $allowedOutput = ['array', 'json'];

    /**
     * @var string
     */
    protected $defaultOutput = 'array';

    /**
     * @var ClientInterface|null
     */
    private $httpClient;

    /**
     * @var LoggerInterface|null
     */
    private $logger;

    /**
     * Config constructor.
     *
     * @param null $params
     */
    public function __construct($params = null)
    {
        if ($params && is_array($params)) {
            foreach ($params as $key => $param) {
                $this->data[$key] = $param;
            }
        }
    }

    /**
     * Get a specific key value.
     *
     * @param string $key Key to retrieve.
     *
     * @return mixed Value of the key or NULL
     */
    public function get(string $key)
    {
        return $this->data[$key] ?? null;
    }

    /**
     * Set a key value pair
     *
     * @param string $key Key to set
     * @param mixed $value Value to set
     */
    public function set(string $key, $value)
    {
        $this->data[$key] = $value;
    }

    /**
     * @return mixed|null
     */
    public function getUsername()
    {
        return $this->data['username'] ?? null;
    }

    /**
     * Set Username of Web Service User
     *
     * @param $username
     */
    public function setUsername($username)
    {
        $this->set('username', $username);
    }

    /**
     * @return mixed|null
     */
    public function getPassword()
    {
        return $this->data['password'] ?? null;
    }

    /**
     * Set Password of Web Service User
     *
     * @param $password
     */
    public function setPassword($password)
    {
        $this->set('password', $password);
    }

    /**
     * Get the Checkout API Key from the Adyen Customer Area
     *
     * @return mixed|null
     */
    public function getXApiKey()
    {
        return $this->data['x-api-key'] ?? null;
    }

    /**
     * Set x-api-key for Web Service Client
     *
     * @param $xApiKey
     */
    public function setXApiKey($xApiKey)
    {
        $this->set('x-api-key', $xApiKey);
    }

    /**
     * Get the http proxy configuration
     *
     * @return mixed|null
     */
    public function getHttpProxy()
    {
        return $this->data['http-proxy'] ?? null;
    }

    /**
     * Set HTTP proxy information
     *
     * @param string $proxy
     */
    public function setHttpProxy($proxy)
    {
        $this->set('http-proxy', $proxy);
    }

    /**
     * @return string|null
     */
    public function getEnvironment()
    {
        return $this->data['environment'] ?? null;
    }

    /**
     * Set environment to connect to test or live platform of Adyen
     * For live please specify the unique identifier.
     *
     * @param string $environment
     * @param string|null $liveEndpointUrlPrefix Provide the unique live url prefix from the "API URLs and Response"
     *                                           menu in the Adyen Customer Area
     * @throws AdyenException
     */
    public function setEnvironment(string $environment, ?string $liveEndpointUrlPrefix = null)
    {
        if (Environment::TEST === $environment) {
            $this->set('environment', Environment::TEST);
            $this->set('endpoint', self::ENDPOINT_TEST);
            $this->set('endpointDirectoryLookup', self::ENDPOINT_TEST_DIRECTORY_LOOKUP);
            $this->set('endpointTerminalCloud', self::ENDPOINT_TERMINAL_CLOUD_TEST);
            $this->set('endpointCheckout', self::ENDPOINT_CHECKOUT_TEST);
            $this->set('endpointNotification', self::ENDPOINT_NOTIFICATION_TEST);
            $this->set('endpointAccount', self::ENDPOINT_ACCOUNT_TEST);
            $this->set('endpointFund', self::ENDPOINT_FUND_TEST);
            $this->set('endpointDisputeService', self::ENDPOINT_DISPUTE_SERVICE_TEST);
            $this->set('endpointCustomerArea', self::ENDPOINT_CUSTOMER_AREA_TEST);
            $this->set('endpointHop', self::ENDPOINT_HOP_TEST);
            $this->set('endpointManagementApi', self::MANAGEMENT_API_TEST);
        } elseif (Environment::LIVE === $environment) {
            $this->set('environment', Environment::LIVE);
            $this->set('endpointDirectoryLookup', self::ENDPOINT_LIVE_DIRECTORY_LOOKUP);
            $this->set('endpointTerminalCloud', self::ENDPOINT_TERMINAL_CLOUD_LIVE);
            $this->set('endpointNotification', self::ENDPOINT_NOTIFICATION_LIVE);
            $this->set('endpointAccount', self::ENDPOINT_ACCOUNT_LIVE);
            $this->set('endpointFund', self::ENDPOINT_FUND_LIVE);
            $this->set('endpointDisputeService', self::ENDPOINT_DISPUTE_SERVICE_LIVE);
            $this->set('endpointCustomerArea', self::ENDPOINT_CUSTOMER_AREA_LIVE);
            $this->set('endpointHop', self::ENDPOINT_HOP_LIVE);
            $this->set('endpointManagementApi', self::MANAGEMENT_API_LIVE);

            if ($liveEndpointUrlPrefix) {
                $this->set(
                    'endpoint',
                    self::ENDPOINT_PROTOCOL . $liveEndpointUrlPrefix . self::ENDPOINT_LIVE_SUFFIX
                );
                $this->set(
                    'endpointCheckout',
                    self::ENDPOINT_PROTOCOL . $liveEndpointUrlPrefix . self::ENDPOINT_CHECKOUT_LIVE_SUFFIX
                );
            } else {
                $this->set('endpoint', self::ENDPOINT_LIVE);
                $this->set('endpointCheckout', null); // not supported please specify unique identifier
            }
        } else {
            // environment does not exist
            $msg = 'This environment does not exist, use "' .
                Environment::TEST . '" or "' . Environment::LIVE . '"';
            throw new \Adyen\AdyenException($msg);
        }
    }

    /**
     * @return mixed|null
     */
    public function getMerchantAccount()
    {
        return $this->data['merchantAccount'] ?? null;
    }

    /**
     * @param $merchantAccount
     */
    public function setMerchantAccount($merchantAccount)
    {
        $this->set('merchantAccount', $merchantAccount);
    }

    /**
     * @return mixed|null
     */
    public function getApplicationName()
    {
        return $this->data['applicationName'] ?? null;
    }

    /**
     * @param $applicationName
     */
    public function setApplicationName($applicationName)
    {
        $this->set('applicationName', $applicationName);
    }

    /**
     * @return mixed|null
     */
    public function getExternalPlatform()
    {
        return $this->data['externalPlatform'] ?? null;
    }

    /**
     * Set external platform name, version and integrator
     *
     * @param string $name
     * @param string $version
     * @param string|null $integrator
     */
    public function setExternalPlatform(string $name, string $version, ?string $integrator = "")
    {
        $this->set('externalPlatform', ['name' => $name, 'version' => $version, 'integrator' => $integrator]);
    }

    /**
     * @return mixed|null
     */
    public function getAdyenPaymentSource()
    {
        return $this->data['adyenPaymentSource'] ?? null;
    }

    /**
     * Set Adyen payment source name and version
     *
     * @param string $name
     * @param string $version
     */
    public function setAdyenPaymentSource(string $name, string $version)
    {
        $this->set('adyenPaymentSource', ['name' => $name, 'version' => $version]);
    }

    /**
     * @return array|null
     */
    public function getMerchantApplication()
    {
        return $this->data['merchantApplication'] ?? null;
    }

    /**
     * Set merchant application name and version
     *
     * @param string $name
     * @param string $version
     */
    public function setMerchantApplication(string $name, string $version)
    {
        $this->set('merchantApplication', ['name' => $name, 'version' => $version]);
    }

    /**
     * @return mixed|string
     */
    public function getInputType()
    {
        if (isset($this->data['inputType']) && in_array($this->data['inputType'], $this->allowedInput)) {
            return $this->data['inputType'];
        }

        return $this->defaultInput;
    }

    /**
     * Type can be json or array
     *
     * @param $value
     */
    public function setInputType($value)
    {
        $this->set('inputType', $value);
    }

    /**
     * @return mixed|string
     */
    public function getOutputType()
    {
        if (isset($this->data['outputType']) && in_array($this->data['outputType'], $this->allowedOutput)) {
            return $this->data['outputType'];
        }

        return $this->defaultOutput;
    }

    /**
     * Type can be json or array
     *
     * @param $value
     */
    public function setOutputType($value)
    {
        $this->set('outputType', $value);
    }

    /**
     * @return mixed|null
     */
    public function getTimeout()
    {
        return $this->data['timeout'] ?? null;
    }

    /**
     * @param $value
     */
    public function setTimeout($value)
    {
        $this->set('timeout', $value);
    }

    /**
     * Get the library name
     *
     * @return string
     */
    public function getLibraryName()
    {
        return self::LIB_NAME;
    }

    /**
     * Get the library version
     *
     * @return string
     */
    public function getLibraryVersion()
    {
        return self::LIB_VERSION;
    }

    /**
     * Get the version of the API Payment endpoint
     *
     * @return string
     */
    public function getApiPaymentVersion()
    {
        return self::API_PAYMENT_VERSION;
    }

    /**
     * Get the version of the API BinLookUp endpoint
     *
     * @return string
     */
    public function getApiBinLookupVersion()
    {
        return self::API_BIN_LOOKUP_VERSION;
    }

    /**
     * Get the version of the API Payout endpoint
     *
     * @return string
     */
    public function getApiPayoutVersion()
    {
        return self::API_PAYOUT_VERSION;
    }

    /**
     * Get the version of the Recurring API endpoint
     *
     * @return string
     */
    public function getApiRecurringVersion()
    {
        return self::API_RECURRING_VERSION;
    }

    /**
     * Get the version of the Checkout API endpoint
     *
     * @return string
     */
    public function getApiCheckoutVersion()
    {
        return self::API_CHECKOUT_VERSION;
    }

    /**
     * Get the version of the Checkout Utility API endpoint
     *
     * @return string
     */
    public function getApiCheckoutUtilityVersion()
    {
        return self::API_CHECKOUT_UTILITY_VERSION;
    }

    /**
     * Get the version of the Notification API endpoint
     *
     * @return string
     */
    public function getApiNotificationVersion()
    {
        return self::API_NOTIFICATION_VERSION;
    }

    /**
     * Get the version of the Account API endpoint
     *
     * @return string
     */
    public function getApiAccountVersion()
    {
        return self::API_ACCOUNT_VERSION;
    }

    /**
     * Get the version of the HOP (Hosted Onboarding Page) API endpoint
     *
     * @return string
     */
    public function getApiHopVersion()
    {
        return self::API_HOP_VERSION;
    }

    /**
     * Get the version of the Fund API endpoint
     *
     * @return string
     */
    public function getApiFundVersion()
    {
        return self::API_FUND_VERSION;
    }

    /**
     * Get the disputes service API version
     *
     * @return string
     */
    public function getDisputeServiceVersion()
    {
        return self::API_DISPUTE_SERVICE_VERSION;
    }

    /**
     * Get the version of the management API endpoint
     *
     * @return string
     */
    public function getManagementApiVersion()
    {
        return self::MANAGEMENT_API;
    }

    /**
     * @param ClientInterface $httpClient
     */
    public function setHttpClient(ClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * @return ClientInterface
     */
    public function getHttpClient()
    {
        if ($this->httpClient === null) {
            $this->httpClient = $this->createDefaultHttpClient();
        }
        return $this->httpClient;
    }

    /**
     * @return CurlClient
     */
    protected function createDefaultHttpClient()
    {
        return new CurlClient();
    }

    /**
     * Set the Logger object
     *
     * @param LoggerInterface $logger
     */
    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @return LoggerInterface
     */
    public function getLogger()
    {
        if ($this->logger === null) {
            $this->logger = $this->createDefaultLogger();
        }

        return $this->logger;
    }

    /**
     * @return Logger
     */
    protected function createDefaultLogger()
    {
        $logger = new Logger('adyen-php-api-library');
        $logger->pushHandler(new StreamHandler('php://stderr', Logger::NOTICE));

        return $logger;
    }
}
