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
            <div class="col-md-9 move-up">
                <div class="jumbotron">
                    <div class="container">
                        <!-- Paper Likes 饼状图 -->
                        <div class="col-md-6">
                            <h3>Paper Likes</h3>
                                <div style="width: 300px; height: 300px; margin: 0 auto;"> <!-- 调整大小 -->
                                    <canvas id="paperLikesPieChart"></canvas>
                                </div>
                        </div>

                        <!-- Paper Comments 饼状图 -->
                        <div class="col-md-6">
                            <h3>Paper Comments</h3>
                            <div style="width: 300px; height: 300px; margin: 0 auto;"> <!-- 调整大小 -->
                                <canvas id="paperCommentsPieChart"></canvas>
                            </div>
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

<!-- 引入chartjs-plugin-wordcloud -->
<!-- <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-wordcloud"></script> -->
<script src="https://cdn.jsdelivr.net/npm/chartjs-chart-wordcloud"></script>

<?php
$filteredPaperTitles = array_map(function ($title) {
    $words = explode(' ', $title);
    return $words[0]; // 仅保留标题的第一个单词
}, $paperTitles);

$filteredCommentTitles = array_map(function ($title) {
    $words = explode(' ', $title);
    return $words[0]; // 仅保留标题的第一个单词
}, $paperCommentTitles);
?>

<script>
window.onload = function () {
    // 计算 Paper Likes 数据占比
    var paperLikesData = <?= json_encode($paperLikes) ?>;
    var filteredTitlesForLikes = <?= json_encode($filteredPaperTitles) ?>;
    var filteredLikes = paperLikesData.filter(count => count > 0); // 过滤点赞数为0的文章
    var paperLikesTotal = filteredLikes.reduce((a, b) => a + b, 0); // 总点赞数
    var paperLikesPercentage = filteredLikes.map(function (count) {
        return ((count / paperLikesTotal) * 100).toFixed(2); // 百分比计算并保留两位小数
    });

    // Paper Likes 饼状图
    var ctx1 = document.getElementById('paperLikesPieChart').getContext('2d');
    var paperLikesPieChart = new Chart(ctx1, {
        type: 'pie',
        data: {
            labels: filteredTitlesForLikes, // 使用过滤后的标题
            datasets: [{
                label: 'Percentage of Likes (%)',
                data: paperLikesPercentage,
                backgroundColor: ['#ff6384', '#36a2eb', '#ffce56', '#4bc0c0', '#9966ff', '#ff9f40'],
                hoverOffset: 4
            }]
        },
        options: {
            responsive: true,
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function (tooltipItem) {
                            var label = tooltipItem.label || '';
                            var value = tooltipItem.raw || 0;
                            return label + ': ' + value + '%'; // 显示百分比
                        }
                    }
                },
                legend: {
                    display: true,
                    position: 'top'
                }
            }
        }
    });

    // 计算 Paper Comments 数据占比
    var paperCommentsData = <?= json_encode($paperCommentCounts) ?>;
    var filteredTitlesForComments = <?= json_encode($filteredCommentTitles) ?>;
    var filteredComments = paperCommentsData.filter(count => count > 0); // 过滤评论数为0的文章
    var paperCommentsTotal = filteredComments.reduce((a, b) => a + b, 0); // 总评论数
    var paperCommentsPercentage = filteredComments.map(function (count) {
        return ((count / paperCommentsTotal) * 100).toFixed(2); // 百分比计算并保留两位小数
    });

    // Paper Comments 饼状图
    var ctx2 = document.getElementById('paperCommentsPieChart').getContext('2d');
    var paperCommentsPieChart = new Chart(ctx2, {
        type: 'pie',
        data: {
            labels: filteredTitlesForComments, // 使用过滤后的标题
            datasets: [{
                label: 'Percentage of Comments (%)',
                data: paperCommentsPercentage,
                backgroundColor: ['#4bc0c0', '#9966ff', '#ff9f40', '#ff6384', '#36a2eb', '#ffce56'],
                hoverOffset: 4
            }]
        },
        options: {
            responsive: true,
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function (tooltipItem) {
                            var label = tooltipItem.label || '';
                            var value = tooltipItem.raw || 0;
                            return label + ': ' + value + '%'; // 显示百分比
                        }
                    }
                },
                legend: {
                    display: true,
                    position: 'top'
                }
            }
        }
    });
};
</script>


<!-- <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-wordcloud"></script> -->

<script>
 

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

    .move-up {
        margin-top: -30px; /* 向上移动内容区域 */
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
    width: 80%; /* 调整宽度，比如设为80%或固定px值 */
    max-width: 900px; /* 限制最大宽度 */
    height: auto; /* 根据内容自动调整高度 */
    padding: 20px; /* 减少内边距 */
    margin: 20px auto; /* 居中显示，设置外边距 */
    border-radius: 10px; /* 添加圆角效果 */

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
        width: 300px; /* 限制宽度，例如 300px */
        height: 300px; /* 限制高度，例如 300px */
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
    .chart-container {
    width: 300px; /* 统一宽度 */
    height: 300px; /* 统一高度 */
    margin: 0 auto; /* 居中 */
    }
</style>
