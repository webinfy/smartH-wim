/**
 * @name AceApp
 * @description
 * # AceApp
 *
 * Main module of the application.
 */
var app = angular
        .module('branchAdminApp', ['ui.router', 'oc.lazyLoad', 'ngFileUpload'])
        .config(function ($stateProvider, $urlRouterProvider) {

            //cfpLoadingBarProvider.includeSpinner = true;

            $urlRouterProvider.otherwise('/dashboard');

            $stateProvider
                    .state('dashboard', {
                        url: '/dashboard',
                        title: 'Dashboard',
                        templateUrl: 'views/branchadmin/dashboard.html'
                    })
                    .state('profile-setting', {
                        url: '/profile-setting',
                        title: 'Profile Setting',
                        controller: 'AdminProfileCtrl',
                        templateUrl: 'views/branchadmin/profile-setting.html'
                    })
                    .state('change-password', {
                        url: '/change-password',
                        title: 'Change Password',
                        controller: 'ChangePasswordCtrl',
                        templateUrl: 'views/branchadmin/change-password.html'
                    })
                    .state('add-branch-admin', {
                        url: '/add-branch-admin',
                        title: 'Add Branch Admin',
                        templateUrl: 'views/branchadmin/add-branch-admin.html'
                    })
                    .state('branch-admin-listing', {
                        url: '/branch-admin-listing',
                        title: 'View All Branch Admins',
                        templateUrl: 'views/branchadmin/branch-admin-listing.html'
                    })
                    .state('view-merchants', {
                        url: '/view-merchants',
                        title: 'View Merchants',
                        templateUrl: 'views/branchadmin/view-merchants.html'
                    })
                    .state('view-customers', {
                        url: '/view-customers',
                        title: 'View Customers',
                        templateUrl: 'views/branchadmin/view-customers.html'
                    })
                    .state('view-payments', {
                        url: '/view-payments',
                        title: 'View Payments',
                        templateUrl: 'views/branchadmin/view-payments.html'
                    })
                    .state('add-new-merchant', {
                        url: '/add-new-merchant',
                        title: 'Add New Merchant',
                        controller: 'MerchantCtrl',
                        templateUrl: 'views/branchadmin/add-new-merchant.html'
                    })
                    .state('edit-new-merchant', {
                        url: '/edit-new-merchant/:id',
                        title: 'Edit New Merchant',
                        controller: 'MerchantCtrl',
                        templateUrl: 'views/branchadmin/edit-new-merchant.html'
                    })
                    .state('view-all-merchant', {
                        url: '/view-all-merchant',
                        title: 'View All Merchant',
                        controller: 'MerchantCtrl',
                        templateUrl: 'views/branchadmin/view-all-merchant.html'
                    })

        })
        .run(function ($rootScope) {

        });
//////////////////////////////////Controller Code/////////////////////////////
app.controller('AdminProfileCtrl', function ($scope, $http) {
    $scope.fillAdminDetails = function () {
        $http.post(siteUrl + "branchadmin/users/ajaxGetProfileData").then(function (response) {
            $scope.user = response.data;
        });
    }
    $scope.updateAdminProfile = function () {
        $http.post(siteUrl + "branchadmin/users/ajaxUpdateProfile", {
            'user': $scope.user
        }).success(function (response, status, headers, config) {
            if (response.status == 'success') {
                $('#success-msg').show().delay(3000).slideUp();
                $('#view-suc-msg-content').html(response.msg);
            } else {
                $('#error-msg').show().delay(3000).slideUp();
                $('#view-err-msg-content').html(response.msg);
            }
        });
        return false;
    }
});
app.controller('ChangePasswordCtrl', function ($scope, $http) {
    $scope.changePassword = function () {
        $http.post(siteUrl + "branchadmin/users/ajaxChangePasssword", {
            'old_password': $scope.old_password,
            'password1': $scope.password1,
            'password2': $scope.password2
        }).success(function (response, status, headers, config) {
            if (response.status == 'success') {
                $('#success-msg').show().delay(3000).slideUp();
                $('#view-suc-msg-content').html(response.msg);
                $scope.old_password = '';
                $scope.password1 = '';
                $scope.password2 = '';
            } else {
                $('#error-msg').show().delay(3000).slideUp();
                $('#view-err-msg-content').html(response.msg);
            }
        });
        return false;
    }
});

