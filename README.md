# Student Practice Project

## Backend (Native PHP)
- PHP without frameworks
- MySQL database
- Pure PHP or minimal dependencies

## Frontend
- HTML5, CSS3, JavaScript (vanilla)
- `fetch()` for API interaction

## 2. Authentication System
### Registration
- Username / Login
- Email
- Password
- Password hashing using `password_hash()`

### Login
- Login via username/email and password
- PHP sessions

### Logout
- End session and log out user

## 3. Public Pages
- Main page – greeting
- Registration page
- Login page

## 4. User Dashboard
- Access restricted to authenticated users
- Display user information
- Profile editing
- Password change

## 5. Admin Panel
- Access restricted to users with the role `admin`
- Dashboard with statistics (number of users, etc.)
- User list with pagination
- User search / filtering
- Edit user information
- Delete users (with confirmation)

# API Docs

## `users.php` – User Registration and Login

| Method | Endpoint                       | Request Body                                                                           | Description                      | Response                                                                                     |
| ------ | ------------------------------ | -------------------------------------------------------------------------------------- | -------------------------------- | -------------------------------------------------------------------------------------------- |
| POST   | `/api/users.php`               | `{ "action": "register", "login": "string", "email": "string", "password": "string" }` | Register a new user              | `200 OK`<br>`{ "message": "User created" }`                                                  |
| POST   | `/api/users.php`               | `{ "action": "login", "login": "string", "password": "string" }`                       | Login a user (by login or email) | `200 OK`<br>`{ "message": "Login successful", "is_admin": true/false }`                      |
| GET    | `/api/users.php?login={login}` | None                                                                                   | Get user info by login           | `200 OK`<br>`[{ "id": 1, "login": "user1", "email": "user1@mail.com", "is_admin": 0 }]`      |
| GET    | `/api/users.php`               | None                                                                                   | Get all users                    | `200 OK`<br>`[{ "id": 1, "login": "user1", "email": "user1@mail.com", "is_admin": 0 }, ...]` |

## `profile.php` – User Profile

| Method | Endpoint           | Request Body                                                                                   | Description                                | Response                                                                         |
| ------ | ------------------ | ---------------------------------------------------------------------------------------------- | ------------------------------------------ | -------------------------------------------------------------------------------- |
| GET    | `/api/profile.php` | None                                                                                           | Get current logged-in user info            | `200 OK`<br>`{ "id": 1, "login": "user1", "email": "user1@mail.com" }`           |
| PATCH  | `/api/profile.php` | `{ "login": "string", "email": "string", "old_password": "string", "new_password": "string" }` | Update user profile fields and/or password | `200 OK`<br>`{ "message": "Profile updated" }`<br>`400 Bad Request` if no fields |

## `admin_users.php` – Admin User Management

**Authorization**: Only admin users (`is_admin` = 1) can access.

| Method | Endpoint                                          | Query/Body                                                         | Description                                      | Response                                                                                                                   |
| ------ | ------------------------------------------------- | ------------------------------------------------------------------ | ------------------------------------------------ | -------------------------------------------------------------------------------------------------------------------------- |
| GET    | `/api/admin_users.php?page={page}&search={query}` | None                                                               | Get paginated list of users with optional search | `200 OK`<br>`{ "users": [{ "id":1,"login":"user1","email":"user1@mail.com","is_admin":0 }, ...], "total": 25, "page": 1 }` |
| PATCH  | `/api/admin_users.php`                            | `{ "id": 1, "login": "string", "email": "string", "is_admin": 1 }` | Edit user data                                   | `200 OK`<br>`{ "message": "User updated" }`                                                                                |
| DELETE | `/api/admin_users.php`                            | `{ "id": 1 }`                                                      | Delete user by ID                                | `200 OK`<br>`{ "message": "User deleted" }`                                                                                |
