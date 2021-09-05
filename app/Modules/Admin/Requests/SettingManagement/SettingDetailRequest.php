<?php
/**
 * SettingDetailRequest
 * Request for validate and set default values for data of setting
 *
 * 処理概要/process overview  : SettingDetailRequest
 * 作成日/create date         : 2021/06/01
 * 作成者/creater             : thanhnguyenduyy@gmail.com
 *
 * 更新日/update date         :
 * 更新者/updater             :
 * 更新内容 /update content   :
 *
 * @package Customer
 * @copyright Copyright (c) ANS-ASIA
 * @version 1.0.0
 */
namespace App\Modules\Admin\Requests\SettingManagement;

use App\Http\Requests\CommonRequest;

class SettingDetailRequest extends CommonRequest
{
    /**
     * Get the validation rules that apply to the request.
     * @return array
     */
    public function rules()
    {
        return [
            'vi.image'             => 'required|max:255',
            'vi.facebook'          => 'required|max:255',
            'vi.linkedin'          => 'required|max:255',
            'vi.about_us'          => 'required|max:500',
            'vi.stories'           => 'required|max:255',
            'vi.process'           => 'required|max:255',
            'vi.description'       => 'required|max:500',
            'vi.keyword'           => 'required|max:100',
            'vi.author'            => 'required|max:100',
            'vi.phone'             => 'required|max:20',
            'vi.address'           => 'required|max:200',
            'vi.email'             => 'required|max:255',
            'trans.image'          => 'required|max:255',
            'trans.about_us'       => 'required|max:500',
            'trans.stories'        => 'required|max:255',
            'trans.process'        => 'required|max:255',
            'trans.description'    => 'required|max:500',
            'trans.keyword'        => 'required|max:100',
            'trans.author'         => 'required|max:100',
            'trans.phone'          => 'required|max:20',
            'trans.address'        => 'required|max:200',
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