///////////Merchant Section By prakash starts here\\\\\\\\\\\\\\
app.controller('MerchantCtrl', function ($scope, $http, $stateParams,$state, Upload, $window, $timeout) {

    $scope.checkNameAvail = function (value) {
        if (value) {
            $http.get(siteUrl + "branchadmin/merchants/ajaxNameAvail?name=" + value).then(function (response) {
                if (response.data.status == 'success') {
                    if (response.data.avail == 1) {
                        $('#name-avail').text('Name available!!').css({'color': 'green'}).show().delay(3000).fadeOut();
                    } else if (response.data.avail == 0) {
                        $('#name-avail').text('Name not available!!').css({'color': 'red'}).show().delay(3000).fadeOut();
                    }
                }
            });
        }
    };
    $scope.checkEmailAvail = function (value) {
        if (value) {
            $http.get(siteUrl + "branchadmin/merchants/ajaxEmailAvail?email=" + value).then(function (response) {
                if (response.data.status == 'success') {
                    if (response.data.avail == 1) {
                        $('#email-avail').text('Email available!!').css({'color': 'green'}).show().delay(3000).fadeOut();
                    } else if (response.data.avail == 0) {
                        $('#email-avail').text('Email not available!!').css({'color': 'red'}).show().delay(3000).fadeOut();
                    }
                }
            });
        }
    };

    $scope.addMerchant = function (file) {
        $scope.formUpload = true;
        if (file != null) {
            file.upload = Upload.upload({
                url: siteUrl + "branchadmin/merchants/ajaxAddMerchant" + $scope.getReqParams(),
                data: {merchant: $scope.merchant, file: file}
            });
            file.upload.then(function (response) {
                var data = response.data;
                if (data.status == 'success') {
                    $window.location.href = siteUrl + 'branchadmin/#/view-all-merchant';
                    $('#view-success-msg').show().delay(4000).slideUp();
                    $('#view-suc-msg-content').html(data.msg).show();

//                    $('#success-msg').show().delay(4000).slideUp();
//                    $('#suc-msg-content').html(data.msg).show();
                } else {
                    $('#error-msg').show().delay(4000).slideUp();
                    $('#err-msg-content').html(data.msg).show();
                }
            });
        }
    };
    $scope.getReqParams = function () {
        return $scope.generateErrorOnServer ? '?errorCode=' + $scope.serverErrorCode + '&errorMessage=' + $scope.serverErrorMsg : '';
    };
    $scope.getMerchant = function () {
        $http.get(siteUrl + "branchadmin/merchants/ajaxFetchMerchants").then(function (response) {
            if (response.data.status == 'success') {
                $scope.listingMerchants = response.data.data;
            }
        });
    }
    $scope.getEditMerchant = function () {
        var merchantId = $stateParams['id'];
        $http.get(siteUrl + "branchadmin/merchants/ajaxGetEditMerchant/" + merchantId).then(function (response) {
            if (response.data.status == 'success') {
                $scope.merchant = response.data.data;
            }
        });
    }
    $scope.editMerchant = function (file, editId) {
        $scope.formUpload = true;
        if (file != null) {
            file.upload = Upload.upload({
                url: siteUrl + "branchadmin/merchants/ajaxEditMerchant/" + editId + '/' + $scope.getReqParams(),
                data: {merchant: $scope.merchant, file: file}
            });
            file.upload.then(function (response) {
                $("html, body").animate({scrollTop: 0}, "slow");
                var data = response.data;
                if (data.status == 'success') {
                    $('#success-msg').show().delay(4000).slideUp();
                    $('#suc-msg-content').html(data.msg).show();
                    $('.merchant-logo > img').attr('src', data.logo);
                } else {
                    $('#error-msg').show().delay(4000).slideUp();
                    $('#err-msg-content').html(data.msg).show();
                }
            });
        } else {
            $http.post(siteUrl + "branchadmin/merchants/ajaxEditMerchant/" + editId, {
                'merchant': $scope.merchant
            }).success(function (response, status, headers, config) {
                $("html, body").animate({scrollTop: 0}, "slow");
                if (response.status == 'success') {
                    $('#success-msg').show().delay(4000).slideUp();
                    $('#suc-msg-content').html(response.msg).show();
                } else {
                    $('#error-msg').show().delay(4000).slideUp();
                    $('#err-msg-content').html(response.msg).show();
                }
            });
        }
    };

    $scope.deleteMerchant = function (id) {
        confirm("Are you sure you want to delete ? ", function (data) {
            if (data) {
                $http.get(siteUrl + "branchadmin/merchants/ajaxDeleteMerchant/" + id).then(function (response) {
                    if (response.data.status == 'success') {
                        $('#merchant-id-' + id).remove();
                        $('#view-success-msg').show().delay(4000).slideUp();
                        $('#view-suc-msg-content').html(response.data.msg).show();
                    }
                });
            }
        }, {return: true});
    };
    $scope.inActivateMerchant = function (id) {
        confirm("Are you sure you want to inactivate this merchant ?", function (data) {
            if (data) {
                $http.get(siteUrl + "branchadmin/merchants/ajaxInActivateMerchant/" + id).then(function (response) {
                    if (response.data.status == 'success') {
//                        $window.location.reload();
                        $('#view-success-msg').show().delay(4000).slideUp();
                        $('#view-suc-msg-content').html(response.data.msg).show();
                        $scope.listingMerchants = response.data.merchants;
//                        setTimeout(function(){
//                            $state.reload();
//                        },2000);
                        
                    }
                });
            }
        }, {return: true});
    };
    $scope.activateMerchant = function (id) {
        confirm("Are you sure you want to activate this merchant ?", function (data) {
            if (data) {
                $http.get(siteUrl + "branchadmin/merchants/ajaxActivateMerchant/" + id).then(function (response) {
                    if (response.data.status == 'success') {
//                        $window.location.reload();
                        $('#view-success-msg').show().delay(4000).slideUp();
                        $('#view-suc-msg-content').html(response.data.msg).show();
                        $scope.listingMerchants = response.data.merchants;
//                         setTimeout(function(){
//                            $state.reload();
//                        },2000);
                    }
                });
            }
        }, {return: true});
    };

});
///////////Merchant Section By prakash ends here\\\\\\\\\



