<?php
/**
 * Created by PhpStorm.
 * User: patriot
 * Date: 11/25/17
 * Time: 11:18 AM
 */
namespace PHPOffCloud;
class OffCloud
{

    /** You can find your API key into your account settings @ https://offcloud.com/#/account
     * @var string
     */
    private $api_key;

    /**
     * @var bool
     */
    public $debug;

    public function __construct($api_key, $debug=false)
    {
        $this->api_key = $api_key;
        $this->debug = $debug;
        return $this;
    }

    /**
     * @param $url string
     * @param $proxy_id string
     * @return OffCloudFile
     */
    public function instantDownload($url, $proxy_id=null){
        $response = $this->request(
            'https://offcloud.com/api/instant/download',
            'POST',
            [],
            [
                'url'=>$url,
                'proxyId'=>$proxy_id
            ]
        );

        return new OffCloudFile($response, $this);

    }

    /**
     * @return OffCloudFile
     */
    public function cloudDownload($url){
        $response = $this->request(
            'https://offcloud.com/api/cloud/download',
            'POST',
            [],
            [
                'url'=>$url,
            ]
        );

        return new OffCloudFile($response);

    }

    /**
     * @return OffCloudFile
     */
    public function remoteDownload($url, $remote_option_id=null, $folder_id=null){
        $response = $this->request(
            'https://offcloud.com/api/remote/download',
            'POST',
            [],
            [
                'url'=>$url,
                'remoteOptionId'=>$remote_option_id,
                'folderId'=>$folder_id
            ]
        );

        return new OffCloudFile($response);

    }

    public function cloudStatus(){
        $response = $this->request(
            'https://offcloud.com/api/cloud/status',
            'POST',
            [],
            []
        );

        return $response;
    }

    public function remoteAccounts(){
        $response = $this->request(
            'https://offcloud.com/api/remote-account/list',
            'POST',
            [],
            []
        );

        if(isset($response->data)){
            $model = new OffCloudRemote();
            return $model->load($response->data);
        }else{
            return [];
        }
    }



    /**
     * @return OffCloudProxy[]
     */
    public function proxies(){
        $response = $this->request(
            'https://offcloud.com/api/proxy/list',
            'POST'
        );
        $proxies =  new OffCloudProxy();
        return $proxies->load($response);
    }




    public function request($path, $method='GET', $query=[], $parameters=[]){
        $ch = curl_init();


        $url = $path.'?';

        if(!empty($query)){
            $url .= http_build_query($query);
        }

        $url .= '&apikey='.$this->api_key;

        if($this->debug)
            var_dump($url, $parameters);

        curl_setopt($ch, CURLOPT_URL,$url);

        if($method == 'POST'){
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,  http_build_query($parameters));

        }
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $data = curl_exec ($ch);

        curl_close ($ch);

        if($this->debug)
            var_dump($data);

        $object = json_decode($data);

        if((json_last_error() == JSON_ERROR_NONE)){
            return $object;
        }else{
            return $data;
        }

    }
}