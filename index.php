<?php
require_once 'db_connect.php';

// Get statistics for dashboard
$stats = [
    'total_products' => countProducts(),
    'total_entrepreneurs' => countEntrepreneurs(),
    'total_categories' => count(getAllCategories())
];

// Get featured products (latest 6 products)
$featured_products = getProducts(6, 0);

// Get featured entrepreneurs (latest 4 entrepreneurs)
$featured_entrepreneurs = getEntrepreneurs(4, 0);

// Get all categories for display
$categories = getAllCategories();
?>

<?php include 'header.php'; ?>

<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="hero-content">
                    <h1 class="hero-title fade-in">UNIBIZHUB</h1>
                    <p class="hero-subtitle fade-in">Empowering University Students to Become Entrepreneurs</p>
                    <p class="lead fade-in">Discover amazing products and services from talented student entrepreneurs. Support local campus businesses and find unique items you won't find anywhere else.</p>
                    <div class="d-flex gap-3 flex-wrap fade-in">
                       
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="hero-image text-center fade-in">
                     <img src="./images/1.png" 
                     alt="UNIBIZHUB Hero Image" 
                     class="img-fluid hero-img-custom">
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Call to Action -->
<section class="py-5 bg-primary" style="color: #1a365d;">
    <div class="container text-center">
        <h2 class="fw-bold mb-3">Ready to Join UNIBIZHUB?</h2>
        <p class="lead mb-4">Start your entrepreneurial journey or discover amazing student products today!</p>
        
        <!-- Additional descriptive text -->
        <div class="row mb-4">
            <div class="col-md-4 mb-3">
                <div class="text-white">
                    <i class="fas fa-graduation-cap fa-2x mb-2"></i>
                    <h5 class="fw-bold">For Students</h5>
                    <p class="small">Turn your ideas into reality and start your business journey</p>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="text-white">
                    <i class="fas fa-shopping-cart fa-2x mb-2"></i>
                    <h5 class="fw-bold">For Customers</h5>
                    <p class="small">Support student entrepreneurs and find unique products</p>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="text-white">
                    <i class="fas fa-users fa-2x mb-2"></i>
                    <h5 class="fw-bold">For Community</h5>
                    <p class="small">Build connections and grow together in our marketplace</p>
                </div>
            </div>
        </div>
        
        <div class="d-flex gap-3 justify-content-center flex-wrap">
            <?php if (!isLoggedIn()): ?>
                <a href="register.php?role=Entrepreneur" class="btn btn-light btn-lg">
                    <i class="fas fa-store me-2"></i>Start Selling
                </a>
                <a href="register.php" class="btn btn-outline-light btn-lg">
                    <i class="fas fa-shopping-cart me-2"></i>Start Shopping
                </a>
            <?php else: ?>
                <?php if (getUserRole() === 'Customer'): ?>
                    <a href="products.php" class="btn btn-light btn-lg">
                        <i class="fas fa-shopping-bag me-2"></i>Browse Products
                    </a>
                    <a href="register.php?role=Entrepreneur" class="btn btn-outline-light btn-lg">
                        <i class="fas fa-store me-2"></i>Become a Seller
                    </a>
                <?php else: ?>
                    <a href="products.php" class="btn btn-light btn-lg">
                        <i class="fas fa-shopping-bag me-2"></i>Browse Products
                    </a>
                    <a href="seller/dashboard.php" class="btn btn-outline-light btn-lg">
                        <i class="fas fa-tachometer-alt me-2"></i>My Dashboard
                    </a>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
</section>
<!-- Statistics Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row text-center">
            <div class="col-md-4 mb-4">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-shopping-bag"></i>
                    </div>
                    <div class="stat-value"><?php echo number_format($stats['total_products']); ?></div>
                    <div class="stat-label">Active Products</div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stat-value"><?php echo number_format($stats['total_entrepreneurs']); ?></div>
                    <div class="stat-label">Student Entrepreneurs</div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-tags"></i>
                    </div>
                    <div class="stat-value"><?php echo number_format($stats['total_categories']); ?></div>
                    <div class="stat-label">Categories</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Featured Categories -->
