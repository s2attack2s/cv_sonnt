<?php

/**
 * SlideDetailModel
 * Model processing for page slides detail
 *
 * 処理概要/process overview  : SlideDetailModel
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

namespace App\Modules\Admin\Models\SlidesManagement;

use Illuminate\Support\Facades\DB;
use Helper, DataResponse, ResponseCode;

class SlideDetailModel
{
    protected $lang;

    public function __construct() {
        $this->lang = Helper::GetCookies('lang', 'en');
    }

    /**
     * Get data slide follow id
     * Created: 2021/05/28
     * @author QuyPN <quy.pham@toploop.co>
     * @param  int $id Id of slide
     * @return Array Data of slide
     */
    public function LoadSlide($id)
    {
        try {
            $vi = DB::table("slides")
                ->where('id', $id)
                ->where('deleted_at', null)
                ->where('lang', 'vi')->first();
            $trans = [];
            $mode = 'I';
            if(isset($vi) && !empty($vi)) {
                $trans = DB::table("slides")
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
     * Update slide
     * Created: 2021/05/31
     * @author QuyPN <quy.pham@toploop.co>
     * @param  Array $data Data of slide from client
     * @return Array updated result
     */
    public function UpdateSlide($data)
    {
        $viImgPath = '';
        $transImgPath = '';
        $folder = 'upload_file/slides/';
        try {
            $response = new DataResponse();
            // upload image
            if (isset($data['vi']['img'])) {
                $viImg = Helper::SaveFileImg($data['vi']['img'], $folder, 'slide_vi');
                if ($viImg['status']) {
                    $viImgPath = $viImg['path'];
                }
                else {
                    $response->msgNo = $viImg['error'];
                    $response->code = ResponseCode::HAVE_ERROR;
                    return $response;
                }
            }
            if (isset($data['trans']['img'])) {
                $transImg = Helper::SaveFileImg($data['trans']['img'], $folder, 'slide_' . $data['trans']['lang']);
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
                DB::table('slides')
                    ->where('deleted_at', null)
                    ->where('id', $data['id'])
                    ->update([
                        'show' => $data['vi']['show'],
                        'updated_at' => date('Y-m-d H:i:s'),
                        'updated_by' =>$userId
                    ]);
                DB::table('slides')
                    ->where('deleted_at', null)
                    ->where('lang', 'vi')
                    ->where('id', $data['id'])
                    ->update([
                        'img' => $viImgPath == '' ? $data['vi']['image'] : $viImgPath,
                        'link' => $data['vi']['link'],
                        'text' => $data['vi']['text'],
                        'updated_at' => date('Y-m-d H:i:s'),
                        'updated_by' =>$userId
                    ]);
                if ($data['will_trans'] == 1) {
                    DB::table('slides')
                        ->where('deleted_at', null)
                        ->where('lang', $data['trans']['lang'])
                        ->where('id', $data['id'])
                        ->update([
                            'img' => $transImgPath == '' ? $data['trans']['image'] : $transImgPath,
                            'link' => $data['trans']['link'],
                            'text' => $data['trans']['text'],
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

    /**
     * Insert new slide
     * Created: 2021/05/31
     * @author QuyPN <quy.pham@toploop.co>
     * @param  Array $data Data of slide from client
     * @return Array inserted result
     */
    public function InsertSlide($data)
    {
        $viImgPath = '';
        $transImgPath = '';
        $folder = 'upload_file/slides/';
        try {
            $response = new DataResponse();
            // upload image
            $viImg = Helper::SaveFileImg($data['vi']['img'], $folder, 'slide_vi');
            if ($viImg['status']) {
                $viImgPath = $viImg['path'];
            }
            else {
                $response->msgNo = $viImg['error'];
                $response->code = ResponseCode::HAVE_ERROR;
                return $response;
            }
            if (isset($data['trans']['img'])) {
                $transImg = Helper::SaveFileImg($data['trans']['img'], 'slide_' . $data['trans']['lang']);
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
                $newId = Helper::GetId('slides');
                $userId = Helper::GetCurrentUserId();
                // Insert data with main and translate language
                DB::table('slides')->insert([
                    [
                        'id' =>  $newId,
                        'lang' => 'vi',
                        'img' => $viImgPath,
                        'link' => $data['vi']['link'],
                        'text' => $data['vi']['text'],
                        'order' => $newId,
                        'show' => $data['vi']['show'],
                        'created_by' => $userId,
                        'created_at' => date('Y-m-d H:i:s')
                    ],
                    [
                        'id' =>  $newId,
                        'lang' => $data['trans']['lang'],
                        'img' => $transImgPath,
                        'link' => $data['trans']['link'],
                        'text' => $data['trans']['text'],
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
                        DB::table('slides')->insert([
                            'id' =>  $newId,
                            'lang' => $lang->code,
                            'img' => $viImgPath,
                            'link' => $data['vi']['link'],
                            'text' => $data['vi']['text'],
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
}
