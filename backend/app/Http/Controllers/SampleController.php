<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class SampleController extends Controller
{
    //
    public function callSlackApi($path, $form_params)
    {
        $base_url = 'https://slack.com/api';
        $client = new \GuzzleHttp\Client([
            'base_uri'  => $base_url,
            'verify'    => false,
        ]);
        $headers = [
            'Origin'                    => 'https://slack.com/api',
            'Accept-Encoding'           => 'gzip, deflate, br',
            'Accept-Language'           => 'ja,en-US;q=0.8,en;q=0.6',
            'Upgrade-Insecure-Requests' => '1',
            'User-Agent'                => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36',
            'Content-Type'              => 'application/x-www-form-urlencoded',
            'Accept'                    => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
            'Cache-Control'             => 'max-age=0',
            'Referer'                   => 'https://slack.com/api',
            'Connection'                => 'keep-alive',
            'Authorization'             => 'Bearer ',
        ];
        // dd($path);
        $response = $client->request('GET', $base_url . $path, [
            'allow_redirects' => true,
            'headers'         => $headers,
            'verify'          => false,
            'query'           => $form_params,
        ]);
        $response_body = (string) $response->getBody();
        //return $this->jsonResponse($response_body);
         dd($response_body);
        echo $response_body;
        echo json_encode($response_body, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

    }

    public function getChannelHistory()
    {
        $path           = '/conversations.history';     // 呼び出すSlack Method
        $form_params    = [
            'channel' => 'C013STP3QDV',
            'limit' => 1,
        ]; // Slack Methodに渡すパラメータ
        $this->callSlackApi($path, $form_params);
    }
}
