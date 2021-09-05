<?php

/**
 * ProcessManagementController
 * Process for page list of process
 *
 * 処理概要/process overview  : ProcessManagementController
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

namespace App\Modules\Admin\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Modules\Admin\Requests\ProcessManagement\SearchProcessConditionRequest;
use App\Modules\Admin\Requests\ProcessManagement\ProcessDetailRequest;
use App\Modules\Admin\Models\ProcessManagement\ListOfProcessModel;
use App\Modules\Admin\Models\ProcessManagement\ProcessDetailModel;


use Helper, DataResponse, ResponseCode;

class ProcessManagementController extends Controller
{
    protected $modelOfList;
    protected $modelOfDetail;

    public function __construct() {
        $this->modelOfList = new ListOfProcessModel();
        $this->modelOfDetail = new ProcessDetailModel();
    }
    
    /**
     * ListOfProcess
     * Created: 2021/06/01
     * @author DinhAn <dinhan0209@gmail.com>
     * @return \Illuminate\Http\Response
     */
    public function ListOfProcess(SearchProcessConditionRequest $request){
        try {
            $condition = $request->all();
            $data = $this->modelOfList->ListOfProcess($request->all());
            // $model = new ListOfProcessModel();
            // $data = $model->ListOfProcess();
            if ($request->ajax()) {
                return view('Admin::ProcessManagement.TableProcess', ["data" => $data]);
            }
            return view('Admin::ProcessManagement.ListOfProcess',["data" => $data, 'condition' => $condition]);
        }
        catch(\Exception $e) {
            return redirect()->route('ServerError', ["error" => $e->getMessage()]);
        }
    }

    /**
     * DeleteProcess
     * Created: 2021/06/01
     * @author DinhAn <dinhan0209@gmail.com> 
     * @param  Request  $request Data from client
     * @return DataResponse Delete result
     */
    public function DeleteProcess(Request $request) {
        $response = new DataResponse();
        try {
            $response = $this->modelOfList->DeleteProcess($request->get('ids'));
            //dd($response->GetData());
        }
        catch(\Exception $e) {
            $response->SetException($e);
        }
        return response()->json($response->GetData());
    }
    /**
     * UpdateStatus
     * Created: 2021/06/01
     * @author DinhAn <dinhan0209@gmail.com> 
     * @param  Request  $request Data from client
     * @return DataResponse Update result
     */
    public function UpdateStatus(Request $request) {
        $response = new DataResponse();
        try {
            $response = $this->modelOfList->UpdateStatus($request->get('id'), $request->get('status'));
        }
        catch(\Exception $e) {
            $response->SetException($e);
        }
        return response()->json($response->GetData());
    }

    /**
     * CreateProcess
     * Created: 2021/06/01
     * @author DinhAn <dinhan0209@gmail.com> 
     * @param  Request  $request Data from client
     * @return \Illuminate\Http\Response
     */
    public function CreateProcess(Request $request) {
        try {
            $data = $this->modelOfDetail->LoadProcess(0);
            return view('Admin::ProcessManagement.ProcessDetail', ["data" => $data]);
        }
        catch(\Exception $e) {
            return redirect()->route('ServerError', ["error" => $e->getMessage()]);
        }
    }

    /**
     * EditProcess
     * Created: 2021/06/01
     * @author DinhAn <dinhan0209@gmail.com> 
     * @param  Request  $request Data from client
     * @return \Illuminate\Http\Response
     */
    public function EditProcess($id) {
        try {
            $data = $this->modelOfDetail->LoadProcess($id);
            if($data['mode'] == 'I') {
                return redirect()->route('CreateProcess');
            }
            return view('Admin::ProcessManagement.ProcessDetail', ["data" => $data]);
        }
        catch(\Exception $e) {
            return redirect()->route('ServerError', ["error" => $e->getMessage()]);
        }
    }

    /**
     * UpdateProcess
     * Created: 2021/06/01
     * @author DinhAn <dinhan0209@gmail.com> 
     * @param  Request  $request Data from client
     * @return DataResponse Update result
     */
    public function UpdateProcess(ProcessDetailRequest $request) {
        $response = new DataResponse();
        try {
            $response = $this->modelOfDetail->UpdateProcess($request->all());
        }
        catch(\Exception $e) {
            $response->SetException($e);
        }
        return response()->json($response->GetData());
    }

    /**
     * InsertProcess
     * Created: 2021/06/01
     * @author DinhAn <dinhan0209@gmail.com> 
     * @param  Request  $request Data from client
     * @return DataResponse Update result
     */
    public function InsertProcess(ProcessDetailRequest $request) {
        $response = new DataResponse();
        try {
            $response = $this->modelOfDetail->InsertProcess($request->all());
        }
        catch(\Exception $e) {
            $response->SetException($e);
        }
        return response()->json($response->GetData());
    }    
}
