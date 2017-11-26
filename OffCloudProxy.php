<?php
/**
 * Created by PhpStorm.
 * User: patriot
 * Date: 11/25/17
 * Time: 11:44 AM
 */
namespace PHPOffCloud;
class OffCloudProxy
{
    public $id;
    public $name;
    public $region;

    public $rand;

    public function __construct()
    {
        $this->rand = rand();
        return $this;
    }
    public function load($response){
        $list = [];
        foreach ($response->list as $proxy) {
            $object = new OffCloudProxy();
            if(isset($proxy->id)) $object->id = $proxy->id;
            if(isset($proxy->name)) $object->name = $proxy->name;
            if(isset($proxy->region)) $object->region = $proxy->region;

            $list[] = $object;
        }
        return $list;
    }

}