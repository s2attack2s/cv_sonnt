<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Helper, Closure, DataResponse, ResponseCode;
use Illuminate\Support\Facades\DB;


class Authenticate extends Middleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request All value from client
     * @param  \Closure  $next The action will be execute
     * @param  string  $type Type of request (for api or normal)
     * @return mixed The action will be execute after check
     */
    public function handle($request, Closure $next, ...$guards)
    {
        $currentUser        = Helper::GetCurrentUser();
        $logined            = isset($currentUser) && !empty($currentUser);
        $have_permission    = true;
        if ($request->ajax() || $request->wantsJson()) {
            $response = new DataResponse();
            if(!$logined) {
                $response->code         = ResponseCode::FORBIDDEN;
                $response->msgNo        = 'E'.$response->code;
                return response($response->GetData());
            }
            if(!$have_permission) {
                $response->code         = ResponseCode::UNAUTHORIZED;
                $response->msgNo        = 'E'.$response->code;
                return response($response->GetData());
            }
        }
        else {
            if(!$logined) {
                \Session::put('UrlBefore', $request->getRequestUri());
                return redirect()->route('AdminLogin');
            }
            if(!$have_permission) {
                return redirect()->route('AccessDenied');
            }
        }
//        $countNew = DB::table('challenges')
//                ->where('status', 1)
//                ->where('deleted_at', null)
//                ->count();

//        \View::share('countNew', $countNew);
        \View::share('user', $currentUser);
        \View::share('languages', Helper::GetLanguages());
        return $next($request);
    }
}
