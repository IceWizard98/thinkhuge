<?php
  /*
  * Injected
  * @var $products <array> array of products
  */
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forex VPS Pricing</title>
    <link rel="stylesheet" href="/assets/style.css">
  </head>
  
  <body>
    <div class="logout-container">
      <a href="/login/" class="btn btn-secondary">Login</a>
    </div>
    <div class="container-lg text-center">
      <h1 class="page-title">FOREX VPS <span class="text-accent">PLANS & PRICING</span></h1>
      <p class="page-subtitle">Choose a longer billing cycle to unlock special Forex VPS discounts!</p>
      <p class="page-subtitle">14-day money-back guarantee on all purchases</p>
    
      <div class="mt-8">
        <div class="card-grid">
          <?php foreach($products ?? [] as $product): ?>
            <div class="product-card">
              <div class="card <?= $product['is_suggested'] ? 'card-highlight' : '' ?>">
              <?php 
                $iconName = ($product['icon'] ?? 'empty') . '_rectangle.svg';
                $iconPath = sprintf("%s/%s",__DIR__ . "/../../www/assets", $iconName);
                if (file_exists($iconPath) && is_readable($iconPath)): 
              ?>
                <img src="/assets/<?= $iconName ?>" alt="Product icon" class="w-12 h-12">
              <?php endif; ?>
                <div class="text-xl font-bold mt-4"><?= htmlspecialchars(ucfirst($product['name'])) ?></div>
                <p class="text-accent mt-2"><?= number_format($product['ram'] / 1024, 1) ?> GB RAM</p>
                <p><?= htmlspecialchars($product['cpu']) ?> <?= $product['cpu'] > 1 ? 'Cores' : 'Core' ?> CPU</p>
                <p><?= htmlspecialchars($product['disk']) ?> GB <?= htmlspecialchars($product['memory_type']) ?> Disk</p>
                <p class="text-accent"><?= htmlspecialchars($product['os']) ?></p>
                <p><?= $product['is_dedicated_ip'] ? 'Dedicated IP addres': ' ' ?></p>
                <?php if($product['discount'] > 0): ?>
                  <div class="discount-badge"><?= htmlspecialchars($product['discount']) ?>% OFF</div>
                <?php endif; ?>
                <p class="price-old mt-2">$<?= htmlspecialchars($product['price']) ?></p>
                <p class="price-current">$<?= htmlspecialchars((string)ceil($product['price'] - ($product['price'] * $product['discount'] / 100))) ?>/mo</p>
              </div>
              <button class="btn btn-primary btn-block mt-4">Order Now</button>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </body>
</html>
