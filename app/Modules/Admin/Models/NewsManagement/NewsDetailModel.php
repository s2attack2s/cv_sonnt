<?php

/**
 * NewsDetailModel
 * Model processing for page news detail
 *
 * 処理概要/process overview  : NewsDetailModel
 * 作成日/create date         : 2021/05/28
 * 作成者/creater             : QuyPN
 *
 * 更新日/update date         :
 * 更新者/updater             :
 * 更新内容 /update content   :
 *
 * @package Modules/Admin
 * @copyright Copyright (c) toploop.co
 * @version 1.0.0
 */

namespace App\Modules\Admin\Models\NewsManagement;

use Illuminate\Support\Facades\DB;
use Helper, DataResponse, ResponseCode;
use Illuminate\Support\Str;

class NewsDetailModel
{
    protected $lang;

    public function __construct() {
        $this->lang = Helper::GetCookies('lang', 'en');
    }

    /**
     * Get data news follow id
     * Created: 2021/05/28
     * @author QuyPN <quy.pham@toploop.co>
     * @param  int $id Id of news
     * @return Array Data of news
     */
    public function LoadNews($id)
    {
        try {
            $news = DB::table("news")
                ->where('id', $id)
                ->where('deleted_at', null)->first();
                // ->where('language_id', '=', 1)->first();
            return  $news;
        }
        catch(\Exception $e) {
            throw $e;
        }
    }

    /**
     * Update news
     * Created: 2021/05/31
     * @param Array $data Data of news from client
     * @return Array updated result
     * @throws \Exception
     * @author QuyPN <quy.pham@toploop.co>
     */
    public function UpdateNews($data)
    {
        $folder = 'upload/news/';
        $news = DB::table('news')
        ->where('id', $data['id'])
        ->where('deleted_at', null)->first();

        try {
            $response = new DataResponse();
            $thumb = $news->thumbnail;
            // upload image
            if (isset($data['image'])) {
                $img = Helper::SaveFileImg($data['image'], $folder, 'images');

                if ($img['status']) {
                    $thumb = $img['path'];
                }
                else {
                    $response->msgNo = $img['error'];
                    $response->code = ResponseCode::HAVE_ERROR;
                    return $response;
                }
            }

            if ($response->code == ResponseCode::OK) {
                $userId = Helper::GetCurrentUserId();
                // Update data
                DB::table('news')
                    // ->where('deleted_at', null)
                    ->where('id', $data['id'])
                    ->update([
                        'title' => $data['title'],
                        'thumbnail' => $thumb,
//                        'language_id' => $data['language_id'],
                        'content' => $this->formatStr(  $data['content']),
                        'website' => $data['website'],
                        'published_date' => $data['published_date'],
                        'is_published' => $data['is_published'],
                        'updated_at' => date('Y-m-d H:i:s'),
                    ]);

                $response->data['id'] = $data['id'];
            }
            return $response;
        }
        catch(\Exception $e) {
            throw $e;
        }
    }

    
    function formatStr($string) {
        $string = str_replace(PHP_EOL, "", $string);
        $string = str_replace("\t", "", $string);
        $string = str_replace("\r", "", $string);
        $string = str_replace("\n", "", $string );
        $string = str_replace('\\n', "", $string );
        return $string;
    }
    /**
     * Insert new news
     * Created: 2021/05/31
     * @author QuyPN <quy.pham@toploop.co>
     * @param  Array $data Data of news from client
     * @return Array inserted result
     */
    public function InsertNews($data)
    {

        $folder = 'upload/news/';
        try {
            $response = new DataResponse();
            $thumb = null;
            // upload image
            if (isset($data['image'])) {

                $img = Helper::SaveFileImg($data['image'], $folder, 'images');

                if ($img['status']) {
                    $thumb = $img['path'];
                }
                else {
                    $response->msgNo = $img['error'];
                    $response->code = ResponseCode::HAVE_ERROR;
                    return $response;
                }
            }

            // Insert data with main and translate language
            $news = DB::table('news')->insert([
                [
                    'title' => $data['title'],
                    'thumbnail' => $thumb,
                    'language_id' => $data['language_id'],
                    'published_date' => $data['published_date'],
                    'is_published' => $data['is_published'],
                    'content' => $data['content'],
                    'website' => $data['website'],
                    'created_at' => date('Y-m-d H:i:s'),
                ]

            ]);
            $response->data['id'] = DB::getPdo()->lastInsertId();;
            return $response;
        }
        catch(\Exception $e) {
            throw $e;
        }
    }
}