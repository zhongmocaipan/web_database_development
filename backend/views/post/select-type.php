<?php
/* @var $this yii\web\View */

$this->title = 'Select Like Type';
?>
<h1 class="text-center mb-5">Select Like Type</h1>

<!-- 使用Flexbox并限制最大宽度来确保页面只在中间部分显示 -->
<div class="container d-flex justify-content-center align-items-center" style="max-width: 800px; margin: 0 auto; min-height: 100vh;">
    <div class="row w-100 justify-content-center">
        <!-- 左边卡片 -->
        <div class="col-md-6 col-lg-6 mb-4">
            <div class="card shadow-lg border-0">
                <div class="card-header text-white" style="background: #007bff; border-radius: 10px;">
                    <h5>AI Tool Likes</h5>
                </div>
                <div class="card-body">
                    <p>View and manage likes for AI tools.</p>
                    <a href="<?= \yii\helpers\Url::to(['post/ai-tool']) ?>" class="btn btn-primary btn-block hover-btn">Go to AI Tool Likes</a>
                </div>
            </div>
        </div>

        <!-- 右边卡片 -->
        <div class="col-md-6 col-lg-6 mb-4">
            <div class="card shadow-lg border-0">
                <div class="card-header text-white" style="background: #28a745; border-radius: 10px;">
                    <h5>Paper Likes</h5>
                </div>
                <div class="card-body">
                    <p>View and manage likes for papers.</p>
                    <a href="<?= \yii\helpers\Url::to(['post/paper']) ?>" class="btn btn-success btn-block hover-btn">Go to Paper Likes</a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    h1 {
    margin-bottom:200px;  /* 自定义更大的间距 */
    }

    /* 页面背景渐变 */
    body {
        background: linear-gradient(135deg, #f8f9fa, #e0e0e0);
        font-family: 'Arial', sans-serif;
    }

    /* 统一卡片阴影 */
    .card {
        border-radius: 10px;
        transition: transform 0.3s ease-in-out;
    }

    .card:hover {
        transform: translateY(-10px);
    }

    /* 按钮悬停效果 */
    .hover-btn {
        transition: all 0.3s ease;
    }

    .hover-btn:hover {
        background-color: #0056b3;
        box-shadow: 0 4px 10px rgba(0, 123, 255, 0.4);
    }

    /* 增加标题字体样式 */
    h1 {
        font-family: 'Arial', sans-serif;
        font-weight: bold;
        color: #333;
    }

    .card-header h5 {
    font-weight: bold;
    font-size: 2rem; /* 设置字体大小 */
    }
    /* 自适应卡片大小 */
    .col-md-6 {
        margin-bottom: 20px;
    }

    .card-body {
        font-size: 20px;
        line-height: 1.6;
    }

    .btn-block {
        padding: 10px 20px;
    }

    /* 响应式设计优化 */
    @media (max-width: 768px) {
        .col-md-6 {
            max-width: 90%;
            margin: 0 auto;
        }
    }
</style>
