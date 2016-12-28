jQuery(function ($) {
    $('[data-rel=tooltip]').tooltip({container: 'body'});
    $('[data-rel=popover]').popover({container: 'body'});
});
jQuery(function ($) {
    $(document).on('keydown', '.decimal', function (e) {
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
                // Allow: Ctrl+A, Command+A
                        (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) ||
                        // Allow: home, end, left, right, down, up
                                (e.keyCode >= 35 && e.keyCode <= 40)) {
                    // let it happen, don't do anything
                    return;
                }
                // Ensure that it is a number and stop the keypress
                if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                    e.preventDefault();
                }
            });

    $(document).on('keydown', '.numeric', function (e) {
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110]) !== -1 || (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) || (e.keyCode >= 35 && e.keyCode <= 40)) {
            return;
        }
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });

    $(document).on('keydown', '.phone', function (e) {
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 45]) !== -1 || (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) || (e.keyCode >= 35 && e.keyCode <= 40)) {
            return;
        }
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });
});

function NewWindow(mypage, myname, w, h, scroll) {
    LeftPosition = (screen.width) ? (screen.width - w) / 2 : 0;
    TopPosition = (screen.height) ? (screen.height - h) / 2 : 0;
    settings = 'height=' + h + ',width=' + w + ',top=' + TopPosition + ',left=' + LeftPosition + ',scrollbars=' + scroll + ',resizable'
    win = window.open(mypage, myname, settings);
    win.focus();
}

function viewTransactions() {
    var merchnatId = $('#merchnat-id').val();
    var phone = $('#customer-phone').val().trim();
    if (phone.length >= 10) {
        $.get('customer/payments/ajax-view-transactions', {'merchnat_id': merchnatId, 'phone': phone}, function (response) {
            var response = JSON.parse(response);
            if (response.status == 'success') {
                $('#ajax-content').html(response.html);
                $('#view-bills-and-payments').show();
                $('#error-msg').html("").hide();
            } else if (response.status == 'error') {
                $('#view-bills-and-payments').hide();
                $('#error-msg').html(response.msg).show();
            }
        });
    } else {
        $('#customer-phone').focus();
        $('#error-msg').html('Please enter a valid phone number.').show();
    }
}


var smarthub = {
    removeInvalidChars: function (d, a, c) {
        var f = c != null ? c : event;
        var h = f.charCode ? f.charCode : f.keyCode;
        var g = String.fromCharCode(h);
        if (h < 32 || h > 222 || h == 37 || h == 39) {
            return;
        }
        var b = "[^" + d + "]";
        a.value = a.value.replace(new RegExp(b, "g"), "");
    }
}
function chkEmailAvail(email) {
    $("#email_msg").html('');
    var url = '<?= HTTP_ROOT ?>';
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    if (email.match(re)) {
        $("#emailloader_ajax").show();
        $.get(url + "webfronts/ajaxCheckEmailAvail/" + email, function (response) {
            if (response.mail_exist == 'yes') {
                $("#email_msg").html("<p style='color:red;border: 0 none;font-size: 13px;left: -57px;position: absolute;top: 20px;width: 350px;'>This email address is already exist.</p>");
            } else if (response.mail_exist == 'no') {
                $("#email_msg").html("<p style='color:green;border: 0 none;font-size: 13px;left: -57px;position: absolute;top: 20px;width: 200px;'>You can use this email adress</p>");
            }
            $("#emailloader_ajax").hide();
        }
        , 'json');
    } else {
        $("#email_msg").html('');
    }
}
function removeTextField(id) {
    $('#textfield-' + id).remove();
    changeTotalAmount(id);
}
function toggleRemove(id) {
    $('#remove-field-' + id).toggle();
    $('#payment-field-' + id).val('');

    var sum = 0;
    $("input[class *= 'add']").each(function () {
        sum += +$(this).val();
    });
    var new_total_amount = parseInt(sum);
    $('.total_amt').html(new_total_amount);
    $('#paid_amount').val(new_total_amount);
}

function changeTotalAmount(id) {
    var sum = 0;
    $("input[class *= 'add']").each(function () {
        sum += +$(this).val();
    });
    if (sum) {
        $('#remove-field-' + id).hide();
        $("#checkbox-id-" + id).prop('checked', true);
    } else {
        $('#remove-field-' + id).show();
        $("#checkbox-id-" + id).prop('checked', false);
    }
    var new_total_amount = parseFloat(sum);
    $('.total_amt').html(new_total_amount);
    $('#paid_amount').val(new_total_amount);
}

