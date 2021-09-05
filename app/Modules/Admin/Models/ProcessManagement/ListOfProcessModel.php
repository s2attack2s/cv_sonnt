<?php

/**
 * ListOfProcessModel
 * Model processing for page list of slides
 *
 * 処理概要/process overview  : ListOfProcessModel
 * 作成日/create date         : 2021/06/01
 * 作成者/creater             : DinhAn
 *
 * 更新日/update date         :
 * 更新者/updater             :
 * 更新内容 /update content   :
 *
 * @package Modules/Admin
 * @copyright Copyright (c) toploop.co
 * @version 1.0.0
 */

namespace App\Modules\Admin\Models\ProcessManagement;

use Illuminate\Support\Facades\DB;
use Helper, DataResponse, ResponseCode;

class ListOfProcessModel
{
    protected $lang;

    public function __construct() {
        $this->lang = Helper::GetCookies('lang', 'en');
    }

    /**
     * Get list of process follow page
     * Created: 2021/06/01
     * @author DinhAn <dinhan0209@gmail.com>
     * @param  Array $condition Search condition
     * @return Array List of process
     */
    public function ListOfProcess($condition)
    {
        try {
            $query = DB::table("process")
                ->where('lang', $this->lang)
                ->where('deleted_at', null);
            if(!Helper::IsNullOrEmpty($condition, 'search')){
                $query->where('title', 'LIKE', '%' . $condition['search'] . '%');
            }
            return $query
                ->select('id', 'title', 'description', 'content','show')
                ->orderBy('created_at', 'desc')
                ->paginate(
                    !Helper::IsNullOrEmpty($condition, 'per_page') ? $condition['per_page'] : 10,
                    [
                        'page' => !Helper::IsNullOrEmpty($condition, 'current_page') ? $condition['current_page'] : 1
                    ])->toArray();

        }
        catch(\Exception $e) {
            throw $e;
        }
    }

    /**
     * Delete list process follow list id
     * Created: 2021/06/01
     * @author DinhAn <dinhan0209@gmail.com>
     * @param  Array $ids id of process need to delete
     * @return DataResponse Delete result
     */
    public function DeleteProcess($ids)
    {
        try {
            $response = new DataResponse();
            $count = DB::table('process')
                ->whereNotIn('id', $ids)
                ->where('show', true)
                ->where('deleted_at', null)
                ->count();
            if($count / 2 < 1) {
                $response->msgNo = 'E026';
                $response->code = ResponseCode::HAVE_ERROR;
            }
            else {
                $userId = Helper::GetCurrentUserId();
                DB::beginTransaction();
                DB::table('process')
                    ->whereIn('id', $ids)
                    ->where('deleted_at', null)
                    ->update([
                        'deleted_at' => date('Y-m-d H:i:s'),
                        'deleted_by' => $userId
                    ]);
                DB::commit();
            }
            return $response;
        }
        catch(\Exception $e) {
            Helper::RollBackTrans();
            throw $e;
        }
    }

    /**
     * Update process show or hide
     * Created: 2021/06/01
     * @author DinhAn <dinhan0209@gmail.com>
     * @param  Integer $id id of process need to update
     * @param  Boolean $status status will update
     * @return DataResponse Updated result
     */
    public function UpdateStatus($id, $status)
    {
        try {
            $response = new DataResponse();
            $count = DB::table('process')
                ->where('id', '<>', $id)
                ->where('show', 1)
                ->where('deleted_at', null)
                ->count();
            if($count / 2 < 1 && $status === 'false') {

                $response->msgNo = 'E026';
                $response->code = ResponseCode::HAVE_ERROR;
            }
            else {
                $userId = Helper::GetCurrentUserId();
                DB::beginTransaction();
                DB::table('process')
                    ->where('id', $id)
                    ->where('deleted_at', null)
                    ->update([
                        'show' => $status === 'true' ? 1 : 0,
                        'updated_at' => date('Y-m-d H:i:s'),
                        'updated_by' => $userId
                    ]);
                DB::commit();
            }
            return $response;
        }
        catch(\Exception $e) {
            Helper::RollBackTrans();
            throw $e;
        }
    }
    
}
