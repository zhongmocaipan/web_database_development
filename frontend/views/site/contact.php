<?php

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model frontend\models\ContactForm */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Contact';
$this->params['breadcrumbs'][] = $this->title;
$this->registerCssFile("https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css");  // 引入 jQuery UI 样式
$this->registerJsFile("https://code.jquery.com/jquery-3.6.0.min.js", ['depends' => [\yii\web\JqueryAsset::class]]);  // 引入 jQuery
$this->registerJsFile("https://code.jquery.com/ui/1.12.1/jquery-ui.min.js", ['depends' => [\yii\web\JqueryAsset::class]]);  // 引入 jQuery UI JS

?>

<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        height: 100vh;
        margin: 0;
        overflow: hidden;
        position: relative;
    }

    /* 背景图片轮播 */
    .background-slideshow {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: -1;
        overflow: hidden;
    }

    .background-slideshow img {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        opacity: 0;
        transition: opacity 1s ease-in-out;
        z-index: -1;
    }

    .background-slideshow img.active {
        opacity: 1;
        z-index: 0;
    }

    .site-contact {
        position: relative;
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 2;
        height: 100%;
        text-align: center;
        padding: 20px;
    }

    .contact-container {
        background-color: rgba(255, 255, 255, 0.9);
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
        max-width: 600px;
        width: 100%;
        text-align: center;
    }

    .contact-container h1 {
        font-size: 24px;
        color: #4e73df;
        margin-bottom: 20px;
    }

    .contact-container p {
        font-size: 16px;
        color: #333;
        margin-bottom: 20px;
    }

    .form-group label {
        font-size: 14px;
        color: #4e73df;
        font-weight: bold;
    }

    .form-control {
        margin-bottom: 15px;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 5px;
        font-size: 14px;
    }

    .btn-primary {
        background-color: #4e73df;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        font-size: 14px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .btn-primary:hover {
        background-color: #3b5ebf;
    }
</style>

<h1>Contact Form</h1>

<!-- Contact Form -->
<?php $form = ActiveForm::begin([
    'id' => 'contact-form',
    'action' => ['site/contact'], // 表单提交到后台的接口
    'enableAjaxValidation' => false, // 不启用AJAX验证
    'options' => ['data-pjax' => 1, 'class' => 'form-horizontal'], // 启用 PJAX
]); ?>

<!-- 表单字段 -->
<?= Html::textInput('name', '', ['placeholder' => 'Your Name', 'class' => 'form-control']) ?>
<?= Html::textInput('email', '', ['placeholder' => 'Your Email', 'class' => 'form-control']) ?>
<?= Html::textInput('subject', '', ['placeholder' => 'Subject', 'class' => 'form-control']) ?>
<?= Html::textarea('body', '', ['rows' => 6, 'placeholder' => 'Your Message', 'class' => 'form-control']) ?>

<div class="form-group">
    <?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'id' => 'submit-button']) ?>
</div>

<?php ActiveForm::end(); ?>


<!-- 弹窗反馈 -->
<div id="successDialog" title="Success" style="display:none;">
    <div>Thank you for your valuable feedback!</div>
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

    $('#contact-form').on('beforeSubmit', function(e) {
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
                    alert('Failed to submit the form.');
                }
            },
            error: function() {
                alert('Error occurred while submitting the form.');
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
    
    /* 弹窗背景、阴影和圆角 */
    .ui-dialog.ui-widget-content {
        background-color: white !important;  /* 背景色为白色 */
        border-radius: 15px !important;  /* 增加圆角 */
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1) !important; /* 细腻的阴影效果 */
        padding: none !important;  /* 内边距增大，防止内容紧贴边框 */
        border: none !important;  /* 去掉边框 */
    }

    /* 弹窗标题栏背景和文本样式 */
    .ui-dialog-titlebar {
        background: linear-gradient(145deg, #81c7e0, #5fa8d3) !important;  /* 淡蓝色渐变背景 */
        color: white !important;  /* 文字颜色 */
        font-size: 20px !important;  /* 字体大小 */
        font-weight: bold !important;  /* 加粗 */
        text-align: center !important;  /* 标题居中 */
        padding: no !important;  /* 增加标题栏的内边距 */
        border-top-left-radius: 12px !important;  /* 顶部左边圆角 */
        border-top-right-radius: 12px !important;  /* 顶部右边圆角 */
        border: none !important;  /* 去掉默认的边框 */
    }
     

    /* 弹窗按钮样式 */
    .ui-dialog-buttonpane button {
        background: linear-gradient(145deg, #81c7e0, #5fa8d3) !important;  /* 按钮渐变背景 */
        color: white !important;  /* 按钮文字颜色 */
        border: none !important;  /* 去掉边框 */
        padding: 10px 20px !important;  /* 按钮内边距 */
        font-size: 16px !important;  /* 字体大小 */
        border-radius: 8px !important;  /* 圆角按钮 */
        cursor: pointer !important;  /* 鼠标悬停为手型 */
        transition: background-color 0.3s ease, transform 0.2s ease !important;  /* 平滑过渡效果 */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15) !important;  /* 添加阴影 */
    }

    /* 按钮悬浮效果 */
    .ui-dialog-buttonpane button:hover {
        background: linear-gradient(145deg, #5fa8d3, #81c7e0) !important;  /* 悬浮时背景颜色反转 */
        transform: translateY(-2px) !important;  /* 按钮悬浮时上移 */
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.2) !important;  /* 悬浮时增加阴影 */
    }
  
     
');

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
       
    }

    h1{
        color:white;
    }
        /* 设置提交按钮样式 */
    .btn.btn-primary {
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
        margin-left: +17px; 
    }

    .btn.btn-primary:hover {
        background: linear-gradient(145deg, #0077cc, #3a8fd5); /* 悬停时背景色反转 */
        transform: translateY(-3px); /* 悬停时稍微上移 */
        box-shadow: 3px 6px 15px rgba(0, 0, 0, 0.25);  /* 悬停时增加更强的阴影 */
    }

   /* 输入框半透明 */
    .form-control {
        margin-bottom: 30px !important;  /* 增加输入框之间的间距 */
        background-color: rgba(255, 255, 255, 0.3); /* 背景色为白色，透明度 0.7 */
        border: 1px solid #ddd; /* 边框样式 */
        padding: 10px; /* 内边距 */
        border-radius: 5px; /* 圆角 */
        font-size: 14px; /* 字体大小 */
        color: #333; /* 字体颜色 */
    }

   
    #successDialog div {
        font-size: 16px;      /* 设置字体大小 */
        color: #333;          /* 设置文字颜色为深灰色 */
        
    }

    .form-control::placeholder {
        color: #d3d3d3 !important;  /* 设置占位符为浅灰色 */
        font-style: italic;        /* 设置占位符文字为斜体 */
    }

    .form-control {
        color: white !important;  
    }
');
?>