<?php

class DbController extends Controller {

    public function actionSaveEvent() {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
        header("Access-Control-Allow-Headers: Authorization");
        
        $event = new Event;
        Utils::show($_POST);
        $event->attributes = json_decode($_POST);
        echo json_encode($event->attributes);
        $event->save();
        echo json_encode($event->getErrors());
    }

    public function actionQuery() {
        $query = Yii::app()->request->getQuery('query');
    }

}
