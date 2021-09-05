<?php

/**
 * ListOfCandidateModel
 * Model processing for page list of candidates
 *
 * 処理概要/process overview  : ListOfCandidateModel
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

namespace App\Modules\Admin\Models\CandidatesManagement;

use Illuminate\Support\Facades\DB;
use Helper, DataResponse, ResponseCode;

class ListOfCandidatesModel
{
    protected $lang;

    public function __construct() {
        $this->lang = Helper::GetCookies('lang', 'en');
    }

    /**
     * Get list of candidates follow page
     * Created: 2021/05/28
     * @param Array $condition Search condition
     * @return Array List of candidates
     * @throws \Exception
     * @author TriTD <tritd@toploop.co>
     */
    public function ListOfCandidates($condition)
    {

        try {

            $query = DB::table("candidates")
                ->select('candidates.id', 'candidates.name', 'candidates.email', 'candidates.phone',
                        'career_id', 'candidates.cv_file', 'candidates.message', 'careers.name as career_name', 'candidates.status'
                    )
                ->join('careers', 'careers.id', '=', 'candidates.career_id')
                ->whereNull('candidates.deleted_at')
                ->whereNull('careers.deleted_at');

            if(!Helper::IsNullOrEmpty($condition, 'search')){

                $query->where(function($query) use ($condition) {
                    return $query
                        ->where('candidates.name', 'LIKE', '%' . $condition['search'] . '%')
                        ->orWhere('candidates.email', 'LIKE', '%' . $condition['search'] . '%')
                        ->orWhere('candidates.phone', 'LIKE', '%' . $condition['search'] . '%');
                });
            }
            if (isset($condition['career_id'])) {
                $query->where('candidates.career_id', '=', $condition['career_id']);
            }
            $result = $query
                ->orderBy('candidates.created_at', 'desc')
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
     * Delete list candidates follow list id
     * Created: 2021/05/28
     * @param Array $ids id of candidates need to delete
     * @return DataResponse Delete result
     * @throws \Exception
     * @author TriTD <tritd@toploop.co>
     */
    public function DeleteCandidates($ids)
    {
        try {
            $response = new DataResponse();

            $userId = Helper::GetCurrentUserId();
            DB::beginTransaction();
            DB::table('candidates')
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
     * Update candidate show or hide
     * Created: 2021/05/28
     * @param Integer $id id of candidate need to update
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
            DB::table('candidates')
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
