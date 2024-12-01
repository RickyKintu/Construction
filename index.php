<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php bloginfo('name'); ?> - <?php bloginfo('description'); ?></title>
    <link rel="stylesheet" href="<?php echo get_stylesheet_uri(); ?>">
    <?php wp_head(); ?>
</head>
<body>
    <!-- Hero Section -->
    <header class="hero">
    <div class="overlay"></div>
    <div class="container">
        <h1 class="fade-in">
            <?php echo get_theme_mod('hero_title', 'Building the Future, Today'); ?>
        </h1>
        <p class="fade-in">
            <?php echo get_theme_mod('hero_subtitle', 'Modern solutions for all your construction needs.'); ?>
        </p>
        <a href="<?php echo get_theme_mod('hero_button_link', '#contact'); ?>" class="btn fade-in">
            <?php echo get_theme_mod('hero_button_text', 'Get in Touch'); ?>
        </a>
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


    <!-- Projects Section -->
    <section id="projects" class="projects">
    <h2 class="section-title scroll-effect">Our Projects</h2>
    <div class="gallery scroll-effect fade-in">
        <?php
        // Get main projects from customizer settings
        $main_project_1 = get_theme_mod('main_project_1');
        $main_project_2 = get_theme_mod('main_project_2');
        
        $projects = array($main_project_1, $main_project_2);
        
        foreach ($projects as $project_id) :
            if ($project_id) :
                $post = get_post($project_id); // Get post by ID
                setup_postdata($post);
        ?>
                <div class="card fade-in scroll-effect">
                    <img src="<?php echo get_the_post_thumbnail_url(); ?>" alt="<?php the_title(); ?>">
                    <h3><?php the_title(); ?></h3>
                    <p><?php echo get_the_date('Y'); ?></p>
                </div>
        <?php
            endif;
        endforeach;
        wp_reset_postdata();
        ?>
    </div>
</section>


    <!-- Slideshow Section -->
    <section class="slideshow">
    <h2 class="section-title slide-in scroll-effect">Our Latest Projects</h2>
    <div class="slider-container">
        <div class="slider">
            <?php
            // WP_Query to fetch the latest project
            $args = array(
                'post_type' => 'project',
                'posts_per_page' => 5, // Change this to however many projects you want to show
                'orderby' => 'date',
                'order' => 'DESC', // Latest first
            );
            $projects = new WP_Query($args);

            if ($projects->have_posts()) :
                while ($projects->have_posts()) : $projects->the_post();
            ?>
                <div class="slide">
                    <!-- Display the featured image of the project -->
                    <img src="<?php echo get_the_post_thumbnail_url(); ?>" alt="<?php the_title(); ?>">
                    <p><?php the_title(); ?> - Completed in <?php echo get_the_date('Y'); ?></p>
                </div>
            <?php
                endwhile;
                wp_reset_postdata();
            else :
            ?>
                <p>No projects found.</p>
            <?php endif; ?>
        </div>

        <!-- Navigation Arrows -->
        <button class="prev" aria-label="Previous Slide">&#10094;</button>
        <button class="next" aria-label="Next Slide">&#10095;</button>
    </div>
</section>


    

   <!-- Testimonials Section -->
<section id="testimonials" class="testimonials">
    <h2 class="section-title scroll-effect"><?php echo get_theme_mod('testimonials_title', 'What Our Clients Say'); ?></h2>
    <div class="carousel">
        <div class="testimonial-card">
            <img src="<?php echo get_theme_mod('testimonial_1_image', get_template_directory_uri() . '/assets/img/alex.webp'); ?>" alt="<?php echo get_theme_mod('testimonial_1_name', 'Alex J.'); ?>" class="testimonial-face">
            <p>"<?php echo get_theme_mod('testimonial_1_text', 'The team was professional and efficient.'); ?>"</p>
            <h4>- <?php echo get_theme_mod('testimonial_1_name', 'Alex J.'); ?></h4>
        </div>
        <div class="testimonial-card">
            <img src="<?php echo get_theme_mod('testimonial_2_image', get_template_directory_uri() . '/assets/img/sophia.jpg'); ?>" alt="<?php echo get_theme_mod('testimonial_2_name', 'Sophia L.'); ?>" class="testimonial-face">
            <p>"<?php echo get_theme_mod('testimonial_2_text', 'They exceeded our expectations.'); ?>"</p>
            <h4>- <?php echo get_theme_mod('testimonial_2_name', 'Sophia L.'); ?></h4>
        </div>
        <div class="testimonial-card">
            <img src="<?php echo get_theme_mod('testimonial_3_image', get_template_directory_uri() . '/assets/img/anna.jpg'); ?>" alt="<?php echo get_theme_mod('testimonial_3_name', 'Anna A.'); ?>" class="testimonial-face">
            <p>"<?php echo get_theme_mod('testimonial_3_text', 'The team was professional and efficient.'); ?>"</p>
            <h4>- <?php echo get_theme_mod('testimonial_3_name', 'Anna A.'); ?></h4>
        </div>
    </div>
