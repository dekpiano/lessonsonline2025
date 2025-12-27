$('#Tb_Couesr').DataTable({
    "paging": true,   
    "ordering": true,
    "info": true,
    "autoWidth": false,
    "responsive": true,
  });

$('#summernote').summernote({
  height: 400,               
});

$(document).on("submit","#LessonFormInsert", function(e) {
    e.preventDefault();

    var formData = new FormData(this); // สร้าง formData จากฟอร์ม
    formData.append('LessonContent', $('#summernote').summernote('code')); 

    $.ajax({
        type: "POST",
        url: "../../../pages/Teacher/Lesson/Php/LessonPhpInsert.php",
        data: formData,
        processData: false, // ไม่ประมวลผลข้อมูล
        contentType: false, // ไม่ตั้งค่า contentType
        cache: false,
        beforeSend: function() {
              // ก่อนส่ง AJAX request, แสดง Spinner และปิดใช้งานปุ่ม
              $("#spinner").show();
              $("#saveButton").prop("disabled", true);
          },
          complete: function() {
            // เมื่อ AJAX request เสร็จสิ้น, ซ่อน Spinner และเปิดใช้งานปุ่ม
            $("#spinner").hide();
            $("#saveButton").prop("disabled", false);
        },
        success: function(response) {
          var data = JSON.parse(response);
          console.log(data.message);
          if(data.message == 1){
            Swal.fire({
              title: "แจ้งเตือน!",
              text: "บันทึกข้อมูลบทเรียนเรียบร้อย!",
              icon: "success"
            }).then((result) => {
              if (result.isConfirmed) {
                window.location.href = '../../../pages/Teacher/Lesson/LessonMain?CourseID='+data.CourseID;
              }
            });
          }
           
        },
        error: function() {
            $("#result").html("<div class='alert alert-danger'>There was an error processing your request</div>");
        }
    });
});

$(document).on("submit","#LessonFormUpdate", function(e) {
  e.preventDefault();
  var formData = $(this).serialize();
  $.ajax({
      type: "POST",
      url: "../../../pages/Teacher/Lesson/Php/LessonPhpUpdate.php",
      data: formData,
      success: function(response) {
        var data = JSON.parse(response);
        console.log(response);
        if(data.message == 1){
          Swal.fire({
            title: "แจ้งเตือน!",
            text: "แก้ไขข้อมูลบทเรียนเรียบร้อย!",
            icon: "success"
          }).then((result) => {
            if (result.isConfirmed) {
              window.location.href = '../../../pages/Teacher/Lesson/LessonMain?CourseID='+data.CourseID;
            }
          });
        }
        
      },
      error: function() {
          $("#result").html("<div class='alert alert-danger'>There was an error processing your request</div>");
      }
  });
});
