<?php
function construction_theme_setup() {
    register_nav_menus(array(
        'primary'        => __('Primary Menu', 'construction-theme'),
        'project-menu'   => __('Project Menu', 'construction-theme'),
        'apartment-menu' => __('Apartment Menu', 'construction-theme'),
    ));
}
add_action('after_setup_theme', 'construction_theme_setup');

function enqueue_custom_stylesheets() {
    // Enqueue the main stylesheet (style.css)
    wp_enqueue_style('main-style', get_stylesheet_uri());

    // Enqueue a custom CSS file
    wp_enqueue_style(
        'custom-style', // Handle name
        get_template_directory_uri() . '/assets/css/animations.css', // Path to your custom CSS
        array('main-style'), // Dependencies (optional)
        '1.0', // Version number (optional)
        'all' // Media type (optional)
    );
}
add_action('wp_enqueue_scripts', 'enqueue_custom_stylesheets');

function enqueue_custom_scripts() {
    // Enqueue the main script (e.g., script.js)
    wp_enqueue_script(
        'custom-script', // Handle for the script
        get_template_directory_uri() . '/assets/js/script.js', // Path to the JS file
        array('jquery'), // Dependencies (optional)
        '1.0', // Version number (optional)
        true // Load in the footer (true) or head (false)
    );

    // Enqueue additional scripts
    wp_enqueue_script(
        'animations-script',
        get_template_directory_uri() . '/assets/js/animations.js',
        array('custom-script'), // Dependencies (optional)
        '1.0',
        true
    );
}
add_action('wp_enqueue_scripts', 'enqueue_custom_scripts');


// Register Custom Post Type for Projects
function register_projects_cpt() {
    $labels = array(
        'name'               => __('Projects', 'construction-theme'),
        'singular_name'      => __('Project', 'construction-theme'),
        'add_new'            => __('Add New Project', 'construction-theme'),
        'add_new_item'       => __('Add New Project', 'construction-theme'),
        'edit_item'          => __('Edit Project', 'construction-theme'),
        'new_item'           => __('New Project', 'construction-theme'),
        'view_item'          => __('View Project', 'construction-theme'),
        'all_items'          => __('All Projects', 'construction-theme'),
        'search_items'       => __('Search Projects', 'construction-theme'),
        'not_found'          => __('No Projects Found', 'construction-theme'),
        'not_found_in_trash' => __('No Projects Found in Trash', 'construction-theme'),
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'menu_position'      => 5,
        'menu_icon'          => 'dashicons-admin-multisite',
        'supports'           => array('title', 'editor', 'thumbnail'), // Include 'thumbnail' here
        'has_archive'        => true,
        'rewrite'            => array('slug' => 'projects'),
    );

    register_post_type('project', $args);
}
add_action('init', 'register_projects_cpt');
add_theme_support('post-thumbnails');

function project_meta_boxes($meta_boxes) {
    $meta_boxes[] = array(
        'id' => 'project_details',
        'title' => 'Project Details',
        'post_types' => array('project'),
        'fields' => array(
            array(
                'name' => 'Constructor Name',
                'id' => 'constructor_name',
                'type' => 'text',
            ),
            array(
                'name' => 'Start Date',
                'id' => 'start_date',
                'type' => 'date',
            ),
            array(
                'name' => 'End Date',
                'id' => 'end_date',
                'type' => 'date',
            ),
            array(
                'name' => 'Construction Images',
                'id' => 'construction_images',
                'type' => 'image_advanced',
                'max_file_uploads' => 10,
            ),
        ),
    );
    return $meta_boxes;
}
add_filter('rwmb_meta_boxes', 'project_meta_boxes');



function enqueue_single_project_styles() {
    if (is_singular('project')) { // Only load for single project pages
        wp_enqueue_style(
            'single-project-style',
            get_template_directory_uri() . '/assets/css/single-project.css',
            array(),
            '1.0'
        );
    }
}
add_action('wp_enqueue_scripts', 'enqueue_single_project_styles');

function enqueue_gallery_script() {
    if (is_singular('project')) { // Load only on single project pages
        wp_enqueue_script(
            'gallery-script',
            get_template_directory_uri() . '/assets/js/gallery.js',
            array(),
            '1.0',
            true // Load in the footer
        );
    }
}
add_action('wp_enqueue_scripts', 'enqueue_gallery_script');


