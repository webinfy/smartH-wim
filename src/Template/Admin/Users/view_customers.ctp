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
                <li class="active">My Customers</li>
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

            <!-- /.ace-settings-container -->

            <!-- /section:settings.box -->
            <div class="page-header">
                <h1>
                    My Customers     
                    <a class="btn btn-info pull-right" style="padding: 0 !important; margin-right: 40px;" href="<?php echo HTTP_ROOT . "merchant/add-customer" ?>"> Add New Customer </a>
                </h1>
            </div><!-- /.page-header -->

            <div class="row">
                <div class="col-xs-12">
                    <!-- PAGE CONTENT BEGINS -->

                    <div class="box-header">
                        <form action="" method="get" name="search" id="Search">
                            <div class="row">
                                <div class="col-xs-12 col-sm-4">
                                    <select id="SearchBY" class="validate[required] form-control input-sm" name="search_by">
                                        <option value="">Search By</option>
                                        <option value="customer_group"> Merchant Name </option>
                                        <option value="customer_name"> Group Name </option>                                      
                                        <option value="customer_name"> Customer Name </option>                                      
                                    </select>
                                </div>
                                <div class="col-xs-12 col-sm-5">
                                    <input type="text" value="" placeholder="Search" class="validate[required] form-control input-sm" name="search_keyword">
                                </div>
                                <div class="col-xs-12 col-sm-3">
                                    <button class="btn btn-sm btn-default" type="submit"><i class="fa fa-search"></i> Search</button>
                                    <a class="btn btn-default btn-sm" href="http://localhost/2016/compareprice/admin/products/allmasterproduct"><i class="fa fa-list"></i> View All</a>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!--<div class="hr hr-24"></div>-->

                    <br>

                    <div class="row">
                        <div class="col-xs-12">
                            <table id="simple-table" class="table  table-bordered table-hover">
                                <thead>
                                    <tr>  
                                        <th> Merchant </th>
                                        <th> Customer Name </th>
                                        <th> Customer Group </th>
                                        <th style="text-align: center;"> Bill Amount </th>    
                                        <th style="text-align: center;">
                                            <i class="ace-icon fa fa-clock-o bigger-110 hidden-480"></i>
                                            Due date
                                        </th>
                                        <th style="text-align: center;" class="hidden-480">Status</th>                                       
                                    </tr>
                                </thead>

                                <tbody>

                                    <tr> 
                                        <td> IDCO Colony </td>
                                        <td> Prakash Guru </td>
                                        <td> IDCO </td>
                                        <td style="text-align: center;"> $45 </td>                                                        
                                        <td style="text-align: center;">Feb 12 , 2016</td>
                                        <td style="text-align: center;" class="hidden-480">
                                            <span class="label label-sm label-warning">Paid</span>
                                        </td>                              
                                    </tr>   

                                    <tr> 
                                        <td> IDCO Colony </td>
                                        <td> Soumya Das </td>
                                        <td> IDCO </td>
                                        <td style="text-align: center;"> $45 </td>                                                        
                                        <td style="text-align: center;">Feb 12 , 2016</td>
                                        <td style="text-align: center;" class="hidden-480">
                                            <span class="label label-sm label-warning">Paid</span>
                                        </td>                                        
                                    </tr>   

                                    <tr> 
                                        <td> Bank Colony </td>
                                        <td> Soubhagya Barik </td>
                                        <td> St Josef School  </td>
                                        <td style="text-align: center;"> $45 </td>                                                        
                                        <td style="text-align: center;">Feb 12 , 2016</td>
                                        <td style="text-align: center;" class="hidden-480">
                                            <span class="label label-sm label-warning">Paid</span>
                                        </td>                                        
                                    </tr>   

                                    <tr> 
                                        <td> Bank Colony </td>
                                        <td> Dipti Ranjan Nayak Barik </td>
                                        <td> St Josef School </td>
                                        <td style="text-align: center;"> $45 </td>                                                        
                                        <td style="text-align: center;">Feb 12 , 2016</td>
                                        <td style="text-align: center;" class="hidden-480">
                                            <span class="label label-sm label-warning">Paid</span>
                                        </td>                                       
                                    </tr>  

                                </tbody>
                            </table>

                            <div class="row"><div class="col-xs-6"><div class="dataTables_info" id="dynamic-table_info" role="status" aria-live="polite">Showing 1 to 10 of 23 entries</div></div><div class="col-xs-6"><div class="dataTables_paginate paging_simple_numbers" id="dynamic-table_paginate"><ul class="pagination"><li class="paginate_button previous disabled" aria-controls="dynamic-table" tabindex="0" id="dynamic-table_previous"><a href="javascript:;">Previous</a></li><li class="paginate_button active" aria-controls="dynamic-table" tabindex="0"><a href="javascript:;">1</a></li><li class="paginate_button " aria-controls="dynamic-table" tabindex="0"><a href="javascript:;">2</a></li><li class="paginate_button " aria-controls="dynamic-table" tabindex="0"><a href="javascript:;">3</a></li><li class="paginate_button next" aria-controls="dynamic-table" tabindex="0" id="dynamic-table_next"><a href="javascript:;">Next</a></li></ul></div></div></div>


                        </div><!-- /.span -->
                    </div><!-- /.row -->


                    <!-- PAGE CONTENT ENDS -->
                </div><!-- /.col -->
            </div><!-- /.row -->
            
        </div><!-- /.page-content -->
    </div>
</div><!-- /.main-content -->
