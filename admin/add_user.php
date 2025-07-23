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
    max-width: 1000px;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    margin: 20px auto;
    box-sizing: border-box;
  }

  .form-container h3 {
    margin-bottom: 20px;
    color: #2c3e50;
  }

  #user-form {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
  }

  .form-group {
    display: flex;
    flex-direction: column;
    flex: 1 1 300px;
  }

  .form-group label {
    font-weight: 600;
    color: #34495e;
    font-size: 14px;
    margin-bottom: 5px;
  }

  .form-group input,
  .form-group select {
    width: 100%;
    padding: 8px 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 14px;
    box-sizing: border-box;
    transition: border-color 0.3s;
  }

  .form-group input:focus,
  .form-group select:focus {
    border-color: teal;
    outline: none;
  }

  button[type="submit"] {
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

  button[type="submit"]:hover {
    background-color: #006666;
  }

  @media (max-width: 600px) {
    .form-group {
      flex: 1 1 100%;
    }
  }
</style>

<div class="form-container">
  <h3>Add New User</h3>
  <form id="user-form" method="POST">
      <input type="hidden" name="id" value="">

      <div class="form-group">
          <label for="idNo">ID No:</label>
          <input name="idNo" type="number" required>
      </div>

      <div class="form-group">
          <label for="email">Email:</label>
          <input name="email" type="email" required>
      </div>

      <div class="form-group">
          <label for="FirstName">First Name:</label>
          <input name="FirstName" type="text" required>
      </div>

      <div class="form-group">
          <label for="LastName">Last Name:</label>
          <input name="LastName" type="text" required>
      </div>

      <div class="form-group">
          <label for="password">Password:</label>
          <input name="password" type="password" required>
      </div>

      <div class="form-group">
          <label for="role">Role:</label>
          <select name="role" required>
              <option value="">-- Select Role --</option>
              <option value="user">User</option>
              <option value="admin">Admin</option>
          </select>
      </div>

      <div class="form-group" style="flex: 1 1 100%;">
          <button type="submit">Save</button>
      </div>
  </form>
</div>
