<?php

class TopController extends Controller
{
    public function actionBitterSE()
    {
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

    public function actionBitter()
    {
        $db = 'neonpudd_queue.event';
        if (Yii::app()->request->hostInfo == "http://localhost") {
            $db = 'db_queue.event';
        }

        $limit = Yii::app()->request->getQuery("limit", 5);
        $sql = "SELECT username, SUM(amount) total FROM ".$db;
        $sql .= " WHERE type = 'cheer' AND state = 1";
        $sql .= " GROUP BY username ORDER BY 2 desc LIMIT " . $limit;

        $bitters = $cmd = Yii::app()->db->createCommand($sql)->queryAll();
        foreach ($bitters as $k => $bitter) {
            $response .= $k + 1 . '. ' . $bitter['username'];
            $response .= ' - ' . $bitter['total'] . ', ';
        }
        echo trim($response, ' ,');
    }

    public function actionGifter()
    {
        $db = 'neonpudd_queue.event';
        if (Yii::app()->request->hostInfo == "http://localhost") {
            $db = 'db_queue.event';
        }


        $limit = Yii::app()->request->getQuery("limit", 5);
        $sql = "SELECT username, SUM(CASE amount WHEN 0 THEN 1 ELSE amount END) total FROM (";
        $sql .= "SELECT * FROM " . $db . " WHERE gift = 1 AND state = 1 AND type = 'event') as f";
        $sql .= " GROUP BY username ORDER BY 2 desc LIMIT " . $limit;

        $gifters = $cmd = Yii::app()->db->createCommand($sql)->queryAll();
        $response = "";
        foreach ($gifters as $k => $gifter) {
            $response .= $k + 1 . '. ' . $gifter['username'];
            $response .= ' - ' . $gifter['total'] . ', ';
        }
        echo trim($response, ' ,');
    }
}
