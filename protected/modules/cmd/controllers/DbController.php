<?php

class DbController extends Controller {

    public function actionSaveEvent() {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
        header("Access-Control-Allow-Headers: Authorization");

        $event = new Event;

        $json = file_get_contents('php://input');
        $data = json_decode($json);
        Utils::show($data);

        $event->type = $data->type;
        $event->username = $data->username;
        $event->text = $data->text;
        $event->gift = $data->gift;
        $event->receiver = $data->receiver;
        $event->amount = $data->amount;
        Utils::show($event->attributes);
        $event->save();
    }

    public function actionQuery() {
        $query = Yii::app()->request->getQuery('query');
    }

}
