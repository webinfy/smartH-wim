/**
 * customAlerts.js
 * Author: Philippe Assis
 * Doc and repo: https://github.com/PhilippeAssis/custom-alert
 *
 * Alert e confirm personalizados.
 * FF, Chromer, IE(>=9)*
 *
 *                              ATENÇÂO
 * window.customAlert e window.customConfirm devem permanecer com esses nomes,
 * a não ser que você saiba o que esta fazendo.
 */
var customKit = {
    createDiv: function (attr, parent) {
        var div = document.createElement("div");

        for(var key in attr){
            div.setAttribute(key, attr[key]);
        }

        if (parent) {
            var parent = document.getElementById(parent)
            parent.appendChild(div);
            return;
        }

        document.body.appendChild(div);
    },
    mergeObjects: function (obj1, obj2) {
        var obj3 = {};
        for (var attrname in obj1) {
            obj3[attrname] = obj1[attrname];
        }
        for (var attrname in obj2) {
            obj3[attrname] = obj2[attrname];
        }
        return obj3;
    }
};

function customAlert(options) {

    this.defaultOptions = {
        'ok': 'OK',
        'title': 'Alert!'
    };

    if (options)
        this.defaultOptions = customKit.mergeObjects(this.defaultOptions, options);

    this.options = this.defaultOptions;

    if (document.getElementById("customAlert") == null) {
        customKit.createDiv({
            "id": "customAlert-overlay",
            "class": 'customalert_overlay'
        });
        customKit.createDiv({
            "id": "customAlert",
            "class": 'customalert customalert_alert'
        });
        customKit.createDiv({
            "class": "customalert_header",
        }, "customAlert");
        customKit.createDiv({
            "class": "customalert_body"
        }, "customAlert");
        customKit.createDiv({
            "class": "customalert_footer"
        }, "customAlert");

        //Os nomes podem ser alterados, window.alert e window.Alert, ao seu gosto!
        window.alert = window.Alert = function (dialog, options, callback) {
            if (typeof options == 'function')
                options = {'callback': options};
            else if (options && typeof options.callback == 'function')
                options.callback = callback;


            if (options)
                window.customAlert.options = customKit.mergeObjects(window.customAlert.options, options);

            window.customAlert.render(dialog);
        };
    }

    this.render = function (dialog) {
        alertBox = document.getElementById("customAlert");
        alertBox.getElementsByClassName("customalert_header")[0].innerHTML = this.options.title;
        alertBox.getElementsByClassName("customalert_body")[0].innerHTML = dialog;
        alertBox.getElementsByClassName("customalert_footer")[0].innerHTML = "<button class=\"btn btn-primary\" onclick=\"window.customAlert.ok()\">" + this.options.ok + "</button>";
        document.getElementsByTagName("html")[0].style.overflow = "hidden";
        document.getElementById("customAlert-overlay").style.display = "block";
        alertBox.style.display = "block";

        alertBox.dispatchEvent(new Event('rendered'))
    };

    this.ok = function () {
        if (typeof this.options.callback == 'function')
            if (this.options.callback() === false)
                return;

        document.getElementById("customAlert").style.display = "none";
        document.getElementById("customAlert-overlay").style.display = "none";
        document.getElementsByTagName("html")[0].style.overflow = "auto";
        this.options = this.defaultOptions;
    }
}

