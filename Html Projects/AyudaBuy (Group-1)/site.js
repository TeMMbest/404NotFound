(function () {
  "use strict";

  function ready(fn) {
    if (document.readyState != "loading") return fn();
    document.addEventListener("DOMContentLoaded", fn);
  }

  ready(function () {
    var htmlEscapeMap = {
      "&": "&amp;",
      "<": "&lt;",
      ">": "&gt;",
      "'": "&#39;",
      '"': "&quot;",
    };
    function escapeHtml(s) {
      return String(s).replace(/[&<>'"]/g, function (c) {
        return htmlEscapeMap[c];
      });
    }

    (function initSidenavToggle() {
      var navToggle = document.querySelector(".nav-toggle");
      var sidenav = document.querySelector(".sidenav.compact");
      if (!navToggle || !sidenav) return;

      var overlay = document.querySelector(".sidenav-overlay");
      if (!overlay) {
        overlay = document.createElement("div");
        overlay.className = "sidenav-overlay";
        document.body.appendChild(overlay);
      }

      var lastFocused = null;

      try {
        sidenav.setAttribute("role", "navigation");
        sidenav.setAttribute("aria-hidden", "true");
      } catch (e) {}

      function openSidenav() {
        lastFocused = document.activeElement;
        sidenav.classList.add("open");
        overlay.classList.add("open");
        navToggle.setAttribute("aria-expanded", "true");
        sidenav.setAttribute("aria-hidden", "false");
        if (sitePage) sitePage.classList.add("sidenav-open");
        var first = sidenav.querySelector(
          "a,button,input,select,textarea,[tabindex]:not([tabindex='-1'])"
        );
        if (first) first.focus();
        document.addEventListener("keydown", onKeyDown);
      }

      function closeSidenav() {
        sidenav.classList.remove("open");
        overlay.classList.remove("open");
        navToggle.setAttribute("aria-expanded", "false");
        sidenav.setAttribute("aria-hidden", "true");
        if (sitePage) {
          sitePage.classList.remove("sidenav-open");
          sitePage.classList.remove("sidenav-preview");
        }
        document.removeEventListener("keydown", onKeyDown);
        try {
          if (lastFocused && typeof lastFocused.focus === "function")
            lastFocused.focus();
        } catch (e) {}
      }

      function toggleSidenav() {
        if (sidenav.classList.contains("open")) closeSidenav();
        else openSidenav();
      }

      navToggle.addEventListener("click", function (ev) {
        ev.preventDefault();
        toggleSidenav();
      });

      sidenav.addEventListener("mouseenter", function () {
        if (!sidenav.classList.contains("open")) {
          sidenav.classList.add("preview");
          if (sitePage) sitePage.classList.add("sidenav-preview");
        }
      });
      sidenav.addEventListener("mouseleave", function () {
        sidenav.classList.remove("preview");
        if (sitePage) sitePage.classList.remove("sidenav-preview");
      });

      overlay.addEventListener("click", function () {
        closeSidenav();
      });
    })();

    var cart = JSON.parse(localStorage.getItem("ayudabuy_cart") || "{}");

    // Shipping fee
    var SHIPPING_FEE = 50;
    function saveCart() {
      localStorage.setItem("ayudabuy_cart", JSON.stringify(cart));
    }

    function cartCount() {
      return Object.values(cart).reduce(function (sum, it) {
        return sum + it.qty;
      }, 0);
    }

    function updateCartBadge() {
      var badge = document.querySelector(".cart-badge");
      if (!badge) return;
      var c = cartCount();
      badge.textContent = c;
      badge.style.display = c > 0 ? "inline-block" : "none";
    }

    function addToCart(item) {
      if (!cart[item.id]) {
        cart[item.id] = {
          id: item.id,
          name: item.name,
          price: parseFloat(item.price),
          img: item.img,
          qty: 0,
        };
      }
      cart[item.id].qty += 1;
      saveCart();
      updateCartBadge();
      renderCart();
    }

    function removeFromCart(id) {
      if (!cart[id]) return;
      delete cart[id];
      saveCart();
      updateCartBadge();
      renderCart();
    }

    function renderCart() {
      var drawer = document.querySelector(".cart-drawer");
      if (!drawer) return;
      var list = drawer.querySelector(".cart-list");
      var footerTotal = drawer.querySelector(".cart-total");
      list.innerHTML = "";
      var keys = Object.keys(cart);
      if (keys.length === 0) {
        list.innerHTML = '<div class="cart-empty">Your cart is empty</div>';
        footerTotal.textContent = "₱0.00";
        return;
      }
      var subtotal = 0;
      keys.forEach(function (k) {
        var it = cart[k];
        var itemSubtotal = it.price * it.qty;
        subtotal += itemSubtotal;
        var row = document.createElement("div");
        row.className = "cart-item";
        var img = document.createElement("img");
        img.src = it.img;
        img.alt = it.name;
        var meta = document.createElement("div");
        meta.className = "meta";
        meta.innerHTML =
          '<div class="fw-bold">' +
          escapeHtml(it.name) +
          '</div><div class="small text-muted">Qty: ' +
          it.qty +
          " • Unit: ₱" +
          it.price.toFixed(2) +
          "</div>";
        var remove = document.createElement("button");
        remove.className = "btn btn-sm btn-link text-danger";
        remove.textContent = "Remove";
        remove.addEventListener("click", function () {
          removeFromCart(k);
        });
        row.appendChild(img);
        row.appendChild(meta);
        row.appendChild(remove);
        list.appendChild(row);
      });
      var shipping = keys.length > 0 ? SHIPPING_FEE : 0;
      var total = subtotal + shipping;
      var shippingEl = drawer.querySelector(".cart-shipping");
      if (shippingEl) shippingEl.textContent = "₱" + shipping.toFixed(2);
      footerTotal.textContent = "₱" + total.toFixed(2);
    }

    function toggleCart(show) {
      var drawer = document.querySelector(".cart-drawer");
      if (!drawer) return;
      if (typeof show === "boolean") {
        drawer.classList.toggle("open", show);
      } else drawer.classList.toggle("open");
      renderCart();
    }

    document.querySelectorAll(".btn-add").forEach(function (b) {
      b.addEventListener("click", function () {
        var id = b.dataset.id;
        var name = b.dataset.name;
        var price = b.dataset.price;
        var img = b.dataset.img;
        addToCart({ id: id, name: name, price: price, img: img });
      });
    });

    (function initProductPreview() {
      var modal = document.createElement("div");
      modal.className = "image-modal";
      modal.innerHTML =
        '<div class="image-modal-inner" role="dialog" aria-modal="true"><button class="image-modal-close" aria-label="Close preview">×</button><img src="" alt="" /><div class="image-caption"></div></div>';
      document.body.appendChild(modal);

      var inner = modal.querySelector(".image-modal-inner");
      var imgEl = modal.querySelector("img");
      var caption = modal.querySelector(".image-caption");
      var closeBtn = modal.querySelector(".image-modal-close");

      function openPreview(src, alt) {
        if (!src) return;
        imgEl.src = src;
        imgEl.alt = alt || "Product preview";
        caption.textContent = alt || "";
        modal.classList.add("open");

        closeBtn.focus();
        document.addEventListener("keydown", onKey);
      }
      function closePreview() {
        modal.classList.remove("open");
        imgEl.src = "";
        caption.textContent = "";
        document.removeEventListener("keydown", onKey);
      }
      function onKey(e) {
        if (e.key === "Escape" || e.key === "Esc") closePreview();
      }

      closeBtn.addEventListener("click", function () {
        closePreview();
      });
      modal.addEventListener("click", function (ev) {
        if (ev.target === modal) closePreview();
      });

      document
        .querySelectorAll(".product-card .btn-outline-secondary")
        .forEach(function (btn) {
          try {
            btn.disabled = false;
          } catch (e) {}
          btn.setAttribute("type", "button");
          btn.addEventListener("click", function (ev) {
            var card = btn.closest(".product-card");
            if (!card) return;
            var pi = card.querySelector(".product-image");
            var src = pi ? pi.src : btn.dataset.img;
            var alt = pi ? pi.alt : btn.getAttribute("aria-label") || "Preview";

            if (modal.classList.contains("open") && imgEl.src === src) {
              closePreview();
            } else {
              openPreview(src, alt);
            }
          });
        });
    })();

    (function injectCartToggle() {
      var status = document.querySelector(".site-status");

      var containerFallback =
        document.querySelector(".site-actions") ||
        document.querySelector(".site-header") ||
        document.querySelector("header") ||
        document.body;
      var btn = document.createElement("button");
      btn.className = "cart-toggle";
      btn.setAttribute("aria-label", "Open cart");
      btn.innerHTML = '<i class="fa fa-shopping-cart fa-lg"></i>';
      var badge = document.createElement("span");
      badge.className = "cart-badge";
      badge.style.display = "none";
      badge.textContent = "0";
      btn.appendChild(badge);
      if (status && status.parentNode) {
        status.parentNode.insertBefore(btn, status.nextSibling);
      } else if (containerFallback) {
        containerFallback.appendChild(btn);
      } else {
        document.body.appendChild(btn);
      }
      btn.addEventListener("click", function () {
        toggleCart();
      });

      var drawer = document.createElement("div");
      drawer.className = "cart-drawer";
      drawer.innerHTML =
        '<div class="d-flex justify-content-between align-items-center mb-2"><strong>Your Cart</strong><button class="btn btn-sm btn-outline-secondary close-cart">Close</button></div><div class="cart-list"></div><div class="cart-footer mt-2"><div class="small text-muted">Shipping: <strong class="cart-shipping">₱0.00</strong></div><div>Total: <strong class="cart-total">₱0.00</strong></div><button class="btn btn-primary btn-sm checkout">Checkout</button></div>';
      document.body.appendChild(drawer);
      drawer
        .querySelector(".close-cart")
        .addEventListener("click", function () {
          toggleCart(false);
        });
      drawer.querySelector(".checkout").addEventListener("click", function () {
        var subtotalNow = Object.keys(cart).reduce(function (sum, k) {
          var it = cart[k];
          return sum + parseFloat(it.price || 0) * it.qty;
        }, 0);
        var shippingNow = Object.keys(cart).length > 0 ? SHIPPING_FEE : 0;
        var totalNow = subtotalNow + shippingNow;
        alert(
          "Checkout total: ₱" +
            totalNow.toFixed(2) +
            " (including ₱" +
            shippingNow.toFixed(2) +
            " shipping) — thank you for trying AyudaBuy!"
        );
        cart = {};
        saveCart();
        updateCartBadge();
        renderCart();
        toggleCart(false);
      });
      updateCartBadge();
      renderCart();
    })();
  });
})();
