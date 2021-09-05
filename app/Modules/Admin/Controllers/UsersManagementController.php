<?php

/**
 * UsersManagementController
 * Process for page list of User
 *
 * 処理概要/process overqueryew  : UsersManagementController
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

namespace App\Modules\Admin\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

use App\Modules\Admin\Requests\UsersManagement\SearchUsersConditionRequest;
use App\Modules\Admin\Requests\UsersManagement\UserDetailRequest;
use App\Modules\Admin\Models\UsersManagement\ListOfUsersModel;
use App\Modules\Admin\Models\UsersManagement\UserDetailModel;

use Helper, DataResponse, ResponseCode;
use phpDocumentor\Reflection\Location;

class UsersManagementController extends Controller
{
    protected $modelOfList;
    protected $modelOfDetail;

    public function __construct()
    {
        $this->modelOfList = new ListOfUsersModel();
        $this->modelOfDetail = new UserDetailModel();
    }
    /**
     * ListOfUsers
     * Created: 2021/05/28
     * @author Sonnt <ntson12a4@gmail.com>
     * @return \Illuminate\Http\Response
     */
    public function ListOfUsers(SearchUsersConditionRequest $request)
    {
        try {
            $condition = $request->all();
            $data = $this->modelOfList->ListOfUsers($request->all());
            
            if ($request->ajax()) {
                return view('Admin::UsersManagement.TableUser', ["data" => $data]);
            }
            return view('Admin::UsersManagement.ListOfUsers', ["data" => $data, 'condition' => $condition]);
        } catch (\Exception $e) {
            return redirect()->route('ServerError', ["error" => $e->getMessage()]);
        }
    }

    /**
     * DeleteUsers
     * Created: 2021/05/28
     * @author Sonnt <ntson12a4@gmail.com>
     * @param  Request  $request Data from client
     * @return DataResponse Delete result
     */
    public function DeleteUsers(Request $request)
    {
        $response = new DataResponse();
        try {
            $response = $this->modelOfList->DeleteUsers($request->get('ids'));
        } catch (\Exception $e) {
            $response->SetException($e);
        }
        return response()->json($response->GetData());
    }
    /**
     * CreateUser
     * Created: 2021/05/28
     * @author Sonnt <ntson12a4@gmail.com>
     * @param  Request  $request Data from client
     * @return \Illuminate\Http\Response
     */
    public function CreateUser(Request $request)
    {
        try {
            $data = $this->modelOfDetail->LoadUser(0);
            return view('Admin::UsersManagement.UserDetail', ["data" => $data]);
        } catch (\Exception $e) {
            return redirect()->route('ServerError', ["error" => $e->getMessage()]);
        }
    }

    /**
     * EditUser
     * Created: 2021/05/28
     * @author Sonnt <ntson12a4@gmail.com>
     * @param  Request  $request Data from client
     * @return \Illuminate\Http\Response
     */
    public function EditUser($id)
    {
        try {
            $data = $this->modelOfDetail->LoadUser($id);
            if ($data['mode'] == 'I') {
                return redirect()->route('CreateUser');
            }
            return view('Admin::UsersManagement.UserDetail', ["data" => $data]);
        } catch (\Exception $e) {
            return redirect()->route('ServerError', ["error" => $e->getMessage()]);
        }
    }
    /**
     * UpdateUser
     * Created: 2021/05/31
     * @author Sonnt <ntson12a4@gmail.com>
     * @param  Request  $request Data from client
     * @return DataResponse Update result
     */
    public function UpdateUser(UserDetailRequest $request)
    {
        $response = new DataResponse();
        try {
            $response = $this->modelOfDetail->UpdateUser($request->all());
        } catch (\Exception $e) {
            $response->SetException($e);
        }
        
        return response()->json($response->GetData());
    }

    /**
     * InsertUser
     * Created: 2021/05/31
     * @author Sonnt <ntson12a4@gmail.com>
     * @param  Request  $request Data from client
     * @return DataResponse Update result
     */
    public function InsertUser(UserDetailRequest $request)
    {
        $response = new DataResponse();
        try {
            $response = $this->modelOfDetail->InsertUser($request->all());
        } catch (\Exception $e) {
            $response->SetException($e);
        }
       
        return response()->json($response->GetData());
    }
 /**
     * ResetPassword
     * Created: 2021/06/04
     * @author Sonnt <ntson12a4@gmail.com>
     * @param  Request  $request Data from client
     * @return DataResponse Update result
     */
     public function ResetPassword(UserDetailRequest $request)
    {
        $response = new DataResponse();
        try {
            $response = $this->modelOfDetail->ResetPassword($request->all());       
        } catch (\Exception $e) {
            $response->SetException($e);
        }    
        return response()->json($response->GetData());
    }
}
