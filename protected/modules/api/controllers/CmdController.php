<?php

class CmdController extends Controller
{
    /*
    !open - command is used to open the queue.
    Output to chat will be "Queue is now opened"
     unless it is already open then it will say
      "Queue is already open".
    */
    public function actionOpen()
    {
        $arr = ['id'=>1];
        echo json_encode($arr);
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
    public function actionClose()
    {
        $arr = ['id'=>1];
        echo json_encode($arr);
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
    public function actionJoin()
    {
        $arr = ['id'=>1];
        echo json_encode($arr);
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
    public function actionBottom()
    {
        $arr = ['id'=>1];
        echo json_encode($arr);
    }

    /*
    !leave - User can use this to leave the queue.
    Output to chat: You have left the queue.
    If they are not in the queue: You are not currently in the queue
    */
    public function actionLeave()
    {
        $arr = ['id'=>1];
        echo json_encode($arr);
    }


    /*
    !clear - This clears the queue entirely.
    Will be a moderator only command set via the
    streamelements custom command setting.

    Chat output: Queue has been cleared.
    */
    public function actionClear()
    {
        $arr = ['id'=>1];
        echo json_encode($arr);
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
    public function actionNext()
    {
        $arr = ['id'=>1];
        echo json_encode($arr);
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
    public function actionRemove()
    {
        $arr = ['id'=>1];
        echo json_encode($arr);
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
    public function actionMostPlayed()
    {
        $arr = ['id'=>1];
        echo json_encode($arr);
    }
    
    /*
    !list - This just prints a URL to the webpage that shows
    the current queue and top 10 most played/queued users.

    Chat output: https://neonpuddles.com/queue/

    I have attached a rough output that would be shown
    on the webpage - you do not need to worry about css styling
     or anything, I can do that after it is finished.
    */
    public function actionList()
    {
        $arr = ['id'=>1];
        echo json_encode($arr);
    }
}
