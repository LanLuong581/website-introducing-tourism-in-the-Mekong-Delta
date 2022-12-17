src = "//cdn.jsdelivr.net/npm/sweetalert2@11"
src = "../jquery/jquery-3.6.0.min.js"

function getValue(id) {
    return document.getElementById(id).value.trim();
}
function check() {
    var flag = true;
    var old_pass = getValue("old_pass");
    var error1 = document.getElementById("error1");
    if (typeof old_pass === 'string' && old_pass.length === 0) {
        flag = false;
        error1.style.display = "block";
    }
    else {
        $('#xacnhan').modal('show');
    }
    return flag;

}
function check_newpass() {
    var flag = true;
    var new_pass = getValue("new_pass");
    var repass = getValue("repass");
    var error2 = document.getElementById("error2");
    var error3 = document.getElementById("error3");
    if (typeof new_pass === 'string' && new_pass.length === 0) {
        flag = false;
        error2.innerHTML = "Vui lòng điền mật khẩu mới!";
    }
    else if (new_pass == "" || !/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9])(?!.*\s).{10,}$/.test(new_pass)) {
        flag = false;
        error2.innerHTML = "Mật khẩu phải ít nhất 10 ký tự bao gồm chữ hoa, chữ thường, số và ký hiệu!";
    }
    if (typeof repass === 'string' && repass.length === 0) {
        flag = false;
        error3.innerHTML = "Vui lòng xác minh lại mật khẩu!";
    }
    else if(repass != new_pass){
        flag = false;
        error3.innerHTML = "Mật khẩu nhập lại không đúng!";
    }
    return flag;
}