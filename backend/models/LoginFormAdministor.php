<?php
namespace backend\models;

use Yii;
use yii\base\Model;

//use backend\models\Administor;  // 引入 Administor 模型

class LoginFormAdministor extends Model
{
    public $administorname;
    public $password;
    public $rememberMe = true;

    private $_administor = false;

    public function rules()
    {
        return [
            [['administorname', 'password'], 'required'],
            ['rememberMe', 'boolean'],
            ['administorname', 'string', 'max' => 255],
            ['password', 'validatePassword'],
        ];
    }

    // 验证密码
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $administor = $this->getAdministor();
            if (!$administor || !$administor->validatePassword($this->password)) {
                $this->addError($attribute, 'Incorrect administorname or password.');
            }
        }
    }

    // 根据用户名获取用户对象
    public function getAdministor()
    {
        if ($this->_administor === false) {
            $this->_administor = Administor::findByUsername($this->administorname);
        }
        return $this->_administor;
    }

    // 执行登录
    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getAdministor(), $this->rememberMe ? 3600 * 24 * 30 : 0);
        }
        return false;
    }
}
