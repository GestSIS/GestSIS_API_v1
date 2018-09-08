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

            // Datatable Editor
            editor = new $.fn.dataTable.Editor( {
                ajax: {
                    create: {
                        type: 'POST',
                        url:  '../php/rest/create.php'
                    },
                    edit: {
                        type: 'PUT',
                        url:  '../php/rest/edit.php?id=_id_'
                    },
                    remove: {
                        type: 'DELETE',
                        url:  '../php/rest/remove.php?id=_id_'
                    }
                },
                table: "#sap-fonctions",
                fields: [ {
                        label: "Date:",
                        name: "date",
                        type:  'date',
                        dateFormat: 'DD.MM.YYYY'
                    }, {
                        label: "Abbréviation:",
                        name: "abr"
                    }, {
                        label: "Fonction:",
                        name: "fonction"
                    }, {
                        label: "Fub:",
                        name: "fin",
                        type:  'date',
                        dateFormat: 'DD.MM.YYYY'
                    }, {
                        label: "Remarque:",
                        name: "remarque"
                    }
                ]
            } );

            $('#sap-fonctions').on( 'click', 'tbody td:not(:first-child)', function (e) {
                editor.inline( this );
            } );
         
            $('#sap-fonctions').DataTable( {
                dom: "Bfrtip",
                columns: [                    
                    { data: "date" },
                    { data: "abr" },
                    { data: "fonction" },
                    { data: "fin" },
                    { data: "remarque" }
                ],
                select: true,
                buttons: [
                    { extend: "create", editor: editor },
                    { extend: "edit",   editor: editor },
                    { extend: "remove", editor: editor }
                ]
            });
        }
    }

    // Public functions
    return {
        init: init
    }
})();

export default SapeurPage;
