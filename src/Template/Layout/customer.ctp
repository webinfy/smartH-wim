<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <meta charset="utf-8" />
        <title>SmartHub</title>

        <base href="<?= HTTP_ROOT; ?>" target="">
        <meta name="description" content="overview &amp; stats" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

        <!-- bootstrap & fontawesome -->
        <link rel="stylesheet" href="assets/css/bootstrap.css" />
        <link rel="stylesheet" href="components/font-awesome/css/font-awesome.css" />
        <!-- page specific plugin styles -->
        <!--<link rel="stylesheet" href="components/bootstrap-duallistbox/dist/bootstrap-duallistbox.css" />-->
        <!-- text fonts -->
        <link rel="stylesheet" href="assets/css/ace-fonts.css" />
        <link rel="stylesheet" href="assets/css/ace.css" class="ace-main-stylesheet" id="main-ace-style" />
        <link rel="stylesheet" href="assets/css/ace-skins.css" />
        <link rel="stylesheet" href="assets/css/ace-rtl.css" />
        <!-- ace settings handler -->
        <script src="assets/js/ace-extra.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
        <script> window.jQuery || document.write('<script src="components/jquery/dist/jquery.js"><\/script>');</script>     
        <?php echo $this->element('script_file'); ?>
    </head>

    <body class="skin-3 no-skin">
        <?php echo $this->element('Customer/header'); ?>

        <div class="main-container ace-save-state container" id="main-container">

            <script type="text/javascript">
                try {
                    ace.settings.loadState('main-container')
                } catch (e) {
                }
            </script>      

            <?= $this->Flash->render() ?>
            <?= $this->element('Customer/sidebar'); ?>
            <?= $this->fetch('content') ?>
            <?= $this->element('footer'); ?>

            <a href="javascript:;" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
                <i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
            </a>
        </div><!-- /.main-container -->

        <!--<script src="components/jquery/dist/jquery.js"></script>-->
        <script src="components/bootstrap/dist/js/bootstrap.js"></script>

        <script src="assets/js/src/ace.js"></script>
        <script src="assets/js/src/ace.basics.js"></script>
        <script src="assets/js/src/ace.sidebar.js"></script>

        <!-- inline scripts related to this page -->
        <script type="text/javascript">
                jQuery(function ($) {
                    $('[data-rel=tooltip]').tooltip({container: 'body'});
                    $('[data-rel=popover]').popover({container: 'body'});
                });
        </script>
    </body>
</html>
