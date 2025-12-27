$('#Tb_Couesr').DataTable({
    "paging": true,   
    "ordering": true,
    "info": true,
    "autoWidth": false,
    "responsive": true,
  });

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
          if(response == 1){
            Swal.fire({
              title: "แจ้งเตือน!",
              text: "บันทึกข้อมูลคอร์สเรียนเรียบร้อย!",
              icon: "success"
            }).then((result) => {
              if (result.isConfirmed) {
                window.location.href = '../../../pages/Teacher/Course/CourseMain';
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