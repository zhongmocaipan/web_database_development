<?php
namespace frontend\models;

use Yii;
use yii\base\Model;
use frontend\models\User; // 引入 User 模型
use yii\base\InvalidParamException;

class LoginForm extends Model
{
    public $username;
    public $password;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['username', 'password'], 'required'],  // 用户名和密码都是必填字段
            ['password', 'validatePassword'],  // 自定义密码验证
        ];
    }

    // 自定义密码验证
    public function validatePassword($attribute, $params)
    {
        $user = User::findOne(['username' => $this->username]);

        // 如果找不到该用户或密码不匹配
        if (!$user || !Yii::$app->security->validatePassword($this->password, $user->password)) {
            $this->addError($attribute, 'Invalid username or password.');
        }
    }

    /**
     * 登录功能
     * @return bool whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            $user = User::findOne(['username' => $this->username]);
            // 如果验证通过，则登录
            return Yii::$app->user->login($user);
        }
        return false; // 登录失败
    }
}
