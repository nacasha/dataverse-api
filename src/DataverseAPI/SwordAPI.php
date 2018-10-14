<?php

namespace DataverseAPI;

use Curl\Curl;
use DataverseAPI\DataverseAPI;
use DataverseAPI\AtomEntry;

class SwordAPI
{

    protected $apitoken = '';
    protected $hostname = '';

    protected $curl = '';

    protected $url = array(
        'retrieveSwordService'
            => 'https://$HOSTNAME/dvn/api/data-deposit/v1.1/swordv2/service-document',
        'listDatasets'
            => 'https://$HOSTNAME/dvn/api/data-deposit/v1.1/swordv2/collection/dataverse/',
        'createDataset'
            => 'https://$HOSTNAME/dvn/api/data-deposit/v1.1/swordv2/collection/dataverse/',
        'addFilesToDataset'
            => 'https://$HOSTNAME/dvn/api/data-deposit/v1.1/swordv2/edit-media/study/'
    );

    public function __construct($apitoken, $hostname) 
    {
        $this->apitoken    = $apitoken;
        $this->hostname    = $hostname;
        
        $this->curl = new Curl();
        $this->curl->setBasicAuthentication($apitoken);
    }

    protected function parseUrl($url)
    {
        $url = str_replace('$HOSTNAME', $this->hostname, $url);
        
        return $url;
    }

    public function newAtomEntry()
    {
        return new AtomEntry();
    }

    public function retrieveSwordService()
    {
        $url = $this->url['retrieveSwordService'];
        $url = $this->parseUrl($url);
        $this->curl->get($url);

        return $this->curl;
    }

    public function listDatasets($alias)
    {
        $url = $this->url['listDatasets'];
        $url = $this->parseUrl($url);
        $this->curl->get($url . $alias);

        return $this->curl;
    }

    public function createDataset($data, $alias)
    {
        $url = $this->url['createDataset'];
        $url = $this->parseUrl($url);
        $this->curl->setHeader('Content-Type', 'application/atom+xml');
        $this->curl->post($url . $alias, $data);

        return $this->curl;
    }

    public function addFilesToDataset($file, $id)
    {
        $url = $this->url['addFilesToDataset'];
        $url = $this->parseUrl($url);
        $this->curl->setHeader('Content-Disposition', 'filename=entry-file.zip');
        $this->curl->setHeader('Content-Type', 'application/zip');
        $this->curl->setHeader('Packaging', 'http://purl.org/net/sword/package/SimpleZip');
        $this->curl->post($url . $id, $file);

        return $this->curl;
    }

}
