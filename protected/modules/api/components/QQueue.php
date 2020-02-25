<?php

class QQueue {

    public static function verifyOpen() {
        $params = 'state = true and queue_finish is null';
        $queue = Queue::model()->find($params);
        if ($queue) {
            return $queue;
        }
        return false;
    }

    public static function checkAlreadyIn($username, $id) {
        $params = 'queue_id = ' . $id . ' AND state = true and ';
        $params .= 'username = "' . $username . '" and play = false ';
        $params .= 'and remove = false';

        $queue = QueueList::model()->find($params);
        if ($queue) {
            return $queue;
        }
        return false;
    }

    public static function getOrder($id) {
        $params = 'queue_id = ' . $id . ' AND state = true and ';
        $params.= 'remove = false and play = false ';
        $queue = QueueList::model()->count($params);
        return $queue + 1;
    }

}
