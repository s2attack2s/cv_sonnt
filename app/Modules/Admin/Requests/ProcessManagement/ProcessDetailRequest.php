<?php
/**
 * ProcessDetailRequest
 * Request for validate and set default values for data of process
 *
 * 処理概要/process overview  : ProcessDetailRequest
 * 作成日/create date         : 2021/06/01
 * 作成者/creater             : dinhan0209@gmail.com
 *
 * 更新日/update date         :
 * 更新者/updater             :
 * 更新内容 /update content   :
 *
 * @package Customer
 * @copyright Copyright (c) ANS-ASIA
 * @version 1.0.0
 */
namespace App\Modules\Admin\Requests\ProcessManagement;

use App\Http\Requests\CommonRequest;

class ProcessDetailRequest extends CommonRequest
{
    /**
     * Get the validation rules that apply to the request.
     * @return array
     */
    public function rules()
    {
        return [
            'vi.title'              => 'required|max:255',
            'vi.description'        => 'required',
            'vi.content'            => 'required',
            'trans.title'           => 'required|max:255',
            'trans.description'     => 'required',
            'trans.content'         => 'required'
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
