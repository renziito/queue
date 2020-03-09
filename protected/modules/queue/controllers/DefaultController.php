<?php

class DefaultController extends Controller {

    /**
     * To change the view you have to edit
     * protectec /modules/queue/default/index.php
     */
    public function actionIndex() {
        $this->render('index', [
            'current' => QQueue::getCurrent(),
            'top' => QQueue::getMostPlayed(10, false)
        ]);
    }

}
