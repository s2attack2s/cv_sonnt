<?php

/**
 * LocationDetailModel
 * Model processing for page location detail
 *
 * 処理概要/process overview  : LocationDetailModel
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

namespace App\Modules\Admin\Models\LocationsManagement;

use Illuminate\Support\Facades\DB;
use Helper, DataResponse, ResponseCode;
use Illuminate\Support\Str;

class LocationDetailModel
{
    protected $lang;

    public function __construct() {
        $this->lang = Helper::GetCookies('lang', 'en');
    }

    /**
     * Get data location follow id
     * Created: 2021/08/16
     * @param int $id Id of location
     * @return Array Data of location
     * @throws \Exception
     * @author TriTD <tritd@toploop.co>
     */
    public function LoadLocation($id)
    {
        try {

            $location = DB::table("locations")
                ->where('id', $id)
                ->where('deleted_at', null)->first();
                //->where('language_id', '=', 1)->first();
            return  $location;
        }
        catch(\Exception $e) {
            throw $e;
        }
    }

    /**
     * @return \Illuminate\Support\Collection
     * @throws \Exception
     */
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
     * Update location
     * Created: 2021/08/16
     * @param Array $data Data of location from location
     * @return Array updated result
     * @throws \Exception
     * @author TriTD <tritd@toploop.co>
     */
    public function UpdateLocation($data)
    {
        $folder = 'upload/location/';
        $location = DB::table('locations')->where('id', $data['id'])->first();

        try {
            $response = new DataResponse();
            $image = $location->image;
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

                // Update data
                DB::table('locations')
                    ->where('id', $data['id'])
                    ->update([
                        'name' => $data['name'],
                        'head_office' => $data['head_office'],
                        'sales_office' => $data['sales_office'],
                        'head_iframe' => $data['head_iframe'],
                        'sales_iframe' => $data['sales_iframe'],
                        'phone' => $data['phone'],
                        'image' => $image,
                        'updated_at' => date('Y-m-d H:i:s')
                    ]);

                $response->data['id'] = $data['id'];
            }
            return $response;
        }
        catch(\Exception $e) {
            throw $e;
        }
    }

    /**
     * Insert new location
     * Created: 2021/08/16
     * @param Array $data Data of location from location
     * @return Array inserted result
     * @throws \Exception
     * @author TriTD <tritd@toploop.co>
     */
    public function InsertLocation($data)
    {
        $folder = 'upload_file/location/';
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
            $location = DB::table('locations')->insert([
                [
                    'name' => $data['name'],
                    'image' => $image,
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
