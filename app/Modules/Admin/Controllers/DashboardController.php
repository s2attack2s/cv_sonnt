<?php

/**
 * DashboardController
 * Process for page dashboard
 *
 * 処理概要/process overview  : DashboardController
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

class DashboardController extends Controller
{
    /**
     * Dashboard
     * Created: 2021/05/28
     * @author QuyPN <quy.pham@toploop.co>
     * @return \Illuminate\Http\Response Page dashboard, or page login if not login
     */
    public function Index(Request $request){
        try {
            return view('Admin::Dashboard.Index');
        }
        catch(\Exception $e) {
            return redirect()->route('ServerError', ["error" => $e->getMessage()]);
        }
    }
}
