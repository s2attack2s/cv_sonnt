<?php

/**
 * ListOfChallengesModel
 * Model processing for page list of challenges
 *
 * 処理概要/process overview  : ListOfChallengesModel
 * 作成日/create date         : 2021/06/02
 * 作成者/creater             : AnhHT
 *
 * 更新日/update date         :
 * 更新者/updater             :
 * 更新内容 /update content   :
 *
 * @package Modules/Admin
 * @copyright Copyright (c) toploop.co
 * @version 1.0.0
 */

namespace App\Modules\Admin\Models\ChallengesManagement;

use Illuminate\Support\Facades\DB;
use Helper, DataResponse, ResponseCode;


class ListOfChallengesModel
{
    protected $lang;

    public function __construct() {
        $this->lang = Helper::GetCookies('lang', 'en');
    }

    /**
     * Get list of challenges follow page
     * Created: 2021/006/02
     * @author AnhHT <tienanhbk96@gmail.com>
     * @param  Array $condition Search condition
     * @return Array List of challenges
     */
    public function ListOfChallenges($condition)
    {
        try {
            $query = DB::table("challenges")
                ->where('deleted_at', null);

            if(!Helper::IsNullOrEmpty($condition, 'search')){
                $query->where('fullname', 'LIKE', '%' . $condition['search'] . '%')
                      ->orWhere('email', 'LIKE', '%' . $condition['search'] . '%')
                        ->where('deleted_at', null);
            }
            
            return $query
                ->select('id', 'fullname', 'email', 'phone', 'company', 'industry', 'content', 'status')
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
     * Get  status value of challenges form
     * Created: 2021/06/02
     * @author AnhHT <tienanhbk96@gmail.com>
     * @param  
     * @return status value of challenges form
     */
    public function GetCombobox(){
        try {
            return DB::table('libraries')
                ->where('libraries.lang', $this->lang)
                ->where('libraries.deleted_at', '=', null)
                ->select(
                    'libraries.number as id',
                    'libraries.name as name'
                )
                ->get()->toArray();
        }
        catch(\Exception $e) {
            throw $e;
        }
    }

     /**
     * Delete list challenges follow list id
     * Created: 2021/06/02
     * @author AnhHT <tienanhbk96@gmail.com>
     * @param  Array $ids id of challenges need to delete
     * @return DataResponse Delete result
     */
    public function DeleteChallenges($ids)
    {
        try {
            $response = new DataResponse();
            $userId = Helper::GetCurrentUserId();
            DB::beginTransaction();
            DB::table('challenges')
                ->whereIn('id', $ids)
                ->where('deleted_at', null)
                ->update([
                    'deleted_at' => date('Y-m-d H:i:s'),
                    'deleted_by' => $userId
                ]);
            
            $count = DB::table('challenges')
            ->where('status', 1)
            ->where('deleted_at', null)
            ->count();
            $response->data = $count;

            DB::commit();
            return $response;
        }
        catch(\Exception $e) {
            Helper::RollBackTrans();
            throw $e;
        }
    }

    /**
     * Update status of challenges form
     * Created: 2021/06/02
     * @author AnhHT <tienanhbk96@gmail.com>
     * @param  Integer $id id of challenges need to update
     * @param  Boolean $status status will update
     * @return DataResponse Updated result
     */
    public function UpdateChallenges($id, $status)
    {
        try {
            $response = new DataResponse();
            $userId = Helper::GetCurrentUserId();
            DB::beginTransaction();
            DB::table('challenges')
                ->where('id', $id)
                ->where('deleted_at', null)
                ->update([
                    'status' => $status,
                    'updated_at' => date('Y-m-d H:i:s'),
                    'updated_by' => $userId
                ]);

            $count = DB::table('challenges')
            ->where('status', 1)
            ->where('deleted_at', null)
            ->count();
            $response->data = $count;

            DB::commit();
            return $response;
        }
        catch(\Exception $e) {
            Helper::RollBackTrans();
            throw $e;
        }
    }

}