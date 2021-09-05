<?php
/**
 * ProfileDetailRequest
 * Request for validate and set default values for data of profile
 *
 * 処理概要/process overview  : ProfileDetailRequest
 * 作成日/create date         : 2021/06/2
 * 作成者/creater             : HungNo1
 *
 * 更新日/update date         :
 * 更新者/updater             :
 * 更新内容 /update content   :
 *
 * @package Customer
 * @copyright Copyright (c) ANS-ASIA
 * @version 1.0.0
 */
namespace App\Modules\Admin\Requests\Profile;

use App\Http\Requests\CommonRequest;

class ProfileRequest extends CommonRequest
{
    /**
     * Get the validation rules that apply to the request.
     * @return array
     */
    public function rules()
    {
        return [
            'username'   => 'required|max:255',
            'name'       => 'required|max:255',
            'address'    => 'required|max:255',
            'email'      => 'required|max:255',
            'phone'      => 'required|max:255',
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

