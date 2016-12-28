/**
 * @name customerApp
 * @description
 * #customerApp
 *
 * Main module of the application.
 */
var app = angular
        .module('customerApp', ['ui.router'])
        .config(function ($stateProvider, $urlRouterProvider) {
            //cfpLoadingBarProvider.includeSpinner = true;
            $urlRouterProvider.otherwise('/dashboard');

            $stateProvider
                    .state('dashboard', {
                        url: '/dashboard',
                        title: 'Dashboard',
                        templateUrl: 'views/customer/dashboard.html'
                    })
//                    .state('profile-setting', {
//                        url: '/profile-setting',
//                        title: 'Profile Setting',
//                        controller: 'ProfileCtrl',
//                        templateUrl: 'views/customer/profile-setting.html'
//                    })
                    .state('change-password', {
                        url: '/change-password',
                        title: 'Change Password',
                        controller: 'ProfileCtrl',
                        templateUrl: 'views/customer/change-password.html'
                    })
                    .state('payment-and-bills', {
                        url: '/payment-and-bills',
                        title: 'Payment & Bills',
                        controller: 'PaymentsCtrl',
                        templateUrl: 'views/customer/upcoming-payments.html'
                    })
                    .state('pay-now', {
                        url: '/pay-now/:uniq_id',
                        title: 'Pay Now',
                        controller: 'PaymentsCtrl',
                        templateUrl: 'views/customer/pay-now.html'
                    })
                    .state('payment-history', {
                        url: '/payment-history',
                        title: 'Payment History',
                        controller: 'PaymentsCtrl',
                        templateUrl: 'views/customer/payment-history.html'
                    })
        })
        .run(['$rootScope', '$location', '$state', function ($rootScope, $location, $state) {

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
app.controller('PaymentsCtrl', function ($scope, $http, $stateParams, $window) {

    $scope.viewUpcomingPayments = function () {
        $http.get(siteUrl + "customer/payments/ajaxUpcomingPayments", {
        }).success(function (data, status, headers, config) {
            if (data.status == 'success') {
                $scope.payments = data.data;
            } else {
                $('#upcoming-payments tbody').html("<tr><td colspan='8' style='text-align:center;color:red;'>No Data Found</td></tr>");
            }
        });
    }

    $scope.viewPaymentHistory = function () {
        $http.get(siteUrl + "customer/payments/ajaxPaymentHistory", {
        }).success(function (data, status, headers, config) {
            if (data.status == 'success') {
                $scope.payments = data.data;
            } else {
                $('#payment-history tbody').html("<tr><td colspan='8' style='text-align:center;color:red;'>No Data Found</td></tr>");
            }
        });
    }

    $scope.viewPaymentDetail = function () {
        var uniqId = $stateParams.uniq_id;
        $http.get(siteUrl + "customer/payments/ajaxViewPaymentDetails/" + uniqId, {
        }).success(function (data, status, headers, config) {
            if (data.status == 'success') {
                console.log(data.payment);
                var payment = data.payment;
                $scope.payment = payment
                if (payment.payee_custom_fields) {
                    $scope.payment.payee_custom_fields = JSON.parse(payment.payee_custom_fields);
                }
                if (payment.payment_custom_fields) {
                    $scope.payment.payment_custom_fields = JSON.parse(payment.payment_custom_fields);
                }
            } else {
//                $('#payment-history tbody').html("<tr><td colspan='8' style='text-align:center;color:red;'>No Data Found</td></tr>");
            }
        });
    };

    $scope.paypalRedirect = function (payment) {
        //window.location.href = siteUrl + "customer/payments/pay-now-redirect/" + payment.uniq_id;
        $window.location.href = "customer/payments/pay-now-redirect/" + payment.uniq_id;

    }

});

app.controller('ProfileCtrl', function ($scope, $rootScope, $http) {
//    $scope.getProfileData = function () {
//        $http.post(siteUrl + "users/ajaxGetProfileData").then(function (response) {
//            $scope.user = response.data;
//            $scope.user_detail = response.data.user_detail;
//        }, 'json');
//    }

    $scope.changePassword = function () {
        $http.post(siteUrl + "users/ajaxChangePasssword", {
            'old_password': $scope.old_password,
            'password1': $scope.password1,
            'password2': $scope.password2
        }).success(function (response, status, headers, config) {
            console.log(response);
            if (response.status == 'success') {
                $rootScope.success('Password Changed Successfully!!');
                $('#changePassword')[0].reset();
            } else {
                $rootScope.error(response.msg);
            }
        });
        return false;
    }
});

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



