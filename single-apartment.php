<?php get_header(); ?>
<div class="apartment-page">
    <!-- Navigation -->
    <nav class="navbar">
        <?php
        wp_nav_menu(array(
            'theme_location' => 'apartment-menu',
            'menu_class' => 'navbar-nav',
        ));
        ?>
    </nav>
    <header class="apartment-header">
        <h1><?php the_title(); ?></h1>
        <p><?php echo get_post_meta(get_the_ID(), 'apartment_city', true); ?></p>
    </header>

    <div class="gallery-info-container">
        <!-- Thumbnails Section -->
        <div class="thumbnails">
        <?php
        $gallery_images = rwmb_meta('apartment_gallery', array('size' => 'thumbnail')); // Get uploaded images
        if ($gallery_images) :
            foreach ($gallery_images as $image) :
        ?>
            <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['title']); ?>" data-label="<?php echo esc_attr($image['title']); ?>">
        <?php endforeach; else : ?>
            <p>No additional images available.</p>
        <?php endif; ?>
    </div>


        <!-- Main Image Section -->
        <div class="main-image">
            <?php if (has_post_thumbnail()) : ?>
                <img id="current-image" src="<?php echo get_the_post_thumbnail_url(); ?>" alt="<?php the_title(); ?>">
            <?php else : ?>
                <img id="current-image" src="<?php echo get_template_directory_uri(); ?>/assets/img/default-image.webp" alt="Default Image">
            <?php endif; ?>
            <p id="image-label"><?php the_title(); ?></p>
            <button id="fullscreen-btn" title="View Gallery">
                <i class="fas fa-expand"></i>
            </button>
        </div>

        <!-- Fullscreen Gallery -->
        <div id="fullscreen-gallery" class="gallery-modal">
            <button class="close-btn"><i class="fas fa-times"></i></button>

            <!-- Left Arrow -->
            <button class="arrow-btn left-arrow" title="Previous">
                <i class="fas fa-chevron-left"></i>
            </button>

            <!-- Right Arrow -->
            <button class="arrow-btn right-arrow" title="Next">
                <i class="fas fa-chevron-right"></i>
            </button>

            <!-- Image Container -->
            <div class="gallery-images">
                <?php
                if ($gallery_images) :
                    foreach ($gallery_images as $image) :
                ?>
                    <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['title']); ?>">
                <?php endforeach; else : ?>
                    <p>No additional images available.</p>
                <?php endif; ?>
            </div>

            <!-- Image Indicator -->
            <div class="gallery-indicator"></div>
        </div>

        <div class="quick-info-container">
            <!-- Quick Info Section -->
            <div class="quick-info">
                <h2>Quick Info</h2>
                <p><i class="fas fa-bed"></i> <strong>Rooms:</strong> <span><?php echo get_post_meta(get_the_ID(), 'apartment_rooms', true); ?></span></p>
                <p><i class="fas fa-ruler-combined"></i> <strong>Size:</strong> <span><?php echo get_post_meta(get_the_ID(), 'apartment_size', true); ?> sqm</span></p>
                <p><i class="fas fa-tag"></i> <strong>Price:</strong> <span><?php echo number_format((float) get_post_meta(get_the_ID(), 'apartment_price', true), 0, '', ','); ?> SEK</span></p>
                <p><i class="fas fa-info-circle"></i> <strong>Status:</strong> <span><?php echo ucfirst(get_post_meta(get_the_ID(), 'apartment_status', true)); ?></span></p>
            </div>

            <!-- Map Section -->
            <div id="map"></div>
            <?php
                $latitude = get_post_meta(get_the_ID(), 'apartment_latitude', true);
                $longitude = get_post_meta(get_the_ID(), 'apartment_longitude', true);
            ?>
            <script>
                const apartmentLatitude = <?php echo json_encode($latitude); ?>;
                const apartmentLongitude = <?php echo json_encode($longitude); ?>;
            </script>
        </div>
    </div>

    <section class="details-section" id="dsec">
        <h2>Apartment Details</h2>
        <?php the_content(); ?>
        <ul>
            <li>High-speed internet connectivity</li>
            <li>Smart home technology</li>
            <li>24/7 security and concierge service</li>
            <li>Private parking available</li>
            <li>Pet-friendly community</li>
        </ul>
    </section>

    <section class="bookings" id="bookings">
        <h2>Are You Interested?</h2>
        <p>Check out the available showings below and book your visit today!</p>
        <div class="showings">
            <h3>Upcoming Showings</h3>
            <div class="showing">
                <div class="title-info">
                    <h4>Open House</h4>
                    <button class="info-btn" title="An open house where potential buyers can visit the property without needing to book an appointment in advance.">?</button>
                </div>
                <div class="details">
                    <p class="date"><i class="fas fa-calendar-alt"></i> 20th December</p>
                    <p class="time"><i class="fas fa-clock"></i> 14:00 - 15:00</p>
                    <p class="host"><i class="fas fa-user"></i> John Doe</p>
                </div>
                <button class="book-btn">Open</button>
            </div>
            <div class="showing">
                <div class="title-info">
                    <h4>Private Showing</h4>
                    <button class="info-btn" title="A private viewing arranged for a specific buyer or a small group, often by appointment.">?</button>
                </div>
                <div class="details">
                    <p class="date"><i class="fas fa-calendar-alt"></i> 20th December</p>
                    <p class="time"><i class="fas fa-clock"></i> 16:00 - 17:00</p>
                    <p class="host"><i class="fas fa-user"></i> Jane Smith</p>
                </div>
                <button class="book-btn">Book</button>
            </div>
        </div>

        <div class="brokers" id="brokers">
            <h3>Contact Our Real Estate Brokers</h3>
            <div class="broker-cards">
                <div class="broker-card">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/broker1.png" alt="Real Estate Agent">
                    <div class="broker-details">
                        <h4>John Doe</h4>
                        <p class="role">Responsible Real Estate Agent</p>
                        <p><i class="fas fa-phone-alt"></i> <a href="tel:+46701234567">+46 70 123 45 67</a></p>
                        <p><i class="fas fa-envelope"></i> <a href="mailto:johndoe@example.com">johndoe@example.com</a></p>
                    </div>
                </div>
                <div class="broker-card">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/broker2.webp" alt="Assistant">
                    <div class="broker-details">
                        <h4>Jane Smith</h4>
                        <p class="role">Assistant</p>
                        <p><i class="fas fa-phone-alt"></i> <a href="tel:+46707654321">+46 70 765 43 21</a></p>
                        <p><i class="fas fa-envelope"></i> <a href="mailto:janesmith@example.com">janesmith@example.com</a></p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php
    // Include the Luxury Apartments section
    get_template_part('template-parts/luxury-apartments');
    ?>
</div>
<?php get_footer(); ?>
