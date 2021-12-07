<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use \App\Models\Article;
use Illuminate\Support\Str;


class SampleController extends Controller
{
    //新規投稿取得メソッド
    public function getNewMessage(Request $request)
    {
        if ($request->input('type') == 'url_verification') {
            return $request->input('challenge');
        }
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


        $response_body = $response->getBody();

        $arr = json_decode($response_body, true);
        $getTitle = Str::between($arr['messages'][0]['text'], '▼', '━━━━━━━━━━━━━━━━');
        //dd($arr['messages'][0]['text']);
        //dd(json_decode($response_body));

        $article = new Article();
        $article->title = $getTitle;
        $title = str_replace('*', '', $getTitle);
        //dd($title);
        $article->content = $arr['messages'][0]['text'];

        //保存する前にclient_msg_idが同じものは保存しない処理を記述する
        $article->save();

        //レスポンスをjson_decodeで加工。後でフロント画面に渡す
        $articles = Article::all();

        
        return $title;
        

    }

    //過去投稿取得メソッド追記予定


}
