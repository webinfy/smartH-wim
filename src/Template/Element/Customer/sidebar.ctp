
<div id="sidebar" class="sidebar responsive ace-save-state">

    <!--
    <div class="profile-pic">
        <span class="img-section"><img src="<?= !empty($loginDetails['merchant_profile']['logo']) ? MERCHANT_LOGO . $loginDetails['merchant_profile']['logo'] : HTTP_ROOT . 'img/profile-img.png'; ?>" alt="" /></span>
        <h3 class="profile-name">Hi <?= $loginDetails['name'] ?> </h3>
        <div class="profile-login-info">Welcome to Merchant Panel <br/>Last Login : <?= date('M d, Y H:i A', strtotime($loginDetails['last_login_date'])) ?></div>
    </div>
    -->

    <ul class="nav nav-list">

        <li class="nav-list-2 active open"  >
            <a href="customer/#/dashboard">
                <i class="menu-icon fa fa-tachometer"></i>
                <span class="menu-text"> Dashboard </span>
            </a>
        </li>   

        <li class="nav-list-2">
            <a href="javascript:;" class="dropdown-toggle">
                <i class="menu-icon fa fa-list"></i>
                <span class="menu-text">  Account Setting </span>
                <b class="arrow fa fa-angle-down"></b>
            </a>

            <b class="arrow"></b>

            <ul class="submenu">
                <!--
                <li class="">
                    <a href="customer/#/profile-setting">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Profile Setting
                    </a>
                    <b class="arrow"></b>
                </li>
                -->
                <li class="">
                    <a href="customer/#/change-password">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Change Password 
                    </a>
                    <b class="arrow"></b>
                </li>

            </ul>
        </li>      

        <li class="nav-list-2" >
            <a href="javascript:;" class="dropdown-toggle">
                <i class="menu-icon fa fa-pencil-square-o"></i>
                <span class="menu-text"> Bills & Payments </span>
                <b class="arrow fa fa-angle-down"></b>
            </a>
            <b class="arrow"></b>
            <ul class="submenu">
                <li class="">
                    <a href="customer/#/payment-and-bills">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Upcoming Payments
                    </a>
                    <b class="arrow"></b>
                </li> 
                <li class="" >
                    <a href="customer/#/payment-history">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Payment History
                    </a>
                    <b class="arrow"></b>
                </li> 
            </ul>
        </li>  

        <li class="nav-list-2">
            <a href="logout">
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