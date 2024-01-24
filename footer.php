<?php

/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package FWD_Starter_Theme
 */

?>

<footer id="colophon" class="site-footer">
	<div class="footer-contact">
		<?php
		if (function_exists('get_field') && !(get_the_ID() == 6)) {
			if (get_field('contact_address_content', 6)) {
				echo "<p>";
				the_field('contact_address_content', 6);
				echo "</p>";
			}

			if (get_field('contact_email_field', 6)) {
				echo "<p>";
				the_field('contact_email_field', 6);
				echo "</p>";
			}
		}
		?>
	</div><!-- .footer-contact -->
	<div class="footer-menus">
		<nav class="footer-navigation">
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'footer-left',
					'menu_id' => 'header-menu',
					'menu_id' => 'footer-left',
				)
			);
			?>
			<!-- <a href="<?php echo esc_url(get_privacy_policy_url()); ?>">Privacy Policy</a>	 -->
		</nav>
		<nav class="footer-navigation">
			<?php
			wp_nav_menu(
				array(
					'menu_id' => 'footer-right',
					'theme_location' => 'footer-right',
				)
			);
			?>
			<!-- <a href="<?php echo esc_url(get_privacy_policy_url()); ?>">Privacy Policy</a>	 -->
		</nav>
	</div><!-- .footer-menus -->
	<div class="site-info">
		<?php the_privacy_policy_link() ?><br>
		<?php esc_html_e('Created by ', 'fwd'); ?><a
			href="<?php echo esc_url(__('https://wp.bcitwebdeveloper.ca/', 'fwd')); ?>">
			<?php esc_html_e('Jonathon Leathers', 'fwd'); ?>
		</a>
	</div><!-- .site-info -->
</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>

</html>