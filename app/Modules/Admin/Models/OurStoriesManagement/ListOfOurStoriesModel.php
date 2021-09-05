<?php

/**
 * ListOfOurStories
 * Model processing for page list of our stories
 *
 * 処理概要/process overview  : ListOfOurStoriesModel
 * 作成日/create date         : 2021/06/01
 * 作成者/creater             : Trung
 *
 * 更新日/update date         :
 * 更新者/updater             :
 * 更新内容 /update content   :
 *
 * @package Modules/Admin
 * @copyright Copyright (c) toploop.co
 * @version 1.0.0
 */

namespace App\Modules\Admin\Models\OurStoriesManagement;

use Illuminate\Support\Facades\DB;
use Helper, DataResponse, ResponseCode;

class ListOfOurStoriesModel
{
    protected $lang;

    public function __construct() {
        $this->lang = Helper::GetCookies('lang', 'en');
    }

    /**
     * Get list of out stories follow page
     * Created: 2021/06/01
     * @author Trung
     * @param  Array $condition Search condition
     * @return Array List of our stories
     */
    public function ListOfOurStories($condition)
    {
        try {
            $query = DB::table("stories")
                ->where('lang', $this->lang)
                ->where('deleted_at', null);
            if(!Helper::IsNullOrEmpty($condition, 'search')){
                $query->where('title', 'LIKE', '%' . $condition['search'] . '%');
            }
            return $query
                ->select('id', 'title', 'description', 'logo', 'url','show')
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
     * Delete list stories follow list id
     * Created: 2021/06/03
     * @author Trung
     * @param  Array $ids id of stories need to delete
     * @return DataResponse Delete result
     */
    public function DeleteOurStories($ids)
    {
        try {
            $response = new DataResponse();
            $count = DB::table('stories')
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
                DB::table('stories')
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
     * Update slide show or hide
     * Created: 2021/05/28
     * @author QuyPN <quy.pham@toploop.co>
     * @param  Integer $id id of slide need to update
     * @param  Boolean $status status will update
     * @return DataResponse Updated result
     */
    public function UpdateStatus($id, $status)
    {
        try {
            $response = new DataResponse();
            $count = DB::table('stories')
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
                DB::table('stories')
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
