<?php

/**
 * DashboardController
 * Process for page dashboard
 *
 * 処理概要/process overview  : DashboardController
 * 作成日/create date         : 2021/06/1
 * 作成者/creater             : HungNo1
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
use App\Modules\Admin\Models\Profile\GetProfileModel;
use App\Modules\Admin\Models\Profile\ProfileDetailModel;
use App\Modules\Admin\Requests\Profile\ProfileRequest;
use App\Modules\Admin\Requests\Profile\ProfilePasswordRequest;

use Helper, DataResponse, ResponseCode;


class ProfileController extends Controller
{
    protected $modelgetProfile;

    public function __construct() {
        $this->modelgetProfile = new GetProfileModel();
        $this->middleware('auth');
    }
    /**
     * Dashboard
     * Created: 2021/06/1
     * @author HungNo1
     * @return \Illuminate\Http\Response Page dashboard, or page login if not login
     */
    public function Index(Request $request){
        try {

            $data = $this->modelgetProfile->GetProfile($request->all());
            return view('Admin::Profile.Index', ["data" => $data]);    
        }
        catch(\Exception $e) {
            return redirect()->route('ServerError', ["error" => $e->getMessage()]);
        }
    }
      /**
     * UpdateProfile
     * Created: 2021/06/2
     * @author HungNo1
     * @param  Request  $request Data from client
     * @return DataResponse Update result
     */
    public function UpdateProfile(ProfileRequest $request) {
        $response = new DataResponse();
        try {
            $response = $this->modelgetProfile->UpdateProfile($request->all());
        }
        catch(\Exception $e) {
            $response->SetException($e);
        }
        return response()->json($response->GetData());
    }
      /**
     * UpdateProfile
     * Created: 2021/06/2
     * @author HungNo1
     * @param  Request  $request Data from client
     * @return DataResponse Update result
     */
    public function UpdatePassword(ProfilePasswordRequest $request) {
        $response = new DataResponse();
        try {
            $response = $this->modelgetProfile->UpdatePassword($request->all());
        }

        catch(\Exception $e) {
            $response->SetException($e);
        }
        return response()->json($response->GetData());
    }

}
