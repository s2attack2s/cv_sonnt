<?php

/**
 * ContractTypeDetailModel
 * Model processing for page contract_type detail
 *
 * 処理概要/process overview  : ContractTypeDetailModel
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

namespace App\Modules\Admin\Models\ContractTypeManagement;

use Illuminate\Support\Facades\DB;
use Helper, DataResponse, ResponseCode;
use Illuminate\Support\Str;

class ContractTypeModel
{
    protected $lang;

    public function __construct() {
        $this->lang = Helper::GetCookies('lang', 'en');
    }

    /**
     * Get data contract_type follow id
     * Created: 2021/05/28
     * @param int $id Id of contract_type
     * @return Array Data of contract_type
     * @throws \Exception
     * @author TriTD <tritd@toploop.co>
     */
    public function LoadContractType($id)
    {
        try {
            $contract_type = DB::table("contract_types")
                ->where('id', $id)
                ->where('deleted_at', null)->first();
            return  $contract_type;
        }
        catch(\Exception $e) {
            throw $e;
        }
    }

    /**
     * Get Contact Type Detail
     * @param $id
     * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Query\Builder|object|null
     * @throws \Exception
     */
    public function LoadContractTypeDettail($id)
    {
        try {
            $contract_type = DB::table("contract_type_details")
                ->where('id', $id)->first();
            return  $contract_type;
        }
        catch(\Exception $e) {
            throw $e;
        }
    }

    /**
     * Get List ContractTypeDetail
     * @param $id
     * @return array
     * @throws \Exception
     */
    public function ListOfContractTypeDetails($id)
    {
        try {
            $contract_type = DB::table("contract_types")
                ->where('id', $id)
                ->where('deleted_at', null)->first();

            $detail = DB::table("contract_type_details")
                ->select('id', 'item_name', 'fix_price', 'time_materials','dedicated_team')
                ->where('contract_type_id', $id)
                ->get()->toArray();
            return  [
                'info' => $contract_type,
                'detail' => $detail
            ];
        }
        catch(\Exception $e) {
            throw $e;
        }
    }

    /**
     * Update contract_type
     * Created: 2021/08/15
     * @param Array $data Data of contract_type from contract_type
     * @return Array updated result
     * @throws \Exception
     * @author TriTD <tritd@toploop.co>
     */
    public function UpdateContractType($data)
    {
        $contract_type = DB::table('contract_types')->where('id', $data['id'])->first();
        $folder = 'upload/contract/';
        try {
            $response = new DataResponse();
            $image = $contract_type->image;
            // upload image
            if (isset($data['image'])) {
                $img = Helper::SaveFileImg($data['image'], $folder, 'images');

                if ($img['status']) {
                    $image = $img['path'];
                }
                else {
                    $response->msgNo = $img['error'];
                    $response->code = ResponseCode::HAVE_ERROR;
                    return $response;
                }
            }

            if ($response->code == ResponseCode::OK) {
                // Update data
                DB::table('contract_types')
                    ->where('id', $data['id'])
                    ->update([
                        'title' => $data['title'],
                        'desc' => $data['desc'],
                        'image' => $image,
                        'updated_at' => date('Y-m-d H:i:s')
                    ]);

                $response->data['id'] = $data['id'];
            }
            return $response;
        }
        catch(\Exception $e) {
            throw $e;
        }
    }

    /**
     * @param $data
     * @return DataResponse
     * @throws \Exception
     */
    public function UpdateContractTypeDetail($data)
    {
        try {
            $response = new DataResponse();

            if ($response->code == ResponseCode::OK) {
                // Update data
                DB::table('contract_type_details')
                    ->where('id', $data['id'])
                    ->update([
                        'item_name' => $data['item_name'],
                        'fix_price' => $data['fix_price'],
                        'time_materials' => $data['time_materials'],
                        'dedicated_team' => $data['dedicated_team'],

                        'updated_at' => date('Y-m-d H:i:s')
                    ]);

                $response->data['id'] = $data['id'];
            }
            return $response;
        }
        catch(\Exception $e) {
            throw $e;
        }
    }


}
