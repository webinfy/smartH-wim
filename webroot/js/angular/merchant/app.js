var app = angular
        .module('merchantApp', ['ui.router', 'oc.lazyLoad', 'ngFileUpload'])
        .config(function ($stateProvider, $urlRouterProvider) {
            $urlRouterProvider.otherwise('/dashboard');
            $stateProvider
                    .state('dashboard', {
                        url: '/dashboard',
                        title: 'Dashboard',
                        controller: 'DashboardCtrl',
                        templateUrl: 'views/merchant/dashboard.html'
                    })
                    .state('basic-web-front-creation', {
                        url: '/basic-web-front-creation',
                        title: 'Basic Web Front Creation',
                        controller: 'WebFrontCtrl',
                        templateUrl: 'views/merchant/basic-web-front-creation.html',
                        resolve: {
                            lazyLoad: ['$ocLazyLoad', function ($ocLazyLoad) {
                                    return $ocLazyLoad.load([
                                        {
                                            name: 'datepicker',
                                            files: ['components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js', 'components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css']
                                        }
                                    ]);
                                }]
                        }
                    })
                    .state('edit-basic-web-front', {
                        url: '/edit-basic-web-front/:id?tab&name&title',
                        title: 'Edit Basic Web Front',
                        controller: 'WebFrontCtrl',
                        templateUrl: 'views/merchant/edit-basic-web-front.html',
                        resolve: {
                            lazyLoad: ['$ocLazyLoad', function ($ocLazyLoad) {
                                    return $ocLazyLoad.load([
                                        {
                                            name: 'datepicker',
                                            files: ['components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js', 'components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css']
                                        }
                                    ]);
                                }]
                        }
                    })
                    .state('webfront-listing', {
                        url: '/webfront-listing',
                        title: 'Webfront Listing',
                        controller: 'WebFrontCtrl',
                        templateUrl: 'views/merchant/webfront-listing.html'
                    })
                    //Advance Webfront Router Section starts here
                    .state('advance-web-front-creation', {
                        url: '/advance-web-front-creation',
                        title: 'Advance Web Front Creation',
                        controller: 'WebFrontCtrl',
                        templateUrl: 'views/merchant/advance-web-front-creation.html',
                        resolve: {
                            lazyLoad: ['$ocLazyLoad', function ($ocLazyLoad) {
                                    return $ocLazyLoad.load([
                                        {
                                            name: 'datepicker',
                                            files: ['components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js', 'components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css']
                                        },
                                        {
                                            name: 'cropit',
                                            files: ['js/jquery.cropit.js']
                                        }
                                    ]);
                                }]
                        }
                    })
                    .state('advance-webfront-listing', {
                        url: '/advance-webfront-listing',
                        title: 'Advance Webfront Listing',
                        controller: 'WebFrontCtrl',
                        templateUrl: 'views/merchant/advance-webfront-listing.html'
                    })
                    .state('edit-advance-web-front', {
                        url: '/edit-advance-web-front/:id/:advance?tab&name&title',
                        title: 'Edit Advance Web Front',
                        controller: 'WebFrontCtrl',
                        templateUrl: 'views/merchant/edit-advance-web-front.html',
                        resolve: {
                            lazyLoad: ['$ocLazyLoad', function ($ocLazyLoad) {
                                    return $ocLazyLoad.load([
                                        {
                                            name: 'datepicker',
                                            files: ['components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js', 'components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css']
                                        }
                                    ]);
                                }]
                        }
                    })
                    .state('advance-view-payments', {
                        url: '/advance-view-payments/:id?title',
                        title: 'View Payments',
                        controller: 'PaymentsCtrl',
                        templateUrl: 'views/merchant/advance-view-payments.html'
                    })
                    //Advance Webfront Router Section ends here
                    .state('view-uploads', {
                        url: '/view-uploads/:id?tab',
                        title: 'View Payments',
                        controller: 'PaymentsCtrl',
                        templateUrl: 'views/merchant/view-uploads.html',
                        resolve: {
                            lazyLoad: ['$ocLazyLoad', function ($ocLazyLoad) {
                                    return $ocLazyLoad.load([
                                        {
                                            name: 'fileinput',
                                            files: ['assets/js/src/elements.fileinput.js']
                                        },
                                        {
                                            name: 'datepicker',
                                            files: ['components/bootstrap-datepicker/dist/js/bootstrap-datepicker.js']
                                        },
                                        {
                                            name: 'merchantApp',
                                            insertBefore: '#main-ace-style',
                                            files: [
                                                'components/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css'
                                            ]
                                        }
                                    ]);
                                }]
                        }
                    })
                    .state('view-payments', {
                        url: '/view-payments/:id?title',
                        title: 'View Payments',
                        controller: 'PaymentsCtrl',
                        templateUrl: 'views/merchant/view-payments.html'
                    })
                    .state('profile-setting', {
                        url: '/profile-setting',
                        title: 'Profile Setting',
                        controller: 'ProfileCtrl',
                        templateUrl: 'views/merchant/profile-setting.html'
                    })
                    .state('change-password', {
                        url: '/change-password',
                        title: 'Change Password',
                        controller: 'ProfileCtrl',
                        templateUrl: 'views/merchant/change-password.html'
                    })
                    .state('import-payments', {
                        url: '/import-payments/:id?title',
                        title: 'Import Payments',
                        controller: 'ImportPaymentsCtrl',
                        templateUrl: 'views/merchant/import-payments.html',
                        resolve: {
                            lazyLoad: ['$ocLazyLoad', function ($ocLazyLoad) {
                                    return $ocLazyLoad.load([
                                        {
                                            name: 'fileinput',
                                            files: ['assets/js/src/elements.fileinput.js']
                                        },
                                        {
                                            name: 'datepicker',
                                            files: ['components/bootstrap-datepicker/dist/js/bootstrap-datepicker.js']
                                        },
                                        {
                                            name: 'merchantApp',
                                            insertBefore: '#main-ace-style',
                                            files: [
                                                'components/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css'
                                            ]
                                        }
                                    ]);
                                }]
                        }
                    })
                    .state('update-excel', {
                        url: '/update-excel/:id',
                        title: 'Update Excel',
                        controller: 'PaymentsCtrl',
                        templateUrl: 'views/merchant/update-excel.html',
                        resolve: {
                            lazyLoad: ['$ocLazyLoad', function ($ocLazyLoad) {
                                    return $ocLazyLoad.load([
                                        {
                                            name: 'fileinput',
                                            files: ['assets/js/src/elements.fileinput.js']
                                        }
                                    ]);
                                }]
                        }
                    })
                    .state('add-new-user', {
                        url: '/add-new-user',
                        title: 'Add New User',
                        controller: 'UserCtrl',
                        templateUrl: 'views/merchant/add-new-user.html'
                    })
                    .state('edit-new-user', {
                        url: '/edit-new-user/:id',
                        title: 'Edit New User',
                        controller: 'UserCtrl',
                        templateUrl: 'views/merchant/edit-new-user.html'
                    })
                    .state('view-all-user', {
                        url: '/view-all-user',
                        title: 'View All User',
                        controller: 'UserCtrl',
                        templateUrl: 'views/merchant/view-all-user.html'
                    })
                    .state('reports', {
                        url: '/reports',
                        title: 'Reports',
                        controller: 'ReportsCtrl',
                        templateUrl: 'views/merchant/reports.html'
                    })
                    .state('view-uploaded-files', {
                        url: '/view-uploaded-files/:id?',
                        title: 'ViewUuploadedFiles',
                        controller: 'ReportsCtrl',
                        templateUrl: 'views/merchant/view-uploaded-files.html'
                    })
                    .state('advance-webfront-payments', {
                        url: '/advance-webfront-payments/:id',
                        title: 'Advance Webfront payments',
                        controller: 'AdvancePaymentsCtrl',
                        templateUrl: 'views/merchant/advance-webfront-payments.html'
                    })

        })
        .run(['$rootScope', '$location', '$state', function ($rootScope, $location, $state) {

                $rootScope.siteUrl = siteUrl;
                $rootScope.$state = $state;
                $rootScope.$on("$stateChangeStart", function (event, toState, toParams, fromState, fromParams) {

                    $("#ui-view").html("");
                    $(".page-loading").removeClass("hidden");

                    $rootScope.authenticated = false;
                    var json = (function () {
                        $.ajax({
                            type: 'GET',
                            async: false,
                            global: false,
                            url: 'users/ajaxCheckLogin',
                            dataType: "json",
                            success: function (response) {
                                if (response.status == 'loggedin') {
                                    $rootScope.authenticated = true;
                                    $rootScope.userSession = response.user;
                                } else {
                                    window.location = siteUrl;
                                }
                            }
                        });
                    })();
                });
                $rootScope.$on('$stateChangeSuccess', function (event, toState, toParams, fromState, fromParams) {
                    $(".page-loading").addClass("hidden");
                });

                $rootScope.success = function (msg) {
                    $html = "";
                    $html += '<div style="display: block;" id="success-msg" class="alert alert-info">';
                    $html += '<button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button>';
                    $html += '<p><i class="ace-icon fa fa-check"></i>&nbsp;' + msg + '</p>';
                    $html += '</div>';
                    $('#flash-msg').html($html).show().focus();//.delay(8000).fadeOut();
                    $("html, body").animate({scrollTop: 0}, "slow");
                };

                $rootScope.error = function (msg) {
                    $html = "";
                    $html += '<div style="display: block;" id="success-msg" class="alert alert-danger">';
                    $html += '<button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button>';
                    $html += ' <p><i class="ace-icon fa fa-times"></i>&nbsp;' + msg + '</p>';
                    $html += '</div>';
                    $('#flash-msg').html($html).show().focus();//.delay(8000).fadeOut();
                    $("html, body").animate({scrollTop: 0}, "slow");
                };

                $rootScope.validatePwd = function (value) {
                    if (value) {
                        console.log(value);
                        var pattern = /\d{3}/;
                        if (pattern.test(value)) {
                            $('#pwdValNum').show();
                        } else {
                            $('#pwdValNum').hide();
                        }
                    }
                };

            }]);
