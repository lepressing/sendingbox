<?php
/*
Template Name: Page d'accueil
*/
get_header(); ?>

<!-- Orbit Container -->
<div class="orbit-container">
  <ul data-orbit="" class="orbit-slides-container">
    <li>
      <img src="http://placehold.it/1000x440&amp;text=Thumbnail 1">
      <div class="orbit-caption">Caption here</div>
    </li>
    <li class="active">
      <img src="http://placehold.it/1000x440&amp;text=Thumbnail 2">
      <div class="orbit-caption">Caption here</div>
    </li>
</div>

<!-- Row for main content area -->
	<div class="small-12 large-12 columns" role="main">
	
	<?php /* Start loop */ ?>
	<?php while (have_posts()) : the_post(); ?>
		<article <?php post_class() ?> id="post-<?php the_ID(); ?>">
			<header>
				<h1 class="entry-title"><?php the_title(); ?></h1>
				<?php reverie_entry_meta(); ?>
			</header>
			<div class="entry-content">
				<?php the_content(); ?>
			</div>
			<footer>
				<?php wp_link_pages(array('before' => '<nav id="page-nav"><p>' . __('Pages:', 'reverie'), 'after' => '</p></nav>' )); ?>
				<p><?php the_tags(); ?></p>
			</footer>
		</article>
	<?php endwhile; // End the loop ?>

	</div>
		
<?php get_footer(); ?>