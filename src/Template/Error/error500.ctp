<?php

use Cake\Core\Configure;
use Cake\Error\Debugger;

$this->layout = '';

if (Configure::read('debug')):
    $this->layout = 'dev_error';

    $this->assign('title', $message);
    $this->assign('templateName', 'error500.ctp');

    $this->start('file');
    ?>
    <?php if (!empty($error->queryString)) : ?>
        <p class="notice">
            <strong>SQL Query: </strong>
            <?= h($error->queryString) ?>
        </p>
    <?php endif; ?>
    <?php if (!empty($error->params)) : ?>
        <strong>SQL Query Params: </strong>
        <?php Debugger::dump($error->params) ?>
    <?php endif; ?>
    <?php if ($error instanceof Error) : ?>
        <strong>Error in: </strong>
        <?= sprintf('%s, line %s', str_replace(ROOT, 'ROOT', $error->getFile()), $error->getLine()) ?>
    <?php endif; ?>
    <?php
    echo $this->element('auto_table_warning');

    if (extension_loaded('xdebug')):
        xdebug_print_function_stack();
    endif;

    $this->end();
endif;
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <meta charset="utf-8" />
        <title><?= SITE_NAME ?> : Error Page </title>
        <base href="<?= HTTP_ROOT; ?>" target="_self">
        <meta name="description" content="overview &amp; stats" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
        <!-- bootstrap & fontawesome -->
        <link rel="stylesheet" href="assets/css/bootstrap.css" />
        <link rel="stylesheet" href="components/font-awesome/css/font-awesome.css" />     
        <link rel="stylesheet" href="assets/css/ace-fonts.css" />
        <!-- ace styles -->
        <link rel="stylesheet" href="assets/css/ace.css" class="ace-main-stylesheet" id="main-ace-style" />
        <link rel="stylesheet" href="assets/css/ace-skins.css" />
        <link rel="stylesheet" href="assets/css/ace-rtl.css" />
        <link href="plugins/custom-alert-master/dist/css/custom-alert.min.css" rel="stylesheet" type="text/css"/>       
        <script src="assets/js/ace-extra.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
        <script> window.jQuery || document.write('<script src="components/jquery/dist/jquery.js"><\/script>');</script>         
    </head>
    <body class="skin-2">  
        <div class="main-container ace-save-state container" id="main-container">
            <!-- /section:basics/sidebar -->
            <div class="main-content">
                <div id="navbar" class="navbar navbar-default ace-save-state" style="background: #bbb;" >
                    <div class="main-container ace-save-state containerXX" id="main-container" style="background: #f1f1f1;">
                        <div class="merchant-header">
                            <div class="logo-left"> <a href="<?= HTTP_ROOT; ?>"><img src="img/logo/smarthub-logo.png" /></a></div>            
                            <div class="logo-center">

                            </div>
                            <div class="logo-right" style="float: right;"><a href="<?= HTTP_ROOT; ?>"><img src="img/logo/hdfc-logo.png" /></a></div>
                        </div>
                    </div>
                </div>
                <div class="main-content-inner">
                    <!-- /section:basics/content.breadcrumbs -->
                    <div class="page-content" style="min-height: 500px;">                        
                        <div class="row">
                            <div class="col-xs-12">
                                <!-- PAGE CONTENT BEGINS -->
                                <div style="text-align: center; height: 100%; background: #D4EBE3;">
                                    <a href="<?= HTTP_ROOT; ?>"><img  style="width: 100%;" src="<?php echo HTTP_ROOT . "img/404.png" ?>" /></a>
                                </div>
                                <!--<div class="hr hr-24"></div>-->
                            </div><!-- /.col -->
                        </div><!-- /.row -->    

                    </div><!-- /.page-content -->
                </div>
            </div><!-- /.main-content -->
            <div class="footer">
                <div class="footer-inner">
                    <!-- #section:basics/footer -->
                    <div class="footer-content">
                        <span class="bigger-120">
                            <a href="<?= HTTP_ROOT; ?>"><span class="blue bolder"><?= SITE_NAME ?></span></a>
                            Application &copy; 2016            
                        </span>                      
                    </div>                  
                </div>
            </div>
        </div><!-- /.main-container -->      
        <script src="components/bootstrap/dist/js/bootstrap.js"></script>
        <script src="assets/js/src/ace.js"></script>
        <script src="assets/js/src/ace.basics.js"></script>
        <script src="assets/js/src/ace.sidebar.js"></script>
    </body>
</html>


