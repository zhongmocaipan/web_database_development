<?php
/*
 * Team：LOVEYII
 * Coding By：胡雨欣 2212117 庞艾语 2211581
 * 后端site控制器
*/
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use backend\models\LoginFormAdministor;  // 引入正确的命名空间
use backend\models\AllAiTool; 
use backend\models\Comment; 
use backend\models\PaperLike; 
use backend\models\ToolLike;
use backend\models\ToolComment;  
use backend\models\ArxivPaper;
use backend\models\Members;
use backend\models\ToolDislike;  // 引入 ToolDislike 模型
use backend\models\PaperDislike;  // 引入 PaperDislike 模型
use yii\data\Pagination;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index', 'paper-management', 'add-paper', 'tool-management', 'add-tool', 'delete-tool', 'delete-paper'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        // 获取前五名点赞数最多的论文，连接 ArxivPaper 表获取论文名称
        $topPapers = PaperLike::find()
            ->select(['paper_likes.paper_id', 'COUNT(*) as likes_count'])
            ->joinWith('paper') // 通过关联关系连接 ArxivPaper 表
            ->groupBy('paper_likes.paper_id') // 按照 paper_id 分组
            ->orderBy(['likes_count' => SORT_DESC]) // 按照点赞数降序排序
            ->limit(5) // 获取前五名
            ->asArray() // 返回数组形式
            ->all();
    
        // 获取对应的论文名称和点赞数
        $paperTitles = [];
        $paperLikes = [];
        foreach ($topPapers as $paper) {
            $paperTitles[] = $paper['paper']['title']; // 获取论文标题
            $paperLikes[] = $paper['likes_count']; // 获取论文点赞数
        }

        // 获取前五名点踩数最多的论文，连接 ArxivPaper 表获取论文名称
        $topPapers = PaperDislike::find()
            ->select(['paper_dislikes.paper_id', 'COUNT(*) as dislikes_count'])
            ->joinWith('paper') // 通过关联关系连接 ArxivPaper 表
            ->groupBy('paper_dislikes.paper_id') // 按照 paper_id 分组
            ->orderBy(['dislikes_count' => SORT_DESC]) // 按照点赞数降序排序
            ->limit(5) // 获取前五名
            ->asArray() // 返回数组形式
            ->all();
    
        // 获取对应的论文名称和点赞数
        $paperTitles = [];
        $paperDislikes = [];
        foreach ($topPapers as $paper) {
            $paperTitles[] = $paper['paper']['title']; // 获取论文标题
            $paperDislikes[] = $paper['dislikes_count']; // 获取论文点赞数
        }
    
        // 获取前五名评论数最多的论文
        $topPaperComments = Comment::find()
            ->select(['comment.paper_id', 'COUNT(*) as comment_count', 'arxiv_papers.title as paper_title']) // 使用 arxiv_papers.title 而不是 paper.title
            ->joinWith('paper') // 通过关联关系连接 arxiv_papers 表
            ->groupBy('comment.paper_id') // 按照 paper_id 分组
            ->orderBy(['comment_count' => SORT_DESC]) // 按照评论数降序排序
            ->limit(5) // 获取前五名评论数最多的论文
            ->asArray() // 返回数组形式
            ->all();
    
        // 获取对应的论文名称和评论数
        $paperCommentTitles = [];
        $paperCommentCounts = [];
        foreach ($topPaperComments as $comment) {
            $paperCommentTitles[] = $comment['paper_title']; // 获取论文标题
            $paperCommentCounts[] = $comment['comment_count']; // 获取论文的评论数
        }
    
        // 获取前五名评论数最多的工具
        $topToolComments = ToolComment::find()
            ->select(['tool_comments.tool_name', 'COUNT(*) as comment_count'])
            ->groupBy('tool_comments.tool_name') // 按照 tool_name 分组
            ->orderBy(['comment_count' => SORT_DESC]) // 按照评论数降序排序
            ->limit(5) // 获取前五名评论数最多的工具
            ->asArray() // 返回数组形式
            ->all();
    
        // 获取对应的工具名称和评论数
        $toolCommentNames = [];
        $toolCommentCounts = [];
        foreach ($topToolComments as $tool) {
            $toolCommentNames[] = $tool['tool_name']; // 获取工具名称
            $toolCommentCounts[] = $tool['comment_count']; // 获取工具评论数
        }
    
        // 获取前五名点赞数最多的工具
        $topTools = ToolLike::find()
            ->select(['tool_likes.tool_name', 'COUNT(*) as likes_count'])
            ->groupBy('tool_likes.tool_name') // 按照 tool_name 分组
            ->orderBy(['likes_count' => SORT_DESC]) // 按照点赞数降序排序
            ->limit(5) // 获取前五名
            ->asArray() // 返回数组形式
            ->all();
    
        // 获取对应的工具名称和点赞数
        $toolNames = [];
        $toolLikes = [];
        foreach ($topTools as $tool) {
            $toolNames[] = $tool['tool_name']; // 获取工具名称
            $toolLikes[] = $tool['likes_count']; // 获取工具点赞数
        }
        // 获取前五名点踩数最多的工具
        $topTools = ToolDislike::find()
            ->select(['tool_dislikes.tool_name', 'COUNT(*) as dislikes_count'])
            ->groupBy('tool_dislikes.tool_name') // 按照 tool_name 分组
            ->orderBy(['dislikes_count' => SORT_DESC]) // 按照点赞数降序排序
            ->limit(5) // 获取前五名
            ->asArray() // 返回数组形式
            ->all();
    
        // 获取对应的工具名称和点赞数
        $toolNames = [];
        $toolDislikes = [];
        foreach ($topTools as $tool) {
            $toolNames[] = $tool['tool_name']; // 获取工具名称
            $toolDislikes[] = $tool['dislikes_count']; // 获取工具点赞数
        }
    
        // 准备传递给视图的数据
        $data = [
            'paperTitles' => $paperTitles,  // 使用正确的变量名称
            'paperLikes' => $paperLikes,
            'paperDislikes' => $paperDislikes,
            'paperCommentCounts' => $paperCommentCounts,
            'paperCommentTitles' => $paperCommentTitles,
            'toolNames' => $toolNames,
            'toolLikes' => $toolLikes,
            'toolDislikes' => $toolDislikes,
            'toolComments' => $toolCommentCounts,
            'toolCommentNames' => $toolCommentNames,
        ];    
        return $this->render('index', $data); // 将数据传递到视图
    }
    
    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        $model = new LoginFormAdministor();

        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            $model->password = '';  // 清空密码
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionPaperManagement()
    {
        $papers = ArxivPaper::find()->all();
        return $this->render('paper-management', ['papers' => $papers]);
    }

    public function actionAddPaper()
    {
        $paper = new ArxivPaper();

        if ($paper->load(Yii::$app->request->post()) && $paper->save()) {
            Yii::$app->session->setFlash('success', 'Paper added successfully');
            return $this->redirect(['site/paper-management']);
        }

        return $this->render('add-paper', [
            'paper' => $paper,
        ]);
    }

    public function actionDeletePaper($id)
    {
        $paper = ArxivPaper::findOne($id);

        if ($paper) {
            $paper->delete();
            Yii::$app->session->setFlash('success', 'Paper deleted successfully');
        } else {
            Yii::$app->session->setFlash('error', 'Paper not found');
        }

        return $this->redirect(['site/paper-management']);
    }
   
    public function actionToolManagement()
    {
        // 查询所有 AI 工具数据
        $query = AllAiTool::find();

        // 创建分页对象
        $pagination = new Pagination([
            'defaultPageSize' => 10,  // 每页显示10条数据
            'totalCount' => $query->count(),  // 总记录数
        ]);

        // 根据分页对象限制查询结果
        $tools = $query->offset($pagination->offset)
                       ->limit($pagination->limit)
                       ->all();

        // 渲染视图，并传递分页对象和数据
        return $this->render('tool-management', [
            'tools' => $tools,
            'pagination' => $pagination,
        ]);
    }

    public function actionAddTool()
    {
        $model = new AllAiTool();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            // 确保数据完整
            if (!empty($model->aiToolName)) {
                $model->save(false); // 保存数据到数据库
                Yii::$app->session->setFlash('success', 'AI Tool added successfully.');
                return $this->redirect(['tool-management']);
            } else {
                Yii::$app->session->setFlash('error', 'AI Tool Name is required.');
            }
        }

        return $this->render('add-tool', ['model' => $model]);
    }

    public function actionDeleteTool($toolName)
    {
        // 使用主键 'AI Tool Name' 查找对应的记录
        $tool = AllAiTool::findOne(['AI Tool Name' => $toolName]);

        if ($tool) {
            // 删除记录
            $tool->delete();
            Yii::$app->session->setFlash('success', 'Tool deleted successfully');
        } else {
            // 如果找不到记录，显示错误消息
            Yii::$app->session->setFlash('error', 'Tool not found');
        }

        // 重定向回工具管理页面
        return $this->redirect(['site/tool-management']);
    }
}