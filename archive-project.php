<?php /* Template Name: Projects Page */ ?>
<?php get_header(); ?>

<!-- Hero Section -->
<header class="hero">
    <div class="overlay"></div>
    <div class="container">
        <h1 class="fade-in">Our Projects</h1>
        <p class="fade-in">Explore our finest achievements in construction and design.</p>
    </div>
</header>

<!-- Navigation -->
<nav class="navbar">
    <?php
    wp_nav_menu(array(
        'theme_location' => 'primary',
        'menu_class' => 'navbar-nav',
    ));
    ?>
</nav>

<!-- Featured Projects Section -->
<section class="featured-projects">
    <h2 class="section-title scroll-effect">Featured Projects</h2>
    <div class="projects-grid">
        <div class="project-card">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/apartment-city.webp" alt="Luxury Villa">
            <div class="project-details">
                <h3>Luxury Villa</h3>
                <p>Completed in 2022</p>
                <a href="#" class="btn">View Details</a>
            </div>
        </div>
        <div class="project-card">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/apartment-lakeside.webp" alt="Lakeside View Apartment">
            <div class="project-details">
                <h3>Lakeside View Apartment</h3>
                <p>Completed in 2023</p>
                <a href="#" class="btn">View Details</a>
            </div>
        </div>
        <div class="project-card">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/apartment-nature.webp" alt="Eco-Friendly House">
            <div class="project-details">
                <h3>Eco-Friendly House</h3>
                <p>Completed in 2021</p>
                <a href="#" class="btn">View Details</a>
            </div>
        </div>
    </div>
</section>

<!-- Latest Projects Section -->
<section class="latest-projects">
    <h2 class="section-title slide-in scroll-effect">Our Latest Projects</h2>
    <div class="slider-container">
        <div class="slider">
            <div class="slide">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/latest1.jpg" alt="Luxury Skyscraper">
                <p>Luxury Skyscraper - Completed in 2023</p>
            </div>
            <div class="slide">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/latest2.jpg" alt="Residential Complex">
                <p>Residential Complex - Completed in 2023</p>
            </div>
            <div class="slide">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/latest3.jpg" alt="Eco-Friendly Office">
                <p>Eco-Friendly Office - Completed in 2022</p>
            </div>
        </div>
        <!-- Navigation Arrows -->
        <button class="prev" aria-label="Previous Slide">&#10094;</button>
        <button class="next" aria-label="Next Slide">&#10095;</button>
    </div>
</section>

<!-- On-Going Projects Section -->
<section class="ongoing-projects">
    <h2 class="section-title scroll-effect">On-Going Projects</h2>
    <div class="projects-grid">
        <div class="project-card">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/ongoing1.jpg" alt="City Center Mall">
            <div class="project-details">
                <h3>City Center Mall</h3>
                <p>Expected Completion: 2024</p>
            </div>
        </div>
        <div class="project-card">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/ongoing2.jpg" alt="Green Urban Development">
            <div class="project-details">
                <h3>Green Urban Development</h3>
                <p>Expected Completion: 2025</p>
            </div>
        </div>
        <div class="project-card">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/ongoing3.jpg" alt="Luxury Resort">
            <div class="project-details">
                <h3>Luxury Resort</h3>
                <p>Expected Completion: 2026</p>
            </div>
        </div>
    </div>
</section>

<?php get_footer(); ?>
