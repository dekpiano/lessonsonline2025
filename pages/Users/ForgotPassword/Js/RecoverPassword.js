
document.addEventListener('DOMContentLoaded', () => {
    const password1Input = document.getElementById('PasswordMain');
    const password2Input = document.getElementById('ConfrimPassword');
    const messageElement = document.getElementById('message');
    const submitButton = document.getElementById('submitButton');

    function validatePassword(password) {
        const minLength = 8;
        const maxLength = 20;
        const minUpper = 1;
        const minLower = 1;
        const minDigit = 1;
        const minSpecial = 1;

        if (password.length < minLength || password.length > maxLength) {
            return `รหัสผ่านต้องมีความยาวระหว่าง ${minLength} ถึง ${maxLength} ตัวอักษร`;
        }
        if ((password.match(/[A-Z]/g) || []).length < minUpper) {
            return `รหัสผ่านต้องมีตัวอักษรพิมพ์ใหญ่ อย่างน้อย ${minUpper} ตัว`;
        }
        if ((password.match(/[a-z]/g) || []).length < minLower) {
            return `รหัสผ่านต้องมีตัวอักษรพิมพ์เล็ก อย่างน้อย ${minLower} ตัว`;
        }
        if ((password.match(/[0-9]/g) || []).length < minDigit) {
            return `รหัสผ่านต้องมีตัวเลข อย่างน้อย ${minDigit} ตัว`;
        }
        if ((password.match(/[\W_]/g) || []).length < minSpecial) {
            return `รหัสผ่านต้องมีตัวอักษรพิเศษ อย่างน้อย ${minSpecial} ตัว`;
        }

        return "รหัสผ่านถูกต้อง";
    }

    function validateForm() {
        const password1 = password1Input.value;
        const password2 = password2Input.value;

        const validationMessage = validatePassword(password1);

        if (validationMessage !== "รหัสผ่านถูกต้อง") {
            messageElement.textContent = validationMessage;
            messageElement.style.color = "red";
            submitButton.disabled = true; // ปิดการใช้งานปุ่ม
            return;
        }

        if (password1 === password2) {
            messageElement.textContent = "รหัสผ่านตรงกัน";
            messageElement.style.color = "green";
            submitButton.disabled = false; // เปิดใช้งานปุ่ม
        } else {
            messageElement.textContent = "รหัสผ่านไม่ตรงกัน";
            messageElement.style.color = "red";
            submitButton.disabled = true; // ปิดการใช้งานปุ่ม
        }
    }

    password1Input.addEventListener('input', validateForm);
    password2Input.addEventListener('input', validateForm);
});