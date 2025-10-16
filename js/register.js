const reg_form = document.getElementById("registerForm");
const loginField = document.getElementById("login");
const emailField = document.getElementById("email");
const passwordField = document.getElementById("password");
const regBtn = document.getElementById("regBtn");

const API_ENDPOINT = "../api/users.php";

regBtn.addEventListener("click", async (e) => {
  e.preventDefault();

  const login = loginField.value;
  const email = emailField.value;
  const password = passwordField.value;

  try {
    const checkResponse = await fetch(
      `${API_ENDPOINT}?login=${encodeURIComponent(login)}`,
      {
        method: "GET",
        credentials: "same-origin",
      }
    );
    const existingUser = await checkResponse.json();

    if (existingUser) {
      alert("User with this login already exists!");
      return;
    }

    const registerResponse = await fetch("/api/users.php", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({
        action: "register",
        login,
        email,
        password
      }),
      credentials: "same-origin"
    });

    const result = await registerResponse.json();

    if (registerResponse.status === 200) {
      alert(result.message || "Registration successfull");
      window.location.href = "/pages/login.php";
    } else {
      alert(result.msg || "Registration error!");
    }

  } catch (err) {
    console.error(err);
    alert("Something went wrong... Try again!");
  }
});
