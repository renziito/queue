<?php

class DbController extends Controller {

    public function actionSaveEvent() {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
        header("Access-Control-Allow-Headers: Authorization");

        $event = new Event;

        $json = file_get_contents('php://input');
        $data = json_decode($json);
        $event->type = $data->type;
        $event->username = $data->username;
        $event->text = $data->text;
        $event->gift = $data->gift;
        $event->receiver = $data->receiver;
        $event->amount = $data->amount;
        $event->register_event = date('Y-m-d H:i:s');
        if ($event->save()) {
            echo 'OK';
        } else {
            echo json_encode($event->getErrors());
        }
    }

    public function actionSearch() {
        $query = Yii::app()->request->getQuery('query');
        $words = explode("&", $query);
        $searchable = "'%" . implode("%' or  text like '%", str_replace('+', ' ', $words)) . "%'";

        $sql = "SELECT count(*) FROM event WHERE state = 1 AND (text like " . $searchable.")";

        echo Yii::app()->db->createCommand($sql)->getText();
    }

}
