"use strict";

// Class Definition
var KTLoginGeneral = function() {

    var login = $('#LoginForm');

    var showErrorMsg = function(form, type, msg) {
        var typeList = {
            success: 'uk-alert-success',
            danger  : 'uk-alert-danger'
        };
        var alert = $('<div class="alertUser '+typeList[type]+'" uk-alert> <a class="uk-alert-close" uk-close></a> <p>'+msg+' </p> </div>');

        form.find('.alertUser').remove();
        alert.prependTo(form);
    }


    var handleSignInFormSubmit = function() {
        $('#LoginFormSubmit').click(function(e) {
            e.preventDefault();

            var loading = $('#loading-icon-login');
            var btn = $(this);
            var form = $(this).closest('form');
            showErrorMsg(form, 'error', 'fuck it works');

            form.css('display', 'none');
            loading.css('display', 'block');
            //
            form.ajaxSubmit({
                success: function(response, status, xhr, $form) {

                    if(response == 500){
                        setTimeout(function() {
                            form.css('display', 'block');
                            loading.css('display', 'none');
                            showErrorMsg(form, 'danger', 'Incorrect username or password. Please try again.');
                        }, 2000);
                    }else{
                        form.css('display', 'block');
                        loading.css('display', 'none');
                        showErrorMsg(form, 'success', 'Logged In successfully');
                        setTimeout(function() {
                            window.location.reload();
                        }, 2000);
                    }

                }
            });
        });
    }

    var handleSignUpFormSubmit = function() {
        $('#kt_login_signup_submit').click(function(e) {
            e.preventDefault();

            var btn = $(this);
            var form = $(this).closest('form');

            form.validate({
                rules: {
                    fullname: {
                        required: true
                    },
                    email: {
                        required: true,
                        email: true
                    },
                    password: {
                        required: true
                    },
                    rpassword: {
                        required: true
                    },
                    agree: {
                        required: true
                    }
                }
            });

            if (!form.valid()) {
                return;
            }

            btn.addClass('kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light').attr('disabled', true);

            form.ajaxSubmit({
                url: '',
                success: function(response, status, xhr, $form) {
                    // similate 2s delay
                    setTimeout(function() {
                        btn.removeClass('kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light').attr('disabled', false);
                        form.clearForm();
                        form.validate().resetForm();

                        // display signup form
                        displaySignInForm();
                        var signInForm = login.find('.kt-login__signin form');
                        signInForm.clearForm();
                        signInForm.validate().resetForm();

                        showErrorMsg(signInForm, 'success', 'Thank you. To complete your registration please check your email.');
                    }, 2000);
                }
            });
        });
    }


    // Public Functions
    return {
        // public functions
        init: function() {
            handleSignInFormSubmit();
            handleSignUpFormSubmit();
        }
    };
}();

// Class Initialization
jQuery(document).ready(function() {
    KTLoginGeneral.init();
});
