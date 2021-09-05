<?php

/**
 * ProcessDetailModel
 * Model processing for page process detail
 *
 * 処理概要/process overview  : ProcessDetailModel
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

class ProcessDetailModel
{
    protected $lang;

    public function __construct() {
        $this->lang = Helper::GetCookies('lang', 'en');
    }

    /**
     * Get data process follow id
     * Created: 2021/06/01
     * @author DinhAn <dinhan0209@gmail.com>
     * @param  int $id Id of process
     * @return Array Data of process
     */
    public function LoadProcess($id)
    {
        try {
            $vi = DB::table("process")
                ->where('id', $id)
                ->where('deleted_at', null)
                ->where('lang', 'vi')->first();
            $trans = [];
            $mode = 'I';
            if(isset($vi) && !empty($vi)) {
                $trans = DB::table("process")
                    ->where('id', $id)
                    ->where('deleted_at', null)
                    ->where('lang', 'en')->first();
                $mode = 'U';
                $vi->created_by = Helper::GetUsername($vi->created_by);
                $vi->updated_by = Helper::GetUsername($vi->updated_by);
            }
            return [
                'vi'    => $vi,
                'trans' => $trans,
                'mode'  => $mode
            ];
        }
        catch(\Exception $e) {
            throw $e;
        }
    }

    /**
     * Update process
     * Created: 2021/06/01
     * @author DinhAn <dinhan0209@gmail.com>
     * @param  Array $data Data of process from client
     * @return Array updated result
     */
    public function UpdateProcess($data)
    {
        try {
            $response = new DataResponse();
            if ($response->code == ResponseCode::OK) {
                $userId = Helper::GetCurrentUserId();
                // Update data
                DB::table('process')
                    ->where('deleted_at', null)
                    ->where('id', $data['id'])
                    ->update([
                        'show'          => $data['vi']['show'],
                        'updated_at'    => date('Y-m-d H:i:s'),
                        'updated_by'    =>$userId
                    ]);
                DB::table('process')
                    ->where('deleted_at', null)
                    ->where('lang', 'vi')
                    ->where('id', $data['id'])
                    ->update([
                        'title'             => $data['vi']['title'],
                        'description'       => $data['vi']['description'],
                        'content'           => $data['vi']['content'],
                        'updated_at'        => date('Y-m-d H:i:s'),
                        'updated_by'        =>$userId
                    ]);
                if ($data['will_trans'] == 1) {
                    DB::table('process')
                        ->where('deleted_at', null)
                        ->where('lang', $data['trans']['lang'])
                        ->where('id', $data['id'])
                        ->update([
                            'title'         => $data['trans']['title'],
                            'description'   => $data['trans']['description'],
                            'content'       => $data['trans']['content'],
                            'updated_at'    => date('Y-m-d H:i:s'),
                            'updated_by'    =>$userId
                        ]);
                }
                $response->data['id'] = $data['id'];
            }
            return $response;
        }
        catch(\Exception $e) {
            throw $e;
        }
    }

    /**
     * Insert new slide
     * Created: 2021/05/31
     * @author QuyPN <quy.pham@toploop.co>
     * @param  Array $data Data of slide from client
     * @return Array inserted result
     */
    public function InsertProcess($data)
    {
        try {
            $response = new DataResponse();
            if ($response->code == ResponseCode::OK) {
                $newId = Helper::GetId('process');
                $userId = Helper::GetCurrentUserId();
                // Insert data with main and translate language
                DB::table('process')->insert([
                    [
                        'id'            =>  $newId,
                        'lang'          => 'vi',
                        'title'         => $data['vi']['title'],
                        'description'   => $data['vi']['description'],
                        'content'       => $data['vi']['content'],
                        'order'         => $newId,
                        'show'          => $data['vi']['show'],
                        'created_by'    => $userId,
                        'created_at'    => date('Y-m-d H:i:s')
                    ],
                    [
                        'id'            =>  $newId,
                        'lang'          => $data['trans']['lang'],
                        'title'         => $data['trans']['title'],
                        'description'   => $data['trans']['description'],
                        'content'       => $data['trans']['content'],
                        'order'         => $newId,
                        'show'          => $data['vi']['show'],
                        'created_by'    => $userId,
                        'created_at'    => date('Y-m-d H:i:s')
                    ]
                ]);
                // insert data for other language if exists
                $langs = Helper::GetLanguages();
                foreach($langs as $key => $lang) {
                    if($lang->code != $data['trans']['lang']) {
                        DB::table('process')->insert([
                            'id'            =>  $newId,
                            'lang'          => $lang->code,
                            'title'         => $data['vi']['title'],
                            'description'   => $data['vi']['description'],
                            'content'       => $data['vi']['content'],
                            'order'         => $newId,
                            'show'          => $data['vi']['show'],
                            'created_by'    => $userId,
                            'created_at'    => date('Y-m-d H:i:s')
                        ]);
                    }
                }
                $response->data['id'] = $newId;
            }
            return $response;
        }
        catch(\Exception $e) {
            throw $e;
        }
    }
    
}