function customConfirm(options) {
    var confirmIt, cancelIt;

    confirmIt = new Event('confirmIt');
    cancelIt = new Event('cancelIt');

    window.dispatchEvent(confirmIt);
    window.dispatchEvent(cancelIt);

    this.defaultOptions = {
        'yes': 'YES',
        'no': 'NO',
        'title': 'Confirm it:',
        'return': false
    };

    if (options)
        this.defaultOptions = customKit.mergeObjects(this.defaultOptions, options);

    this.options = this.defaultOptions;

    if (document.getElementById("customConfirm") == null) {
        customKit.createDiv({
            "id": "customConfirm-overlay",
            "class": 'customalert_overlay'
        });
        customKit.createDiv({
            "id": "customConfirm",
            "class": 'customalert customalert_confirm'
        });
        customKit.createDiv({
            "class": "customalert_header",
        }, "customConfirm");
        customKit.createDiv({
            "class": "customalert_body"
        }, "customConfirm");
        customKit.createDiv({
            "class": "customalert_footer"
        }, "customConfirm");

        //Os nomes podem ser alterados, window.confirm e window.Confirm, ao seu gosto!
        window.confirm = window.Confirm = function (dialog, callback, options) {
            if (options)
                window.customConfirm.options = customKit.mergeObjects(window.customConfirm.options, options);

            if (typeof callback == "object") {
                if (!options)
                    options = {}

                if (callback.confirm)
                    options.confirm = callback.confirm;

                if (callback.cancel)
                    options.cancel = callback.cancel;

                callback = null;

                window.customConfirm.options = customKit.mergeObjects(window.customConfirm.options, options);
            }

            window.customConfirm.render(dialog, callback);

        };
    }

    this.callback = function (data) {
    };

    this.render = function (dialog, callback) {
        this.callback = callback;
        confirmBox = document.getElementById("customConfirm");
        confirmBox.getElementsByClassName("customalert_header")[0].innerHTML = this.options.title;
        confirmBox.getElementsByClassName("customalert_body")[0].innerHTML = dialog;
        confirmBox.getElementsByClassName("customalert_footer")[0].innerHTML = "<button class=\"btn btn-success customalert_button_confirm\" onclick=\"window.customConfirm.ok()\">" + (this.options.yes) + "</button><button class=\"btn btn-danger customalert_button_cancel\" onclick=\"window.customConfirm.cancel()\">" + (this.options.no) + "</button>";
        document.getElementsByTagName("html")[0].style.overflow = "hidden";
        document.getElementById("customConfirm-overlay").style.display = "block";
        confirmBox.style.display = "block";

        confirmBox.dispatchEvent(new Event('rendered'))
    };

    this.ok = function () {
        if (typeof this.options.confirm == "function")
            if (!this.options.confirm())
                return;

        this.end();

        if (this.options.return) {
            this.clear();
            if (typeof this.callback == 'function')
                this.callback(true);
            return;
        }

        this.clear();

        if (typeof this.callback == 'function')
            this.callback();
    }

    this.cancel = function () {
        if (typeof this.options.cancel == "function")
            if (!this.options.cancel())
                return;

        this.end();

        if (this.options.return) {
            this.clear();
            if (typeof this.callback == 'function')
                this.callback(false);
            return;
        }

        this.clear();
    }

    this.end = function () {
        document.getElementById("customConfirm").style.display = "none";
        document.getElementById("customConfirm-overlay").style.display = "none";
        document.getElementsByTagName("html")[0].style.overflow = "auto";
    }

    this.clear = function () {
        this.options = this.defaultOptions;
    }
}

window.addEventListener('keydown', function (e) {
    var keynum;

    keynum = e.keyCode ? e.keyCode : e.which;

    if (keynum == 13) {
        if (document.getElementById("customConfirm").style.display == "block")
            window.customConfirm.ok();
        else if (document.getElementById("customAlert").style.display == "block")
            window.customAlert.ok();
    }
    else if (keynum == 27 && document.getElementById("customConfirm").style.display == "block")
        window.customConfirm.cancel();

}, false);

/*
 * window.customAlert e window.customConfirm devem permanecer com esses nomes, a não se que vc saiba o que esta fazendo.
 * Vocẽ pode adicionar configuraçãos na declaração de ambos, ex: new customConfirm({execute:false});
 * */
window.customAlert = new customAlert({title: ''});

window.customConfirm = new customConfirm({title: ''});
