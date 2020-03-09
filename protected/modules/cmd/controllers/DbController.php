<?php

class DbController extends Controller {

    public function actionSaveEvent() {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
        header("Access-Control-Allow-Headers: Authorization");
        
        $event = new Event;
        $event->attributes = $_POST;
        $event->save();
    }

    public function actionQuery() {
        $query = Yii::app()->request->getQuery('query');
    }

}
