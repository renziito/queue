<?php

class DbController extends Controller {

    public function actionSaveEvent() {
        $event = new Event;
        $event->attributes = $_POST;
        $event->save();
    }

    public function actionQuery() {
        $query = Yii::app()->request->getQuery('query');
    }

}
