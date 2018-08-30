require('./bootstrap');
import App from './app';

/**
 * Fonctions relatives aux pages de connexion
 */
var UserPage = (function() {

    function init(pageCode){
        switch(pageCode){
            case 'connection':
                App.initStandardForm($("#connection-form"));
                break;

            case 'forgot_password_form':
                App.initStandardForm($("#forgot-password-form"));
                break;
        }
    }

    // Public functions
    return {
        init: init
    }
})();

export default UserPage;
