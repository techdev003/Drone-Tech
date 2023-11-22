<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 * @since Twenty Twenty-One 1.0
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<header class="entry-header alignwide ">
		<?php the_title( '<h1 class="entry-title ">', '</h1>' ); ?>
		<?php twenty_twenty_one_post_thumbnail(); ?>
	</header><!-- .entry-header -->
	<div class="container">
	<div class="row">
	<div class="entry-content col-md-8">
		<?php
		the_content();

		wp_link_pages(
			array(
				'before'   => '<nav class="page-links" aria-label="' . esc_attr__( 'Page', 'twentytwentyone' ) . '">',
				'after'    => '</nav>',
				/* translators: %: Page number. */
				'pagelink' => esc_html__( 'Page %', 'twentytwentyone' ),
			)
		);
		?>
	</div><!-- .entry-content -->
	<div class="col-md-4">
	<?php if (is_single() && is_active_sidebar('custom-single-post-sidebar')) : ?>
    <div id="custom-single-post-sidebar" class="custom-single-post-sidebar">
        <?php dynamic_sidebar('custom-single-post-sidebar'); ?>
    </div>
	<?php endif; ?>
	</div>
	</div>
	</div>

	<footer class="entry-footer default-max-width">
		<?php twenty_twenty_one_entry_meta_footer(); ?>
	</footer><!-- .entry-footer -->

	<?php if ( ! is_singular( 'attachment' ) ) : ?>
		<?php get_template_part( 'template-parts/post/author-bio' ); ?>
	<?php endif; ?>

</article><!-- #post-<?php the_ID(); ?> -->
