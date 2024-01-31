<?php
/**
 * The template for displaying the Front Page
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

<main id="primary" class="site-main home-page">

	<?php
	while (have_posts()):
		the_post();
		?>

		<section class="home-intro">
			<h1>
				<?php the_title(); ?>
			</h1>
			<?php the_post_thumbnail('large'); ?>
			<?php
			if (function_exists('get_field')) {
				if (get_field('top_section_heading')) {
					echo "<h2>";
					the_field('top_section_heading');
					echo "</h2>";
				}
				if (get_field('top_section')) {
					echo "<p>";
					the_field('top_section');
					echo "</p>";
				}
			}
			?>
		</section>

		<section class="home-work">
			<h2>Featured Works</h2>
			<div class="home-work-container">
				<?php
				// Class demo
				// Add an ACF relationship field and assign it to the Home page
				if (function_exists('get_field')):
					$featured_works = get_field('featured_works_acf');
					if ($featured_works):
						foreach ($featured_works as $post):
							setup_postdata($post);
							?>
							<article class="front-portfolio">
								<a href="<?php the_permalink(); ?>">
									<?php the_post_thumbnail('medium'); ?>
									<h3>
										<?php the_title(); ?>
									</h3>
								</a>
							</article>
							<?php
						endforeach;
						wp_reset_postdata();
					endif;
				endif;
				?>
			</div>

			<!-- OLD CODE -->
			<!-- <?php

			$args = array(
				'post_type' => 'fwd-work',
				'posts_per_page' => 4,
				'tax_query' => array(
					array(
						'taxonomy' => 'fwd-featured',
						'field' => 'slug',
						'terms' => 'front-page',
					)
				),
			);

			$query = new WP_Query($args);
			if ($query->have_posts()) {

				while ($query->have_posts()) {
					$query->the_post();
					?>
					<article>
						<a href=" <?php the_permalink(); ?> ">
							<h3>
								<?php the_post_thumbnail('medium'); ?><br>
								<?php the_title(); ?>
							</h3>
						</a>
					</article>
					<?php
				}
				wp_reset_postdata();
				?>
			</section>
			<?php
			}
			?> -->

			<!-- <section class="home-work"></section> -->

			<section class="home-left">
				<?php
				if (function_exists('get_field')) {
					if (get_field('left_section_heading')) {
						echo "<h2>";
						the_field('left_section_heading');
						echo "</h2>";
					}
					if (get_field('left_section_heading')) {
						echo "<p>";
						the_field('left_section_content');
						echo "</p>";
					}
				}
				?>
			</section>

			<section class="home-right">
				<?php
				if (function_exists('get_field')) {
					if (get_field('right_section_heading')) {
						echo "<h2>";
						the_field('right_section_heading');
						echo "</h2>";
					}
					if (get_field('right_section_content')) {
						echo "<p>";
						the_field('right_section_content');
						echo "</p>";
					}
				}
				?>
			</section>

			<section class="home-slider">
				<?php
				$args = array(
					'post_type' => 'fwd-testimonial',
					'posts_per_page' => -1
				);

				$query = new WP_Query($args);

				if ($query->have_posts()):
					?>
					<div class="swiper">
						<div class="swiper-wrapper">
							<?php
							while ($query->have_posts()):
								$query->the_post();
								?>
								<div class="swiper-slide">
									<?php
									the_content();
									?>
								</div>
								<?php
							endwhile;
							wp_reset_postdata();
							?>
						</div>
						<div class="swiper-pagination"></div>
						<!-- if want to have buttons, style hthem later.
						want transparent background. btns for accessibility -->
						<button class="swiper-button-prev"></button>
						<button class="swiper-button-next"></button>
					</div>
					<?php
				endif;
				?>
			</section>

			<section class="home-blog">
				<h2>
					<?php esc_html_e('Latest Blog Posts', 'fwd') ?>
				</h2>
				<div class="home-blog-container">
					<?php
					$args = array(
						'post_type' => 'post',
						'posts_per_page' => 4
					);

					$blog_query = new WP_Query($args);

					if ($blog_query->have_posts()) {
						while ($blog_query->have_posts()) {
							$blog_query->the_post();
							?>

							<article class="blog-article">
								<a href="<?php the_permalink(); ?>">
									<?php
									the_post_thumbnail('latest-blog-teaser');
									?>
									<h3>
										<?php the_title(); ?>
									</h3>
									<h4>
										<?php echo get_the_date('F j, Y'); ?>
									</h4>
								</a>
							</article>

							<?php
						}
					}
					wp_reset_postdata();
					?>
				</div>
			</section>

			<?php
	endwhile; // End of the loop.
	?>

</main><!-- #primary -->

<?php
get_footer();
