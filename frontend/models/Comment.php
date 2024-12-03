<?php
namespace frontend\models;


use Yii;
use yii\base\Model;
use yii\db\ActiveRecord;
use common\models\User;  // 引入位于 common/models/User.php 的 User 模型


class Comment extends ActiveRecord
{
    // 指定表名
    public static function tableName()
    {
        return 'comment';  // 对应数据库中的 `comment` 表
    }

    // 定义规则
    public function rules()
    {
        return [
            [['movie_id', 'user_id', 'content'], 'required'],  // 必填字段
            [['movie_id'], 'string', 'max' => 50],              // movie_id 字符串类型，最大长度 50
            [['user_id'], 'integer'],                           // user_id 应该是整数
            [['content'], 'string'],                             // 评论内容为字符串
            [['created_at'], 'integer'],                         // 创建时间为整数（时间戳）
        ];
    }

    
    // 定义与 User 模型的关系
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}
