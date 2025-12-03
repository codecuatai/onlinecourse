// ==================== GLOBAL VARIABLES ====================
let isLogin = true;
let currentStep = 1;
let userEmail = "";
let resendTimer = null;
let timeLeft = 30;

// ==================== PAGE DETECTION ====================
const pageType = document.body.classList.contains("login-page")
  ? "login"
  : document.body.classList.contains("register-page")
  ? "register"
  : document.body.classList.contains("forgot-password-page")
  ? "forgot"
  : null;

// ==================== INITIALIZATION ====================
document.addEventListener("DOMContentLoaded", function () {
  initializePage();
});

function initializePage() {
  if (pageType === "login") {
    initLoginPage();
  } else if (pageType === "register") {
    initRegisterPage();
  } else if (pageType === "forgot") {
    initForgotPasswordPage();
  }

  // Add Enter key handler for all pages
  document.addEventListener("keypress", function (e) {
    if (e.key === "Enter") {
      handleEnterKey();
    }
  });
}

// ==================== LOGIN PAGE FUNCTIONS ====================
function initLoginPage() {
  console.log("Login page initialized");
}

// ==================== REGISTER PAGE FUNCTIONS ====================
function initRegisterPage() {
  // Password strength check
  const passwordInput = document.getElementById("password");
  if (passwordInput) {
    passwordInput.addEventListener("input", function () {
      const password = this.value;

      if (password.length === 0) {
        document.getElementById("password-strength").style.display = "none";
        return;
      }

      document.getElementById("password-strength").style.display = "block";
      const strength = calculatePasswordStrength(password);
      updatePasswordStrength(strength);
    });
  }
}

function calculatePasswordStrength(password) {
  let strength = 0;

  if (password.length >= 6) strength++;
  if (password.length >= 10) strength++;
  if (/[a-z]/.test(password) && /[A-Z]/.test(password)) strength++;
  if (/\d/.test(password)) strength++;
  if (/[^a-zA-Z0-9]/.test(password)) strength++;

  return strength;
}

function updatePasswordStrength(strength) {
  const strengthBar = document.getElementById("strength-bar");
  const strengthText = document.getElementById("strength-text");

  if (!strengthBar || !strengthText) return;

  const colors = ["#ef4444", "#f59e0b", "#eab308", "#84cc16", "#10b981"];
  const texts = ["Rất yếu", "Yếu", "Trung bình", "Mạnh", "Rất mạnh"];
  const widths = ["20%", "40%", "60%", "80%", "100%"];

  strengthBar.style.width = widths[strength];
  strengthBar.style.backgroundColor = colors[strength];
  strengthText.textContent = texts[strength];
  strengthText.style.color = colors[strength];
}

function socialLogin(provider) {
  alert(
    "Đăng nhập/Đăng ký bằng " + (provider === "google" ? "Google" : "Facebook")
  );
}

// ==================== FORGOT PASSWORD FUNCTIONS ====================
function initForgotPasswordPage() {
  // Auto-focus and move to next input for OTP
  const codeInputs = document.querySelectorAll(".code-input");
  codeInputs.forEach((input, index) => {
    input.addEventListener("input", function () {
      if (this.value.length === 1 && index < 5) {
        document.getElementById(`code-${index + 2}`).focus();
      }
    });

    input.addEventListener("keydown", function (e) {
      if (e.key === "Backspace" && this.value === "" && index > 0) {
        document.getElementById(`code-${index}`).focus();
      }
    });
  });
}

function startResendTimer() {
  timeLeft = 30;
  const resendBtn = document.getElementById("resend-btn");
  const timer = document.getElementById("timer");

  if (!resendBtn || !timer) return;

  resendBtn.disabled = true;
  timer.style.display = "inline";

  resendTimer = setInterval(() => {
    timeLeft--;
    timer.textContent = `(${timeLeft}s)`;

    if (timeLeft <= 0) {
      clearInterval(resendTimer);
      resendBtn.disabled = false;
      timer.style.display = "none";
    }
  }, 1000);
}

