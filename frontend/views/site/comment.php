<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
$this->registerCssFile("https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css");  // 引入 jQuery UI 样式
$this->registerJsFile("https://code.jquery.com/jquery-3.6.0.min.js", ['depends' => [\yii\web\JqueryAsset::class]]);  // 引入 jQuery
$this->registerJsFile("https://code.jquery.com/ui/1.12.1/jquery-ui.min.js", ['depends' => [\yii\web\JqueryAsset::class]]);  // 引入 jQuery UI JS

?>

<h1><?= Html::encode($movie['title']) ?></h1>
<p><strong>Directors:</strong> <?= Html::encode($movie['directors']) ?></p>
<p><strong>Actors:</strong> <?= Html::encode($movie['actors']) ?></p>
<p><strong>Release Region:</strong> <?= Html::encode($movie['release_region']) ?></p>
<p><strong>Score:</strong> <?= Html::encode($movie['score']) ?></p>
<p><strong>Description:</strong> <?= Html::encode($movie['description']) ?></p>

<h2>Comments</h2>
<ul>
    <?php if (!empty($comments)): ?>
        <?php foreach ($comments as $comment): ?>
            <li><strong><?= Html::encode($comment->user->username) ?>:</strong> <?= Html::encode($comment->content) ?></li>
        <?php endforeach; ?>
    <?php else: ?>
        <li>No comments yet.</li> <!-- 如果没有评论，显示提示信息 -->
    <?php endif; ?>
</ul>


<h3>Leave a Comment</h3>

<?php $form = ActiveForm::begin([
    'id' => 'comment-form',
    'action' => ['site/add-comment'],
    'enableAjaxValidation' => false, // 不启用AJAX验证
    'options' => ['data-pjax' => 1, 'class' => 'form-horizontal'], // 启用 PJAX
]); ?>

<!-- 隐藏电影ID，确保评论与电影关联 -->
<?= Html::hiddenInput('Comment[movie_id]', $movie['douban_id']) ?>

<?= $form->field($commentModel, 'content')->textarea(['rows' => 4, 'placeholder' => 'Write your comment here...']) ?>

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