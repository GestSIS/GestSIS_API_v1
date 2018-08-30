require('./bootstrap');

/**
 * Fonctions relatives aux pages des sapeurs
 */
var SapeurPage = (function() {

    function init(pageCode){

        if(pageCode === 'index'){
            $('#nav-tab a').on('click', function (e) {
                e.preventDefault()
                $(this).tab('show')
            });
        }
        // if(pageCode === 'details'){
        // etc.
    }

    // Public functions
    return {
        init: init
    }
})();

export default SapeurPage;
