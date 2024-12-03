<?php
/**
 * Team:ddl驱动队,NKU
 * coding by sunyiqi 2012810,202302008
 * login
 */
namespace common\models;

use Yii;
use yii\base\Model;

/**
 * Login form
 */
class LoginFormAdministor extends Model
{
    public $administorname;
    public $password;
    public $rememberMe = true;

    private $_administor;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['administorname', 'password'], 'required'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password','string', 'min' => 6],
        ];
    }


    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
   
        if (!$administor || !$administor->validatePassword($this->password)) {
            $this->addError($attribute, 'Incorrect username or password.');
        }
    }

    /**
     * Logs in a user using the provided username and password.
     *
     * @return bool whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
        }
        
        return false;
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    protected function getUser()
    {
        
        if ($this->_administor === null) {
            $this->_administor = Administor::findByUsername($this->administorname);
        }

        return $this->_administor;
    }
}