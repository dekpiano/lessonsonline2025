$(document).on("submit","#FormRegisterTeacher", function(e) {
    e.preventDefault();
    var formData = $(this).serialize();
    $.ajax({
        type: "POST",
        url: "../../../pages/Admin/Teacher/Php/RegisterPhpInsert.php",
        data: formData,
        success: function(response) {
            console.log(response);
            Swal.fire({
              title: 'สำเร็จ!',
              text: 'สมัครครูผู้สอนเรียบร้อย',
              icon: 'success',
              confirmButtonText: 'ตกลง'
          }).then((result) => {
              if (result.isConfirmed) {
                window.location.href = '../../../pages/Admin/Teacher'; // หรือหน้าอื่นที่คุณต้องการ
              }
          });

        },
        error: function() {
          Swal.fire('เกิดข้อผิดพลาด', 'ไม่สามารถสมัครครูผู้สอนได้', 'error');
        }
    });
});