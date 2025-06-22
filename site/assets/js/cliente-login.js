$(document).ready(() => {
  // CPF Mask
  $("#cpfInput").on("input", function () {
    let value = $(this).val().replace(/\D/g, "")
    value = value.replace(/(\d{3})(\d)/, "$1.$2")
    value = value.replace(/(\d{3})(\d)/, "$1.$2")
    value = value.replace(/(\d{3})(\d{1,2})$/, "$1-$2")
    $(this).val(value)
  })

  // Password Toggle
  $("#togglePassword").on("click", () => {
    const passwordInput = $("#passwordInput")
    const passwordIcon = $("#passwordIcon")

    if (passwordInput.attr("type") === "password") {
      passwordInput.attr("type", "text")
      passwordIcon.removeClass("fa-eye").addClass("fa-eye-slash")
    } else {
      passwordInput.attr("type", "password")
      passwordIcon.removeClass("fa-eye-slash").addClass("fa-eye")
    }
  })

  // Login Form
  $("#loginForm").on("submit", function (e) {
    e.preventDefault()

    const cpf = $("#cpfInput").val()
    const password = $("#passwordInput").val()

    if (!cpf || !password) {
      showToast("Por favor, preencha todos os campos", "error")
      return
    }

    // Show loading
    const submitBtn = $(this).find('button[type="submit"]')
    const originalText = submitBtn.html()
    submitBtn.html('<i class="fas fa-spinner fa-spin me-2"></i>Entrando...').prop("disabled", true)

    // Simulate login
    setTimeout(() => {
      // Reset button
      submitBtn.html(originalText).prop("disabled", false)

      // Simulate successful login
      if (cpf === "123.456.789-00" && password === "123456") {
        showToast("Login realizado com sucesso!", "success")
        setTimeout(() => {
          window.location.href = "dashboard.html"
        }, 1000)
      } else {
        showToast("CPF ou senha incorretos", "error")
      }
    }, 2000)
  })

  function showToast(message, type) {
    const toastClass = type === "success" ? "toast-success" : "toast-error"
    const icon = type === "success" ? "fa-check-circle" : "fa-exclamation-circle"

    const toast = $(`
            <div class="toast ${toastClass}" role="alert">
                <div class="toast-body d-flex align-items-center">
                    <i class="fas ${icon} me-2"></i>
                    ${message}
                </div>
            </div>
        `)

    // Add to page
    if (!$("#toastContainer").length) {
      $("body").append('<div id="toastContainer" class="position-fixed top-0 end-0 p-3" style="z-index: 9999;"></div>')
    }

    $("#toastContainer").append(toast)
    toast.toast({ delay: 3000 }).toast("show")

    // Remove after hide
    toast.on("hidden.bs.toast", function () {
      $(this).remove()
    })
  }
})
