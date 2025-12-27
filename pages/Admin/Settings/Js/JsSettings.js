$(document).ready(function() {
    $('#FormSettingsCourse').submit(function(e) {
        e.preventDefault();
        
        var formData = $(this).serialize();
        
        $.ajax({
            type: "POST",
            url: "Php/SettingsUpdate.php",
            data: formData,
            success: function(response) {
                if (response.trim() == "1") {
                    Swal.fire({
                        icon: 'success',
                        title: 'บันทึกสำเร็จ',
                        text: 'อัปเดตการตั้งค่าเรียบร้อยแล้ว',
                        showConfirmButton: false,
                        timer: 1500
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'เกิดข้อผิดพลาด',
                        text: 'ไม่สามารถบันทึกข้อมูลได้ กรุณาลองใหม่อีกครั้ง'
                    });
                }
            },
            error: function() {
                Swal.fire({
                    icon: 'error',
                    title: 'เกิดข้อผิดพลาด',
                    text: 'การเชื่อมต่อล้มเหลว'
                });
            }
        });
    });
});
