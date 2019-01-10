<?php

namespace App\Services;

use Mailjet\Client;
use \Mailjet\Resources;

class MailjetService
{

    /**
     * @var Client
     */
    private $client;

    /**
     * @return Client
     */
    public function getClient(): Client
    {
        return $this->client;
    }

    /**
     * @return Resources
     */
    public function getResources(): Resources
    {
        return $this->resources;
    }


    /**
     * @var Resources
     */
    private $resources;

    /**
     * MailjetService constructor.
     */
    public function __construct()
    {

        $this->client = new Client(getenv('MJ_APIKEY_PUBLIC'), getenv('MJ_APIKEY_PRIVATE'),
            true,['version' => 'v3.1']);

        $this->resources = new Resources;
    }
}
