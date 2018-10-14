<?php

namespace DataverseAPI;

use DataverseAPI\SearchAPI;
use DataverseAPI\SwordAPI;

class DataverseAPI
{
    protected $curl;

    protected $apitoken = '';
    protected $hostname = '';

    public function setApiToken($apitoken)
    {
        $this->apitoken = $apitoken;
    }

    public function setHostName($hostname)
    {
        $this->hostname = $hostname;
    }

    public function SwordAPI()
    {
        $curl = $this->curl;
        $apitoken = $this->apitoken;
        $hostname = $this->hostname;

        return new SwordAPI($apitoken, $hostname, $curl);
    }

    public function SearchAPI()
    {
        $curl = $this->curl;
        $apitoken = $this->apitoken;
        $hostname = $this->hostname;

        return new SearchAPI($apitoken, $hostname, $curl);
    }
}
