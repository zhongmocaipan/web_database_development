@echo off
:: 一键部署脚本 - Windows 环境
:: 请确保系统已安装 PHP、Composer 和 Python

:: 设置项目路径和PHP路径
set PROJECT_PATH=C:\path\to\your_project
set PHP_PATH=C:\path\to\php
set COMPOSER_PATH=C:\path\to\composer

:: 进入项目目录
cd /d %PROJECT_PATH%

echo [步骤1] 安装 Composer 依赖...
%COMPOSER_PATH%\composer install
if %errorlevel% neq 0 (
    echo Composer 依赖安装失败，请检查环境配置。
    exit /b 1
)

echo [步骤2] 安装 Python 环境依赖...
pip install -r requirements.txt
if %errorlevel% neq 0 (
    echo Python 依赖安装失败，请检查 pip 配置。
    exit /b 1
)

echo [步骤3] 配置数据库...
echo 请确保数据库已配置完成，执行迁移操作。
%PHP_PATH%\php yii migrate --interactive=0
if %errorlevel% neq 0 (
    echo 数据库迁移失败，请检查数据库配置。
    exit /b 1
)

echo [步骤4] 启动前端服务...
start %PHP_PATH%\php yii serve --docroot=frontend/web --port=8080

echo [步骤5] 启动后端服务...
start %PHP_PATH%\php yii serve --docroot=backend/web --port=8081

echo 部署完成！前端运行在 http://localhost:8080 ，后端运行在 http://localhost:8081。
pause
