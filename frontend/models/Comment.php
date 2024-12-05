<?php
namespace frontend\models;


use Yii;
use yii\base\Model;
use yii\db\ActiveRecord;
use common\models\User;  // 引入位于 common/models/User.php 的 User 模型


class Comment extends ActiveRecord
{
    public static function tableName()
    {
        return 'comment';  // 对应数据库中的 `comment` 表
    }

    public function rules()
    {
        return [
            [['paper_id', 'user_id', 'content'], 'required'],  // 必填字段
            [['paper_id', 'user_id'], 'integer'],             // paper_id 和 user_id 为整数
            [['content'], 'string'],                          // 评论内容为字符串
            [['created_at'], 'integer'],                      // 创建时间为时间戳
        ];
    }

    // 定义与 User 模型的关系
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    
}
