$(document).on("submit","#FormAssessmentInsert", function(event) {
  event.preventDefault(); // Prevent default form submission

  $.ajax({
      url: '../../../pages/Users/Assessment/Php/AssessmentInsert.php',
      method: 'POST',
      data: $(this).serialize(),
      success: function(response) {
        console.log(response);
          Swal.fire(
              'บันทึกสำเร็จ!',
              'คุณสามารถดาวน์โหลดเกียรติบัตรได้เลย.',
              'success'
          ).then((result) => {
            if (result.isConfirmed) {
              window.location.href = '../Course/CourseMy';
            }
          });;
      },
      error: function(jqXHR, textStatus, errorThrown) {
          Swal.fire(
              'Error!',
              'There was an issue submitting your assessment.',
              'error'
          );
      }
  });
});

$(document).on("submit","#FormAssessmentUpdate", function(event) {
  event.preventDefault(); // Prevent default form submission

  $.ajax({
      url: '../../../pages/Users/Assessment/Php/AssessmentUpdate.php',
      method: 'POST',
      data: $(this).serialize(),
      success: function(response) {
        console.log(response);
          Swal.fire(
              'บันทึกสำเร็จ!',
              'คุณสามารถดาวน์โหลดเกียรติบัตรได้เลย.',
              'success'
          ).then((result) => {
            if (result.isConfirmed) {
              window.location.href = '../Course/CourseMy';
            }
          });
      },
      error: function(jqXHR, textStatus, errorThrown) {
          Swal.fire(
              'Error!',
              'There was an issue submitting your assessment.',
              'error'
          );
      }
  });
});