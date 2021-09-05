<?php

/**
 * ContractTypesManagementController
 * Process for page list of ContractTypes
 *
 * 処理概要/process overview  : ContractTypesManagementController
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
use App\Modules\Admin\Requests\ContractTypesManagement\ContractTypeRequest;
use App\Modules\Admin\Requests\ContractTypesManagement\ContractTypeDetailRequest;
use App\Modules\Admin\Models\ContractTypeManagement\ListOfContractType;
use App\Modules\Admin\Models\ContractTypeManagement\ContractTypeModel;

use Helper, DataResponse, ResponseCode;

class ContractTypesManagementController extends Controller
{
    protected $modelOfList;
    protected $modelOfDetail;
    protected $languages;

    public function __construct() {
        $this->modelOfList = new ListOfContractType();
        $this->modelOfDetail = new ContractTypeModel();
        $this->languages = [ 1 => 'English', 2 => 'Japanese', 'Việt Nam'];
    }

    /**
     * ListOfContractType
     * Created: 2021/08/16
     * @param \Request $request
     * @return \Illuminate\Http\Response
     * @author TriTD <tritd@toploop.co>
     */
    public function ListOfContractTypes(Request $request){

        try {
            $condition = $request->all();
            $data = $this->modelOfList->ListOfContractTypes($request->all());


            return view('Admin::ContractTypesManagement.ListOfContractTypes',
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
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function ListOfContractTypeDetails(Request $request, $id){
        try {
            $data = $this->modelOfDetail->ListOfContractTypeDetails($id);

            return view('Admin::ContractTypesManagement.ListOfContractTypeDetails',
                [
                    "data" => $data,
                    'languages' => $this->languages,
                ]);
        }
        catch(\Exception $e) {
            return redirect()->route('ServerError', ["error" => $e->getMessage()]);
        }
    }

    /**
     * EditContractType
     * Created: 2021/08/16
     * @author TriTD <tritd@toploop.co>
     * @param  Request  $request Data from ContractType
     * @return \Illuminate\Http\Response
     */
    public function EditContractType($id) {
        try {
            $data = $this->modelOfDetail->LoadContractType($id);
            return view('Admin::ContractTypesManagement.ContractType',
                [
                    "data" => $data,
                    'languages' => $this->languages
                ]);
        }
        catch(\Exception $e) {
            return redirect()->route('ServerError', ["error" => $e->getMessage()]);
        }
    }

    public function EditContractTypeDetail($id) {
        try {
            $data = $this->modelOfDetail->LoadContractTypeDettail($id);
            return view('Admin::ContractTypesManagement.ContractTypeDetail',
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
     * UpdateContractType
     * Created: 2021/08/16
     * @author TriTD <tritd@toploop.co>
     * @param  Request  $request Data from ContractType
     * @return DataResponse Update result
     */
    public function UpdateContractType(ContractTypeRequest $request) {
        $response = new DataResponse();
        try {
            $response = $this->modelOfDetail->UpdateContractType($request->all());
        }
        catch(\Exception $e) {
            $response->SetException($e);
        }
        return response()->json($response->GetData());
    }

    /**
     * @param ContractTypeDetailRequest $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function UpdateContractTypeDetail(ContractTypeDetailRequest $request) {
        $response = new DataResponse();
        try {
            $response = $this->modelOfDetail->UpdateContractTypeDetail($request->all());
        }
        catch(\Exception $e) {
            $response->SetException($e);
        }
        return response()->json($response->GetData());
    }

}
