/**
 * @name adminApp
 * @description
 * # adminApp
 *
 * Main module of the application.
 */

var app = angular
        .module('adminApp', ['ui.router', 'oc.lazyLoad', 'ngFileUpload'])
        .config(function ($stateProvider, $urlRouterProvider) {

            $urlRouterProvider.otherwise('/dashboard');

            $stateProvider
                    .state('dashboard', {
                        url: '/dashboard',
                        title: 'Dashboard',
                        templateUrl: 'views/admin/dashboard.html'
                    })
                    .state('profile-setting', {
                        url: '/profile-setting',
                        title: 'Profile Setting',
                        controller: 'AdminProfileCtrl',
                        templateUrl: 'views/admin/profile-setting.html'
                    })
                    .state('change-password', {
                        url: '/change-password',
                        title: 'Change Password',
                        controller: 'ChangePasswordCtrl',
                        templateUrl: 'views/admin/change-password.html'
                    })
                    .state('add-new-merchant', {
                        url: '/add-new-merchant',
                        title: 'Add New Merchant',
                        controller: 'MerchantCtrl',
                        templateUrl: 'views/admin/add-new-merchant.html'
                    })
                    .state('edit-merchant', {
                        url: '/edit-merchant/:id',
                        title: 'Edit Merchant',
                        controller: 'MerchantCtrl',
                        templateUrl: 'views/admin/edit-merchant.html'
                    })
                    .state('view-all-merchant', {
                        url: '/view-all-merchant',
                        title: 'View All Merchant',
                        controller: 'MerchantCtrl',
                        templateUrl: 'views/admin/view-all-merchant.html'
                    })
                    ///Sub Merchant//
                    .state('add-new-submerchant', {
                        url: '/add-new-submerchant',
                        title: 'Add New Sub-Merchant',
                        controller: 'SubMerchantCtrl',
                        templateUrl: 'views/admin/add-new-submerchant.html',
                        resolve: {
                            lazyLoad: ['$ocLazyLoad', function ($ocLazyLoad) {
                                    return $ocLazyLoad.load([
                                        {
                                            name: 'chosen',
                                            files: ['components/chosen/chosen.jquery.js', 'components/angular-chosen-localytics/chosen.js']
                                        },
                                        {
                                            name: 'AceApp',
                                            insertBefore: '#main-ace-style',
                                            files: [
                                                'components/chosen/chosen.css',
                                            ]
                                        }
                                    ]);
                                }]
                        }
                    })
                    .state('edit-submerchant', {
                        url: '/edit-submerchant/:id',
                        title: 'Edit Sub-Merchant',
                        controller: 'SubMerchantCtrl',
                        templateUrl: 'views/admin/edit-submerchant.html',
                        resolve: {
                            lazyLoad: ['$ocLazyLoad', function ($ocLazyLoad) {
                                    return $ocLazyLoad.load([
                                        {
                                            name: 'chosen',
                                            files: ['components/chosen/chosen.jquery.js', 'components/angular-chosen-localytics/chosen.js']
                                        },
                                        {
                                            name: 'AceApp',
                                            insertBefore: '#main-ace-style',
                                            files: [
                                                'components/chosen/chosen.css',
                                            ]
                                        }
                                    ]);
                                }]
                        }
                    })
                    .state('view-all-submerchant', {
                        url: '/view-all-submerchant',
                        title: 'View All SubMerchant',
                        controller: 'SubMerchantCtrl',
                        templateUrl: 'views/admin/view-all-submerchant.html'
                    })
                    .state('split-settlement-mapping', {
                        url: '/split-settlement-mapping',
                        title: 'Split Settlement Mmapping',
                        controller: 'SplitSettlementCtrl',
                        templateUrl: 'views/admin/split-settlement-mapping.html',
                        resolve: {
                            lazyLoad: ['$ocLazyLoad', function ($ocLazyLoad) {
                                    return $ocLazyLoad.load([
                                        {
                                            name: 'chosen',
                                            files: ['components/chosen/chosen.jquery.js', 'components/angular-chosen-localytics/chosen.js']
                                        },
                                        {
                                            name: 'AceApp',
                                            insertBefore: '#main-ace-style',
                                            files: [
                                                'components/chosen/chosen.css',
                                            ]
                                        }
                                    ]);
                                }]
                        }
                    })
                    .state('split-settlement-mapping-list', {
                        url: '/split-settlement-mapping-list',
                        title: 'Split Settlement Mmapping List',
                        controller: 'SplitSettlementCtrl',
                        templateUrl: 'views/admin/split-settlement-mapping-list.html'
                    })
                    .state('edit-split-settlement-mapping', {
                        url: '/edit-split-settlement-mapping/:id',
                        title: 'Edit Split Settlement Mapping',
                        controller: 'SplitSettlementCtrl',
                        templateUrl: 'views/admin/edit-split-settlement-mapping.html',
                        resolve: {
                            lazyLoad: ['$ocLazyLoad', function ($ocLazyLoad) {
                                    return $ocLazyLoad.load([
                                        {
                                            name: 'chosen',
                                            files: ['components/chosen/chosen.jquery.js', 'components/angular-chosen-localytics/chosen.js']
                                        },
                                        {
                                            name: 'AceApp',
                                            insertBefore: '#main-ace-style',
                                            files: [
                                                'components/chosen/chosen.css',
                                            ]
                                        }
                                    ]);
                                }]
                        }
                    })

        })
        .run(function ($rootScope) {
            $rootScope.success = function (msg) {
                $html = "";
                $html += '<div style="display: block;" id="success-msg" class="alert alert-info">';
                $html += '<button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button>';
                $html += '<p><i class="ace-icon fa fa-check"></i>&nbsp;' + msg + '</p>';
                $html += '</div>';
                $('#flash-msg').html($html).show();//.delay(8000).fadeOut();
            };
            $rootScope.error = function (msg) {
                $html = "";
                $html += '<div style="display: block;" id="success-msg" class="alert alert-danger">';
                $html += '<button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button>';
                $html += ' <p><i class="ace-icon fa fa-times"></i>&nbsp;' + msg + '</p>';
                $html += '</div>';
                $('#flash-msg').html($html).show();//.delay(8000).fadeOut();
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
        });

//////////////////////////////////Controller Code/////////////////////////////
app.controller('AdminProfileCtrl', function ($scope, $http, $rootScope) {
    $scope.fillAdminDetails = function () {
        $http.post(siteUrl + "admin/users/ajaxGetProfileData").then(function (response) {
            $scope.user = response.data;
        });
    }
    $scope.updateAdminProfile = function () {
        $http.post(siteUrl + "admin/users/ajaxUpdateProfile", {'user': $scope.user}).success(function (response, status, headers, config) {
            if (response.status == 'success') {
                $rootScope.success(response.msg);
            } else {
                $rootScope.error(response.msg);
            }
        });
        return false;
    }
});
app.controller('ChangePasswordCtrl', function ($scope, $http, $rootScope) {
    $scope.changePassword = function () {
        $http.post(siteUrl + "admin/users/ajaxChangePasssword", {
            'old_password': $scope.old_password,
            'password1': $scope.password1,
            'password2': $scope.password2
        }).success(function (response, status, headers, config) {
            if (response.status == 'success') {
                $rootScope.success(response.msg);
                $('#changePassword')[0].reset();
            } else {
                $rootScope.error(response.msg);
            }
        });
        return false;
    }
});

///////////Merchant Section By prakash starts here\\\\\\\\\\\\\\
app.controller('MerchantCtrl', function ($scope, $rootScope, $http, $stateParams, $state, Upload, $window, $timeout) {

    if ($('.image-editor').length) {
        $('.image-editor').cropit();
    }

    $scope.addMerchant = function (file) {
        var imageData = $('.image-editor').cropit('export');
        $http.post(siteUrl + "admin/merchants/ajaxAddMerchant", {
            merchant: $scope.merchant,
            merchant_profile: $scope.merchant_profile,
            croppedImage: imageData
        }).then(function (response) {
            if (response.data.status == 'success') {
                $rootScope.success(response.data.msg);
                alert(response.data.msg);
                $window.location.href = siteUrl + 'admin/#/view-all-merchant';
            } else {
                $rootScope.error(response.data.msg);
            }
        });

        /*
         $scope.formUpload = true;
         if (file != null) {
         file.upload = Upload.upload({
         url: siteUrl + "admin/merchants/ajaxAddMerchant" + $scope.getReqParams(),
         data: {
         merchant: $scope.merchant,
         merchant_profile: $scope.merchant_profile,
         file: file
         }
         });
         file.upload.then(function (response) {
         var data = response.data;
         if (data.status == 'success') {
         $rootScope.success(data.msg);
         alert(data.msg);
         $window.location.href = siteUrl + 'admin/#/view-all-merchant';
         } else {
         $rootScope.error(data.msg);
         }
         });
         }
         */
    };

    $scope.getMerchants = function () {
        $http.get(siteUrl + "admin/merchants/ajaxFetchMerchants").then(function (response) {
            if (response.data.status == 'success') {
                $scope.merchants = response.data.merchants;
            }
        });
    }

    $scope.getEditMerchant = function () {
        var merchantId = $stateParams['id'];
        $http.get(siteUrl + "admin/merchants/ajaxGetEditMerchant/" + merchantId).then(function (response) {
            if (response.data.status == 'success') {
                $scope.merchant = response.data.data;
                $scope.merchant.password = '';
                $scope.merchant_profile = response.data.data.merchant_profile;
            }
        });
    }

    $scope.editMerchant = function (file, editId) {
        $scope.formUpload = true;
//        if (file != null) {
//            file.upload = Upload.upload({
//                url: siteUrl + "admin/merchants/ajaxEditMerchant/" + editId + '/' + $scope.getReqParams(),
//                data: {
//                    merchant: $scope.merchant,
//                    merchant_profile: $scope.merchant_profile,
//                    file: file
//                }
//            });
//            file.upload.then(function (response) {
//                $("html, body").animate({scrollTop: 0}, "slow");
//                var data = response.data;
//                if (data.status == 'success') {
//                    $rootScope.success(data.msg);
//                    $scope.merchant = data.merchant;
//                } else {
//                    $rootScope.error(data.msg);
//                }
//            });
//        } else {

        var imageData = $('.image-editor').cropit('export');
        $http.post(siteUrl + "admin/merchants/ajaxEditMerchant/" + editId, {
            merchant: $scope.merchant,
            merchant_profile: $scope.merchant_profile,
            croppedImage: imageData,
        }).success(function (response, status, headers, config) {
            $("html, body").animate({scrollTop: 0}, "slow");
            var data = response;
            if (data.status == 'success') {
                //$rootScope.success(data.msg);
                $scope.merchant = data.merchant;
                $rootScope.success(data.msg);
                alert(data.msg);
                $window.location.href = siteUrl + 'admin/#/view-all-merchant';
            } else {
                $rootScope.error(data.msg);
            }
        });
//        }
    };

    $scope.checkNameAvail = function (value) {
        if (value) {
            $http.get(siteUrl + "admin/merchants/ajaxNameAvail?name=" + value).then(function (response) {
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
            $http.get(siteUrl + "admin/merchants/ajaxEmailAvail?email=" + value).then(function (response) {
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

    $scope.deleteMerchant = function (id) {
        confirm("Are you sure you want to delete ? ", function (data) {
            if (data) {
                $http.get(siteUrl + "admin/merchants/ajaxDeleteMerchant/" + id).then(function (response) {
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
                $http.get(siteUrl + "admin/merchants/ajaxInActivateMerchant/" + id).then(function (response) {
                    if (response.data.status == 'success') {
                        $('#view-success-msg').show().delay(4000).slideUp();
                        $('#view-suc-msg-content').html(response.data.msg).show();
                        $scope.merchants = response.data.merchants;
                    }
                });
            }
        }, {return: true});
    };

    $scope.activateMerchant = function (id) {
        confirm("Are you sure you want to activate this merchant ?", function (data) {
            if (data) {
                $http.get(siteUrl + "admin/merchants/ajaxActivateMerchant/" + id).then(function (response) {
                    if (response.data.status == 'success') {
                        $('#view-success-msg').show().delay(4000).slideUp();
                        $('#view-suc-msg-content').html(response.data.msg).show();
                        $scope.merchants = response.data.merchants;
                    }
                });
            }
        }, {return: true});
    };

    $scope.getReqParams = function () {
        return $scope.generateErrorOnServer ? '?errorCode=' + $scope.serverErrorCode + '&errorMessage=' + $scope.serverErrorMsg : '';
    };

});
///////////Merchant Section By prakash ends here\\\\\\\\\


///////////SubMerchant Section By Pradeepta Start Here ///////////////
app.controller('SubMerchantCtrl', function ($scope, $rootScope, $http, $stateParams, $state, Upload, $window, $timeout) {

    $('.select2').select2();

    $scope.getAllMerchants = function () {
        $http.get(siteUrl + "admin/merchants/ajaxGetAllMerchants").success(function (response, status, headers, config) {
            if (response.status == 'success') {
                $scope.merchants = response.merchants;
            }
        });
    };

    $scope.addSubMerchant = function () {
        $http.post(siteUrl + "admin/merchants/ajaxAddSubMerchant", {submerchant: $scope.submerchant}).success(function (response, status, headers, config) {
            if (response.status == 'success') {
                $rootScope.success(response.msg);
                setTimeout(function () {
                    $window.location = siteUrl + 'admin/#/view-all-submerchant';
                }, 2000);
            } else {
                $rootScope.error(response.msg);
            }
        });
    };

    $scope.getSubMerchants = function (option) {
        if (option == 'all') {
            $scope.searchby = "";
            $scope.keyword = "";
        }
        $http.post(siteUrl + "admin/merchants/ajaxFetchSubMerchants", {searchby: $scope.searchby, keyword: $scope.keyword}).then(function (response) {
            if (response.data.status == 'success') {
                $scope.submerchants = response.data.submerchants;
            }
        });
    }

    $scope.deleteSubMerchant = function (id) {
        confirm("Are you sure you want to delete ? ", function (data) {
            if (data) {
                $http.get(siteUrl + "admin/merchants/ajaxDeleteSubMerchant/" + id).then(function (response) {
                    if (response.data.status == 'success') {
                        $('#submerchant-id-' + id).remove();
                        $rootScope.success('SubMerchant deleted Successfully!!');
                    } else {
                        $rootScope.error('Some error occured.Please try again!!');
                    }
                });
            }
        }, {return: true});
    };

    $scope.getSubMerchantDetails = function () {
        var subMerchantId = $stateParams['id'];
        $http.get(siteUrl + "admin/merchants/ajaxGetSubMerchantDetails/" + subMerchantId).then(function (response) {
            if (response.data.status == 'success') {
                $scope.submerchant = response.data.submerchant;
                $scope.merchant_id = response.data.submerchant.user.id;
            }
        });
    }

    $scope.editSubMerchant = function () {
        $http.post(siteUrl + "admin/merchants/ajaxEditSubMerchant", {'merchant_id': $scope.merchant_id, 'submerchant': $scope.submerchant}).success(function (response, status, headers, config) {
            if (response.status == 'success') {
                $rootScope.success('Sub-Merchant Edited Successfully!!');
                setTimeout(function () {
                    $window.location = siteUrl + 'admin/#/view-all-submerchant';
                }, 2000);
            } else {
                $rootScope.error('Some error occured.Please try again!!.');
            }
        });
    };

});
///////////SubMerchant Section By Pradeepta End ///////////////

///////////Split Settlement Section By Pradeepta Start Here ///////////////
app.controller('SplitSettlementCtrl', function ($scope, $rootScope, $http, $stateParams, $state, Upload, $window, $timeout) {

    $('.select2').select2();

    $scope.getSplitSettlements = function () {
        $http.get(siteUrl + "admin/merchants/ajaxGetSplitSettlements").success(function (response, status, headers, config) {
            if (response.status == 'success') {
                $scope.splitSettlements = response.split_settlements;
            }
        });
    };

    $scope.deleteSplitSettlement = function (id) {
        confirm("Are you sure you want to delete ? ", function (data) {
            if (data) {
                $http.post(siteUrl + "admin/merchants/ajaxDeleteSplitSettlements/" + id).success(function (response, status, headers, config) {
                    if (response.status == 'success') {
                        $rootScope.success('Split Settlement Deleted Successfully!!');
                        $('#split-settlement-id-' + id).remove();
                    } else {
                        $rootScope.error('Some error occured.Please try again!!.');
                    }
                });
            }
        }, {return: true});
    };

    $scope.getSplitSettlement = function () {
        var id = $stateParams.id;
        $http.get(siteUrl + "admin/merchants/ajaxGetSplitSettlement/" + id).success(function (response, status, headers, config) {
            if (response.status == 'success') {
                $scope.split_settlement = response.split_settlement;
                $http.get(siteUrl + "admin/merchants/ajaxWebfronts/" + response.split_settlement.merchant_id).success(function (response, status, headers, config) {
                    if (response.status == 'success') {
                        $scope.webfronts = response.webfronts;
                    }
                });
                $http.get(siteUrl + "admin/merchants/ajaxFetchPaymentFields/" + response.split_settlement.webfront_id).success(function (response, status, headers, config) {
                    if (response.status == 'success') {
                        $scope.payment_fileds = response.payment_fileds;
                        $scope.submerchants = response.submerchants;
                    }
                });
            }
        });
    };


    $scope.getAllMerchants = function () {
        $http.get(siteUrl + "admin/merchants/ajaxGetAllMerchants").success(function (response, status, headers, config) {
            if (response.status == 'success') {
                $scope.merchants = response.merchants;
            }
        });
    };

    $scope.fetchWebfronts = function (merchantId) {
        if (merchantId) {
            $http.get(siteUrl + "admin/merchants/ajaxWebfronts/" + merchantId).success(function (response, status, headers, config) {
                if (response.status == 'success') {
                    $scope.webfronts = response.webfronts;
                }
            });
        } else {
            $scope.webfronts = [];
        }
    };

    $scope.fetchPaymentFields = function (webfrontId) {
        if (webfrontId) {
            $http.get(siteUrl + "admin/merchants/ajaxFetchPaymentFields/" + webfrontId).success(function (response, status, headers, config) {
                if (response.status == 'success') {
                    $scope.payment_fileds = response.payment_fileds;
                    $scope.submerchants = response.submerchants;
                } else {
                    $scope.payment_fileds = null;
                    $scope.submerchants = null;
                }
            });
        } else {
            $scope.payment_fileds = null;
            $scope.submerchants = null;
        }
    };

    $scope.addSplitSettlement = function (webfrontId) {
        $(".page-loading").removeClass("hidden");
        var formData = $('#splitSettlement').serialize();
        $http({
            method: "POST",
            dataType: 'JSON',
            url: siteUrl + "admin/merchants/ajaxAddSplitSettlement",
            data: formData,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function (response) {
            if (response.data.status == 'success') {
                $rootScope.success(response.data.msg);
                setTimeout(function () {
                    $window.location = siteUrl + 'admin/#/split-settlement-mapping-list';
                }, 2000);
            } else {
                $rootScope.error(response.data.msg);
            }
            $(".page-loading").addClass("hidden");
        });
    }

});
///////////Split Settlement Section By Pradeepta End Here ///////////////

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



