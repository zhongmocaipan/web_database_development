<?php

namespace backend\models;

use Yii;
use yii\db\ActiveRecord;

class ArxivPaper extends ActiveRecord
{
    public static function tableName()
    {
        return 'arxiv_papers'; // 关联到 arxiv_papers 表
    }

    public function rules()
    {
        return [
            [['title', 'authors'], 'required'],
            [['title', 'authors'], 'string', 'max' => 255],
            [['abstract'], 'string'],
            [['published'], 'safe'],
        ];
    }


        // 确保在这里定义了正确的属性
    public function getAuthors()
    {
        return $this->authors;  // 如果字段名是 authors
    }

    
    public function getComments()
    {
        return $this->hasMany(Comment::class, ['paper_id' => 'id']);
    }

}
