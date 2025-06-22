import { Chart } from "@/components/ui/chart"
$(document).ready(() => {
  // Set current date
  const now = new Date()
  const dateStr = now.toLocaleDateString("pt-BR", {
    weekday: "long",
    year: "numeric",
    month: "long",
    day: "numeric",
  })
  $("#currentDate").text(dateStr)

  // Initialize sales chart
  initSalesChart()

  // Auto-refresh data every 30 seconds
  setInterval(() => {
    refreshDashboardData()
  }, 30000)

  // Check for offline status
  window.addEventListener("online", () => {
    $(".offline-indicator").remove()
  })

  window.addEventListener("offline", () => {
    if (!$(".offline-indicator").length) {
      $("body").prepend(`
                <div class="offline-indicator">
                    <i class="fas fa-wifi me-2"></i>
                    Sem conexão com a internet - Funcionando offline
                </div>
            `)
    }
  })

  function initSalesChart() {
    const ctx = document.getElementById("salesChart").getContext("2d")
    new Chart(ctx, {
      type: "line",
      data: {
        labels: ["Seg", "Ter", "Qua", "Qui", "Sex", "Sáb", "Dom"],
        datasets: [
          {
            label: "Vendas (R$)",
            data: [1200, 1900, 3000, 2500, 2200, 3200, 2847],
            borderColor: "#ffd700",
            backgroundColor: "rgba(255, 215, 0, 0.1)",
            borderWidth: 3,
            fill: true,
            tension: 0.4,
          },
        ],
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            display: false,
          },
        },
        scales: {
          y: {
            beginAtZero: true,
            ticks: {
              callback: (value) => "R$ " + value.toLocaleString("pt-BR"),
            },
          },
        },
      },
    })
  }

  function refreshDashboardData() {
    // Simulate data refresh
    console.log("Refreshing dashboard data...")

    // Update summary cards with animation
    $(".summary-card").addClass("pulse")
    setTimeout(() => {
      $(".summary-card").removeClass("pulse")
    }, 1000)
  }

  // Keyboard shortcuts
  $(document).on("keydown", (e) => {
    // Ctrl + N for new transaction
    if (e.ctrlKey && e.key === "n") {
      e.preventDefault()
      window.location.href = "nova-venda.html"
    }

    // F5 for refresh (prevent default and use custom refresh)
    if (e.key === "F5") {
      e.preventDefault()
      refreshDashboardData()
    }
  })

  // Play notification sound for new transactions
  function playNotificationSound() {
    const audio = document.getElementById("notificationSound")
    if (audio) {
      audio.play().catch((e) => {
        console.log("Could not play notification sound:", e)
      })
    }

    // Show sound indicator
    if (!$(".sound-indicator").length) {
      $("body").append(`
                <div class="sound-indicator">
                    <i class="fas fa-volume-up me-2"></i>
                    Nova transação
                </div>
            `)
    }

    $(".sound-indicator").addClass("show")
    setTimeout(() => {
      $(".sound-indicator").removeClass("show")
    }, 3000)
  }

  // Simulate new transaction notification every 2 minutes
  setInterval(() => {
    if (Math.random() > 0.7) {
      // 30% chance
      playNotificationSound()
    }
  }, 120000)
})
