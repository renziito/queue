<?php

class DbController extends Controller {

    public function actionSaveEvent() {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods", "DELETE, POST, GET, OPTIONS");
        header("Access-Control-Allow-Headers", "Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

        $event = new Event;

        $json = file_get_contents('php://input');
        $data = json_decode($json);

        $event->type = $data->type;
        $event->username = $data->username;
        $event->text = $data->text;
        $event->gift = $data->gift;
        $event->receiver = $data->receiver;
        $event->amount = $data->amount;
        $event->save();
        echo json_encode($event->getErrors());
    }

    public function actionQuery() {
        $query = Yii::app()->request->getQuery('query');
    }

}
