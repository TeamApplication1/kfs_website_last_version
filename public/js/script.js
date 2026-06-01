document.addEventListener("DOMContentLoaded", function () {
  const mobileMenuToggler = document.getElementById("mobileMenuToggler");
  const mobileMenuPanel = document.getElementById("mobileMenuPanel");
  const mobileMenuOverlay = document.getElementById("mobileMenuOverlay");
  const closeMobileMenu = document.getElementById("closeMobileMenu");
  const body = document.body;

  function openMenu() {
    if (mobileMenuPanel && mobileMenuOverlay) {
      mobileMenuPanel.classList.add("show");
      mobileMenuOverlay.classList.add("show");
      body.classList.add("body-no-scroll");
    }
  }

  function closeMenu() {
    if (mobileMenuPanel && mobileMenuOverlay) {
      mobileMenuPanel.classList.remove("show");
      mobileMenuOverlay.classList.remove("show");
      body.classList.remove("body-no-scroll");
    }
  }

  if (mobileMenuToggler) {
    mobileMenuToggler.addEventListener("click", openMenu);
  }
  if (closeMobileMenu) {
    closeMobileMenu.addEventListener("click", closeMenu);
  }
  if (mobileMenuOverlay) {
    mobileMenuOverlay.addEventListener("click", closeMenu);
  }

  // --- Mobile submenu dropdown toggle ---
  document.querySelectorAll(".mobile-dropdown-trigger").forEach(function (trigger) {
    trigger.addEventListener("click", function (e) {
      e.preventDefault();
      var submenu = this.nextElementSibling;
      if (submenu && submenu.classList.contains("mobile-submenu")) {
        submenu.classList.toggle("open");
        this.classList.toggle("open");
      }
    });
  });

  // --- Mobile bottom navbar: hide on scroll down, show on scroll up ---
  var lastScrollY = window.scrollY;
  var bottomNav = document.getElementById("mobileBottomNav");

  if (bottomNav && window.innerWidth < 992) {
    window.addEventListener("scroll", function () {
      var currentScrollY = window.scrollY;
      if (currentScrollY > lastScrollY && currentScrollY > 100) {
        bottomNav.classList.add("bottom-nav-hidden");
      } else {
        bottomNav.classList.remove("bottom-nav-hidden");
      }
      lastScrollY = currentScrollY;
    }, { passive: true });
  }

  // --- Function to update Date and Time ---
  function updateDateTime() {
    const now = new Date();
    const dateTimeContainer = document.getElementById("date-time-container");

    if (dateTimeContainer) {
      const gregorianOptions = {
        weekday: "long",
        year: "numeric",
        month: "long",
        day: "numeric",
      };
      const hijriOptions = {
        calendar: "islamic-civil",
        year: "numeric",
        month: "long",
        day: "numeric",
      };
      const timeOptions = {
        hour: "2-digit",
        minute: "2-digit",
        second: "2-digit",
        hour12: true,
      };

      const gregorianDate = new Intl.DateTimeFormat(
        "ar-EG",
        gregorianOptions
      ).format(now);
      const hijriDate = new Intl.DateTimeFormat(
        "ar-SA-u-ca-islamic-civil",
        hijriOptions
      ).format(now);
      const timeString = new Intl.DateTimeFormat("ar-EG", timeOptions).format(
        now
      );

      dateTimeContainer.innerHTML = `
                <span><b class="highlight">${gregorianDate}</b> | ${hijriDate}</span>
                <span class="mx-2">|</span>
                <span>${timeString}</span>
            `;
    }
  }

  function updateCopyrightYear() {
    const yearSpan = document.getElementById("copyright-year");
    if (yearSpan) {
      yearSpan.textContent = new Date().getFullYear();
    }
  }

  updateDateTime();
  setInterval(updateDateTime, 1000);
  updateCopyrightYear();
});
