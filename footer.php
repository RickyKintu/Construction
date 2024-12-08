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
