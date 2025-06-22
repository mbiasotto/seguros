$(document).ready(() => {
  let currentStep = 1
  let currentAmount = 0
  let customerData = null
  let transactionData = {}

  // Initialize
  showStep(1)

  // CPF Mask
  $("#customerCpf").on("input", function () {
    let value = $(this).val().replace(/\D/g, "")
    value = value.replace(/(\d{3})(\d)/, "$1.$2")
    value = value.replace(/(\d{3})(\d)/, "$1.$2")
    value = value.replace(/(\d{3})(\d{1,2})$/, "$1-$2")
    $(this).val(value)
  })

  // Authorization code mask
  $("#authCode").on("input", function () {
    let value = $(this).val().replace(/\D/g, "")
    if (value.length > 6) value = value.slice(0, 6)
    $(this).val(value)
  })

  window.verifyCustomer = () => {
    const cpf = $("#customerCpf").val()

    if (!cpf || cpf.length < 14) {
      showToast("Digite um CPF válido", "error")
      return
    }

    // Show loading
    const btn = $('[onclick="verifyCustomer()"]')
    const originalText = btn.html()
    btn.html('<i class="fas fa-spinner fa-spin me-2"></i>Verificando...').prop("disabled", true)

    setTimeout(() => {
      btn.html(originalText).prop("disabled", false)

      // Simulate customer verification
      customerData = {
        name: "João Silva",
        cpf: cpf,
        status: "active",
      }

      $("#customerName").text(customerData.name)
      $("#customerInfo").removeClass("d-none")

      setTimeout(() => {
        nextStep()
      }, 1500)
    }, 2000)
  }

  window.addDigit = (digit) => {
    if (currentAmount === 0 && digit === "0") return

    const currentStr = currentAmount.toString()
    const newAmount = Number.parseInt(currentStr + digit)

    if (newAmount > 999999) return // Max R$ 9.999,99

    currentAmount = newAmount
    updateAmountDisplay()
  }

  window.clearAmount = () => {
    if (currentAmount > 0) {
      const currentStr = currentAmount.toString()
      currentAmount = Number.parseInt(currentStr.slice(0, -1)) || 0
      updateAmountDisplay()
    }
  }

  function updateAmountDisplay() {
    const formatted = (currentAmount / 100).toLocaleString("pt-BR", {
      style: "currency",
      currency: "BRL",
    })
    $("#amountDisplay").text(formatted)
  }

  window.confirmAmount = () => {
    if (currentAmount === 0) {
      showToast("Digite um valor válido", "error")
      return
    }

    transactionData.amount = currentAmount / 100
    transactionData.customer = customerData

    // Update summary
    $("#summaryCustomer").text(customerData.name)
    $("#summaryAmount").text(
      (currentAmount / 100).toLocaleString("pt-BR", {
        style: "currency",
        currency: "BRL",
      }),
    )

    nextStep()
  }

  window.sendAuthorization = () => {
    // Show loading
    const btn = $('[onclick="sendAuthorization()"]')
    const originalText = btn.html()
    btn.html('<i class="fas fa-spinner fa-spin me-2"></i>Enviando...').prop("disabled", true)

    setTimeout(() => {
      btn.html(originalText).prop("disabled", false)
      nextStep()

      // Start waiting for customer
      startWaitingForCustomer()
    }, 2000)
  }

  function startWaitingForCustomer() {
    // Simulate waiting time
    setTimeout(() => {
      $("#loadingSpinner").hide()
      $("#waitingTitle").text("Digite o Código")
      $("#waitingText").text("Solicite o código de 6 dígitos ao cliente")
      $("#codeInputSection").show()
      $("#validateCodeBtn").show()

      // Start countdown
      startCodeCountdown()
    }, 3000)
  }

  function startCodeCountdown() {
    let timeLeft = 300 // 5 minutes
    const countdown = setInterval(() => {
      timeLeft--
      const minutes = Math.floor(timeLeft / 60)
      const seconds = timeLeft % 60
      $("#codeCountdown").text(`${minutes.toString().padStart(2, "0")}:${seconds.toString().padStart(2, "0")}`)

      if (timeLeft <= 0) {
        clearInterval(countdown)
        showToast("Código expirado", "error")
        // Reset to step 3
        currentStep = 2
        nextStep()
      }
    }, 1000)

    // Store interval for cleanup
    window.codeCountdownInterval = countdown
  }

  window.validateCode = () => {
    const code = $("#authCode").val()

    if (code.length !== 6) {
      showToast("Digite um código de 6 dígitos", "error")
      return
    }

    // Show loading
    const btn = $("#validateCodeBtn")
    const originalText = btn.html()
    btn.html('<i class="fas fa-spinner fa-spin me-2"></i>Validando...').prop("disabled", true)

    setTimeout(() => {
      btn.html(originalText).prop("disabled", false)

      // Clear countdown
      if (window.codeCountdownInterval) {
        clearInterval(window.codeCountdownInterval)
      }

      // Generate transaction ID
      transactionData.id = "#" + Math.floor(100000 + Math.random() * 900000)
      transactionData.timestamp = new Date()

      // Update final step
      $("#transactionId").text(transactionData.id)
      $("#finalAmount").text(
        transactionData.amount.toLocaleString("pt-BR", {
          style: "currency",
          currency: "BRL",
        }),
      )
      $("#transactionTime").text(
        transactionData.timestamp.toLocaleString("pt-BR", {
          day: "2-digit",
          month: "2-digit",
          year: "numeric",
          hour: "2-digit",
          minute: "2-digit",
        }),
      )

      nextStep()
      showToast("Transação aprovada com sucesso!", "success")
    }, 2000)
  }

  window.printReceipt = () => {
    // Generate receipt content
    const receiptContent = `
            <div style="font-family: monospace; width: 300px; margin: 0 auto;">
                <div style="text-align: center; border-bottom: 1px dashed #000; padding-bottom: 10px; margin-bottom: 10px;">
                    <h3>MULTIPLIC.CC</h3>
                    <p>Supermercado Família</p>
                </div>
                <div style="margin-bottom: 10px;">
                    <p><strong>ID:</strong> ${transactionData.id}</p>
                    <p><strong>Data:</strong> ${transactionData.timestamp.toLocaleString("pt-BR")}</p>
                    <p><strong>Cliente:</strong> ${customerData.name}</p>
                    <p><strong>CPF:</strong> ${customerData.cpf}</p>
                </div>
                <div style="border-top: 1px dashed #000; padding-top: 10px; text-align: center;">
                    <h4>VALOR: ${transactionData.amount.toLocaleString("pt-BR", { style: "currency", currency: "BRL" })}</h4>
                </div>
                <div style="text-align: center; margin-top: 20px; font-size: 12px;">
                    <p>Obrigado pela preferência!</p>
                </div>
            </div>
        `

    // Open print window
    const printWindow = window.open("", "_blank")
    printWindow.document.write(`
            <html>
                <head><title>Comprovante</title></head>
                <body onload="window.print(); window.close();">
                    ${receiptContent}
                </body>
            </html>
        `)
    printWindow.document.close()
  }

  window.newTransaction = () => {
    // Reset all data
    currentStep = 1
    currentAmount = 0
    customerData = null
    transactionData = {}

    // Reset form
    $("#customerCpf").val("")
    $("#customerInfo").addClass("d-none")
    $("#authCode").val("")
    updateAmountDisplay()

    // Clear any intervals
    if (window.codeCountdownInterval) {
      clearInterval(window.codeCountdownInterval)
    }

    showStep(1)
  }

  function nextStep() {
    if (currentStep < 5) {
      currentStep++
      showStep(currentStep)
    }
  }

  function showStep(step) {
    // Hide all steps
    $(".transaction-step").addClass("d-none")

    // Show current step
    $(`#stepContent${step}`).removeClass("d-none").addClass("fade-in")

    // Update progress indicators
    $(".step").removeClass("active completed")

    for (let i = 1; i <= 5; i++) {
      if (i < step) {
        $(`#step${i}`).addClass("completed")
      } else if (i === step) {
        $(`#step${i}`).addClass("active")
      }
    }
  }

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

    if (!$("#toastContainer").length) {
      $("body").append('<div id="toastContainer" class="position-fixed top-0 end-0 p-3" style="z-index: 9999;"></div>')
    }

    $("#toastContainer").append(toast)
    toast.toast({ delay: 3000 }).toast("show")

    toast.on("hidden.bs.toast", function () {
      $(this).remove()
    })
  }

  // Keyboard shortcuts
  $(document).on("keydown", (e) => {
    // ESC to go back
    if (e.key === "Escape" && currentStep > 1) {
      currentStep--
      showStep(currentStep)
    }

    // Enter to proceed (context-dependent)
    if (e.key === "Enter") {
      if (currentStep === 1 && $("#customerCpf").val()) {
        window.verifyCustomer()
      } else if (currentStep === 2 && currentAmount > 0) {
        window.confirmAmount()
      } else if (currentStep === 3) {
        window.sendAuthorization()
      } else if (currentStep === 4 && $("#authCode").val().length === 6) {
        window.validateCode()
      }
    }
  })
})
