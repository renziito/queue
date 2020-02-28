<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html>
    <head>
        <?php $this->renderPartial('//layouts/sections/_header'); ?>
    </head>
    <body class="fixed-header menu-pin menu-behind menu-pin">
        <div class="page-container ">
            <div class="page-content-wrapper ">
                <div class="content ">
                    <div class="container-fluid container-fixed-lg sm-p-l-10 sm-p-r-10">
                        <?= $content ?>
                    </div>
                </div>

                <div class=" container-fluid  container-fixed-lg footer">
                    <div class="copyright sm-text-center">
                        <p class="small no-margin pull-right sm-pull-reset">
                            <span class="hint-text">Copyright &copy; <?= date('Y') ?> </span>
                            <span class="font-montserrat"><?= $_SERVER['HTTP_HOST'] ?></span>.
                            <span class="hint-text">All rights reserved. </span>
                            <span class="hint-text">Made with Love <i class="fas fa-heart text-danger"></i></span>
                        </p>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            $(document).ready(function () {
                var Global = {
                    module: '<?= ($this->module) ? $this->module->id : '' ?>',
                    controller: '<?= $this->id ?>',
                    action: '<?= $this->action->id ?>',
                    absoluteUrl: '<?= Yii::app()->getBaseUrl(true) ?>',
                    baseUrl: '<?= Yii::app()->baseUrl ?>',
                };

            });
            
        </script>
    </body>
</html>