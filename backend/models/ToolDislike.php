<?php
/*
 * Team：LOVEYII
 * Coding By：胡雨欣 2212117
 * 后端工具点赞模型
*/
namespace backend\models;

use Yii;
use yii\db\ActiveRecord;
use common\models\User;  // 引入 User 模型

class ToolDislike extends ActiveRecord
{
    // 绑定表名
    public static function tableName()
    {
        return 'tool_dislikes';  // 数据表名
    }

    // 定义规则
    public function rules()
    {
        return [
            [['tool_name'], 'required'],  // 确保 tool_name 和 content 字段必填
            [['tool_name'], 'string'],             // tool_name 必须是字符串
            [['created_at'], 'safe'],             // created_at 是安全的（日期字段）
        ];
    }

    // 定义字段标签
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tool_name' => 'Tool Name',
            'created_at' => 'Created At',
            'user_id' => 'User ID', // 显示 User ID
        ];
    }

    // 与 User 表的关联关系
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);  // 假设用户表是 User，关联 user_id
    }

    // 通过 tool_id 关联 AllAiTool
    public function getTool()
    {
        return $this->hasOne(AllAiTool::class, ['AI Tool Name' => 'tool_name']);
    }

}
