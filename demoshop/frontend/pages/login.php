<?php include_once('../layout/styles.php'); ?>
<?php include_once('../layout/partials/header.php'); ?><main class="d-flex justify-content-center align-items-center" style="min-height: 100vh;">
  <div class="container" style="max-width: 400px;">
    <form action="loginf.php" method="post">
      <h1 class="h3 mb-3 fw-normal text-center">Login</h1>

      <div class="form-floating mb-3">
        <input type="text" class="form-control" name="username" id="username" placeholder="name@example.com">
        <label for="username">Username</label>
      </div>

      <div class="form-floating mb-3">
        <input type="password" class="form-control" id="password" name="password" placeholder="Password">
        <label for="password">Password</label>
      </div>

      <div class="form-check mb-3">
        <input class="form-check-input" type="checkbox" value="remember-me" id="checkDefault">
        <label class="form-check-label" for="checkDefault">Remember me</label>
      </div>

      <button class="btn btn-primary w-100 py-2" type="submit">Sign in</button>
    </form>
  </div>
</main>


<?php include_once('../layout/partials/footer.php'); ?>
<?php include_once('../layout/scripts.php'); ?>