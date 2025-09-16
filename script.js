// Globale Variablen für Auswahloptionen
let brandOptions = [];
let materialOptions = [];


// Dark / Light Mode
const darkMode = window.matchMedia("(prefers-color-scheme: dark)").matches;
document.documentElement.setAttribute("data-theme", darkMode ? "DARK" : "LIGHT");

// -------------------------
// Sprache laden
// -------------------------
async function loadLanguage() {
  let lang = navigator.language.split("-")[0];
  try {
    let response = await fetch(`lang/${lang}.json`);
    if (!response.ok) {
      lang = "en";
      response = await fetch(`lang/${lang}.json`);
    }
    const translations = await response.json();
    document.querySelectorAll("[data-i18n]").forEach(el => {
      const key = el.getAttribute("data-i18n");
      if (translations[key]) el.textContent = translations[key];
    });
  } catch (err) {
    console.error("Fehler beim Laden der Sprachdatei:", err);
  }
}

// -------------------------
// Marken & Materialien laden
// -------------------------
async function loadOptions() {
  try {
    const brandsResponse = await fetch("brands.json");
    brandOptions = await brandsResponse.json();
    const materialsResponse = await fetch("materials.json");
    materialOptions = await materialsResponse.json();

    populateSelects();
    await loadSlots();
    updateColorDisplays()
  } catch (error) {
    console.error("Fehler beim Laden der Optionen:", error);
  }
}

// -------------------------
// Dropdowns für Marken/Materialien
// -------------------------
function populateSelects() {
  document.querySelectorAll(".slot").forEach(slot => {
    const brandSelect = slot.querySelector(".brand");
    const materialSelect = slot.querySelector(".material");
    brandSelect.innerHTML = "";
    materialSelect.innerHTML = "";

    brandOptions.forEach(b => {
      const option = document.createElement("option");
      option.value = b;
      option.textContent = b;
      brandSelect.appendChild(option);
    });

    materialOptions.forEach(m => {
      const option = document.createElement("option");
      option.value = m;
      option.textContent = m;
      materialSelect.appendChild(option);
    });
  });
}

// -------------------------
// Farb-Display aktualisieren
// -------------------------
function updateColorDisplays() {
  document.querySelectorAll(".slot").forEach(slot => {
    const colorInput = slot.querySelector(".color");
    const colorDisplay = slot.querySelector(".color-display");
    if (!colorDisplay) return;

    colorDisplay.style.backgroundColor = colorInput.value;
    colorInput.addEventListener("input", () => {
      colorDisplay.style.backgroundColor = colorInput.value;
    });
  });
}

// -------------------------
// Slot-Daten auslesen
// -------------------------
function getSlotData() {
  const slots = [];
  document.querySelectorAll(".slot").forEach(slot => {
    slots.push({
      brand: slot.querySelector(".brand").value,
      material: slot.querySelector(".material").value,
      color: slot.querySelector(".color").value
    });
  });
  return slots;
}

// -------------------------
// Container-Titel Listener
// -------------------------
function setupContainerTitleListeners() {
  const titleInput = document.querySelector(".container-title");
  if (!titleInput) return;

  titleInput.addEventListener("keydown", (e) => {
    if (e.key === "Enter") {
      e.preventDefault(); // verhindert, dass das Formular abschickt
      // Wert committen (falls nötig)
      titleInput.blur();   // zwingt Input, den Wert zu „committen“
      saveSlots();
    }
  });

  titleInput.addEventListener("blur", () => {
    saveSlots();
  });
}

function applySlotVisibility(slotCount) {
  document.querySelectorAll(".slot").forEach((slot, i) => {
    slot.style.display = i < slotCount ? "" : "none";
  });
}

// -------------------------
// Hide button for last slot
// -------------------------
function updateDeleteButtons() {
  const slots = Array.from(document.querySelectorAll(".slot"));

  // Alle bisherigen Delete-Buttons entfernen
  slots.forEach(slot => {
    const btn = slot.querySelector(".delete-slot-btn");
    if (btn) btn.remove();
  });

  // Sichtbare Slots filtern
  const visibleSlots = slots.filter(slot => !slot.classList.contains("hidden"));

  // Wenn nur 1 sichtbar ist, kein Delete-Button anzeigen
  if (visibleSlots.length <= 1) return;

  // Letzten sichtbaren Slot nehmen
  const lastSlot = visibleSlots[visibleSlots.length - 1];

  // Delete-Button erstellen
  const deleteBtn = document.createElement("button");
  deleteBtn.textContent = "✕";
  deleteBtn.classList.add("delete-slot-btn");
  lastSlot.style.position = "relative";
  lastSlot.appendChild(deleteBtn);

  // Klick-Event: Slot ausblenden
  deleteBtn.addEventListener("click", () => {
    const content = lastSlot.querySelector(".slot-content");
    if (content) content.style.opacity = "0"; // fade-out
    setTimeout(() => {
      lastSlot.classList.add("hidden");
      updateDeleteButtons();
      updateAddButtons();
      saveSlots();
    }, 300); // entspricht Transition-Dauer
  });
}

