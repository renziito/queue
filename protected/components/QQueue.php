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

    public static function getMostPlayed($limit = 5, $text = true)
    {
        $params = 'state = true and play = true and ';
        $params .= 'remove = false';

        $queue = QueueList::model()->findAll([
            'select'=> 'username, count(*) as play',
            'order'=>'2 desc  LIMIT '.$limit,
            'group'=>'username',
            'condition'=>$params
        ]);
        if ($text) {
            $result = "";

            foreach ($queue as $k => $q) {
                $result .= ($k+1) .'. '. $q->username;
                $result .= ' ('.$q->play.' games), ';
            }
            return trim($result, ', ');
        } else {
            return $queue;
        }
    }

    public static function getOrder($userId, $id)
    {
        $params = 'queue_id = ' . $id . ' AND state = true and ';
        $params.= 'remove = false and play = false and ';
        $params.= 'id <= '.$userId;
        $queue = QueueList::model()->count($params);
        return $queue;
    }

    public static function getCurrent()
    {
        $queue = self::verifyOpen();
        $result = [];
        if ($queue) {
            $params = 'queue_id = ' . $queue->id . ' AND state = true';
            $params .= ' and  play = false and remove = false ';
            $params .= 'ORDER BY register_date ASC';
            return QueueList::model()->findAll($params);
        }

        return $result;
    }
}
