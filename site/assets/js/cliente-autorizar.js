$(document).ready(() => {
  let currentTransaction = null
  let countdownInterval = null

  window.authorizeTransaction = (transactionId) => {
    // Get transaction data (simulate)
    const transactions = {
      1: { store: "Supermercado Família", amount: "R$ 156,80" },
      2: { store: "Farmácia Popular", amount: "R$ 67,50" },
    }

    currentTransaction = transactionId
    const transaction = transactions[transactionId]

    $("#modalStoreName").text(transaction.store)
    $("#modalAmount").text(transaction.amount)
    $("#pinInput").val("")

    $("#authorizationModal").modal("show")
  }

  window.rejectTransaction = (transactionId) => {
    if (confirm("Tem certeza que deseja recusar esta transação?")) {
      // Simulate rejection
      showToast("Transação recusada com sucesso", "success")
      // Remove from pending list
      $(`[onclick="rejectTransaction(${transactionId})"]`).closest(".list-group-item").fadeOut()
    }
  }

  window.confirmAuthorization = () => {
    const pin = $("#pinInput").val()

    if (pin.length !== 4) {
      showToast("Digite uma senha de 4 dígitos", "error")
      return
    }

    // Show loading
    const btn = $('[onclick="confirmAuthorization()"]')
    const originalText = btn.html()
    btn.html('<i class="fas fa-spinner fa-spin me-2"></i>Processando...').prop("disabled", true)

    setTimeout(() => {
      btn.html(originalText).prop("disabled", false)
      $("#authorizationModal").modal("hide")

      // Generate authorization code
      const code = Math.floor(100000 + Math.random() * 900000)
      $("#authorizationCode").text(code)

      // Start countdown
      startCountdown()

      $("#codeModal").modal("show")

      // Remove from pending list
      $(`[onclick="authorizeTransaction(${currentTransaction})"]`).closest(".list-group-item").fadeOut()

      showToast("Compra autorizada com sucesso!", "success")
    }, 2000)
  }

  function startCountdown() {
    let timeLeft = 300 // 5 minutes
    countdownInterval = setInterval(() => {
      timeLeft--
      const minutes = Math.floor(timeLeft / 60)
      const seconds = timeLeft % 60
      $("#countdown").text(`${minutes.toString().padStart(2, "0")}:${seconds.toString().padStart(2, "0")}`)

      if (timeLeft <= 0) {
        clearInterval(countdownInterval)
        $("#codeModal").modal("hide")
        showToast("Código expirado", "error")
      }
    }, 1000)
  }

  window.copyCode = () => {
    const code = $("#authorizationCode").text()
    navigator.clipboard.writeText(code).then(() => {
      showToast("Código copiado!", "success")
    })
  }

  window.sendWhatsApp = () => {
    const code = $("#authorizationCode").text()
    const message = `Código de autorização Multiplic: ${code}`
    const url = `https://wa.me/?text=${encodeURIComponent(message)}`
    window.open(url, "_blank")
  }

  // PIN input formatting
  $("#pinInput").on("input", function () {
    let value = $(this).val().replace(/\D/g, "")
    if (value.length > 4) value = value.slice(0, 4)
    $(this).val(value)
  })

  // Clear countdown on modal close
  $("#codeModal").on("hidden.bs.modal", () => {
    if (countdownInterval) {
      clearInterval(countdownInterval)
    }
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

    if (!$("#toastContainer").length) {
      $("body").append('<div id="toastContainer" class="position-fixed top-0 end-0 p-3" style="z-index: 9999;"></div>')
    }

    $("#toastContainer").append(toast)
    toast.toast({ delay: 3000 }).toast("show")

    toast.on("hidden.bs.toast", function () {
      $(this).remove()
    })
  }
})
