<?php
/**
 * Created by PhpStorm.
 * User: patriot
 * Date: 11/25/17
 * Time: 11:21 AM
 */
namespace PHPOffCloud;
class OffCloudFile
{
    public $requestId;
    public $fileName;
    public $url;
    public $site;
    public $status;
    public $originalLink;
    public $createdOn;

    /** @var $offCloud OffCloud */
    private $offCloud;


    public function __construct($response, $offCloud=null)
    {
        $this->offCloud = $offCloud;
        if($response){
            if(isset($response->not_available)){
                throw new OffCloudException(self::ParseError($response->not_available), 403);
            }

            if(isset($response->requestId)){
                if(isset($response->requestId)) $this->requestId = $response->requestId;
                if(isset($response->fileName)) $this->fileName = $response->fileName;
                if(isset($response->url)) $this->url = $response->url;
                if(isset($response->site)) $this->site = $response->site;
                if(isset($response->status)) $this->status = $response->status;
                if(isset($response->originalLink)) $this->originalLink = $response->originalLink;
                if(isset($response->createdOn)) $this->createdOn = $response->createdOn;

                return $this;
            }else{
                var_dump($response);
                throw new \Exception('Cant Add new File', 403);
            }
        }



        return $this;
    }

    public function refresh(){
        return $this;
    }
    public function checkCloudStatus(){
        //cloud/explore
        $response = $this->offCloud->request(
            'https://offcloud.com/api/cloud/explore',
            'POST',
            [],
            ['requestId'=>$this->requestId]
        );
        if(isset($response->error)){
            throw new \Exception($response->error);
        }
        return $response;
    }
    public function checkRemoteStatus(){
        $response = $this->offCloud->request(
            'https://offcloud.com/api/remote/status',
            'POST',
            [],
            ['requestId'=>$this->requestId]
        );

        if(isset($response->error)){
            throw new \Exception($response->error);
        }
        return $response;
    }

    public function cloudExplore(){

        $response = $this->offCloud->request(
            'https://offcloud.com/api/cloud/explore',
            'POST',
            ['requestId'=>$this->requestId],
            []
        );

        if(isset($response->error)){
            throw new \Exception($response->error);
        }
        return $response;
    }


    public static function ParseError($error){
        switch ($error){
            case 'premium':
                $description = 'User must purchase a premium downloading addon for this download.';
                break;
            case 'links':
                $description = 'User must purchase a Link increase addon for this download.';
                break;
            case 'proxy':
                $description = 'User must purchase a proxy downloading addon for this download.';
                break;
            case 'video':
                $description = 'User must purchase a video sharing site support addon for this download.';
                break;
            case 'cloud':
                $description = 'User must purchase a clowd downloading upgrade addon for this download.';
                break;
            default:
                $description = 'Unknown Error';
        }

        return $description;
    }
}