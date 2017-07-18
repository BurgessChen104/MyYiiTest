<?php

class testForm extends CFormModel
{
	public $account;
    public $password;
    public $rememberMe=false;
 
    private $_identity;
 
    public function rules()
    {
        return array(
            array('account, password', 'required'),
            array('account', 'length', 'min'=>5, 'max'=>12),
            array('rememberMe', 'boolean'),
            array('password', 'authenticate'),
        );
    }
 
    public function authenticate($attribute,$params)
    {
        $this->_identity=new UserIdentity($this->account,$this->password);
        if(!$this->_identity->authenticate())
            $this->addError('password','錯誤的帳號及密碼');
    }

}


