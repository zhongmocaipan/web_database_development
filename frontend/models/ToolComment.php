<?php
namespace frontend\models;


use Yii;
use yii\base\Model;
use yii\db\ActiveRecord;
use common\models\User;  // 引入位于 common/models/User.php 的 User 模型

class ToolComment extends ActiveRecord
{
    public static function tableName()
    {
        return 'tool_comments';
    }

    public function rules()
    {
        return [
            [['tool_name', 'user_id', 'content'], 'required'],
            [['user_id'], 'integer'],
            [['content'], 'string'],
            [['created_at'], 'integer'],
            [['tool_name'], 'string', 'max' => 255],  // 使用 string 类型替代 tool_id 的整数
        ];
    }

    // 定义与 User 模型的关系
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    
}