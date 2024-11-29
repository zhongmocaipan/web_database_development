<?php
namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\User;

/**
 * Signup form
 */
namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\User; // 引入 User 模型
use yii\web\IdentityInterface;

class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;

    // 定义验证规则
    public function rules()
    {
        return [
            [['username', 'email', 'password'], 'required'],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email address has already been taken.'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This username has already been taken.'],
            ['password', 'string', 'min' => 6],
        ];
    }

    // 注册用户
    public function signup()
    {
        if ($this->validate()) {
            $user = new User();
            $user->username = $this->username;
            $user->email = $this->email;
            $user->password = Yii::$app->security->generatePasswordHash($this->password); // 密码哈希加密
            $user->auth_key = Yii::$app->security->generateRandomString(); // 生成auth_key
            $user->created_at = date('Y-m-d H:i:s', time()); // 当前时间转为DATETIME格式
            $user->updated_at = date('Y-m-d H:i:s', time()); // 当前时间转为DATETIME格式


            return $user->save() ? $user : null;
        }

        return null;
    }
}
