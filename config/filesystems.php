<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the framework. The "local" disk, as well as a variety of cloud
    | based disks are available to your application. Just store away!
    |
    */

    'default' => env('FILESYSTEM_DISK', 'local'),

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Here you may configure as many filesystem "disks" as you wish, and you
    | may even configure multiple disks of the same driver. Defaults have
    | been set up for each driver as an example of the required values.
    |
    | Supported Drivers: "local", "ftp", "sftp", "s3"
    |
    */

    'disks' => [

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app'),
            'throw' => false,
        ],

        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'public',
            'throw' => false,
        ],

        's3' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION'),
            'bucket' => env('AWS_BUCKET'),
            'url' => env('AWS_URL'),
            'endpoint' => env('AWS_ENDPOINT'),
            'use_path_style_endpoint' => env('AWS_USE_PATH_STYLE_ENDPOINT', false),
            'throw' => false,
        ],

	    'qiniu' => [
		    'driver'  => 'qiniu',
		    'domains' => [
			    'default'   => 'hakutakustorage.nbmun.cn', //你的七牛域名
			    'https'     => 'hakutakustorage.nbmun.cn',         //你的HTTPS域名
			    'custom'    => 'static.abc.com',                //Useless 没啥用，请直接使用上面的 default 项
		    ],
		    'access_key'=> 'tvlYewu8yVme2G1YlGZTX2ndxeOAz4ZLTeE4SVtE',  //AccessKey
		    'secret_key'=> 'ASxr4X70Y2OkwaLCO_te63z0K8GtK8il6ImXgZEF',  //SecretKey
		    'bucket'    => 'hakutaku',  //Bucket名字
		    'notify_url'=> '',  //持久化处理回调地址
		    'access'    => 'public',  //空间访问控制 public 或 private
		    'hotlink_prevention_key' => 'afc89ff8bd2axxxxxxxxxxxxxxbb', // CDN 时间戳防盗链的 key。 设置为 null 则不启用本功能。
//            'hotlink_prevention_key' => 'cbab68a279xxxxxxxxxxab509a', // 同上，备用
	    ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Symbolic Links
    |--------------------------------------------------------------------------
    |
    | Here you may configure the symbolic links that will be created when the
    | `storage:link` Artisan command is executed. The array keys should be
    | the locations of the links and the values should be their targets.
    |
    */

    'links' => [
        public_path('storage') => storage_path('app/public'),
    ],

];
