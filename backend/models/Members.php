<?php
/*
 * Team：LOVEYII
 * Coding By：胡雨欣 2212117
 * 后端成员模型
*/
namespace backend\models;

use yii\db\ActiveRecord;

class Members extends ActiveRecord
{
    public static function tableName()
    {
        return 'members';
    }

    public function rules()
    {
        return [
            [['membername', 'memberschoolID', 'zuzhangorduiyuan'], 'required'],
            [['memberschoolID'], 'integer'],
            [['zuzhangorduiyuan'], 'in', 'range' => ['团队', '队长', '队员']],
            [['memberhomework'], 'file', 'extensions' => 'zip, rar', 'maxSize' => 10 * 1024 * 1024], 
        ];
    }
}
