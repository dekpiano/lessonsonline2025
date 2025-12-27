$(document).on("submit","#FormRegisterTeacher", function(e) {
    e.preventDefault();
    var formData = $(this).serialize();
    $.ajax({
        type: "POST",
        url: "../../../pages/Admin/Teacher/Php/RegisterPhpInsert.php",
        data: formData,
        success: function(response) {
            console.log(response);
            if(response.trim() == "limit") {
                Swal.fire({
                  title: 'ไม่สามารถเพิ่มครูผู้สอนได้',
                  text: 'ระบบมีจำนวนบัญชีครูผู้สอนครบตามจำนวนที่กำหนดแล้ว กรุณาติดต่อผู้ดูแลระบบ',
                  icon: 'warning',
                  confirmButtonText: 'ตกลง'
                });
            } else if(response == 1) {
                Swal.fire({
                  title: 'สำเร็จ!',
                  text: 'เพิ่มครูผู้สอนเรียบร้อย',
                  icon: 'success',
                  confirmButtonText: 'ตกลง'
              }).then((result) => {
                  if (result.isConfirmed) {
                    window.location.href = '../../../pages/Admin/Teacher';
                  }
              });
            } else {
                Swal.fire('เกิดข้อผิดพลาด', 'ไม่สามารถเพิ่มครูผู้สอนได้', 'error');
            }
        },
        error: function() {
          Swal.fire('เกิดข้อผิดพลาด', 'ไม่สามารถสมัครครูผู้สอนได้', 'error');
        }
    });
});

function deleteTeacher(id) {
    Swal.fire({
        title: 'ยืนยันการลบ?',
        text: "คุณต้องการลบข้อมูลครูท่านนี้ใช่หรือไม่? การกระทำนี้ไม่สามารถย้อนกลับได้",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'ลบข้อมูล',
        cancelButtonText: 'ยกเลิก'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "POST",
                url: "../../../pages/Admin/Teacher/Php/RegisterPhpDelete.php",
                data: { UserID: id },
                success: function(response) {
                    if (response == 1) {
                        Swal.fire(
                            'ลบเรียบร้อย!',
                            'ข้อมูลครูถูกลบแล้ว',
                            'success'
                        );
                        $("#row_" + id).fadeOut(500, function() { $(this).remove(); });
                    } else {
                        Swal.fire('เกิดข้อผิดพลาด', 'ไม่สามารถลบข้อมูลได้', 'error');
                    }
                }
            });
        }
    });
}

function fetchTeacherData(id) {
    $.ajax({
        type: "POST",
        url: "../../../pages/Admin/Teacher/Php/RegisterPhpFetch.php",
        data: { UserID: id },
        dataType: "json",
        success: function(response) {
            $('#edit_UserID').val(response.UserID);
            $('#edit_UserPrefix').val(response.UserPrefix);
            $('#edit_UserFirstName').val(response.UserFirstName);
            $('#edit_UserLastName').val(response.UserLastName);
            $('#edit_UserBirthday').val(response.UserBirthday);
            $('#edit_UserPhone').val(response.UserPhone);
            $('#edit_Email').val(response.Email);
            $('#edit_Password').val(''); // Reset password field

            $('#modalEditTeacher').modal('show');
        }
    });
}

function updateTeacher() {
    var formData = $('#FormEditTeacher').serialize();
    $.ajax({
        type: "POST",
        url: "../../../pages/Admin/Teacher/Php/RegisterPhpUpdate.php",
        data: formData,
        success: function(response) {
            if (response == 1) {
                Swal.fire({
                    title: 'บันทึกสำเร็จ!',
                    text: 'ข้อมูลครูผู้สอนถูกแก้ไขเรียบร้อยแล้ว',
                    icon: 'success',
                    timer: 1500,
                    showConfirmButton: false
                }).then(() => {
                    location.reload(); 
                });
            } else {
                Swal.fire('เกิดข้อผิดพลาด', 'ไม่สามารถแก้ไขข้อมูลได้', 'error');
            }
        }
    });
}