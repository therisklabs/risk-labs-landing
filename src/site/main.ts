// The Risk Labs — marketing site behaviour: mobile nav, footer year, contact form.

const CONTACT_EMAIL = "risklabs@proton.me";
const EMAIL_PATTERN = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

function initNav(): void {
  const toggle = document.getElementById("nav-toggle");
  const nav = document.getElementById("site-nav");
  if (!toggle || !nav) return;

  const setOpen = (open: boolean) => {
    nav.classList.toggle("is-open", open);
    toggle.setAttribute("aria-expanded", String(open));
    toggle.setAttribute("aria-label", open ? "Close menu" : "Open menu");
  };

  toggle.addEventListener("click", () => {
    setOpen(!nav.classList.contains("is-open"));
  });

  nav.querySelectorAll("a").forEach((link) => {
    link.addEventListener("click", () => setOpen(false));
  });

  document.addEventListener("keydown", (event) => {
    if (event.key === "Escape" && nav.classList.contains("is-open")) {
      setOpen(false);
      toggle.focus();
    }
  });
}

function initYear(): void {
  const year = document.getElementById("year");
  if (year) year.textContent = String(new Date().getFullYear());
}

function fieldValue(form: HTMLFormElement, name: string): string {
  const field = form.elements.namedItem(name) as HTMLInputElement | HTMLSelectElement | HTMLTextAreaElement | null;
  return field ? field.value.trim() : "";
}

function initContactForm(): void {
  const form = document.getElementById("contact-form") as HTMLFormElement | null;
  const errorBox = document.getElementById("form-error");
  if (!form || !errorBox) return;

  const showError = (message: string, fieldName?: string) => {
    errorBox.textContent = message;
    errorBox.hidden = false;
    if (fieldName) {
      const field = form.elements.namedItem(fieldName) as HTMLElement | null;
      field?.setAttribute("aria-invalid", "true");
      field?.focus();
    }
  };

  form.addEventListener("input", (event) => {
    (event.target as HTMLElement).removeAttribute("aria-invalid");
  });

  form.addEventListener("submit", (event) => {
    event.preventDefault();
    errorBox.hidden = true;

    const name = fieldValue(form, "name");
    const email = fieldValue(form, "email");
    const company = fieldValue(form, "company");
    const service = fieldValue(form, "service");
    const message = fieldValue(form, "message");

    if (!name) return showError("Please enter your name.", "name");
    if (!EMAIL_PATTERN.test(email)) return showError("Please enter a valid work email address.", "email");
    if (!message) return showError("Please describe what you need.", "message");

    const subject = `Enquiry: ${service}${company ? ` — ${company}` : ""}`;
    const body = [
      `Name: ${name}`,
      `Email: ${email}`,
      `Company: ${company || "Not provided"}`,
      `Area of interest: ${service}`,
      "",
      message,
    ].join("\n");

    window.location.href =
      `mailto:${CONTACT_EMAIL}?subject=${encodeURIComponent(subject)}&body=${encodeURIComponent(body)}`;
  });
}

initNav();
initYear();
initContactForm();
