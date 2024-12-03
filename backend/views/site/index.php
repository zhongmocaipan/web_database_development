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
                        <a class="nav-link" href="<?= \yii\helpers\Url::to(['comment/index']) ?>">Comment Management</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= \yii\helpers\Url::to(['post/likes']) ?>">Likes Management</a>
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
                                <p>Manage user comments on posts. Approve, edit, or delete comments as needed.</p>
                                <a href="<?= \yii\helpers\Url::to(['comment/index']) ?>" class="btn btn-primary">Go to Comment Management</a>
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
                                <a href="<?= \yii\helpers\Url::to(['post/likes']) ?>" class="btn btn-primary">Go to Likes Management</a>
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
</style>
