<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use common\models\User;
use yii\web\NotFoundHttpException;
use yii\data\ActiveDataProvider;

class UserController extends Controller
{
    /**
     * 显示所有用户的管理页面
     * @return string
     */
    // 获取所有用户数据，选择需要的字段
   // Controller: UserController.php
    public function actionUserManagement()
    {
        // 获取所有用户数据，选择需要的字段
        $users = User::find()->select(['id', 'username', 'email', 'status'])->all();
        
        // 将用户数据传递给视图
        return $this->render('user-management', [
            'users' => $users
        ]);
    }

    
    /**
     * 显示单个用户的详细信息
     * @param int $id 用户 ID
     * @return string
     * @throws NotFoundHttpException 如果没有找到该用户
     */
    public function actionView($id)
    {
        $user = User::findOne($id);
        if (!$user) {
            throw new NotFoundHttpException('User not found');
        }

        return $this->render('view', ['user' => $user]);
    }

    /**
     * 更新用户信息
     * @param int $id 用户 ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException 如果没有找到该用户
     */
    public function actionUpdate($id)
    {
        $user = User::findOne($id);
        if (!$user) {
            throw new NotFoundHttpException('User not found');
        }

        // 如果表单提交并且保存成功，重定向到用户详情页
        if ($user->load(Yii::$app->request->post()) && $user->save()) {
            Yii::$app->session->setFlash('success', 'User updated successfully');
            return $this->redirect(['view', 'id' => $user->id]);
        }

        return $this->render('update', ['user' => $user]);
    }

    /**
     * 删除用户
     * @param int $id 用户 ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException 如果没有找到该用户
     */
    public function actionDelete($id)
    {
        $user = User::findOne($id);
        if (!$user) {
            throw new NotFoundHttpException('User not found');
        }

        $user->delete();
        Yii::$app->session->setFlash('success', 'User deleted successfully');
        return $this->redirect(['index']);
    }
}