// Add Customizer settings for main projects
function my_customizer_settings($wp_customize) {
    // Main Projects Section
    $wp_customize->add_section('main_projects_section', array(
        'title' => 'Main Projects',
        'priority' => 30,
    ));

    // Main Project 1
    $wp_customize->add_setting('main_project_1', array(
        'default' => '',
        'sanitize_callback' => 'absint',
    ));
    $wp_customize->add_control('main_project_1', array(
        'label' => 'Select Main Project 1',
        'section' => 'main_projects_section',
        'type' => 'select', // Use select instead of dropdown-pages
        'choices' => get_projects_dropdown(), // Custom function to get project list
    ));

    // Main Project 2
    $wp_customize->add_setting('main_project_2', array(
        'default' => '',
        'sanitize_callback' => 'absint',
    ));
    $wp_customize->add_control('main_project_2', array(
        'label' => 'Select Main Project 2',
        'section' => 'main_projects_section',
        'type' => 'select', // Use select instead of dropdown-pages
        'choices' => get_projects_dropdown(), // Custom function to get project list
    ));
}
add_action('customize_register', 'my_customizer_settings');

// Custom function to get a list of projects for dropdown
function get_projects_dropdown() {
    $projects = get_posts(array(
        'post_type' => 'project',
        'posts_per_page' => -1, // Show all projects
        'orderby' => 'title', // Sort by title
        'order' => 'ASC', // Ascending order
    ));

    $choices = array(); // Initialize an array for the dropdown options
    foreach ($projects as $project) {
        $choices[$project->ID] = $project->post_title; // Add project ID and title
    }
    return $choices; // Return the choices for the dropdown
}



function construction_widgets_init() {
    register_sidebar(array(
        'name' => 'Sidebar',
        'id' => 'sidebar-1',
        'before_widget' => '<div class="widget">',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>',
    ));
}
add_action('widgets_init', 'construction_widgets_init');

