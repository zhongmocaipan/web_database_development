<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

class Administor extends ActiveRecord
{

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%administor}}'; // 数据表名称，假设表名为 user
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['administorname', 'password'], 'required'],
            [['administorname'], 'unique'],
        ];
    }

    // 根据用户名查找用户
    public static function findByUsername($administorname)
    {
        return self::findOne(['administorname' => $administorname]);
    }

    // 验证密码是否正确
    public function validatePassword($password)
    {
        return $this->password === $password; // 直接比较密码，不做加密验证
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        // 根据 ID 查找用户
        return self::findOne($id);
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        // 返回用户的 ID（主键）
        return $this->getPrimaryKey();
    }

}