// -------------------------
// unhide button
// -------------------------
function updateAddButtons() {
  const container = document.querySelector(".slot-container");
  if (!container) return;

  // Alle bisherigen Add-Buttons entfernen
  container.querySelectorAll(".add-slot-btn").forEach(btn => btn.remove());

  const slots = Array.from(container.querySelectorAll(".slot"));

  // Letzten sichtbaren Slot finden
  const lastVisibleIndex = slots.map(s => !s.classList.contains("hidden")).lastIndexOf(true);

  // Nächsten versteckten Slot danach
  const nextSlot = slots.slice(lastVisibleIndex + 1).find(s => s.classList.contains("hidden"));

  if (nextSlot) {
    // Add-Button erstellen
    const addBtn = document.createElement("button");
    addBtn.textContent = "+";
    addBtn.classList.add("add-slot-btn");
    nextSlot.appendChild(addBtn);

    addBtn.addEventListener("click", () => {
      nextSlot.classList.remove("hidden");
      const content = nextSlot.querySelector(".slot-content");
      if (content) content.style.opacity = "0";
      setTimeout(() => {
        if (content) content.style.opacity = "1"; // fade-in
        updateAddButtons();
        updateDeleteButtons();
        saveSlots();
      }, 10);
    });
  }

  // Alle Slots danach prüfen: wenn hidden **und kein Add-Button**, ganz ausblenden
  slots.forEach(slot => {
    const addBtn = slot.querySelector(".add-slot-btn");
    const content = slot.querySelector(".slot-content");

    if (slot.classList.contains("hidden") && !addBtn) {
      // Fade-Out
      if (content) content.style.opacity = "0";  // Inhalt ausblenden
      slot.classList.add("fully-hidden");        // Höhe/Opacity animieren
    } else {
      // Fade-In
      slot.classList.remove("fully-hidden");
      if (content) content.style.opacity = "1";
    }
  });
}

// -------------------------
// Speichern in config.json
// -------------------------
async function saveSlots() {
  const container = document.querySelector(".slot-container");
  if (!container) return;

  const title = container.querySelector(".container-title")?.value || "";

  // Slots inkl. hidden auslesen
  const slots = Array.from(container.querySelectorAll(".slot")).map(slot => ({
    brand: slot.querySelector(".brand")?.value || "",
    material: slot.querySelector(".material")?.value || "",
    color: slot.querySelector(".color")?.value || "#ff6600",
    hidden: slot.classList.contains("hidden") // hier wird true/false gesetzt
  }));

  const formData = new FormData();
  formData.append("containers", JSON.stringify([{ title, slots }]));
  formData.append("settings", JSON.stringify({ slotCount: slots.length }));

  try {
    const response = await fetch("index.php", { method: "POST", body: formData });
    const result = await response.json();
    if (result.success) {
      showSaveMessage();
    } else {
      console.error("Fehler beim Speichern:", result.error);
    }
  } catch (error) {
    console.error("Fehler beim Speichern:", error);
  }
}

// -------------------------
// Speichern-Feedback
// -------------------------
function showSaveMessage() {
  let msg = document.getElementById("saveMessage");
  if (!msg) {
    msg = document.createElement("div");
    msg.id = "saveMessage";
    msg.style.cssText = "position:fixed;bottom:20px;right:20px;background:#ff6600;color:#fff;padding:.5rem 1rem;border-radius:8px;box-shadow:0 2px 6px rgba(0,0,0,.3);font-family:Arial,sans-serif;font-size:14px;display:flex;align-items:center;gap:8px;z-index:9999";
    document.body.appendChild(msg);
  }
  msg.innerHTML = `
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="white" stroke-width="2" viewBox="0 0 24 24">
      <path d="M20 6L9 17l-5-5"/>
    </svg> Gespeichert`;
  msg.style.opacity = "1";
  msg.style.transition = "opacity 0.5s";
  setTimeout(() => msg.style.opacity = "0", 1500);
}

