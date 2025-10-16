const msg = document.getElementById("message");
const loginField = document.getElementById("login");
const emailField = document.getElementById("email");
const saveBtn = document.getElementById("saveProfileBtn");
const changePassBtn = document.getElementById("changePasswordBtn");
const oldPass = document.getElementById("old_password");
const newPass = document.getElementById("new_password");

const API_ENDPOINT = "../api/profile.php";

async function loadProfile() {
  try {
    const res = await fetch(API_ENDPOINT);
    const data = await res.json();

    if (!res.ok)
      throw new Error(data.message || "Error while loading profile!");

    loginField.value = data.data.login || "";
    emailField.value = data.data.email || "";
  } catch (err) {
    msg.textContent = err.message;
  }
}

saveBtn.addEventListener("click", async (e) => {
  e.preventDefault();

  const payload = {
    login: loginField.value,
    email: emailField.value,
  };

  try {
    const res = await fetch(API_ENDPOINT, {
      method: "PATCH",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify(payload),
      credentials: "same-origin",
    });

    const data = await res.json();
    msg.textContent =
      data.data.message || "Unrecognized response";
  } catch (err) {
    msg.textContent = "Error while updating profile";
  }
});

changePassBtn.addEventListener("click", async (e) => {
  e.preventDefault();

  const payload = {
    old_password: oldPass.value,
    new_password: newPass.value,
  };

  try {
    const res = await fetch(API_ENDPOINT, {
      method: "PATCH",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify(payload),
      credentials: "same-origin",
    });

    const data = await res.json();
    msg.textContent =
      data.data.message || "Unrecognized response";
  } catch (err) {
    msg.textContent = "Error while changing password";
  }
});

loadProfile();
