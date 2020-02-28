<?php

class QQueue
{
    public static function verifyOpen()
    {
        $params = 'state = true and queue_finish is null';
        $queue = Queue::model()->find($params);
        if ($queue) {
            return $queue;
        }
        return false;
    }

    public static function checkAlreadyIn($username, $id)
    {
        $params = 'queue_id = ' . $id . ' AND state = true and ';
        $params .= 'username = "' . $username . '" and play = false ';
        $params .= 'and remove = false';

        $queue = QueueList::model()->find($params);
        if ($queue) {
            return $queue;
        }
        return false;
    }

    public static function getNext($id)
    {
        $params = 'queue_id = ' . $id . ' AND state = true and ';
        $params .= 'play = false and remove = false ';
        $params .= 'ORDER BY register_date ASC';

        $queue = QueueList::model()->find($params);
        if ($queue) {
            return $queue;
        }
        return false;
    }

    public static function getMostPlayed()
    {
        $params = 'state = true and play = true and ';
        $params .= 'remove = false';

        $queue = QueueList::model()->findAll([
            'select'=> 'username, count(*) as play',
            'order'=>'2 desc  LIMIT 5',
            'group'=>'username',
            'condition'=>$params
        ]);
        $result = "";

        foreach ($queue as $k => $q) {
            $result .= ($k+1) .'. '. $q->username;
            $result .= ' ('.$q->play.' games), ';
        }
        return trim($result, ', ');
    }

    public static function getOrder($userId, $id)
    {
        $params = 'queue_id = ' . $id . ' AND state = true and ';
        $params.= 'remove = false and play = false and ';
        $params.= 'id <= '.$userId;
        $queue = QueueList::model()->count($params);
        return $queue;
    }
}
