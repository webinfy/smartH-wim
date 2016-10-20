<?php $paramAction = $this->request->params['action']; ?>

<div  id="sidebar" class="sidebar responsive ace-save-state">
    <script type="text/javascript">
        try {
            ace.settings.loadState('sidebar')
        } catch (e) {
        }
    </script>
    
  <!--<div class="sidebar-" style="background: #FFF; min-height: 9px;"> </div>-->
 
     <ul class="nav nav-list">

        <li class="nav-list-2 active open">
            <a href="merchant/#/dashboard">
                <i class="menu-icon fa fa-tachometer"></i>
                <span class="menu-text"> Dashboard </span>
            </a>
        </li>    

        <li class="nav-list-2">
            <a href="javascript:;" class="dropdown-toggle">
                <i class="menu-icon fa fa-list"></i>
                <span class="menu-text">  Account Setup </span>
                <b class="arrow fa fa-angle-down"></b>
            </a>

            <b class="arrow"></b>

            <ul class="submenu">
                <li class="">
                    <a href="merchant/#/profile-setting">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Profile Setting
                    </a>

                    <b class="arrow"></b>
                </li>

                <li class="">
                    <a href="merchant/#/change-password">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Change Password 
                    </a>
                    <b class="arrow"></b>
                </li>

            </ul>
        </li>

        <li class="nav-list-2">
            <a href="javascript:;" class="dropdown-toggle">
                <i class="menu-icon fa fa-money"></i>
                <span class="menu-text"> Payments </span>
                <b class="arrow fa fa-angle-down"></b>
            </a>

            <b class="arrow"></b>

            <ul class="submenu">          

                <li class="">
                    <a href="merchant/#/import-payments">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Import From Excel
                    </a>
                    <b class="arrow"></b>
                </li>

                <li class="">
                    <a href="merchant/#/view-payment-files">
                        <i class="menu-icon fa fa-caret-right"></i>
                        View Payment Uploads
                    </a>
                    <b class="arrow"></b>
                </li>

            </ul>
        </li>

        <li>
            <a href="<?php echo HTTP_ROOT . 'logout'; ?>">
                <i class="menu-icon fa fa-power-off"></i>
                <span class="menu-text"> Logout </span>
            </a>
        </li>

    </ul>

    <!-- /.nav-list -->

    <!-- #section:basics/sidebar.layout.minimize -->
    <div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
        <i id="sidebar-toggle-icon" class="ace-icon fa fa-angle-double-left ace-save-state" data-icon1="ace-icon fa fa-angle-double-left" data-icon2="ace-icon fa fa-angle-double-right"></i>
    </div>

    <!-- /section:basics/sidebar.layout.minimize -->
</div>