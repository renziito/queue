<?php

class TopController extends Controller {

    public function actionBitter() {
        $limit = Yii::app()->request->getQuery("limit", 5);
        $url = ConstApp::URLAPI . "sessions/" . ConstApp::CLIENID;

        $url .= "/top?type=cheer&interval=alltime&limit=" . $limit;

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'accept: application/json',
            'content-type: application/json',
            'authorization: Bearer ' . ConstApp::JWTTOKEN
        ));
        $exec = curl_exec($ch);
        curl_close($ch);

        $bitters = json_decode($exec, true);
        $response = "";

        foreach ($bitters as $k => $bitter) {
            $response .= $k + 1 . '. ' . $bitter['username'];
            $response .= ' - ' . $bitter['total'] . ', ';
        }
        echo trim($response, ' ,');
    }

    public function actionGifter() {
        $limit = Yii::app()->request->getQuery("limit", 5);
        $sql = "SELECT distinct(username),amount as total FROM event WHERE";
        $sql .= " type = 'subscriber' AND state = 1 and gift = 1 ORDER BY amount desc LIMIT " . $limit;

        $gifters = $cmd = Yii::app()->db->createCommand($sql)->queryAll();
        $response = "";
        foreach ($gifters as $k => $gifter) {
            $response .= $k + 1 . '. ' . $gifter['username'];
            $response .= ' - ' . $gifter['total'] . ', ';
        }
        echo trim($response, ' ,');
    }

}
