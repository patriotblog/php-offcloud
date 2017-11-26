<?php
/**
 * Created by PhpStorm.
 * User: patriot
 * Date: 11/25/17
 * Time: 11:49 AM
 */
namespace PHPOffCloud;
class OffCloudRemote
{
    public $accountId;
    public $remoteOptionId;
    public $type;
    public $username;
    public $status;
    public $host;
    public $port;
    public $usage;

    public function __construct($response)
    {

        if($response && is_array($response)){
            $list = [];
            foreach ($response as $remote) {
                $object = new OffCloudRemote(null);

                if(isset($remote->accountId)) $this->accountId = $remote->accountId;
                if(isset($remote->type)) $this->type = $remote->type;
                if(isset($remote->remoteOptionId)) $this->remoteOptionId = $remote->remoteOptionId;
                if(isset($remote->username)) $this->username = $remote->username;
                if(isset($remote->status)) $this->status = $remote->status;
                if(isset($remote->host)) $this->host = $remote->host;
                if(isset($remote->port)) $this->port = $remote->port;
                if(isset($remote->usage)) $this->usage = $remote->usage;

                $list[] = $object;
            }
            return $list;
        }
        return $this;

    }
}