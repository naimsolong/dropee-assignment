<script>
    let jQuery = require("jquery");
    
    let total_row = 0;
    let total_column = 0;
    let sentences = [];
    
    let ajaxForm = false;
    function ajax(json) {
        // window.event.preventDefault();
        // window.event.stopImmediatePropagation();
        
        /* If ajax is already called, then abort the process */
        if(ajaxForm != false)
        ajaxForm.abort();
        
        ajaxForm = jQuery.ajax({
            url: json.action ?? '',
            type: json.method ?? 'GET',
            data: json.data ?? {},
            dataType: "json",
            beforeSend: function (xhr) {
                xhr.setRequestHeader('Authorization', 'Bearer '+jQuery('meta[name="x-header-spa"]').attr('content'));
                xhr.setRequestHeader('X-CSRF-TOKEN', jQuery('meta[name="csrf-token"]').attr('content'));
            },
            complete: function (responses) {
                responses = responses.responseJSON;
                
                /* Alert if have message */
                if(responses.message != undefined && responses.message != "")
                alert(responses.message);
                
                if(responses.redirect != undefined && responses.redirect != "")
                window.location.href = responses.redirect; // Load page in normal behaviour
                
                if(json.callback != undefined && typeof json.callback == "function")
                json.callback(responses)
            }
        });
        ajaxForm = false;
        return false;
    }
    
    ajax({ action: '/api/admin/get/all', method: 'POST', callback: function(responses) {
        if(responses.data != undefined) {
            var data = responses.data;
            
            total_row = data.total_row;
            total_column = data.total_column;
            sentences = data.sentences;
        }
    } });
    
    function saveSettingForm(e) {
        ajax({
            action: e.target.action,
            method: e.target.method, 
            data: {
                row: total_row,
                column: total_column
            },
        });
    }
    
    function saveSentenceForm(e) {
        var form = jQuery(e.target);
        ajax({
            action: e.target.action,
            method: e.target.method, 
            data: {
                value: form.find("input[name='value']").val(),
                row: form.find("input[name='row']").val(),
                column: form.find("input[name='column']").val(),
                text_color: form.find("input[name='text_color']").val(),
                background_color: form.find("input[name='background_color']").val(),
            },
            callback: function(responses) {
                if(responses.data != undefined) {
                    sentences = responses.data;
                    
                    form.find("input[name='value']").val('');
                    form.find("input[name='row']").val('');
                    form.find("input[name='column']").val('');
                    form.find("input[name='text_color']").val('');
                    form.find("input[name='background_color']").val('');

                    jQuery("#addRow_close").click();
                }
            }
        });
    }
    
    function deleteSentenceForm(e) {
        var button = jQuery(e.target);
        var data_id = button.attr("data-id");
        var data_row = button.attr("data-row");
        
        ajax({
            action: '/api/admin/delete/sentence/'+data_id,
            method: 'POST', 
            callback: function(responses) {
                if(responses.message != undefined && responses.message == "Success!") {
                    var temp_sentences = sentences;
                    temp_sentences.splice(data_row, 1); 
                    sentences = temp_sentences;
                }
            }
        });
    }
</script>

<div class="container">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="/admin">Admin Dashboard</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                </ul>
                <form class="d-flex">
                    <a href="/admin/logout" class="btn btn-outline-info">Logout</a>
                </form>
            </div>
        </div>
    </nav>
    
    <div class="card my-3">
        <div class="card-header">
            <h3>Table Setting</h3>
        </div>
        <div class="card-body">
            <ul class="list-group">
                <li class="list-group-item">
                    <form action="/api/admin/save/setting" method="POST" on:submit|preventDefault|stopPropagation={saveSettingForm}>
                        <div class="input-group">
                            <span class="input-group-text">Row</span>
                            <input type="number" name="total_row" class="form-control" bind:value={total_row}>
                            <span class="input-group-text">Column</span>
                            <input type="number" name="total_column" class="form-control" bind:value={total_column}>
                            <button class="btn btn-outline-secondary" type="submit">Save</button>
                        </div>
                    </form>
                </li>
            </ul>
        </div>
    </div>
    
    <div class="card my-3">
        <div class="card-header">
            <h3>Sentences</h3>
        </div>
        <div class="card-body">
            <ul class="list-group list-group-flush">
                {#each sentences as { id, value, row, column, text_color, background_color }, i}
                <li class="list-group-item py-5">
                    <form action="/api/admin/save/sentence/{id}" method="POST" on:submit|preventDefault|stopPropagation={saveSentenceForm}>
                        <h3>Data #{i+1}</h3>
                        <div class="input-group mb-3">
                            <span class="input-group-text">Value</span>
                            <input type="text" name="value" class="form-control" value="{value}">
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text">Row</span>
                            <input type="number" name="row" class="form-control" value="{row}">
                            <span class="input-group-text">Column</span>
                            <input type="number" name="column" class="form-control" value="{column}">
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text">Text Color</span>
                            <input type="color" name="text_color" class="form-control form-control-color" value="{text_color}">
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text">Background Color</span>
                            <input type="color" name="background_color" class="form-control form-control-color" value="{background_color}">
                        </div>
                        <div class="input-group" style="width: 100%;">
                            <button class="btn btn-outline-secondary float-end" type="submit">Save</button>
                            <button class="btn btn-outline-secondary float-end" data-id="{id}" data-row="{i}" type="button" on:click={deleteSentenceForm}>Delete</button>
                        </div>
                    </form>
                </li>
                {/each}
            </ul>
        </div>
        <div class="card-footer">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addRow">Add Row</button>
        </div>
    </div>
    
    <!-- Modal -->
    <div class="modal fade" id="addRow" tabindex="-1" aria-labelledby="addRowLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addRowLabel">Add NEW Row</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="/api/admin/save/sentence" method="POST" on:submit|preventDefault|stopPropagation={saveSentenceForm}>
                        <div class="input-group mb-3">
                            <span class="input-group-text">Value</span>
                            <input type="text" name="value" class="form-control" value="">
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text">Row</span>
                            <input type="number" name="row" class="form-control" value="">
                            <span class="input-group-text">Column</span>
                            <input type="number" name="column" class="form-control" value="">
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text">Text Color</span>
                            <input type="color" name="text_color" class="form-control form-control-color" value="#000000">
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text">Background Color</span>
                            <input type="color" name="background_color" class="form-control form-control-color" value="#ffffff">
                        </div>
                        <div class="input-group" style="width: 100%;">
                            <button class="btn btn-outline-secondary float-end" type="submit">Save</button>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" id="addRow_close" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>