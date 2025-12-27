$(document).on("submit","#FormInsertQuizzes", function(e) {
    e.preventDefault();

    $('input[name="OptAnswer[]"]').each(function() {
        // ถ้าไม่มี checkbox ไหนถูกเลือกในรอบนี้
        if (!$(this).is(":checked")) {
            // เพิ่ม checkbox ที่ไม่ได้ถูกเลือกเข้าไปในฟอร์ม โดยกำหนดค่า default เป็น 0
            console.log($(this).after('<input type="hidden" name="OptAnswer[]" value="0">'));
        }
    });

    var formData = new FormData($("#FormInsertQuizzes")[0]);
    $.ajax({
        type: "POST",
        url: "../../../pages/Teacher/Quizzes/Php/QuizzesPhpInsert.php",
        data: formData,
        contentType: false,
        processData: false,
        dateType:"json",
        success: function(response) {          
          console.log(response);
          if(response == 1){
            Swal.fire({
              title: "แจ้งเตือน!",
              text: "บันทึกคำถามเรียบร้อย!",
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

$(document).on("submit","#FormUpdateQuizzes", function(e) {
  e.preventDefault();

  $('input[name="OptAnswer[]"]').each(function() {
      // ถ้าไม่มี checkbox ไหนถูกเลือกในรอบนี้
      if (!$(this).is(":checked")) {
          // เพิ่ม checkbox ที่ไม่ได้ถูกเลือกเข้าไปในฟอร์ม โดยกำหนดค่า default เป็น 0
          $(this).after('<input type="hidden" name="OptAnswer[]" value="0">')
          //console.log($(this).after('<input type="hidden" name="OptAnswer[]" value="0">'));
      }
  });

  $('input[name="UpdateOptAnswer[]"]').each(function() {
    // ถ้าไม่มี checkbox ไหนถูกเลือกในรอบนี้
    if (!$(this).is(":checked")) {
        // เพิ่ม checkbox ที่ไม่ได้ถูกเลือกเข้าไปในฟอร์ม โดยกำหนดค่า default เป็น 0
        $(this).after('<input type="hidden" name="UpdateOptAnswer[]" value="0">')
        //console.log($(this).after('<input type="hidden" name="OptAnswer[]" value="0">'));
    }
});

  var formData = new FormData($("#FormUpdateQuizzes")[0]);
  $.ajax({
      type: "POST",
      url: "../../../pages/Teacher/Quizzes/Php/QuizzesPhpUpdate.php",
      data: formData,
      contentType: false,
      processData: false,
      dateType:"json",
      success: function(response) {          
        console.log(response);
        if(response == 1){
          Swal.fire({
            title: "แจ้งเตือน!",
            text: "แก้ไขข้อมูลเรียบร้อย!",
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

$(document).on("click",".BtnEditQuizzes", function(e) {

   $.post("../../../pages/Teacher/Quizzes/Php/QuizzesPhpEdit.php", { IDQuestion: $(this).attr('IDQuestion') })
          .done(function(response) {

           // console.log(response[0].QuestionImg);
           
            $('#UpdateQuestionText').val(response[0].QuestionText);
            $('#UpdateQuestionID').val(response[0].QuestionID);
            $('#UpdateimagePreview').attr("src","../../../uploads/Question/"+response[0].QuestionImg);
            var container = $("#Update-options-container");
            container.empty();
            $.each(response, function(index, value) {
              let Check;
              if(value.OptAnswer == 1){
                Check = "checked";
              }else{
                Check = "";
              }
              var num = index+1;
              var ImgOption = "<img id='OptionPreviwe"+(num)+"' class='OptionPreviwe'  src='../../../uploads/Options/"+value.OptImg+"' alt='' style='width:150px'";
              var html =
                '<div> <input type="hidden" id="UpdateOptID" name="OptID[]" value="'+value.OptID+'"><div class="d-flex align-items-center mt-2"><div class="mr-2" style="width: -webkit-fill-available;"><input type="text" id="UpdateOptChoice" name="UpdateOptChoice[]" class="form-control"placeholder="ใส่ตัวเลือกคำตอบ" required value="'+value.OptChoice+'"></div><div><label for="Update-OrtionFile' +
                (num) +
        '" class="file-label mb-0 mr-2"><i class="fas fa-image upload-icon"></i></label><input type="file" class="option-file-Update" name="OptImg[]" id="Update-OrtionFile' +
        (num) +
        '"  accept="image/*" style="display: none;"> </div><div><div class="icheck-primary d-inline"><input type="checkbox" id="UpdateOptAnswer' +
                index + '" name="UpdateOptAnswer[]" value="1"  '+Check+'><label for="UpdateOptAnswer' + index + '"></label></div></div></div><div>'+ImgOption+'</div></div>';
            container.append(html);
            });

           
          },'json')
          .fail(function(xhr, status, error) {
              console.error("Error:", error);
          });
});



function confirmDeleteQuiz(deleteId) {
 
  Swal.fire({
      title: 'คุณแน่ใจหรือไม่?',
      text: "คุณต้องการลบข้อมูลนี้?",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'ใช่, ลบข้อมูล!',
      cancelButtonText: 'ยกเลิก'
  }).then((result) => {
      if (result.isConfirmed) {
          // หากผู้ใช้ยืนยันการลบ ให้เรียกฟังก์ชันลบข้อมูล
          $.post("../../../pages/Teacher/Quizzes/Php/QuizzesPhpDelete.php", { delete_id: deleteId })
          .done(function(response) {

            if(response >= 1){
              $('#Quiz' + response).remove();
            }
           console.log(response);
          })
          .fail(function(xhr, status, error) {
              console.error("Error:", error);
          });
      }
  });
}