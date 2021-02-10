<?php
get_header();
?>
	<main id="site-content" role="main" class="main archive-content">

		<?php if ( have_posts() ) : ?>
			<header class="archive-header">
				<?php
				the_archive_title( '<h1 class="page-title">', '</h1>' );
				?>
			</header><!-- .page-header -->
		<?php endif; ?>

		<div class="archive-inner posts-loop">
			<?php
			if ( have_posts() ) {

				while ( have_posts() ) {

					the_post();

					get_template_part('template-parts/post-entry');

				}
			}
			?>
		</div>
	</main>
<?php
get_footer();
