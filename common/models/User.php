<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_INACTIVE = 0; // 用户未激活状态
    const STATUS_ACTIVE = 10; // 用户活跃状态
    public $status;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user}}'; // 数据表名称，假设表名为 user
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'password', 'email'], 'required'],
            [['username', 'email'], 'string', 'max' => 255],
            [['password'], 'string', 'max' => 60],
            [['email'], 'email'],
            [['username', 'email'], 'unique'],
        ];
    }

    // 根据用户名查找用户
    public static function findByUsername($username)
    {
        return self::findOne(['username' => $username]);
    }

    // 验证密码是否正确
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password);
    }

    // 设置密码，保存加密后的密码
    public function setPassword($password)
    {
        $this->password = Yii::$app->security->generatePasswordHash($password);
    }

    // 在保存用户时设置默认的激活状态为 ACTIVE
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->status = self::STATUS_ACTIVE; // 设置新用户的status为激活
            }
            return true;
        }
        return false;
    }

    // 激活用户
    public function activate()
    {
        $this->status = self::STATUS_ACTIVE;
        return $this->save(false);
    }

    // 获取激活状态的用户
    public static function findActiveUser($username)
    {
        return self::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
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
    public static function findIdentityByAccessToken($token, $type = null)
    {
        // 如果你有实现基于 token 的登录，可以在这里处理
        return self::findOne(['auth_key' => $token]);
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        // 返回用户的 ID（主键）
        return $this->getPrimaryKey();
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        // 如果你需要支持 authKey，可以返回用户的 auth_key 字段
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        // 验证 authKey 是否匹配
        return $this->getAuthKey() === $authKey;
    }
}
