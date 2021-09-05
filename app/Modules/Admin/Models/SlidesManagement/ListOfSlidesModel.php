<?php

/**
 * ListOfSlidesModel
 * Model processing for page list of slides
 *
 * 処理概要/process overview  : ListOfSlidesModel
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

namespace App\Modules\Admin\Models\SlidesManagement;

use Illuminate\Support\Facades\DB;
use Helper, DataResponse, ResponseCode;

class ListOfSlidesModel
{
    protected $lang;

    public function __construct() {
        $this->lang = Helper::GetCookies('lang', 'en');
    }

    /**
     * Get list of slides follow page
     * Created: 2021/05/28
     * @author QuyPN <quy.pham@toploop.co>
     * @param  Array $condition Search condition
     * @return Array List of slides
     */
    public function ListOfSlides($condition)
    {
        try {
            $query = DB::table("slides")
                ->where('lang', $this->lang)
                ->where('deleted_at', null);
            if(!Helper::IsNullOrEmpty($condition, 'search')){
                $query->where('text', 'LIKE', '%' . $condition['search'] . '%');
            }
            return $query
                ->select('id', 'img', 'link', 'text', 'show')
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
     * Delete list slides follow list id
     * Created: 2021/05/28
     * @author QuyPN <quy.pham@toploop.co>
     * @param  Array $ids id of slides need to delete
     * @return DataResponse Delete result
     */
    public function DeleteSlides($ids)
    {
        try {
            $response = new DataResponse();
            $count = DB::table('slides')
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
                DB::table('slides')
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
            $count = DB::table('slides')
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
                DB::table('slides')
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
