<?php get_header(); ?>

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
                    <a href="<?php echo get_permalink($project_id); ?>" class="project-link">
                        <img src="<?php echo get_the_post_thumbnail_url(); ?>" alt="<?php the_title(); ?>">
                        </a>
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
                    <a href="<?php echo esc_url(get_permalink()); ?>" class="project-link">
                        <img src="<?php echo esc_url(get_the_post_thumbnail_url()); ?>" alt="<?php echo esc_attr(get_the_title()); ?>">
                        <p><?php echo esc_html(get_the_title()); ?> - Completed in <?php echo esc_html(get_the_date('Y')); ?></p>
                    </a>
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

<?php
    // Include the Luxury Apartments section
    get_template_part('template-parts/luxury-apartments');
?>


    





<?php get_footer(); ?>
