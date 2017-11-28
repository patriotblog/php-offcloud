# PHP-Offcloud
PHP library for Offcloud.com

## Installation

```     
composer require patriotblog/php-offcloud
```

Offcloud.com API
===============

## Introduction to the Offcloud.com API

Offcloud API is a solution that gives developers ability to interact with Offcloud.com service, including:

* Adding an URL to Offcloud for Instant downloading
* Adding an URL to Offcloud cloud.
* Adding an URL to Offcloud for Remote downloading

All requests return JSON, including errors. All parameters should be passed to API scripts as POST request variables.


## Authentificate to the Offcloud.com API

The best way to authentificate to Offcloud is to add "?apikey=" to your API queries, along with your API key. You can find your API key into your account settings @ https://offcloud.com/#/account


## Submitting an input to Offcloud.com through the API

### Adding an URL for instant downloading

To add an URL for instant downloading, you can make a POST call to the following URL with the available variables described below:

```
$offCloud = new PHPOffCloud\OffCloud(API_KEY);
$file = $offCloud->instantDownload(SOME_URL, PROXY_ID);

if($file_one){
    echo 'requestId: '.$file->requestId;
}
```

* url: URL of downloaded resource
* proxyId: (optional) ID of the preferred proxy server to use. If proxyId is not specified,  the default user proxy server will be used

In the case of success, the script will return the OffCloudFile object that contains:
* requestId
* fileName: the name of the requested file
* url: url for instant download
* site: website name
* status: status of the requested file. Should be ‘created’
* originalLink: link to the original file
* createdOn: date and time when request was processed

In the case when adding this URL is not available for this user, API will return the following JSON answer:
* not_available

Here are the following values of the ‘not_available’ response and their descriptions:

| Name | Description          |
| ------------- | ----------- |
| premium      | User must purchase a premium downloading addon for this download.|
| links     | User must purchase a Link increase addon for this download.   |
| proxy     | User must purchase a proxy downloading addon for this download. |
| video     | User must purchase a video sharing site support addon for this download.     |

When a request cannot be processed, API will return error message in the JSON answer.


### Adding an URL for cloud downloading.

To add an URL for cloud downloading, you can make a POST call to the following URL with the available variables described below:

```
$file = $offCloud->cloudDownload(SOME_URL);
```

* url: URL of downloaded resource

In the case of success, the script will return the OffCloudFile object that contains:
* requestId
* fileName: the name of the requested file
* url: url for download from the cloud
* site: website name
* status: status of the requested file downloading. Can be ‘created’, ‘downloaded’, ‘error’.
* originalLink: link to the original file
* createdOn: date and time when request was processed

If you want to start a process of downloading from the cloud, please, be convinced that the status of download is ‘downloaded’. You can check the status of download request by sending an API call (see the section “Retrieving a status of user’s cloud download” below).

In the case when adding this URL is not available for this user, API will return the following JSON answer:
* not_available

Here are the following values of the ‘not_available’ response and their descriptions:

| Name | Description          |
| ------------- | ----------- |
| premium      | User must purchase a premium downloading addon for this download.|
| links     | User must purchase a Link increase addon for this download.   |
| proxy     | User must purchase a proxy downloading addon for this download. |
| cloud     | User must purchase a clowd downloading upgrade addon for this download. |
| video     | User must purchase a video sharing site support addon for this download.     |

When a request cannot be processed, API will return error message in the JSON answer.


### Adding an URL for remote downloading.

To add an URL for remote downloading, you can make a POST call to the following URL with the available variables described below:

```
$file = $offCloud->remoteDownload(SOME_URL, REMOTE_OPTION_ID, FOLDER_ID);
```

* url: URL of downloaded resource
* remoteOptionId: ID of the remote account where to download
* folderId: Google Drive's ID of the folder to upload content to.

To get a list of all users remote accounts, see the section “Retrieving a list of remote accounts”.

In the case of success, the script will return the OffCloudFile object that contains:
* requestId
* fileName: the name of the requested file
* site: website name
* status: status of the requested file downloading. Can be ‘created’, ‘downloaded’, ‘error’.
* originalLink: original link to the file
* createdOn: date and time when request was processed

The API call doesn’t return a link for immediate downloading, you can only check the status of download request by sending additional API call (See the section “Retrieving a status of user’s remote download” below).

In the case when adding this URL is not available for this user, API will return the following JSON answer:
* not_available

Here are the following values of the ‘not_available’ response and their descriptions:

| Name | Description          |
| ------------- | ----------- |
| premium      | User must purchase a premium downloading addon for this download.|
| links     | User must purchase a Link increase addon for this download.   |
| proxy     | User must purchase a proxy downloading addon for this download. |
| video     | User must purchase a video sharing site support addon for this download.     |

When a request cannot be processed, API will return error message in the JSON answer.


## Retrieving some data from Offcloud.com through the API

### Retrieving a list of available proxy servers

To get a list of available proxy servers, you can make a POST call to the following URL:

```
$proxies = $offCloud->proxies()
```

This script will return a JSON array of the available proxy servers with the following data:
* id
* name: name of the proxy server
* region: location of the proxy server


### Retrieving a status of user’s cloud download

To get a status of user’s cloud download, you can make a POST call with a requestId parameter to the following URL:

```
$file->checkCloudStatus()
```

The server will return status of the download or an error message if the request cannot be processed.


### Exploring zipped files or folder archives from cloud

To explore your zipped files or folder archives in your cloud history, you can make a GET call with a requestId parameter to the following URL:

```
$file->cloudExplore()
```

The server will return a JSON array of download links to each file stored in archive.


### Retrieving a list of user’s remote accounts

To get a list of user’s remote accounts, you can make a POST call to the following URL:

```
$remoteAccounts = $offCloud->remoteAccounts();
```

This script will return a JSON array of the current user’s remote accounts with the following data:
* accountId
* type: type of account
* username: login used for the remote account
* status: status of the account
* host: remote host
* port: remote port
* usage: amount of traffic used by this remote account


### Retrieving a status of user’s remote download

To get a status of user’s remote download, you can make a POST call with a requestId parameter to the following URL:

```
$file->checkRemoteStatus()
```

The server will return a status of the download or an error message if the request cannot be processed.
