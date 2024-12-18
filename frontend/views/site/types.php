<?php 
use yii\helpers\Html;
use yii\helpers\Url;
use yii\db\Query;

$this->registerCssFile('@web/css/style.css');  // 引入样式文件
$this->registerJsFile('https://d3js.org/d3.v5.min.js', ['position' => \yii\web\View::POS_END]);  // 引入 D3.js 库
$this->registerJsFile('https://cdn.plot.ly/plotly-latest.min.js', ['position' => \yii\web\View::POS_END]);  // 引入 Plotly.js 库
$this->registerCssFile('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css');  // 引入 FontAwesome 图标库
?>

<h1>Country Ranking by Score</h1>

<!-- 下拉列表选择年份 -->
<div class="form-group">
    <label for="year-select">Select Year:</label>
    <select id="year-select" class="form-control" onchange="updateCharts()">
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

<!-- 显示弦图和三维图容器 -->
<div class="row">
    <!-- 弦图 -->
    <div class="col-lg-6">
        <div id="chord-diagram" style="width: 100%; height: 400px;"></div>
    </div>
    <!-- 三维图 -->
    <div class="col-lg-6">
        <div id="threeD-chart" style="width: 100%; height: 600px;"></div>
    </div>
</div>



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
    // 国家和图标的映射
    var countryIcons = {
        "USA": "fa-flag",
        "China": "fa-git",
        "Germany": "fa-basketball-ball",
        "India": "fa-cogs",
        "UK": "fa-paw",  // 示例，继续添加其他国家及图标
        // ...
    };

    function updateCharts() {
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

                // 转换数据为弦图所需的格式
                var countries = data.map(function(country) { return country.region; });
                var matrix = generateMatrix(data); // 生成弦图需要的矩阵数据

                // 更新弦图
                createChordDiagram(matrix, countries);

                // 更新三维图
                update3DChart(data);
                updateLineChart(data);
            }
        });
    }
  
    function updateLineChart(data) {
    // 提取数据：国家、文档数和引用数
    var countries = data.map(function(country) { return country.region; });
    var documents = data.map(function(country) { return parseFloat(country.documents); });
    var citations = data.map(function(country) { return parseFloat(country.citations); });

    // 创建折线图的traces
    var traceDocuments = {
            x: countries,
            y: documents,
            mode: 'lines+markers',
            name: 'Documents',
            line: { color: '#1f77b4', width: 2 },
            marker: { color: '#1f77b4' }
        };

        var traceCitations = {
            x: countries,
            y: citations,
            mode: 'lines+markers',
            name: 'Citations',
            line: { color: '#ff7f0e', width: 2 },
            marker: { color: '#ff7f0e' }
        };

        var layout = {
            title: 'Documents & Citations by Country',
            xaxis: { title: 'Country' },
            yaxis: { title: 'Count' },
            plot_bgcolor: 'rgba(0, 0, 0, 0)',  // 设置背景透明
            paper_bgcolor: 'rgba(0, 0, 0, 0.1)', // 设置透明背景
            font: { color: '#fff' }  // 设置字体颜色为白色
        };

        // 使用Plotly绘制折线图
        Plotly.newPlot('line-chart', [traceDocuments, traceCitations], layout);
    }

    // 生成弦图矩阵
    function generateMatrix(data) {
        var countries = [...new Set(data.map(function(country) { return country.region; }))];
        var matrix = [];

        countries.forEach(function(source, i) {
            matrix[i] = [];
            countries.forEach(function(target, j) {
                var value = 0;

                // 根据需要的属性来填充矩阵，例如使用citable_documents、citations等
                data.forEach(function(country) {
                    if (country.region === source) {
                        value += parseFloat(country.citable_documents);  // 这里你可以根据需求替换不同属性
                    }
                });

                matrix[i][j] = value;
            });
        });

        return matrix;
    }

    // 创建弦图
    function createChordDiagram(matrix, countries) {
        var width = 400;
        var height = 400;
        var innerRadius = Math.min(width, height) * 0.4;
        var outerRadius = innerRadius * 1.1;

        // 设置弦图的颜色
        var color = d3.scaleOrdinal(d3.schemeCategory10);

        // 设置弦图的布局
        var chord = d3.chord().padAngle(0.05).sortSubgroups(d3.descending);

        var arc = d3.arc().innerRadius(innerRadius).outerRadius(outerRadius);
        var ribbon = d3.ribbon().radius(innerRadius);

        // 清空之前的图形
        d3.select("#chord-diagram").select("svg").remove();

        var svg = d3.select("#chord-diagram").append("svg")
            .attr("width", width)
            .attr("height", height)
            .append("g")
            .attr("transform", "translate(" + width / 2 + "," + height / 2 + ")");

        var chords = chord(matrix);

        var group = svg.append("g")
            .selectAll("g")
            .data(chords.groups)
            .enter().append("g");

        group.append("path")
            .style("fill", function(d, i) { return color(i); })
            .style("stroke", function(d, i) { return color(i); })
            .attr("d", arc);

        group.append("text")
            .attr("transform", function(d) { 
                return "rotate(" + ((d.startAngle + d.endAngle) / 2 * 180 / Math.PI - 90) + ")translate(" + (outerRadius + 10) + ")";
            })
            .attr("dy", ".35em")
            .style("text-anchor", "middle")
            .html(function(d, i) {
                var country = countries[i];
                var iconClass = countryIcons[country] || 'fa-circle';  // 默认图标
                return `<i class="fa ${iconClass}" style="color: ${color(i)};"></i>`;  // FontAwesome图标与颜色
            });

        svg.append("g")
            .selectAll("path")
            .data(chords)
            .enter().append("path")
            .attr("d", ribbon)
            .style("fill", function(d) { return color(d.target.index); })
            .style("stroke", function(d) { return color(d.target.index); });
        
        // 添加矩形框，表示每个国家的颜色
       // 添加矩形框，表示每个国家的颜色
var legendContainer = d3.select("#chord-diagram").append("div")
    .style("display", "flex") // 水平排列
    .style("flex-wrap", "wrap") // 自动换行
    .style("margin-left", "20px")
    .style("margin-top", "20px");

countries.forEach(function(country, i) {
    var legendItem = legendContainer.append("div")
        .style("display", "flex")
        .style("align-items", "center")
        .style("margin-right", "15px") // 增加水平间距
        .style("margin-bottom", "10px"); // 增加垂直间距

    // 创建颜色矩形框
    legendItem.append("div")
        .style("width", "20px")
        .style("height", "20px")
        .style("background-color", color(i)) // 设置颜色
        .style("margin-right", "5px"); // 矩形与文本之间的间距

    // 创建文本标签
    legendItem.append("span")
        .text(country)
        .style("color", "#fff")
        .style("font-size", "14px")
        .style("font-weight", "bold"); // 你可以调整字体样式
});

    }

    // 更新三维图
    function update3DChart(data) {
    var countries = data.map(function(country) { return country.region; });
    var regions = data.map(function(country) { return country.region; });

    // 提取不同属性数据
    var documents = data.map(function(country) { return parseFloat(country.documents); });
    var citableDocuments = data.map(function(country) { return parseFloat(country.citable_documents); });
    var citations = data.map(function(country) { return parseFloat(country.citations); });
    var selfCitations = data.map(function(country) { return parseFloat(country.self_citations); });
    var citationsPerDocument = data.map(function(country) { return parseFloat(country.citations_per_document); });
    var hIndex = data.map(function(country) { return parseFloat(country.h_index); });

    // 定义不同颜色
    var colors = ['#1f77b4', '#ff7f0e', '#2ca02c', '#d62728', '#9467bd', '#8c564b'];

    // 为不同的属性创建多个系列
    var traces = [
        {
            x: countries,
            y: regions,
            z: documents,
            mode: 'markers',
            marker: { size: 10, color: '#1f77b4' },
            name: 'Documents',
            type: 'scatter3d'
        },
        {
            x: countries,
            y: regions,
            z: citableDocuments,
            mode: 'markers',
            marker: { size: 10, color: '#ff7f0e' },
            name: 'Citable Documents',
            type: 'scatter3d'
        },
        {
            x: countries,
            y: regions,
            z: citations,
            mode: 'markers',
            marker: { size: 10, color: '#2ca02c' },
            name: 'Citations',
            type: 'scatter3d'
        },
        {
            x: countries,
            y: regions,
            z: selfCitations,
            mode: 'markers',
            marker: { size: 10, color: '#d62728' },
            name: 'Self Citations',
            type: 'scatter3d'
        },
        {
            x: countries,
            y: regions,
            z: citationsPerDocument,
            mode: 'markers',
            marker: { size: 10, color: '#9467bd' },
            name: 'Citations per Document',
            type: 'scatter3d'
        },
        {
            x: countries,
            y: regions,
            z: hIndex,
            mode: 'markers',
            marker: { size: 10, color: '#8c564b' },
            name: 'H-index',
            type: 'scatter3d'
        }
    ];

    // 设置图表布局
    var layout = {
        scene: {
            xaxis: { title: 'Country' },
            yaxis: { title: 'Region' },
            zaxis: { title: 'Metrics' },
            bgcolor: 'rgba(0,0,0,0)'  // 设置背景为透明
        },
        title: '3D Scatter Plot of Country Metrics',
        plot_bgcolor: 'rgba(0,0,0,0)',  // 设置绘图区背景为透明
        paper_bgcolor: 'rgba(0,0,0,0.5)',  // 设置整体背景为透明
        font: { color: '#fff' }  // 设置字体颜色为白色，避免与背景混淆
    };

    // 清空之前的图形
    Plotly.newPlot('threeD-chart', traces, layout);
}

    // 页面加载时，如果有初始数据，渲染弦图和三维图
    <?php if ($initialYear): ?>
        document.addEventListener('DOMContentLoaded', function() {
            updateCharts();  // 更新弦图和三维图
        });
    <?php endif; ?>
</script>

<style>
    /* 隐藏底部的版权信息 */
footer {
    display: none;
}
    #chord-diagram, #threeD-chart {
        width: 100%;
        height: 600px;
    }
    #line-chart {
    width: 100%;
    height: 200px;  /* 设置折线图的高度为200px */
}
    .row {
        display: flex;
        justify-content: space-between;
    }

    .col-lg-6 {
        padding: 10px;
        flex: 0 0 48%;
    }


    .legend {
        display: flex;
        flex-direction: column;
        margin-left: 20px;
    }
</style>

<?php
// 添加样式来调整页面布局和背景图片
$this->registerCss('
    body {
        background-image: url("' . Yii::getAlias('@web/images/background.jpg') . '");
        background-size: cover;
        background-attachment: fixed;
        background-position: center;
        background-repeat: no-repeat;
        color: #333;
    }

    h1 {
        font-size: 48px;
        color: #f0f0f0;
        font-weight: bold;
        text-align: center;
        margin-top: 30px;
    }

    .form-group {
        margin-bottom: 20px;
        text-align: center;
    }

    .form-control {
        width: 300px;
        display: inline-block;
    }

    .row {
        margin-top: 60px;
    }

    .col-lg-6 {
        padding: 10px;
    }
');
?> 
