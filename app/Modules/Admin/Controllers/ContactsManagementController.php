<?php

/**
 * ContactsManagementController
 * Process for page list of contacts
 *
 * 処理概要/process overview  : ContactsManagementController
 * 作成日/create date         : 2021/08/16
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

use App\Modules\Admin\Requests\ContactsManagement\SearchContactsConditionRequest;
use App\Modules\Admin\Requests\ContactsManagement\ContactDetailRequest;
use App\Modules\Admin\Models\ContactsManagement\ListOfContactsModel;
use App\Modules\Admin\Models\ContactsManagement\ContactDetailModel;

use Helper, DataResponse, ResponseCode;

class ContactsManagementController extends Controller
{
    protected $modelOfList;
    protected $modelOfDetail;
    protected $status;

    public function __construct() {
        $this->modelOfList = new ListOfContactsModel();
        $this->modelOfDetail = new ContactDetailModel();
        $this->status = [ 0 => __('New'), 1 => __('Read'), 2 => __('Resolved'), 3 => __('Closed') ];
    }

    /**
     * ListOfContact
     * Created: 2021/08/16
     * @param SearchContactsConditionRequest $request
     * @return \Illuminate\Http\Response
     * @author TriTD <tritd@toploop.co>
     */
    public function ListOfContacts(SearchContactsConditionRequest $request){

        try {
            $condition = $request->all();

            $data = $this->modelOfList->ListOfContacts($request->all());
            if ($request->ajax()) {
                return view('Admin::ContactsManagement.TableContact',
                    [
                        "data" => $data,
                        'status' => $this->status,
                        'condition' => $condition
                    ]);
            }
            return view('Admin::ContactsManagement.ListOfContacts',
                [
                    "data" => $data,
                    'status' => $this->status,
                    'condition' => $condition
                ]);

        }
        
        catch(\Exception $e) {
            return redirect()->route('ServerError', ["error" => $e->getMessage()]);
        }
    }

    /**
     * DeleteContacts
     * Created: 2021/08/14
     * @author TriTD <tritd@toploop.co>
     * @param  Request  $request Data from contact
     * @return DataResponse Delete result
     */
    public function DeleteContacts(Request $request) {
        $response = new DataResponse();
        try {
            $response = $this->modelOfList->DeleteContacts($request->get('ids'));
        }
        catch(\Exception $e) {
            $response->SetException($e);
        }
        return response()->json($response->GetData());
    }

    /**
     * UpdateStatus
     * Created: 2021/08/16
     * @author TriTD <tritd@toploop.co>
     * @param  Request  $request Data from contact
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
     * CreateContact
     * Created: 2021/08/16
     * @author TriTD <tritd@toploop.co>
     * @param  Request  $request Data from contact
     * @return \Illuminate\Http\Response
     */
    public function CreateContact(Request $request) {
        try {
            $data = $this->modelOfDetail->LoadContact(0);
            return view('Admin::ContactsManagement.ContactDetail',
                    [
                        "data" => $data,
                        'status' => $this->status
                    ]);
        }
        catch(\Exception $e) {
            return redirect()->route('ServerError', ["error" => $e->getMessage()]);
        }
    }

    /**
     * EditContact
     * Created: 2021/08/16
     * @author TriTD <tritd@toploop.co>
     * @param  Request  $request Data from contact
     * @return \Illuminate\Http\Response
     */
    public function ViewContact($id) {
        try {
            $data = $this->modelOfDetail->LoadContact($id);
            return view('Admin::ContactsManagement.ContactDetail',
                [
                    "data" => $data,
                    'status' => $this->status,
                ]);
        }
        
        catch(\Exception $e) {
            return redirect()->route('ServerError', ["error" => $e->getMessage()]);
        }
    }

    /**
     * UpdateContact
     * Created: 2021/08/16
     * @author TriTD <tritd@toploop.co>
     * @param  Request  $request Data from contact
     * @return DataResponse Update result
     */
    public function UpdateContact(ContactDetailRequest $request) {
        $response = new DataResponse();
        try {
            $response = $this->modelOfDetail->UpdateContact($request->all());
        }
        catch(\Exception $e) {
            $response->SetException($e);
        }
        return response()->json($response->GetData());
    }

    /**
     * Update Status - Resolve
     * Created: 2021/08/16
     * @author TriTD <tritd@toploop.co>
     * @param  Request  $request Data from contact
     * @return DataResponse Update result
     */
    public function ResolveContact(Request $request) {

        $response = new DataResponse();
        try {
            $response = $this->modelOfDetail->UpdateContactStatus($request->id, 2);
        }
        catch(\Exception $e) {
            $response->SetException($e);
        }
        return response()->json($response->GetData());
    }

    /**
     * Update Status - Close
     * Created: 2021/08/16
     * @author TriTD <tritd@toploop.co>
     * @param  Request  $request Data from contact
     * @return DataResponse Update result
     */
    public function CloseContact(Request $request) {

        $response = new DataResponse();
        try {
            $response = $this->modelOfDetail->UpdateContactStatus($request->id, 3);
        }
        catch(\Exception $e) {
            $response->SetException($e);
        }
        return response()->json($response->GetData());
    }
}
