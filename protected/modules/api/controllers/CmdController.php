<?php

class CmdController extends Controller {
    /*
      !open - command is used to open the queue.
      Output to chat will be "Queue is now opened"
      unless it is already open then it will say
      "Queue is already open".
     */

    public function actionOpen() {
        $isOpen = QQueue::verifyOpen();
        if ($isOpen) {
            echo UQueue::MSG_ALREADYOPEN;
            Yii::app()->end();
        }
        $user = Yii::app()->request->getQuery('user', false);
        $q = new Queue();
        $q->username = ($user ? $user : 'neonpuddles');
        $q->queue_start = date('Y-m-d H:i:s');
        if ($q->save()) {
            echo UQueue::MSG_NOWOPEN;
        } else {
            echo UQueue::MSG_ERROR;
        }
    }

    /*
      !close - command is used to open the queue.
      The queue will function completely normal
      except that users can not join the queue any
      longer. Sometimes the queue is closed early
      to stop new people from joining.

      Chat output: "Queue has been closed".
      If it is open already closed "Queue is already closed".
     */

    public function actionClose() {
        $isOpen = QQueue::verifyOpen();
        if (!$isOpen) {
            echo UQueue::MSG_ALREADYCLOSE;
            Yii::app()->end();
        }
        $isOpen->queue_finish = date('Y-m-d H:i:s');
        if ($isOpen->save()) {
            echo UQueue::MSG_NOWCLOSED;
        } else {
            echo UQueue::MSG_ERROR;
        }
    }

    /*
      !join - User uses this to join the queue
      (unless it's closed), whether or not it is
      sub only is decided in the streamelements
      custom command area. User can add a comment
      which will show in the web list beside their
      name (if there is a comment) and also will
      show in chat when the !next command is used.
      User can only join the queue once, no duplicates.

      Output to chat will be "Added <twitch name>
      to queue. Your position is currently #".
      Or if they're already in the queue
      "You are already in the queue, your position is #"
      If thequeue is closed: "Queue is closed, you can not join it."
     */

    public function actionJoin() {
        $user = Yii::app()->request->getQuery('user', false);
        if (!$user) {
            echo UQueue::MSG_ERROR;
            Yii::app()->end();
        }

        $isOpen = QQueue::verifyOpen();
        if (!$isOpen) {
            echo UQueue::MSG_CLOSEONJOIN;
            Yii::app()->end();
        }

        $alreadyIn = QQueue::checkAlreadyIn($user, $isOpen->id);
        if ($alreadyIn) {
            $orden = QQueue::getOrder($alreadyIn->id, $isOpen->id);
            echo str_replace(['{order}', '{user}'], [$orden, $user], UQueue::MSG_ALREADYIN);
            Yii::app()->end();
        }
        $args = Yii::app()->request->getQuery('args', null);
        $q = new QueueList();
        $q->queue_id = $isOpen->id;
        $q->username = $user;
        $q->args = ($args != '$null' ? $args : null);
        $q->register_date = date('Y-m-d H:i:s');
        $q->order = 0;
        if ($q->save()) {
            $q->order = QQueue::getOrder($q->id, $isOpen->id);
            $q->update();
            echo str_replace(['{order}', '{user}'], [$q->order, $user], UQueue::MSG_ADDED);
        } else {
            echo UQueue::MSG_ERROR;
        }
    }

    /*
      !leave - User can use this to leave the queue.
      Output to chat: You have left the queue.
      If they are not in the queue: You are not currently in the queue
     */

    public function actionLeave() {
        $user = Yii::app()->request->getQuery('user', false);
        if (!$user) {
            echo UQueue::MSG_ERROR;
            Yii::app()->end();
        }

        $isOpen = QQueue::verifyOpen();
        if (!$isOpen) {
            echo UQueue::MSG_CLOSEONLEAVE;
            Yii::app()->end();
        }

        $alreadyIn = QQueue::checkAlreadyIn($user, $isOpen->id);
        if (!$alreadyIn) {
            echo str_replace('{user}', $user, UQueue::MSG_NOTIN);
            Yii::app()->end();
        }

        $alreadyIn->remove = 1;

        if ($alreadyIn->save()) {
            echo str_replace('{user}', $user, UQueue::MSG_LEFT);
        } else {
            echo UQueue::MSG_ERROR;
        }
    }

    /*
      !clear - This clears the queue entirely.
      Will be a moderator only command set via the
      streamelements custom command setting.

      Chat output: Queue has been cleared.
     */

