<?php
/*
 * Team：LOVEYII
 * Coding By：庞艾语 2211581
 * 后端paper点赞模型
*/
namespace backend\models;

use Yii;
use yii\db\ActiveRecord;
use common\models\User;  // 引入 User 模型

class PaperDislike extends ActiveRecord
{
    public static function tableName()
    {
        return 'paper_dislikes'; // 关联到 comments 表
    }

    public function rules()
    {
        return [
            [['paper_id', 'user_id'], 'required'],
            [['paper_id', 'user_id'], 'integer'],
            [['created_at'], 'safe'],
        ];
    }

    public function getPaper()
    {
        return $this->hasOne(ArxivPaper::class, ['id' => 'paper_id']);
    }

    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    
}
