<?php
/**
 * Team:LOVEYII,NKU
 * coding by 高玉格 2213925,20241218 庞艾语2211581
 * This is the main layout of frontend web.
 */
use yii\helpers\Html;
use yii\widgets\ActiveForm;
$this->registerCssFile("https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css");  // 引入 jQuery UI 样式
$this->registerJsFile("https://code.jquery.com/jquery-3.6.0.min.js", ['depends' => [\yii\web\JqueryAsset::class]]);  // 引入 jQuery
$this->registerJsFile("https://code.jquery.com/ui/1.12.1/jquery-ui.min.js", ['depends' => [\yii\web\JqueryAsset::class]]);  // 引入 jQuery UI JS

?>



<h1>Paper Details</h1>
<!-- 展示论文详情 -->
<p><strong>Title:</strong> <?= Html::encode($paper['title']) ?></p>
<p><strong>Abstract:</strong> <?= Html::encode($paper['abstract']) ?></p>
<p><strong>Published:</strong> <?= Html::encode($paper['published']) ?></p>
<p><strong>Authors:</strong> <?= Html::encode($paper['authors']) ?></p>
<p><strong>URL:</strong> <a href="<?= Html::encode($paper['url']) ?>" target="_blank"><?= Html::encode($paper['url']) ?></a></p>

<hr>

<h2>Comments</h2>
<!-- 评论区 -->
<?php if (!empty($comments)): ?>
    <?php foreach ($comments as $comment): ?>
        <div class="comment-box" style="background-color: rgba(249, 249, 249, 0.8);">
            <p><strong>User:</strong> <?= Html::encode($comment->user->username) ?></p>
            <p><strong>Comment:</strong> <?= Html::encode($comment->content) ?></p>
            <p><strong>Posted at:</strong> <?= date('Y-m-d H:i:s', $comment->created_at) ?></p>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <p>No comments yet.</p>
<?php endif; ?>

<hr>
<h2>Like this tool</h2>
<?php
// 获取当前工具名称
$paperId = $paper['id'];

// 获取点赞数
$likesCount = Yii::$app->db->createCommand('SELECT COUNT(*) FROM paper_likes WHERE paper_id = :paper_id', [':paper_id' => $paperId])->queryScalar();

// 获取点踩数
$dislikesCount = Yii::$app->db->createCommand('SELECT COUNT(*) FROM paper_dislikes WHERE paper_id = :paper_id', [':paper_id' => $paperId])->queryScalar();
?>

<p><strong>Likes:</strong> <span id="like-count"><?= $likesCount ?></span></p>
<p><strong>Dislikes:</strong> <span id="dislike-count"><?= $dislikesCount ?></span></p>

<!-- 点赞按钮 -->
<button id="like-button" class="btn btn-success">Like</button>
<!-- 点踩按钮 -->
<button id="dislike-button" class="btn btn-primary">Dislike</button>
<hr>

<h2>Post a Comment</h2>
<?php $form = ActiveForm::begin([
    'id' => 'comment-form',
    'action' => ['site/add-comment'],
    'enableAjaxValidation' => false, // 不启用AJAX验证
    'options' => ['data-pjax' => 1, 'class' => 'form-horizontal'], // 启用 PJAX
]); ?>

<!-- 隐藏论文 ID，确保评论与论文关联 -->
<?= Html::hiddenInput('Comment[paper_id]', $paper['id']) ?>

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
    <div>Your comment has been successfully posted!</div>
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

    $(document).ready(function(){
        // 点赞操作
        $('#like-button').on('click', function() {
            var paperId = '$paperId';  // 获取当前论文 ID
            
            // 发送点赞请求到后端
            $.ajax({
                url: '/site/like-paper',  // 后端点赞接口
                type: 'POST',
                data: { paper_id: paperId },
                success: function(response) {
                    if (response.success) {
                        if (response.message === 'Like added.') {
                            alert('Thank you for your like!');
                            $('#like-button').addClass('liked');  // 添加点赞样式
                        } else if (response.message === 'Like removed.') {
                            alert('The like has been canceled.');
                            $('#like-button').removeClass('liked');  // 移除点赞样式
                        }
                        // 更新点赞数
                        $('#like-count').text(response.likes_count);
                    } else {
                        alert(response.message);  // 点赞失败的提示
                    }
                },
                error: function() {
                    alert('Error occurred while liking the paper.');
                }
            });
        });

        // 点踩操作
        $('#dislike-button').on('click', function() {
            var paperId = '$paperId';  // 获取当前论文 ID
            
            // 发送点踩请求到后端
            $.ajax({
                url: '/site/dislike-paper',  // 后端点踩接口
                type: 'POST',
                data: { paper_id: paperId },
                success: function(response) {
                    if (response.success) {
                        if (response.message === 'Dislike added.') {
                            alert('You have disliked this paper.');
                            $('#dislike-button').addClass('disliked');  // 添加点踩样式
                        } else if (response.message === 'Dislike removed.') {
                            alert('The dislike has been canceled.');
                            $('#dislike-button').removeClass('disliked');  // 移除点踩样式
                        }
                        // 更新点踩数
                        $('#dislike-count').text(response.dislikes_count);
                    } else {
                        alert(response.message);  // 点踩失败的提示
                    }
                },
                error: function() {
                    alert('Error occurred while disliking the paper.');
                }
            });
        });
    });
JS;
$this->registerJs($script);

?>

