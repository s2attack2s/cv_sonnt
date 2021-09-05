<?php
/**
 * EmailSettingDetailRequest
 * Request for validate and set default values for data of setting
 *
 * 処理概要/process overview  : EmailSettingDetailRequest
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

class EmailSettingDetailRequest extends CommonRequest
{
    /**
     * Get the validation rules that apply to the request.
     * @return array
     */
    public function rules()
    {
        return [
            'vi.mailer'             => 'required|max:10',
            'vi.mail_port'          => 'required|integer',
            'vi.mail_host'          => 'required|max:100',
            'vi.mail_smtp_auth'     => 'required|max:10',
            'vi.mail_user'          => 'required|max:255',
            'vi.mail_password'      => 'required|max:255',
            'vi.mail_from'          => 'required|max:255',
            'vi.mail_received'      => 'required|max:255',
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
