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

$(document).on("click", ".BtnEditQuizzes", function(e) {
    $.post("../../../pages/Teacher/Quizzes/Php/QuizzesPhpEdit.php", {
            IDQuestion: $(this).attr('IDQuestion')
        })
        .done(function(response) {
            $('#UpdateQuestionText').val(response[0].QuestionText);
            $('#UpdateQuestionID').val(response[0].QuestionID);

            if (response[0].QuestionImg) {
                $('#UpdateimagePreview').attr("src", "../../../uploads/Question/" + response[0].QuestionImg);
                $('#up-q-preview-box').removeClass('d-none');
            } else {
                $('#UpdateimagePreview').attr("src", "#");
                $('#up-q-preview-box').addClass('d-none');
            }

            var container = $("#Update-options-container");
            container.empty();
            
            var labels = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H'];

            $.each(response, function(index, value) {
                let Check = value.OptAnswer == 1 ? "checked" : "";
                let CorrectClass = value.OptAnswer == 1 ? "is-correct" : "";
                var num = index + 1;
                var label = labels[index] || num;
                
                var imgPath = value.OptImg ? "../../../uploads/Options/" + value.OptImg : "#";
                var imgDisplay = value.OptImg ? "" : "d-none";

                var html = `
                <div class="option-item d-flex flex-column ${CorrectClass}" id="up-opt-item-${num}">
                    <input type="hidden" name="OptID[]" value="${value.OptID}">
                    <div class="d-flex align-items-center">
                        <div class="choice-label">${label}</div>
                        <div class="flex-grow-1">
                            <input type="text" name="UpdateOptChoice[]" class="form-control border-0 bg-light"
                                placeholder="ระบุตัวเลือกคำตอบ" required style="border-radius: 8px;" value="${value.OptChoice}">
                        </div>
                        <div class="ml-2">
                            <label for="UP-OrtionFile${num}" class="upload-trigger mb-0" title="เปลี่ยนรูปภาพ">
                                <i class="fas fa-camera"></i>
                            </label>
                            <input type="file" class="option-file-Update d-none" name="OptImg[]" id="UP-OrtionFile${num}" accept="image/*">
                            <input type="hidden" name="UpdateOptImgDelete[]" class="opt-img-delete" value="0">
                        </div>
                        <div class="correct-checkbox">
                            <div class="custom-control custom-checkbox ml-2">
                                <input type="checkbox" class="custom-control-input" id="UpdateOptAnswer${index}" name="UpdateOptAnswer[]" value="1" ${Check}>
                                <label class="custom-control-label font-weight-bold text-xs" for="UpdateOptAnswer${index}">ถูก</label>
                            </div>
                        </div>
                        <button type="button" class="btn btn-link text-danger ml-2 p-1" onclick="removeOption(this)">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </div>
                    <div class="image-preview-wrapper mt-2 ${imgDisplay}" id="up-preview-box-${num}">
                        <img id="OptionPreviwe${num}" src="${imgPath}" alt="">
                        <button type="button" class="btn-remove-img" onclick="removeUpdateOptionImg(${num})" title="ลบรูปภาพ">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>`;
                container.append(html);
            });
        }, 'json')
        .fail(function(xhr, status, error) {
            console.error("Error:", error);
        });
});



function confirmDeleteQuiz(deleteId) {
    Swal.fire({
        title: 'คุณแน่ใจหรือไม่?',
        text: "คุณต้องการลบแบบทดสอบนี้และข้อมูลที่เกี่ยวข้องทั้งหมด?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'ใช่, ลบข้อมูล!',
        cancelButtonText: 'ยกเลิก'
    }).then((result) => {
        if (result.isConfirmed) {
            $.post("../../../pages/Teacher/Quizzes/Php/QuizzesPhpDelete.php", {
                    delete_id: deleteId
                })
                .done(function(response) {
                    var id = parseInt(response.trim());
                    if (id >= 1) {
                        $('#Quiz' + id).fadeOut(400, function() {
                            $(this).remove();
                            Swal.fire({
                                title: "สำเร็จ!",
                                text: "ลบข้อมูลเรียบร้อยแล้ว",
                                icon: "success",
                                timer: 1500,
                                showConfirmButton: false
                            });
                        });
                    } else {
                        Swal.fire("ข้อผิดพลาด", "ไม่สามารถลบข้อมูลได้", "error");
                    }
                })
                .fail(function(xhr, status, error) {
                    console.error("Error:", error);
                    Swal.fire("ข้อผิดพลาด", "เกิดปัญหาในการเชื่อมต่อเซิร์ฟเวอร์", "error");
                });
        }
    });
}