<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <meta charset="utf-8" />
        <title><?= SITE_NAME ?> : Branch Admin Panel</title>
        <base href="<?= HTTP_ROOT; ?>" target="_self">
        <meta name="description" content="overview &amp; stats" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

        <!-- bootstrap & fontawesome -->
        <link rel="stylesheet" href="assets/css/bootstrap.css" />
        <link rel="stylesheet" href="components/font-awesome/css/font-awesome.css" />
        <!-- page specific plugin styles -->  
        <!-- text fonts -->
        <link rel="stylesheet" href="assets/css/ace-fonts.css" />

        <!-- ace styles -->
        <link rel="stylesheet" href="assets/css/ace.css" class="ace-main-stylesheet" id="main-ace-style" />

        <link rel="stylesheet" href="assets/css/ace-skins.css" />
        <link rel="stylesheet" href="assets/css/ace-rtl.css" />
        <link rel="stylesheet" href="assets/css/ace-themes.css" />
        
        <link href="plugins/custom-alert-master/dist/css/custom-alert.min.css" rel="stylesheet" type="text/css"/>
        <!-- inline styles related to this page -->
        <!-- ace settings handler -->
        <script src="assets/js/ace-extra.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
        <script> window.jQuery || document.write('<script src="components/jquery/dist/jquery.js"><\/script>');</script>        
        <!--<script src="components/jquery/dist/jquery.js"></script>-->
        <?php echo $this->element('script_file'); ?>    
    </head>

    <body class="skin-3 no-skin">
        <!-- #section:basics/navbar.layout -->
        <?php echo $this->element('Branchadmin/header'); ?>        
        <!-- /section:basics/navbar.layout -->
        <div class="main-container ace-save-state" id="main-container">           
            <?= $this->Flash->render() ?>
            <?= $this->element('Branchadmin/sidebar'); ?>
            <?= $this->fetch('content') ?>       
            <?= $this->element('footer'); ?>
            <a href="javascript:;" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
                <i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
            </a>
        </div><!-- /.main-container -->

        <!-- basic scripts -->
        <script src="components/bootstrap/dist/js/bootstrap.js"></script>
        <script src="components/chosen/chosen.jquery.js"></script>

        <script src="assets/js/src/ace.js"></script>
        <script src="assets/js/src/ace.basics.js"></script>
        <script src="assets/js/src/ace.sidebar.js"></script>

        <!-- inline scripts related to this page -->
        <script src="js/common.js"></script>
        <script src="plugins/custom-alert-master/dist/js/custom-alert.min.js"></script>    
    </body>
</html>