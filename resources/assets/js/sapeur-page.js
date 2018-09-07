require('./bootstrap');
import App from './app';

/**
 * Fonctions relatives aux pages des sapeurs
 */
var SapeurPage = (function() {
    var selectSapeurScrollTop = 0;

    function init(pageCode){

        if(pageCode === 'index' || pageCode === 'details'){
            $('#nav-tab a').on('click', function (e) {
                e.preventDefault()
                $(this).tab('show')
            });

            $(".select-sapeur").off("click").on("click", function(e){
                selectSapeurScrollTop = $(".select-sapeur").scrollTop();
            });
            $(".select-sapeur").scrollTop(selectSapeurScrollTop);

            // Filtres
            $("#f-sapeur-filters input").change(function(){
                App.getPageContent($("#f-sapeur-filters").attr("action") + '?' + $("#f-sapeur-filters").serialize(), App.g_stateAction.replace);
            });
        }
    }

    // Public functions
    return {
        init: init
    }
})();

export default SapeurPage;
