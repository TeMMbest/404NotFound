document.addEventListener("DOMContentLoaded", function () {
  const sidebarToggle = document.getElementById("sidebarToggle");
  const sidebar = document.getElementById("sidebar");

  if (sidebarToggle && sidebar) {
    sidebarToggle.addEventListener("click", function () {
      sidebar.classList.toggle("open");
    });

    document.addEventListener("click", function (e) {
      if (!sidebar.contains(e.target) && !sidebarToggle.contains(e.target)) {
        sidebar.classList.remove("open");
      }
    });
  }

  const alerts = document.querySelectorAll(".alert");
  alerts.forEach(function (alert) {
    setTimeout(function () {
      alert.style.transition = "opacity 0.5s";
      alert.style.opacity = "0";
      setTimeout(function () {
        alert.remove();
      }, 500);
    }, 5000);
  });

  const modals = document.querySelectorAll(".modal");
  modals.forEach(function (modal) {
    modal.addEventListener("click", function (e) {
      if (e.target === modal) {
        modal.classList.remove("show");
      }
    });
  });

  const forms = document.querySelectorAll("form");
  forms.forEach(function (form) {
    form.addEventListener("submit", function (e) {
      const requiredFields = form.querySelectorAll("[required]");
      let isValid = true;

      requiredFields.forEach(function (field) {
        if (!field.value.trim()) {
          isValid = false;
          field.style.borderColor = "#dc3545";
        } else {
          field.style.borderColor = "";
        }
      });

      if (!isValid) {
        e.preventDefault();
        alert("Please fill in all required fields.");
      }
    });
  });

  const numberInputs = document.querySelectorAll('input[type="number"]');
  numberInputs.forEach(function (input) {
    input.addEventListener("input", function () {
      if (this.value < 0) {
        this.value = 0;
      }
    });
  });

  const priceInputs = document.querySelectorAll('input[name="item_price"]');
  priceInputs.forEach(function (input) {
    input.addEventListener("blur", function () {
      if (this.value) {
        this.value = parseFloat(this.value).toFixed(2);
      }
    });
  });
});

function confirmDelete(type) {
  return confirm(
    "Are you sure you want to delete this " +
      type +
      "? This action cannot be undone."
  );
}

function formatCurrency(amount) {
  return (
    "₱" +
    parseFloat(amount).toLocaleString("en-US", {
      minimumFractionDigits: 2,
      maximumFractionDigits: 2,
    })
  );
}

function showNotification(message, type = "success") {
  const notification = document.createElement("div");
  notification.className = "alert alert-" + type;
  notification.innerHTML =
    '<i class="fas fa-' +
    (type === "success" ? "check-circle" : "exclamation-circle") +
    '"></i> ' +
    message;
  notification.style.position = "fixed";
  notification.style.top = "80px";
  notification.style.right = "24px";
  notification.style.zIndex = "9999";
  notification.style.minWidth = "300px";

  document.body.appendChild(notification);

  setTimeout(function () {
    notification.style.transition = "opacity 0.5s";
    notification.style.opacity = "0";
    setTimeout(function () {
      notification.remove();
    }, 500);
  }, 3000);
}
