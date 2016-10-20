<?php $paramAction = $this->request->params['action']; ?>

<div id="sidebar" class="sidebar responsive ace-save-state">
    <script type="text/javascript">
        try {
            ace.settings.loadState('sidebar')
        } catch (e) {
        }
    </script>

    <div class="sidebar-shortcuts" id="sidebar-shortcuts">
        <div class="sidebar-shortcuts-large" id="sidebar-shortcuts-large">

            <a href="<?= HTTP_ROOT . "branchadmin" ?>" class="btn btn-success">
                <i class="ace-icon fa fa-signal"></i>
            </a> 

            <a href="<?= HTTP_ROOT . "branchadmin/profile-setting" ?>" class="btn btn-info">
                <i class="ace-icon fa fa-pencil"></i>
            </a>     

            <a href="<?= HTTP_ROOT . "branchadmin/change-password" ?>" class="btn btn-warning"> 
                <i class="ace-icon fa fa-users"></i>
            </a> 

            <a href="<?= HTTP_ROOT . "branchadmin/view-merchants/1" ?>" class="btn btn-danger"> 
                <i class="ace-icon fa fa-cogs"></i>
            </a> 

            <!-- /section:basics/sidebar.layout.shortcuts -->
        </div>

        <div class="sidebar-shortcuts-mini" id="sidebar-shortcuts-mini">
            <span class="btn btn-success"></span>

            <span class="btn btn-info"></span>

            <span class="btn btn-warning"></span>

            <span class="btn btn-danger"></span>
        </div>
    </div><!-- /.sidebar-shortcuts -->

    <ul class="nav nav-list">

        <li <?php if (in_array($paramAction, ['dashboard'])) { ?>  class="active open"  <?php } ?> >
            <a href="<?php echo HTTP_ROOT . 'branchadmin'; ?>">
                <i class="menu-icon fa fa-tachometer"></i>
                <span class="menu-text"> Dashboard </span>
            </a>
        </li>   

        <li <?php if (in_array($paramAction, ['profileSetting', 'changePassword'])) { ?>  class="active open"  <?php } ?> >
            <a href="javascript:;" class="dropdown-toggle">
                <i class="menu-icon fa fa-cogs"></i>
                <span class="menu-text">  Account Setting </span>
                <b class="arrow fa fa-angle-down"></b>
            </a>

            <b class="arrow"></b>

            <ul class="submenu">
                <li class="<?php if (in_array($paramAction, ['profileSetting'])) { ?>  active  <?php } ?>">
                    <a href="<?php echo HTTP_ROOT . 'branchadmin/profile-setting'; ?>">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Profile Setting
                    </a>
                    <b class="arrow"></b>
                </li>
                <li class="<?php if (in_array($paramAction, ['changePassword'])) { ?>  active  <?php } ?>">
                    <a href="<?php echo HTTP_ROOT . 'branchadmin/change-password'; ?>">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Change Password 
                    </a>
                    <b class="arrow"></b>
                </li>

            </ul>
        </li>   

        <!--
        <li <?php if (in_array($paramAction, ['viewMerchants'])) { ?>  class="active open"  <?php } ?> >
            <a href="javascript:;" class="dropdown-toggle">
                <i class="menu-icon fa fa-list"></i>
                <span class="menu-text"> Merchants </span>
                <b class="arrow fa fa-angle-down"></b>
            </a>
            <b class="arrow"></b>
            <ul class="submenu">
                <li class="<?php if (in_array($paramAction, ['viewMerchants'])) { ?>  active  <?php } ?>">
                    <a href="<?php echo HTTP_ROOT . 'branchadmin/view-merchants/1'; ?>">
                        <i class="menu-icon fa fa-caret-right"></i>
                        View Merchants
                    </a>
                    <b class="arrow"></b>
                </li>
            </ul>
        </li>
        -->

        <li <?php if (in_array($paramAction, ['viewMerchants'])) { ?>  class="active open"  <?php } ?> >
            <a href="<?php echo HTTP_ROOT . 'branchadmin/view-merchants/1'; ?>">
                <i class="menu-icon fa fa-user"></i>
                <span class="menu-text"> Merchants </span>
            </a>
        </li>

        <!--
        <li <?php if (in_array($paramAction, ['viewCustomers'])) { ?>  class="active open"  <?php } ?> >
            <a href="javascript:;" class="dropdown-toggle">
                <i class="menu-icon fa fa-list"></i>
                <span class="menu-text"> Customers </span>
                <b class="arrow fa fa-angle-down"></b>
            </a>
            <b class="arrow"></b>
            <ul class="submenu">
                <li class="<?php if (in_array($paramAction, ['viewCustomers'])) { ?>  active  <?php } ?>">
                    <a href="<?php echo HTTP_ROOT . 'branchadmin/view-customers/1'; ?>">
                        <i class="menu-icon fa fa-caret-right"></i>
                        View Customers
                    </a>
                    <b class="arrow"></b>
                </li>
            </ul>
        </li>         
        -->

        <li <?php if (in_array($paramAction, ['viewCustomers'])) { ?>  class="active open"  <?php } ?> >
            <a href="<?php echo HTTP_ROOT . 'branchadmin/view-customers/1'; ?>">
                <i class="menu-icon fa fa-user"></i>
                <span class="menu-text"> Customers </span>
            </a>
        </li>

        <li>
            <a href="<?php echo HTTP_ROOT . 'logout'; ?>">
                <i class="menu-icon fa fa-power-off"></i>
                <span class="menu-text"> Logout </span>
            </a>
        </li>


    </ul><!-- /.nav-list -->

    <!-- #section:basics/sidebar.layout.minimize -->
    <div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
        <i id="sidebar-toggle-icon" class="ace-icon fa fa-angle-double-left ace-save-state" data-icon1="ace-icon fa fa-angle-double-left" data-icon2="ace-icon fa fa-angle-double-right"></i>
    </div>

    <!-- /section:basics/sidebar.layout.minimize -->
</div>