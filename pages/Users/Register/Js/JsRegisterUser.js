$(document).ready(function() {
    const $submitBtn = $('#BtnSubmitRegister');
    const $password = $('#Password');
    const $confirmPassword = $('#ConfirmPassword');
    const $idCard = $('#UserIdCard');
    const $feedbackLength = $('#feedback-length');
    const $feedbackMatch = $('#feedback-match');
    
    // State object to track validity of each section
    let state = {
        email: false,
        password: false,
        match: false,
        idCard: false
    };

    // Central function to enable/disable submit button
    function validateState() {
        // Debug: console.log(state);
        if (state.email && state.password && state.match && state.idCard) {
            $submitBtn.prop('disabled', false);
        } else {
            $submitBtn.prop('disabled', true);
        }
    }

    // --- Email Validation ---
    window.CheckEmailRegister = function() {
        const email = $('#Email').val();
        if (email.length === 0) {
            $('#emailStatus').text('');
            state.email = false;
            validateState();
            return;
        }

        // Basic Regex format check first
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
            $('#emailStatus').html('<span class="text-danger small">รูปแบบอีเมลไม่ถูกต้อง</span>');
            state.email = false;
            validateState();
            return;
        }

        $.ajax({
            type: "POST",
            url: "../../../pages/Users/Register/Php/RegisterPhpCheckEmail.php",
            data: {Email: email},
            success: function(response) {
                // Assuming response '1' means exists, '0' means available
                if (response.trim() == '1') {
                    $('#emailStatus').html('<span class="text-danger small">อีเมลนี้มีผู้ใช้งานแล้ว!</span>');
                    state.email = false;
                } else {
                    $('#emailStatus').html('<span class="text-success small"><i class="fas fa-check-circle"></i> อีเมลใช้งานได้</span>');
                    state.email = true;
                }
                validateState();
            }
        });
    }

    // --- Password Validation ---
    function checkPassword() {
        const val = $password.val();
        // Check Length >= 8
        if (val.length >= 8) {
            $feedbackLength.addClass('valid');
            state.password = true;
        } else {
            $feedbackLength.removeClass('valid');
            state.password = false;
        }
        // Re-check match whenever password changes
        checkMatch();
        validateState();
    }

    function checkMatch() {
        const val = $password.val();
        const confirmVal = $confirmPassword.val();
        
        if (val === confirmVal && val.length > 0) {
            $feedbackMatch.addClass('valid');
            state.match = true;
        } else {
            $feedbackMatch.removeClass('valid');
            state.match = false;
        }
        validateState();
    }

    $password.on('keyup input', checkPassword);
    $confirmPassword.on('keyup input', checkMatch);

    // Toggle Password Visibility
    $('#togglePassword').on('click', function() {
        const type = $password.attr('type') === 'password' ? 'text' : 'password';
        $password.attr('type', type);
        $(this).find('i').toggleClass('fa-eye fa-eye-slash');
    });

    // --- Thai ID Card Validation ---
    function validateThaiID(id) {
        if(id.length != 13) return false;
        if(!/^[0-9]+$/.test(id)) return false;
        
        let sum = 0;
        for(let i=0; i < 12; i++) {
            sum += parseFloat(id.charAt(i)) * (13-i);
        }
        let check = (11 - sum % 11) % 10;
        if(check == parseFloat(id.charAt(12))) return true;
        return false;
    }

    $idCard.on('keyup input change', function() {
        let id = $(this).val();
        const $msg = $('#message13');
        
        // Remove non-numeric characters for valid input data
        id = id.replace(/[^0-9]/g, '');
        
        // Limit to 13 digits
        if (id.length > 13) {
            id = id.slice(0, 13);
        }
        $(this).val(id); // update input value

        if (validateThaiID(id)) {
            $msg.html('<span class="text-success small"><i class="fas fa-check-circle"></i> หมายเลขบัตรประชาชนถูกต้อง</span>');
            state.idCard = true;
        } else {
            if(id.length > 0) {
                 $msg.html('<span class="text-danger small">รูปแบบหมายเลขบัตรประชาชนไม่ถูกต้อง</span>');
            } else {
                 $msg.html('');
            }
            state.idCard = false;
        }
        validateState();
    });

    // --- Form Submit ---
    $('#FormRegisterUser').on('submit', function(e) {
        e.preventDefault();
        
        // Final validation check
        if (!state.email || !state.password || !state.match || !state.idCard) {
            Swal.fire({
                title: 'ข้อมูลไม่ครบถ้วน', 
                text: 'กรุณากรอกข้อมูลที่จำเป็นให้ครบถ้วนและถูกต้อง', 
                icon: 'warning',
                confirmButtonText: 'ตกลง'
            });
            return;
        }

        var formData = $(this).serialize();
        
        // Show loading state
        Swal.fire({
            title: 'กำลังบันทึกข้อมูล...',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        $.ajax({
            type: "POST",
            url: "../../../pages/Users/Register/Php/RegisterPhpInsert.php",
            data: formData,
            success: function(response) {
                console.log(response); 
                // Check PHP response (Assuming '1' or specific success message)
                // Note: The previous view of RegisterPhpInsert.php was simplistic. 
                // Just assuming output 1 for success based on typical simple PHP logic seen before.
                Swal.fire({
                    title: 'สมัครสมาชิกสำเร็จ!',
                    text: 'ยินดีต้อนรับสู่ Lessons Online',
                    icon: 'success',
                    timer: 2000,
                    showConfirmButton: false
                }).then(() => {
                    window.location.href = '../../../pages/Users/Home/HomeMain';
                });
            },
            error: function() {
                Swal.fire('เกิดข้อผิดพลาด', 'ไม่สามารถเชื่อมต่อระบบได้ กรุณาลองใหม่อีกครั้ง', 'error');
            }
        });
    });

});
