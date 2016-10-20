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
                    <a href="javascript:;"> Merchants </a>
                </li>
                <li class="active"> My Merchants </li>
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

            <?php echo $this->element('change_skin'); ?>


            <div class="row">
                <div class="col-xs-12">

                    <h3 class="header smaller lighter blue"> My Merchants  </h3>

                    <div class="box-header">
                        <form id="Search" name="search" method="get" action="">
                            <div class="row" style="position: relative; margin: auto; width: 800px; margin-left: 180px;">                           
                                <div class="col-xs-12 col-sm-5">
                                    <input type="text" name="search_keyword" class="validate[required] form-control input-sm" placeholder="Search by Keyword.." value="">
                                </div>
                                <div class="col-xs-12 col-sm-3">
                                    <button type="submit" class="btn btn-sm btn-default"><i class="fa fa-search"></i> Search</button>
                                    <a href="javascript:;" class="btn btn-default btn-sm"><i class="fa fa-list"></i> View All</a>
                                </div>
                            </div>
                        </form>
                    </div>

                    <br/>


                    <div class="clearfix">
                        <div class="pull-right tableTools-container"></div>
                    </div>

                    <!--
                    <div class="table-header">
                        Bills & Payments History 
                    </div>
                    -->

                    <!-- div.table-responsive -->

                    <!-- div.dataTables_borderWrap -->
                    <div>
                        <table id="dynamic-table" class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>  
                                    <th> Merchant </th>
                                    <th style="text-align: center;"> No Of Customers </th>                                   
                                    <th style="text-align: center;"> Created </th>
                                    <th style="text-align: center;"> Status </th>
                                    <th style="text-align: center;"> Action </th>
                                </tr>
                            </thead>

                            <tbody>

                                <?php $users = ['ST Joseph School', 'Eagle Society', 'Merchant 3', 'Maerchant 4']; ?>

                                <?php for ($i = 0; $i < 4; $i++) { ?>
                                    <tr>  
                                        <td> <?= $users[$i] ?> </td>
                                        <td style="text-align: center;"> 5000 </td>                                        
                                        <td style="text-align: center;">Feb 12 , 2016</td>
                                        <td style="text-align: center;">
                                            <span class="label label-sm label-warning arrowed arrowed-righ">Active</span>
                                        </td>

                                        <td style="text-align: center;">
                                            <a href="<?= HTTP_ROOT . "branchadmin/view-customers/1" ?>"><span class="label label-sm label-success arrowed arrowed-righ">View Customers</span></a>
                                        </td>

                                    </tr>

                                <?php } ?>

                            </tbody>
                        </table>

                        <div class="row"><div class="col-xs-6"><div aria-live="polite" role="status" id="dynamic-table_info" class="dataTables_info">Showing 1 to 10 of 23 entries</div></div><div class="col-xs-6"><div id="dynamic-table_paginate" class="dataTables_paginate paging_simple_numbers"><ul class="pagination"><li id="dynamic-table_previous" tabindex="0" aria-controls="dynamic-table" class="paginate_button previous disabled"><a href="javascript:;">Previous</a></li><li tabindex="0" aria-controls="dynamic-table" class="paginate_button active"><a href="javascript:;">1</a></li><li tabindex="0" aria-controls="dynamic-table" class="paginate_button "><a href="javascript:;">2</a></li><li tabindex="0" aria-controls="dynamic-table" class="paginate_button "><a href="javascript:;">3</a></li><li id="dynamic-table_next" tabindex="0" aria-controls="dynamic-table" class="paginate_button next"><a href="javascript:;">Next</a></li></ul></div></div></div>

                    </div>
                </div>
            </div>
        </div><!-- /.page-content -->



    </div>
</div><!-- /.main-content -->

