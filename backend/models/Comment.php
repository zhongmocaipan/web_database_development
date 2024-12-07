<?php

namespace backend\models;

use Yii;
use yii\db\ActiveRecord;
use common\models\User;  // 引入 User 模型

class Comment extends ActiveRecord
{
    public static function tableName()
    {
        return 'comment'; // 关联到 comments 表
    }

    public function rules()
    {
        return [
            [['paper_id', 'user_id', 'content'], 'required'],
            [['paper_id', 'user_id'], 'integer'],
            [['content'], 'string'],
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
