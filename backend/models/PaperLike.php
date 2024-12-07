<?php

namespace backend\models;

use Yii;
use yii\db\ActiveRecord;
use common\models\User;  // 引入 User 模型

class PaperLike extends ActiveRecord
{
    public static function tableName()
    {
        return 'paper_likes'; // 关联到 comments 表
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
