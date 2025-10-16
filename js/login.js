const log_form = document.getElementById("loginForm");
const loginField = document.getElementById("login");
const passwordField = document.getElementById("password");
const logBtn = document.getElementById("loginBtn");

const API_ENDPOINT = "../api/users.php";

logBtn.addEventListener("click", async (e) => {
  e.preventDefault();

  const login = loginField.value;
  const password = passwordField.value;

  try {
    const response = await fetch(API_ENDPOINT, {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({
        action: "login",
        login: login,
        password: password,
      }),
      credentials: "same-origin",
    });

    const result = await response.json();

    if (response.status === 200) {
      if (result.data.is_admin) {
        window.location.href = "../pages/admin.php";
      } else {
        alert(result.data.message);
        window.location.href = "../pages/home.php";
      }
    } else {
      alert(result.error);
    }
  } catch (err) {
    console.error(err);
    alert("Something went wrong... Try again!");
  }
});