</section>


 <!-- Statistics Section -->
 <section class="statistics fade-in scroll-effect">
    <div class="stats-container">
        <div class="stat-box">
            <h3><?php echo get_theme_mod('stat_years', '20+'); ?></h3>
            <p><?php echo get_theme_mod('stat_years_description', 'Years in the market'); ?></p>
        </div>
        <div class="stat-box">
            <h3><?php echo get_theme_mod('stat_projects', '200'); ?></h3>
            <p><?php echo get_theme_mod('stat_projects_description', 'Completed Projects'); ?></p>
        </div>
        <div class="stat-box">
            <h3><?php echo get_theme_mod('stat_offices', '15'); ?></h3>
            <p><?php echo get_theme_mod('stat_offices_description', 'Offices around the world'); ?></p>
        </div>
    </div>
</section>

    

<!-- Video Section (After Testimonials) -->
<?php if ( get_theme_mod('show_job_opportunity', true) ) : ?>
<section id="job-opportunity" class="job-opportunity fade-in scroll-effect">
    <div class="video-overlay">
        <div class="video-content">
            <h2><?php echo get_theme_mod('job_opportunity_title', 'Are you looking for a job?'); ?></h2>
            <p><?php echo get_theme_mod('job_opportunity_description', 'We are currently looking for talented individuals to join our team. If you\'re passionate about construction and innovation, apply now!'); ?></p>
            <a href="<?php echo get_theme_mod('job_opportunity_button_link', '#apply'); ?>" class="btn">
                <?php echo get_theme_mod('job_opportunity_button_text', 'Apply Here'); ?>
            </a>
        </div>
    </div>
    <video autoplay muted loop id="job-video">
        <source src="<?php echo get_template_directory_uri(); ?>/assets/videos/construction.mp4" type="video/mp4">
        Your browser does not support the video tag.
    </video>
</section>
<?php endif; ?>

<!-- Apartments Section (After Job Opportunity) -->
<section id="luxury-apartments" class="fade-in scroll-effect">
    <div class="container">
        <h2 class="section-title">Luxury Apartments for Sale</h2>
        <p class="section-description">Discover stunning apartments in Sweden. Browse available options below.</p>
        
        <div class="apartments-gallery">
            <?php
            // Fetch selected apartments from the customizer
            $featured_apartments = array(
                get_theme_mod('featured_apartment_1'),
                get_theme_mod('featured_apartment_2'),
                get_theme_mod('featured_apartment_3'),
            );

            foreach ($featured_apartments as $apartment_id) :
                if ($apartment_id) :
                    $post = get_post($apartment_id);
                    setup_postdata($post);
                    
                    // Get apartment meta values
                    $city = get_post_meta($apartment_id, 'apartment_city', true) ?: 'N/A';
                    $rooms = get_post_meta($apartment_id, 'apartment_rooms', true) ?: 'N/A';
                    $size = get_post_meta($apartment_id, 'apartment_size', true) ?: 'N/A';
                    $price = get_post_meta($apartment_id, 'apartment_price', true);
                    $status = get_post_meta($apartment_id, 'apartment_status', true) ?: 'forsale';

                    // Format price if it exists
                    $formatted_price = $price ? number_format((float) $price) . ' SEK' : 'Price Not Available';
            ?>
                    <div class="apartment-item <?php echo $status === 'sold' ? 'sold' : ''; ?>">
                        <div class="ribbon"><?php echo ucfirst($status); ?></div>
                        <img src="<?php echo get_the_post_thumbnail_url($apartment_id); ?>" alt="<?php the_title(); ?>">
                        <div class="overlay">
                            <h3><?php the_title(); ?>, <?php echo ucfirst($city); ?></h3>
                            <p><?php echo $rooms; ?> Rooms • <?php echo $size; ?> sqm</p>
                            <p>Price: <?php echo $formatted_price; ?></p>
                        </div>
                    </div>
            <?php
                endif;
            endforeach;
            wp_reset_postdata();
            ?>
        </div>
    </div>
        </section>


    

   <!-- Contact Section -->
<section id="contact" class="contact">
<h2 class="slide-in"><?php echo get_theme_mod('contact_section_title', 'Contact Us'); ?></h2>
    <div class="contact-wrapper scroll-effect">
        <div class="contact-info">
            <div class="overlay"></div>
            <div class="contact-content">
                <p><strong>Email:</strong> <?php echo get_theme_mod('contact_email', 'info@construction.com'); ?></p>
                <p><strong>Phone:</strong> <?php echo get_theme_mod('contact_phone', '+123 456 7890'); ?></p>
                <p><?php echo get_theme_mod('contact_text', 'Reach out for inquiries, collaborations, or support!'); ?></p>
            </div>
        </div>
        <form action="#" method="post" class="contact-form scroll-effect">
            <input type="text" name="name" placeholder="Your Name" required>
            <input type="email" name="email" placeholder="Your Email" required>
            <textarea name="message" placeholder="Your Message" required></textarea>
            <button type="submit" class="btn">Send Message</button>
        </form>
    </div>
</section>



    

<footer>
    <p><?php echo get_theme_mod('footer_text', '&copy; 2024 Construction Company. All Rights Reserved.'); ?></p>
</footer>

    <?php wp_footer(); ?>
</body>
</html>
