$(document).on("submit","#loginForm", function(e) {
    e.preventDefault();
    
    $.ajax({
        type: "POST",
        url: "../../../php/Login/PhpLoginMain.php",
        data: $(this).serialize(),
        success: function(response) {
            var data = JSON.parse(response);
            console.log(data.Type);
            if(data.Type == "teacher"){
               window.location.href = "../../../pages/Teacher/Home/HomeMain";
            }else if(data.Type == "student"){ 
                Swal.fire({
                    title: "ยินดีต้อนรับ!",
                    text: data.FullName,
                    icon: "success"
                  }).then((result) => {
                    if (result.isConfirmed) {
                        location.reload(); // รีโหลดหน้าปัจจุบัน
                    }
                  }); 
            }else if(data.Type == "admin"){
              window.location.href = "../../../pages/Admin/Home/HomeMain";
            }
            else{
                Swal.fire({
                    title: "แจ้งเตือน!",
                    text: "ชื่อผู้ใช้งาน หรือ รหัสผ่าน ไม่ถูกต้อง?",
                    icon: "error"
                  });
            }
           
       }
   });
 });