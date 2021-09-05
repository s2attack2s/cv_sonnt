<?php

/**
 * OurStoriesDetailModel
 * Model processing for page stories detail
 *
 * 処理概要/process overview  : OurStoriesDetailModel
 * 作成日/create date         : 2021/06/02
 * 作成者/creater             : Trung
 *
 * 更新日/update date         :
 * 更新者/updater             :
 * 更新内容 /update content   :
 *
 * @package Modules/Admin
 * @copyright Copyright (c) toploop.co
 * @version 1.0.0
 */

namespace App\Modules\Admin\Models\OurStoriesManagement;

use Illuminate\Support\Facades\DB;
use Helper, DataResponse, ResponseCode;

class OurStoriesDetailModel
{
    protected $lang;

    public function __construct() {
        $this->lang = Helper::GetCookies('lang', 'en');
    }

    /**
     * Get data stories follow id
     * Created: 2021/06/02
     * @author Trung
     * @param  int $id Id of story
     * @return Array Data of story
     */
    public function LoadOurStories($id)
    {
        try {
            $vi = DB::table("stories")
                ->where('id', $id)
                ->where('deleted_at', null)
                ->where('lang', 'vi')->first();
            $trans = [];
            $mode = 'I';
            if(isset($vi) && !empty($vi)) {
                $trans = DB::table("stories")
                    ->where('id', $id)
                    ->where('deleted_at', null)
                    ->where('lang', 'en')->first();
                $mode = 'U';
                $vi->created_by = Helper::GetUsername($vi->created_by);
                $vi->updated_by = Helper::GetUsername($vi->updated_by);
            }
            return [
                'vi'    => $vi,
                'trans' => $trans,
                'mode'  => $mode
            ];
        }
        catch(\Exception $e) {
            throw $e;
        }
    }

    /**
     * Insert new stories
     * Created: 2021/06/03
     * @author Trung
     * @param  Array $data Data of story from client
     * @return Array inserted result
     */
    public function InsertOurStories($data)
    {
        $viImgPath = '';
        $transImgPath = '';
        $folder = 'upload_file/stories/';
        try {
            $response = new DataResponse();
            // upload image
            $viImg = Helper::SaveFileImg($data['vi']['logo'], $folder, 'stories_vi');
            if ($viImg['status']) {
                $viImgPath = $viImg['path'];
            }
            else {
                $response->msgNo = $viImg['error'];
                $response->code = ResponseCode::HAVE_ERROR;
                return $response;
            }
            if (isset($data['trans']['img'])) {
                $transImg = Helper::SaveFileImg($data['trans']['logo'], 'stories_' . $data['trans']['lang']);
                if ($transImg['status']) {
                    $transImgPath = $transImg['path'];
                }
                else {
                    $response->msgNo = $transImg['error'];
                    $response->code = ResponseCode::HAVE_ERROR;
                    Helper::DeleteFile($viImgPath);
                    return $response;
                }
            }
            else {
                $transImgPath = $viImgPath;
            }
            if ($response->code == ResponseCode::OK) {
                $newId = Helper::GetId('stories');
                $userId = Helper::GetCurrentUserId();
                // Insert data with main and translate language
                DB::table('stories')->insert([
                    [
                        'id' =>  $newId,
                        'lang' => 'vi',
                        'logo' => $viImgPath,
                        'title' => $data['vi']['title'],
                        'url' => $data['vi']['url'],
                        'description' => $data['vi']['description'],
                        'order' => $newId,
                        'show' => $data['vi']['show'],
                        'created_by' => $userId,
                        'created_at' => date('Y-m-d H:i:s')
                    ],
                    [
                        'id' =>  $newId,
                        'lang' => $data['trans']['lang'],
                        'logo' => $transImgPath,
                        'title' => $data['trans']['title'],
                        'url' => $data['trans']['url'],
                        'description' => $data['trans']['description'],
                        'order' => $newId,
                        'show' => $data['vi']['show'],
                        'created_by' => $userId,
                        'created_at' => date('Y-m-d H:i:s')
                    ]
                ]);
                // insert data for other language if exists
                $langs = Helper::GetLanguages();
                foreach($langs as $key => $lang) {
                    if($lang->code != $data['trans']['lang']) {
                        DB::table('stories')->insert([
                            'id' =>  $newId,
                            'lang' => $lang->code,
                            'logo' => $viImgPath,
                            'title' => $data['vi']['title'],
                            'url' => $data['vi']['url'],
                            'description' => $data['vi']['description'],
                            'order' => $newId,
                            'show' => $data['vi']['show'],
                            'created_by' => $userId,
                            'created_at' => date('Y-m-d H:i:s')
                        ]);
                    }
                }
                $response->data['id'] = $newId;
            }
            return $response;
        }
        catch(\Exception $e) {
            Helper::DeleteFile($viImgPath);
            Helper::DeleteFile($transImgPath);
            throw $e;
        }
    }

