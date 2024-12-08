<!-- Apartments Section (After Job Opportunity) -->
<section id="luxury-apartments" class="fade-in scroll-effect">
    <div class="container">
        <h2 class="section-title">Luxury Homes for Sale</h2>
        <p class="section-description">Discover stunning homes in Sweden. Browse available options below.</p>
        
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
                    $permalink = get_permalink($apartment_id);

            ?>

                    <div class="apartment-item <?php echo $status === 'sold' ? 'sold' : ''; ?>">
                    <a href="<?php echo esc_url($permalink); ?>" class="apartment-link">

                        <div class="ribbon"><?php echo ucfirst($status); ?></div>
                        <img src="<?php echo get_the_post_thumbnail_url($apartment_id); ?>" alt="<?php the_title(); ?>">
                        <div class="overlay">
                            <h3><?php the_title(); ?>, <?php echo ucfirst($city); ?></h3>
                            <p><?php echo $rooms; ?> Rooms • <?php echo $size; ?> sqm</p>
                            <p>Price: <?php echo $formatted_price; ?></p>
                        </div>
                        </a>

                    </div>
            <?php
                endif;
            endforeach;
            wp_reset_postdata();
            ?>
        </div>
    </div>
        </section>