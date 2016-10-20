/**
 * @name AceApp
 * @description
 * # AceApp
 *
 * Main module of the application.
 */
var app = angular
        .module('adminApp', ['ui.router'])
        .config(function ($stateProvider, $urlRouterProvider) {

            //cfpLoadingBarProvider.includeSpinner = true;

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
                    .state('add-branch-admin', {
                        url: '/add-branch-admin',
                        title: 'Add Branch Admin',
                        templateUrl: 'views/admin/add-branch-admin.html'
                    })
                    .state('branch-admin-listing', {
                        url: '/branch-admin-listing',
                        title: 'View All Branch Admins',
                        templateUrl: 'views/admin/branch-admin-listing.html'
                    })
                    .state('view-merchants', {
                        url: '/view-merchants',
                        title: 'View Merchants',
                        templateUrl: 'views/admin/view-merchants.html'
                    })
                    .state('view-customers', {
                        url: '/view-customers',
                        title: 'View Customers',
                        templateUrl: 'views/admin/view-customers.html'
                    })
                    .state('view-payments', {
                        url: '/view-payments',
                        title: 'View Payments',
                        templateUrl: 'views/admin/view-payments.html'
                    })

        })
        .run(function ($rootScope) {

        });
//////////////////////////////////Controller Code/////////////////////////////
app.controller('AdminProfileCtrl', function ($scope, $http) {
    $scope.fillAdminDetails = function () {
        $http.post(siteUrl + "admin/users/ajaxGetProfileData").then(function (response) {
            console.log(response.data);
            $scope.user = response.data;
        });
    }
    $scope.updateAdminProfile = function () {
        $http.post(siteUrl + "admin/users/ajaxUpdateProfile", {
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
});

app.controller('ChangePasswordCtrl', function ($scope, $http) {
    $scope.changePassword = function () {
        $http.post(siteUrl + "admin/users/ajaxChangePasssword", {
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



