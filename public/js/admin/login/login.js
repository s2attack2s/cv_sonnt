/**
 * ****************************************************************************
 * login.js
 *
 * Description		:	Methods and events for login
 * Created at		:	2021/05/26
 * Created by		:	QuyPN – quy.pham@toploop.co
 * package		    :	Admin
 * ****************************************************************************
 */
 $(document).ready(function() {
    LoginModel.Init();
    LoginModel.InitEvents();
});

/**
 * Module contains handling for system login
 * Author       :   QuyPN - 2021/05/26 - create
 * Param        :
 * Output       :   LoginModel.Init() - Initialize values
 * Output       :   LoginModel.InitEvents() - Initiating events
 */
var LoginModel = (function() {
    /**
     * Objects associated with items on the screen
     */
    var obj = {
        'username': { 'type': 'text', 'attr': { 'maxlength': 100, 'class': 'required' } }
    ,   'password': { 'type': 'password', 'attr': { 'maxlength': 100, 'class': 'required' } }
    };

    /**
     * Is it showing login failure message?
     */
    var error = false;

    /**
     * Initialize system values
     *
     * Author : QuyPN - 2021/05/26 - create
     * Params :
     * Return :
     * Access : public
     */
    var Init = function () {
        try {
            Common.DisableFunction();
            Common.InitItem(obj);
            FillRemember();
            $('#username').focus();
        }
        catch (e) {
            console.log('Init: ' + e.message);
        }
    };

    /**
     * Initiating events in the page
     *
     * Author : QuyPN - 2021/05/26 - create
     * Params :
     * Return :
     * Access : public
     */
    var InitEvents = function () {
        try {
            // Event when clicking the login button
            $('#btn-login').on('click', function () {
                error = false;
                SubmitLogin();
            });
            // Event when clicking the button to see the password
            $('#btn-show-password').on('mousedown mouseup', function () {
                ToggleShowPassword();
            });
            // Enter press event
            document.onkeyup = function(event) {
                // If the button being pressed is enter and is not showing a login failure message, then submit the login information
                if ((event.which === 13 || event.keyCode === 13) && !error) {
                    SubmitLogin();
                }
            };
        }
        catch (e) {
            console.log('InitEventLogin: ' + e.message);
        }
    };

    /**
     * Submit the information entered by the user to the server for verification
     *
     * Author : QuyPN - 2021/05/26 - create
     * Params :
     * Return :
     * Access : private
     */
    var SubmitLogin = function () {
        try {
            // Check for errors of input data
            if (ValidateModule.Validate(obj)) {
                // Get data and encrypt password before transmitting
                var data = Common.GetData(obj);
                data.password = Secure.EncodeMD5(data.password);
                // Submit to the server
                $.ajax({
                    type: $('#form-login').attr('method'),
                    url: $('#form-login').attr('action'),
                    dataType: 'json',
                    data: data,
                    success: CheckLoginSuccess,
                    error: function () {
                        Notification.Alert(MSG_NO.SERVER_ERROR, function () {
                            $('#username').focus();
                        });
                    }
                });
            }
        }
        catch (e) {
            console.log('SubmitLogin: ' + e.message);
        }
    };

    /**
     * Handle on successful login. Save the cookie token and navigate to the page after login.
     *
     * Author : QuyPN - 2021/05/26 - create
     * Params : res - The json object contains the results returned from the server
     * Return :
     * Access : private
     */
    var CheckLoginSuccess = function (res) {
        try {
            if (res.code === 200) {
                $.cookie('token', res.data.token, { expires: 1, path: '/' });
                var date = new Date();
                date.setTime(date.getTime() + (NumberModule.ToNumber(res.data.expires) * 60 * 1000));
                $.cookie('expires', date.toUTCString(), { expires: 1, path: '/' });
                CheckRemember();
                window.location = res.data.before;
            } else if (res.code === 422) {
                ValidateModule.FillError(res.errors.data);
                ValidateModule.FocusFirstError();
            } else {
                error = true;
                Notification.Alert(res.msgNo, function() {
                    error = false;
                });
            }
        }
        catch (e) {
            console.log('CheckLoginSuccess: ' + e.message);
        }
    };

    /**
     * If the user chooses to remember login, save the encrypted Username and Password values in the Local store.
     *
     * Author : QuyPN - 2021/05/26 - create
     * Params :
     * Return :
     * Access : private
     */
    var FillRemember = function () {
        try {
            if (window.localStorage.getItem("username")) {
                $('#username').val(Secure.DecodeBase64(window.localStorage.getItem("username")));
                $('#password').val(Secure.DecodeBase64(window.localStorage.getItem("password")));
                $('#remember').prop('checked', true);
            }
        }
        catch (e) {
            console.log('FillRemember: ' + e.message);
        }
    };

    /**
     * Check at page load if there is a previously saved Username and Password, then automatically fill the item on the page.
     *
     * Author : QuyPN - 2021/05/26 - create
     * Params :
     * Return :
     * Access : private
     */
    var CheckRemember = function () {
        try {
            if ($('#remember').is(':checked')) {
                window.localStorage.setItem("username", Secure.EncodeBase64($('#username').val()));
                window.localStorage.setItem("password", Secure.EncodeBase64($('#password').val()));
            }
            else {
                window.localStorage.removeItem("username");
                window.localStorage.removeItem("password");
            }
        }
        catch (e) {
            console.log('CheckRemember: ' + e.message);
        }
    };

    /**
     * Displays the entered password when pressing and holding the show password button.
     *
     * Author : QuyPN - 2021/05/26 - create
     * Params :
     * Return :
     * Access : private
     */
    var ToggleShowPassword = function () {
        try {
            if ($('#password').attr('type') === 'password') {
                $('#password').attr('type', 'text');
                //$('#btn-show-password i').removeClass('fa-eye');
                //$('#btn-show-password i').addClass('fa-eye-slash');
            }
            else {
                $('#password').attr('type', 'password');
                //$('#btn-show-password i').addClass('fa-eye');
                //$('#btn-show-password i').removeClass('fa-eye-slash');
            }
        }
        catch (e) {
            console.log('ToggleShowPassword: ' + e.message);
        }
    };
    return {
        Init: Init,
        InitEvents: InitEvents
    };
})();
