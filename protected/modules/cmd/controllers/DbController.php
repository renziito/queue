<?php

class DbController extends Controller {

    public function actionSaveEvent() {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
        header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

        $event = new Event;

        $json = file_get_contents('php://input');
        $data = json_decode($json);


        Utils::show($data);
        $event->attributes = $data;
        echo json_encode($event->attributes);
        $event->save();
        echo json_encode($event->getErrors());
    }

    public function actionQuery() {
        $query = Yii::app()->request->getQuery('query');
    }

}
