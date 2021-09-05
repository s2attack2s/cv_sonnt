<?php

/**
 * ListOfCareerModel
 * Model processing for page list of careers
 *
 * 処理概要/process overview  : ListOfCareerModel
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

class ListOfCareersModel
{
    protected $lang;

    public function __construct() {
        $this->lang = Helper::GetCookies('lang', 'en');
    }

    /**
     * Get list of careers follow page
     * Created: 2021/05/28
     * @param Array $condition Search condition
     * @return Array List of careers
     * @throws \Exception
     * @author TriTD <tritd@toploop.co>
     */
    public function ListOfCareers($condition)
    {
        try {

            $query = DB::table("careers")
                ->select('careers.id', 'careers.language_id', 'careers.name', 'job_type_id', 'careers.image', 'short_desc',
                    'location_id', 'start_at', 'finish_at', 'quantity', 'status', 'salary', 'detail', 'skill_required',
                    'priority', 'benefit', 'careers.created_at', 'careers.updated_at', 'locations.name as location_name')
                ->leftJoin('locations', 'careers.location_id', '=', 'locations.id')
                ->whereNull('careers.deleted_at');

            if(!Helper::IsNullOrEmpty($condition, 'search')){
                $query->where('careers.name', 'LIKE', '%' . $condition['search'] . '%');
                #$query->orWhere('short_desc', 'LIKE', '%' . $condition['search'] . '%');
            }

            if($condition && $condition['language_id']) {
                $query->where('careers.language_id', '=', $condition['language_id']);
            }
            if($condition && $condition['location_id']) {
                $query->where('careers.location_id', '=', $condition['location_id']);
            }
            $result = $query
                ->orderBy('created_at', 'desc')
                ->paginate(
                    !Helper::IsNullOrEmpty($condition, 'per_page') ? $condition['per_page'] : 10,
                    ['*'],
                    'page',
                    !Helper::IsNullOrEmpty($condition, 'current_page') ? $condition['current_page'] : 1
                    )->toArray();
            return  $result;
        }
        catch(\Exception $e) {
            throw $e;
        }
    }

    /**
     * Delete list careers follow list id
     * Created: 2021/05/28
     * @param Array $ids id of careers need to delete
     * @return DataResponse Delete result
     * @throws \Exception
     * @author TriTD <tritd@toploop.co>
     */
    public function DeleteCareers($ids)
    {
        try {
            $response = new DataResponse();

            $userId = Helper::GetCurrentUserId();
            DB::beginTransaction();
            DB::table('careers')
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
     * Update career show or hide
     * Created: 2021/05/28
     * @param Integer $id id of career need to update
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
            DB::table('careers')
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
