<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use backend\models\AllAiTool;
use backend\models\ToolLike;
use backend\models\ArxivPaper;
use backend\models\PaperLike;
use backend\models\AiToolSearch;
use yii\data\Pagination;
class PostController extends Controller
{
    // 显示选择评论类型的页面
    public function actionSelectType()
    {
        return $this->render('select-type');  // 渲染视图 select-type.php
    }

        // 显示 AI Tool 评论页面
        public function actionAiTool()
        {
            // 获取所有的 AI 工具数据
            $query = AllAiTool::find();            
            // 分页查询
            $pagination = new Pagination([
                'defaultPageSize' => 10,
                'totalCount' => $query->count(),
            ]);
    
            $tools = $query->offset($pagination->offset)
                ->limit($pagination->limit)
                ->all();
    

                $searchModel = new AiToolSearch();  // 创建搜索模型
                $data = $searchModel->search(Yii::$app->request->queryParams);  // 获取搜索数据
                

            // 渲染视图，并将数据传递给视图
            return $this->render('ai-tool', [
                'tools' => $tools,
                'pagination' => $pagination,
            ]);
        }


      public function actionViewLikes($toolName)
        {
            // 根据 AI Tool Name 获取 AI 工具信息
            $tool = AllAiTool::find()->where(['AI Tool Name' => $toolName])->one();
        
            if (!$tool) {
                throw new \yii\web\NotFoundHttpException('The requested tool does not exist.');
            }
        
            // 查询点赞数据
            $query = ToolLike::find()->where(['tool_name' => $tool->getAttribute('AI Tool Name')])->orderBy(['created_at' => SORT_DESC]);
        
            // 设置分页
            $pagination = new Pagination([
                'defaultPageSize' => 10,
                'totalCount' => $query->count(),
            ]);
        
            // 获取分页后的数据
            $toolLikes = $query->offset($pagination->offset)
                               ->limit($pagination->limit)
                               ->all();
        
            // 获取总点赞数
            $totalLikes = $query->count();
        
            // 渲染视图并传递数据
            return $this->render('view-likes', [
                'toolLikes' => $toolLikes,
                'pagination' => $pagination,
                'tool' => $tool,
                'totalLikes' => $totalLikes,  // 传递总点赞数
            ]);
        }
        
             // 显示 Paper 评论页面
    public function actionPaper()
    {
        // 获取所有的 Paper 数据
        $query = ArxivPaper::find();

        // 分页查询
        $pagination = new Pagination([
            'defaultPageSize' => 10,
            'totalCount' => $query->count(),
        ]);

        $papers = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        // 渲染视图，并将数据传递给视图
        return $this->render('paper', [
            'papers' => $papers,
            'pagination' => $pagination,
        ]);
    }

    public function actionViewPaperLikes($id)
    {
        // 根据 Paper ID 获取对应的 Paper 信息
        $paper = ArxivPaper::findOne($id);
    
        if (!$paper) {
            throw new \yii\web\NotFoundHttpException('The requested paper does not exist.');
        }
    
        // 查询该论文的所有点赞记录
        $query = PaperLike::find()->where(['paper_id' => $id])->orderBy(['created_at' => SORT_DESC]);
    
        // 分页设置
        $pagination = new Pagination([
            'defaultPageSize' => 10,  // 每页显示 10 条记录
            'totalCount' => $query->count(),
        ]);
    
        // 获取分页后的点赞数据
        $paperLikes = $query->offset($pagination->offset)
                            ->limit($pagination->limit)
                            ->all();
    
        // 获取总点赞数
        $totalLikes = $query->count();
    
        // 渲染视图并传递数据
        return $this->render('view-paper-likes', [
            'paperLikes' => $paperLikes,
            'pagination' => $pagination,
            'paper' => $paper,
            'totalLikes' => $totalLikes,
        ]);
    }

    public function actionDeletePaperLike($id)
{
    $paperLike = PaperLike::findOne($id);

    if (!$paperLike) {
        throw new \yii\web\NotFoundHttpException('The requested like does not exist.');
    }

    // 删除该点赞记录
    if ($paperLike->delete()) {
        Yii::$app->session->setFlash('success', 'Like has been deleted.');
    } else {
        Yii::$app->session->setFlash('error', 'Failed to delete like.');
    }

    return $this->redirect(['view-paper-likes', 'id' => $paperLike->paper_id]);
}
public function actionDeleteLike($id)
{
    $like = ToolLike::findOne($id);
    if ($like) {
        $like->delete();
    }

    return $this->redirect(['view-likes', 'toolName' => $like->tool->getAttribute('AI Tool Name')]);
}

};