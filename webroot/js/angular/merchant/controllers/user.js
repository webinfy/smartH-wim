///////////User Section By prakash starts here\\\\\\\\\\\\\\
app.controller('UserCtrl', function ($scope, $http, $stateParams, $window, $timeout) {

    $scope.checkNameAvail = function (value) {
        if (value) {
            $http.get(siteUrl + "merchant/users/ajaxNameAvail?name=" + value).then(function (response) {
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
            $http.get(siteUrl + "merchant/users/ajaxEmailAvail?email=" + value).then(function (response) {
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


    $scope.addUser = function () {
        $http.post(siteUrl + "merchant/users/ajaxAddUser", {
            'user': $scope.user
        }).success(function (response, status, headers, config) {
            if (response.status == 'success') {
                $window.location.href = siteUrl + 'merchant/#/view-all-user';
                $('#view-success-msg').show().delay(4000).slideUp();
                $('#view-suc-msg-content').html(response.msg).show();

//                    $('#success-msg').show().delay(4000).slideUp();
//                    $('#suc-msg-content').html(data.msg).show();
            } else {
                $('#error-msg').show().delay(4000).slideUp();
                $('#err-msg-content').html(response.msg).show();
            }
        });
    }
    $scope.getReqParams = function () {
        return $scope.generateErrorOnServer ? '?errorCode=' + $scope.serverErrorCode + '&errorMessage=' + $scope.serverErrorMsg : '';
    };
    $scope.getUser = function () {
        $http.get(siteUrl + "merchant/users/ajaxFetchUsers").then(function (response) {
            if (response.data.status == 'success') {
                $scope.listingUsers = response.data.data;
            }
        });
    }
    $scope.getEditUser = function () {
        var userId = $stateParams['id'];
        $http.get(siteUrl + "merchant/users/ajaxGetEditUser/" + userId).then(function (response) {
            if (response.data.status == 'success') {
                $scope.user = response.data.data;
            }
        });
    }
    $scope.editUser = function (editId) {
        if (editId) {
            $http.post(siteUrl + "merchant/users/ajaxEditUser/" + editId, {
                'user': $scope.user
            }).success(function (response, status, headers, config) {
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
    $scope.deleteUser = function (id) {
        var msg = "Are you sure you want to delete this user?";
        confirm(msg, function (data) {
            if (data) {
                $http.get(siteUrl + "merchant/users/ajaxDeleteUser/" + id).then(function (response) {
                    if (response.data.status == 'success') {
                        $('#user-id-' + id).remove();
                        $('#view-success-msg').show().delay(4000).slideUp();
                        $('#view-suc-msg-content').html(response.data.msg).show();
                    }
                });
            }
        }, {return: true});
    }
    $scope.inActivateUser = function (id) {
        var msg = "Are you sure you want to inactivate this user?";
        confirm(msg, function (data) {
            if (data) {
                $http.get(siteUrl + "merchant/users/ajaxInActivateUser/" + id).then(function (response) {
                    if (response.data.status == 'success') {
//                        $window.location.reload();
                        $('#view-success-msg').show().delay(4000).slideUp();
                        $('#view-suc-msg-content').html(response.data.msg).show();
                        $scope.listingUsers = response.data.users;
                    }
                });
            }
        }, {return: true});
    }
    $scope.activateUser = function (id) {
        var msg = "Are you sure you want to activate this user?";
        confirm(msg, function (data) {
            if (data) {
                $http.get(siteUrl + "merchant/users/ajaxActivateUser/" + id).then(function (response) {
                    if (response.data.status == 'success') {
//                        $window.location.reload();
                        $('#view-success-msg').show().delay(4000).slideUp();
                        $('#view-suc-msg-content').html(response.data.msg).show();
                        $scope.listingUsers = response.data.users;
                    }
                });
            }
        }, {return: true});
    }
});
///////////User Section By prakash ends here\\\\\\\\\
