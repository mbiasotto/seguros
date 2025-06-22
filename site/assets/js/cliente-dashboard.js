$(document).ready(() => {
  // Update notification badge
  updateNotificationBadge()

  // Session timeout warning
  let sessionTimeout = setTimeout(
    () => {
      showSessionWarning()
    },
    25 * 60 * 1000,
  ) // 25 minutes

  // Reset session timeout on activity
  $(document).on("click keypress", () => {
    clearTimeout(sessionTimeout)
    sessionTimeout = setTimeout(
      () => {
        showSessionWarning()
      },
      25 * 60 * 1000,
    )
  })

  function updateNotificationBadge() {
    // Simulate checking for pending authorizations
    const pendingCount = 2
    if (pendingCount > 0) {
      $("#notificationBadge").text(pendingCount).show()
    } else {
      $("#notificationBadge").hide()
    }
  }

  function showSessionWarning() {
    const modal = $(`
            <div class="modal fade" id="sessionModal" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header border-0">
                            <h5 class="modal-title fw-bold">Sessão Expirando</h5>
                        </div>
                        <div class="modal-body text-center">
                            <i class="fas fa-clock text-warning fs-1 mb-3"></i>
                            <p>Sua sessão expirará em <span id="sessionCountdown" class="fw-bold">5:00</span></p>
                            <p class="text-muted">Clique em "Continuar" para manter-se logado</p>
                        </div>
                        <div class="modal-footer border-0">
                            <button type="button" class="btn btn-outline-secondary" onclick="logout()">Sair</button>
                            <button type="button" class="btn btn-warning" onclick="extendSession()">Continuar</button>
                        </div>
                    </div>
                </div>
            </div>
        `)

    $("body").append(modal)
    modal.modal("show")

    // Countdown
    let timeLeft = 300 // 5 minutes
    const countdown = setInterval(() => {
      timeLeft--
      const minutes = Math.floor(timeLeft / 60)
      const seconds = timeLeft % 60
      $("#sessionCountdown").text(`${minutes}:${seconds.toString().padStart(2, "0")}`)

      if (timeLeft <= 0) {
        clearInterval(countdown)
        logout()
      }
    }, 1000)

    window.extendSession = () => {
      clearInterval(countdown)
      modal.modal("hide")
      modal.remove()
      // Reset session timeout
      sessionTimeout = setTimeout(
        () => {
          showSessionWarning()
        },
        25 * 60 * 1000,
      )
    }
  }

  window.logout = () => {
    window.location.href = "login.html"
  }

  // Quick action animations
  $(".quick-action-card").on("mouseenter", function () {
    $(this).addClass("fade-in")
  })

  // Auto-refresh data every 30 seconds
  setInterval(() => {
    updateNotificationBadge()
    // Update balance and transactions here
  }, 30000)
})
