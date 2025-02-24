<?php
  /*
  * Injected
  * @var string $action
  * @var array $product
  */
  $action = !empty($product) && !empty($product['id']) ? 'edit' : 'add';
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forex VPS Admin - Add Product</title>
    <link rel="stylesheet" href="/assets/style.css">
    </head>
  <body>
    <div class="logout-container">
      <a href="/logout/" class="btn btn-secondary">Logout</a>
    </div>
    <div class="container">
      <h1 class="page-title">
        <?= htmlspecialchars(ucfirst($action)) ?> NEW <span class="text-accent">PRODUCT</span>
      </h1>
      <p class="page-subtitle">Create a new VPS plan</p>
      <div class="mt-8">
        <form method="POST" action="/product/<?= htmlspecialchars($action) ?: 'add' ?>/" class="card">
          <?php if (!empty($product['id'])): ?>
            <input type="hidden" name="id" value="<?= htmlspecialchars($product['id']) ?>">
          <?php endif; ?>
          <div class="space-y-4">
            <div>
              <label for="name" class="form-label">Product Name</label>
              <input type="text" id="name" name="name" maxlength="50" required class="form-input" value="<?= htmlspecialchars($product['name'] ?? '') ?>">
            </div>
            <div class="grid grid-cols-2 gap-4">
              <div>
                <label for="ram" class="form-label">RAM (MB)</label>
                <input type="number" id="ram" name="ram" min="1" required class="form-input" value="<?= htmlspecialchars($product['ram'] ?? '') ?>">
              </div>
              <div>
                <label for="cpu_cores" class="form-label">CPU Cores</label>
                <input type="number" id="cpu_cores" name="cpu_cores" min="1" required class="form-input" value="<?= htmlspecialchars($product['cpu'] ?? '') ?>">
              </div>
            </div>
            <div>
              <label class="form-label">Disk Type</label>
              <div class="flex gap-4">
                <label class="flex items-center">
                  <input type="radio" name="disk_type" value="ssd" <?= (!isset($product['disk_type']) || $product['disk_type'] === 'ssd') ? 'checked' : '' ?> class="form-radio">
                  <span class="form-check-label">SSD</span>
                </label>
                <label class="flex items-center">
                  <input type="radio" name="disk_type" value="hdd" <?= (isset($product['disk_type']) && $product['disk_type'] === 'hdd') ? 'checked' : '' ?> class="form-radio">
                  <span class="form-check-label">HDD</span>
                </label>
              </div>
            </div>
            <div>
              <label for="memory_space" class="form-label">Memory Space (MB)</label>
              <input type="number" id="memory_space" name="memory_space" min="1" required class="form-input" value="<?= htmlspecialchars($product['disk'] ?? '') ?>">
            </div>
            <div>
              <label for="os" class="form-label">Operating System</label>
              <input type="text" id="os" name="os" maxlength="255" required class="form-input" value="<?= htmlspecialchars($product['os'] ?? '') ?>">
            </div>
            <div class="grid grid-cols-2 gap-4">
              <div>
                <label for="price" class="form-label">Price ($)</label>
                <input type="number" id="price" name="price" min="0" step="0.01" required class="form-input" value="<?= htmlspecialchars($product['price'] ?? '') ?>">
              </div>
              <div>
                <label for="discount" class="form-label">Discount ($)</label>
                <input type="number" id="discount" name="discount" min="0" step="0.01" required class="form-input" value="<?= htmlspecialchars($product['discount'] ?? '') ?>">
              </div>
            </div>
            <div>
              <label for="icon" class="form-label">Product Icon</label>
              <select id="icon" name="icon" required class="form-input">
                <?php
                  $icons = glob(__DIR__ . "/../../www/assets/*.svg");
                  foreach($icons as $icon) 
                  {
                    $filename = basename($icon);
                    $name     = pathinfo($filename, PATHINFO_FILENAME);
                    $value    = explode('_', $name)[0];
                    $display  = ucwords(str_replace('_', ' ', $name));

                    $selected = (isset($product['icon']) && $product['icon'] === $value) ? 'selected' : '';
                    echo "<option value=\"$value\" $selected>$display</option>";
                  }
                ?>
            </div>
            <div class="flex gap-4">
              <label class="flex items-center">
                <input type="checkbox" name="is_dedicated_ip" value="1" class="form-checkbox" <?= (!empty($product['is_dedicated_ip'])) ? 'checked' : '' ?>>
                <span class="form-check-label">Dedicated IP Address</span>
              </label>
              <label class="flex items-center">
                <input type="checkbox" name="is_suggested" value="1" class="form-checkbox" <?= (!empty($product['is_suggested'])) ? 'checked' : '' ?>>
                <span class="form-check-label">Suggested Product</span>
              </label>
            </div>
          </div>

          <div class="form-actions">
            <a href="/product/list/" class="btn btn-secondary">
              Cancel
            </a>
            <button type="submit" name="action" value="insert" class="btn btn-primary">
              Save Product
            </button>
          </div>
        </form>
      </div>
    </div>
  </body>
</html>

