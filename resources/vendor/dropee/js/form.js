var $ = require("jquery");

var ajaxForm;

/* Bind form with submit eventlistener */
$("form").on("submit", function(e) {
    /* Get this form element */
    var form = $(this);
    /* Get all required attribute */
    var ajax = form.attr("data-ajax");

    /* If the form use ajax */
    if(ajax == "true") {
        e.preventDefault();
        e.stopImmediatePropagation();

        /* If ajax is already called, then abort the process */
        if(ajaxForm != undefined)
            ajaxForm.abort();
        
        ajaxForm = $.ajax({
            url: form.attr("action"),
            type: form.attr("method"),
            data: form.serialize(),
            dataType: "json",
            beforeSend: function (xhr) {
                if($('meta[name="x-header-spa"]').length > 0)
                    xhr.setRequestHeader('Authorization', 'Bearer '+$('meta[name="x-header-spa"]').attr('content'));
                else
                    xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
            },
            complete: function (responses) {
                responses = responses.responseJSON;

                /* Alert if have message */
                if(responses.message != undefined && responses.message != "")
                    alert(responses.message);
                    
                if(responses.redirect != undefined && responses.redirect != "")
                    window.location.href = responses.redirect; // Load page in normal behaviour
            }
        });

        return false;
    } else
        return true;
});