function custom_hero_customizer($wp_customize) {
    // Add Section
    $wp_customize->add_section('hero_section', array(
        'title' => __('Hero Section', 'construction-theme'),
        'priority' => 30,
    ));

    // Hero Title
    $wp_customize->add_setting('hero_title', array(
        'default' => 'Building the Future, Today',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('hero_title', array(
        'label' => __('Hero Title', 'construction-theme'),
        'section' => 'hero_section',
        'type' => 'text',
    ));

    // Hero Subtitle
    $wp_customize->add_setting('hero_subtitle', array(
        'default' => 'Modern solutions for all your construction needs.',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('hero_subtitle', array(
        'label' => __('Hero Subtitle', 'construction-theme'),
        'section' => 'hero_section',
        'type' => 'text',
    ));

    // Hero Button Text
    $wp_customize->add_setting('hero_button_text', array(
        'default' => 'Get in Touch',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('hero_button_text', array(
        'label' => __('Hero Button Text', 'construction-theme'),
        'section' => 'hero_section',
        'type' => 'text',
    ));

    // Hero Button Link
    $wp_customize->add_setting('hero_button_link', array(
        'default' => '#contact',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control('hero_button_link', array(
        'label' => __('Hero Button Link', 'construction-theme'),
        'section' => 'hero_section',
        'type' => 'url',
    ));
}
add_action('customize_register', 'custom_hero_customizer');


function statistics_customize_register($wp_customize) {
    // Statistics section
    $wp_customize->add_section('statistics_section', array(
        'title' => __('Statistics Section', 'mytheme'),
        'priority' => 30,
    ));

    // Add settings for the numbers
    $wp_customize->add_setting('stat_years', array(
        'default' => '20+',
        'transport' => 'postMessage',
    ));
    $wp_customize->add_setting('stat_projects', array(
        'default' => '200',
        'transport' => 'postMessage',
    ));
    $wp_customize->add_setting('stat_offices', array(
        'default' => '15',
        'transport' => 'postMessage',
    ));

    // Add settings for the descriptions
    $wp_customize->add_setting('stat_years_description', array(
        'default' => 'Years in the market',
        'transport' => 'postMessage',
    ));
    $wp_customize->add_setting('stat_projects_description', array(
        'default' => 'Completed Projects',
        'transport' => 'postMessage',
    ));
    $wp_customize->add_setting('stat_offices_description', array(
        'default' => 'Offices around the world',
        'transport' => 'postMessage',
    ));

    // Add controls for the numbers
    $wp_customize->add_control('stat_years_control', array(
        'label' => __('Years in the Market', 'mytheme'),
        'section' => 'statistics_section',
        'settings' => 'stat_years',
        'type' => 'text',
    ));
    $wp_customize->add_control('stat_projects_control', array(
        'label' => __('Completed Projects', 'mytheme'),
        'section' => 'statistics_section',
        'settings' => 'stat_projects',
        'type' => 'text',
    ));
    $wp_customize->add_control('stat_offices_control', array(
        'label' => __('Offices Around the World', 'mytheme'),
        'section' => 'statistics_section',
        'settings' => 'stat_offices',
        'type' => 'text',
    ));

    // Add controls for the descriptions
    $wp_customize->add_control('stat_years_description_control', array(
        'label' => __('Description for Years in the Market', 'mytheme'),
        'section' => 'statistics_section',
        'settings' => 'stat_years_description',
        'type' => 'text',
    ));
    $wp_customize->add_control('stat_projects_description_control', array(
        'label' => __('Description for Completed Projects', 'mytheme'),
        'section' => 'statistics_section',
        'settings' => 'stat_projects_description',
        'type' => 'text',
    ));
    $wp_customize->add_control('stat_offices_description_control', array(
        'label' => __('Description for Offices Around the World', 'mytheme'),
        'section' => 'statistics_section',
        'settings' => 'stat_offices_description',
        'type' => 'text',
    ));
}

add_action('customize_register', 'statistics_customize_register');

function testimonials_customize_register($wp_customize) {
    // Testimonials section
    $wp_customize->add_section('testimonials_section', array(
        'title' => __('Testimonials Section', 'mytheme'),
        'priority' => 40,
    ));


    // Testimonial title section
    $wp_customize->add_setting('testimonials_title', array(
        'default'     => 'What Our Clients Say',
        'transport'   => 'refresh',
    ));
    $wp_customize->add_control('testimonials_title', array(
        'label'       => __('Testimonials Section Title', 'mytheme'),
        'section'     => 'testimonials_section',
        'type'        => 'text',
    ));


    // Testimonial 1 settings
    $wp_customize->add_setting('testimonial_1_name', array(
        'default' => 'Alex J.',
        'transport' => 'postMessage',
    ));
    $wp_customize->add_setting('testimonial_1_text', array(
        'default' => 'The team was professional and efficient.',
        'transport' => 'postMessage',
    ));
    $wp_customize->add_setting('testimonial_1_image', array(
        'default' => get_template_directory_uri() . '/assets/img/alex.webp',
    ));

    // Testimonial 2 settings
    $wp_customize->add_setting('testimonial_2_name', array(
        'default' => 'Sophia L.',
        'transport' => 'postMessage',
    ));
    $wp_customize->add_setting('testimonial_2_text', array(
        'default' => 'They exceeded our expectations.',
        'transport' => 'postMessage',
    ));
    $wp_customize->add_setting('testimonial_2_image', array(
        'default' => get_template_directory_uri() . '/assets/img/sophia.jpg',
    ));

    // Testimonial 3 settings
    $wp_customize->add_setting('testimonial_3_name', array(
        'default' => 'Anna A.',
        'transport' => 'postMessage',
    ));
    $wp_customize->add_setting('testimonial_3_text', array(
        'default' => 'The team was professional and efficient.',
        'transport' => 'postMessage',
    ));
    $wp_customize->add_setting('testimonial_3_image', array(
        'default' => get_template_directory_uri() . '/assets/img/anna.jpg',
    ));

    // Add controls for the testimonials
    // Testimonial 1
    $wp_customize->add_control('testimonial_1_name_control', array(
        'label' => __('Testimonial 1 Name', 'mytheme'),
        'section' => 'testimonials_section',
        'settings' => 'testimonial_1_name',
        'type' => 'text',
    ));
    $wp_customize->add_control('testimonial_1_text_control', array(
        'label' => __('Testimonial 1 Text', 'mytheme'),
        'section' => 'testimonials_section',
        'settings' => 'testimonial_1_text',
        'type' => 'textarea',
    ));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'testimonial_1_image_control', array(
        'label' => __('Testimonial 1 Image', 'mytheme'),
        'section' => 'testimonials_section',
        'settings' => 'testimonial_1_image',
    )));

    // Testimonial 2
    $wp_customize->add_control('testimonial_2_name_control', array(
        'label' => __('Testimonial 2 Name', 'mytheme'),
        'section' => 'testimonials_section',
        'settings' => 'testimonial_2_name',
        'type' => 'text',
    ));
    $wp_customize->add_control('testimonial_2_text_control', array(
        'label' => __('Testimonial 2 Text', 'mytheme'),
        'section' => 'testimonials_section',
        'settings' => 'testimonial_2_text',
        'type' => 'textarea',
    ));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'testimonial_2_image_control', array(
        'label' => __('Testimonial 2 Image', 'mytheme'),
        'section' => 'testimonials_section',
        'settings' => 'testimonial_2_image',
    )));

    // Testimonial 3
    $wp_customize->add_control('testimonial_3_name_control', array(
        'label' => __('Testimonial 3 Name', 'mytheme'),
        'section' => 'testimonials_section',
        'settings' => 'testimonial_3_name',
        'type' => 'text',
    ));
    $wp_customize->add_control('testimonial_3_text_control', array(
        'label' => __('Testimonial 3 Text', 'mytheme'),
        'section' => 'testimonials_section',
        'settings' => 'testimonial_3_text',
        'type' => 'textarea',
    ));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'testimonial_3_image_control', array(
        'label' => __('Testimonial 3 Image', 'mytheme'),
        'section' => 'testimonials_section',
        'settings' => 'testimonial_3_image',
    )));
}

add_action('customize_register', 'testimonials_customize_register');

function contact_customize_register($wp_customize) {
    // Add Contact Section
    $wp_customize->add_section('contact_section', array(
        'title'       => __('Contact Section', 'mytheme'),
        'priority'    => 160,
    ));

    $wp_customize->add_setting('contact_section_title', array(
        'default'     => 'Contact Us',
        'transport'   => 'refresh',
    ));
    $wp_customize->add_control('contact_section_title', array(
        'label'       => __('Contact Section Title', 'mytheme'),
        'section'     => 'contact_section',
        'type'        => 'text',
    ));

    // Add Email Setting
    $wp_customize->add_setting('contact_email', array(
        'default'     => 'info@construction.com',
        'transport'   => 'refresh',
    ));
    $wp_customize->add_control('contact_email', array(
        'label'       => __('Email Address', 'mytheme'),
        'section'     => 'contact_section',
        'type'        => 'text',
    ));

    // Add Phone Number Setting
    $wp_customize->add_setting('contact_phone', array(
        'default'     => '+123 456 7890',
        'transport'   => 'refresh',
    ));
    $wp_customize->add_control('contact_phone', array(
        'label'       => __('Phone Number', 'mytheme'),
        'section'     => 'contact_section',
        'type'        => 'text',
    ));

    // Add Contact Us Text Setting
    $wp_customize->add_setting('contact_text', array(
        'default'     => 'Reach out for inquiries, collaborations, or support!',
        'transport'   => 'refresh',
    ));
    $wp_customize->add_control('contact_text', array(
        'label'       => __('Contact Us Text', 'mytheme'),
        'section'     => 'contact_section',
        'type'        => 'textarea',
    ));
}
add_action('customize_register', 'contact_customize_register');



function footer_customize_register($wp_customize) {
    // Add Footer Section
    $wp_customize->add_section('footer_section', array(
        'title'       => __('Footer Section', 'mytheme'),
        'priority'    => 200,
    ));

    // Add Footer Text Setting
    $wp_customize->add_setting('footer_text', array(
        'default'     => '&copy; 2024 Construction Company. All Rights Reserved.',
        'transport'   => 'refresh',
    ));
    $wp_customize->add_control('footer_text', array(
        'label'       => __('Footer Text', 'mytheme'),
        'section'     => 'footer_section',
        'type'        => 'textarea',
    ));
}
add_action('customize_register', 'footer_customize_register');

function job_customize_register($wp_customize) {
    // Job Opportunity Section Title
    $wp_customize->add_section('job_opportunity_section', array(
        'title'    => __('Job Opportunity Section', 'your_theme'),
        'priority' => 160,
    ));

    // Setting for the Job Opportunity Section Visibility (show/hide)
    $wp_customize->add_setting('show_job_opportunity', array(
        'default' => true,
        'transport' => 'refresh',
    ));
    $wp_customize->add_control('show_job_opportunity', array(
        'label'   => __('Show Job Opportunity Section?', 'your_theme'),
        'section' => 'job_opportunity_section',
        'type'    => 'checkbox',
    ));

    // Setting for Job Opportunity Section Title
    $wp_customize->add_setting('job_opportunity_title', array(
        'default' => 'Are you looking for a job?',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control('job_opportunity_title', array(
        'label'   => __('Job Opportunity Title', 'your_theme'),
        'section' => 'job_opportunity_section',
        'type'    => 'text',
    ));

    // Setting for Job Opportunity Section Description
    $wp_customize->add_setting('job_opportunity_description', array(
        'default' => 'We are currently looking for talented individuals to join our team. If you\'re passionate about construction and innovation, apply now!',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control('job_opportunity_description', array(
        'label'   => __('Job Opportunity Description', 'your_theme'),
        'section' => 'job_opportunity_section',
        'type'    => 'textarea',
    ));

    // Setting for Job Opportunity Button Text
    $wp_customize->add_setting('job_opportunity_button_text', array(
        'default' => 'Apply Here',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control('job_opportunity_button_text', array(
        'label'   => __('Job Opportunity Button Text', 'your_theme'),
        'section' => 'job_opportunity_section',
        'type'    => 'text',
    ));

    // Setting for Job Opportunity Button Link
    $wp_customize->add_setting('job_opportunity_button_link', array(
        'default' => '#apply',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control('job_opportunity_button_link', array(
        'label'   => __('Job Opportunity Button Link', 'your_theme'),
        'section' => 'job_opportunity_section',
        'type'    => 'url',
    ));
}
add_action('customize_register', 'job_customize_register');


function create_apartment_post_type() {
    register_post_type('apartment',
        array(
            'labels' => array(
                'name' => __('Apartments'),
                'singular_name' => __('Apartment'),
                'add_new' => __('Add New Apartment'),
                'add_new_item' => __('Add New Apartment'),
                'edit_item' => __('Edit Apartment'),
                'new_item' => __('New Apartment'),
                'view_item' => __('View Apartment'),
                'all_items' => __('All Apartments'),
            ),
            'public' => true,
            'has_archive' => true,
            'supports' => array('title', 'editor', 'thumbnail'),
            'menu_icon' => 'dashicons-building',
        )
    );
}
add_action('init', 'create_apartment_post_type');

function apartment_meta_boxes($meta_boxes) {
    $meta_boxes[] = array(
        'id' => 'apartment_details',
        'title' => __('Apartment Details', 'construction-theme'),
        'post_types' => array('apartment'),
        'fields' => array(
            array(
                'name' => __('City', 'construction-theme'),
                'id' => 'apartment_city',
                'type' => 'text',
                'desc' => __('Enter the city name'),
            ),
            array(
                'name' => __('Rooms', 'construction-theme'),
                'id' => 'apartment_rooms',
                'type' => 'number',
                'step' => '0.5',
                'desc' => __('Enter the number of rooms (e.g., 3 or 2.5)'),
            ),
            array(
                'name' => __('Size (sqm)', 'construction-theme'),
                'id' => 'apartment_size',
                'type' => 'number',
                'desc' => __('Enter the size in square meters'),
            ),
            array(
                'name' => __('Price (SEK)', 'construction-theme'),
                'id' => 'apartment_price',
                'type' => 'number',
                'desc' => __('Enter the price in SEK'),
            ),
            array(
                'name' => __('Sale Status', 'construction-theme'),
                'id' => 'apartment_status',
                'type' => 'select',
                'options' => array(
                    'forsale' => __('For Sale', 'construction-theme'),
                    'sold' => __('Sold', 'construction-theme'),
                ),
                'desc' => __('Set the sale status'),
            ), 
            array(
                'name' => __('Apartment Gallery', 'construction-theme'),
                'id' => 'apartment_gallery',
                'type' => 'image_advanced',
                'max_file_uploads' => 10,
                'desc' => __('Upload additional images for the apartment gallery.'),
            ),
            array(
                'name' => __('Latitude', 'construction-theme'),
                'id' => 'apartment_latitude',
                'type' => 'text',
                'desc' => __('Enter the latitude for the apartment location.'),
            ),
            array(
                'name' => __('Longitude', 'construction-theme'),
                'id' => 'apartment_longitude',
                'type' => 'text',
                'desc' => __('Enter the longitude for the apartment location.'),
            ),
        ),
    );
    return $meta_boxes;
}
add_filter('rwmb_meta_boxes', 'apartment_meta_boxes');

function apartment_customizer($wp_customize) {
    // Section for Featured Apartments
    $wp_customize->add_section('featured_apartments_section', array(
        'title' => __('Featured Apartments', 'construction-theme'),
        'priority' => 70,
    ));

    // Fetch apartments for selection
    $apartments = get_posts(array(
        'post_type' => 'apartment',
        'posts_per_page' => -1,
    ));

    $apartment_choices = array();
    foreach ($apartments as $apartment) {
        $apartment_choices[$apartment->ID] = $apartment->post_title;
    }

    // Apartment 1
    $wp_customize->add_setting('featured_apartment_1', array(
        'default' => '',
        'sanitize_callback' => 'absint',
    ));
    $wp_customize->add_control('featured_apartment_1', array(
        'label' => __('Featured Apartment 1', 'construction-theme'),
        'section' => 'featured_apartments_section',
        'type' => 'select',
        'choices' => $apartment_choices,
    ));

    // Apartment 2
    $wp_customize->add_setting('featured_apartment_2', array(
        'default' => '',
        'sanitize_callback' => 'absint',
    ));
    $wp_customize->add_control('featured_apartment_2', array(
        'label' => __('Featured Apartment 2', 'construction-theme'),
        'section' => 'featured_apartments_section',
        'type' => 'select',
        'choices' => $apartment_choices,
    ));

    // Apartment 3
    $wp_customize->add_setting('featured_apartment_3', array(
        'default' => '',
        'sanitize_callback' => 'absint',
    ));
    $wp_customize->add_control('featured_apartment_3', array(
        'label' => __('Featured Apartment 3', 'construction-theme'),
        'section' => 'featured_apartments_section',
        'type' => 'select',
        'choices' => $apartment_choices,
    ));
}
add_action('customize_register', 'apartment_customizer');

function enqueue_apartment_scripts() {
    if (is_singular('apartment')) { // Only load for single apartment pages
        wp_enqueue_script(
            'apartment-page-script',
            get_template_directory_uri() . '/assets/js/apartment-page.js',
            array(),
            '1.0',
            true // Load in the footer
        );
    }
}
add_action('wp_enqueue_scripts', 'enqueue_apartment_scripts');

function enqueue_leaflet() {
    wp_enqueue_style('leaflet-css', 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.css');
    wp_enqueue_script('leaflet-js', 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.js', array(), null, true);
}
add_action('wp_enqueue_scripts', 'enqueue_leaflet');

function enqueue_leaflet_map_script() {
    wp_enqueue_script('leaflet-map', get_template_directory_uri() . '/assets/js/leaflet-map.js', array('leaflet-js'), null, true);
}
add_action('wp_enqueue_scripts', 'enqueue_leaflet_map_script');


function enqueue_project_styles() {
    if (is_post_type_archive('project')) { // Only load for projects archive page
        wp_enqueue_style(
            'projects-style',
            get_template_directory_uri() . '/assets/css/projects.css',
            array(),
            '1.0'
        );
    }
}
add_action('wp_enqueue_scripts', 'enqueue_project_styles');



?>