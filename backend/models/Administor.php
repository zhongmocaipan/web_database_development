<?php

namespace backend\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

class Administor extends ActiveRecord implements IdentityInterface
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%administor}}'; // 数据表名称
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['administorname', 'password'], 'required'],
            ['administorname', 'unique'],
        ];
    }
    // 添加 getUsername 方法
    public function getUsername()
    {
        return $this->administorname;  // 返回 administorname
    }
    /**
     * 根据用户名查找用户
     */
    public static function findByUsername($administorname)
    {
        return self::findOne(['administorname' => $administorname]);
    }

    /**
     * 验证密码
     */
    public function validatePassword($password)
    {
        return $this->password === $password;  // 比较明文密码
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return self::findOne($id);
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        // 如果没有使用授权密钥，返回 null
        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        // 如果没有使用授权密钥，直接返回 false 或者返回 true 也可以
        return false;
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return null;  // 如果不需要通过令牌查找用户，返回 null
    }
}
