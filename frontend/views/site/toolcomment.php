<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\db\Command; // 添加 yii\db 命名空间以便执行数据库查询
$this->registerCssFile("https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css");  // 引入 jQuery UI 样式
$this->registerJsFile("https://code.jquery.com/jquery-3.6.0.min.js", ['depends' => [\yii\web\JqueryAsset::class]]);  // 引入 jQuery
$this->registerJsFile("https://code.jquery.com/ui/1.12.1/jquery-ui.min.js", ['depends' => [\yii\web\JqueryAsset::class]]);  // 引入 jQuery UI JS



?>
<h1>Tool Details</h1>
<!-- 展示工具详情 -->
<p><strong>Name:</strong> <?= Html::encode($tool['AI Tool Name']) ?></p>
<p><strong>Description:</strong> <?= Html::encode($tool['Description']) ?></p>
<p><strong>Free/Paid/Other:</strong> <?= Html::encode($tool['Free/Paid/Other']) ?></p>
<p><strong>Usable For:</strong> <?= Html::encode($tool['Useable For']) ?></p>
<p><strong>Charges:</strong> <?= Html::encode($tool['Charges']) ? Html::encode($tool['Charges']) : 'Free' ?></p>
<p><strong>Review:</strong> <?= Html::encode($tool['Review']) ? Html::encode($tool['Review']) : 'No reviews yet' ?></p>
<p><strong>Tool Link:</strong> <a href="<?= Html::encode($tool['Tool Link']) ?>" target="_blank"><?= Html::encode($tool['Tool Link']) ?></a></p>
<p><strong>Major Category:</strong> <?= Html::encode($tool['Major Category']) ?></p>

<hr>

<h2>Comments</h2>
<!-- 评论区 -->
<?php if (!empty($comments)): ?>
    <?php foreach ($comments as $comment): ?>
        <div class="comment-box">
            <p><strong>User:</strong> <?= Html::encode($comment->user->username) ?></p>
            <p><strong>Comment:</strong> <?= Html::encode($comment->content) ?></p>
            <p><strong>Posted at:</strong> <?= date('Y-m-d H:i:s', $comment->created_at) ?></p>
        </div>
        <hr>
    <?php endforeach; ?>
<?php else: ?>
    <p>No comments yet.</p>
<?php endif; ?>

<hr>

<h2>Post a Comment</h2>
<?php $form = ActiveForm::begin([
    'id' => 'comment-form',
    'action' => ['site/add-tool-comment'],
    'enableAjaxValidation' => false, // 不启用AJAX验证
    'options' => ['data-pjax' => 1, 'class' => 'form-horizontal'], // 启用 PJAX
]); ?>

<!-- 隐藏工具名称，确保评论与工具关联 -->
<?= Html::hiddenInput('ToolComment[tool_name]', $tool['AI Tool Name']) ?>

<?= $form->field($commentModel, 'content')->textarea([
    'rows' => 4,
    'placeholder' => 'Write your comment here...'
])->label(false) ?>

<div class="form-group">
    <?= Html::submitButton('Post Comment', ['class' => 'btn btn-primary', 'id' => 'submit-button']) ?>
</div>

<?php ActiveForm::end(); ?>







<!-- 弹窗反馈 -->
<div id="successDialog" title="Success" style="display:none;">
    <p>Your comment has been successfully posted!</p>
</div>

<?php
// 在JavaScript中显示弹窗
$script = <<<JS
    // 初始化 dialog 插件
    $('#successDialog').dialog({
        autoOpen: false,  // 确保初始化时不自动打开
        modal: true,      // 使用模态窗口，阻止其他操作
        buttons: {
            'OK': function() {
                $(this).dialog('close');
                location.reload();  // 页面刷新
            }
        }
    });

    $('#comment-form').on('beforeSubmit', function(e) {
        e.preventDefault(); // 阻止默认提交
        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                // 处理响应，例如弹窗反馈
                if (response.success) {
                    $('#successDialog').dialog('open');  // 调用 open 打开对话框
                } else {
                    alert('Failed to post comment.');
                }
            },
            error: function() {
                alert('Error occurred while posting the comment.');
            }
        });
        return false;
    });
JS;
$this->registerJs($script);
?>

<?php
$this->registerCss('
    .ui-dialog-titlebar-close {
        background-color: transparent !important; /* 背景透明 */
        color: transparent !important;                  /* 设置关闭按钮字体颜色 */
        border: none !important; 
    }
');
?>