//////////////////////////////////Controller Code/////////////////////////////


//app.controller('ImportPaymentsCtrl', function ($scope) {

app.controller('ImportPaymentsCtrl', function ($scope, $http, $timeout, $compile, $stateParams, $rootScope, Upload) {

    $scope.title = $stateParams['title'];

    $scope.importExcel = function (file) {
        $(".page-loading").removeClass("hidden");
        $scope.formUpload = true;
        if (file != null) {
            file.upload = Upload.upload({
                url: siteUrl + "merchant/webfronts/ajaxImportPayments" + $scope.getReqParams(),
                data: {id: $stateParams['id'], payment_cycle_date: $scope.payment_cycle_date, file: file}
            });
            file.upload.then(function (response) {
                $(".page-loading").addClass("hidden");
                if (response.data.status == 'success') {
                    $rootScope.success('File Imported Successfully!!.');
                    $('#fileinput').closest('form').get(0).reset();
                } else if (response.data.status == 'error') {
                    $rootScope.error(response.data.msg);
                }
            });
        }
    };

    $scope.getReqParams = function () {
        return $scope.generateErrorOnServer ? '?errorCode=' + $scope.serverErrorCode + '&errorMessage=' + $scope.serverErrorMsg : '';
    };

    //datepicker value and options
    if ($('.datepicker').length) {
        $('.datepicker').datepicker({format: 'yyyy-mm-dd', autoclose: true});
    }

});



