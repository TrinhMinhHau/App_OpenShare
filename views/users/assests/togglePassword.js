function togglePasswordVisibility() {
  var passwordInput = document.getElementById("password");
  var toggleButton = document.getElementById("togglePassword");

  if (passwordInput.type === "password") {
    passwordInput.type = "text";
    toggleButton.classList.remove("bi-eye");
    toggleButton.classList.add("bi-eye-slash");
  } else {
    passwordInput.type = "password";
    toggleButton.classList.remove("bi-eye-slash");
    toggleButton.classList.add("bi-eye");
  }
}
var passwordInput = document.getElementById("password");
passwordInput.addEventListener("input", function () {
  var toggleButton = document.getElementById("togglePassword");

  if (passwordInput.value !== "") {
    toggleButton.style.display = "block";
  } else {
    toggleButton.style.display = "none";
  }
});
