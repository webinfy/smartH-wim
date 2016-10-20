<?php $paramAction = $this->request->params['action']; ?>

<div id="sidebar" class="sidebar responsive ace-save-state">
    <script type="text/javascript">
        try {
            ace.settings.loadState('sidebar')
        } catch (e) {
        }
    </script>

<!--    <div class="sidebar-shortcuts" id="sidebar-shortcuts">
        <div class="sidebar-shortcuts-large" id="sidebar-shortcuts-large">
            <a href="customer/#/dashboard" class="btn btn-success">
                <i class="ace-icon fa fa-signal"></i>
            </a> 
            <a href="customer/#/change-password" class="btn btn-info">
                <i class="ace-icon fa fa-pencil"></i>
            </a>     
            <a href="customer/#/payment-and-bills" class="btn btn-warning"> 
                <i class="ace-icon fa fa-money"></i>
            </a> 
            <a href="customer/#/payment-history" class="btn btn-danger"> 
                <i class="ace-icon fa fa-cogs"></i>
            </a>            
        </div>

        <div class="sidebar-shortcuts-mini" id="sidebar-shortcuts-mini">
            <span class="btn btn-success"></span>
            <span class="btn btn-info"></span>
            <span class="btn btn-warning"></span>
            <span class="btn btn-danger"></span>
        </div>
    </div>-->

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


    </ul><!-- /.nav-list -->

    <!-- #section:basics/sidebar.layout.minimize -->
    <div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
        <i id="sidebar-toggle-icon" class="ace-icon fa fa-angle-double-left ace-save-state" data-icon1="ace-icon fa fa-angle-double-left" data-icon2="ace-icon fa fa-angle-double-right"></i>
    </div>

    <!-- /section:basics/sidebar.layout.minimize -->
</div>