function resendCode() {
  console.log("Gửi lại mã xác nhận đến:", userEmail);
  startResendTimer();

  // Clear code inputs
  for (let i = 1; i <= 6; i++) {
    const input = document.getElementById(`code-${i}`);
    if (input) input.value = "";
  }
  const firstCode = document.getElementById("code-1");
  if (firstCode) firstCode.focus();
}

function resetPassword() {
  clearErrors();
  const newPassword = document.getElementById("new-password").value;
  const confirmPassword = document.getElementById("confirm-password").value;
  let isValid = true;

  if (!newPassword) {
    showError("new-password", "Vui lòng nhập mật khẩu mới");
    isValid = false;
  } else if (newPassword.length < 6) {
    showError("new-password", "Mật khẩu phải có ít nhất 6 ký tự");
    isValid = false;
  }

  if (!confirmPassword) {
    showError("confirm-password", "Vui lòng xác nhận mật khẩu");
    isValid = false;
  } else if (newPassword !== confirmPassword) {
    showError("confirm-password", "Mật khẩu không khớp");
    isValid = false;
  }

  if (isValid) {
    console.log("Đặt lại mật khẩu thành công cho:", userEmail);

    // Show success
    document.querySelectorAll(".step-content").forEach((el) => {
      el.classList.remove("active");
    });
    const successContent = document.getElementById("content-success");
    if (successContent) successContent.classList.add("active");

    // Hide steps indicator
    const stepsEl = document.querySelector(".steps");
    if (stepsEl) stepsEl.style.display = "none";

    const titleEl = document.getElementById("page-title");
    const descEl = document.getElementById("page-description");
    if (titleEl) titleEl.textContent = "Hoàn tất!";
    if (descEl) descEl.textContent = "";
  }
}

// ==================== FORM VALIDATION ====================
function validateForm() {
  clearErrors();
  let isValid = true;

  // For login/register combo page
  if (pageType === "login") {
    if (!isLogin) {
      const fullname = document.getElementById("fullname").value.trim();
      if (!fullname) {
        showError("fullname", "Vui lòng nhập họ tên");
        isValid = false;
      }
    }

    const email = document.getElementById("email").value.trim();
    if (!email) {
      showError("email", "Vui lòng nhập email");
      isValid = false;
    } else if (!/\S+@\S+\.\S+/.test(email)) {
      showError("email", "Email không hợp lệ");
      isValid = false;
    }

    const password = document.getElementById("password").value;
    if (!password) {
      showError("password", "Vui lòng nhập mật khẩu");
      isValid = false;
    } else if (password.length < 6) {
      showError("password", "Mật khẩu phải có ít nhất 6 ký tự");
      isValid = false;
    }

    if (!isLogin) {
      const confirmPassword = document.getElementById("confirm-password").value;
      if (!confirmPassword) {
        showError("confirm-password", "Vui lòng xác nhận mật khẩu");
        isValid = false;
      } else if (password !== confirmPassword) {
        showError("confirm-password", "Mật khẩu không khớp");
        isValid = false;
      }
    }
  }

  // For register page
  if (pageType === "register") {
    const fullname = document.getElementById("fullname").value.trim();
    if (!fullname) {
      showError("fullname", "Vui lòng nhập họ tên");
      isValid = false;
    }

    const email = document.getElementById("email").value.trim();
    if (!email) {
      showError("email", "Vui lòng nhập email");
      isValid = false;
    } else if (!/\S+@\S+\.\S+/.test(email)) {
      showError("email", "Email không hợp lệ");
      isValid = false;
    }

    const password = document.getElementById("password").value;
    if (!password) {
      showError("password", "Vui lòng nhập mật khẩu");
      isValid = false;
    } else if (password.length < 6) {
      showError("password", "Mật khẩu phải có ít nhất 6 ký tự");
      isValid = false;
    }

    const confirmPassword = document.getElementById("confirm-password").value;
    if (!confirmPassword) {
      showError("confirm-password", "Vui lòng xác nhận mật khẩu");
      isValid = false;
    } else if (password !== confirmPassword) {
      showError("confirm-password", "Mật khẩu không khớp");
      isValid = false;
    }

    const terms = document.getElementById("terms").checked;
    if (!terms) {
      showError("terms", "Vui lòng đồng ý với điều khoản");
      isValid = false;
    }
  }

  return isValid;
}

