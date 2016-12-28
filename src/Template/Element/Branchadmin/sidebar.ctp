<?php $paramAction = $this->request->params['action']; ?>
<div id="sidebar" class="sidebar responsive ace-save-state">
    <div class="profile-pic">
        <span class="img-section"><img src="<?= HTTP_ROOT . 'img/profile-img.png'; ?>" alt="" /></span>
        <h3 class="profile-name">Hi <?= $loginDetails['name'] ?> </h3>
        <div class="profile-login-info">Welcome to Branch Admin Panel <br/>Last Login : <?= date('M d, Y H:i A', strtotime($loginDetails['last_login_date'])) ?></div>
    </div>
    <!--<div class="sidebar-" style="background: #FFF; min-height: 9px;"> </div>-->

    <ul class="nav nav-list">
        <li class="nav-list-2 active open">
            <a href="branchadmin/#/dashboard">
                <i class="menu-icon fa fa-list"></i>
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
                    <a href="branchadmin/#/profile-setting">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Profile Setting
                    </a>

                    <b class="arrow"></b>
                </li>

                <li class="">
                    <a href="branchadmin/#/change-password">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Change Password 
                    </a>
                    <b class="arrow"></b>
                </li>

            </ul>
        </li>      

        <li <?php if (in_array($paramAction, ['addMerchant', 'merchantListing'])) { ?>  class="active open"  <?php } ?> >
            <a href="javascript:;" class="dropdown-toggle">
                <i class="menu-icon fa fa-list"></i>
                <span class="menu-text"> Manage Merchant </span>
                <b class="arrow fa fa-angle-down"></b>
            </a>
            <b class="arrow"></b>
            <ul class="submenu">
                <li class="<?php if (in_array($paramAction, ['addNewMerchant'])) { ?>  active   <?php } ?>">
                    <a href="<?php echo HTTP_ROOT . 'branchadmin/#/add-new-merchant'; ?>">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Add New Merchant
                    </a>
                    <b class="arrow"></b>
                </li>

                <li class="<?php if (in_array($paramAction, ['viewAllMerchant', 'merchantListing'])) { ?>  active  <?php } ?>">
                    <a href="<?php echo HTTP_ROOT . 'branchadmin/#/view-all-merchant'; ?>">
                        <i class="menu-icon fa fa-caret-right"></i>
                        View All Merchant
                    </a>
                    <b class="arrow"></b>
                </li>
            </ul>
        </li>           

        <?php /* ?>


          <li <?php if (in_array($paramAction, ['addBranchAdmin', 'branchAdminListing'])) { ?>  class="active open"  <?php } ?> >
          <a href="javascript:;" class="dropdown-toggle">
          <i class="menu-icon fa fa-list"></i>
          <span class="menu-text"> Branch Admins </span>
          <b class="arrow fa fa-angle-down"></b>
          </a>
          <b class="arrow"></b>
          <ul class="submenu">
          <li class="<?php if (in_array($paramAction, ['addBranchAdmin'])) { ?>  active   <?php } ?>">
          <a href="<?php echo HTTP_ROOT . 'branchadmin/#/add-branch-admin'; ?>">
          <i class="menu-icon fa fa-caret-right"></i>
          Add Branch Admin
          </a>
          <b class="arrow"></b>
          </li>

          <li class="<?php if (in_array($paramAction, ['branchAdminListing', 'viewMerchants'])) { ?>  active  <?php } ?>">
          <a href="<?php echo HTTP_ROOT . 'branchadmin/#/branch-admin-listing'; ?>">
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
          <a href="<?php echo HTTP_ROOT . 'branchadmin/#/view-merchants'; ?>">
          <i class="menu-icon fa fa-caret-right"></i>
          View Merchants
          </a>
          <b class="arrow"></b>
          </li>
          </ul>
          </li>
          -->

          <li <?php if (in_array($paramAction, ['viewMerchants'])) { ?>  class="active open"  <?php } ?> >
          <a href="<?php echo HTTP_ROOT . 'branchadmin/#/view-merchants'; ?>" class="dropdown-toggleXX">
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
          <a href="<?php echo HTTP_ROOT . 'branchadmin/#/view-customers'; ?>">
          <i class="menu-icon fa fa-caret-right"></i>
          View Customers
          </a>
          <b class="arrow"></b>
          </li>
          </ul>
          </li>
          -->

          <li <?php if (in_array($paramAction, ['viewCustomers'])) { ?>  class="active open"  <?php } ?> >
          <a href="<?php echo HTTP_ROOT . 'branchadmin/#/view-customers'; ?>" class="dropdown-toggleXX">
          <i class="menu-icon fa fa-user"></i>
          <span class="menu-text"> Customers </span>
          <b class="arrow fa"></b>
          </a>
          </li>



          <li <?php if (in_array($paramAction, ['transactions'])) { ?>  class="active open"  <?php } ?> >
          <a href="<?php echo HTTP_ROOT . 'branchadmin/#/view-payments'; ?>" class="dropdown-toggleXX">
          <i class="menu-icon fa fa-money"></i>
          <span class="menu-text"> Payments </span>
          <b class="arrow fa"></b>
          </a>
          </li>
          <?php */ ?>

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