<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyCsrfToken extends BaseVerifier
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        //
        '/yibutest',
        '/yibu',
        '/api/welkin/markdown/upload/images',
        '/payinfo/notify_url/swiftpass',
        '/payinfo/notify_url/qianfang',
        '/payinfo/notify_url/qianfang1',
        '/payinfo/notify_url/aihuangou',
        '/payinfo/notify_url/aihuangou1',
        '/payinfo/notify_url/aihuangoutoqianfang',
        '/payinfo/notify_url/payfutong',
        'welkin/mcy/automan/run'
    ];
}
