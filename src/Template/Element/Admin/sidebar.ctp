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
            <a href="<?= HTTP_ROOT . "admin/#/dashboard" ?>" class="btn btn-success">               
                <i class="ace-icon fa fa-signal"></i>                
            </a>
            <a href="<?= HTTP_ROOT . "admin/#/profile-setting" ?>" class="btn btn-info">               
                <i class="ace-icon fa fa-pencil"></i>               
            </a>
            <a href="<?= HTTP_ROOT . "admin/#/view-payments" ?>" class="btn btn-warning">               
               <i class="ace-icon fa fa-money"></i> <!--<i class="ace-icon fa fa-users"></i>-->               
            </a>
            <a href="<?= HTTP_ROOT . "admin/#/view-customers" ?>" class="btn btn-danger">               
                <i class="ace-icon fa fa-user"></i><!--<i class="ace-icon fa fa-cogs"></i>-->          
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

        <li <?php if (in_array($paramAction, ['dasboard'])) { ?>  class="active open"  <?php } ?> >
            <a href="<?php echo HTTP_ROOT . 'admin/#/dashboard'; ?>">
                <i class="menu-icon fa fa-tachometer"></i>
                <span class="menu-text"> Dashboard </span>
            </a>
        </li>    


        <li <?php if (in_array($paramAction, ['changePassword', 'profileSetting'])) { ?>  class="active open"  <?php } ?> >
            <a href="javascript:;" class="dropdown-toggle">
                <i class="menu-icon fa fa-pencil-square-o"></i>
                <span class="menu-text">  Account Setup </span>
                <b class="arrow fa fa-angle-down"></b>
            </a>

            <b class="arrow"></b>

            <ul class="submenu">  
                <li class="<?php if (in_array($paramAction, ['profileSetting'])) { ?>  active  <?php } ?>">
                    <a href="<?php echo HTTP_ROOT . 'admin/#/profile-setting'; ?>">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Profile Setting
                    </a>
                    <b class="arrow"></b>
                </li>

                <li class="<?php if (in_array($paramAction, ['changePassword'])) { ?>  active  <?php } ?>">
                    <a href="<?php echo HTTP_ROOT . 'admin/#/change-password'; ?>">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Change Password 
                    </a>
                    <b class="arrow"></b>
                </li>

            </ul>
        </li>

        <li <?php if (in_array($paramAction, ['addBranchAdmin', 'branchAdminListing'])) { ?>  class="active open"  <?php } ?> >
            <a href="javascript:;" class="dropdown-toggle">
                <i class="menu-icon fa fa-list"></i>
                <span class="menu-text"> Branch Admins </span>
                <b class="arrow fa fa-angle-down"></b>
            </a>
            <b class="arrow"></b>
            <ul class="submenu">
                <li class="<?php if (in_array($paramAction, ['addBranchAdmin'])) { ?>  active   <?php } ?>">
                    <a href="<?php echo HTTP_ROOT . 'admin/#/add-branch-admin'; ?>">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Add Branch Admin
                    </a>
                    <b class="arrow"></b>
                </li>

                <li class="<?php if (in_array($paramAction, ['branchAdminListing', 'viewMerchants'])) { ?>  active  <?php } ?>">
                    <a href="<?php echo HTTP_ROOT . 'admin/#/branch-admin-listing'; ?>">
                        <i class="menu-icon fa fa-caret-right"></i>
                        View All Branch Admin
                    </a>
                    <b class="arrow"></b>
                </li>
            </ul>
        </li>

        <!--
        <li <?php if (in_array($paramAction, ['viewMerchants'])) { ?>  class="active open"  <?php } ?> >
            <a href="javascript:;" class="dropdown-toggle">
                <i class="menu-icon fa fa-shopping-cart"></i>
                <span class="menu-text"> Merchants </span>
                <b class="arrow fa fa-angle-down"></b>
            </a>
            <b class="arrow"></b>
            <ul class="submenu">
                <li class="<?php if (in_array($paramAction, ['viewMerchants'])) { ?>  active  <?php } ?>">
                    <a href="<?php echo HTTP_ROOT . 'admin/#/view-merchants'; ?>">
                        <i class="menu-icon fa fa-caret-right"></i>
                        View Merchants
                    </a>
                    <b class="arrow"></b>
                </li>
            </ul>
        </li>
        -->

        <li <?php if (in_array($paramAction, ['viewMerchants'])) { ?>  class="active open"  <?php } ?> >
            <a href="<?php echo HTTP_ROOT . 'admin/#/view-merchants'; ?>" class="dropdown-toggleXX">
                <i class="menu-icon fa fa-shopping-cart"></i>
                <span class="menu-text"> Merchants </span>
                <b class="arrow fa"></b>
            </a>             
        </li>


        <!--        
        <li <?php if (in_array($paramAction, ['viewCustomers'])) { ?>  class="active open"  <?php } ?> >
               <a href="javascript:;" class="dropdown-toggle">
                   <i class="menu-icon fa fa-user"></i>
                   <span class="menu-text"> Customers </span>
                   <b class="arrow fa fa-angle-down"></b>
               </a>
               <b class="arrow"></b>
               <ul class="submenu">
                   <li class="<?php if (in_array($paramAction, ['viewCustomers'])) { ?>  active  <?php } ?>">
                       <a href="<?php echo HTTP_ROOT . 'admin/#/view-customers'; ?>">
                           <i class="menu-icon fa fa-caret-right"></i>
                           View Customers
                       </a>
                       <b class="arrow"></b>
                   </li>
               </ul>
           </li>
        -->

        <li <?php if (in_array($paramAction, ['viewCustomers'])) { ?>  class="active open"  <?php } ?> >
            <a href="<?php echo HTTP_ROOT . 'admin/#/view-customers'; ?>" class="dropdown-toggleXX">
                <i class="menu-icon fa fa-user"></i>
                <span class="menu-text"> Customers </span>
                <b class="arrow fa"></b>
            </a>             
        </li>



        <li <?php if (in_array($paramAction, ['transactions'])) { ?>  class="active open"  <?php } ?> >
            <a href="<?php echo HTTP_ROOT . 'admin/#/view-payments'; ?>" class="dropdown-toggleXX">
                <i class="menu-icon fa fa-money"></i>
                <span class="menu-text"> Payments </span>
                <b class="arrow fa"></b>
            </a>             
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