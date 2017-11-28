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

    public function __construct()
    {

        return $this;

    }
    public function load($response){
        if($response && is_array($response)){
            $list = [];
            foreach ($response as $remote) {
                $object = new OffCloudRemote();

                if(isset($remote->accountId)) $object->accountId = $remote->accountId;
                if(isset($remote->type)) $object->type = $remote->type;
                if(isset($remote->remoteOptionId)) $object->remoteOptionId = $remote->remoteOptionId;
                if(isset($remote->username)) $object->username = $remote->username;
                if(isset($remote->status)) $object->status = $remote->status;
                if(isset($remote->host)) $object->host = $remote->host;
                if(isset($remote->port)) $object->port = $remote->port;
                if(isset($remote->usage)) $object->usage = $remote->usage;

                $list[] = $object;
            }
            return $list;
        }
        return [];
    }

}