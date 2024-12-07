<?php

/* @var $this yii\web\View */

$this->title = 'Admin Dashboard';
?>
<div class="admin-dashboard">

    <!-- 顶部导航栏 -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Admin Dashboard</a>
   </nav>

    <div class="container-fluid">
        <div class="row">
            <!-- 侧边栏 -->
            <div class="col-md-3 bg-light sidebar">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link active" href="<?= \yii\helpers\Url::to(['site/index']) ?>">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= \yii\helpers\Url::to(['comment/select-type']) ?>">Comment Management</a>
                        <!-- 子菜单 -->
                        <ul class="nav flex-column ml-3">
                            <li class="nav-item">
                                <a class="nav-link" href="<?= \yii\helpers\Url::to(['comment/ai-tool']) ?>">AI Tool Comments</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= \yii\helpers\Url::to(['comment/paper']) ?>">Paper Comments</a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="<?= \yii\helpers\Url::to(['post/select-type']) ?>">Likes Management</a>
                        <!-- 子菜单 -->
                        <ul class="nav flex-column ml-3">
                            <li class="nav-item">
                                <a class="nav-link" href="<?= \yii\helpers\Url::to(['post/ai-tool']) ?>">AI Tool Likes</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= \yii\helpers\Url::to(['post/paper']) ?>">Paper Likes</a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= \yii\helpers\Url::to(['user/user-management']) ?>">User Management</a>
                    </li>
                </ul>
            </div>

            <!-- 主要内容区域 -->
            <div class="col-md-9">
                <div class="jumbotron">
                    <h1 class="display-4">Welcome to the Admin Dashboard!</h1>
                    <p class="lead">You can manage all the aspects of the website from here. Use the sidebar to navigate to different sections.</p>
                </div>

                <div class="row">

                    <!-- 评论管理 -->
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header">
                                Comment Management
                            </div>
                            <div class="card-body">
                                <p>Select the type of comments you want to manage:</p>
                                <a href="<?= \yii\helpers\Url::to(['comment/select-type']) ?>" class="btn btn-primary">Go to Comment Management</a>
                            </div>
                        </div>
                    </div>

                    <!-- 点赞数管理 -->
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header">
                                Likes Management
                            </div>
                            <div class="card-body">
                                <p>Manage the number of likes for each post. Reset, increase, or decrease likes as needed.</p>
                                <a href="<?= \yii\helpers\Url::to(['post/select-type']) ?>" class="btn btn-primary">Go to Likes Management</a>
                            </div>
                        </div>
                    </div>

                    <!-- 用户管理 -->
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header">
                                User Management
                            </div>
                            <div class="card-body">
                                <p>Manage front-end users, including viewing profiles, disabling accounts, and more.</p>
                                <a href="<?= \yii\helpers\Url::to(['user/user-management']) ?>" class="btn btn-primary">Go to User Management</a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

</div>

<style>
    .admin-dashboard {
        margin-top: 20px;
    }

    .sidebar {
        padding-top: 20px;
    }

    .card {
        margin-bottom: 20px;
    }

    .card-header {
        font-size: 18px;
    }

    .jumbotron {
        background-color: #f1f1f1;
    }

    .navbar {
        margin-bottom: 20px;
    }

    .nav-link.active {
        font-weight: bold;
    }

    .nav.flex-column .nav-item .nav-link {
        padding-left: 1.5rem;
    }
</style>
