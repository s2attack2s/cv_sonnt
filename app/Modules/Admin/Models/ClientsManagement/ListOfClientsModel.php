<?php

/**
 * ListOfClientModel
 * Model processing for page list of clients
 *
 * 処理概要/process overview  : ListOfClientModel
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

namespace App\Modules\Admin\Models\ClientsManagement;

use Illuminate\Support\Facades\DB;
use Helper, DataResponse, ResponseCode;

class ListOfClientsModel
{
    protected $lang;

    public function __construct() {
        $this->lang = Helper::GetCookies('lang', 'en');
    }

    /**
     * Get list of clients follow page
     * Created: 2021/08/15
     * @param Array $condition Search condition
     * @return Array List of clients
     * @throws \Exception
     * @author TriTD <tritd@toploop.co>
     */
    public function ListOfClients($condition)
    {
        try {

            $query = DB::table("clients")
                ->select('id', 'language_id', 'name', 'website', 'logo', 'image', 'desc')
                ->whereNull('deleted_at');

            if(!Helper::IsNullOrEmpty($condition, 'search')){
                $query->where('name', 'LIKE', '%' . $condition['search'] . '%');
                #$query->orWhere('short_desc', 'LIKE', '%' . $condition['search'] . '%');
            }

            $result = $query
                ->orderBy('created_at', 'desc')
                ->paginate(
                    !Helper::IsNullOrEmpty($condition, 'per_page') ? $condition['per_page'] : 10,
                            ['*'], 'page',
                    !Helper::IsNullOrEmpty($condition, 'current_page') ? $condition['current_page'] : 1
                    )->toArray();
            return  $result;
        }
        catch(\Exception $e) {
            throw $e;
        }
    }

    /**
     * Delete list clients follow list id
     * Created: 2021/08/15
     * @param Array $ids id of clients need to delete
     * @return DataResponse Delete result
     * @throws \Exception
     * @author TriTD <tritd@toploop.co>
     */
    public function DeleteClients($ids)
    {
        try {
            $response = new DataResponse();

            $userId = Helper::GetCurrentUserId();
            DB::beginTransaction();
            DB::table('clients')
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
     * Update client show or hide
     * Created: 2021/08/15
     * @param Integer $id id of client need to update
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
            DB::table('clients')
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
