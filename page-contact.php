<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package FWD_Starter_Theme
 */

get_header();
?>

<main id="primary" class="site-main">

	<?php while (have_posts()):
		the_post();
		get_template_part('template-parts/content', 'page');
		?>

		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

			<div class="entry-content">
				<?php

				if (function_exists('get_field')) {

					if (get_field('contact_heading')) {
						echo "<h2>";
						esc_html(the_field('contact_heading'));
						echo "</h2>";
					}

					if (get_field('contact_address_content')) {
						echo "<p>";
						esc_html(the_field('contact_address_content'));
						echo "</p>";
					}

					if (get_field('contact_email_field')) {
						echo "<p>";
						esc_html(the_field('contact_email_field'));
						echo "</p>";
					}
				}
				?>
			</div>

		</article>

	<?php endwhile; // End of the loop. ?>

</main>

<?php
get_sidebar();
get_footer();
