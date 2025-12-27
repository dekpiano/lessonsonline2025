
$(document).on("submit","#FormCheckAnswers", function(e) {
    e.preventDefault();
    var formData = new FormData($("#FormCheckAnswers")[0]);
    $.ajax({
        type: "POST",
        url: "../../../pages/Users/Quizzes/Php/CheckAnswersUser.php",
        data: formData,
        contentType: false,
        processData: false,
        dateType:"json",
        success: function(response) {          
          console.log(response);
          if(response == 1){
            Swal.fire({
              title: "แจ้งเตือน!",
              text: "ส่งแบบทดสอบเรียบร้อย!",
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

let round = $(".QuestionText").length
$(document).on("click",".radio-button", function() {
    for (let index = 1; index <= round; index++) {
        if($(this).attr('key_main') == index){
            $(".R"+index).attr('style',"");
            $(".mark"+index).remove();
        }
    }
    
   
});
