<?php
  /*
   * Injected:
   * @var $products <array> list of product to be shown
  */
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forex VPS Admin - Products</title>
    <link rel="stylesheet" href="/assets/style.css">
  </head>
  <body class="dark-bg">
    <div class="logout-container">
      <a href="/logout/" class="btn btn-secondary">Logout</a>
    </div>
    <div class="container-lg">
      <h1 class="page-title">FOREX VPS <span class="text-accent">PRODUCTS</span></h1>
      <p class="page-subtitle">Manage your VPS plans</p>
      <div class="mt-8">
        <div class="space-y-4">
          <?php if(empty($products)): ?>
            <div class="text-center py-8">
              <p class="text-xl text-accent">No products available</p>
            </div>
          <?php else: ?>
            <?php foreach($products as $product): ?>
              <div class="card">
                <div class="flex flex-col">
                  <div>
                    <h3 class="text-xl font-bold" style="text-transform: capitalize; font-size: 1.5rem;">
                      <?= htmlspecialchars($product['name']); ?>
                    </h3>
                    <div class="mt-2 space-y-1">
                      <p class="text-accent"><?= number_format($product['ram'] / 1024, 1); ?> GB RAM</p>
                      <p><?= htmlspecialchars($product['cpu']); ?> Core<?= $product['cpu'] > 1 ? 's' : ''; ?> CPU</p>
                      <p><?= htmlspecialchars($product['disk']); ?> GB SSD Disk</p>
                      <p class="text-accent"><?= htmlspecialchars($product['os']); ?></p>
                      <?php if($product['is_dedicated_ip']): ?>
                        <p>Dedicated IP address</p>
                      <?php endif; ?>
                      <?php if($product['is_suggested']): ?>
                        <p class="text-accent font-bold">Suggested Plan</p>
                      <?php endif; ?>
                    </div>
                    <div class="mt-3">
                      <?php if(!empty($product['discount'])): ?>
                        <span class="discount-badge"><?= htmlspecialchars($product['discount']); ?>% OFF</span>
                        <span class="price-old vps-space-x">$<?= htmlspecialchars($product['price']); ?></span>
                        <?php $discounted_price = $product['price'] * (1 - ($product['discount']/100)); ?>
                        <span class="price-current">$<?= number_format($discounted_price, 2); ?>/mo</span>
                      <?php else: ?>
                        <span class="price-current">$<?= htmlspecialchars($product['price']); ?>/mo</span>
                      <?php endif; ?>
                    </div>
                  </div>
                  
                  <div class="flex justify-between items-center mt-4">
                    <a href="/product/edit/?id=<?= $product['id']; ?>" class="btn btn-edit">
                      Edit
                    </a>
                    <a href="/product/delete?id=<?= $product['id']; ?>" class="btn btn-danger">
                      Delete
                    </a>
                  </div>
                </div>
              </div>
            <?php endforeach; ?>
          <?php endif; ?>
        </div>

        <div class="mt-6 text-center">
          <a href="/product/add/" class="btn btn-primary btn-lg">
            Add New Product
          </a>
        </div>
      </div>
    </div>
  </body>
</html>

