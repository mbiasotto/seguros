$(document).ready(() => {
  let currentStep = 1
  const totalSteps = 2

  // Form validation
  function validateStep(step) {
    let isValid = true
    const requiredFields = $(`#step${step} [required]`)

    requiredFields.each(function () {
      const $field = $(this)
      const value = $field.val().trim()

      if (!value) {
        $field.addClass("is-invalid")
        isValid = false
      } else {
        $field.removeClass("is-invalid")
      }
    })

    return isValid
  }

  // Update progress
  function updateProgress() {
    const progress = (currentStep / totalSteps) * 100
    $("#progressBar").css("width", progress + "%")

    // Update step indicators
    if (currentStep >= 2) {
      $("#step2Dot").addClass("active")
      $("#step2Text").removeClass("text-muted").addClass("fw-medium")
    } else {
      $("#step2Dot").removeClass("active")
      $("#step2Text").addClass("text-muted").removeClass("fw-medium")
    }

    // Update titles
    if (currentStep === 1) {
      $("#formTitle").text("Abra sua conta")
      $("#formSubtitle").text("Começa aqui, leva poucos minutos")
    } else {
      $("#formTitle").text("Finalize seu cadastro")
      $("#formSubtitle").text("Últimos dados para liberar seu cartão")
    }
  }

  // Show/hide steps
  function showStep(step) {
    $(".form-step").addClass("d-none")
    $(`#step${step}`).removeClass("d-none")

    // Update buttons
    if (step === 1) {
      $("#backBtn").addClass("d-none")
      $("#nextBtn").html('Continuar <i class="fas fa-arrow-right ms-2"></i>')
    } else {
      $("#backBtn").removeClass("d-none")
      $("#nextBtn").html('<i class="fas fa-check me-2"></i>Finalizar Cadastro')
    }

    updateProgress()
  }

  // Next button click
  $("#nextBtn").on("click", function (e) {
    e.preventDefault()

    if (currentStep === 1) {
      if (validateStep(1)) {
        currentStep = 2
        showStep(2)
      }
    } else {
      if (validateStep(2)) {
        // Submit form to Laravel
        $("#cadastroForm").attr("action", "/cadastro").attr("method", "POST").off("submit").submit()
      }
    }
  })

  // Form submission (for final step)
  $("#cadastroForm").on("submit", function (e) {
    // Allow form to submit naturally on final step
    if (currentStep < 2) {
      e.preventDefault()
    }
  })

  // Back button
  $("#backBtn").on("click", () => {
    if (currentStep > 1) {
      currentStep = 1
      showStep(1)
    }
  })

  // Password toggle
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

  // Input masks
  $('input[name="cpf"]').on("input", function () {
    let value = $(this).val().replace(/\D/g, "")
    value = value.replace(/(\d{3})(\d)/, "$1.$2")
    value = value.replace(/(\d{3})(\d)/, "$1.$2")
    value = value.replace(/(\d{3})(\d{1,2})$/, "$1-$2")
    $(this).val(value)
  })

  $('input[name="phone"]').on("input", function () {
    let value = $(this).val().replace(/\D/g, "")
    value = value.replace(/(\d{2})(\d)/, "($1) $2")
    value = value.replace(/(\d{5})(\d)/, "$1-$2")
    $(this).val(value)
  })

  $('input[name="cep"]').on("input", function () {
    let value = $(this).val().replace(/\D/g, "")
    value = value.replace(/(\d{5})(\d)/, "$1-$2")
    $(this).val(value)
  })

  // CEP lookup
  $('input[name="cep"]').on("blur", function () {
    const cep = $(this).val().replace(/\D/g, "")

    if (cep.length === 8) {
      $.getJSON(`https://viacep.com.br/ws/${cep}/json/`, (data) => {
        if (!data.erro) {
          $('input[name="address"]').val(data.logradouro)
          $('input[name="neighborhood"]').val(data.bairro)
          $('input[name="city"]').val(data.localidade)
          $('select[name="state"]').val(data.uf)
        }
      }).fail(() => {
        console.log("Erro ao buscar CEP")
      })
    }
  })

  // Remove validation classes on input
  $("input, select").on("input change", function () {
    $(this).removeClass("is-invalid")
  })

  // Initialize
  showStep(1)
})
