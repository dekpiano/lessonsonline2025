$(document).on("submit","#FormRegisterUser", function(e) {
    e.preventDefault();
    var formData = $(this).serialize();
    $.ajax({
        type: "POST",
        url: "../../../pages/Users/Register/Php/RegisterPhpInsert.php",
        data: formData,
        success: function(response) {
            console.log(response);
            Swal.fire({
              title: 'สำเร็จ!',
              text: 'สมัครเรียนเรียบร้อย เข้าสู่ระบบได้เลย',
              icon: 'success',
              confirmButtonText: 'ตกลง'
          }).then((result) => {
              if (result.isConfirmed) {
                window.location.href = '../../../pages/Users/Home/HomeMain'; // หรือหน้าอื่นที่คุณต้องการ
              }
          });

        },
        error: function() {
          Swal.fire('เกิดข้อผิดพลาด', 'ไม่สามารถสมัครเรียนได้', 'error');
        }
    });
});

const passwordInput = document.getElementById('Password');
const confirmPasswordInput = document.getElementById('ConfirmPassword');
const lengthError = document.getElementById('lengthError');
const uppercaseError = document.getElementById('uppercaseError');
const lowercaseError = document.getElementById('lowercaseError');
const digitError = document.getElementById('digitError');
const specialCharError = document.getElementById('specialCharError');
const validMessage = document.getElementById('validMessage');
const matchError = document.getElementById('matchError');
const matchSuccess = document.getElementById('matchSuccess');
const BtnSubmitRegister = document.getElementById('BtnSubmitRegister');

function validatePassword() {
    const password = passwordInput.value;
    let isValid = true;

    if (password.length < 8) {
        lengthError.style.display = 'block';
        isValid = false;
    } else {
        lengthError.style.display = 'none';
    }

    if (!/[A-Z]/.test(password)) {
        uppercaseError.style.display = 'block';
        isValid = false;
    } else {
        uppercaseError.style.display = 'none';
    }

    if (!/[a-z]/.test(password)) {
        lowercaseError.style.display = 'block';
        isValid = false;
    } else {
        lowercaseError.style.display = 'none';
    }

    if (!/[0-9]/.test(password)) {
        digitError.style.display = 'block';
        isValid = false;
    } else {
        digitError.style.display = 'none';
    }

    if (!/[!@#$%^&*(),.?":{}|<>]/.test(password)) {
        specialCharError.style.display = 'block';
        isValid = false;
    } else {
        specialCharError.style.display = 'none';
    }

    if (isValid) {
        validMessage.style.display = 'block';
    } else {
        validMessage.style.display = 'none';
    }

    return isValid;
}

function validateConfirmPassword() {
    const password = passwordInput.value;
    const confirmPassword = confirmPasswordInput.value;

    if (password === confirmPassword && password !== "") {
        matchSuccess.style.display = 'block';
        matchError.style.display = 'none';
        BtnSubmitRegister.disabled = false;
        return true;
    } else {
        matchError.style.display = 'block';
        matchSuccess.style.display = 'none';
        BtnSubmitRegister.disabled = true;
        return false;
    }
}

passwordInput.addEventListener('keyup', function() {
    validatePassword();
    validateConfirmPassword();
});

confirmPasswordInput.addEventListener('keyup', function() {
    validateConfirmPassword();
});


document.getElementById('togglePassword').addEventListener('click', function () {
    const passwordField = document.getElementById('Password');
    const toggleIcon = this.querySelector('i');
    
    if (passwordField.type === 'password') {
        passwordField.type = 'text';
        toggleIcon.classList.remove('fa-eye');
        toggleIcon.classList.add('fa-eye-slash');
    } else {
        passwordField.type = 'password';
        toggleIcon.classList.remove('fa-eye-slash');
        toggleIcon.classList.add('fa-eye');
    }
});

document.getElementById('togglePassword1').addEventListener('click', function () {
    const passwordField = document.getElementById('ConfirmPassword');
    const toggleIcon = this.querySelector('i');
    
    if (passwordField.type === 'password') {
        passwordField.type = 'text';
        toggleIcon.classList.remove('fa-eye');
        toggleIcon.classList.add('fa-eye-slash');
    } else {
        passwordField.type = 'password';
        toggleIcon.classList.remove('fa-eye-slash');
        toggleIcon.classList.add('fa-eye');
    }
});


document.addEventListener('DOMContentLoaded', () => {

  const messageElement13 = document.getElementById('message13');
  const numberInput = document.getElementById('UserIdCard');
  const submitButton = document.getElementById('BtnSubmitRegister');


  function validateNumber(number) {
    if (number.length === 13 && /^\d+$/.test(number)) {
        return "หมายเลขถูกต้อง";
    } else {
        return "หมายเลขต้องมีความยาว 13 หลักและประกอบด้วยตัวเลขเท่านั้น";
    }
  }

  function validateNumberField() {
    const number = numberInput.value;
       // ตรวจสอบและตัดข้อมูลที่เกิน 13 หลัก
       if (number.length > 13) {
        number = number.slice(0, 13);
        numberInput.value = number;
    }

    const numberMessage = validateNumber(number);
    
    if (numberMessage !== "หมายเลขถูกต้อง") {
        messageElement13.textContent = numberMessage;
        messageElement13.style.color = "red";
        submitButton.disabled = true; // ปิดการใช้งานปุ่ม data-inputmask="'mask': '9999999999999'"
       
    }else{
      messageElement13.textContent = "";
      submitButton.disabled = false;
    }
  }


});

function CheckEmailRegister() {

  var email = $('#Email').val();
  if(email.length === 0) {
    $('#emailStatus').text('');
    return;
}

  $.ajax({
    type: "POST",
    url: "../../../pages/Users/Register/Php/RegisterPhpCheckEmail.php",
    data: {Email: email},
    success: function(response) {
      console.log(response);
        if(response == 1) {
            $('#emailStatus').text('อีเมลนี้มีผู้ใช้งานแล้ว!');
            $('#BtnSubmitRegister').prop('disabled', true);
        } else {
            $('#emailStatus').text('');
            $('#BtnSubmitRegister').prop('disabled', false);
        }
    }
});
  
}
