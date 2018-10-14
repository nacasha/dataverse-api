<?php

namespace DataverseAPI;

use Curl\Curl;
use DataverseAPI\DataverseAPI;

class SearchAPI
{

    protected $apitoken = '';
    protected $hostname = '';

    protected $curl = '';

    protected $query = [];

    protected $url = array(
        'getAllDataverses'
            => 'https://$HOSTNAME/api/search?',
    );

    public function __construct($apitoken, $hostname) 
    {
        $this->apitoken    = $apitoken;
        $this->hostname    = $hostname;
        
        $this->curl = new Curl();
        $this->curl->setHeader('X-Dataverse-key', $apitoken);
    }

    protected function parseUrl($url)
    {
        $url = str_replace('$HOSTNAME', $this->hostname, $url);
        
        return $url;
    }

    public function setCriteria($criteria = array())
    {
        foreach($criteria as $index => $value) {
            $this->query[$index] = $value;
        }

    }

    public function buildSearchQuery()
    {
        $query = '';
        
        foreach($this->query as $index => $value) {
            $query .= "${index}=${value}&";
        }

        return $query;
    }

    public function getAllDataverses()
    {
        $this->setCriteria(array(
            'q' => '*',
            'type' => 'dataverse',
            'sort' => 'date'
        ));
        $query = $this->buildSearchQuery();

        $url = $this->url['getAllDataverses'];
        $url = $this->parseUrl($url);
        $this->curl->get($url . $query);
    
        return $this->curl;
    }

}