<section class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Browse Categories</h2>
            <p class="text-muted">Find exactly what you're looking for</p>
        </div>
        
        <div class="row g-3">
            <?php foreach (array_slice($categories, 0, 8) as $category): ?>
                <div class="col-md-3 col-6">
                    <a href="products.php?category=<?php echo $category['category_id']; ?>" 
                       class="text-decoration-none">
                        <div class="card h-100 border-0 shadow-sm category-card">
                            <div class="card-body text-center">
                                <div class="category-icon mb-3">
                                    <?php
                                    $icon = 'fa-box';
                                    switch(strtolower($category['category_name'])) {
                                        case 'men': $icon = 'fa-male'; break;
                                        case 'women': $icon = 'fa-female'; break;
                                        case 'handcraft': $icon = 'fa-palette'; break;
                                        case 'digital product': $icon = 'fa-laptop'; break;
                                        case 'electronics': $icon = 'fa-mobile-alt'; break;
                                        case 'books & stationery': $icon = 'fa-book'; break;
                                        case 'food & beverages': $icon = 'fa-utensils'; break;
                                        case 'sports & fitness': $icon = 'fa-dumbbell'; break;
                                    }
                                    ?>
                                    <i class="fas <?php echo $icon; ?> fa-3x text-primary"></i>
                                </div>
                                <h6 class="card-title"><?php echo htmlspecialchars($category['category_name']); ?></h6>
                                <p class="card-text small text-muted"><?php echo truncateText($category['description'], 50); ?></p>
                            </div>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
        
        <div class="text-center mt-4">
            <a href="products.php" class="btn btn-outline-primary">
                <i class="fas fa-th me-2"></i>View All Products
            </a>
        </div>
    </div>
</section>

<!-- Featured Products -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Featured Products</h2>
            <p class="text-muted">Discover amazing items from our student entrepreneurs</p>
        </div>
        
        <div class="row g-4">
            <?php if (empty($featured_products)): ?>
                <div class="col-12 text-center">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        No products available yet. Be the first to start selling!
                    </div>
                </div>
            <?php else: ?>
                <?php foreach ($featured_products as $product): ?>
                    <div class="col-lg-4 col-md-6">
                        <div class="card product-card h-100">
                            <?php if ($product['stock_quantity'] <= 5): ?>
                                <div class="product-badge">Low Stock</div>
                            <?php endif; ?>
                            
                            <img src="<?php echo !empty($product['product_image']) ? $product['product_image'] : 'https://via.placeholder.com/300x200/f0f0f0/666666?text=No+Image'; ?>" 
                                 class="card-img-top" 
                                 alt="<?php echo htmlspecialchars($product['product_name']); ?>">
                            
                            <div class="card-body">
                                <h5 class="card-title"><?php echo truncateText($product['product_name'], 30); ?></h5>
                                <p class="card-text"><?php echo truncateText($product['description'], 80); ?></p>
                                
                                <div class="product-price">
                                    <?php echo formatPrice($product['price']); ?>
                                </div>
                                
                                <div class="product-seller">
                                    <i class="fas fa-store me-1"></i>
                                    <?php echo htmlspecialchars($product['seller_name']); ?>
                                </div>
                                
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="badge bg-primary">
                                        <?php echo htmlspecialchars($product['category_name'] ?: 'Uncategorized'); ?>
                                    </span>
                                    <span class="text-muted small">
                                        <?php echo $product['stock_quantity']; ?> in stock
                                    </span>
                                </div>
                            </div>
                            
                            <div class="card-footer bg-transparent">
                                <div class="d-grid">
                                    <a href="#" class="btn btn-primary btn-sm">
                                        <i class="fas fa-shopping-cart me-2"></i>Add to Cart
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        
        <div class="text-center mt-4">
            <a href="products.php" class="btn btn-primary">
                <i class="fas fa-eye me-2"></i>View All Products
            </a>
        </div>
    </div>
</section>