<?php
$this->registerCss('
    /* 设置背景图片 */
    body {
        background-image: url("' . Yii::getAlias('@web/images/background.jpg') . '");
        background-size: cover; /* 背景图像覆盖整个页面 */
        background-attachment: fixed; /* 背景固定不滚动 */
        background-position: center; /* 背景居中 */
        background-repeat: no-repeat; /* 不重复背景图片 */
        color: rgba(255, 255, 255, 0.9); /* 设置稍微透明的白色文字 */
    }

    .comment-box {
        background-color: rgba(255, 255, 255, 0.3); /* 评论框背景色和透明度 */
        border-left: 5px solid #ddd;                  /* 左侧边框 */
        padding: 15px;                                /* 内边距 */
        margin-bottom: 15px;                          /* 下边距 */
        border-radius: 5px;                           /* 圆角 */
    }

    #like-button {
        background-color: transparent; /* 设置按钮背景为透明 */
        border: 2px solid white;  /* 设置白色边框 */
        padding: 10px 20px;  /* 增加内边距 */
        font-size: 16px;  /* 设置字体大小 */
        cursor: pointer;  /* 鼠标悬停时显示手形光标 */
        border-radius: 25px;  /* 设置圆角效果 */
        transition: all 0.3s ease;  /* 设置平滑过渡效果 */
        outline: none;  /* 去除点击后的边框 */
        color: white;  /* 设置文字颜色为白色 */
    }

    #like-button.liked {
        background-color: #ff69b4; /* 点赞后的背景色为粉色 */
        border-color: #ff69b4; /* 点赞后边框变成粉色 */
        color: white;  /* 保持文字为白色 */
    }
    
    #like-button:hover {
        background-color: rgba(255, 255, 255, 0.1); /* 鼠标悬停时，背景变为半透明白色 */
        transform: scale(1.05);  /* 鼠标悬停时，按钮稍微变大 */
    }

    #like-button:active {
        transform: scale(0.98);  /* 鼠标按下时，按钮稍微缩小 */
    }

    #dislike-button {
        background-color: transparent; /* 设置按钮背景为透明 */
        border: 2px solid blue;  /* 设置蓝色边框 */
        padding: 10px 20px;  /* 增加内边距 */
        font-size: 16px;  /* 设置字体大小 */
        cursor: pointer;  /* 鼠标悬停时显示手形光标 */
        border-radius: 25px;  /* 设置圆角效果 */
        transition: all 0.3s ease;  /* 设置平滑过渡效果 */
        outline: none;  /* 去除点击后的边框 */
        color: blue;  /* 设置文字颜色为蓝色 */
    }

    #dislike-button.disliked {
        background-color: blue; /* 点踩后的背景色为蓝色 */
        border-color: blue; /* 点踩后边框变成蓝色 */
        color: white;  /* 保持文字为白色 */
    }
    
    #dislike-button:hover {
        background-color: rgba(0, 0, 255, 0.1); /* 鼠标悬停时，背景变为半透明蓝色 */
        transform: scale(1.05);  /* 鼠标悬停时，按钮稍微变大 */
    }

    #dislike-button:active {
        transform: scale(0.98);  /* 鼠标按下时，按钮稍微缩小 */
    }

    p {
        font-size: 16px;  /* 设置整个页面所有 p 标签的字体大小 */
        line-height: 1.6; /* 设置行高，增加文本的可读性 */
        color: rgba(255, 255, 255, 0.9); /* 设置字体颜色为稍透明的白色 */
    }
    
    /* 修改评论输入框的外观 */
    #comment-form textarea {
        width: 100%;  /* 让输入框填满容器 */
        height: 120px;  /* 设置高度 */
        padding: 10px;  /* 内边距 */
        border: 1px solid #ddd;  /* 边框 */
        border-radius: 8px;  /* 圆角效果 */
        background-color: rgba(255, 255, 255, 0.3);  /* 背景颜色和透明度 */
        color: white;  /* 字体颜色 */
        font-size: 16px;  /* 字体大小 */
        resize: vertical;  /* 允许上下调整大小 */
        box-sizing: border-box;  /* 包括内边距在内的总宽度 */
    }

    /* 提示文字的颜色 */
    #comment-form textarea::placeholder {
        color: #aaa;  /* 设置提示文字颜色 */
        font-style: italic;  /* 设置提示文字为斜体 */
    }

    /* 设置提交按钮样式 */
    .form-group button {
        background: linear-gradient(145deg, #3a8fd5, #0077cc); /* 渐变蓝色背景 */
        color: white;  /* 按钮文字颜色 */
        border: none;  /* 去掉按钮边框 */
        padding: 12px 25px;  /* 内边距，适当增加按钮的大小 */
        border-radius: 30px;  /* 圆角效果，增加现代感 */
        font-size: 18px;  /* 字体大小，稍微加大字形 */
        cursor: pointer;  /* 鼠标悬停时显示手形光标 */
        font-weight: 600;  /* 加粗文字，增加可读性 */
        text-transform: uppercase;  /* 按钮文字大写，增加视觉冲击力 */
        box-shadow: 3px 3px 6px rgba(0, 0, 0, 0.2), inset 1px 1px 3px rgba(255, 255, 255, 0.3);  /* 增加外部阴影和内阴影 */
        transition: all 0.3s ease; /* 按钮的过渡效果，平滑过渡所有变化 */
        outline: none;  /* 去掉点击后的边框 */
    }

    .form-group button:hover {
        background: linear-gradient(145deg, #0077cc, #3a8fd5); /* 悬停时背景色反转 */
        transform: translateY(-3px); /* 悬停时稍微上移 */
        box-shadow: 3px 6px 15px rgba(0, 0, 0, 0.25);  /* 悬停时增加更强的阴影 */
    }

    .ui-dialog-titlebar-close {
        background-color: transparent !important; /* 背景透明 */
        color: transparent !important;                  /* 设置关闭按钮字体颜色 */
        border: none !important; 
    }

    #successDialog div {
        font-size: 16px;      /* 设置字体大小 */
        color: #333;          /* 设置文字颜色为深灰色 */
    }
');
?>