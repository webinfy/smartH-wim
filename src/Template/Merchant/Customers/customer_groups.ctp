<!-- /section:basics/sidebar -->
<div class="main-content">
    <div class="main-content-inner">
        <!-- #section:basics/content.breadcrumbs -->
        <div class="breadcrumbs ace-save-state" id="breadcrumbs">
            <ul class="breadcrumb">
                
                <li>
                    <i class="ace-icon fa fa-home home-icon"></i>
                    <a href="javascript:;">Home</a>
                </li>

                <li>
                    <a href="javascript:;">Customers</a>
                </li>
                <li class="active"> Customer Groups </li>
            </ul><!-- /.breadcrumb -->

            <!-- #section:basics/content.searchbox -->
            <div class="nav-search" id="nav-search">
                <form class="form-search">
                    <span class="input-icon">
                        <input type="text" placeholder="Search ..." class="nav-search-input" id="nav-search-input" autocomplete="off" />
                        <i class="ace-icon fa fa-search nav-search-icon"></i>
                    </span>
                </form>
            </div><!-- /.nav-search -->

            <!-- /section:basics/content.searchbox -->
        </div>

        <!-- /section:basics/content.breadcrumbs -->
        <div class="page-content">
            <!-- #section:settings.box -->

            <?php echo $this->element('change_skin'); ?>

            <!-- /section:settings.box -->
            <div class="page-header">
                <h1>
                    Customer Groups                      
                    <a class="btn btn-info pull-right" style="padding: 0 !important; margin-right: 40px;" href="<?php echo HTTP_ROOT . "merchant/add-group" ?>">Add New Group</a>
                </h1>
            </div><!-- /.page-header -->

            <div class="row">
                <div class="col-xs-12">
                    <!-- PAGE CONTENT BEGINS -->


                    <div class="row">
                        <div class="col-xs-12">
                            <table id="simple-table" class="table  table-bordered table-hover">
                                <thead>
                                    <tr>                                                      
                                        <th> Group Name </th>
                                        <th style="text-align: center;"> No of Customers </th>
                                        <th style="text-align: center;"> Actions </th>
                                    </tr>
                                </thead>

                                <tbody>

                                    <?php for ($i = 1; $i <= 5; $i++) { ?>      

                                        <tr> 

                                            <td> BANK Colony </td>

                                            <td style="text-align: center;"> <?php echo 50; ?> </td>

                                            <td style="text-align: center;">
                                                <div class="hidden-sm hidden-xs btn-group">
                                                    <button class="btn btn-xs btn-success">
                                                        <i class="ace-icon fa fa-check bigger-120"></i>
                                                    </button>

                                                    <button class="btn btn-xs btn-info">
                                                        <i class="ace-icon fa fa-pencil bigger-120"></i>
                                                    </button>

                                                    <button class="btn btn-xs btn-danger">
                                                        <i class="ace-icon fa fa-trash-o bigger-120"></i>
                                                    </button>

                                                    <button class="btn btn-xs btn-warning">
                                                        <i class="ace-icon fa fa-flag bigger-120"></i>
                                                    </button>

                                                    <a href="<?php echo HTTP_ROOT . "merchant/payment-setting" ?>" class="tooltip-error" data-rel="tooltip" title="Payment Setting">
                                                        Payment Setting                                                        
                                                    </a>

                                                </div>

                                                <!--
                                                <div class="hidden-md hidden-lg">
                                                    <div class="inline pos-rel">
                                                        <button class="btn btn-minier btn-primary dropdown-toggle" data-toggle="dropdown" data-position="auto">
                                                            <i class="ace-icon fa fa-cog icon-only bigger-110"></i>
                                                        </button>

                                                        <ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close">
                                                            <li>
                                                                <a href="javascript:;" class="tooltip-info" data-rel="tooltip" title="View">
                                                                    <span class="blue">
                                                                        <i class="ace-icon fa fa-search-plus bigger-120"></i>
                                                                    </span>
                                                                </a>
                                                            </li>

                                                            <li>
                                                                <a href="javascript:;" class="tooltip-success" data-rel="tooltip" title="Edit">
                                                                    <span class="green">
                                                                        <i class="ace-icon fa fa-pencil-square-o bigger-120"></i>
                                                                    </span>
                                                                </a>
                                                            </li>

                                                            <li>
                                                                <a href="javascript:;" class="tooltip-error" data-rel="tooltip" title="Delete">
                                                                    <span class="red">
                                                                        <i class="ace-icon fa fa-trash-o bigger-120"></i>
                                                                    </span>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                -->
                                            </td>
                                        </tr>

                                    <?php } ?>                                          

                                </tbody>
                            </table>

                        </div><!-- /.span -->
                    </div><!-- /.row -->


                    <!-- PAGE CONTENT ENDS -->
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.page-content -->
    </div>
</div><!-- /.main-content -->

