<?php $paramAction = $this->request->params['action']; ?>
<div  id="sidebar" class="sidebar responsive ace-save-state" style="min-height: 500px;">

    <div class="profile-pic">
        <?php if (!empty($loginDetails['merchant_profile']['logo'])) { ?>
            <span class="img-section"><img src="<?= MERCHANT_LOGO . $loginDetails['merchant_profile']['logo'] ?>" alt="" /></span>
        <?php } ?>
        <h3 class="profile-name">Hi <?= $loginDetails['name'] ?> </h3>
        <div class="profile-login-info">Welcome to Merchant Panel <br/>Last Login : <?= date('M d, Y H:i A', strtotime($loginDetails['last_login_date'])) ?></div>
    </div>

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
                <span class="menu-text">  Payments  </span>
                <b class="arrow fa fa-angle-down"></b>
            </a>
            <b class="arrow"></b> 
            <ul class="submenu">               
                <li class="">
                    <a href="merchant/#/webfront-listing">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Basic Webfront List
                    </a>
                    <b class="arrow"></b>
                </li>  
                <li class="">
                    <a href="merchant/#/advance-webfront-listing">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Advance Webfront List     
                    </a>
                    <b class="arrow"></b>
                </li> 
            </ul>
        </li>

        <li class="nav-list-2">
            <a href="merchant/#/reports" class="dropdown-toggleXX">               
                <i class="menu-icon fa fa-money"></i>
                <span class="menu-text">  Reports  </span>
                <b class="arrow fa"></b>
            </a>            
        </li>

        <!--

        <li class="nav-list-2">
            <a href="javascript:;" class="dropdown-toggle">               
                <i class="menu-icon fa fa-money"></i>
                <span class="menu-text">  Basic Webfronts  </span>
                <b class="arrow fa fa-angle-down"></b>
            </a>
            <b class="arrow"></b> 
            <ul class="submenu">
                <li class="">
                    <a href="merchant/#/basic-web-front-creation">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Create Basic Webfront  
                    </a>
                    <b class="arrow"></b>
                </li>
                <li class="">
                    <a href="merchant/#/webfront-listing">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Basic Webfront List
                    </a>
                    <b class="arrow"></b>
                </li>       
            </ul>
        </li>

        <li class="nav-list-2">
            <a href="javascript:;" class="dropdown-toggle">               
                <i class="menu-icon fa fa-money"></i>
                <span class="menu-text">  Advance Webfronts   </span>
                <b class="arrow fa fa-angle-down"></b>
            </a>
            <b class="arrow"></b> 
            <ul class="submenu">
                <li class="">                  
                    <a href="merchant/#/advance-web-front-creation">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Create Advance Webfront            
                    </a>
                    <b class="arrow"></b>
                </li>  
                <li class="">
                    <a href="merchant/#/advance-webfront-listing">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Advance Webfront List     
                    </a>
                    <b class="arrow"></b>
                </li>       
            </ul>
        </li>

        -->

        <li>
            <a href="javascript:;" class="dropdown-toggle">
                <i class="menu-icon fa fa-list"></i>
                <span class="menu-text"> Manage User </span>
                <b class="arrow fa fa-angle-down"></b>
            </a>
            <b class="arrow"></b>
            <ul class="submenu">
                <li>
                    <a href="<?php echo HTTP_ROOT . 'merchant/#/add-new-user'; ?>">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Add New User
                    </a>
                    <b class="arrow"></b>
                </li>

                <li>
                    <a href="<?php echo HTTP_ROOT . 'merchant/#/view-all-user'; ?>">
                        <i class="menu-icon fa fa-caret-right"></i>
                        View All User
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
    <!--
    <div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
        <i id="sidebar-toggle-icon" class="ace-icon fa fa-angle-double-left ace-save-state" data-icon1="ace-icon fa fa-angle-double-left" data-icon2="ace-icon fa fa-angle-double-right"></i>
    </div>
    -->

    <!-- /section:basics/sidebar.layout.minimize -->
</div>