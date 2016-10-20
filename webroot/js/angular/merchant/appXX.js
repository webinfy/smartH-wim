var app = angular
        .module('merchantApp', ['ui.router', 'oc.lazyLoad', 'ngFileUpload'])
        .config(function ($stateProvider, $urlRouterProvider) {
            //cfpLoadingBarProvider.includeSpinner = true;
            $urlRouterProvider.otherwise('/dashboard');
            $stateProvider
                    .state('dashboard', {
                        url: '/dashboard',
                        title: 'Dashboard',
                        templateUrl: 'views/merchant/dashboard.html'
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
                        url: '/import-payments',
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
                    .state('view-payment-files', {
                        url: '/view-payment-files',
                        title: 'View Payment Files',
                        controller: 'PaymentsCtrl',
                        templateUrl: 'views/merchant/view-uploaded-files.html'
                    })
                    .state('view-payments', {
                        url: '/view-payments/:id?page&keyword',
                        title: 'View Payments',
                        controller: 'PaymentsCtrl',
                        templateUrl: 'views/merchant/view-payments.html'
                    })

        })
        .run(['$rootScope', '$location', '$state', function ($rootScope, $location, $state) {

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
            }]);
//////////////////////////////////Controller Code/////////////////////////////


//app.controller('ProfileCtrl', function ($scope, $http) {

app.controller('ProfileCtrl', function ($scope, $http, $timeout, $compile, Upload) {
    $scope.uploadPic = function (file, resumable) {
        $scope.formUpload = true;
        if (file != null) {
            $scope.errorMsg = null;
            file.upload = Upload.upload({
                url: siteUrl + "users/ajaxUpdateProfile" + $scope.getReqParams(),
                headers: {
                    'optional-header': 'header-value'
                },
                data: {user: $scope.user, file: file}
            });

            file.upload.then(function (response) {
                $('#logo').val('');
                if (response.data.status == 'success') {
                    $('#success-msg').show().delay(2000).slideUp();
                    $('.logo-center > img').attr('src', response.data.logo);
                } else {
                    $('#error-msg').show().delay(4000).slideUp();
                }
                $timeout(function () {
                    file.result = response.data;
                });
            }, function (response) {
                if (response.status > 0) {
                    $scope.errorMsg = response.status + ': ' + response.data;
                }
            }, function (evt) {
                // Math.min is to fix IE which reports 200% sometimes
//                file.progress = Math.min(100, parseInt(100.0 * evt.loaded / evt.total));
            });

//                file.upload.xhr(function (xhr) {
//                    // xhr.upload.addEventListener('abort', function(){console.log('abort complete')}, false);
//                });

        } else {
            $http.post(siteUrl + "users/ajaxUpdateProfile", {
                'user': $scope.user
            }).success(function (response, status, headers, config) {
                if (response.status == 'success') {
                    $('#success-msg').show().delay(2000).slideUp();
                } else {
                    $('#error-msg').show().delay(4000).slideUp();
                }
            });
        }
    };

    $scope.getReqParams = function () {
        return $scope.generateErrorOnServer ? '?errorCode=' + $scope.serverErrorCode + '&errorMessage=' + $scope.serverErrorMsg : '';
    };

    $scope.getProfileData = function () {
        $http.post(siteUrl + "users/ajaxGetProfileData").then(function (response) {
            $scope.user = response.data;
        }, 'json');
    }

    $scope.updateProfile = function () {
        $http.post(siteUrl + "users/ajaxUpdateProfile", {
            'user': $scope.user
        }).success(function (data, status, headers, config) {
            if (data.status == 'success') {
                $('#success-msg').show().delay(2000).slideUp();
            } else {
                $('#error-msg').show().delay(4000).slideUp();
            }
        });
        return false;
    }

    $scope.changePassword = function () {
        $http.post(siteUrl + "users/ajaxChangePasssword", {
            'old_password': $scope.old_password,
            'password1': $scope.password1,
            'password2': $scope.password2
        }).success(function (data, status, headers, config) {
            if (data.status == 'success') {
                $('#success-msg').show().delay(2000).slideUp();
                $scope.old_password = '';
                $scope.password1 = '';
                $scope.password2 = '';
            } else {
                $('#err-msg-content').html(data.msg);
                $('#error-msg').show().delay(4000).slideUp();
            }
        });
        return false;
    }
});

app.controller('PaymentsCtrl', function ($scope, $http, $stateParams) {

    $scope.getUploadedFiles = function () {
        $http({
            method: "GET",
            url: siteUrl + "merchant/payments/ajaxGetUploadedFiles"
        }).then(function mySucces(response) {
            if (response.data.status == 'success') {
                $scope.uploaded_payment_files = response.data.data;
            } else {
//                $('#simple-table tbody').html("<tr><td colspan='8' style='text-align:center; color:red;'>No files are uploaded yet.</td></tr>");
            }
        }, function myError(response) {
            //Error Code//
        });
    }

    $scope.deletePaymentUpload = function (id) {
        confirm("Are you sure you want to delete ? ", function (data) {
            if (data) {
                $http.get(siteUrl + "merchant/payments/ajaxDeletePaymentFile/" + id).then(function (response) {
                    if (response.data.status == 'success') {
                        $('#file-no-' + id).remove();
                    }
                });
            }
        }, {return: true});
    }

    $scope.fetchCustomFields = function () {
        var paymentFileId = $stateParams['id'];
        $http.get(siteUrl + "merchant/payments/ajaxfetchCustomFields/" + paymentFileId).then(function (response) {
            if (response.data.status == 'success') {
                $scope.custom_fields = response.data.data;
            }
        });
    }

    $scope.viewPaymentsPagination = function (event) {
        var $this = angular.element(event.target);
        if ($this.parents('li').hasClass('active') || $this.parents('li').hasClass('disabled')) {
            return false;
        }
        var url = $this.attr('href');
        var key = 'page';
        var page = unescape(url.replace(new RegExp("^(?:.*[&\\?]" + escape(key).replace(/[\.\+\*]/g, "\\$&") + "(?:\\=([^&]*))?)?.*$", "i"), "$1"));
        page = (typeof page === 'undefined') ? 1 : page;
        $scope.viewPayments(page);
        return false;
    }

    $scope.viewPayments = function (page) {
//        console.log($stateParams);
        var paymentFileId = $stateParams['id'];
        $(".page-loading").removeClass("hidden");

        var page = (typeof page === 'undefined') ? 1 : page;
        var searchby = $('#searchby').val();
        var keyword = $('#keyword').val();
        var dataString = {'page': page, 'searchby': searchby, 'keyword': keyword};

        $http({
            method: "POST",
            url: siteUrl + "merchant/payments/ajaxViewPayments/" + paymentFileId,
            data: dataString,
        }).then(function mySucces(response) {
            if (response.data.status == 'success') {
                var payments = response.data.payments;
                var newPayments = [];
                for (var i = 0; i < payments.length; i++) {
                    payments[i].custom_fields = JSON.parse(payments[i]['custom_fields']);
                    newPayments.push(payments[i]);
                }
                $scope.payments = newPayments;
                $scope.file = response.data.file;
                $scope.counter = response.data.counter;
                $('#pagination-paginate .pagination').html(response.data.paging);
            } else {
//                $('#simple-table tbody').html("<tr><td colspan='8' style='text-align:center; color:red;'>No Data Found.</td></tr>");
            }
            $(".page-loading").addClass("hidden");
        }, function myError(response) {
            //Error Code//
        });

        return false;
    }

    $scope.confirmUpload = function (id) {
        var paymentFileId = $stateParams['id'];
        confirm("Are you sure you want to confirm ? ", function (data) {
            if (data) {
                window.location = siteUrl + "merchant/payments/confirmUpload/" + paymentFileId
            }
        }, {return: true});
    }

    $scope.cancelUpload = function (id) {
        var paymentFileId = $stateParams['id'];
        confirm("Are you sure you want to cancel ? ", function (data) {
            if (data) {
                window.location = siteUrl + "merchant/payments/cancelUpload/" + paymentFileId
            }
        }, {return: true});
    }

});

app.controller('ImportPaymentsCtrl', function ($scope) {
    $('#file').ace_file_input({
        no_file: 'No File ...',
        btn_choose: 'Choose',
        btn_change: 'Change',
        droppable: false,
        onchange: null,
        thumbnail: false, //| true | large
        whitelist: 'xls|xlsx',
//        blacklist: 'exe|php'
        //onchange:''
        //
    });
    $('#file').on('change', function (e) {
        e.preventDefault();
        var value = $(this).val();
        var ext = value.substring(value.lastIndexOf('.') + 1);
        var ext = ext.toLowerCase();
        var extList = ["xls", "xlsx", "csv"];
        if ($.inArray(ext, extList) < 0) {
            $(this).val('');
            $('label a.remove').click();
            alert("Invalid input file format! Please upload only excel file");
            return false;
        } else {
            return true;
        }
    });
    //datepicker value and options
    $('.datepicker').datepicker();
});
//////////////////////////////////
function getParameterByName(name, url) {
    if (!url)
        url = window.location.href;
    name = name.replace(/[\[\]]/g, "\\$&");
    var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
            results = regex.exec(url);
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
