app.controller('ProfileCtrl', function ($scope, $rootScope, $http, $timeout, $compile, Upload) {

    if ($('.image-editor').length) {
        $('.image-editor').cropit();
    }

    $scope.editMerchant = function (file, editId) {

//        $scope.formUpload = true;
//        if (file != null) {
//            file.upload = Upload.upload({
//                url: siteUrl + "merchant/users/ajaxEditMerchant/" + editId + '/' + $scope.getReqParams(),
//                data: {merchant: $scope.merchant, file: file}
//            });
//            file.upload.then(function (response) {
//                $("html, body").animate({scrollTop: 0}, "slow");
//                var data = response.data;
//                if (data.status == 'success') {
//                    $scope.merchant = data.merchant
//                    $rootScope.success(data.msg);
//                } else if (data.status == 'error') {
//                    $rootScope.error(data.msg);
//                } else {
//                    $rootScope.error('Some error occured. Please try again!!.');
//                }
//            });
//        } else {

        var imageData = $('.image-editor').cropit('export');
        $http.post(siteUrl + "merchant/users/ajaxEditMerchant/" + editId, {
            merchant: $scope.merchant,
            merchant_profile: $scope.merchant_profile,
            croppedImage: imageData
        }).success(function (response, status, headers, config) {
            $("html, body").animate({scrollTop: 0}, "slow");
            var data = response;
            if (data.status == 'success') {
                $scope.merchant = data.merchant
                $rootScope.success(data.msg);
            } else if (data.status == 'error') {
                $rootScope.error(data.msg);
            } else {
                $rootScope.error('Some error occured. Please try again!!.');
            }
        });
//        }
    };

    $scope.getReqParams = function () {
        return $scope.generateErrorOnServer ? '?errorCode=' + $scope.serverErrorCode + '&errorMessage=' + $scope.serverErrorMsg : '';
    };

    $scope.getProfileData = function () {
        $http.get(siteUrl + "merchant/users/ajaxGetProfileData").then(function (response) {
            var data = response.data;
            if (data.status == 'success') {
                $scope.merchant = data.merchant;
                $scope.merchant_profile = data.merchant.merchant_profile;
            } else {
                $scope.merchant = [];
            }
        });
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
        }).success(function (response, status, headers, config) {
            if (response.status == 'success') {
                $rootScope.success('Password changed successfully!!.');
                $('#changePassword')[0].reset();
            } else {
                $rootScope.error(response.msg);
            }
        });
        return false;
    }
});

