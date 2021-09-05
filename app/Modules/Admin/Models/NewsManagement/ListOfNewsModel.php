<?php

/**
 * ListOfNewsModel
 * Model processing for page list of news
 *
 * 処理概要/process overview  : ListOfNewsModel
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

namespace App\Modules\Admin\Models\NewsManagement;

use Illuminate\Support\Facades\DB;
use Helper, DataResponse, ResponseCode;

class ListOfNewsModel
{
    protected $lang;

    public function __construct() {
        $this->lang = Helper::GetCookies('lang', 'en');
    }

    /**
     * Get list of news follow page
     * Created: 2021/05/28
     * @author QuyPN <quy.pham@toploop.co>
     * @param  Array $condition Search condition
     * @return Array List of news
     */
    public function ListOfNews($condition)
    {

        try {

            $query = DB::table("news")
                ->whereNull('deleted_at');

            if(!Helper::IsNullOrEmpty($condition, 'search')){
                $query->where('title', 'LIKE', '%' . $condition['search'] . '%');
            }

            if($condition && $condition['language_id']) {
                $query->where('language_id', '=', $condition['language_id']);
            }
            return $query
                ->select('id', 'language_id', 'title', 'content', 'thumbnail', 'is_published', 'published_date')
                ->orderBy('created_at', 'desc')
                ->paginate(
                    !Helper::IsNullOrEmpty($condition, 'per_page') ? $condition['per_page'] : 10,
                    ['*'],
                    'page',
                    !Helper::IsNullOrEmpty($condition, 'current_page') ? $condition['current_page'] : 1
                )->toArray();
        }
        catch(\Exception $e) {
            throw $e;
        }
    }

    /**
     * Delete list news follow list id
     * Created: 2021/05/28
     * @author QuyPN <quy.pham@toploop.co>
     * @param  Array $ids id of news need to delete
     * @return DataResponse Delete result
     */
    public function DeleteNews($ids)
    {
        try {
            $response = new DataResponse();

            $userId = Helper::GetCurrentUserId();
            DB::beginTransaction();
            DB::table('news')
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
     * Update news show or hide
     * Created: 2021/05/28
     * @author QuyPN <quy.pham@toploop.co>
     * @param  Integer $id id of news need to update
     * @param  Boolean $status status will update
     * @return DataResponse Updated result
     */
    public function UpdateStatus($id, $status)
    {
        try {
            $response = new DataResponse();

            DB::beginTransaction();
            DB::table('news')
                ->where('id', $id)
                ->where('deleted_at', null)
                ->update([
                    'is_published' => $status === 'true' ? 1 : 0,
                    'updated_at' => date('Y-m-d H:i:s'),
//                        'updated_by' => $userId
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
