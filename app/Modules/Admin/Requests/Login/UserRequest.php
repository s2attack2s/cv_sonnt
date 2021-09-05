<?php
/**
 * UserRequest
 * Request for validate and set default values for data of user login
 *
 * 処理概要/process overview  : UserRequest
 * 作成日/create date         : 2021/05/26
 * 作成者/creater             : quy.pham@toploop.co
 *
 * 更新日/update date         :
 * 更新者/updater             :
 * 更新内容 /update content   :
 *
 * @package Customer
 * @copyright Copyright (c) ANS-ASIA
 * @version 1.0.0
 */
namespace App\Modules\Admin\Requests\Login;

use App\Http\Requests\CommonRequest;

class UserRequest extends CommonRequest
{
    /**
     * Get the validation rules that apply to the request.
     * @return array
     */
    public function rules()
    {
        return [
            'username'  => 'required|string|max:100',
            'password'  => 'required|string|max:100',
        ];
    }

    /**
     * Get default value if not have in request of client
     */
    protected function getDeffaultValues()
    {
        $data = $this->all();
        $defaults = [];
        $data = $this->setDeffaultValues($defaults, $data);
        $this->getInputSource()->replace($data);
    }

    /**
     * Get the validator instance for the request.
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function getValidatorInstance()
    {
        $this->getDeffaultValues();
        return parent::getValidatorInstance();
    }

}
