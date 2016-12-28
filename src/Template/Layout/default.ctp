<!DOCTYPE html>
<html lang="en">
    <head>     
        <title><?= SITE_NAME ?> : <?= $this->fetch('title') ?></title>      
        <base href="<?= HTTP_ROOT; ?>" target="_self">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <meta charset="utf-8" />        
        <meta name="description" content="overview &amp; stats" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

        <!-- bootstrap & fontawesome -->
        <link rel="stylesheet" href="assets/css/bootstrap.css" />
        <link rel="stylesheet" href="components/font-awesome/css/font-awesome.css" />      
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
        <style>
            /*******Succes & Error Message Start*******/
            div.message::before {
                background-color: #fff;
                border-radius: 15px;
                color: #1AAF65;
                content: "i";
                display: inline-block;
                font-size: 16px;
                left: -11px;
                padding: 2px 11px 2px 5px;
                position: relative;
                text-align: center;
                vertical-align: middle;
                width: 12px;
            }
            div.message {
                background-color: #1AAF65;
                color: #FFF;
                cursor: pointer;
                display: block;
                font-size: 13px;
                font-weight: normal;
                overflow: hidden;
                padding: 5px 15px;
                position: relative !important;
                left: 0;
                top: -10px;              
                transition: height 300ms ease-out 0s;
                z-index: 999;
            }
            div.message.error {
                background-color: #C3232D;
                color: #FFF;
            }
            div.message.error:before {   
                color: #C3232D;
                content: "x";
            }
            .logo-row-1 {
                width: 100%;
                float: left;
                padding: 10px;
            }
        </style>
    </head>
    <body class="skin-2">   
        <div class="main-container ace-save-state container" id="main-container">
            <?= $this->Flash->render() ?>  
            <div class="main-content"> 
                <?= $this->fetch('content') ?>
            </div><!-- /.main-content -->
            <?= $this->element('footer'); ?>
            <a href="javascript:;" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
                <i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
            </a>
        </div><!-- /.main-container -->
        <script src="components/bootstrap/dist/js/bootstrap.js"></script>
        <script src="assets/js/src/ace.js"></script>
        <script src="assets/js/src/ace.basics.js"></script>
        <script src="assets/js/src/ace.sidebar.js"></script>
        <script src="js/common.js"></script>
    </body>
</html>

