<?php get_header(); ?>

<?php
// Get project details
$project_title = get_the_title();
$project_date = get_the_date('F Y');
$hero_image = get_the_post_thumbnail_url(null, 'full');
$description = get_the_content();
$constructor_name = get_post_meta(get_the_ID(), 'constructor_name', true);
$start_date = get_post_meta(get_the_ID(), 'start_date', true);
$end_date = get_post_meta(get_the_ID(), 'end_date', true);

// Fetch the construction images
$construction_images = rwmb_meta('construction_images', array('size' => 'thumbnail'));

?>

<!-- Hero Section -->
<header class="hero" style="background: url('<?php echo $hero_image; ?>') center/cover no-repeat;">
    
    <div class="overlay"></div>
    <div class="container">
   

        <h1 class="fade-in"><?php echo $project_title; ?></h1>
        <p class="fade-in">Completed in <?php echo $project_date; ?></p>
    </div>
</header>
    <!-- Navigation -->
    <nav class="navbar">
        <?php
        wp_nav_menu(array(
            'theme_location' => 'project-menu',
            'menu_class' => 'navbar-nav',
        ));
        ?>
    </nav>
<!-- Project Details Section -->
<section class="project-details">
    <div class="container">
        <div class="details-wrapper">
            <!-- Main Description -->
            <div class="project-description">
                <h2>Project Overview</h2>
                <p><?php echo nl2br($description); ?></p>
            </div>

            <!-- Info Area -->
            <div class="project-info">
                <h2>Project Information</h2>
                <ul>
                    <li><i class="fas fa-hard-hat"></i> <strong>Constructor:</strong> <?php echo $constructor_name ?: 'Unknown'; ?></li>
                    <li><i class="fas fa-calendar-alt"></i> <strong>Start Date:</strong> <?php echo $start_date ?: 'Not specified'; ?></li>
                    <li><i class="fas fa-calendar-check"></i> <strong>Completion Date:</strong> <?php echo $end_date ?: 'Not specified'; ?></li>
                </ul>
            </div>
        </div>
    </div>
</section>

<?php if (!empty($construction_images)) : ?>
<section class="construction-gallery" id="cgallery">
    <div class="container">
        <h2>Construction Gallery</h2>
        <div class="gallery-grid">
        <?php foreach ($construction_images as $image_id => $image_data) : ?>
    <div class="gallery-item">
        <img src="<?php echo esc_url($image_data['url']); ?>" alt="<?php echo esc_attr($image_data['alt']); ?>">
    </div>
<?php endforeach; ?>
        </div>
    </div>
</section>
<?php else : ?>
<p class="no-images">No construction images available.</p>
<?php endif; ?>


<!-- Additional Features -->
<section class="additional-features">
    <div class="container">
        <div class="features-grid">
            <!-- Sustainability Feature -->
            <div class="feature-item">
                <i class="fas fa-leaf"></i>
                <h3>Sustainability</h3>
                <p>This project was built with a focus on eco-friendly materials and sustainable practices.</p>
            </div>

            <!-- Innovation Feature -->
            <div class="feature-item">
                <i class="fas fa-lightbulb"></i>
                <h3>Innovation</h3>
                <p>Integrated state-of-the-art technologies to ensure energy efficiency and comfort.</p>
            </div>

            <!-- Community Impact -->
            <div class="feature-item">
                <i class="fas fa-users"></i>
                <h3>Community Impact</h3>
                <p>Designed to foster a sense of community while meeting urban development needs.</p>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="call-to-action">
    <div class="container">
        <h2>Interested in Our Projects?</h2>
        <p>Contact us to discuss your ideas and let us bring them to life!</p>
        <a href="#contact" class="btn">Get in Touch</a>
    </div>
</section>

<?php get_footer(); ?>
