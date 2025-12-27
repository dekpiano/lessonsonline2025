$(document).on("submit","#ProfileUpdateDataUser", function(e) {
    e.preventDefault();
    var formData = new FormData($(this)[0]);
    $.ajax({
        type: "POST",
        url: "../../../pages/Users/Profile/Php/ProfileUpdateDataUser.php",
        data: formData,
        contentType: false,
        processData: false,
        dateType:"json",
        success: function(response) {          
          console.log(response);
          if(response == 1){
            Swal.fire({
              title: "แจ้งเตือน!",
              text: "บันทึกข้อมูลเรียบร้อย!",
              icon: "success"
            }).then((result) => {
              if (result.isConfirmed) {
                window.location.reload();
              }
            });           
          }else{
            Swal.fire({
              title: "แจ้งเตือน!",
              text: response.Text,
              icon: "error"
            });
          }
         
        },
        error: function() {
            $("#result").html("<div class='alert alert-danger'>There was an error processing your request</div>");
        }
    });
});

$(document).on("submit","#ResetPassword", function(e) {
  e.preventDefault();
  var formData = new FormData($(this)[0]);
  $.ajax({
      type: "POST",
      url: "../../../pages/Users/Profile/Php/ProfileUpdatePassword.php",
      data: formData,
      contentType: false,
      processData: false,
      dateType:"json",
      success: function(response) {          
        console.log(response);
        if(response == 1){
          Swal.fire({
            title: "แจ้งเตือน!",
            text: "เปลี่ยนรหัสผ่านเรียบร้อย!",
            icon: "success"
          }).then((result) => {
            if (result.isConfirmed) {
              window.location.reload();
            }
          });           
        }else{
          Swal.fire({
            title: "แจ้งเตือน!",
            text: response.Text,
            icon: "error"
          });
        }
       
      },
      error: function() {
          $("#result").html("<div class='alert alert-danger'>There was an error processing your request</div>");
      }
  });
});

$(document).on('keyup','#PasswordNew',function(){
  var password = $(this).val();
  var strength = checkPasswordStrength(password);
  var strengthText = '';

  switch (strength) {
      case 'weak':
          strengthText = 'อย่างน้อย 8 ตัวอักษร';
          $('#password-strength').removeClass().addClass('weak');
          break;
      case 'medium':
          strengthText = 'ง่าย';
          $('#password-strength').removeClass().addClass('medium');
          break;
      case 'strong':
          strengthText = 'ปานกลาง';
          $('#password-strength').removeClass().addClass('strong');
          break;
      case 'very strong':
          strengthText = 'ยากมาก';
          $('#password-strength').removeClass().addClass('very_strong');
          break;
  }

  $('#password-strength').text('ระดับ: ' + strengthText);
});

function checkPasswordStrength(password) {
  var strength = 0;
  if (password.length < 8) { // เปลี่ยนเงื่อนไขนี้เป็น 8
      return 'weak';
  }

  if (password.length >= 8 && password.length < 10) {
      strength += 1;
  } else if (password.length >= 10) {
      strength += 2;
  }

  if (password.match(/[a-z]+/)) {
      strength += 1;
  }

  if (password.match(/[A-Z]+/)) {
      strength += 1;
  }

  if (password.match(/[0-9]+/)) {
      strength += 1;
  }

  if (password.match(/[!@#$%^&*()]+/)) {
      strength += 1;
  }

  if (strength < 3) {
      return 'medium';
  } else if (strength >= 3 && strength < 5) {
      return 'strong';
  } else {
      return 'very strong';
  }
}

// $(document).on('keyup','#PasswordNew, #PasswordConfrim',function(){
//   var password = $('#PasswordNew').val();
//   var confirm_password = $('#PasswordConfrim').val();

//   if(password != '' && confirm_password != ''){
//       if(password == confirm_password){
//           $('#password_match').removeClass().addClass('match').text('รหัสผ่านตรงกัน!');
//           $('#BtnResetPassword').prop('disabled', false);
//       }else{
//           $('#password_match').removeClass().addClass('mismatch').text('รหัสผ่านไม่ตรงกัน');
//           $('#BtnResetPassword').prop('disabled', true); 
//       }
//   }else{
//       $('#password_match').text('');
//   }
// });

$(document).on('keyup','#PasswordOld,#PasswordNew,#PasswordConfrim',function(){
 
        var PasswordOld = $('#PasswordOld').val();
        var PasswordNew = $('#PasswordNew').val();
        var PasswordConfrim = $('#PasswordConfrim').val();

 $.ajax({
  type: 'POST',
  url: '../../../pages/Users/Profile/Php/ProfileCheckPasswordOld.php', // เปลี่ยนเป็นชื่อไฟล์ PHP ที่ตรวจสอบรหัสผ่านเก่า
  data: { PasswordOld: PasswordOld },
  success: function(response) {
   console.log(response);
      if(response == 'รหัสผ่านถูกต้อง') {
          // ถ้ารหัสผ่านเก่าถูกต้อง ตรวจสอบรหัสผ่านใหม่และยืนยันรหัสผ่า
          $('#password_match1').removeClass().addClass('match').text('รหัสผ่านเก่าถูกต้อง');
          if(PasswordNew == PasswordConfrim && PasswordNew != "" && PasswordConfrim != "") {
              $('#password_match').removeClass().addClass('match').text('รหัสผ่านตรงกัน');
              $('#BtnResetPassword').prop('disabled', false); // เปิดปุ่ม
          } else {
              $('#password_match').removeClass().addClass('mismatch').text('รหัสผ่านไม่ตรงกัน!');
              $('#BtnResetPassword').prop('disabled', true); // ปิดปุ่ม
          }
      } else {
          $('#password_match1').removeClass().addClass('mismatch').text('รหัสผ่านเก่าไม่ถูกต้อง');
          $('#BtnResetPassword').prop('disabled', true); // ปิดปุ่ม
      }
  }
});

});
