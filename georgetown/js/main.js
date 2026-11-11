/* Georgetown UAE — light interactions */

(function () {
  "use strict";

  // Close mobile nav after clicking a link
  var navCollapse = document.getElementById("mainNav");
  if (navCollapse) {
    navCollapse.querySelectorAll(".nav-link, .dropdown-item, .btn-book").forEach(function (el) {
      el.addEventListener("click", function () {
        if (window.bootstrap && window.innerWidth < 992) {
          var instance = bootstrap.Collapse.getInstance(navCollapse);
          if (instance) instance.hide();
        }
      });
    });
  }

  // Smooth scroll for same-page anchors (respect reduced motion)
  var prefersReduced = window.matchMedia("(prefers-reduced-motion: reduce)").matches;
  document.querySelectorAll('a[href^="#"]').forEach(function (anchor) {
    anchor.addEventListener("click", function (e) {
      var id = anchor.getAttribute("href");
      if (!id || id === "#") return;
      var target = document.querySelector(id);
      if (!target) return;
      e.preventDefault();
      target.scrollIntoView({ behavior: prefersReduced ? "auto" : "smooth", block: "start" });
    });
  });
})();
