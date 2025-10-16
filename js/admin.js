const API_ENDPOINT = "../api/admin_users.php";

async function loadUsers(page = 1, search = "") {
  const res = await fetch(
    `${API_ENDPOINT}?page=${page}&search=${encodeURIComponent(search)}`,
    { credentials: "same-origin" }
  );
  const data = await res.json();

  if (!data.success) {
    alert("Error: " + data.error);
    return;
  }

  const tbody = document.querySelector("#userTable tbody");
  tbody.innerHTML = "";

  data.data.users.forEach((u) => {
    const row = document.createElement("tr");
    row.innerHTML = `
      <td>${u.id}</td>
      <td>${u.login}</td>
      <td>${u.email}</td>
      <td>${u.is_admin}</td>
      <td>
        <button class="edit" data-id="${u.id}">Edit</button>
        <button class="delete" data-id="${u.id}">Delete</button>
      </td>`;
    tbody.appendChild(row);
  });

  document.getElementById("totalUsers").textContent = data.data.total;
  attachUserActions();
}

function attachUserActions() {
  document.querySelectorAll(".delete").forEach((btn) => {
    btn.onclick = async () => {
      const id = btn.dataset.id;
      if (!confirm("Do you sure?")) return;

      try {
        const res = await fetch(API_ENDPOINT, {
          method: "DELETE",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify({ id }),
          credentials: "same-origin",
        });
        const result = await res.json();
        if (res.status === 200) loadUsers();
        else alert(result.error);
      } catch (err) {
        console.error(err);
        alert("Error while deleting!");
      }
    };
  });

  document.querySelectorAll(".edit").forEach((btn) => {
    btn.onclick = () => {
      const id = btn.dataset.id;
      const newLogin = prompt("New login:");
      const newEmail = prompt("New email:");
      const newRole = confirm("Grant admin rights?") ? 1 : 0;

      if (!newLogin && !newEmail && newRole === null) return;

      fetch(API_ENDPOINT, {
        method: "PATCH",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({
          id,
          login: newLogin,
          email: newEmail,
          role: newRole,
        }),
        credentials: "same-origin",
      })
        .then((r) => r.json())
        .then((res) => {
          if (res.success) loadUsers();
          else alert(res.error);
        })
        .catch((err) => {
          console.error(err);
          alert("Error while editing!");
        });
    };
  });
}

// search users
document.getElementById("searchBtn").onclick = () => {
  const q = document.getElementById("searchField").value;
  loadUsers(1, q);
};

// load users when page loads
document.addEventListener("DOMContentLoaded", () => {
  loadUsers();
});
