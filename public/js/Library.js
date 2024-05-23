$(document).ready(function(){
    $.ajax({
        url: "history.php",
        type: "POST",
        data: {"temperature", "timestamp"},
        success: function(data) {
            console.log(data);
        }
    });
});