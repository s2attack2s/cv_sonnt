<?php

/**
 * DeliveryModelsManagementController
 * Process for page list of delivery_models
 *
 * 処理概要/process overview  : DeliveryModelsManagementController
 * 作成日/create date         : 2021/08/16
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

namespace App\Modules\Admin\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Modules\Admin\Requests\DeliveryModelsManagement\DeliveryModelDetailRequest;
use App\Modules\Admin\Models\DeliveryModelManagement\ListOfDeliveryModel;
use App\Modules\Admin\Models\DeliveryModelManagement\DeliveryDetailModel;

use Helper, DataResponse, ResponseCode;

class DeliveryModelsManagementController extends Controller
{
    protected $modelOfList;
    protected $modelOfDetail;
    protected $languages;

    public function __construct() {
        $this->modelOfList = new ListOfDeliveryModel();
        $this->modelOfDetail = new DeliveryDetailModel();
        $this->languages = [ 1 => 'English', 2 => 'Japanese', 'Việt Nam'];
    }

    /**
     * ListOfDeliveryModel
     * Created: 2021/08/16
     * @param \Request $request
     * @return \Illuminate\Http\Response
     * @author TriTD <tritd@toploop.co>
     */
    public function ListOfDeliveryModels(Request $request){

        try {
            $condition = $request->all();

            $data = $this->modelOfList->ListOfDeliveryModels($request->all());
            if ($request->ajax()) {
                return view('Admin::DeliveryModelsManagement.TableDeliveryModel',
                    [
                        "data" => $data
                    ]);
            }

            return view('Admin::DeliveryModelsManagement.ListOfDeliveryModels',
                [
                    "data" => $data,
                    'languages' => $this->languages,
                    'condition' => $condition
                ]);
        }
        catch(\Exception $e) {
            return redirect()->route('ServerError', ["error" => $e->getMessage()]);
        }
    }

    /**
     * EditDeliveryModel
     * Created: 2021/08/16
     * @author TriTD <tritd@toploop.co>
     * @param  Request  $request Data from delivery_model
     * @return \Illuminate\Http\Response
     */
    public function EditDeliveryModel($id) {
        try {
            $data = $this->modelOfDetail->LoadDeliveryModel($id);
            return view('Admin::DeliveryModelsManagement.DeliveryModelDetail',
                [
                    "data" => $data,
                    'languages' => $this->languages
                ]);
        }
        catch(\Exception $e) {
            return redirect()->route('ServerError', ["error" => $e->getMessage()]);
        }
    }

    /**
     * UpdateDeliveryModel
     * Created: 2021/08/16
     * @author TriTD <tritd@toploop.co>
     * @param  Request  $request Data from delivery_model
     * @return DataResponse Update result
     */
    public function UpdateDeliveryModel(DeliveryModelDetailRequest $request) {
        $response = new DataResponse();
        try {
            $response = $this->modelOfDetail->UpdateDeliveryModel($request->all());
        }
        catch(\Exception $e) {
            $response->SetException($e);
        }
        return response()->json($response->GetData());
    }


}