<!-- Featured Entrepreneurs -->
<section class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Featured Entrepreneurs</h2>
            <p class="text-muted">Meet the talented students behind our marketplace</p>
        </div>
        
        <div class="row g-4">
            <?php if (empty($featured_entrepreneurs)): ?>
                <div class="col-12 text-center">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        No entrepreneurs registered yet. Be the first to join!
                    </div>
                </div>
            <?php else: ?>
                <?php foreach ($featured_entrepreneurs as $entrepreneur): ?>
                    <div class="col-lg-3 col-md-6">
                        <div class="card entrepreneur-card h-100">
                            <div class="entrepreneur-info">
                                <div class="entrepreneur-name"><?php echo htmlspecialchars($entrepreneur['full_name']); ?></div>
                                <div class="entrepreneur-details">
                                    <div><?php echo htmlspecialchars($entrepreneur['faculty']); ?></div>
                                    <div>ID: <?php echo htmlspecialchars($entrepreneur['student_id']); ?></div>
                                </div>
                            </div>
                            
                            <div class="card-body">
                                <h6 class="card-title"><?php echo htmlspecialchars($entrepreneur['shop_name']); ?></h6>
                                <p class="card-text small"><?php echo truncateText($entrepreneur['shop_description'], 60); ?></p>
                                
                                <?php if (!empty($entrepreneur['category_name'])): ?>
                                    <span class="badge bg-warning text-dark mb-2">
                                        <?php echo htmlspecialchars($entrepreneur['category_name']); ?>
                                    </span>
                                <?php endif; ?>
                            </div>
                            
                            <div class="card-footer bg-transparent">
                                <a href="#" class="btn btn-outline-primary btn-sm w-100">
                                    <i class="fas fa-eye me-2"></i>View Shop
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        
        <div class="text-center mt-4">
            <a href="entrepreneurs.php" class="btn btn-outline-primary">
                <i class="fas fa-users me-2"></i>View All Entrepreneurs
            </a>
        </div>
    </div>
</section>

<!-- How It Works -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold">How UNIBIZHUB Works</h2>
            <p class="text-muted">Simple steps to get started</p>
        </div>
        
        <div class="row g-4">
            <div class="col-md-4">
                <div class="text-center">
                    <div class="step-icon mb-3">
                        <i class="fas fa-user-plus fa-3x text-primary"></i>
                    </div>
                    <h5>1. Register</h5>
                    <p class="text-muted">Create your account as a customer or entrepreneur. Students get verified for selling.</p>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="text-center">
                    <div class="step-icon mb-3">
                        <i class="fas fa-store fa-3x text-success"></i>
                    </div>
                    <h5>2. Set Up Shop</h5>
                    <p class="text-muted">Entrepreneurs create their store and list products. Customers browse available items.</p>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="text-center">
                    <div class="step-icon mb-3">
                        <i class="fas fa-exchange-alt fa-3x text-warning"></i>
                    </div>
                    <h5>3. Buy & Sell</h5>
                    <p class="text-muted">Customers purchase products and support student businesses. Safe and secure transactions.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Testimonials -->
<section class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold">What Our Community Says</h2>
            <p class="text-muted">Real experiences from UNIBIZHUB users</p>
        </div>
        
        <div class="row g-4">
            <div class="col-lg-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body">
                        <div class="mb-3">
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                        </div>
                        <p class="card-text">"UNIBIZHUB helped me start my handmade jewelry business. I've made over Rs 10,000 in just 2 months!"</p>
                        <footer class="blockquote-footer">
                            <strong>Sahan Lakshan</strong>
                            <small>Entrepreneur, Faculty of ART</small>
                        </footer>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body">
                        <div class="mb-3">
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                        </div>
                        <p class="card-text">"Love supporting fellow students! Found unique study materials and handmade crafts here."</p>
                        <footer class="blockquote-footer">
                            <strong>Amaya kethaki</strong>
                            <small>Customer, Engineering Student</small>
                        </footer>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body">
                        <div class="mb-3">
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                        </div>
                        <p class="card-text">"The platform is easy to use and the community is very supportive. Highly recommended!"</p>
                        <footer class="blockquote-footer">
                            <strong>Vishal rathnayaka</strong>
                            <small>Entrepreneur, Faculty of Management</small>
                        </footer>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>



<style>
.hero-section {
    background: var(--dark-gradient);
    color: white;
    padding: 100px 0;
    position: relative;
    overflow: hidden;
}

.stat-card {
    background: white;
    border-radius: 15px;
    padding: 2rem;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    text-align: center;
    transition: all 0.3s ease;
}

.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.15);
}

.step-icon {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    background: linear-gradient(135deg, #ff6b35, #f7931e);
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto;
    color: white;
}

.category-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.15);
}

.fade-in {
    animation: fadeIn 0.8s ease-in;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(30px); }
    to { opacity: 1; transform: translateY(0); }
}

.hero-img-custom {
    max-width: 120%;
    height: auto;
    transform: scale(1.1);
    transition: transform 0.3s ease;
}

.hero-img-custom:hover {
    transform: scale(1.15);
}
</style>

<?php include 'footer.php'; ?>
