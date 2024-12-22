<?php
/*
 * Team：LOVEYII
 * Coding By：胡雨欣 2212117
 * 后端所有tool模型
*/
namespace backend\models;

use Yii;
use yii\db\ActiveRecord;

class AllAiTool extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'all_ai_tool';
    }

    public function rules()
    {
        return [
            [['aiToolName', 'Description'], 'required'], // 必填字段
            [['aiToolName'], 'unique', 'targetAttribute' => 'AI Tool Name'], // 显式指定数据库字段名
            [['Description', 'freePaidOther', 'useableFor', 'Charges', 'Review', 'toolLink', 'majorCategory'], 'safe'], // 其他字段
        ];
    }
            
    // 映射数据库的字段名
    public function attributeLabels()
    {
        return [
            'aiToolName' => 'AI Tool Name',
            'freePaidOther' => 'Free/Paid/Other',
            'useableFor' => 'Useable For',
            'toolLink' => 'Tool Link',
            'majorCategory' => 'Major Category',
        ];
    }
        // 添加映射方法
    public function getAiToolName()
    {
        return $this->getAttribute('AI Tool Name'); // 映射数据库的字段名
    }

    public function setAiToolName($value)
    {
        $this->setAttribute('AI Tool Name', $value);
    }

    public function getFreePaidOther()
    {
        return $this->getAttribute('Free/Paid/Other');
    }

    public function setFreePaidOther($value)
    {
        $this->setAttribute('Free/Paid/Other', $value);
    }

     // Useable For 映射
    public function getUseableFor()
    {
        return $this->getAttribute('Useable For');
    }

    public function setUseableFor($value)
    {
        $this->setAttribute('Useable For', $value);
    }
    // Useable For 映射
    public function getToolLink()
    {
        return $this->getAttribute('Tool Link');
    }

    public function setToolLink($value)
    {
        $this->setAttribute('Tool Link', $value);
    }
    public function getMajorCategory()
    {
        return $this->getAttribute('Major Category');
    }

    public function setMajorCategory($value)
    {
        $this->setAttribute('Major Category', $value);
    }

}


