<?php

/**
 * DeliveryModelDetailModel
 * Model processing for page delivery_model detail
 *
 * 処理概要/process overview  : DeliveryModelDetailModel
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

namespace App\Modules\Admin\Models\DeliveryModelManagement;

use Illuminate\Support\Facades\DB;
use Helper, DataResponse, ResponseCode;
use Illuminate\Support\Str;

class DeliveryDetailModel
{
    protected $lang;

    public function __construct() {
        $this->lang = Helper::GetCookies('lang', 'en');
    }

    /**
     * Get data delivery_model follow id
     * Created: 2021/05/28
     * @param int $id Id of delivery_model
     * @return Array Data of delivery_model
     * @throws \Exception
     * @author TriTD <tritd@toploop.co>
     */
    public function LoadDeliveryModel($id)
    {
        try {

            $delivery_model = DB::table("delivery_models")
                ->where('id', $id)
                ->where('deleted_at', null)->first();
            return  $delivery_model;
        }
        catch(\Exception $e) {
            throw $e;
        }
    }



    /**
     * Update delivery_model
     * Created: 2021/08/15
     * @param Array $data Data of delivery_model from delivery_model
     * @return Array updated result
     * @throws \Exception
     * @author TriTD <tritd@toploop.co>
     */
    public function UpdateDeliveryModel($data)
    {
        $delivery_model = DB::table('delivery_models')->where('id', $data['id'])->first();
        $folder = 'upload/delivery/';
        try {
            $response = new DataResponse();
            $response1 = new DataResponse();
            $response2 = new DataResponse();
            $response3 = new DataResponse();
            $image = $delivery_model->image;
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
            $offshore_delivery_image = $delivery_model->offshore_delivery;
            if (isset($data['offshore_delivery_image'])) {
                $img = Helper::SaveFileImg($data['offshore_delivery_image'], $folder, 'images');

                if ($img['status']) {
                    $offshore_delivery_image = $img['path'];
                }
                else {
                    $response1->msgNo = $img['error'];
                    $response1->code = ResponseCode::HAVE_ERROR;
                    return $response1;
                }
            }

            $onside_delivery_image = $delivery_model->onside_delivery;
            if (isset($data['onside_delivery_image'])) {
                $img = Helper::SaveFileImg($data['onside_delivery_image'], $folder, 'images');

                if ($img['status']) {
                    $onside_delivery_image = $img['path'];
                }
                else {
                    $response2->msgNo = $img['error'];
                    $response2->code = ResponseCode::HAVE_ERROR;
                    return $response2;
                }
            }

            $hybrid_delivery_image = $delivery_model->hybrid_delivery;
            if (isset($data['hybrid_delivery_image'])) {
                $img = Helper::SaveFileImg($data['hybrid_delivery_image'], $folder, 'images');

                if ($img['status']) {
                    $hybrid_delivery_image = $img['path'];
                }
                else {
                    $response3->msgNo = $img['error'];
                    $response3->code = ResponseCode::HAVE_ERROR;
                    return $response3;
                }
            }


            if ($response->code == ResponseCode::OK && $response1->code == ResponseCode::OK && $response2->code == ResponseCode::OK && $response3->code == ResponseCode::OK) {
                // Update data
                DB::table('delivery_models')
                    ->where('id', $data['id'])
                    ->update([
                        'title' => $data['title'],
                        'language_id' => $data['language_id'],
                        'image' => $image,
                        'desc' => $data['desc'],
                        'offshore_delivery' => $offshore_delivery_image,
                        'onside_delivery' => $onside_delivery_image,
                        'hybrid_delivery' => $hybrid_delivery_image,
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
