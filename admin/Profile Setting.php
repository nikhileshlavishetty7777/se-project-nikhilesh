<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Profile Setting</title>
  <style>
    body {
  margin: 0;
  font-family: 'Segoe UI', sans-serif;
  background: #f5c373ff; /* Light orange */
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;

    }

    .profile-card {
      background: #fff;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 0 15px rgba(0,0,0,0.1);
      width: 100%;
      max-width: 450px;
      text-align: center;
    }

    .profile-card h2 {
      margin-bottom: 20px;
      font-size: 24px;
      color: #333;
    }

    .avatar {
      width: 100px;
      height: 100px;
      border-radius: 50%;
      margin-bottom: 20px;
      object-fit: cover;
      border: 3px solid #e74c3c;
    }

    .form-group {
      text-align: left;
      margin-bottom: 15px;
    }

    .form-group label {
      display: block;
      font-weight: bold;
      margin-bottom: 5px;
      color: #555;
    }

    .form-group input[type="text"],
    .form-group input[type="email"],
    .form-group input[type="tel"],
    .form-group input[type="password"] {
      width: 100%;
      padding: 10px;
      border-radius: 6px;
      border: 1px solid #ccc;
      font-size: 14px;
    }

    .form-group input[type="file"] {
      margin-top: 5px;
    }

    .save-btn {
      margin-top: 20px;
      padding: 12px;
      width: 100%;
      background-color: #ff6200ff;
      color: white;
      border: none;
      border-radius: 6px;
      font-size: 16px;
      cursor: pointer;
      transition: background 0.3s ease;
    }

    .save-btn:hover {
      background-color: #ff5618ff;
    }
  </style>
</head>
<body>

  <div class="profile-card">
    <h2>Profile Setting</h2>
    

    <form action="save_profile.php" method="POST" enctype="multipart/form-data">
      <div class="form-group">
        <label for="fname">First Name</label>
        <input type="text" id="fname" name="fname" value="lavishetty">
      </div>

      <div class="form-group">
        <label for="lname">Last Name</label>
        <input type="text" id="lname" name="lname" value="nikhilesh">
      </div>

      <div class="form-group">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" value="nikhilesh@gmail.com">
      </div>

      <div class="form-group">
        <label for="contact">Contact Number</label>
        <input type="tel" id="contact" name="contact" value="9316184016">
      </div>

      <div class="form-group">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" value="7777777">
      </div>

      

      <button type="submit" class="save-btn">Save Settings</button>
    </form>
  </div>

</body>
</html>