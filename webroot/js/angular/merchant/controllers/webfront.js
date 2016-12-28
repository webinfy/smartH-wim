//*********************Web Front Controller Code Starts here by Prakash*****************************
app.controller('WebFrontCtrl', function ($scope, $http, $timeout, $compile, $window, $stateParams, $state, $rootScope, Upload) {

    if ($('.image-editor').length) {
        $('.image-editor').cropit();
    }

    $scope.cropitStart = function (value) {
        if ($('.image-editor').length) {
            $('.image-editor').cropit();
        }
    }

    $scope.autoFillMerchantData = function (value) {
        $http.get(siteUrl + "merchant/webfronts/ajaxGetMerchantData").then(function (response) {
            $scope.webfront = response.data.webfront;
        });
    }

    $scope.checkUrlAvail = function (value) {
        if (value) {
            $http.get(siteUrl + "merchant/webfronts/ajaxNameAvail?name=" + value).then(function (response) {
                if (response.data.status == 'success') {
                    if (response.data.avail == 1) {
                        $('#name-avail').text('Name available!!').css({'color': 'green'}).show();
                    } else if (response.data.avail == 0) {
                        $('#name-avail').text('Name not available!!').css({'color': 'red'}).show();
                    }
                }
            });
        }
    };

    $scope.createWebfront = function (file) {
        $scope.formUpload = true;
//        if (file != null) {
//            file.upload = Upload.upload({
//                url: siteUrl + "merchant/webfronts/create" + $scope.getReqParams(),
//                data: {webfront: $scope.webfront, file: file}
//            });
//            file.upload.then(function (response) {
//                var data = response.data;
//                if (data.status == 'success') {
//                    $rootScope.success('Webfront created successfully!!');
//                    setTimeout(function () {
//                        $window.location.href = siteUrl + 'merchant/#/edit-basic-web-front/' + data.webfront.id + '?tab=payee-information';
//                    }, 2000);
//                } else {
//                    $rootScope.error(data.msg);
//                }
//            });
//        } else {
        var imageData = $('.image-editor').cropit('export');
        $http.post(siteUrl + "merchant/webfronts/create", {webfront: $scope.webfront, croppedImage: imageData}).then(function (response) {
            var data = response.data;
            if (data.status == 'success') {
                $rootScope.success('Webfront created successfully!!');
                setTimeout(function () {
                    $window.location.href = siteUrl + 'merchant/#/edit-basic-web-front/' + data.webfront.id + '?tab=payee-information';
                }, 2000);
            } else {
                $rootScope.error(data.msg);
            }
        });
//        }
    };

    $scope.editWebfront = function (file) {

//        $scope.formUpload = true;
//        if (file != null) {
//            $(".page-loading").removeClass("hidden");
//            file.upload = Upload.upload({
//                url: siteUrl + "merchant/webfronts/edit" + $scope.getReqParams(),
//                data: {webfront: $scope.webfront, file: file}
//            });
//            file.upload.then(function (response) {
//                var data = response.data;
//                $(".page-loading").addClass("hidden");
//                if (data.status == 'success') {
//                    $rootScope.success('Webfront details updated successfully!!');
//                    $scope.webfront = response.data.webfront;//                    
////                  setTimeout(function () {
//                    //$state.reload();
//                    $('a[href=\'#payee-information\']').click();
////                    }, 2000);                    
//                } else {
//                    $rootScope.error('Some error occured.Please try again!!');
//                }
//            });
//        } else {
        $(".page-loading").removeClass("hidden");
        var imageData = $('.image-editor').cropit('export');
        $http.post(siteUrl + "merchant/webfronts/edit", {webfront: $scope.webfront, croppedImage: imageData}).then(function (response) {
            $(".page-loading").addClass("hidden");
            if (response.data.status == 'success') {
                $scope.webfront = response.data.webfront;
                $('a[href=\'#payee-information\']').click();
                $rootScope.success('Webfront details updated successfully!!');
                if (response.data.webfront.logo != '') {
                    $('#logo .img-logo').attr('src', 'files/webfront_logo/' + response.data.webfront.logo);
                }
                $('.cropit-preview-image').attr('src', '');
                $('.cropit-image-input').val('');
                //$state.reload();               
            } else {
                $rootScope.error('Some error occured.Please try again!!');
            }
        });
//        }
    };

    $scope.myWebfronts = function () {
        $http.get(siteUrl + "merchant/webfronts/ajaxMyBasicWebfronts").then(function (response) {
            if (response.data.status == 'success') {
                $scope.webfronts = response.data.webfronts;
            }
        });
    };

    $scope.deleteWebfront = function (id) {
        confirm("Are you sure you want to delete ? ", function (data) {
            if (data) {
                $http.post(siteUrl + "merchant/webfronts/delete/" + id).then(function (response) {
                    if (response.data.status == 'success') {
                        $('#webfront-' + id).remove();
                        $rootScope.success('Webfront deleted successfully!!');
                    } else {
                        $rootScope.error('Some Error occured. Please try again!!');
                    }
                });
            }
        }, {return: true});
    };

    $scope.publishWebfront = function (id) {
        confirm("Are you sure you want to Publish ? ", function (data) {
            if (data) {
                $http.post(siteUrl + "merchant/webfronts/publish/" + id).then(function (response) {
                    if (response.data.status == 'success') {
                        $rootScope.success(response.data.msg);
                        $scope.webfronts = response.data.webfronts;
                    } else {
                        $rootScope.error('Some Error occured. Please try again!!');
                    }
                });
            }
        }, {return: true});
    };

    $scope.unPublishWebfront = function (id) {
        confirm("Are you sure you want to Unpublish ? ", function (data) {
            if (data) {
                $http.post(siteUrl + "merchant/webfronts/unpublish/" + id).then(function (response) {
                    if (response.data.status == 'success') {
                        $rootScope.success(response.data.msg);
                        $scope.webfronts = response.data.webfronts;
                    } else {
                        $rootScope.error('Some Error occured. Please try again!!');
                    }
                });
            }
        }, {return: true});
    };

    $scope.editCustomerFields = function () {
        $http.post(siteUrl + "merchant/webfronts/ajaxUpdatePayeeFields", {webfront: $scope.webfront, customer_fields: $scope.customer_fields}).then(function (response) {
            if (response.data.status == 'success') {
                $rootScope.success('Customer Fields updated successfully!!');
                $scope.webfront = response.data.webfront;
                $('a[href=\'#payment-information\']').click();
            } else {
                $rootScope.error('Some error occured.Please try again!!');
            }
        });
    };


    $scope.editPaymentFields = function () {
        $http.post(siteUrl + "merchant/webfronts/ajaxUpdatePaymentFields", {webfront: $scope.webfront, payment_fields: $scope.payment_fields}).then(function (response) {
            if (response.data.status == 'success') {
                $scope.webfront = response.data.webfront;
                $rootScope.success('Payment Fields updated successfully!!');
                $('a[href=\'#download-excel\']').click();
            } else {
                $rootScope.error('Some error occured.Please try again!!');
            }
        });
    };

    $scope.getReqParams = function () {
        return $scope.generateErrorOnServer ? '?errorCode=' + $scope.serverErrorCode + '&errorMessage=' + $scope.serverErrorMsg : '';
    };

    if ($stateParams['id'] != 'undefined' && $stateParams['id'] > 0 && !$stateParams['advance']) {
        var id = $stateParams['id'];
        $http.get(siteUrl + "merchant/webfronts/ajaxGetDetails/" + id).then(function (response) {
            if (response.data.status == 'success') {
                $scope.webfront = response.data.webfront;
                if (response.data.webfront.customer_fields.length) {
                    var customer_fields = response.data.webfront.customer_fields;
                    for (var i = 0; i < customer_fields.length; i++) {
                        var filedNo = parseInt(i) + 1;
                        $('#ca' + filedNo + '_chk').trigger('click');
                        if (filedNo == 1)
                            $scope.customer_fields.ca1 = customer_fields[i].name;
                        if (filedNo == 2)
                            $scope.customer_fields.ca2 = customer_fields[i].name;
                        if (filedNo == 3)
                            $scope.customer_fields.ca3 = customer_fields[i].name;
                        if (filedNo == 4)
                            $scope.customer_fields.ca4 = customer_fields[i].name;
                        if (filedNo == 5)
                            $scope.customer_fields.ca5 = customer_fields[i].name;
                        if (filedNo == 6)
                            $scope.customer_fields.ca6 = customer_fields[i].name;

                    }
                }

                ////////////////////////////
                if (response.data.webfront.payment_fields.length) {
                    var payment_fields = response.data.webfront.payment_fields;
                    for (var i = 0; i < payment_fields.length; i++) {
                        var filedNo = parseInt(i) + 1;
                        $('#pa' + filedNo + '_chk').trigger('click');
                        if (filedNo == 1)
                            $scope.payment_fields.pa1 = payment_fields[i].name;
                        if (filedNo == 2)
                            $scope.payment_fields.pa2 = payment_fields[i].name;
                        if (filedNo == 3)
                            $scope.payment_fields.pa3 = payment_fields[i].name;
                        if (filedNo == 4)
                            $scope.payment_fields.pa4 = payment_fields[i].name;
                        if (filedNo == 5)
                            $scope.payment_fields.pa5 = payment_fields[i].name;
                        if (filedNo == 6)
                            $scope.payment_fields.pa6 = payment_fields[i].name;
                        if (filedNo == 7)
                            $scope.payment_fields.pa7 = payment_fields[i].name;
                        if (filedNo == 8)
                            $scope.payment_fields.pa8 = payment_fields[i].name;
                        if (filedNo == 9)
                            $scope.payment_fields.pa9 = payment_fields[i].name;
                        if (filedNo == 10)
                            $scope.payment_fields.pa10 = payment_fields[i].name;

                    }
                }

            }
        });

        if ($stateParams['tab'] != 'undefined' && $stateParams['tab'] != '') {
            $("a[href^='#" + $stateParams['tab'] + "']").click();
        }
    }
    if ($('.datepicker').length) {
        $('.datepicker').datepicker({format: 'yyyy-mm-dd', autoclose: true});
    }


    /////**********************Advance Web front section By prakash starts here**************************

    $scope.createAdvanceWebfront = function (file) {
//        $scope.formUpload = true;
//        if (file != null) {
//            file.upload = Upload.upload({
//                url: siteUrl + "merchant/webfronts/createAdvanceWebfront" + $scope.getReqParams(),
//                data: {webfront: $scope.webfront, file: file}
//            });
//            file.upload.then(function (response) {
//                var data = response.data;
//                if (data.status == 'success') {
//                    $rootScope.success('Webfront created successfully!!');
//                    setTimeout(function () {
//                        $window.location.href = siteUrl + 'merchant/#/edit-advance-web-front/' + data.webfront.id + '/advance?tab=payee-information';
//                    }, 2000);
//                } else {
//                    $rootScope.error(data.msg);
//                }
//            });
//        } else {

        var imageData = $('.image-editor').cropit('export');
//        $http.post(siteUrl + "merchant/webfronts/edit", {webfront: $scope.webfront, croppedImage: imageData}).then(function (response) {

        $http.post(siteUrl + "merchant/webfronts/createAdvanceWebfront", {webfront: $scope.webfront, croppedImage: imageData}).then(function (response) {
            var data = response.data;
            if (data.status == 'success') {
                $rootScope.success('Webfront created successfully!!');
                setTimeout(function () {
                    $window.location.href = siteUrl + 'merchant/#/edit-advance-web-front/' + data.webfront.id + '/advance?tab=payee-information';
                }, 2000);
            } else {
                $rootScope.error(data.msg);
            }
        });
//        }
    };
    $scope.customer_choices = {};
    if ($stateParams['id'] != 'undefined' && $stateParams['id'] > 0 && $stateParams['advance']) {
        var id = $stateParams['id'];
        $http.get(siteUrl + "merchant/webfronts/ajaxAdvanceGetDetails/" + id).then(function (response) {
            if (response.data.status == 'success') {
                $scope.webfront = response.data.webfront;
                $scope.webfront_payment_attributes = response.data.webfront_payment_attributes;
                $scope.webfront_payment_attributes_length = response.data.webfront_payment_attributes.length;
                $scope.total_amount = response.data.total_amount;
                var cust_length = $scope.webfront.customer_fields.length;

                for ($i = 0; $i < cust_length; $i++) {
                    if ($scope.webfront.customer_fields[$i].webfront_field_values.length == 0) {
                        $scope.webfront.customer_fields[$i].webfront_field_values = [{label: 1}];
                    }
                }
                for ($i = 0; $i < 6; $i++) {
                    $scope.customer_choices[$i] = [{label: 'textBox'}];
                }
            }
        });

        if ($stateParams['tab'] != 'undefined' && $stateParams['tab'] != '') {
            $("a[href^='#" + $stateParams['tab'] + "']").click();
        }
    }
    $scope.customerChecked = function (data, i) {
        if (data[i].customer_checkbox != true) {
            //data.splice(i, 1);
            data[i].customer_checkbox = false;
            data[i].name = '';
        }
    };
    $scope.makeCustomerCheckBoxFalse = function (data, i) {
        if (data[i].name == '') {
            data[i].customer_checkbox = false;
        }
    }
    $scope.input_types = [{
            value: 1,
            name: "Textbox"
        }, {
            value: 2,
            name: "Text area"
        }, {
            value: 3,
            name: "Radio Button"
        }, {
            value: 4,
            name: "Dropdown"
        }];

    $scope.validations = [{
            value: 1,
            name: "No Validation"
        }, {
            value: 2,
            name: "Numeric"
        }, {
            value: 3,
            name: "Alphanumeric"
        }, {
            value: 4,
            name: "Character"
        }];

    $scope.finishWebfront = function () {
        $rootScope.success('Webfront created successfully!!');
        setTimeout(function () {
            $window.location = siteUrl + 'merchant/#/advance-webfront-listing';
        }, 2000);
    }

    $scope.editCustomerFieldsAdvance = function () {
        $(".page-loading").removeClass("hidden");
        $http.post(siteUrl + "merchant/webfronts/ajaxUpdateCustomerFieldsAdvance", {webfront: $scope.webfront, customer_fields: $scope.customer_fields, customer_choices: $scope.customer_choices, select_fields: $scope.select_fields, validation_fields: $scope.validation_fields}).then(function (response) {
            if (response.data.status == 'success') {
                $scope.webfront = response.data.webfront;
                var cust_length = $scope.webfront.customer_fields.length;
                for ($i = 0; $i < cust_length; $i++) {
                    if ($scope.webfront.customer_fields[$i].webfront_field_values.length == 0) {
                        $scope.webfront.customer_fields[$i].webfront_field_values = [{label: 1}];
                    }
                }
                $rootScope.success('Customer Fields updated successfully!!');
                $('a[href=\'#payment-information\']').click();
            } else {
                $rootScope.error('Some error occured.Please try again!!');
            }
            $(".page-loading").addClass("hidden");
        });
    };
    $scope.myAdvanceWebfronts = function () {
        $http.get(siteUrl + "merchant/webfronts/ajaxMyAdvanceWebfronts").then(function (response) {
            if (response.data.status == 'success') {
                $scope.webfronts = response.data.webfronts;
            }
        });
    };
    $scope.publishAdvanceWebfront = function (id) {
        confirm("Are you sure you want to Publish ? ", function (data) {
            if (data) {
                $http.post(siteUrl + "merchant/webfronts/publishAdvanceWebfront/" + id).then(function (response) {
                    if (response.data.status == 'success') {
                        $rootScope.success(response.data.msg);
                        $scope.webfronts = response.data.webfronts;
                    } else {
                        $rootScope.error('Some Error occured. Please try again!!');
                    }
                });
            }
        }, {return: true});
    };

    $scope.unPublishAdvanceWebfront = function (id) {
        confirm("Are you sure you want to Unpublish ? ", function (data) {
            if (data) {
                $http.post(siteUrl + "merchant/webfronts/unPublishAdvanceWebfront/" + id).then(function (response) {
                    if (response.data.status == 'success') {
                        $rootScope.success(response.data.msg);
                        $scope.webfronts = response.data.webfronts;
                    } else {
                        $rootScope.error('Some Error occured. Please try again!!');
                    }
                });
            }
        }, {return: true});
    };

    $scope.textBoxes = [];
    $scope.addTextBox = function (data) {
        data.push({label: data.length + 1, value: ''});
    }


    $scope.removeTextBox = function (data, i, id) {
        data.splice(i, 1);
        if (id) {
            $http.post(siteUrl + "merchant/webfronts/removeWebfrontFieldValues/" + id).then(function (response) {
            });
        }
    }
    $scope.addNewChoice = function (i) {
        var newItemNo = $scope.customer_choices[i].length + 1;
        $scope.customer_choices[i].push({'label': 'textBox' + newItemNo});
    };
    $scope.removeChoice = function (data, i) {
        data.splice(i, 1);
    }
//payment attribute parts starts here
    $scope.addPaymentAttribute = function () {
        $http.post(siteUrl + "merchant/webfronts/ajaxAddPaymentAttribute", {paymentAttributeData: $scope.paymentAttributeData, webfront_id: $scope.webfront.id}).then(function (response) {
            if (response.data.status == 'success') {
                $scope.webfront_payment_attributes = response.data.webfront_payment_attributes;
                $scope.webfront_payment_attributes_length = response.data.webfront_payment_attributes.length;
                $scope.total_amount = response.data.total_amount;
                $scope.paymentAttributeData = '';
                $rootScope.success('Payment attribute added successfully!!');
            } else {
                $rootScope.error('Some error occured.Please try again!!');
            }

        });
    };

    $scope.editPaymentAttribute = function (payment_attribute) {
        $http.post(siteUrl + "merchant/webfronts/ajaxUpdatePaymentAttribute", {payment_attribute: payment_attribute}).then(function (response) {
            if (response.data.status == 'success') {
                $scope.webfront_payment_attributes = response.data.webfront_payment_attributes;
                $scope.webfront_payment_attributes_length = response.data.webfront_payment_attributes.length;
                $scope.total_amount = response.data.total_amount;
                $rootScope.success('Payment attribute updated successfully!!');
            } else {
                $rootScope.error('Some error occured.Please try again!!');
            }

        });
    };

    $scope.deletePaymentAttribute = function (id) {
        confirm('Are you sure you want to delete ?', function (data) {
            if (data) {
                $http.post(siteUrl + "merchant/webfronts/ajaxDeletePaymentAttribute/" + id).then(function (response) {
                    if (response.data.status == 'success') {
                        $('#payment-attribute-' + id).remove();
                        $scope.webfront_payment_attributes = response.data.webfront_payment_attributes;
                        $scope.webfront_payment_attributes_length = response.data.webfront_payment_attributes.length;
                        $scope.total_amount = response.data.total_amount;
                        $rootScope.success('Payment attribute deleted successfully');
                    } else {
                        $rootScope.error('Some error occured.Please try again');
                    }
                })
            }
        }, {return: true});
    }
//    payment attribute parts ends here
    /////*****************Advance Web front section By prakash ends here***********************


});
//*********************Web Front Controller Code Ends here*****************************//
