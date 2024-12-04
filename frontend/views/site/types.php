<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\db\Query;

$this->registerCssFile('@web/css/style.css');  // 引入样式文件
$this->registerJsFile('https://cdn.jsdelivr.net/npm/chart.js', ['position' => \yii\web\View::POS_END]);  // 引入 Chart.js 库
?>

<h1>Country Ranking by Score</h1>

<!-- 下拉列表选择年份 -->
<div class="form-group">
    <label for="year-select">Select Year:</label>
    <select id="year-select" class="form-control" onchange="updateTableAndChart()">
        <option value="">Select Year</option>
        <?php
        // 查询所有年份
        $command = Yii::$app->db->createCommand('SELECT DISTINCT year FROM country_rank ORDER BY year DESC');
        $years = $command->queryAll();
        foreach ($years as $year) {
            echo "<option value='" . $year['year'] . "'>" . $year['year'] . "</option>";
        }
        ?>
    </select>
</div>

<!-- 显示图表容器 -->
<div class="row">
    <div class="col-lg-12">
        <canvas id="countryChart" width="400" height="200"></canvas>
    </div>
</div>

<!-- 数据表格 -->
<table class="table table-striped" id="country-table">
    <thead>
        <tr>
            <th>Region</th>
            <th>Documents</th>
            <th>Citable Documents</th>
            <th>Citations</th>
            <th>Self Citations</th>
            <th>Citations per Document</th>
            <th>H-index</th>
        </tr>
    </thead>
    <tbody>
        <!-- 数据将在这里动态加载 -->
    </tbody>
</table>

<?php
// 初始年份数据（用于页面加载时默认展示）
$initialYear = isset($years[0]['year']) ? $years[0]['year'] : '';
$initialData = [];
if ($initialYear) {
    $command = Yii::$app->db->createCommand("SELECT * FROM country_rank WHERE year = :year");
    $initialData = $command->bindValue(':year', $initialYear)->queryAll();
}

// 将初始数据传递给JS
$initialDataJson = json_encode($initialData);
?>

<script>
    // 更新表格和图表
    function updateTableAndChart() {
        var selectedYear = document.getElementById('year-select').value;

        if (!selectedYear) {
            alert("Please select a year.");
            return;
        }

        // 发起AJAX请求获取选定年份的数据
        $.ajax({
            url: '<?= Url::to(["site/get-country-data"]) ?>',
            type: 'GET',
            data: { year: selectedYear },
            success: function(response) {
                var data = JSON.parse(response);

                // 更新表格
                var tableBody = document.getElementById('country-table').getElementsByTagName('tbody')[0];
                tableBody.innerHTML = ''; // 清空表格
                data.forEach(function(country) {
                    var row = tableBody.insertRow();
                    row.insertCell(0).textContent = country.region;
                    row.insertCell(1).textContent = country.documents;
                    row.insertCell(2).textContent = country.citable_documents;
                    row.insertCell(3).textContent = country.citations;
                    row.insertCell(4).textContent = country.self_citations;
                    row.insertCell(5).textContent = country.citations_per_document;
                    row.insertCell(6).textContent = country.h_index;
                });

                // 更新图表
                var regionNames = data.map(function(country) { return country.region; });
                var citations = data.map(function(country) { return parseInt(country.citations); });

                var ctx = document.getElementById('countryChart').getContext('2d');
                var countryChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: regionNames,
                        datasets: [{
                            label: 'Citations',
                            data: citations,
                            backgroundColor: 'rgba(54, 162, 235, 0.2)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            }
        });
    }

    // 页面加载时，如果有初始数据，渲染表格和图表
    <?php if ($initialYear): ?>
        document.addEventListener('DOMContentLoaded', function() {
            updateTableAndChart();  // 更新表格和图表
        });
    <?php endif; ?>
</script>
