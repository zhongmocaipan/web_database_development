<?php

/* @var $this yii\web\View */

$this->title = 'Admin Dashboard';
?>

<div class="admin-dashboard">

    <!-- 顶部导航栏 -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#" style="color: white;">Admin Dashboard</a>
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
                    <li class="nav-item">
                        <a class="nav-link" href="<?= \yii\helpers\Url::to(['site/paper-management']) ?>">Paper Management</a>
                        <a class="nav-link" href="<?= \yii\helpers\Url::to(['site/tool-management']) ?>">AI Tool Management</a>                    </li>
                </ul>
            </div>

            <!-- 主要内容区域 -->
            <div class="col-md-9">
                <div class="jumbotron">
                    <div class="container">
                        <!-- Paper Likes -->
                        <div class="col-md-6">
                            <h3>Paper Likes</h3>
                            <canvas id="paperLikesChart"></canvas> <!-- Paper Likes Chart -->
                        </div>

                        <!-- Paper Comments -->
                        <div class="col-md-6">
                            <h3>Paper Comments</h3>
                            <canvas id="paperCommentsChart"></canvas> <!-- Paper Comments Chart -->
                        </div>
                    </div>

                    <div class="container">
                        <!-- AI Tool Likes -->
                        <div class="col-md-6">
                            <h3>AI Tool Likes</h3>
                            <canvas id="aiToolLikesChart"></canvas> <!-- AI Tool Likes Chart -->
                        </div>

                        <!-- AI Tool Comments -->
                        <div class="col-md-6">
                            <h3>AI Tool Comments</h3>
                            <canvas id="aiToolCommentsChart"></canvas> <!-- AI Tool Comments Chart -->
                        </div>
                    </div>
                </div>

                <!-- 三个卡片并排显示 -->
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

<!-- 引入Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.1/dist/chart.min.js"></script>

<script>
    // Paper Likes Chart
    var ctx1 = document.getElementById('paperLikesChart').getContext('2d');
    var paperLikesChart = new Chart(ctx1, {
        type: 'bar',
        data: {
            labels: <?= json_encode($paperTitles) ?>, // 从控制器传递的数据
            datasets: [{
                label: 'Likes Count',
                data: <?= json_encode($paperLikes) ?>, // 从控制器传递的数据
                backgroundColor: '#ffc107', // Yellow for Likes
                borderColor: '#e0a800',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                tooltip: {
                    callbacks: {
                        label: function(tooltipItem) {
                            return tooltipItem.dataset.label + ': ' + tooltipItem.raw;
                        }
                    }
                }
            },
            scales: {
                x: {
                    beginAtZero: true
                }
            }
        }
    });

    // Paper Comments Chart
    var ctx2 = document.getElementById('paperCommentsChart').getContext('2d');
    var paperCommentsChart = new Chart(ctx2, {
        type: 'bar',
        data: {
            labels: <?= json_encode($paperCommentTitles) ?>, // 从控制器传递的数据
            datasets: [{
                label: 'Comments Count',
                data: <?= json_encode($paperCommentCounts) ?>, // 从控制器传递的数据
                backgroundColor: '#17a2b8', // Blue for Comments
                borderColor: '#138496',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                tooltip: {
                    callbacks: {
                        label: function(tooltipItem) {
                            return tooltipItem.dataset.label + ': ' + tooltipItem.raw;
                        }
                    }
                }
            },
            scales: {
                x: {
                    beginAtZero: true
                }
            }
        }
    });

    // AI Tool Likes Chart
    var ctx3 = document.getElementById('aiToolLikesChart').getContext('2d');
    var aiToolLikesChart = new Chart(ctx3, {
        type: 'bar',
        data: {
            labels: <?= json_encode($toolNames) ?>, // 从控制器传递的数据
            datasets: [{
                label: 'Likes Count',
                data: <?= json_encode($toolLikes) ?>, // 从控制器传递的数据
                backgroundColor: '#007bff', // Blue for Likes
                borderColor: '#0056b3',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                tooltip: {
                    callbacks: {
                        label: function(tooltipItem) {
                            return tooltipItem.dataset.label + ': ' + tooltipItem.raw;
                        }
                    }
                }
            },
            scales: {
                x: {
                    beginAtZero: true
                }
            }
        }
    });

// Paper Comments Chart
var ctx2 = document.getElementById('aiToolCommentsChart').getContext('2d');
var paperCommentsChart = new Chart(ctx2, {
    type: 'bar',
    data: {
        labels: <?= json_encode($toolCommentNames) ?>, // 传递的 tool-name 数据
        datasets: [{
            label: 'Comments Count',
            data: <?= json_encode($toolComments) ?>, // 传递的数量数据
            backgroundColor: '#17a2b8', // 柱子的背景颜色
            borderColor: '#138496',
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'top',
            },
            // 在柱子上方显示数量标签
            tooltip: {
                callbacks: {
                    label: function(context) {
                        return context.dataset.label + ': ' + context.raw;
                    }
                }
            }
        },
        scales: {
            y: { // Y轴配置
                beginAtZero: true,
                title: {
                    display: true,
                    text: 'Comments Count' // 竖坐标标题
                }
                
            },
            x: { // X轴配置
                title: {
                    display: true,
                    text: 'Tool Name' // 横坐标标题
                }
            }
            
        },
        animation: {
            onComplete: function() {
                var chartInstance = this.chart;
                var ctx = chartInstance.ctx;
                ctx.font = Chart.helpers.fontString(12, 'bold', Chart.defaults.font.family);
                ctx.fillStyle = '#000';
                ctx.textAlign = 'center';
                ctx.textBaseline = 'bottom';

                this.data.datasets.forEach(function(dataset, i) {
                    var meta = chartInstance.getDatasetMeta(i);
                    meta.data.forEach(function(bar, index) {
                        var data = dataset.data[index];
                        ctx.fillText(data, bar.x, bar.y - 5); // 在柱子上方显示数量
                    });
                });
            }
        }
    }
});
</script>

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
        color: white;
    }

    .jumbotron {
    background-color: #f1f1f1; /* 原始背景色 */
    opacity: 0.55; /* 50% 透明度 */
    }

    .navbar {
        margin-bottom: 20px;
    }

    .nav-link.active {
        font-weight: bold;
    }

    .nav.flex-column .nav-item .nav-link {
        padding-left: 1.5rem;
        color: white;
    }

    p {
        color: white;
    }

    /* 使柱状图之间有间隔 */
    canvas {
        margin-bottom: 30px;
    }

    /* 调整红框区域的样式 */
    .card {
        border-radius: 15px; /* 圆角 */
    }

    .bg-danger {
        background-color: #dc3545 !important; /* Red background for card */
    }

    /* 向右移动红框区域 */
    .col-md-4 {
        margin-left: 0px; /* 添加左侧的 margin 使卡片区域向右移动 */
    }

    /* 使卡片区域与图表有间距 */
    .mt-5 {
        margin-top: 50px;
    }
</style>