    public function actionClear() {
        $isOpen = QQueue::verifyOpen();
        if (!$isOpen) {
            echo UQueue::MSG_CLOSEONCLEAR;
            Yii::app()->end();
        }
        QueueList::model()->updateAll(['remove' => 1], 'queue_id = ' . $isOpen->id);
        echo UQueue::MSG_CLEARED;
    }

    /*
      !bottom - User can use this to bump themselves
      down to the bottom of the list. ie: If they're
      first and there's 4 people in queue, they are
      now the 4th place in queue and the person who was 2nd is now 1st.

      Output to chat will be: You have been moved to
      the bottom of the queue, your position is now #.
      If they are not in the queue: You are currently
      not in the queue, use !join if you'd like to join the queue.
     */

    public function actionBottom() {
        $user = Yii::app()->request->getQuery('user', false);
        if (!$user) {
            echo UQueue::MSG_ERROR;
            Yii::app()->end();
        }

        $isOpen = QQueue::verifyOpen();
        if (!$isOpen) {
            echo UQueue::MSG_ALREADYCLOSE;
            Yii::app()->end();
        }

        $alreadyIn = QQueue::checkAlreadyIn($user, $isOpen->id);
        if (!$alreadyIn) {
            echo str_replace('{user}', $user, UQueue::MSG_NOTIN);
            Yii::app()->end();
        }

        $alreadyIn->remove = 1;

        if ($alreadyIn->save()) {
            $q = new QueueList();
            $q->queue_id = $isOpen->id;
            $q->username = $user;
            $q->args = $alreadyIn->args;
            $q->register_date = date('Y-m-d H:i:s');
            $q->order = 0;
            if ($q->save()) {
                $q->order = QQueue::getOrder($q->id, $isOpen->id);
                $q->update();
                echo str_replace(['{order}', '{user}'], [$q->order, $user], UQueue::MSG_NEWORDER);
            } else {
                echo UQueue::MSG_ERROR;
            }
        } else {
            echo UQueue::MSG_ERROR;
        }
    }

    /*
      !remove Twitchname - this removes the specified
      twitch name from the queue. Also a mod only command
      set via the stream elements custom command setting.

      Chat output: Twitchname has been removed from the queue.
      If the user is not in the queue the chat output
      would be: Twitchname is not currently in the queue
      so they can not be removed.
     */

    public function actionRemove() {
        $user = Yii::app()->request->getQuery('user', false);
        if (!$user) {
            echo UQueue::MSG_ERROR;
            Yii::app()->end();
        }

        $isOpen = QQueue::verifyOpen();
        if (!$isOpen) {
            echo UQueue::MSG_ALREADYCLOSE;
            Yii::app()->end();
        }

        $alreadyIn = QQueue::checkAlreadyIn($user, $isOpen->id);
        if (!$alreadyIn) {
            echo str_replace('{user}', $user, UQueue::MSG_NOTIN);
            Yii::app()->end();
        }

        $alreadyIn->remove = 1;

        if ($alreadyIn->save()) {
            echo str_replace('{user}', $user, UQueue::MSG_LEFT);
        } else {
            echo UQueue::MSG_ERROR;
        }
    }

    /*
      !next - This removes the #1 position person
      from the queue and prints their twitch name
      (and comment if they added one with !join)
      to chat. Also a mod only command set via the
      stream elements custom command setting.

      Chat output: The next person in queue is:
      TwitchName - "Comment" (the - "Comment"
      would only show IF the user added a comment).
      If there is no one in queue the chat output
      would be: The queue is currently empty.
     */

    public function actionNext() {
        $isOpen = QQueue::verifyOpen();
        if (!$isOpen) {
            echo UQueue::MSG_ALREADYCLOSE;
            Yii::app()->end();
        }

        $next = QQueue::getNext($isOpen->id);

        if ($next) {
            $next->play = 1;

            if ($next->save()) {
                $args = ($next->args != null) ? ' - "' . $next->args . '"' : '';
                $user = $next->username . $args;
                echo str_replace('{user}', $user, UQueue::MSG_NEXT);
            } else {
                echo UQueue::MSG_ERROR;
            }
        } else {
            echo UQueue::MSG_NOONE;
        }
    }

    /*
      !mostplayed - This shows the top 5 people who have
      played with neon in the chat. Note: The # of times
      someone has played with neon SHOULD NOT be how many
      times they have used !join. It should only be how
      many times their name has shown up in "!next".
      This is to prevent !join / !leave abuse to make
      their count go up.

      Chat output: Most games played: 1. mcgriever
      (131 games), 2. thisuser (91 games), 3. thatuser
      (54 games), 4. anotheruser (32 games), 5. mysuer
      (29 games).
     */

    public function actionMostPlayed() {
        $most = QQueue::getMostPlayed();
        echo "Most games played: " . $most;
    }

}
