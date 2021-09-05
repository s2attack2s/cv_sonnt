<?php

/**
 * ListOfLocationModel
 * Model processing for page list of locations
 *
 * 処理概要/process overview  : ListOfLocationModel
 * 作成日/create date         : 2021/08/15
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

class ListOfLocationsModel
{
    protected $lang;

    public function __construct() {
        $this->lang = Helper::GetCookies('lang', 'en');
    }

    /**
     * Get list of locations follow page
     * Created: 2021/08/16
     * @param Array $condition Search condition
     * @return Array List of locations
     * @throws \Exception
     * @author TriTD <tritd@toploop.co>
     */
    public function ListOfLocations($condition)
    {
        try {
            $query = DB::table("locations")
                ->select('id', 'language_id', 'name', 'image','head_office', 'sales_office', 'head_iframe','sales_iframe', 'phone')
                ->whereNull('deleted_at');


            $result = $query
                ->orderBy('created_at', 'desc')
                ->get()->toArray();
            return  $result;
        }
        catch(\Exception $e) {
            throw $e;
        }
    }

    /**
     * Delete list locations follow list id
     * Created: 2021/08/16
     * @param Array $ids id of locations need to delete
     * @return DataResponse Delete result
     * @throws \Exception
     * @author TriTD <tritd@toploop.co>
     */
    public function DeleteLocations($ids)
    {
        try {
            $response = new DataResponse();

            $userId = Helper::GetCurrentUserId();
            DB::beginTransaction();
            DB::table('locations')
                ->whereIn('id', $ids)
                ->where('deleted_at', null)
                ->update([
                    'deleted_at' => date('Y-m-d H:i:s'),
//                    'deleted_by' => $userId
                ]);
            DB::commit();

            return $response;
        }
        catch(\Exception $e) {
            Helper::RollBackTrans();
            throw $e;
        }
    }

    /**
     * Update location show or hide
     * Created: 2021/08/16
     * @param Integer $id id of location need to update
     * @param Boolean $status status will update
     * @return DataResponse Updated result
     * @throws \Exception
     * @author TriTD <tritd@toploop.co>
     */
    public function UpdateStatus($id, $status)
    {
        try {
            $response = new DataResponse();

            DB::beginTransaction();
            DB::table('locations')
                ->where('id', $id)
                ->where('deleted_at', null)
                ->update([
                    'status' => $status === 'true' ? 1 : 0,
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
            DB::commit();

            return $response;
        }
        catch(\Exception $e) {
            Helper::RollBackTrans();
            throw $e;
        }
    }
}
