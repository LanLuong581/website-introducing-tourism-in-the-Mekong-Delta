src = "//cdn.jsdelivr.net/npm/sweetalert2@11"
src = "../jquery/jquery-3.6.0.min.js"

function getValue(id) {
    return document.getElementById(id).value.trim();
}
function vali(){
    var flag = true;
    var email = getValue('email');
    if (typeof email === 'string' && email.length === 0) {
        flag = false;
        Swal.fire({
            icon: 'error',
            title: 'Email trống',
            text: 'vui lòng điền email'
        })
    }
    return flag;
}