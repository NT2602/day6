<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <?php include_once('../layout/styles.php'); ?>
  <title>Create Account</title>
</head>
<main class="container">
<body>
  <div class="container">
        <br>
        <br>
    </div>
  <?php include_once('../layout/partials/header.php'); ?>
  <h1>Create Account</h1><form method="POST" action="createaccountf.php">
        <div class="mb-3">
          <label for="username" class="form-label">Username</label>
          <input type="text" id="username" name="username" class="form-control" required>
        </div>

        <div class="mb-3">
          <label for="email" class="form-label">Email</label>
          <input type="email" id="email" name="email" class="form-control" required>
        </div>

        <div class="mb-3">
          <label for="password" class="form-label">password</label>
          <input type="password" id="password" name="password" class="form-control" required>
        </div>

        <div class="mb-3">
          <label for="confirm_password" class="form-label">confirm_password</label>
          <input type="password" id="confirm_password" name="confirm_password" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary w-100">Create Account</button>
      </form>

      <p class="text-center mt-3">Already have Account <a href="/demoshop/frontend/pages/login.php">Login</a></p>
</body>
</main>
</html>
<?php include_once('../layout/partials/footer.php'); ?>
<?php include_once('../layout/scripts.php'); ?>