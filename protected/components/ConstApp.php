<?php
class ConstApp
{
    const URLAPI = "https://api.streamelements.com/kappa/v2/";
    const JWTTOKEN = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eJ1c2VyIjoiNWQ3ZjkxYjc4Nzg2ZmI2MTNjOGYwZDc5IiwiY2hhbm5lbCI6IjVkMjI3MjBhNWRlMTA4MTMzNzc5OWEwNiIsInJvbGUiOiJvd25lciIsImF1dGhUb2tlbiI6Im1Cekh2LUNnd0Zkd29BTmRkT1FZU2FhdkpEYVFiSndKS1lQN2hnQThIOF9FekxDQyIsImlhdCI6MTU4MzQzNzQwNiwiaXNzIjoiU3RyZWFtRWxlbWVudHMifQ.uNbdtChz8xTOyiOQzw3pQzW-uf8xqUehuvxxtvaBhRY";
    const CLIENID = "5d22720a5de1081337799a0";

    const MSG_ERROR = "Something happen, please try again";
    const MSG_ALREADYOPEN = "Queue is already open";
    const MSG_NOWOPEN = "Queue is now opened";
    const MSG_NOWCLOSED = "Queue has been closed";
    const MSG_ALREADYCLOSE = "Queue is already closed";
    const MSG_CLOSEONJOIN = "Queue is closed, you can not join it";
    const MSG_CLOSEONLEAVE = "Queue is closed, you can not leave it";
    const MSG_CLOSEONCLEAR = "Queue is closed, you can not clear it";
    const MSG_CLEARED = "Queue has been cleared";
    const MSG_ALREADYIN = "{user}, you are already in the queue, your position is #{order}";
    const MSG_ADDED = "Added {user} to queue. Your position is currently #{order}";
    const MSG_NOTIN  = "{user}, you are not currently in the queue";
    const MSG_LEFT  = "{user}, have left the queue";
    const MSG_NEWORDER  = "{user}, you have been moved to the bottom of the queue, your position is now #{order}";
    const MSG_NEXT = "The next person in queue is: {user}";
    const MSG_NOONE = "The queue is currently empty";
}
