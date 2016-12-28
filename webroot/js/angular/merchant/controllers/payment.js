app.controller('PaymentsCtrl', function ($scope, $http, $timeout, $compile, $state, $stateParams, $rootScope, $window, Upload) {

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
                    $scope.viewUploads();
                    $('#fileinput').closest('form').get(0).reset();
                    $('#upload-excel-section').hide(), $('#uploaded-file-section').show();
                } else if (response.data.status == 'error') {
                    //$rootScope.error(response.data.msg);                    
                    $html = '<div style="display: block;" id="success-msg" class="alert alert-danger">';
                    $html += '<button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button>';
                    $html += ' <p><i class="ace-icon fa fa-times"></i>&nbsp;' + response.data.msg + '</p>';
                    $html += '</div>';
                    $('#upload-flash-msg').html($html).show();//.delay(8000).fadeOut();
                    $("html, body").animate({scrollTop: 0}, "slow");
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


    $scope.viewUploads = function () {
        var webfrontId = $stateParams['id'];
        $scope.tab = $stateParams.tab;
        //$(".page-loading").removeClass("hidden");
        $http({
            method: "POST",
            url: siteUrl + "merchant/payments/ajaxViewUploads/" + webfrontId,
            data: {},
        }).then(function (response) {
            if (response.data.status == 'success') {
                $scope.uploaded_payment_files = response.data.data.uploaded_payment_files;
                $scope.webfront = response.data.data.webfront;
            }
            //$(".page-loading").addClass("hidden");
        });
        return false;
    };


    $scope.appendRecords = function ($event) {
        $event.preventDefault();
        var id = $($event.currentTarget).attr('data-uploaded_payment_file_id');
        var formId = $($event.currentTarget).attr('id');
        var formData = new FormData($($('#' + formId))[0]);
        $.ajax({
            url: siteUrl + "merchant/webfronts/ajaxAppendRecords",
            type: 'POST',
            data: formData,
            dataType: 'JSON',
            async: false,
            success: function (response) {
                if (response.status == 'success') {
                    $('#appendRecord' + id).hide();
                    $scope.viewUploads();
                    $rootScope.success('New Records Added Successfully!!.');
                } else {
                    var msg = '<div style="display: block;" id="success-msg" class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><p><i class="ace-icon fa fa-check"></i>&nbsp;<span class="msg">' + response.msg + '</span></p></div>';
                    $('#append_records_error_' + id).html(msg).show();
                }
            },
            cache: false,
            contentType: false,
            processData: false
        });
        return false;
    }


    $scope.uploadReuse = function ($event) {
        $event.preventDefault();
        var id = $($event.currentTarget).attr('data-uploaded_payment_file-id');
        var formId = $($event.currentTarget).attr('id');
        var formData = $('#' + formId).serialize();
        $http({
            method: "POST",
            dataType: 'JSON',
            url: siteUrl + "merchant/payments/ajaxUploadReuse",
            data: formData,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function (response) {
            if (response.data.status == 'success') {
                $('#reuseUpload' + id).hide();
                $scope.viewUploads();
                $rootScope.success('Copied Successfully!!.');
            } else {
                $('#reuse_upload_error_' + id).html('<div style="display: block;" id="success-msg" class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><p><i class="ace-icon fa fa-check"></i>&nbsp;' + response.data.msg + '</p></div>').show();
            }
        });
        return false;
    };

    $scope.deleteUploadedFile = function (uploadedFile) {
        confirm(' You are going to delete all the records uploads. Are you sure you want to delete ?', function (data) {
            if (data) {
                $http({
                    method: "POST",
                    url: siteUrl + "merchant/payments/ajaxDeleteUploadedFile/" + uploadedFile.id,
                }).then(function (response) {
                    if (response.data.status == 'success') {
                        $('#uploaded-payment-file-' + uploadedFile.id).remove();
                        $rootScope.success('Records deleted Successfully!!.');
                    }
                });
            }
        }, {return: true});
    }

    $scope.downloadReport = function () {
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
                $window.location = siteUrl + 'merchant/payments/downloadReport/' + $scope.webfront.id + '/' + option;
            }
        }, {return: true});
    }

    $scope.viewPayments = function (page) {
        var paymentFileId = $stateParams['id'];
        $(".page-loading").removeClass("hidden");
        var page = (typeof page === 'undefined') ? 1 : page;
        var searchby = $('#searchby').val();
        var keyword = $('#keyword').val();
        //$scope.status = (status === undefined || status === null) ? 'all' : status;
        var dataString = {'page': page, 'status': $scope.status, 'searchby': searchby, 'keyword': keyword};
        $http({
            method: "POST",
            url: siteUrl + "merchant/payments/ajaxViewPayments/" + paymentFileId,
            data: dataString,
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
        }, function myError(response) {
            //Error Code//
        });

        return false;
    };

    $scope.advanceViewPayments = function (page) {
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
        return false;
    };

    $scope.deletePayment = function (payment) {
        var uniq_id = payment.uniq_id;
        var msg = "Are you sure you want to delete bill for <b>" + payment.name + "</b> ?";
        confirm(msg, function (data) {
            if (data) {
                $http.post(siteUrl + "merchant/payments/ajaxDeletePayment/" + uniq_id).success(function (data, status, headers, config) {
                    if (data.status == 'success') {
                        $('#payment-' + uniq_id).remove();
                        $rootScope.success('Payment details deleted successfully!!.');
                    } else {
                        $rootScope.error('Some error occured.Please try again.');
                    }
                });
            }
        }, {return: true});
    };

    $scope.deleteSelectedPayments = function () {
        if ($('.chk_payment:checked').length <= 0) {
            alert('Please select atlest one row to delete.');
            return flase;
        }
        var msg = "Are you sure you want to delete selected payment details ?";
        confirm(msg, function (data) {
            if (data) {
                var checkValues = $('input[class=chk_payment]:checked').map(function () {
                    return $(this).val();
                }).get();
                $http.post(siteUrl + "merchant/payments/ajaxDeleteSelectedPayments", {'ids': checkValues}).success(function (data, status, headers, config) {
                    if (data.status == 'success') {
                        for (var i = 0; i < checkValues.length; i++) {
                            $('#payment-' + checkValues[i]).remove();
                        }
                        $rootScope.success('Selected rows deleted successfully!!.');
                    } else {
                        $rootScope.error('Some error occured.Please try again.');
                    }
                });
            }
        }, {return: true});
    };


    $scope.remindPayment = function (payment) {
        var msg = "Are you sure you want to send reminder email ?";
        confirm(msg, function (data) {
            if (data) {
                $(".page-loading").removeClass("hidden");
                $http.post(siteUrl + "merchant/payments/ajaxRemindPayment/" + payment.id).success(function (data, status, headers, config) {
                    if (data.status == 'success') {
                        $rootScope.success('Reminder email sent successfully!!.');
                    } else {
                        $rootScope.error('Some error occured.Please try again.');
                    }
                    $(".page-loading").addClass("hidden");
                });
            }
        }, {return: true});
    };

    $scope.remindSelectedPayment = function (payment) {
        if ($('.chk_payment:checked').length <= 0) {
            alert('Please select atlest one row to send email.');
            return flase;
        }
        confirm("Are you sure you want to send reminder email ?", function (data) {
            if (data) {
                $(".page-loading").removeClass("hidden");
                var checkValues = $('input[class=chk_payment]:checked').map(function () {
                    return $(this).val();
                }).get();
                $http.post(siteUrl + "merchant/payments/ajaxRemindSelectedPayment", {'ids': checkValues}).success(function (data, status, headers, config) {
                    if (data.status == 'success') {
                        $rootScope.success('Reminder email sent to selected customers successfully!!.');
                    } else {
                        $rootScope.error('Some error occured.Please try again!!.');
                    }
                    $(".page-loading").addClass("hidden");
                });
            }
        }, {return: true});
    };

    $scope.updatePayment = function ($event) {
        $event.preventDefault();
        var paymentId = $($event.currentTarget).attr('data-payment-id');
        var formId = $($event.currentTarget).attr('id');
        var formData = $('#' + formId).serialize();
        $http({
            method: "POST",
            dataType: 'josn',
            url: siteUrl + "merchant/payments/ajaxEditPayment",
            data: formData,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function (response) {
            if (response.data.status == 'success') {
                $('#edit-payment-success-' + paymentId).show().focus().delay(5000).fadeOut();
                setTimeout(function () {
                    $scope.viewPayments();//$state.reload();
                }, 2000);
            } else {
                $('#edit-payment-error-' + paymentId).show().focus().delay(5000).fadeOut();
            }
        });
        return false;
    };
    $scope.emailReceipt = function (uniq_id) {
        var msg = "Are you sure you want to send email receipt ?";
        confirm(msg, function (data) {
            if (data) {
                $(".page-loading").removeClass("hidden");
                $http.post(siteUrl + "customer/payments/ajaxEmailReceipt/" + uniq_id).success(function (data, status, headers, config) {
                    if (data.status == 'success') {
                        $rootScope.success('Email receipt sent successfully!!.');
                    } else {
                        $rootScope.error('Some error occured.Please try again.');
                    }
                    $(".page-loading").addClass("hidden");
                });
            }
        }, {return: true});
    };

    $scope.parJson = function (json) {
        return JSON.parse(json);
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

});
