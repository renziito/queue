<?php

class TopController extends Controller {

    public function actionBitterSE() {
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

    public function actionBitter() {
        $db = 'neonpudd_queue.event';
        if (Yii::app()->request->hostInfo == "http://localhost") {
            $db = 'db_queue.event';
        }

        $limit = Yii::app()->request->getQuery("limit", 5);
        $sql = "SELECT username, SUM(amount) total FROM " . $db;
        $sql .= " WHERE type = 'cheer' AND state = 1";
        $sql .= " GROUP BY username ORDER BY 2 desc LIMIT " . $limit;

        $bitters = $cmd = Yii::app()->db->createCommand($sql)->queryAll();
        foreach ($bitters as $k => $bitter) {
            $response .= $k + 1 . '. ' . $bitter['username'];
            $response .= ' - ' . $bitter['total'] . ', ';
        }
        echo trim($response, ' ,');
    }

    public function actionGifter() {
        $db = 'neonpudd_queue.event';
        if (Yii::app()->request->hostInfo == "http://localhost") {
            $db = 'db_queue.event';
        }

        $gifters = [];
        $limit = Yii::app()->request->getQuery("limit", 5);

        $sql = "SELECT  b.username as users, b.amount, b.register_event as date";
        $sql .= " FROM " . $db . " as b WHERE b.gift = 1 AND b.state = 1 ";
        $sql .= " AND text like '%gifted%' AND b.type = 'event' and b.amount > 0 ";
        $sql .= " ORDER BY 2,1 ";

        $comGifters = $cmd = Yii::app()->db->createCommand($sql)->queryAll();

        foreach ($comGifters as $comGifter) {
            $gifters[$comGifter['users']] = [
                'users' => $comGifter['users'],
                'amount' => $comGifter['amount'],
                'date' => $comGifter['date']
            ];
        }

        $sql = "select * from " . $db . " as a where";
        $sql .= " a.gift = 1 AND a.state = 1 AND a.type = 'event' and a.amount = 0";
        $sql .= " AND text like '%gifted%'";
        $sql .= " order by register_event";

        $indGifters = $cmd = Yii::app()->db->createCommand($sql)->queryAll();

        foreach ($indGifters as $indGifter) {
            if (isset($gifters[$indGifter['username']])) {
                if ($indGifter['register_event'] > $gifters[$indGifter['username']]['date']) {
                    $gifters[$indGifter['username']]['amount'] += 1;
                }
            } else {
                $gifters[$indGifter['username']] = [
                    'users' => $indGifter['username'],
                    'amount' => 1,
                    'date' => $indGifter['register_event']
                ];
            }
        }

        usort($gifters, function($a, $b) {
            return $b['amount'] - $a['amount'];
        });

        $response = "";
        $k = 1;
        for ($i = 0; $i < $limit; $i++) {
            $response .= $k. '. ' . $gifters[$i]['users'];
            $response .= ' - ' . $gifters[$i]['amount'] . ', ';
            $k++;
        }
        echo trim($response, ' ,');
    }

}
