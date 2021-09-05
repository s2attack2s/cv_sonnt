<?php

/**
 * NewsManagementController
 * Process for page list of clients
 *
 * 処理概要/process overview  : ClientsManagementController
 * 作成日/create date         : 2021/08/14
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

use App\Modules\Admin\Requests\ClientsManagement\SearchClientsConditionRequest;
use App\Modules\Admin\Requests\ClientsManagement\ClientDetailRequest;
use App\Modules\Admin\Models\ClientsManagement\ListOfClientsModel;
use App\Modules\Admin\Models\ClientsManagement\ClientDetailModel;

use Helper, DataResponse, ResponseCode;

class ClientsManagementController extends Controller
{
    protected $modelOfList;
    protected $modelOfDetail;
    protected $languages;
    protected $locations;
    protected $job_types;

    public function __construct() {
        $this->modelOfList = new ListOfClientsModel();
        $this->modelOfDetail = new ClientDetailModel();
        $this->languages = [ 1 => 'English', 2 => 'Japanese', 3 => 'Vietnam'];
        $this->locations = [ 1 => 'Tokyo', 2 => 'Đà Nẵng' ];
    }

    /**
     * ListOfClient
     * Created: 2021/05/28
     * @param SearchClientsConditionRequest $request
     * @return \Illuminate\Http\Response
     * @author TriTD <tritd@toploop.co>
     */
    public function ListOfClients(SearchClientsConditionRequest $request){

        try {
            $condition = $request->all();

            $data = $this->modelOfList->ListOfClients($request->all());
            if ($request->ajax()) {
                return view('Admin::ClientsManagement.TableClient',
                    [
                        "data" => $data,
                        'languages' => $this->languages,
                        'locations' => $this->locations,
                    ]);
            }
            return view('Admin::ClientsManagement.ListOfClients',
                [
                    "data" => $data,
                    'languages' => $this->languages,
                    'locations' => $this->locations,
                    'condition' => $condition
                ]);
        }
        catch(\Exception $e) {
            return redirect()->route('ServerError', ["error" => $e->getMessage()]);
        }
    }

    /**
     * DeleteClients
     * Created: 2021/08/14
     * @author TriTD <tritd@toploop.co>
     * @param  Request  $request Data from client
     * @return DataResponse Delete result
     */
    public function DeleteClients(Request $request) {
        $response = new DataResponse();
        try {
            $response = $this->modelOfList->DeleteClients($request->get('ids'));
        }
        catch(\Exception $e) {
            $response->SetException($e);
        }
        return response()->json($response->GetData());
    }

    /**
     * UpdateStatus
     * Created: 2021/08/14
     * @author TriTD <tritd@toploop.co>
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
     * CreateClient
     * Created: 2021/08/14
     * @author TriTD <tritd@toploop.co>
     * @param  Request  $request Data from client
     * @return \Illuminate\Http\Response
     */
    public function CreateClient(Request $request) {
        try {
            $data = $this->modelOfDetail->LoadClient(0);
            $jobTypes = $this->modelOfDetail->LoadListJobTypes();
            return view('Admin::ClientsManagement.ClientDetail',
                    [
                        "data" => $data,
                        'languages' => $this->languages,
                        'locations' => $this->locations,
                        'job_types' => $jobTypes
                    ]);
        }
        catch(\Exception $e) {
            return redirect()->route('ServerError', ["error" => $e->getMessage()]);
        }
    }

    /**
     * EditClient
     * Created: 2021/08/14
     * @author TriTD <tritd@toploop.co>
     * @param  Request  $request Data from client
     * @return \Illuminate\Http\Response
     */
    public function EditClient($id) {
        try {
            $data = $this->modelOfDetail->LoadClient($id);
            $jobTypes = $this->modelOfDetail->LoadListJobTypes();
            return view('Admin::ClientsManagement.ClientDetail',
                [
                    "data" => $data,
                    'languages' => $this->languages,
                    'locations' => $this->locations,
                     'job_types' => $jobTypes
                ]);
        }
        catch(\Exception $e) {
            return redirect()->route('ServerError', ["error" => $e->getMessage()]);
        }
    }

    /**
     * UpdateClient
     * Created: 2021/05/31
     * @author TriTD <tritd@toploop.co>
     * @param  Request  $request Data from client
     * @return DataResponse Update result
     */
    public function UpdateClient(ClientDetailRequest $request) {
        $response = new DataResponse();
        try {
            $response = $this->modelOfDetail->UpdateClient($request->all());
        }
        catch(\Exception $e) {
            $response->SetException($e);
        }
        return response()->json($response->GetData());
    }

    /**
     * InsertClient
     * Created: 2021/05/31
     * @author TriTD <tritd@toploop.co>
     * @param  Request  $request Data from client
     * @return DataResponse Update result
     */
    public function InsertClient(Request $request) {

        $response = new DataResponse();
        try {
            $response = $this->modelOfDetail->InsertClient($request->all());
        }
        catch(\Exception $e) {
            $response->SetException($e);
        }
        return response()->json($response->GetData());
    }
}
