<?php
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
            [['aiToolName', 'Description'], 'required'],
            [['aiToolName'], 'unique'], // 添加唯一性验证
            [['Description', 'freePaidOther', 'useableFor', 'charges', 'review', 'toolLink', 'majorCategory'], 'safe'],
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
        return $this->getAttribute('Tool Link');
    }

    public function setMajorCategory($value)
    {
        $this->setAttribute('Major Category', $value);
    }

}