// -------------------------
// Slots & Container laden
// -------------------------
async function loadSlots() {
  try {
    const response = await fetch("index.php?getSlots=1");
    const config = await response.json();

    const slotCount = (config.settings?.slotCount) || 5;
    const containerData = (config.containers && config.containers[0]) || {};

    // Container-Titel setzen
    const titleInput = document.querySelector(".container-title");
    if (titleInput) titleInput.value = containerData.title || "";

    // Slots setzen inkl. hidden
    const slots = containerData.slots || [];
    document.querySelectorAll(".slot").forEach((slot, i) => {
      if (!slots[i]) return;

      const brandInput = slot.querySelector(".brand");
      const materialInput = slot.querySelector(".material");
      const colorInput = slot.querySelector(".color");

      if (brandInput) brandInput.value = slots[i].brand || "";
      if (materialInput) materialInput.value = slots[i].material || "";
      if (colorInput) colorInput.value = slots[i].color || "#ff6600";

      // Hidden-Status anwenden
      if (slots[i].hidden) {
        slot.classList.add("hidden");
      } else {
        slot.classList.remove("hidden");
      }
    });

    // Delete-Buttons aktualisieren
    updateDeleteButtons();

    // unhide Button aktualisieren
    updateAddButtons();

    // Farb-Displays updaten
    updateColorDisplays();

  } catch (error) {
    console.error("Fehler beim Laden der config.json:", error);
  }
}

// -------------------------
// Automatisches Abgleichen der Config
// -------------------------
// Letzter bekannter Zustand
let lastConfig = null;

// Prüft alle 5 Sekunden
setInterval(async () => {
  try {
    const response = await fetch('index.php?getSlots=1', {cache: "no-store"});
    const config = await response.json();

    // Wenn es keine Änderung gibt, nichts tun
    if (JSON.stringify(config) === JSON.stringify(lastConfig)) return;

    lastConfig = config;

    // Slots aktualisieren, aber nur wenn der Benutzer gerade nicht tippt/ändert
    updateSlotsFromServer(config);

  } catch (err) {
    console.error("Fehler beim Abrufen der config.json:", err);
  }
}, 5000);


// Funktion, die Slots aktualisiert, ohne laufende Änderungen des Benutzers zu überschreiben
function updateSlotsFromServer(config) {
  const container = document.querySelector(".slot-container");
  if (!container) return;

  const containerData = (config.containers && config.containers[0]) || {};
  const slots = containerData.slots || [];

  document.querySelectorAll(".slot").forEach((slotEl, i) => {
    if (!slots[i]) return;

    // Nur aktualisieren, wenn das Feld nicht fokussiert ist
    const brand = slotEl.querySelector(".brand");
    const material = slotEl.querySelector(".material");
    const color = slotEl.querySelector(".color");

    if (brand && document.activeElement !== brand) brand.value = slots[i].brand || "";
    if (material && document.activeElement !== material) material.value = slots[i].material || "";
    if (color && document.activeElement !== color) color.value = slots[i].color || "#ff6600";

    // Hidden-Status
    if (slots[i].hidden) {
      slotEl.classList.add("hidden");
    } else {
      slotEl.classList.remove("hidden");
    }
  });

  // Update Delete- / Add-Buttons
  updateDeleteButtons();
  updateAddButtons();
}

// -------------------------
// Debounce
// -------------------------
function debounce(func, delay) {
  let timeout;
  return function() {
    clearTimeout(timeout);
    timeout = setTimeout(func, delay);
  };
}

// -------------------------
// Init
// -------------------------
document.addEventListener("DOMContentLoaded", () => {
  loadLanguage();
  loadOptions();
  updateDeleteButtons();
  updateAddButtons();
  loadSlots().then(() => {
    document.querySelector("main").classList.add("visible");
  });
  const debouncedSave = debounce(saveSlots, 1000);
  document.addEventListener("change", (e) => {
    if (e.target.matches(".slot input, .slot select")) debouncedSave();
  });

  const titleInput = document.querySelector(".container-title");
  if (titleInput) {
    titleInput.addEventListener("keydown", (e) => {
      if (e.key === "Enter") {
        e.preventDefault();   // verhindert Form-Submit
        saveSlots();          // speichert sofort
      }
    });

    titleInput.addEventListener("blur", () => {
      saveSlots();
    });
  }
});
