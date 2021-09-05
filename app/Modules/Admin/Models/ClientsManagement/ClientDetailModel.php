<?php

/**
 * ClientDetailModel
 * Model processing for page client detail
 *
 * 処理概要/process overview  : ClientDetailModel
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

namespace App\Modules\Admin\Models\ClientsManagement;

use Illuminate\Support\Facades\DB;
use Helper, DataResponse, ResponseCode;
use Illuminate\Support\Str;

class ClientDetailModel
{
    protected $lang;

    public function __construct() {
        $this->lang = Helper::GetCookies('lang', 'en');
    }

    /**
     * Get data client follow id
     * Created: 2021/08/15
     * @param int $id Id of client
     * @return Array Data of client
     * @throws \Exception
     * @author TriTD <tritd@toploop.co>
     */
    public function LoadClient($id)
    {
        try {
            $client = DB::table("clients")
                ->where('id', $id)
                ->where('deleted_at', null)->first();
                //->where('language_id', '=', 1)->first();
            return  $client;
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
     * Update client
     * Created: 2021/08/15
     * @param Array $data Data of client from client
     * @return Array updated result
     * @throws \Exception
     * @author TriTD <tritd@toploop.co>
     */
    public function UpdateClient($data)
    {
        $folder = 'upload/client/';
        $client = DB::table('clients')->where('id', $data['id'])->first();

        try {
            $response = new DataResponse();
            $image = $client->logo;
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
                DB::table('clients')
                    ->where('id', $data['id'])
                    ->update([
                        'name' => $data['name'],
                        'website' => $data['website'],
                        'logo' => $image,
                        'updated_at' => date('Y-m-d H:i:s')
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

    /**
     * Insert new client
     * Created: 2021/05/31
     * @param Array $data Data of client from client
     * @return Array inserted result
     * @throws \Exception
     * @author TriTD <tritd@toploop.co>
     */
    public function InsertClient($data)
    {
        $folder = 'upload/client/';
        try {
            $response = new DataResponse();
            $logo = null;
            // upload image
            if (isset($data['image'])) {
                $img = Helper::SaveFileImg($data['image'], $folder, 'images');

                if ($img['status']) {
                    $logo = $img['path'];
                }
                else {
                    $response->msgNo = $img['error'];
                    $response->code = ResponseCode::HAVE_ERROR;
                    return $response;
                }
            }

            // Insert data with main and translate language
            $client = DB::table('clients')->insert([
                [
                    'name' => $data['name'],
                    'website' => $data['website'],
                    'logo' => $logo,
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
