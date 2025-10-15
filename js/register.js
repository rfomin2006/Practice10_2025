const reg_form = document.getElementById("registerForm");
const loginField = document.getElementById("login");
const emailField = document.getElementById("email");
const passwordField = document.getElementById("password");
const regBtn = document.getElementById("regBtn");

regBtn.addEventListener("click", (e) => {
  const login = loginField.value;
  const email = emailField.value;
  const password = passwordField.value;
  e.preventDefault();
  fetch("../api/users.php", {
    method: "GET",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify({ login: login }),
    credentials: "include",
  })
    .then((res) => res.json())
    .then((result) => {
      if (result.success) {
        fetch("../api/users.php", {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify({
            login: login,
            email: email,
            password: password,
          }),
          credentials: "include",
        });
      } else {
        console.error("Ошибка регистрации:", result.message);
      }
    })
    .catch((err) => console.error(err));
});
