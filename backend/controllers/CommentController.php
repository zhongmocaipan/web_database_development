<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use backend\models\AllAiTool;
use backend\models\ToolComment;
use backend\models\ArxivPaper;
use backend\models\Comment;
use yii\data\Pagination;

class CommentController extends Controller
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

        // 渲染视图，并将数据传递给视图
        return $this->render('ai-tool', [
            'tools' => $tools,
            'pagination' => $pagination,
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

    // 在 CommentController 中的 viewComments 方法中获取评论并进行分页
    public function actionViewComments($toolName)
    {
        // 查找指定的 AI Tool
        $tool = AllAiTool::findOne(['AI Tool Name' => $toolName]);

        if ($tool === null) {
            throw new NotFoundHttpException('Tool not found.');
        }

        // 获取评论数据
        $query = ToolComment::find()->where(['tool_name' => $toolName]);

        // 分页查询
        $pagination = new Pagination([
            'defaultPageSize' => 10,
            'totalCount' => $query->count(),
        ]);

        $comments = $query->offset($pagination->offset)
                        ->limit($pagination->limit)
                        ->all();

        return $this->render('view-comments', [
            'tool' => $tool,
            'comments' => $comments,
            'pagination' => $pagination,
        ]);
    }


    public function actionViewPaperComments($id)
    {

        // 获取指定的论文信息
        $paper = ArxivPaper::findOne($id);
        // 调试日志：查看 $paper 的信息
        Yii::debug($paper, 'paper');
        Yii::info('This is an info message', 'category');
        if (!$paper) {
            throw new NotFoundHttpException('论文未找到');
        }
        if ($paper === null) {
            throw new \yii\web\NotFoundHttpException('The requested paper does not exist.');
        }
    
        // 获取与该论文相关的所有评论
        $comments = Comment::find()->where(['paper_id' => $id])->all();  // 通过 paper_id 获取评论
    
        // 渲染视图
        return $this->render('view-paper-comments', [
            'paper' => $paper,
            'comments' => $comments,  // 将评论数据传递到视图
        ]);
    }
                    

    // 删除评论
    public function actionDeleteComment($id)
    {
        $comment = ToolComment::findOne($id);
        if ($comment) {
            $comment->delete();
        }

        // 返回到评论页面
        return $this->redirect(['comment/view-comments', 'id' => $comment->ai_tool_id]);
    }

    // 更新评论页面
    public function actionUpdateComment($id)
    {
        $comment = ToolComment::findOne($id);
        
        if (!$comment) {
            throw new NotFoundHttpException('The requested comment does not exist.');
        }

        if ($comment->load(Yii::$app->request->post()) && $comment->save()) {
            // 更新成功后重定向回评论列表页
            return $this->redirect(['view-comments', 'toolName' => $comment->tool_name]);
        }

        return $this->render('update-comment', [
            'comment' => $comment,
        ]);
    }


    public function actionUpdatePaperComment($id)
    {
        // 获取需要更新的 paper
        $comment = Comment::findOne($id);
        
        if (!$comment) {
            throw new NotFoundHttpException('The requested paper does not exist.');
        }
    
        // 创建表单提交的模型实例
        if ($comment->load(Yii::$app->request->post()) && $comment->save()) {
            // 保存成功后跳转到显示评论的页面（可以根据需求跳转到其他页面）
            return $this->redirect(['view-paper-comments', 'id' => $paper->id]);
        }
    
        // 渲染更新页面
        return $this->render('update-paper-comment', [
            'comment' => $comment,
        ]);
    }
    
    public function actionDeletePaperComment($id)
    {
        // 获取需要删除的评论
        $comment = Comment::findOne($id);
        
        if (!$comment) {
            // 如果没有找到该评论，抛出异常
            throw new NotFoundHttpException('The requested comment does not exist.');
        }
    
        // 获取该评论关联的论文 ID
        $paperId = $comment->paper_id;
    
        // 删除评论
        $comment->delete();
    
        // 重定向回该论文的评论页面
        return $this->redirect(['view-paper-comments', 'id' => $paperId]);
    }
    

}
