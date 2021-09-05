<?php

/**
 * ListOfUsersModel
 * Model processing for page list of Users
 *
 * 処理概要/process overview  : ListOfUsersModel
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

namespace App\Modules\Admin\Models\UsersManagement;

use Illuminate\Support\Facades\DB;
use Helper, DataResponse, ResponseCode;

class ListOfUsersModel
{

    /**
     * Get list of Users follow page
     * Created: 2021/05/28
     * @author Sonnt <ntson12a4@gmail.com>
     * @param  Array $condition Search condition
     * @return Array List of Users
     */
    public function ListOfUsers($condition)
    {
        try {
            $userId = Helper::GetCurrentUserId();
            $query = DB::table("users")
                ->where('id', '!=', $userId)
                ->where('deleted_at', null);
            if (!Helper::IsNullOrEmpty($condition, 'search')) {
                $query->where('name', 'LIKE', '%' . $condition['search'] . '%');
                $query->orWhere('username', 'LIKE', '%' . $condition['search'] . '%');
                $query->where('id', '!=', $userId);
            }
            return $query
                ->select('*')
                ->orderBy('created_at', 'desc')
                ->paginate(
                    !Helper::IsNullOrEmpty($condition, 'per_page') ? $condition['per_page'] : 10,
                    [
                        'page' => !Helper::IsNullOrEmpty($condition, 'current_page') ? $condition['current_page'] : 1
                    ]
                )->toArray();
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Delete list Users follow list id
     * Created: 2021/05/28
     * @author Sonnt <ntson12a4@gmail.com>
     * @param  Array $ids id of Users need to delete
     * @return DataResponse Delete result
     */
    public function DeleteUsers($ids)
    {
        try {
            $response = new DataResponse();
            $userId = Helper::GetCurrentUserId();
            $count = DB::table('users')
                ->whereNotIn('id', $ids)
                ->where('deleted_at', null)
                ->count();
        
                $userId = Helper::GetCurrentUserId();
                DB::beginTransaction();
                DB::table('users')
                    ->where('id', '!=', $userId)
                    ->whereIn('id', $ids)
                    ->where('deleted_at', null)
                    ->update([
                        'deleted_at' => date('Y-m-d H:i:s'),
                        'deleted_by' => $userId
                    ]);
                DB::commit();
            
            return $response;
        } catch (\Exception $e) {
            Helper::RollBackTrans();
            throw $e;
        }
    }
}
