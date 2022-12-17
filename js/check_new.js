src = "//cdn.jsdelivr.net/npm/sweetalert2@11"
src = "../jquery/jquery-3.6.0.min.js"

function getValue(id) {
    return document.getElementById(id).value.trim();
}

function check_booking_info() {
    var flag = true;
    var booking_ngaysudung = getValue('booking_ngaysudung');
    var booking_ngaybook = getValue('booking_ngaybook');
    var booking_sl_nguoilon = getValue('booking_sl_nguoilon');
    var booking_sl_treem = getValue('booking_sl_treem');
    if (booking_ngaysudung == '' || booking_ngaysudung == null) {
        alert("ngay trong");
        flag = false;
        Swal.fire({
            icon: 'error',
            title: 'Ngay su dung trong',
            text: 'vui lòng điền ngay'
        })
    }
    else if (typeof booking_ngaysudung === 'date' && booking_ngaysudung < booking_ngaybook) {
        flag = false;
        Swal.fire({
            icon: 'error',
            title: 'Ngay khong hop le',
            text: 'vui lòng điền hop le'
        })
    }
    return flag;

}

function validate() {
    var flag = true;
    //password
    var account_password = getValue('account_password');
    var account_email = getValue('account_email');
    var re_password = getValue('re_password');
    var atposition = account_email.indexOf("@");
    var dotposition = account_email.lastIndexOf(".");
    if (typeof account_email === 'string' && account_email.length === 0) {
        flag = false;
        Swal.fire({
            icon: 'error',
            title: 'Email trống',
            text: 'vui lòng điền email'
        })
    }


    else if (typeof account_password === 'string' && account_password.length === 0) {
        flag = false;
        Swal.fire({
            icon: 'error',
            title: 'mật khẩu trống',
            text: 'vui lòng điền mật khẩu'
        })
    }
    else if (account_password == "" || !/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9])(?!.*\s).{10,}$/.test(account_password)) {
        flag = false;
        Swal.fire({
            icon: 'error',
            title: 'Mật khẩu không hợp lệ',
            text: 'Mật khẩu phải ít nhất 10 ký tự bao gồm chữ hoa, chữ thường, số và ký hiệu'
        })
    }

    else if (typeof re_password === 'string' && re_password.length === 0) {
        flag = false;
        Swal.fire({
            icon: 'error',
            title: 'Xác minh mật khẩu',
            text: 'vui lòng xác minh lại mật khẩu'
        })
    }
    else if (account_password != re_password) {
        flag = false;
        Swal.fire({
            icon: 'error',
            title: 'Mật khẩu nhập lại không đúng',
            text: 'vui lòng kiểm tra lại'
        })
    }
    else if (atposition < 1 || dotposition < (atposition + 2) || (dotposition + 2) >= x.length) {
        flag = false;
        Swal.fire({
            icon: 'error',
            title: 'Email không hợp lệ',
            text: 'vui lòng nhập đúng email'
        })
    }
    return flag;
}

function vali() {
    var flag = true;
    var account_email = getValue('account_email');
    var account_password = getValue('account_password');
    var atposition = account_email.indexOf("@");
    var dotposition = account_email.lastIndexOf(".");
    if ((typeof account_email === 'string' && account_email.length === 0) && (typeof account_password === 'string' && account_password.length === 0)) {
        flag = false;
        Swal.fire({
            icon: 'error',
            title: 'Email và mật khẩu trống',
            text: 'vui lòng điền email và mật khẩu để đăng nhập'
        })
    }
    else if (typeof account_email === 'string' && account_email.length === 0) {
        flag = false;
        Swal.fire({
            icon: 'error',
            title: 'Email trống',
            text: 'vui lòng điền email'
        })
    }
    else if (typeof account_password === 'string' && account_password.length === 0) {
        flag = false;
        Swal.fire({
            icon: 'error',
            title: 'mật khẩu trống',
            text: 'vui lòng điền mật khẩu'
        })
    }
    else if (atposition < 1 || dotposition < (atposition + 2) || (dotposition + 2) >= account_email.length) {
        flag = false;
        Swal.fire({
            icon: 'error',
            title: 'Email không hợp lệ',
            text: 'vui lòng nhập đúng email'
        })
    }

    return flag;
}

function vali_doanhnghiep() {
    var flag = true;
    var account_email = getValue('account_email');
    var tour_ten = getValue('tour_ten');
    var tour_dienthoai = getValue('tour_dienthoai');
    var atposition = account_email.indexOf("@");
    var dotposition = account_email.lastIndexOf(".");
    var phoneno = /[2-9]{1}\d{2}/;
    if (typeof tour_ten === 'string' && tour_ten.length === 0) {
        flag = false;
        Swal.fire({
            icon: 'error',
            title: 'Tên doanh nghiệp trống',
            text: 'vui lòng điền tên doanh nghiệp'
        })
    }
    else if (typeof account_email === 'string' && account_email.length === 0) {
        flag = false;
        Swal.fire({
            icon: 'error',
            title: 'Email trống',
            text: 'vui lòng điền email doanh nghiệp'
        })
    }
    else if (atposition < 1 || dotposition < (atposition + 2) || (dotposition + 2) >= account_email.length) {
        flag = false;
        Swal.fire({
            icon: 'error',
            title: 'Email không hợp lệ',
            text: 'vui lòng nhập đúng email'
        })
    }
    else if (tour_dienthoai == "") {
        flag = false;
        Swal.fire({
            icon: 'error',
            title: 'Số điện thoại trống',
            text: 'vui lòng điền số điện thoại'
        })
    }
    else if (!/^[0-9]+$/.test(tour_dienthoai)) {
        flag = false;
        Swal.fire({
            icon: 'error',
            title: 'Số điện thoại không hợp lệ',
            text: 'vui lòng điền giá trị số'
        })
    }
    else if (!/^\d{10}$/.test(tour_dienthoai)) {
        flag = false;
        Swal.fire({
            icon: 'error',
            title: 'Số điện thoại không hợp lệ',
            text: 'Số điện thoại là dãy 10 chữ số'
        })
    }
    return flag;
}

var nguoilon = document.getElementsByClassName('nguoilon');
var treem = document.getElementsByClassName('treem');

function min_soluong() {
    for (i = 0; i < nguoilon.length; i++) {
        if (nguoilon[i].value > 0) {
            treem[i].setAttribute('min', 0);
        } else {
            treem[i].setAttribute('min', 1);
        }
        if (treem[i].value > 0) {
            nguoilon[i].setAttribute('min', 0);
        } else {
            nguoilon[i].setAttribute('min', 1);
        }
    }
}