    /**
     * Update story
     * Created: 2021/06/03
     * @author Trung
     * @param  Array $data Data of story from client
     * @return Array updated result
     */
    public function UpdateOurStories($data)
    {
        $viImgPath = '';
        $transImgPath = '';
        $folder = 'upload_file/stories/';
        try {
            $response = new DataResponse();
            // upload image
            if (isset($data['vi']['logo'])) {
                $viImg = Helper::SaveFileImg($data['vi']['logo'], $folder, 'stories_vi');
                if ($viImg['status']) {
                    $viImgPath = $viImg['path'];
                }
                else {
                    $response->msgNo = $viImg['error'];
                    $response->code = ResponseCode::HAVE_ERROR;
                    return $response;
                }
            }
            if (isset($data['trans']['logo'])) {
                $transImg = Helper::SaveFileImg($data['trans']['logo'], $folder, 'stories_' . $data['trans']['lang']);
                if ($transImg['status']) {
                    $transImgPath = $transImg['path'];
                }
                else {
                    $response->msgNo = $transImg['error'];
                    $response->code = ResponseCode::HAVE_ERROR;
                    Helper::DeleteFile($viImgPath);
                    return $response;
                }
            }
            if ($response->code == ResponseCode::OK) {
                $userId = Helper::GetCurrentUserId();
                // Update data
                DB::table('stories')
                    ->where('deleted_at', null)
                    ->where('id', $data['id'])
                    ->update([
                        'show' => $data['vi']['show'],
                        'updated_at' => date('Y-m-d H:i:s'),
                        'updated_by' =>$userId
                    ]);
                DB::table('stories')
                    ->where('deleted_at', null)
                    ->where('lang', 'vi')
                    ->where('id', $data['id'])
                    ->update([
                        'logo' => $viImgPath == '' ? $data['vi']['logo'] : $viImgPath,
                        'title' => $data['vi']['title'],
                        'url' => $data['vi']['url'],
                        'description' => $data['vi']['description'],
                        'updated_at' => date('Y-m-d H:i:s'),
                        'updated_by' =>$userId
                    ]);
                if ($data['will_trans'] == 1) {
                    DB::table('stories')
                        ->where('deleted_at', null)
                        ->where('lang', $data['trans']['lang'])
                        ->where('id', $data['id'])
                        ->update([
                            'logo' => $transImgPath == '' ? $data['trans']['logo'] : $transImgPath,
                            'url' => $data['trans']['url'],
                            'description' => $data['trans']['description'],
                            'updated_at' => date('Y-m-d H:i:s'),
                            'updated_by' =>$userId
                        ]);
                }
                $response->data['id'] = $data['id'];
            }
            return $response;
        }
        catch(\Exception $e) {
            Helper::DeleteFile($viImgPath);
            Helper::DeleteFile($transImgPath);
            throw $e;
        }
    }
}
