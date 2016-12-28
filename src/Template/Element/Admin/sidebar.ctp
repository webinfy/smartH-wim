<?php $paramAction = $this->request->params['action']; ?>
<div id="sidebar" class="sidebar responsive ace-save-state" style="min-height: 600px;">

    <div class="profile-pic">
        <!--<span class="img-section"><img src="img/profile-img.png" alt="" /></span>-->
        <h3 class="profile-name">Hi <?= $loginDetails['name'] ?> </h3>
        <div class="profile-login-info">Welcome to Admin Panel <br/>Last Login : <?= date('M d, Y H:i A', strtotime($loginDetails['last_login_date'])) ?></div>
    </div>

    <!--<div class="sidebar-" style="background: #FFF; min-height: 9px;"> </div>-->

    <ul class="nav nav-list">
        <li class="nav-list-2 active open">
            <a href="admin/#/dashboard">
                <i class="menu-icon fa fa-dashboard"></i>
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
                    <a href="admin/#/profile-setting">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Profile Setting
                    </a>
                    <b class="arrow"></b>
                </li>
                <li class="">
                    <a href="admin/#/change-password">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Change Password 
                    </a>
                    <b class="arrow"></b>
                </li>

            </ul>
        </li>      

        <li>
            <a href="javascript:;" class="dropdown-toggle">
                <i class="menu-icon fa fa-user"></i>
                <span class="menu-text"> Manage Merchant </span>
                <b class="arrow fa fa-angle-down"></b>
            </a>
            <b class="arrow"></b>
            <ul class="submenu">
                <li>
                    <a href="<?php echo HTTP_ROOT . 'admin/#/add-new-merchant'; ?>">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Add New Merchant
                    </a>
                    <b class="arrow"></b>
                </li>
                <li>
                    <a href="<?php echo HTTP_ROOT . 'admin/#/view-all-merchant'; ?>">
                        <i class="menu-icon fa fa-caret-right"></i>
                        View All Merchant
                    </a>
                    <b class="arrow"></b>
                </li>
            </ul>
        </li>    

        <li>
            <a href="javascript:;" class="dropdown-toggle">
                <i class="menu-icon fa fa-user"></i>
                <span class="menu-text"> Manage Sub-Merchant </span>
                <b class="arrow fa fa-angle-down"></b>
            </a>
            <b class="arrow"></b>
            <ul class="submenu">
                <li>
                    <a href="admin/#/add-new-submerchant">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Add New Sub-Merchant
                    </a>
                    <b class="arrow"></b>
                </li>
                <li>
                    <a href="admin/#/view-all-submerchant">
                        <i class="menu-icon fa fa-caret-right"></i>
                        View All Sub-Merchant
                    </a>
                    <b class="arrow"></b>
                </li>
            </ul>
        </li>  

        <li class="nav-list-2">
            <a href="javascript:;" class="dropdown-toggle">
                <i class="menu-icon fa fa-dollar"></i>
                <span class="menu-text">  Split Settlement Mapping </span>
                <b class="arrow fa fa-angle-down"></b>
            </a>
            <b class="arrow"></b>
            <ul class="submenu">
                <li class="">
                    <a href="admin/#/split-settlement-mapping">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Add New Split Settlement
                    </a>
                    <b class="arrow"></b>
                </li>
                <li class="">
                    <a href="admin/#/split-settlement-mapping-list">
                        <i class="menu-icon fa fa-caret-right"></i>
                        View Split Settlements 
                    </a>
                    <b class="arrow"></b>
                </li>

            </ul>
        </li>   
        
        <li>
            <a href="logout">
                <i class="menu-icon fa fa-power-off"></i>
                <span class="menu-text"> Logout </span>
            </a>
        </li>

        <!--<li style="background: #BBBBBB; border: none;">&nbsp;</li>-->

    </ul>

    <!-- /.nav-list -->

    <!--
    <div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
        <i id="sidebar-toggle-icon" class="ace-icon fa fa-angle-double-left ace-save-state" data-icon1="ace-icon fa fa-angle-double-left" data-icon2="ace-icon fa fa-angle-double-right"></i>
    </div>
    -->

</div>