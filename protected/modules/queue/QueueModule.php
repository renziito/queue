<?php

class QueueModule extends CWebModule {

    public function init() {
        $this->setImport(array(
            'queue.models.*',
            'queue.components.*',
            'cmd.components.*'
        ));
    }

    public function beforeControllerAction($controller, $action) {
        if (parent::beforeControllerAction($controller, $action)) {
            return true;
        } else
            return false;
    }

}
