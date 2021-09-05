<?php

/**
 * CareerDetailModel
 * Model processing for page career detail
 *
 * 処理概要/process overview  : CareerDetailModel
 * 作成日/create date         : 2021/05/28
 * 作成者/creater             : TriTD
 *
 * 更新日/update date         :
 * 更新者/updater             :
 * 更新内容 /update content   :
 *
 * @package Modules/Admin
 * @copyright Copyright (c) toploop.co
 * @version 1.0.0
 */

namespace App\Modules\Admin\Models\CareersManagement;

use Illuminate\Support\Facades\DB;
use Helper, DataResponse, ResponseCode;
use Illuminate\Support\Str;

class CareerDetailModel
{
    protected $lang;

    public function __construct() {
        $this->lang = Helper::GetCookies('lang', 'en');
    }

    /**
     * Get data career follow id
     * Created: 2021/05/28
     * @param int $id Id of career
     * @return Array Data of career
     * @throws \Exception
     * @author TriTD <tritd@toploop.co>
     */
    public function LoadCareer($id)
    {
        try {
            $career = DB::table("careers")
                ->where('id', $id)
                ->where('deleted_at', null)->first();
                //->where('language_id', '=', 1)->first();
            return  $career;
        }
        catch(\Exception $e) {
            throw $e;
        }
    }

    public function LoadListJobTypes() {
        try {
            $types = DB::table("job_types")
                ->pluck('name', 'id');

            return  $types;
        }
        catch(\Exception $e) {
            throw $e;
        }
    }

    /**
     * Update career
     * Created: 2021/05/31
     * @param Array $data Data of career from client
     * @return Array updated result
     * @throws \Exception
     * @author TriTD <tritd@toploop.co>
     */
    public function UpdateCareer($data)
    {

        $folder = 'upload/career/';
        $career = DB::table("careers")
            ->where('id', $data['id'])
            ->where('deleted_at', null)->first();
        try {
            $response = new DataResponse();
            $image = $career->image;
            // upload image
            if (isset($data['image'])) {

                $img = Helper::SaveFileImg($data['image'], $folder, 'images');

                if ($img['status']) {
                    $image = $img['path'];
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
                DB::table('careers')
                    //->where('deleted_at', null)
                    ->where('id', $data['id'])
                    ->update([
                        'name' => $data['name'],
                        'image' => $image,
                        'language_id' => $data['language_id'],
                        'location_id' => $data['location_id'],
                        'job_type_id' => $data['job_type_id'],
                        'salary' => $data['salary'],
                        'quantity' => $data['quantity'],
                        'detail' => $this->formatStr(  $data['detail']),
                        'short_desc' => $this->formatStr( $data['short_desc']), //$data['short_desc'],
                        'skill_required' => $this->formatStr( $data['skill_required']),
                        'benefit' => $this->formatStr( $data['benefit']),
                        'priority' => $this->formatStr(  $data['priority']),
                        'status' => $data['status'],
                        'start_at' => $data['start_at'],
                        'finish_at' => $data['finish_at'],
                        'contact' => $this->formatStr($data['contact']),
                        'updated_at' => date('Y-m-d H:i:s'),
                    ]);

                $response->data['id'] = $data['id'];
            }
            return $response;
        }
        catch(\Exception $e) {
//            Helper::DeleteFile($viImgPath);
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
     * Insert new career
     * Created: 2021/05/31
     * @param Array $data Data of career from client
     * @return Array inserted result
     * @throws \Exception
     * @author TriTD <tritd@toploop.co>
     */
    public function InsertCareer($data)
    {
        $folder = 'upload/career/';
        try {
            $response = new DataResponse();
            $image = null;
            // upload image
            if (isset($data['image'])) {
                $img = Helper::SaveFileImg($data['image'], $folder, 'images');

                if ($img['status']) {
                    $image = $img['path'];
                }
                else {
                    $response->msgNo = $img['error'];
                    $response->code = ResponseCode::HAVE_ERROR;
                    return $response;
                }
            }

            // Insert data with main and translate language
            $career = DB::table('careers')->insert([
                [
                    'name' => $data['name'],
                    'image' => $image,
                    'job_type_id' => $data['job_type_id'],
                    'start_at' => $data['start_at'],
                    'finish_at' => $data['finish_at'],
                    'language_id' => $data['lang_id'],
                    'location_id' => $data['location_id'],
                    'salary' => $data['salary'],
                    'quantity' => $data['quantity'],
                    'detail' => $data['detail'],
                    'short_desc' => $data['short_desc'],
                    'skill_required' => $data['skill_required'],
                    'benefit' => $data['benefit'],
                    'priority' => $data['priority'],
                    'contact' => $data['contact'],
                    'created_at' => date('Y-m-d H:i:s'),
                    'status' => $data['status'],
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
