<?php
/*
 * Team：LOVEYII
 * Coding By：胡雨欣 2212117
 * 后端查找tool模型
*/
namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\AllAiTool;

class AiToolSearch extends AllAiTool
{
    public $toolName;  // 用于搜索的字段

    public function rules()
    {
        return [
            [['toolName'], 'safe'],  // 支持模糊查询
        ];
    }

    public function search($params)
    {
        $query = AllAiTool::find();

        // 加载查询参数
        $this->load($params);

        if (!$this->validate()) {
            return $this->getDataProvider($query);
        }

        // 处理搜索字段
        if ($this->toolName) {
            $query->andFilterWhere(['like', 'AI Tool Name', $this->toolName]);
        }

        return $this->getDataProvider($query);
    }

    private function getDataProvider($query)
    {
        return new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,  // 每页显示10条记录
            ],
        ]);
    }
}
