<?php

/**
 * ErrorController
 * Process for custom page error
 *
 * 処理概要/process overview  : ErrorController
 * 作成日/create date         : 2021/05/26
 * 作成者/creater             : QuyPN
 *
 * 更新日/update date         :
 * 更新者/updater             :
 * 更新内容 /update content   :
 *
 * @package Modules/Home
 * @copyright Copyright (c) toploop.co
 * @version 1.0.0
 */

namespace App\Modules\Admin\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ErrorController extends Controller
{

    /**
     * ServerError.
     * Created: 2021/05/26
     * @author QuyPN <quy.pham@toploop.co>
     * @return \Illuminate\Http\Response Page error 500
     */
    public function ServerError(Request $request){
        $error = $request->input('error');
        return view('Admin::Error.500', ['error' => $error]);
    }

    /**
     * PageNotFound.
     * Created: 2021/05/20
     * @author QuyPN <quy.pham@toploop.co>
     * @return \Illuminate\Http\Response Page error 404
     */
    public function PageNotFound(Request $request){
        return view('Admin::Error.404');
    }

    /**
     * AccessDenied.
     * Created: 2021/05/20
     * @author QuyPN <quy.pham@toploop.co>
     * @return \Illuminate\Http\Response Page error 403
     */
    public function AccessDenied(Request $request){
        return view('Admin::Error.403');
    }
}
