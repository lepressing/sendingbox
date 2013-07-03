<?php
/**
 * The default template for displaying home category.
 *
 * @subpackage LEPRESSING
 * @since 0.1
 */
?>
<?php get_header(); ?>
<!-- template -->

<h1>Category: <?php single_cat_title(); ?></h1>


<!--
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
</article>
-->
<div class="row color">
	<div class="large-12 columns">
	<?php
		$args=array(
			'category_name' => 'categorie-post-5',
			'posts_per_page' => 15,
			'order'=>'ASC'
		);
		$editorials = new WP_Query($args);
		if($editorials->have_posts()) : while($editorials->have_posts()) : $editorials->the_post();
	?>
	<div class="large-3 small-6 columns color left">
		<?php the_post_thumbnail( $size, $attr ); ?>
		<div class="panel">
			<a href="<?php the_permalink(); ?>" title="Read the article &quot;<?php the_title(); ?>&quot;">
			<h5><?php the_title(); ?></h5>
			<h6 class="subheader">Lire la suite</h6>
			</a>
		</div>
	</div>
	
	<?php endwhile; endif; ?>
	</div>
</div>

<hr />
<!-- end template -->
<?php get_footer(); ?>