app.controller('ReportsCtrl', function ($scope, $http, $stateParams, $window, $timeout) {

    $scope.fetchWebfronts = function () {
        $http.get(siteUrl + "merchant/webfronts/ajaxMyWebfronts").then(function (response) {
            if (response.data.status == 'success') {
                $scope.webfronts = response.data.webfronts;
            }
        });
    };

    $scope.viewWebfrontFiles = function () {
        var id = $stateParams.id;
        $http.get(siteUrl + "merchant/payments/ajaxViewUploads/" + id).then(function (response) {
            if (response.data.status == 'success') {
                $scope.uploaded_payment_files = response.data.data.uploaded_payment_files;
                $scope.webfront = response.data.data.webfront;
            }
        });
    };

});

app.controller('AdvancePaymentsCtrl', function ($scope, $http, $timeout, $compile, $stateParams, $rootScope, $window, Upload) {

    var webfrontId = $stateParams['id'];

    $scope.advanceWebfrontReport = function () {
        var status = $scope.status;
        var msg = "Are you sure you want all the invoices report ?";
        var option = 0;
        if (status == 'paid') {
            option = 1;
            msg = "Are you sure you want all the paid invoices report ?";
        } else if (status == 'unpaid') {
            option = 2;
            msg = "Are you sure you want all the unpaid invoices report ?";
        }
        confirm(msg, function (data) {
            if (data) {
                $window.location = siteUrl + 'merchant/payments/webfront-report/' + $scope.webfront.id + '/' + option;
            }
        }, {return: true});
    }

    $scope.advanceWebfrontPayments = function () {
        $(".page-loading").removeClass("hidden");
        var dataString = {'status': $scope.status};
        $http({
            method: "POST",
            url: siteUrl + "merchant/payments/ajaxAdvanceWebfrontPayments/" + webfrontId,
            data: dataString
        }).then(function (response) {
            if (response.data.status == 'success') {
                var payments = response.data.payments;
                var newPayments = [];
                for (var i = 0; i < payments.length; i++) {
                    if (payments[i]['payee_custom_fields'])
                        payments[i].payee_custom_fields = JSON.parse(payments[i]['payee_custom_fields']);
                    if (payments[i]['payment_custom_fields'])
                        payments[i].payment_custom_fields = JSON.parse(payments[i]['payment_custom_fields']);
                    newPayments.push(payments[i]);
                }
                $scope.payments = newPayments;
                $scope.webfront = response.data.webfront;
                $scope.file = response.data.file;
                $scope.counter = response.data.counter;
                $('#pagination-paginate .pagination').html(response.data.paging);
            }
            $(".page-loading").addClass("hidden");
        });
    }

});

