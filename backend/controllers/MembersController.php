<?php
/*
 * Team：LOVEYII
 * Coding By：胡雨欣 2212117
 * 后端成员控制器
*/
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\UploadedFile;
use backend\models\Members;

class MembersController extends Controller
{
    public function actionAdd()
    {
        $model = new Members();
    
        if (Yii::$app->request->isPost) {
            $model->load(Yii::$app->request->post());
    
            // 处理文件上传
            $file = UploadedFile::getInstance($model, 'memberhomework');
            if ($file) {
                // 将文件读取为二进制数据
                $model->memberhomework = file_get_contents($file->tempName);
            }
    
            // 保存数据到数据库
            if ($model->save()) {
                Yii::$app->session->setFlash('success', '成员信息保存成功！');
                return $this->redirect(['members/member']);
            } else {
                Yii::$app->session->setFlash('error', '数据保存失败！');
            }
        }
    
        return $this->render('add', ['model' => $model]);
    }
    

    public function actionMember()
    {
        // 获取所有 Members 数据
        $members = Members::find()->all();

        // 渲染视图，并将数据传递过去
        return $this->render('member', ['members' => $members]);
    }
    public function actionUpdate($id)
    {
        $model = Members::findOne($id);
    
        if (!$model) {
            throw new NotFoundHttpException('The requested member does not exist.');
        }
    
        if ($model->load(Yii::$app->request->post())) {
            // 处理文件上传
            $file = UploadedFile::getInstance($model, 'memberhomework');
            if ($file) {
                $model->memberhomework = file_get_contents($file->tempName);
            }
    
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Member updated successfully.');
                return $this->redirect(['member']);
            }
        }
    
        return $this->render('update', ['model' => $model]);
    }
    
}
