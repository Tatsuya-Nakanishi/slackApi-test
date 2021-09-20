<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class SampleController extends Controller
{
    //新規投稿取得メソッド
    public function getNewMessage()
    {
        $base_url = 'https://slack.com/api/conversations.history';
        $client = new \GuzzleHttp\Client([
            'base_uri'  => $base_url,
            'verify'    => false,
        ]);
        $headers = [
            'Origin'                    => 'https://slack.com/api/conversations.history',
            'Accept-Encoding'           => 'gzip, deflate, br',
            'Accept-Language'           => 'ja,en-US;q=0.8,en;q=0.6',
            'Upgrade-Insecure-Requests' => '1',
            'User-Agent'                => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36',
            'Content-Type'              => 'application/x-www-form-urlencoded',
            'Accept'                    => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
            'Cache-Control'             => 'max-age=0',
            'Referer'                   => 'https://slack.com/api',
            'Connection'                => 'keep-alive',
            //トークンは.envファイルに設定
            'Authorization'             => 'Bearer ' . env('API_KEY', null),
        ];

        //チャンネルIDと最大取得件数をリクエストパラメータに指定。
        $form_params    = [
            'channel' => 'C02CQN57B7U',
            'limit' => 1,
        ];
        
        $response = $client->request('GET', $base_url, [
            'allow_redirects' => true,
            'headers'         => $headers,
            'verify'          => false,
            'query'           => $form_params,
        ]);

        $response_body =  (string) $response->getBody();

        //dd(json_decode($response_body));

        //レスポンスをjson_decodeで加工
        return json_decode($response_body);
        

    }

    //過去投稿取得メソッド追記予定


}
