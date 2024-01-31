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

	<header class="page-header">
		<?php
		the_archive_title('<h1 class="page-title">', '</h1>');
		the_archive_description('<div class="archive-description">', '</div>');
		?>
	</header><!-- .page-header -->

	<section class="our-services">
		<!-- <h2>Our Services</h2> -->
		<?php
		while (have_posts()):
			the_post();

			$args = array(
				'post_type' => 'fwd-service',
				'posts_per_page' => -1,
				'order' => 'ASC',
				'orderby' => 'title',
			);

			$query = new WP_Query($args);

			?>

			<nav class="services-nav">
				<ul>
					<?php
					if ($query->have_posts()) {
						while ($query->have_posts()) {
							$query->the_post();

							?>
							<li>
								<a href="#<?php echo esc_attr(get_the_ID()); ?>">
									<?php esc_html(the_title()); ?>
								</a>
							</li>
							<?php
						}
						wp_reset_postdata();
					}
					?>
				</ul>
			</nav>
			<?php
			$terms = get_terms(
				array(
					'taxonomy' => 'fwd-service-category',
				)
			);

			if ($terms && !is_wp_error($terms)) {
				foreach ($terms as $term) {
					// Use $term->slug in your tax_query
					// Use $term->name to organize the posts
					$args = array(
						'post_type' => 'fwd-service',
						'posts_per_page' => -1,
						'order' => 'ASC',
						'orderby' => 'title',
						'tax_query' => array(
							array(
								'taxonomy' => 'fwd-service-category',
								'field' => 'slug',
								'terms' => $term->slug,
							)
						),
					);

					$query = new WP_Query($args);

					if ($query->have_posts()) {
						echo '<section><h2>' . esc_html($term->name) . '</h2>';

						while ($query->have_posts()) {
							$query->the_post();
							?>
							<div class="service-content">
								<?php
								if (function_exists('get_field')) {

									if (get_field('services')) {
										?>
										<div>
											<h3 id="<?php echo esc_attr(get_the_ID()); ?>">
												<?php esc_html(the_title()); ?>
											</h3>
											<?php
											esc_html(the_field('services'));
											?>
										</div>
										<?php
									}
								}
								?>
							</div>
							<?php
						}
						wp_reset_postdata();
						echo '</section>';
					}
				}
			}
		endwhile; // End of the loop.
		
		?>
	</section>

</main><!-- #primary -->

<?php
get_sidebar();
get_footer();
