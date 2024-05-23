function validateForm() {
    var x = document.forms["registro.php"]["Edit_user"].value;
    if (x == "") {
        alert("Formulario event");
        return false;
    }
}