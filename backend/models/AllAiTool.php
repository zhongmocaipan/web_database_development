<?php
namespace backend\models;

use Yii;
use yii\db\ActiveRecord;

class AllAiTool extends ActiveRecord
{
    public static function tableName()
    {
        return 'all_ai_tool';
    }

    public static function primaryKey()
    {
        return ['AI Tool Name']; // 设置主键为 `AI Tool Name`
    }

    public function rules()
    {
        return [
            [['AI Tool Name', 'Description'], 'required'],
            [['AI Tool Name', 'Description'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'AI Tool Name' => 'AI Tool Name',
            'Description' => 'Description',
        ];
    }

    // 定义与 ToolComment 的关系
    public function getToolComments()
    {
        return $this->hasMany(ToolComment::class, ['tool_name' => 'AI Tool Name']);
    }

    // 显式定义属性映射，确保字段能够正确访问
    public function getAiToolName()
    {
        return $this->getAttribute('AI Tool Name');
    }

    
}
