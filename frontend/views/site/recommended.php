<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\db\Command; // 添加 yii\db 命名空间以便执行数据库查询

// 连接数据库
$connection = Yii::$app->db;  // 使用 Yii 框架自带的数据库连接

// 查询 arxiv_papers 表中的所有论文
$arxivPapers = $connection->createCommand('SELECT * FROM arxiv_papers')->queryAll();

$this->registerCssFile('@web/css/style.css');  // 引入样式文件
?>

<h1>Arxiv Papers</h1>

<!-- 显示所有论文 -->
<?php if ($arxivPapers): ?>
    <div class="row">
        <?php foreach ($arxivPapers as $paper): ?>
            <div class="col-lg-3">
                <div class="paper-box">
                    <p><strong>Title:</strong> <?= Html::encode($paper['title']) ?></p>
                    <p><strong>Abstract:</strong> <?= Html::encode($paper['abstract']) ?></p>
                    <p><strong>Published Date:</strong> <?= Html::encode($paper['published']) ?></p>
                    <p><strong>Authors:</strong> <?= Html::encode($paper['authors']) ?></p>
                    <p><strong>URL:</strong> <a href="<?= Html::encode($paper['url']) ?>" target="_blank"><?= Html::encode($paper['url']) ?></a></p>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php else: ?>
    <p>No papers available.</p>
<?php endif; ?>

<?php
// 添加样式来调整论文显示页面的布局
$this->registerCss('
    .paper-box {
        padding: 15px;
        border: 1px solid #ddd;
        border-radius: 5px;
        margin-bottom: 20px;
        background-color: #f9f9f9;
    }
    .paper-box p {
        margin: 5px 0;
    }
    .row {
        margin-top: 60px; /* 给固定导航条留出空间 */
    }
');
?>
