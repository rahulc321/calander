<?php
/**
 * Created by PhpStorm.
 * User: Zorro
 * Date: 6/21/2016
 * Time: 11:06 AM
 */

namespace App\OAuth;

use OAuth\Common\Consumer\Credentials;
use OAuth\Common\Storage\TokenStorageInterface;
use OAuth\ServiceFactory;

class Consumer
{
    private $serviceFactory;
    private $storage;
    private $scopes = [];
    private $credentials;
    private $serviceName;
    private $service;

    /**
     * @return mixed
     */
    public function getServiceName()
    {
        return $this->serviceName;
    }

    /**
     * @param mixed $serviceName
     * @return Consumer
     */
    public function setServiceName($serviceName)
    {
        $this->serviceName = $serviceName;
        return $this;
    }


    /**
     * @return mixed
     */
    public function getService()
    {
        return $this->service;
    }

    /**
     * @param mixed $service
     * @return Consumer
     */
    public function setService($service)
    {
        $this->service = $service;
        return $this;
    }


    public function __construct(ServiceFactory $serviceFactory, Credentials $credentials, TokenStorageInterface $storage){
        $this->credentials = $credentials;
        $this->serviceFactory = $serviceFactory;
        $this->storage = $storage;
    }

    public function init($serviceName, $class){
        $this->setServiceName($serviceName);
        $this->serviceFactory->registerService($this->getServiceName(), $class);
        $this->service = $this->serviceFactory->createService($this->getServiceName(), $this->credentials, $this->storage, $this->scopes);
    }

    /**
     * @return mixed
     */
    public function getServiceFactory()
    {
        return $this->serviceFactory;
    }

    /**
     * @param mixed $serviceFactory
     * @return Consumer
     */
    public function setServiceFactory($serviceFactory)
    {
        $this->serviceFactory = $serviceFactory;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getStorage()
    {
        return $this->storage;
    }

    /**
     * @param mixed $storage
     * @return Consumer
     */
    public function setStorage($storage)
    {
        $this->storage = $storage;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getScopes()
    {
        return $this->scopes;
    }

    /**
     * @param mixed $scopes
     * @return Consumer
     */
    public function setScopes($scopes)
    {
        $this->scopes = $scopes;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCredentials()
    {
        return $this->credentials;
    }

    /**
     * @param mixed $credentials
     * @return Consumer
     */
    public function setCredentials($credentials)
    {
        $this->credentials = $credentials;
        return $this;
    }





}