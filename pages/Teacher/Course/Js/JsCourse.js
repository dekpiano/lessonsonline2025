const commonDataTableConfig = {
    "responsive": true,
    "lengthChange": false,
    "autoWidth": false,
    "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
};

if ($('#Tb_Couesr').length) {
    $("#Tb_Couesr").DataTable({
        ...commonDataTableConfig,
        "ordering": true,
        "paging": true,
        "info": true
    }).buttons().container().appendTo('#Tb_Couesr_wrapper .col-md-6:eq(0)');
}

$(document).on("submit","#courseForm", function(e) {
    e.preventDefault();
    var formData = new FormData($("#courseForm")[0]);
    $.ajax({
        type: "POST",
        url: "../../../pages/Teacher/Course/Php/CoursePhpInsert.php",
        data: formData,
        contentType: false,
        processData: false,
        dateType:"json",
                success: function(response) {          
              console.log(response);
              if(response.trim() == "limit") {
                Swal.fire({
                  title: "ไม่สามารถสร้างคอร์สได้",
                  text: "ระบบมีจำนวนคอร์สเรียนครบตามจำนวนที่กำหนดแล้ว กรุณาติดต่อผู้ดูแลระบบ",
                  icon: "warning"
                });
              } else if(response == 1) {
                Swal.fire({
                  title: "แจ้งเตือน!",
                  text: "บันทึกข้อมูลคอร์สเรียนเรียบร้อย!",
                  icon: "success"
                }).then((result) => {
                  if (result.isConfirmed) {
                    window.location.href = '../../../pages/Teacher/Course/CourseMain';
                  }
                });           
              } else {
                Swal.fire({
                  title: "แจ้งเตือน!",
                  text: response.Text || "เกิดข้อผิดพลาดในการบันทึกข้อมูล",
                  icon: "error"
                });
              }
            },
        error: function() {
            $("#result").html("<div class='alert alert-danger'>There was an error processing your request</div>");
        }
    });
});

$(document).on("submit","#courseFormUpdate", function(e) {
  e.preventDefault();
  // แสดง spinner
  $('#loading').show();
  $('#btnText').text('Loading...');

  var formData = new FormData($("#courseFormUpdate")[0]);
  $.ajax({
      type: "POST",
      url: "../../../pages/Teacher/Course/Php/CoursePhpUpdate.php",
      data: formData,
      contentType: false,
      processData: false,
      success: function(response) {
        console.log(response);
        if(response == 1){
          Swal.fire({
            title: "แจ้งเตือน!",
            text: "แก้ไขข้อมูลคอร์สเรียนเรียบร้อย!",
            icon: "success"
          }).then((result) => {
            if (result.isConfirmed) {
              window.location.href = '../../../pages/Teacher/Course/CourseMain';
            }
          });
        }
        
      },
          complete: function() {
              // ซ่อน spinner และเปลี่ยนข้อความกลับเมื่อเสร็จสิ้น
              $('#loading').hide();
              $('#btnText').text('แก้ไขคอร์สเรียน');
          },
      error: function() {
          $("#result").html("<div class='alert alert-danger'>There was an error processing your request</div>");
      }
  });
});

function confirmDeleteCourse(deleteId) {
    Swal.fire({
        title: 'คุณแน่ใจหรือไม่?',
        text: "คุณต้องการลบคอร์สเรียนนี้และข้อมูลที่เกี่ยวข้องทั้งหมด?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'ใช่, ฉันต้องการลบ!',
        cancelButtonText: 'ยกเลิก'
    }).then((result) => {
        if (result.isConfirmed) {
            $.post("../../../pages/Teacher/Course/Php/CoursePhpDelete.php", {
                CourseID: deleteId
            }, function(response) {
                if (parseInt(response.trim()) > 0) {
                    Swal.fire(
                        'ลบข้อมูลเรียบร้อย!',
                        'ไฟล์ของคุณถูกลบแล้ว.',
                        'success'
                    );
                    $("#Course" + response.trim()).fadeOut(1000, function() {
                        $(this).remove();
                    });
                } else {
                    Swal.fire(
                        'เกิดข้อผิดพลาด!',
                        'ไม่สามารถลบข้อมูลได้',
                        'error'
                    );
                }
            });
        }
    });
}