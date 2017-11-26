<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('memory_limit', '-1');
set_time_limit(0);

require_once dirname(__FILE__).'/../OffCloud.php';
require_once dirname(__FILE__).'/../OffCloudProxy.php';
require_once dirname(__FILE__).'/../OffCloudFile.php';
require_once dirname(__FILE__).'/../OffCloudRemote.php';
require_once dirname(__FILE__).'/../OffCloudException.php';

    try {
        echo 'Test Start...'.PHP_EOL;
        $offCloud = new PHPOffCloud\OffCloud('ic6S4uFhxso2xAAnxhFlhQChumGvPDjR');



        /*
         * echo 'Available Proxies...'.PHP_EOL;
        $last_proxy = null;
        foreach ($offCloud->proxies() as $proxy) {
            echo $proxy->name.PHP_EOL;
            $last_proxy = $proxy;
        }
        echo PHP_EOL;



        echo 'Remote Accounts...'.PHP_EOL;
        $remoteAccounts = $offCloud->remoteAccounts();
        foreach (remoteAccounts as $remoteAccount) {
            echo $remoteAccount->type.PHP_EOL;
        }
        echo PHP_EOL;

        */

        echo 'Cloud Exploer'.PHP_EOL;

        echo 'Add New Torrent...'.PHP_EOL;
        $file_one = $offCloud->instantDownload(
        //'https://zoink.ch/torrent/Shameless.US.S07E07.720p.HDTV.X264-DIMENSION[eztv].mkv.torrent'
        //'https://yts.am/torrent/download/9054E68994A0E9718F6202481B99782B8CCACF1D'
            'https://yts.am/torrent/download/2AB33288EF609BE4C267E958AB66020E14753903'
        );
        echo PHP_EOL;
        var_dump('remote status', $file_one->checkRemoteStatus());
        var_dump('cloud status', $file_one->checkCloudStatus());
        var_dump('cloud explore', $file_one->cloaudExplore());




    }catch (Exception $e){
        var_dump('exception', $e);

    }
