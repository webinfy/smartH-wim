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
                    <a href="javascript:;"> Branch Admins </a>
                </li>
                <li class="active"> View All Branch Admins </li>
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
                    <h3 class="header smaller lighter blue">  View All Branch Admins   </h3>


                    <div class="box-header">
                        <form id="Search" name="search" method="get" action="">
                            <div class="row">
                                <div class="col-xs-12 col-sm-4">
                                    <select name="search_by" class="validate[required] form-control input-sm" id="SearchBY">
                                        <option value="">Search By</option>
                                        <option value="merchant_name">Branch Name</option>
                                        <option value="due_amount">Bank</option>
                                        <option value="due_date">IFSC Code</option>                                                                               
                                    </select>
                                </div>
                                <div class="col-xs-12 col-sm-5">
                                    <input type="text" name="search_keyword" class="validate[required] form-control input-sm" placeholder="Search" value="">
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
                                    <th> Branch </th>
                                    <th style="text-align: center;"> Bank </th>                                   
                                    <th style="text-align: center;"> IFSC Code </th>
                                    <th style="text-align: center;"> No of Merchants </th>
                                    <th style="text-align: center;"> Actions </th>                                    
                                </tr>
                            </thead>

                            <tbody>

                                <tr>                                    
                                    <td> Trahi Achyuta Nagar </td>
                                    <td style="text-align: center;"> HDFC </td>                                        
                                    <td style="text-align: center;"> HDFC0000122 </td>
                                    <td style="text-align: center;"> 400 </td>
                                    <td style="text-align: center;">
                                        <a href="<?= HTTP_ROOT . "admin/view-merchants/1" ?>"><span class="label label-sm label-success arrowed arrowed-righ">View Merchants</span></a>
                                    </td>
                                </tr>

                                <tr>                                    
                                    <td> SHAHID NAGAR - ORISSA </td>
                                    <td style="text-align: center;"> SBI </td>                                        
                                    <td style="text-align: center;"> SBIN0005457 </td>
                                    <td style="text-align: center;"> 500 </td>
                                    <td style="text-align: center;">
                                        <a href="<?= HTTP_ROOT . "admin/view-merchants/1" ?>"><span class="label label-sm label-success arrowed arrowed-righ">View Merchants</span></a>
                                    </td>
                                </tr>

                            </tbody>

                        </table>

                        <div class="row"><div class="col-xs-6"><div aria-live="polite" role="status" id="dynamic-table_info" class="dataTables_info">Showing 1 to 10 of 23 entries</div></div><div class="col-xs-6"><div id="dynamic-table_paginate" class="dataTables_paginate paging_simple_numbers"><ul class="pagination"><li id="dynamic-table_previous" tabindex="0" aria-controls="dynamic-table" class="paginate_button previous disabled"><a href="javascript:;">Previous</a></li><li tabindex="0" aria-controls="dynamic-table" class="paginate_button active"><a href="javascript:;">1</a></li><li tabindex="0" aria-controls="dynamic-table" class="paginate_button "><a href="javascript:;">2</a></li><li tabindex="0" aria-controls="dynamic-table" class="paginate_button "><a href="javascript:;">3</a></li><li id="dynamic-table_next" tabindex="0" aria-controls="dynamic-table" class="paginate_button next"><a href="javascript:;">Next</a></li></ul></div></div></div>

                    </div>
                </div>
            </div>
        </div><!-- /.page-content -->



    </div>
</div><!-- /.main-content -->

