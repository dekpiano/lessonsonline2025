let timing = 60; // 60 seconds per cycle
let endTime = new Date().getTime() + (timing * 1000);
const circle = document.querySelector('#countdown circle');
const number = document.getElementById('number');
const circumference = 2 * Math.PI * circle.getAttribute('r');

circle.style.strokeDasharray = `${circumference} ${circumference}`;
circle.style.strokeDashoffset = `${circumference}`;

function updateCountdown() {
  const now = new Date().getTime();
  let distance = endTime - now;

  // Ensure distance doesn't drop below 0 for display (before reset)
  if (distance < 0) distance = 0;

  const seconds = Math.ceil(distance / 1000);

  // Calculate the offset for the circular progress
  // At 60s (start), percentage should be 1.0 -> offset 0 (Full circle) or offset circumference (Empty)?
  // Original code: percent = (distance / 60000) * C. 
  // If distance = 60000, percent = C. offset = C - C = 0. (Full)
  // If distance = 0, percent = 0. offset = C. (Empty)
  const percent = (distance / (timing * 1000)) * circumference;
  circle.style.strokeDashoffset = circumference - percent;

  // Update the timer display
  // Show 60 as 0:60 or 1:00? User code had 0:ss. 
  // Let's stick to 00 - 60 range.
  number.textContent = `0:${seconds < 10 ? '0' : ''}${seconds}`;

  // When timer reaches 0, trigger update
  if (distance <= 0) {
    resetCountdown();    
  }
}

function resetCountdown() {
  // Add 1 second buffer to prevent double firing or drift issues visually
  endTime = new Date().getTime() + (timing * 1000) + 200; 
  updateCountdown(); 
  UpdateTimeLesson(1); // Add 1 minute to server
}

function UpdateTimeLesson(CountTime = 0) {
  let LessProID = $('#LessProID').val();
  let CourseID = $('#CourseID').val();
  let LessonStudyTime = parseFloat($('#LessonStudyTime').val()) || 0;
  let CountTimeFull = CountTime;

  $.ajax({
    type: "POST",
    url: "../../../pages/Users/Learn/Php/EnrollmentUpdateTime.php",
    data: { 
        LessProID: LessProID, 
        CountTimeFull: CountTimeFull, 
        CourseID: CourseID 
    },
    success: function(response) {
        console.log("Current Study Time: " + response + " / Required: " + LessonStudyTime);
        let currentProgress = parseFloat(response) || 0;
        
        $('#RoundTime').html(currentProgress);

        if (currentProgress < LessonStudyTime) {
          // Not finished yet
          $('#btnQuiz').addClass('d-none');
          $('#btnLocked').removeClass('d-none');
        } else {
          // Finished
          $('#RoundTime').html(currentProgress); // Ensure final time is shown
          $('#btnQuiz').removeClass('d-none'); // Show Quiz Button
          $('#btnLocked').addClass('d-none');  // Hide Locked Button
          
          // Stop the local timer
          clearInterval(interval);
          number.textContent = "✔"; // Show checkmark or similar
          circle.style.strokeDashoffset = 0; // Full circle
        }
    },
    error: function() {
        console.error("Failed to update status");
    }
  });
}

// Start checks
updateCountdown();
UpdateTimeLesson(0); // Initial check
const interval = setInterval(updateCountdown, 100); // Update more frequently for smoother animation