function handleSubmit() {
  if (pageType === "register") {
    if (validateForm()) {
      const fullname = document.getElementById("fullname").value;
      const email = document.getElementById("email").value;
      const phone = document.getElementById("phone").value;

      // Show success message
      const successMsg = document.getElementById("success-message");
      if (successMsg) {
        successMsg.classList.add("show");

        setTimeout(() => {
          successMsg.classList.remove("show");
        }, 3000);
      }

      // Clear form
      document.getElementById("fullname").value = "";
      document.getElementById("email").value = "";
      document.getElementById("phone").value = "";
      document.getElementById("password").value = "";
      document.getElementById("confirm-password").value = "";
      document.getElementById("terms").checked = false;

      const strengthContainer = document.getElementById("password-strength");
      if (strengthContainer) strengthContainer.style.display = "none";

      console.log("Đăng ký thành công:", { fullname, email, phone });
    }
  } else if (pageType === "login") {
    if (validateForm()) {
      const email = document.getElementById("email").value;
      if (isLogin) {
        alert("Đăng nhập thành công!\nEmail: " + email);
      } else {
        const fullname = document.getElementById("fullname").value;
        alert("Đăng ký thành công!\nTên: " + fullname + "\nEmail: " + email);
      }
      clearForm();
    }
  }
}

// ==================== UTILITY FUNCTIONS ====================
function togglePassword(inputId) {
  const input = document.getElementById(inputId);
  if (input) {
    input.type = input.type === "password" ? "text" : "password";
  }
}

function clearErrors() {
  document.querySelectorAll(".error-message").forEach((el) => {
    el.style.display = "none";
    const span = el.querySelector("span");
    if (span) span.textContent = "";
  });
  document.querySelectorAll("input, select").forEach((input) => {
    input.classList.remove("error");
  });
}

function clearForm() {
  const inputs = ["fullname", "email", "password", "confirm-password", "phone"];
  inputs.forEach((id) => {
    const input = document.getElementById(id);
    if (input) input.value = "";
  });
}

function showError(inputId, message) {
  const input = document.getElementById(inputId);
  const errorEl = document.getElementById(inputId + "-error");

  if (input) input.classList.add("error");
  if (errorEl) {
    errorEl.style.display = "flex";
    const span = errorEl.querySelector("span");
    if (span) span.textContent = message;
  }
}

function goBack() {
  window.location.href = "../../views/auth/login.php";
}

function goToLogin() {
  window.location.href = "../../views/auth/login.php";
}

function handleEnterKey() {
  if (pageType === "login") {
    handleSubmit();
  } else if (pageType === "register") {
    handleSubmit();
  } else if (pageType === "forgot") {
    if (currentStep === 1) sendCode();
    else if (currentStep === 2) verifyCode();
    else if (currentStep === 3) resetPassword();
  }
}

// ==================== EXPOSE GLOBAL FUNCTIONS ====================
// Make functions available globally for onclick handlers in HTML
window.switchMode = switchMode;
window.handleSubmit = handleSubmit;
window.togglePassword = togglePassword;
window.socialLogin = socialLogin;
window.sendCode = sendCode;
window.verifyCode = verifyCode;
window.resetPassword = resetPassword;
window.resendCode = resendCode;
window.goToStep = goToStep;
window.goBack = goBack;
window.goToLogin = goToLogin;
