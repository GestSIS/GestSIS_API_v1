require('./bootstrap');
import App from './app';

/**
 * Fonctions relatives aux pages des sapeurs
 */
var SapeurPage = (function() {
    var selectSapeurScrollTop = 0;
    var editor;

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

            // Autocomplete
            $("#f-sap-localite").select2({
                placeholder: "---",
                allowClear: true,
                ajax: {
                    url: $("#f-sap-localite").data("url"),
                    dataType: 'json',
                    delay: 400,
                    data: function (params) {
                        return {
                            query: params.term
                        };
                    },
                    processResults: function (data) {
                        return {
                            results: data.data.map(function(el){
                                return {
                                    'id': el.id,
                                    'text': el.npa + ' ' + el.nom
                                };
                            }),
                            pagination: {
                                more: false
                            }
                        };
                    }
                }
            });            
        }
    }

    // Public functions
    return {
        init: init
    }
})();

export default SapeurPage;
