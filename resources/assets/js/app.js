/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

var App = (function() {
    var g_ajaxStatus = true;
    var g_homePageUri = "/";
    var g_currentUri = window.location.hash ? window.location.hash.substr(window.location.hash.indexOf("/") + 1) : g_homePageUri;
    var g_stateAction = {
        'push': 1,
        'replace' : 2
    };

    function handleInit(){
        window.addEventListener("popstate", function(event) {
            if((!event.state || !event.state.url) && location.pathname === g_homePageUri){
                if($(".js-url", "#main-content").val() !== "")
                    getPageContent(g_homePageUri);
            }
            else if(event.state && event.state.url){
                getPageContent(event.state.url);
            }
        }, false);

        window.history.replaceState({url: $(".js-url", "#main-content").val()}, document.title, $(".js-url", "#main-content").val());

        managePageContent();
    }

    function managePageContent(){
        var callbackCode = $(".js-callback-code", "#main-content").val();

        var segments = callbackCode !== '' ? callbackCode.split('.') : [''];
        var jwtToken = $(".jwt-token:eq(0)").val();

        if(jwtToken){
            $.ajaxSetup({
                beforeSend: function (xhr) {
                    xhr.setRequestHeader("Authorization", 'Bearer '+ jwtToken);
                }
            });
        }
        else{
            if($.ajaxSettings && $.ajaxSettings.headers)
                delete $.ajaxSettings.headers.Authorization;
        }

        switch(segments[0]){
            case 'user':
                
                break;
        }

        onInternalLinkClick();
    }

    function onInternalLinkClick(){
        $("#main-content a.internal-link, .sidebar a.nav-link").off("click").on("click", function(event) {
            event.preventDefault();

            var uri = $(this).attr("href").replace($("base").attr("href"), "");
            getPageContent(uri, g_stateAction.push);
        });
    }

    function getPageContent(uri, stateAction){
        if (!g_ajaxStatus) return;

        showMainLoader();

        // Requête au serveur pour la page demandée
        $.get(uri, function(result) {
            g_ajaxStatus = true;
            if (typeof result !== "undefined") {
                // Redirection de l'utilisateur
                if (result.redirect) {
                    return redirect(result.redirect);
                }
                if (result.follow && result.follow != uri) {
                    return getPageContent(result.follow, g_stateAction.push);
                }
                if (result.error) {
                    errorHandling(uri, result.error);
                    return App.notifyUser(result.error, 'danger');
                }

                // Affectation du contenu à la page
                $("#main-content").html(result);

                // Changement du titre
                document.title = $(".js-page-title", "#main-content").val();

                // Changement de l'uri dans le hash
                if(stateAction === g_stateAction.push){
                    window.history.pushState({url: $(".js-url", "#main-content").val()}, document.title, uri);
                }
                else if(stateAction === g_stateAction.replace){
                    window.history.replaceState({url: $(".js-url", "#main-content").val()}, document.title, uri);
                }

                // Gestion du contenu
                managePageContent();

            } else {
                errorHandling(uri);
            }
        })
        .fail(function() {
            g_ajaxStatus = true;
            errorHandling(uri);
        })
        .always(function() {
            hideMainLoader();
        });
    }

    /**
     * Affiche le loader principal
     */
    function showMainLoader() {
        $("#main-loader").removeClass("d-none");
        $("#main-content").css("opacity", 0.4).addClass("loading");
    }

    /**
     * Cache le loader principal
     */
    function hideMainLoader() {
        $("#main-loader").addClass("d-none");
        $("#main-content").css("opacity", 1).removeClass("loading");
    }

    /**
     * Affiche une notification à l'utilisateur
     * @param  string textStatus Message à afficher
     * @param  string type       Type de message (danger, info, success)
     * @param  jQuery $ctn       (facultatif) Container de la notification
     */
    function notifyUser(textStatus, type, $ctn) {
        var $userNotification;

        if (typeof $ctn !== "undefined") {
            $userNotification = $ctn.find(".user-notification");
        } else {
            $userNotification = $(".user-notification", "#main-content");
        }

        if (!$userNotification.length) {
            $userNotification = $("<div>").addClass("alert user-notification").prependTo("#main-content");
        }

        $userNotification.removeClass("d-none alert-danger alert-success").addClass("alert-" + type).html(textStatus);
    }

    /**
     * Masque une notification
     * @param  jQuery $ctn (facultatif) Container de la notification
     */
    function hideUserNotification($ctn) {
        if (typeof $ctn !== "undefined") {
            $ctn.find(".user-notification").addClass("d-none");
        } else {
            $(".user-notification").addClass("d-none");
        }
    }

    /**
     * Vérifie l'intégrité d'un formulaire
     * @param formID Identifiant du formulaire
     * @return boolean Indique si le formulaire contient des erreurs
     */
    function checkFormIntegrity($form) {
        var errorFields = [];
        var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;

        $form.find(".required:not(:disabled)").each(function() {
            // Champ texte vide
            if ($.trim($(this).val()) === '') {
                if (errorFields.length === 0 || errorFields[errorFields.length - 1] != $(this).closest(".form-group").children("label").text()) {
                    $(this).addClass("is-invalid");
                    errorFields.push($(this).closest(".form-group").children("label").text());
                }
            }
            // Mots de passe pas identique
            else if ($(this).hasClass('password-confirmation') && ($form.find("input.password").val() !== $(this).val() || $(this).val() === "")) {
                $(this).addClass("is-invalid");
                errorFields.push($(this).closest(".form-group").children("label").text());
            }
            // Adresse e-mail syntaxiquement incorrecte
            else if ($(this).hasClass('email') && !emailReg.test($.trim($(this).val()))) {
                $(this).addClass("is-invalid");
                errorFields.push($(this).closest(".form-group").children("label").text());
            }
            // Bouton radio, aucun coché
            else if ($(this).is(":radio") && !$(this).closest(".form-group").find("input[name=" + $(this).attr("name") + "]:checked").val()) {
                $(this).addClass("is-invalid");
                if ($(this).parent(".custom-control").index() === 0) {
                    errorFields.push($(this).closest(".form-group").children("label").text());
                }
            }
            // Aucune erreur
            else {
                if (errorFields.length === 0 || errorFields[errorFields.length - 1] != $(this).closest(".form-group").children("label").text()) {
                    $(this).removeClass("is-invalid");
                }
            }
        });

        // Si il y a des erreurs dans le formulaire
        if (errorFields.length > 0) {
            var $errorList = $("<ul>");
            for (var errorField in errorFields) {
                $errorList.append($("<li>").text(errorFields[errorField]));
            }

            var $errorMessage = $("<div>");
            // Adaptation du message d'erreur en fonction du nombre d'erreur
            if (errorFields.length == 1) {
                $errorMessage.text(g_trans.form_error);
            } else {
                $errorMessage.text(g_trans.form_errors);
            }

            var $ctn = $.merge($errorMessage, $errorList);

            notifyUser($ctn, "danger", $form);
            return false;
        } else {
            // Si il n'y a pas d'erreur, on cache le message
            hideUserNotification($form);
            return true;
        }
    }

    /**
     * Initialise un formulaire standard
     * @param  jQuery $form Formulaire à initialiser
     */
    function initStandardForm($form) {
        /*var $recaptchaFields = $form.find(".recaptcha");
        if($recaptchaFields.length > 0){
            App.initCaptcha($recaptchaFields.eq(0).attr("id"));
        }*/

        $form.off("submit").on("submit", function(e) {
            e.preventDefault();

            submitStandardForm($form);
        });
    }

    function submitStandardForm($form){
        if (checkFormIntegrity($form) && g_ajaxStatus) {
            g_ajaxStatus = false;
            $form.find("button[type=submit]").prop("disabled", true);

            $.post($form.attr("action"), $form.serialize(), function(result) {
                g_ajaxStatus = true;
                if (typeof result.error == "undefined" && typeof result.success != "undefined" && result.success) {
                    if (result.redirect) {
                        App.redirect(result.redirect);
                    } else if (result.follow) {
                        App.getPageContent(result.follow, g_stateAction.push);
                    } else if (result.message) {
                        App.notifyUser(result.message, "success", $form);
                    }
                } else {
                    App.notifyUser(result.error, "danger", $form);
                }
            })
            .fail(function(jqXHR, textStatus, errorThrown) {
                g_ajaxStatus = true;
                App.notifyUser("Une erreur est survenue lors de votre requête. Veuillez réessayer.", "danger", $form);
            })
            .always(function() {
                $form.find("button[type=submit]").prop("disabled", false);
                //App.reloadCaptcha();
            });
        }
    }

    
    /**
     * Gestion des erreurs
     * @param string url
     * @param string error     Code d'erreur
     */
    function errorHandling(url, error) {
        g_ajaxStatus = true;
        hideMainLoader();

        //error = error || g_trans.request_error;
        //ga('send', 'event', 'Website', 'Ajax request error', url);

        notifyUser(error, "danger");
    }

    /**
     * Rafraîchit la page actuelle
     */
    function refreshPage() {
        getPageContent(g_currentUri, g_stateAction.replace);
    }

    /**
     * Redirectionne vers l'url donnée
     * @param  string url   Destination de la redirection
     */
    function redirect(url) {
        window.location.href = url;
    }

    // Public functions
    return {
        init: handleInit,
        notifyUser: notifyUser,
        hideUserNotification: hideUserNotification,
        refreshPage: refreshPage,
        redirect: redirect,
        checkFormIntegrity: checkFormIntegrity,
        getPageContent: getPageContent,
        initStandardForm: initStandardForm,
        submitStandardForm: submitStandardForm,
        onInternalLinkClick: onInternalLinkClick,
        errorHandling: errorHandling,
        g_ajaxStatus: g_ajaxStatus,
        g_stateAction: g_stateAction
    };

})();

export default App;

App.init();