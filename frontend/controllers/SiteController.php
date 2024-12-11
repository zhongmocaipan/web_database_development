<?php
namespace frontend\controllers;
use yii\db\Query;
use frontend\models\ResendVerificationEmailForm;
use frontend\models\VerifyEmailForm;
use Yii;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use frontend\models\Comment;  // 导入 Comment 模型类
use frontend\models\ToolComment; 


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
                'only' => ['logout', 'signup', 'dashboard'],  // 添加dashboard的访问控制
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],  // 只允许未登录用户访问signup页面
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],  // 只有已登录用户可以访问logout
                    ],
                    [
                        'actions' => ['dashboard'], // 只有登录用户可以访问dashboard
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
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * 推荐电影页面
     */
    public function actionRecommended()
    {
        Yii::info('Rendering recommended movies page', __METHOD__);  // 添加日志
    
        // 假设推荐数据来源于 CSV 文件，以下是读取 CSV 文件并获取推荐电影的过程
        $csvFile = Yii::getAlias('@frontend/web/data/sample.csv');
        $movies = [];
        
        if (($handle = fopen($csvFile, 'r')) !== false) {
            // 读取 CSV 文件的表头
            $headers = fgetcsv($handle);
        
            // 检查表头的列数
            $headerCount = count($headers);
        
            // 读取每一行数据
            while (($data = fgetcsv($handle)) !== false) {
                if (count($data) === $headerCount) {
                    $movies[] = array_combine($headers, $data);
                } else {
                    Yii::warning("Skipping row with mismatched column count: " . implode(", ", $data));
                }
            }
        
            fclose($handle);
        } else {
            Yii::warning("CSV file could not be opened: " . $csvFile);
        }
    
        // 按发行地区 (release_region) 对电影进行分类
        $movieRegions = [];
        foreach ($movies as $movie) {
            $regions = explode(',', $movie['release_region']);  // 假设发行地区是以逗号分隔的字符串
            foreach ($regions as $region) {
                $region = trim($region);  // 去除空格
                if (!isset($movieRegions[$region])) {
                    $movieRegions[$region] = [];
                }
                $movieRegions[$region][] = $movie;
            }
        }
        
        // 输出调试信息，确认数据是否正确
        Yii::info('Movie release regions: ' . print_r($movieRegions, true));
    
        // 获取所有发行地区的名称，用于下拉列表
        $regionsList = array_keys($movieRegions);
        
        // 渲染推荐页面视图并传递分类后的电影数据和区域名称列表
        return $this->render('recommended', [
            'movieRegions' => $movieRegions,
            'regionsList' => $regionsList,
            'movies' => $movies,
        ]);
    }
    

    /**
     * 热门电影页面
     */
    public function actionPopular()
    {
        $csvFile = Yii::getAlias('@frontend/web/data/sample.csv');
        $movies = [];
        
        if (($handle = fopen($csvFile, 'r')) !== false) {
            // 读取 CSV 文件的表头
            $headers = fgetcsv($handle);
        
            // 检查表头的列数
            $headerCount = count($headers);
        
            // 读取每一行数据
            while (($data = fgetcsv($handle)) !== false) {
                if (count($data) === $headerCount) {
                    $movies[] = array_combine($headers, $data);
                } else {
                    Yii::warning("Skipping row with mismatched column count: " . implode(", ", $data));
                }
            }
        
            fclose($handle);
        } else {
            Yii::warning("CSV file could not be opened: " . $csvFile);
        }
        
        // 按类型对电影进行分类
        $movieTypes = [];
        foreach ($movies as $movie) {
            $types = explode(',', $movie['types']);  // 假设类型是以逗号分隔的字符串
            foreach ($types as $type) {
                $type = trim($type);  // 去除空格
                if (!isset($movieTypes[$type])) {
                    $movieTypes[$type] = [];
                }
                $movieTypes[$type][] = $movie;
            }
        }
        
        // 输出调试信息，确认数据是否正确
        Yii::info('Movie types: ' . print_r($movieTypes, true));
        
        return $this->render('types', [
            'movieTypes' => $movieTypes,
            'movies' => $movies,
        ]);
    }
    
    

    /**
     * 电影论坛页面
     */
    public function actionForum()
    {
        // 使用 Query 查询数据库中的数据
        $tools = (new Query())
            ->select('*') // 查询所有字段
            ->from('all_ai_tool') // 表名
            ->all(); // 获取所有数据

        // 将数据传递给视图
        return $this->render('id', [
            'tools' => $tools,  // 将查询到的数据传递给视图
        ]);
    }
    

    /**
     * Dashboard page for logged-in users.
     *
     * @return mixed
     */
    public function actionDashboard()
    {
        return $this->render('dashboard');  // 渲染dashboard视图
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            $model->password = '';  // 清空密码字段，避免泄漏敏感信息

            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {   /*
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending your message.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }*/
        // 只在表单提交时处理
        // 只在表单提交时处理
        if (Yii::$app->user->isGuest) {
            Yii::$app->session->setFlash('error', 'You must be logged in to post a comment.');
            return $this->redirect(['site/login']);
        }

        if (Yii::$app->request->isPost) {
            $name = Yii::$app->request->post('name');
            $email = Yii::$app->request->post('email');
            $subject = Yii::$app->request->post('subject');
            $body = Yii::$app->request->post('body');
    
            // 打印日志查看是否接收到数据
            Yii::info("Received data: name=$name, email=$email, subject=$subject, body=$body", 'contactForm');
            $createdAt = date('Y-m-d H:i:s', time());
            try {
                // 生成 SQL 语句，记录日志
                $sql = Yii::$app->db->createCommand()
                    ->insert('contact_form_submissions', [
                        'user_id' => Yii::$app->user->id,
                        'name' => $name,
                        'email' => $email,
                        'subject' => $subject,
                        'body' => $body,
                        'created_at' => $createdAt,
                    ])
                    ->getSql();
                
                Yii::info("Generated SQL: " . $sql, 'contactForm');
                
                // 执行插入操作
                Yii::$app->db->createCommand()
                    ->insert('contact_form_submissions', [
                        'user_id' => Yii::$app->user->isGuest ? null : Yii::$app->user->id,
                        'name' => $name,
                        'email' => $email,
                        'subject' => $subject,
                        'body' => $body,
                        'created_at' => $createdAt,
                    ])
                    ->execute();
                
                // 返回成功响应
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ['success' => true];
            } catch (\Exception $e) {
                // 捕获异常，记录详细错误信息
                Yii::error("Database error: " . $e->getMessage(), 'contactForm');
                Yii::error("Stack trace: " . $e->getTraceAsString(), 'contactForm');
                
                // 返回具体错误信息
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ['success' => false, 'message' => 'An error occurred: ' . $e->getMessage()];
            }
        }
        return $this->render('contact');
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');  // 渲染about页面
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
            Yii::$app->session->setFlash('success', 'Thank you for registration. Please check your inbox for verification email.');
            return $this->goHome();
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');
                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');
            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    /**
     * Verify email address.
     *
     * @param string $token
     * @throws BadRequestHttpException
     * @return yii\web\Response
     */
    public function actionVerifyEmail($token)
    {
        try {
            $model = new VerifyEmailForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
        if ($user = $model->verifyEmail()) {
            if (Yii::$app->user->login($user)) {
                Yii::$app->session->setFlash('success', 'Your email has been confirmed!');
                return $this->goHome();
            }
        }

        Yii::$app->session->setFlash('error', 'Sorry, we are unable to verify your account with the provided token.');
        return $this->goHome();
    }

    /**
     * Resend verification email.
     *
     * @return mixed
     */
    public function actionResendVerificationEmail()
    {
        $model = new ResendVerificationEmailForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');
                return $this->goHome();
            }
            Yii::$app->session->setFlash('error', 'Sorry, we are unable to resend the verification email for the provided email address.');
        }

        return $this->render('resendVerificationEmail', [
            'model' => $model,
        ]);
    }


    public function actionComment($paper_id)
    {
        // 从数据库获取论文信息
        $paper = Yii::$app->db->createCommand('SELECT * FROM arxiv_papers WHERE id = :id')
        ->bindValue(':id', $paper_id)
        ->queryOne();

        if (!$paper) {
            throw new \yii\web\NotFoundHttpException('Paper not found.');
        }

        // 使用 Comment 模型获取与该论文相关的评论
        $comments = Comment::find()->where(['paper_id' => $paper_id])->all();

        // 创建一个新的 Comment 模型用于表单
        $commentModel = new Comment();

        // 渲染评论页面，并传递论文和评论数据
        return $this->render('comment', [
            'paper' => $paper,         // 传递论文详细信息
            'comments' => $comments,  // 评论数据
            'commentModel' => $commentModel,  // 评论模型
        ]);


        /*
        // 获取电影信息
        $movie = null;
        $csvFile = Yii::getAlias('@frontend/web/data/sample.csv');
        $movies = [];

        if (($handle = fopen($csvFile, 'r')) !== false) {
            $headers = fgetcsv($handle);
            while (($data = fgetcsv($handle)) !== false) {
                $movie = array_combine($headers, $data);
                if ($movie['douban_id'] == $douban_id) {
                    break;
                }
                $movies[] = $movie;
            }
            fclose($handle);
        }

        if (!$movie) {
            throw new \yii\web\NotFoundHttpException('Movie not found.');
        }

        // 获取与该电影相关的评论
        $comments = Comment::find()->where(['movie_id' => $movie['douban_id']])->all();

        // 创建一个新的 Comment 模型用于表单
        $commentModel = new Comment();

        // 渲染评论页面，并传递电影信息
        return $this->render('comment', [
            'movie' => $movie,  // 传递电影的详细信息
            'comments' => $comments,  // 评论数据
            'commentModel' => $commentModel,  // 评论模型
        ]);
        */
    }

    public function actionAddComment()
    {
        
        // 检查用户是否登录
        if (Yii::$app->user->isGuest) {
            Yii::$app->session->setFlash('error', 'You must be logged in to post a comment.');
            return $this->redirect(['site/login']);  // 如果未登录，重定向到登录页面
        }

        $comment = new Comment();

        // 加载表单数据到 Comment 模型
        if ($comment->load(Yii::$app->request->post())) {

            // 检查 paper_id 是否有效
            $paper = Yii::$app->db->createCommand('SELECT * FROM arxiv_papers WHERE id = :id')
            ->bindValue(':id', $comment->paper_id)
            ->queryOne();

            if (!$paper) {
                Yii::$app->session->setFlash('error', 'Invalid paper ID.');
                return $this->redirect(['site/comment', 'paper_id' => $comment->paper_id]);
            }

            
            // 设置评论的创建时间（当前时间戳）
            $comment->created_at = time();
            
            // 获取当前登录用户的 ID 和用户名
            $comment->user_id = Yii::$app->user->id;  // 当前用户的 ID
            
            // 保存评论
            if ($comment->save()) {
                
                if (Yii::$app->request->isAjax) {
                    return $this->asJson(['success' => true]);
                }
                Yii::$app->session->setFlash('success', 'Comment added successfully.');

            } else {
                
            
                //Yii::error('Error saving comment: ' . json_encode($comment->errors), __METHOD__);
                if (Yii::$app->request->isAjax) {
                    return $this->asJson(['success' => false]);
                }
                Yii::$app->session->setFlash('error', 'Failed to add comment.');
                
            }

            
        }

        // 重定向回电影评论页面
        //return $this->redirect(['site/comment', 'douban_id' => $movie_id]);
        // 如果表单未提交或加载失败，重新渲染页面
        return $this->render('comment');
    }

    // public function actionGetCountryData()
    // {
    //     $year = Yii::$app->request->get('year');
    //     if ($year) {
    //         $command = Yii::$app->db->createCommand('SELECT * FROM country_rank WHERE year = :year');
    //         $data = $command->bindValue(':year', $year)->queryAll();
    //         return json_encode($data);
    //     }
    //     return json_encode([]);
    // }
    // public function actionGetCountryData()
    // {
    //     $year = Yii::$app->request->get('year');
    //     $attribute = Yii::$app->request->get('attribute');
    
    //     if (!$year || !$attribute) {
    //         return json_encode([]);
    //     }
    
    //     $data = (new Query())
    //         ->select(['region', 'documents', 'citable_documents', 'citations', 'self_citations', 'citations_per_document', 'h_index'])
    //         ->from('country_rank')
    //         ->where(['year' => $year])
    //         ->all();
    
    //     // 将数据返回给前端
    //     return json_encode($data);
    // }
    public function actionGetCountryData()
    {
        $year = Yii::$app->request->get('year');

        if (!$year) {
            return json_encode([]);
        }

        $data = (new Query())
            ->select(['region', 'documents', 'citable_documents', 'citations', 'self_citations', 'citations_per_document', 'h_index'])
            ->from('country_rank')
            ->where(['year' => $year])
            ->all();

        return json_encode($data);
    }

    

    public function actionToolcomment($tool_name)
    {
        // 获取工具详情
        $tool = Yii::$app->db->createCommand('SELECT * FROM all_ai_tool WHERE `AI Tool Name` = :tool_name')
        ->bindValue(':tool_name', $tool_name)
        ->queryOne();

        if (!$tool) {
            throw new \yii\web\NotFoundHttpException('Tool not found.');
        }

        // 获取与该工具相关的评论
        $comments = ToolComment::find()->where(['tool_name' => $tool_name])->all();

        // 创建一个新的评论模型用于表单
        $commentModel = new ToolComment();

        return $this->render('toolcomment', [
            'tool' => $tool,
            'comments' => $comments,
            'commentModel' => $commentModel,
        ]);
    }

    public function actionAddToolComment()
    {
        if (Yii::$app->user->isGuest) {
            Yii::$app->session->setFlash('error', 'You must be logged in to post a comment.');
            return $this->redirect(['site/login']);
        }

        $comment = new ToolComment();

        if ($comment->load(Yii::$app->request->post())) {
            $comment->user_id = Yii::$app->user->id;
            $comment->created_at = time();

            // 保存评论
            if ($comment->save()) {
                
                if (Yii::$app->request->isAjax) {
                    return $this->asJson(['success' => true]);
                }
                Yii::$app->session->setFlash('success', 'Comment added successfully.');

            } else {
                
            
                //Yii::error('Error saving comment: ' . json_encode($comment->errors), __METHOD__);
                if (Yii::$app->request->isAjax) {
                    return $this->asJson(['success' => false]);
                }
                Yii::$app->session->setFlash('error', 'Failed to add comment.');
                
            }
        }

        return $this->render('toolcomment');
    }
    // controllers/SiteController.php

    public function actionArxiv()
    {
        // 获取数据库连接
        $connection = Yii::$app->db;

        // 获取用户输入的日期
        $searchDate = Yii::$app->request->get('date', '');

        // 根据日期查询 arxiv_papers 表
        if ($searchDate) {
            $arxivPapers = $connection->createCommand('SELECT * FROM arxiv_papers WHERE published = :date')
                ->bindValue(':date', $searchDate)
                ->queryAll();
        } else {
            $arxivPapers = $connection->createCommand('SELECT * FROM arxiv_papers')->queryAll();
        }

        // 如果没有找到数据，抛出 404 错误
        if (empty($arxivPapers)) {
            throw new \yii\web\HttpException(404, 'No papers found for the selected date.');
        }

        // 渲染视图
        return $this->render('arxiv', [
            'arxivPapers' => $arxivPapers,
            'searchDate' => $searchDate,
        ]);
    }
    // public function actionAiTool()
    // {
    //     // 获取选择的工具状态
    //     $toolStatus = Yii::$app->request->get('tool_status');
        
    //     // 查询工具
    //     $toolsQuery = Tool::find();  // 使用你实际的工具模型类
        
    //     if ($toolStatus) {
    //         $toolsQuery->andWhere(['Free/Paid/Other' => $toolStatus]);
    //     }
    
    //     $tools = $toolsQuery->all();
    
    //     return $this->render('ai_tool', [
    //         'tools' => $tools,
    //     ]);
    // }

    public function actionAiTool()
    {
        // 获取数据库连接
        $connection = Yii::$app->db;
    
        // 获取用户选择的工具状态
        $toolStatus = Yii::$app->request->get('tool_status', '');
    
        // 查询数据库
        $query = "SELECT * FROM all_ai_tool";
        $params = [];
    
        if ($toolStatus) {
            $query .= " WHERE `Free/Paid/Other` = :tool_status";
            $params[':tool_status'] = $toolStatus;
        }
    
        try {
            $tools = $connection->createCommand($query, $params)->queryAll();
    
            if (empty($tools)) {
                throw new \yii\web\HttpException(404, 'No tools found for the selected status.');
            }
    
            return $this->render('ai-tool', [
                'tools' => $tools,
            ]);
        } catch (\Exception $e) {
            throw new \yii\web\HttpException(500, 'An internal error occurred.');
        }
    }
    
    
    
    public function actionLike()
    {
        if (Yii::$app->user->isGuest) {
            Yii::$app->session->setFlash('error', 'You must be logged in to post a comment.');
            return $this->redirect(['site/login']);
        }
        
        $userId = Yii::$app->user->id;  // 获取当前用户 ID
        $toolName = Yii::$app->request->post('tool_name');  // 获取工具名称

        if (!$userId || !$toolName) {
            return $this->asJson(['success' => false, 'message' => 'User ID or Tool Name is missing.']);
        }

        

        try {
            // 插入点赞记录到数据库
            Yii::$app->db->createCommand()->insert('tool_likes', [
                'user_id' => $userId,
                'tool_name' => $toolName,
                'created_at' => time(),  // 当前时间
            ])->execute();

            // 获取更新后的点赞数
            $likesCount = Yii::$app->db->createCommand('SELECT COUNT(*) FROM tool_likes WHERE tool_name = :tool_name', [':tool_name' => $toolName])->queryScalar();

            // 返回点赞数
            return $this->asJson([
                'success' => true,
                'likes_count' => $likesCount,  // 返回更新后的点赞数
            ]);
        } catch (\Exception $e) {
            return $this->asJson(['success' => false, 'message' => 'You have liked this tool!']);
        }
    }

    public function actionLikePaper()
    {
        

        if (Yii::$app->user->isGuest) {
            Yii::$app->session->setFlash('error', 'You must be logged in to post a comment.');
            return $this->redirect(['site/login']);
        }

        $userId = Yii::$app->user->id;  // 获取当前用户 ID
        $paperId = Yii::$app->request->post('paper_id');  // 获取论文 ID

        // 检查用户ID和论文ID是否有效
        if (!$userId || !$paperId) {
            return $this->asJson(['success' => false, 'message' => 'User ID or Paper ID is missing.']);
        }

        try {
            // 插入点赞记录到数据库
            Yii::$app->db->createCommand()->insert('paper_likes', [
                'user_id' => $userId,
                'paper_id' => $paperId,
                'created_at' => new \yii\db\Expression('NOW()'),  // 当前时间
            ])->execute();
            
            Yii::info("Inserted like record for Paper ID: $paperId, User ID: $userId", __METHOD__);

            // 获取更新后的点赞数
            $likesCount = Yii::$app->db->createCommand('SELECT COUNT(*) FROM paper_likes WHERE paper_id = :paper_id', [':paper_id' => $paperId])->queryScalar();

            Yii::info("Likes count for Paper ID: $paperId updated to: $likesCount", __METHOD__);

            // 获取更新后的点赞数
            //$likesCount = Yii::$app->db->createCommand('SELECT COUNT(*) FROM paper_likes WHERE paper_id = :paper_id', [':paper_id' => $paperId])->queryScalar();

            // 返回点赞数
            return $this->asJson([
                'success' => true,
                'likes_count' => $likesCount,  // 返回更新后的点赞数
            ]);
        } catch (\Exception $e) {
            Yii::error("Error occurred while liking paper $paperId: " . $e->getMessage(), __METHOD__);
            return $this->asJson(['success' => false, 'message' => 'You have liked this paper!']);
        }
    }
    public function actionVideos()
   {
     // 禁用 main.php 布局
     //$this->layout = false;
       // 渲染 video.php 视图文件
       //return $this->render('videos');
 // 视频列表：文件路径存放在 web/videos 目录下
 $videos = [
    Yii::getAlias('@web') . '/videos/video1.mp4',
    Yii::getAlias('@web') . '/videos/video2.mp4',
    Yii::getAlias('@web') . '/videos/video3.mp4',
    Yii::getAlias('@web') . '/videos/video4.mp4',
    Yii::getAlias('@web') . '/videos/video5.mp4',
    Yii::getAlias('@web') . '/videos/video6.mp4',
];

// 获取当前视频索引，默认为 0
$currentIndex = Yii::$app->request->get('index', 0);
$currentIndex = (int)$currentIndex; // 确保为整数
$totalVideos = count($videos);

// 计算上下一个视频的索引
$prevIndex = ($currentIndex - 1 + $totalVideos) % $totalVideos; // 循环回退
$nextIndex = ($currentIndex + 1) % $totalVideos; // 循环前进

// 当前视频和上下视频
$currentVideo = $videos[$currentIndex];
$prevVideo = $videos[$prevIndex];
$nextVideo = $videos[$nextIndex];

// 将数据传递给视图
return $this->render('videos', [
    'currentVideo' => $currentVideo,
    'prevVideo' => $prevVideo,
    'nextVideo' => $nextVideo,
    'prevIndex' => $prevIndex,
    'nextIndex' => $nextIndex,
]); 
  }    

}

