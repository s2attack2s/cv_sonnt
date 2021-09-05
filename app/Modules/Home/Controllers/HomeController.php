<?php

/**
 * HomeController
 * Process for homepage
 *
 * 処理概要/process overview  : HomeController
 * 作成日/create date         : 2021/08/13
 * 作成者/creater             : Anh
 *
 * 更新日/update date         :
 * 更新者/updater             :
 * 更新内容 /update content   :
 *
 * @package Modules/Home
 * @copyright Copyright (c) toploop.co
 * @version 1.0.0
 */

namespace App\Modules\Home\Controllers;

use App\Helpers\Helper;
use Illuminate\Http\Request;
use App\Modules\Home\Models\HomeModel;
use App\Http\Controllers\Controller;
use App\Modules\Home\Models\ApplyJobModel;
use App\Modules\Home\Requests\ApplyJobRequest;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;


class HomeController extends Controller
{

    /**
     * Homepage.
     * Created: 2021/08/13
     * @author AnhHT <anh.ho@toploop.co	>
     * @return \Illuminate\Http\Response 
     */
    public function Index(Request $request)
    {
        try {
            return view('Home::Home.Index');
        }
        catch(\Exception $e) {
            return redirect()->route('ServerError', ["error" => $e->getMessage()]);
        }
    }
}
