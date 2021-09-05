<?php

/**
 * SettingManagementController
 * Process for page list of setting
 *
 * 処理概要/process overview  : SettingManagementController
 * 作成日/create date         : 2021/06/01
 * 作成者/creater             : ThanhND
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

use App\Modules\Admin\Requests\SettingManagement\SettingDetailRequest;
use App\Modules\Admin\Requests\SettingManagement\EmailSettingDetailRequest;
use App\Modules\Admin\Models\SettingManagement\SettingDetailModel;


use Helper, DataResponse, ResponseCode;

class SettingManagementController extends Controller
{
    protected $modelOfDetail;

    public function __construct() {
        $this->modelOfDetail = new SettingDetailModel();
    }

    /**
     * EditSetting
     * Created: 2021/06/01
     * @author ThanhND <thanhnguyenduyy@gmail.com>
     * @param  Request  $request Data from client
     * @return \Illuminate\Http\Response
     */
    public function EditSetting() {
        try {
            $data = $this->modelOfDetail->LoadSetting();
            return view('Admin::SettingManagement.SettingDetail', ["data" => $data]);
        }
        catch(\Exception $e) {
            return redirect()->route('ServerError', ["error" => $e->getMessage()]);
        }
    }

    /**
     * EditEmailSetting
     * Created: 2021/06/01
     * @author ThanhND <thanhnguyenduyy@gmail.com>
     * @param  Request  $request Data from client
     * @return \Illuminate\Http\Response
     */
    public function EditEmailSetting() {
        try {
            $data = $this->modelOfDetail->LoadSetting();
            return view('Admin::SettingManagement.EmailSettingDetail', ["data" => $data]);
        }
        catch(\Exception $e) {
            return redirect()->route('ServerError', ["error" => $e->getMessage()]);
        }
    }

    /**
     * UpdateSetting
     * Created: 2021/06/01
     * @author ThanhND <thanhnguyenduyy@gmail.com>
     * @param  Request  $request Data from client
     * @return DataResponse Update result
     */
    public function UpdateSetting(SettingDetailRequest $request) {
        $response = new DataResponse();
        try {
            $response = $this->modelOfDetail->UpdateSetting($request->all());
        }
        catch(\Exception $e) {
            $response->SetException($e);
        }
        return response()->json($response->GetData());
    }

    /**
     * UpdateEmailSetting
     * Created: 2021/06/01
     * @author ThanhND <thanhnguyenduyy@gmail.com>
     * @param  Request  $request Data from client
     * @return DataResponse Update result
     */
    public function UpdateEmailSetting(EmailSettingDetailRequest $request) {
        $response = new DataResponse();
        try {
            $response = $this->modelOfDetail->UpdateEmailSetting($request->all());
        }
        catch(\Exception $e) {
            $response->SetException($e);
        }
        return response()->json($response->GetData());
    }
}