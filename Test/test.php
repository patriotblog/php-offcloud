<?php

const API_KEY = '';

require_once dirname(__FILE__).'/../OffCloud.php';
require_once dirname(__FILE__).'/../OffCloudProxy.php';
require_once dirname(__FILE__).'/../OffCloudFile.php';
require_once dirname(__FILE__).'/../OffCloudRemote.php';
require_once dirname(__FILE__).'/../OffCloudException.php';

    try {
        echo 'Test Start'.PHP_EOL;
        $offCloud = new PHPOffCloud\OffCloud(API_KEY);

        echo 'Available Proxies:'.PHP_EOL;
        $last_proxy = null;
        foreach ($offCloud->proxies() as $proxy) {
            echo $proxy->name.PHP_EOL;
            $last_proxy = $proxy;
        }
        echo PHP_EOL;
        readline('Enter a key...');





        echo 'Remote Accounts:'.PHP_EOL;
        //$offCloud->debug = true;
        $remoteAccounts = $offCloud->remoteAccounts();
        foreach ($remoteAccounts as $remoteAccount) {
            echo $remoteAccount->type.PHP_EOL;
        }
        echo PHP_EOL;
        readline('Enter a key...');




        echo 'Add New Torrent:'.PHP_EOL;
        $file_one = $offCloud->instantDownload(
            'http://fs2.filegir.com/patriot7/OmOut52.zip'
        );
        if($file_one){
            echo 'requestId: '.$file_one->requestId.PHP_EOL;
        }
        echo PHP_EOL;
        readline('Enter a key...');


        echo 'Check Remote Status...'.PHP_EOL;
        var_dump($file_one->checkRemoteStatus());
        echo PHP_EOL;
        readline('Enter a key...');

        echo 'Check Cloud Status...'.PHP_EOL;
        var_dump($file_one->checkCloudStatus());
        echo PHP_EOL;
        readline('Enter a key...');

        echo 'Cloud Explore...'.PHP_EOL;
        var_dump($file_one->cloudExplore());
        echo PHP_EOL;
        readline('Enter a key...');

    }catch (Exception $e){
        var_dump('exception', $e);

    }
