<?php

class SiteController extends Controller {

    /**
     * To change the view you have to edit
     * protectec/view/site/index.php
     */
    public function actionIndex() {
        echo 'Nothing to see here';
        Yii::app()->end();
        $this->render('index', [
            'current' => QQueue::getCurrent(),
            'top' => QQueue::getMostPlayed(10, false)
        ]);
    }

    /**
     * This is the action to handle external exceptions.
     */
    public function actionError() {
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest) {
                echo $error['message'];
            } else {
                $this->render('error', $error);
            }
        }
    }

    public function beforeAction($action) {
        $cssRoute = Yii::app()->baseUrl . '/css/main.css';
        Yii::app()->clientScript->registerCssFile($cssRoute);
        return true;
    }

}
