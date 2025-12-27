let timing = 60; //วินาที
let end = new Date().getTime() + (timing * 1000); // 10 seconds from now
const circle = document.querySelector('circle');
const number = document.getElementById('number');
const circumference = 2 * Math.PI * circle.getAttribute('r');
let RoundTime = 0;

circle.style.strokeDasharray = `${circumference} ${circumference}`;
circle.style.strokeDashoffset = `${circumference}`;

function updateCountdown() {
  const now = new Date().getTime();
  const distance = end - now;
  const seconds = Math.floor((distance % (1000 * timing)) / 1000);

  // Calculate the offset for the circular progress
  const percent = (((distance / 1000)) / timing) * circumference;
  circle.style.strokeDashoffset = circumference - percent;

  // Update the timer display
  number.textContent = `0:${seconds < 10 ? '0' : ''}${seconds}`;

  // Automatically restart the countdown when it reaches 0
  if (distance < 0) {
    resetCountdown();    
  }
}

function resetCountdown() {
  end = new Date().getTime() + (timing * 1000); // Reset end time to 10 seconds from now
  circle.style.strokeDashoffset = `${circumference}`; // Reset the circle's stroke dashoffset
  updateCountdown(); // Update the countdown immediately to avoid delay
  //RoundTime += 1;
  //document.getElementById('RoundTime').innerHTML = RoundTime+0;
  UpdateTimeLesson(1);
}

function UpdateTimeLesson(CountTime) {
  let LessProID = document.getElementById('LessProID').value;
  let CourseID = document.getElementById('CourseID').value;
  let LessonStudyTime = document.getElementById('LessonStudyTime').value;
 // let LeesonID = document.getElementById('LeesonID').value;
  let CountTimeFull = CountTime;
  $.ajax({
    type: "POST",
    url: "../../../pages/Users/Learn/Php/EnrollmentUpdateTime.php", // เปลี่ยนเป็น URL ของไฟล์ที่รับข้อมูลและอัพเดตฐานข้อมูล
    data: { LessProID: LessProID,CountTimeFull:CountTimeFull,CourseID:CourseID }, // ส่งข้อมูลตามที่ต้องการ
    success: function(response) {
       console.log(response); // พิมพ์การตอบกลับจากเซิร์ฟเวอร์ใน console
        if(response != LessonStudyTime){
          document.getElementById('RoundTime').innerHTML = response;
          $('#btnQuiz').addClass('disabled');

        }else{
          document.getElementById('RoundTime').innerHTML = response;
          $('#btnQuiz').removeClass('disabled');
         // $('#LessonNo'+LeesonID).removeClass('d-none');
          clearInterval(interval);
          
        }
        
    }
});
}

updateCountdown(); // Initialize the countdown
//document.getElementById('RoundTime').innerHTML = 0;
UpdateTimeLesson();
const interval = setInterval(updateCountdown, 1000);

