$(document).ready(() => {
  // CNPJ Mask
  $("#cnpjInput").on("input", function () {
    let value = $(this).val().replace(/\D/g, "")

    // Check if it's email format
    if ($(this).val().includes("@")) {
      return // Don't apply mask for email
    }

    // Apply CNPJ mask
    value = value.replace(/(\d{2})(\d)/, "$1.$2")
    value = value.replace(/(\d{3})(\d)/, "$1.$2")
    value = value.replace(/(\d{3})(\d)/, "$1/$2")
    value = value.replace(/(\d{4})(\d{1,2})$/, "$1-$2")
    $(this).val(value)
  })

  // Password Toggle
  $("#posTogglePassword").on("click", () => {
    const passwordInput = $("#posPasswordInput")
    const passwordIcon = $("#posPasswordIcon")

    if (passwordInput.attr("type") === "password") {
      passwordInput.attr("type", "text")
      passwordIcon.removeClass("fa-eye").addClass("fa-eye-slash")
    } else {
      passwordInput.attr("type", "password")
      passwordIcon.removeClass("fa-eye-slash").addClass("fa-eye")
    }
  })

  // Login Form
  $("#posLoginForm").on("submit", function (e) {
    e.preventDefault()

    const cnpjEmail = $("#cnpjInput").val()
    const password = $("#posPasswordInput").val()

    if (!cnpjEmail || !password) {
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
      if (cnpjEmail === "12.345.678/0001-90" || cnpjEmail === "admin@supermercado.com") {
        showToast("Login realizado com sucesso!", "success")
        setTimeout(() => {
          window.location.href = "dashboard.html"
        }, 1000)
      } else {
        showToast("CNPJ/Email ou senha incorretos", "error")
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
