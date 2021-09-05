<?php

/**
 * LoginController
 * Process for page login
 *
 * 処理概要/process overview  : LoginController
 * 作成日/create date         : 2021/05/26
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

use App\Modules\Admin\Requests\Login\UserRequest;
use App\Modules\Admin\Models\Login\LoginModel;

use Helper, DataResponse, ResponseCode;

class LoginController extends Controller
{
    protected $model;

    public function __construct() {
        $this->model = new LoginModel();
    }

    /**
     * Login page.
     * Created: 2021/05/26
     * @author QuyPN <quy.pham@toploop.co>
     * @return \Illuminate\Http\Response Page login or error page if have exception. If has login, then return home page
     */
    public function Login(Request $request){
        try {
            if (Helper::GetCurrentUserId() > 0) {
                return redirect()->route('AdminDashboard');
            }
            return view('Admin::Login.Index');
        }
        catch(\Exception $e) {
            return redirect()->route('ServerError', ["error" => $e->getMessage()]);
        }
    }

    /**
     * Check data login.
     * Created: 2021/05/26
     * @author QuyPN <quy.pham@toploop.co>
     * @param  UserRequest  $request Data login from client
     * @return DataResponse Result of check login
     */
    public function CheckLogin(UserRequest $request) {
        $response = new DataResponse();
        try {
            $response = $this->model->CheckLogin($request->all());

            if ($response->code == ResponseCode::OK) {
                $path = $request->session()->pull('UrlBefore','');
                $response->data['before'] = $path == '' ? '/admin' : $path;
            }
        }
        catch(\Exception $e) {
            $response->SetException($e);
        }
        return response()->json($response->GetData());
    }

    /**
     * RefreshToken.
     * Created: 2021/05/28
     * @author QuyPN <quy.pham@toploop.co>
     * @param  UserRequest  $request Data from client
     * @return DataResponse New token
     */
    public function RefreshToken(Request $request) {
        $response = new DataResponse();
        try {
            $response = $this->model->RefreshToken();
        }
        catch(\Exception $e) {
            $response->SetException($e);
        }
        return response()->json($response->GetData());
    }

    /**
     * Logout.
     * Created: 2021/05/26
     * @author QuyPN <quy.pham@toploop.co>
     * @param  Request  $request Data from client
     * @return DataResponse Result of logout
     */
    public function Logout(Request $request) {
        $response = new DataResponse();
        try {
            $response = $this->model->Logout($request->cookie('token', ''));
        }
        catch(\Exception $e) {
            $response->SetException($e);
        }
        return response()->json($response->GetData());
    }
}
