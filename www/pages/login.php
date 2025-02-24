<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forex VPS Login</title>
    <link rel="stylesheet" href="/assets/style.css">
  </head>
  <body>
    <div class="container-sm">
      <h1 class="page-title">FOREX VPS <span class="text-accent">LOGIN</span></h1>
      <p class="page-subtitle">Access your VPS dashboard</p>
      
      <div class="mt-8">
        <div class="card">
          <form method="POST" action="/login/index.php">
            <div class="space-y-4">
              <div class="form-group">
                <label for="email" class="form-label">Email address</label>
                <input type="email" name="email" id="email" required class="form-input">
              </div>
              
              <div class="form-group">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" id="password" required class="form-input">
              </div>
              
              <button type="submit" class="btn btn-primary btn-block btn-lg">
                Sign in
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </body>
</html>