app.controller('DashboardCtrl', function ($scope, $http, $timeout, $compile, $stateParams, $rootScope, $window, Upload) {
    $scope.getMerchantData = function () {
        $http.get(siteUrl + "merchant/users/ajaxGetProfileData").then(function (response) {
            $scope.merchant = response.data.merchant
        });
    }
});

app.directive('noSpecialChar', function () {
    return {
        require: 'ngModel',
        restrict: 'A',
        link: function (scope, element, attrs, modelCtrl) {
            modelCtrl.$parsers.push(function (inputValue) {
                if (inputValue == null)
                    return ''
                cleanInputValue = inputValue.replace(/[^\w\s]/gi, '');
                if (cleanInputValue != inputValue) {
                    modelCtrl.$setViewValue(cleanInputValue);
                    modelCtrl.$render();
                }
                return cleanInputValue;
            });
        }
    }
});

//////////////////////////////////
function getParameterByName(name, url) {
    if (!url)
        url = window.location.href;
    name = name.replace(/[\[\]]/g, "\\$&");
    var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"), results = regex.exec(url);
    if (!results)
        return null;
    if (!results[2])
        return '';
    return decodeURIComponent(results[2].replace(/\+/g, " "));
}
//JQuery Code for Menu Active & In-Active
$(function () {
    $(document).on('click', '.nav-list a', function () {
        $('.nav-list').find('li.nav-list-2').removeClass('active').removeClass('open').find('ul.submenu').addClass('nav-hide').removeClass('nav-show');
        $(this).parents('li.nav-list-2').addClass('active').addClass('open');

        $('.nav-list').find('li').removeClass('active');
        $(this).parent('li').addClass('active');
        $('#sidebar').removeClass('display');
    });
});

$(function () {
    var page = 1;
    $(document).on('click', '#uploaded_file_paginate a', function () {
        if (!$(this).parent('li').hasClass('disabled') && !$(this).parent('li').hasClass('active')) {
            var pageUrl = $(this).attr('href');
            page = getParameterByName('page', pageUrl);
            if (page == null || page == '') {
                page = 1;
            }
            getUploadedFiles();
        }
        return false;
    });
});
