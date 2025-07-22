<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
?>
<style>
  .form-container {
    background-color: #fff;
    padding: 25px 30px;
    border-radius: 10px;
    box-shadow: 0 2px 12px rgba(0,0,0,0.1);
    max-width: 400px;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    margin: 0 auto;
  }

  .form-container label {
    display: block;
    margin-bottom: 15px;
    font-weight: 600;
    color: #34495e;
    font-size: 14px;
  }

  .form-container input[type="text"],
  .form-container input[type="email"],
  .form-container input[type="password"],
  .form-container input[type="number"],
  .form-container select {
    width: 100%;
    padding: 8px 10px;
    margin-top: 5px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 14px;
    box-sizing: border-box;
    transition: border-color 0.3s;
  }

  .form-container input[type="text"]:focus,
  .form-container input[type="email"]:focus,
  .form-container input[type="password"]:focus,
  .form-container input[type="number"]:focus,
  .form-container select:focus {
    border-color: teal;
    outline: none;
  }

  .form-container button[type="submit"] {
    background-color: teal;
    color: white;
    border: none;
    padding: 12px 22px;
    font-size: 16px;
    border-radius: 6px;
    cursor: pointer;
    transition: background-color 0.3s;
    margin-top: 10px;
  }

  .form-container button[type="submit"]:hover {
    background-color: #006666;
  }

  @media (max-width: 480px) {
    .form-container {
      padding: 20px 15px;
    }
  }
</style>

<div class="form-container">
  <h3>Add New User</h3>
  <form id="user-form" method="POST">
      <input type="hidden" name="id" value="">

      <label>ID No:
          <input name="idNo" type="number" required>
      </label>

      <label>Email:
          <input name="email" type="email" required>
      </label>

      <label>First Name:
          <input name="FirstName" type="text" required>
      </label>

      <label>Last Name:
          <input name="LastName" type="text" required>
      </label>

      <label>Password:
          <input name="password" type="password" required>
      </label>

      <label>Role:
          <select name="role" required>
              <option value="">-- Select Role --</option>
              <option value="user">User</option>
              <option value="admin">Admin</option>
          </select>
      </label>

      <button type="submit">Save</button>
  </form>
</div>
