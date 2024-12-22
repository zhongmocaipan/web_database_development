@echo off
REM 检查 Conda 是否安装
where conda >nul 2>nul
IF ERRORLEVEL 1 (
    echo Conda 未安装，请先安装 Miniconda 或 Anaconda.
    exit /b
)

REM 创建并激活虚拟环境
echo 创建并激活虚拟环境...
conda create -y -n myenv python=3.7.5
call conda activate myenv

REM 安装依赖
echo 安装依赖...
pip install -r requirements.txt

echo 部署完成！
pause
