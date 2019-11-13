/**
 * 
 * Show a confirmation window
 */
$(function() {
    $("button.desativar").click(function() {
        if (window.confirm('Deseja realmente desativar?')){
            window.location.replace($(this).attr("url"));
        }
    })
    $("button.ativar").click(function() {
        if (window.confirm('Deseja realmente ativar?')){
            window.location.replace($(this).attr("url"));
        }
    })
});