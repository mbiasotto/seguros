$(document).ready(() => {
  // Navbar scroll effect with throttling
  let ticking = false;
  
  function updateNavbar() {
    if ($(window).scrollTop() > 100) {
      $("#mainNavbar").addClass("scrolled");
    } else {
      $("#mainNavbar").removeClass("scrolled");
    }
    ticking = false;
  }

  $(window).scroll(() => {
    if (!ticking) {
      requestAnimationFrame(updateNavbar);
      ticking = true;
    }
  });

  // Smooth scrolling for anchor links with easing
  $('a[href^="#"]').on("click", function (event) {
    var target = $(this.getAttribute("href"));
    if (target.length) {
      event.preventDefault();
      $("html, body").stop().animate(
        {
          scrollTop: target.offset().top - 80,
        },
        1200,
        "easeInOutCubic"
      );
    }
  });

  // Custom easing function
  $.easing.easeInOutCubic = function (x, t, b, c, d) {
    if ((t /= d / 2) < 1) return (c / 2) * t * t * t + b;
    return (c / 2) * ((t -= 2) * t * t + 2) + b;
  };

  // Intersection Observer for scroll animations
  const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -100px 0px'
  };

  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('visible');
      }
    });
  }, observerOptions);

  // Observe elements for scroll animations
  document.querySelectorAll('.fade-in-on-scroll, .slide-in-left, .slide-in-right').forEach(el => {
    observer.observe(el);
  });

  // Parallax effect for hero section
  $(window).scroll(() => {
    const scrolled = $(window).scrollTop();
    const parallax = $('.hero-bg');
    const speed = 0.5;
    
    if (parallax.length) {
      parallax.css('transform', `translateY(${scrolled * speed}px)`);
    }
  });

  // Enhanced card hover effects
  $('.card').on('mouseenter', function() {
    $(this).addClass('card-hover');
  }).on('mouseleave', function() {
    $(this).removeClass('card-hover');
  });

  // Statistics counter animation
  function animateCounters() {
    $('.stats-section .fs-3').each(function() {
      const $this = $(this);
      const countTo = parseInt($this.text().replace(/\D/g, ''));
      const suffix = $this.text().replace(/\d/g, '');
      
      $({ countNum: 0 }).animate({
        countNum: countTo
      }, {
        duration: 2000,
        easing: 'easeInOutCubic',
        step: function() {
          $this.text(Math.floor(this.countNum) + suffix);
        },
        complete: function() {
          $this.text(countTo + suffix);
        }
      });
    });
  }

  // Trigger counter animation when stats section is visible
  const statsObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        animateCounters();
        statsObserver.unobserve(entry.target);
      }
    });
  }, { threshold: 0.5 });

  const statsSection = document.querySelector('.stats-section');
  if (statsSection) {
    statsObserver.observe(statsSection);
  }

  // Enhanced loading states
  function showLoading(element) {
    element.addClass('loading').prop('disabled', true);
    const originalText = element.text();
    element.data('original-text', originalText);
    element.html('<i class="fas fa-spinner fa-spin me-2"></i>Carregando...');
  }

  function hideLoading(element) {
    element.removeClass('loading').prop('disabled', false);
    element.text(element.data('original-text'));
  }

  // Form validation with modern UX
  $('form').on('submit', function(e) {
    e.preventDefault();
    const form = $(this);
    const submitBtn = form.find('button[type="submit"]');
    
    showLoading(submitBtn);
    
    // Simulate form processing
    setTimeout(() => {
      hideLoading(submitBtn);
      // Add success animation or redirect
    }, 2000);
  });

  // Establishments data with enhanced features
  const establishments = {
    "São Paulo": [
      {
        name: "Supermercado Bom Preço",
        category: "Supermercados",
        address: "Av. Paulista, 1000",
        discount: "5% de desconto",
        icon: "🛒",
        rating: 4.5,
        distance: "1.2 km"
      },
      {
        name: "Farmácia Saúde",
        category: "Farmácias",
        address: "Rua Augusta, 500",
        discount: "10% de desconto",
        icon: "💊",
        rating: 4.8,
        distance: "0.8 km"
      },
      {
        name: "Posto Shell Centro",
        category: "Postos",
        address: "Av. São João, 200",
        discount: "R$ 0,10 por litro",
        icon: "⛽",
        rating: 4.3,
        distance: "2.1 km"
      },
      {
        name: "Restaurante Sabor",
        category: "Restaurantes",
        address: "Rua da Consolação, 800",
        discount: "15% de desconto",
        icon: "🍽️",
        rating: 4.7,
        distance: "1.5 km"
      },
      {
        name: "Loja Fashion Style",
        category: "Lojas",
        address: "Shopping Paulista, Loja 201",
        discount: "20% de desconto",
        icon: "🛍️",
        rating: 4.4,
        distance: "1.8 km"
      },
    ],
    Campinas: [
      {
        name: "Supermercado Família",
        category: "Supermercados",
        address: "Av. das Amoreiras, 300",
        discount: "8% de desconto",
        icon: "🛒",
        rating: 4.6,
        distance: "0.9 km"
      },
      {
        name: "Farmácia Popular",
        category: "Farmácias",
        address: "Rua Barão de Jaguara, 150",
        discount: "12% de desconto",
        icon: "💊",
        rating: 4.5,
        distance: "1.3 km"
      },
      {
        name: "Auto Posto Campinas",
        category: "Postos",
        address: "Av. Norte Sul, 400",
        discount: "R$ 0,15 por litro",
        icon: "⛽",
        rating: 4.2,
        distance: "2.5 km"
      },
    ],
    "Ribeirão Preto": [
      {
        name: "Mercado Central",
        category: "Supermercados",
        address: "Av. Independência, 600",
        discount: "6% de desconto",
        icon: "🛒",
        rating: 4.4,
        distance: "1.1 km"
      },
      {
        name: "Drogaria Ribeirão",
        category: "Farmácias",
        address: "Rua Álvares Cabral, 250",
        discount: "15% de desconto",
        icon: "💊",
        rating: 4.7,
        distance: "0.7 km"
      },
    ],
    Sorocaba: [
      {
        name: "Supermercado União",
        category: "Supermercados",
        address: "Rua Sorocaba, 100",
        discount: "7% de desconto",
        icon: "🛒",
        rating: 4.3,
        distance: "1.6 km"
      },
      {
        name: "Posto Sorocaba",
        category: "Postos",
        address: "Av. Dom Aguirre, 300",
        discount: "R$ 0,12 por litro",
        icon: "⛽",
        rating: 4.1,
        distance: "2.0 km"
      },
    ],
    Santos: [
      {
        name: "Mercado da Praia",
        category: "Supermercados",
        address: "Av. Ana Costa, 200",
        discount: "10% de desconto",
        icon: "🛒",
        rating: 4.8,
        distance: "0.5 km"
      },
      {
        name: "Farmácia Santos",
        category: "Farmácias",
        address: "Rua XV de Novembro, 150",
        discount: "8% de desconto",
        icon: "💊",
        rating: 4.6,
        distance: "1.0 km"
      },
    ],
  };

  let selectedCity = "São Paulo";
  let selectedCategory = "Todos";
  let searchTerm = "";

  // Initialize establishments
  renderEstablishments();

  // City selector with improved animations
  $(".city-btn").on("click", function () {
    const $this = $(this);
    if ($this.hasClass('active')) return;
    
    $(".city-btn").removeClass("active").addClass("btn-outline-dark").removeClass("btn-dark");
    $this.addClass("active").removeClass("btn-outline-dark").addClass("btn-dark");
    selectedCity = $this.data("city");
    
    // Add loading animation
    $("#establishmentsGrid").fadeOut(200, () => {
      renderEstablishments();
      $("#establishmentsGrid").fadeIn(300);
    });
  });

  // Category filter with improved animations
  $(".category-btn").on("click", function () {
    const $this = $(this);
    if ($this.hasClass('active')) return;
    
    $(".category-btn").removeClass("active").addClass("btn-outline-warning").removeClass("btn-warning");
    $this.addClass("active").removeClass("btn-outline-warning").addClass("btn-warning");
    selectedCategory = $this.data("category");
    
    // Add loading animation
    $("#establishmentsGrid").fadeOut(200, () => {
      renderEstablishments();
      $("#establishmentsGrid").fadeIn(300);
    });
  });

  // Enhanced search functionality with debouncing
  let searchTimeout;
  $("#searchInput").on("input", function () {
    clearTimeout(searchTimeout);
    searchTerm = $(this).val().toLowerCase();
    
    searchTimeout = setTimeout(() => {
      $("#establishmentsGrid").fadeOut(200, () => {
        renderEstablishments();
        $("#establishmentsGrid").fadeIn(300);
      });
    }, 300);
  });

  // Enhanced render function with better cards
  function renderEstablishments() {
    const cityEstablishments = establishments[selectedCity] || [];
    const filteredEstablishments = cityEstablishments.filter((est) => {
      const matchesCategory = selectedCategory === "Todos" || est.category === selectedCategory;
      const matchesSearch = est.name.toLowerCase().includes(searchTerm) || 
                           est.category.toLowerCase().includes(searchTerm);
      return matchesCategory && matchesSearch;
    });

    const grid = $("#establishmentsGrid");
    grid.empty();

    if (filteredEstablishments.length === 0) {
      grid.append(`
        <div class="col-12 text-center py-5">
          <div class="fade-in-on-scroll">
            <i class="fas fa-search fs-1 text-muted mb-3"></i>
            <h5 class="text-muted">Nenhum estabelecimento encontrado</h5>
            <p class="text-muted">Tente ajustar os filtros ou termo de busca</p>
          </div>
        </div>
      `);
      return;
    }

    filteredEstablishments.forEach((est, index) => {
      const stars = generateStars(est.rating);
      const card = `
        <div class="col-lg-4 col-md-6 mb-4 fade-in-on-scroll" style="animation-delay: ${index * 0.1}s">
          <div class="card h-100 establishment-card border-0 shadow-sm">
            <div class="card-body p-4">
              <div class="d-flex justify-content-between align-items-start mb-3">
                <div class="flex-grow-1">
                  <h5 class="card-title fw-bold mb-1">${est.name}</h5>
                  <p class="card-text small text-muted mb-2">${est.category}</p>
                  <div class="d-flex align-items-center mb-2">
                    <div class="stars me-2">${stars}</div>
                    <span class="small text-muted">(${est.rating})</span>
                  </div>
                </div>
                <span class="fs-4">${est.icon}</span>
              </div>
              
              <div class="d-flex align-items-center text-muted mb-2">
                <i class="fas fa-map-marker-alt me-2 text-primary"></i>
                <span class="small">${est.address}</span>
              </div>
              
              <div class="d-flex align-items-center text-muted mb-3">
                <i class="fas fa-route me-2 text-info"></i>
                <span class="small">${est.distance}</span>
              </div>
              
              <div class="bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill small fw-medium mb-3 text-center">
                <i class="fas fa-tag me-1"></i>${est.discount}
              </div>
              
              <div class="d-grid gap-2">
                <button class="btn btn-warning text-dark fw-bold">
                  <i class="fas fa-map-marked-alt me-2"></i>Ver no mapa
                </button>
                <button class="btn btn-outline-primary btn-sm">
                  <i class="fas fa-info-circle me-2"></i>Mais informações
                </button>
              </div>
            </div>
          </div>
        </div>
      `;
      grid.append(card);
    });

    // Re-observe new elements
    document.querySelectorAll('.fade-in-on-scroll:not(.visible)').forEach(el => {
      observer.observe(el);
    });
  }

  // Generate star rating
  function generateStars(rating) {
    const fullStars = Math.floor(rating);
    const hasHalfStar = rating % 1 !== 0;
    let stars = '';
    
    for (let i = 0; i < fullStars; i++) {
      stars += '<i class="fas fa-star text-warning"></i>';
    }
    
    if (hasHalfStar) {
      stars += '<i class="fas fa-star-half-alt text-warning"></i>';
    }
    
    const emptyStars = 5 - Math.ceil(rating);
    for (let i = 0; i < emptyStars; i++) {
      stars += '<i class="far fa-star text-warning"></i>';
    }
    
    return stars;
  }

  // Enhanced button interactions
  $(document).on('click', '.btn:not(.no-loading)', function() {
    const $btn = $(this);
    
    // Add ripple effect
    const ripple = $('<span class="ripple"></span>');
    $btn.append(ripple);
    
    setTimeout(() => {
      ripple.remove();
    }, 600);
    
    // Add loading state for certain buttons
    if ($btn.hasClass('btn-warning') || $btn.hasClass('btn-primary')) {
      showLoading($btn);
      setTimeout(() => hideLoading($btn), 1500);
    }
  });

  // Smooth reveal animations for page load
  setTimeout(() => {
    $('.hero-content').addClass('slide-in-left');
    $('.credit-card-3d').addClass('slide-in-right');
  }, 500);

  // Enhanced scroll to top functionality - CORREÇÃO PROBLEMA 1
  const scrollToTopBtn = $('<button class="btn btn-warning position-fixed shadow-lg scroll-to-top-btn" style="z-index: 1000; display: none;"><i class="fas fa-arrow-up"></i></button>');
  $('body').append(scrollToTopBtn);

  $(window).scroll(() => {
    if ($(window).scrollTop() > 500) {
      scrollToTopBtn.fadeIn();
    } else {
      scrollToTopBtn.fadeOut();
    }
  });

  scrollToTopBtn.on('click', () => {
    $('html, body').animate({ scrollTop: 0 }, 800, 'easeInOutCubic');
  });

  // Enhanced accordion animations
  $('.accordion-button').on('click', function() {
    const $this = $(this);
    setTimeout(() => {
      if (!$this.hasClass('collapsed')) {
        $this.closest('.accordion-item').addClass('active');
      } else {
        $this.closest('.accordion-item').removeClass('active');
      }
    }, 150);
  });

  // Preloader (if needed)
  function hidePreloader() {
    const preloader = $('.preloader');
    if (preloader.length) {
      preloader.fadeOut(500, () => {
        preloader.remove();
      });
    }
  }

  // Initialize everything
  setTimeout(hidePreloader, 1000);
  
  // Add performance monitoring
  console.log('Site loaded successfully with enhanced features');
});
