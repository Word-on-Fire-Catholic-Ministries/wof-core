<?php

?>
<article <?php post_class('post-entry'); ?> id="post-<?php the_ID(); ?>">

	<a href="<?php the_permalink(); ?>">

		<?php if (has_post_thumbnail()) : ?>

		<figure class="post-entry__thumbnail">

			<?php the_post_thumbnail() ?>

		</figure>

		<?php endif; ?>

		<section class="post-entry__meta">

			<h2 class="post-entry__title"><?php the_title() ?></h2>

			<p class="post-entry__author"><?php the_author() ?></p>

		</section>

	</a>

</article>
