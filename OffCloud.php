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

    private $api_key;

    public function __construct($api_key)
    {
        $this->api_key = $api_key;
        return $this;
    }

    /**
     * @param $url
     * @param null $proxy_id
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

        var_dump('response',$response);
    }

    public function remoteAccounts(){
        $response = $this->request(
            'https://offcloud.com/api/remote-account/list',
            'POST',
            [],
            []
        );

        if(isset($response->data)){
            return new OffCloudRemote($response->data);
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

        curl_setopt($ch, CURLOPT_URL,$url);

        if($method == 'POST'){
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,  http_build_query($parameters));

        }
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $data = curl_exec ($ch);

        curl_close ($ch);


        $object = json_decode($data);

        if((json_last_error() == JSON_ERROR_NONE)){
            return $object;
        }else{
            return $data;
        }

    }
}