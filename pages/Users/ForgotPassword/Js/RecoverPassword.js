document.addEventListener("DOMContentLoaded", () => {
  const password1Input = document.getElementById("PasswordMain");
  const password2Input = document.getElementById("ConfrimPassword");
  const submitButton = document.getElementById("submitButton");

  // Requirement elements
  const reqLength = document.getElementById("req-length");
  const reqUpper = document.getElementById("req-upper");
  const reqLower = document.getElementById("req-lower");
  const reqNumber = document.getElementById("req-number");
  const reqSpecial = document.getElementById("req-special");
  const reqMatch = document.getElementById("req-match");

  function updateRequirement(element, isMet) {
    const icon = element.querySelector("i");
    if (isMet) {
      element.classList.remove("requirement-unmet");
      element.classList.add("requirement-met");
      icon.classList.remove("fa-circle");
      icon.classList.add("fa-check-circle");
    } else {
      element.classList.remove("requirement-met");
      element.classList.add("requirement-unmet");
      icon.classList.remove("fa-check-circle");
      icon.classList.add("fa-circle");
    }
  }

  function validateForm() {
    const p1 = password1Input.value;
    const p2 = password2Input.value;

    const isLength = p1.length >= 8 && p1.length <= 20;
    const isUpper = /[A-Z]/.test(p1);
    const isLower = /[a-z]/.test(p1);
    const isNumber = /[0-9]/.test(p1);
    const isSpecial = /[\W_]/.test(p1);
    const isMatch = p1 === p2 && p1 !== "";

    updateRequirement(reqLength, isLength);
    updateRequirement(reqUpper, isUpper);
    updateRequirement(reqLower, isLower);
    updateRequirement(reqNumber, isNumber);
    updateRequirement(reqSpecial, isSpecial);
    updateRequirement(reqMatch, isMatch);

    const allMet =
      isLength && isUpper && isLower && isNumber && isSpecial && isMatch;
    submitButton.disabled = !allMet;
  }

  password1Input.addEventListener("input", validateForm);
  password2Input.addEventListener("input", validateForm);

  // Initialize
  validateForm();
});
