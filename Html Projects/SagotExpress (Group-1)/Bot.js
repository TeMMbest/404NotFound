(function () {
  const chatWindow = document.getElementById("chatWindow");
  const chatForm = document.getElementById("chatForm");
  const userInput = document.getElementById("userInput");

  const BOT_NAME = "SagotExpress";

  /* SagotExpress knowledge base */
  const responses = [
    {
      keywords: ["hours", "time", "open", "closing"],
      reply:
        "SagotExpress support is online Monday to Friday, 8:00 AM – 6:00 PM. If you message outside these hours, automatic naming ipapasok sa priority queue kinabukasan.",
    },
    {
      keywords: ["contact", "email", "phone", "call"],
      reply:
        "Reach SagotExpress Care at support@sagotexpress.ph or call (02) 8899‑8811. Para mas mabilis, ihanda ang order o tracking number mo.",
    },
    {
      keywords: ["order", "status", "track", "tracking"],
      reply:
        "Para i-check ang status, mag-log in at buksan ang “My Parcels”. Real-time naming ina-update ang tracking tuwing may bagong courier scan.",
    },
    {
      keywords: ["refund", "return", "replace", "exchange"],
      reply:
        "May 30 days ka mula delivery date para mag-request ng return/refund. Siguraduhing maayos ang item at kumpleto ang accessories bago isumite ang form sa “My Parcels”.",
    },
    {
      keywords: ["shipping", "delivery", "ship"],
      reply:
        "Standard SagotExpress shipping tumatagal ng 3–5 business days matapos ang processing. May kasama itong SMS at email tracking alerts para updated ka palagi.",
    },
    {
      keywords: ["payment", "pay", "card", "method"],
      reply:
        "Tumatanggap kami ng major credit/debit cards, e‑wallets, at COD para sa piling ruta. Secure ang payment partner at di namin sine-save ang buong card details mo.",
    },
    {
      keywords: ["help", "support", "agent"],
      reply:
        "Ako ang SagotExpress assistant para sa orders, shipping, delivery hours, returns, payments, at contact info. Gamitin ang !list para makita lahat ng commands.",
    },
  ];

  const commandHandlers = {
    "!help": () =>
      "Uy! Ako si SagotExpress, ang mabilisang taga-sagot para sa delivery at order concerns mo.\n\nSubukan mo:\n- !list – tingnan lahat ng commands\n- Magtanong tungkol sa tracking, shipping time, returns, payments, o contact info.",
    "!list": () => {
      const cmdDescriptions = {
        "!help": "show what I can do",
        "!list": "list all commands and keywords",
        "!complain": "submit a complaint form",
        "!hours": "delivery support schedule",
        "!contact": "paano kami tawagan",
        "!clear": "clear the chat",
      };

      const cmdList = Object.keys(commandHandlers)
        .map((c) => (cmdDescriptions[c] ? `${c} – ${cmdDescriptions[c]}` : c))
        .join("\n- ");

      const keywordsSet = new Set();
      responses.forEach((entry) => {
        (entry.keywords || []).forEach((k) => keywordsSet.add(k));
      });

      const keywords = Array.from(keywordsSet).sort().join(", ");

      return (
        "Here are the commands I understand:\n- " +
        cmdList +
        "\n\nKeywords I recognize:\n- " +
        keywords +
        "\n\nPwede ka ring magtanong tulad ng “Nasaan na order ko?”"
      );
    },
    "!hours": () =>
      "SagotExpress support is online Monday–Friday, 9:00 AM – 6:00 PM. Kapag nag-message ka off-hours, sasagot kami sa susunod na business day.",
    "!contact": () =>
      "Contact SagotExpress via support@sagotexpress.ph, (02) 8899‑8811, o DM @SagotExpressCare. Average reply time: < 1 business day.",
    "!clear": (meta) => {
      chatWindow.innerHTML = "";
      appendBotMessage(
        "Chat cleared. You can start again by typing a question or using a command like !help.",
        meta
      );
      return null;
    },
    "!complain": () => {
      // complaint form
      const form = document.createElement("form");
      form.className = "complaint-form";

      const field = (labelText, input) => {
        const wrapper = document.createElement("div");
        wrapper.className = "cf-field";
        const label = document.createElement("label");
        label.textContent = labelText;
        wrapper.appendChild(label);
        wrapper.appendChild(input);
        return wrapper;
      };

      const nameInput = document.createElement("input");
      nameInput.type = "text";
      nameInput.placeholder = "Your name";
      nameInput.required = true;

      const emailInput = document.createElement("input");
      emailInput.type = "email";
      emailInput.placeholder = "you@example.com";
      emailInput.required = true;

      const orderInput = document.createElement("input");
      orderInput.type = "text";
      orderInput.placeholder = "Order number (optional)";

      const messageInput = document.createElement("textarea");
      messageInput.placeholder = "Describe your complaint...";
      messageInput.rows = 4;
      messageInput.required = true;

      const submitBtn = document.createElement("button");
      submitBtn.type = "submit";
      submitBtn.textContent = "Submit Complaint";

      const cancelBtn = document.createElement("button");
      cancelBtn.type = "button";
      cancelBtn.textContent = "Cancel";
      cancelBtn.style.marginLeft = "8px";

      form.appendChild(field("Name", nameInput));
      form.appendChild(field("Email", emailInput));
      form.appendChild(field("Order #", orderInput));
      form.appendChild(field("Message", messageInput));

      const actions = document.createElement("div");
      actions.className = "cf-actions";
      actions.appendChild(submitBtn);
      actions.appendChild(cancelBtn);
      form.appendChild(actions);

      if (!window._sagot_complaints) window._sagot_complaints = [];

      form.addEventListener("submit", function (ev) {
        ev.preventDefault();
        if (
          !nameInput.value.trim() ||
          !emailInput.value.trim() ||
          !messageInput.value.trim()
        ) {
          appendBotMessage(
            "Please fill in the required fields: Name, Email, and Message."
          );
          return;
        }

        const id =
          "CMP-" +
          Date.now().toString(36) +
          Math.floor(Math.random() * 900 + 100);
        const complaint = {
          id,
          name: nameInput.value.trim(),
          email: emailInput.value.trim(),
          order: orderInput.value.trim() || null,
          message: messageInput.value.trim(),
          submittedAt: new Date().toISOString(),
        };

        window._sagot_complaints.push(complaint);

        submitBtn.disabled = true;
        nameInput.disabled = true;
        emailInput.disabled = true;
        orderInput.disabled = true;
        messageInput.disabled = true;

        appendBotMessage(
          `Complaint submitted. Reference ID: ${id}\n\nOur SagotExpress team will review and will reach out to you at ${complaint.email}.`
        );
      });

      cancelBtn.addEventListener("click", function () {
        appendBotMessage(
          "Complaint cancelled. If you need anything else, type !help."
        );
      });

      appendBotElement(form);
      return null;
    },
  };

  function appendMessageRow(text, sender) {
    const row = document.createElement("div");
    row.className = "message-row " + sender;

    const bubble = document.createElement("div");
    bubble.className = "message-bubble";

    text.split("\n").forEach((line, index) => {
      if (index > 0) bubble.appendChild(document.createElement("br"));
      bubble.appendChild(document.createTextNode(line));
    });

    const meta = document.createElement("div");
    meta.className = "message-meta";
    const now = new Date();
    const timeStr = now.toLocaleTimeString([], {
      hour: "2-digit",
      minute: "2-digit",
    });
    meta.textContent =
      (sender === "user" ? "You • " : BOT_NAME + " • ") + timeStr;

    bubble.appendChild(document.createElement("br"));
    bubble.appendChild(meta);

    row.appendChild(bubble);
    chatWindow.appendChild(row);
    chatWindow.scrollTop = chatWindow.scrollHeight;
  }

  function appendUserMessage(text) {
    appendMessageRow(text, "user");
  }

  function appendBotMessage(text) {
    appendMessageRow(text, "bot");
  }

  // append an arbitrary DOM element as a bot message (used for forms/widgets)
  function appendBotElement(el) {
    const row = document.createElement("div");
    row.className = "message-row bot";

    const bubble = document.createElement("div");
    bubble.className = "message-bubble";

    bubble.appendChild(el);

    const meta = document.createElement("div");
    meta.className = "message-meta";
    const now = new Date();
    const timeStr = now.toLocaleTimeString([], {
      hour: "2-digit",
      minute: "2-digit",
    });
    meta.textContent = BOT_NAME + " • " + timeStr;

    bubble.appendChild(document.createElement("br"));
    bubble.appendChild(meta);

    row.appendChild(bubble);
    chatWindow.appendChild(row);
    chatWindow.scrollTop = chatWindow.scrollHeight;
  }

  function handleCommand(rawText) {
    const text = rawText.trim().toLowerCase();
    const handler = commandHandlers[text];
    if (!handler) {
      return "I don’t recognize that command. Type !list to see everything I understand.";
    }
    return handler();
  }

  function findResponseFor(message) {
    const normalized = message.toLowerCase();
    for (const entry of responses) {
      if (entry.keywords.some((kw) => normalized.includes(kw))) {
        return entry.reply;
      }
    }
    return (
      "Wala pa akong sagot para diyan.\n\n" +
      "SagotExpress assistant lang ako na may pre-programmed replies tungkol sa delivery hours, contact info, shipping, returns, at payments. " +
      "Subukan mong i-type ang !help para makita ang lahat."
    );
  }

  function handleUserInput(text) {
    if (!text.trim()) return;

    appendUserMessage(text);
    userInput.value = "";

    const trimmed = text.trim();
    const looksLikeCommand = trimmed.startsWith("!");

    let reply;
    if (looksLikeCommand) {
      const result = handleCommand(trimmed);
      if (result) {
        reply = result;
      } else {
        return;
      }
    } else {
      reply = findResponseFor(trimmed);
    }

    appendBotMessage(reply);
  }

  function registerQuickCommands() {
    const buttons = document.querySelectorAll(".quick-command[data-command]");
    buttons.forEach((button) => {
      button.addEventListener("click", function () {
        const command = button.getAttribute("data-command");
        if (!command) return;
        handleUserInput(command);
      });
    });
  }

  chatForm.addEventListener("submit", function (event) {
    event.preventDefault();
    handleUserInput(userInput.value);
  });

  registerQuickCommands();

  // automated message
  window.addEventListener("load", function () {
    setTimeout(function () {
      appendBotMessage(
        "Welcome to SagotExpress — ang mabilisang sagot para sa lahat ng tanong mo tungkol sa orders, delivery, at shipping updates! Handa akong tumulong anytime, anywhere.\n\n" +
          "Pwede kang magtanong sa Tagalog o English, o gamitin ang !help at !list para makita ang mga puwede kong gawin."
      );
    }, 350);
  });
})();
