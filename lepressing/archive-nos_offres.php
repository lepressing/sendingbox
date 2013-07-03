<?php
/*
Template Name: Archives nos-offres
*/
/*
Gestion dans des pages d'une autre post-type - bcp a faire :)
template des pages a faire sur single-projet.php
*/
?>

<?php get_header(); ?>


<!-- GOOD SUR LE TRI -->
<div class="row">
	<div class="large-12 columns">
		<h3 class="project-name"><?php the_title(); ?></h3>
	</div>
</div>
<!-- LE SELECTEUR/FILTRE -->
<div class="row">
	<div id="options" class="large-12 columns clearfix">
		<ul class="" id="filters" data-option-key="filter">
				<?php
				    $terms = get_terms("offers");  
				    $count = count($terms);  
				    echo '<ul class="button-group radius" id="">';  
				    echo '<li><a href="#" class="button secondary" data-filter="*" title="">Show All</a></li>';  
				        if ( $count > 0 )
				        {     
				            foreach ( $terms as $term ) {  
				                $termname = strtolower($term->name);  
				                $termname = str_replace(' ', '-', $termname);  
				                echo '<li><a href="#" class="button secondary" data-filter=".'.$termname.'" title="" >'.$term->name.'</a></li>';  
				            }  
				        }  
				    echo "</ul>";  
				?>
		</ul>
	</div>
</div>
<!-- LES PUSH -->
<div id="containeriso" class="row color">
	<div class="large-12 columns color">
		<?php   
		    $loop = new WP_Query(array('post_type' => 'nos_offres','order'=>'ASC'));  
		    $count =0;  
		?>          
		<?php if ( $loop ) :   
		               
		    while ( $loop->have_posts() ) : $loop->the_post(); ?>  
		              
		        <?php  
		        $terms = get_the_terms( $post->ID, 'offers' );  
		                              
		        if ( $terms && ! is_wp_error( $terms ) ) :   
		            $links = array();  
		
		            foreach ( $terms as $term )   
		            {  
		                $links[] = $term->name;  
		            }  
		            $links = str_replace(' ', '-', $links);   
		            $tax = join( " ", $links );       
		        else :    
		            $tax = '';    
		        endif;  
		        ?>          
		        <?php $infos = get_post_custom_values('_url'); ?>
		        <div class="large-3 columns box color <?php echo $term->slug; ?> <?php echo strtolower($tax); ?>" >
		            <?php the_post_thumbnail(); ?>
<!-- 		            <img src="http://placehold.it/1000x1000&amp;text=Thumbnail"> -->
		            <div class="panel">
			            <a href="<?php the_permalink() ?>"><?php the_title(); ?></a>
			            <a href="<?php the_permalink() ?>"><?php echo get_the_excerpt(); ?></a>
			            <?php echo get_the_term_list($post->ID, 'offers', 'Catégorie : ', ', ', '' ); ?>
			        </div>    
		        </div>     
		    <?php endwhile; else: ?>   
		        <li class="error-not-found">Sorry, no entries found.</li>  
		<?php endif; ?>
	</div>
</div>
<!-- end contenu -->
<?php get_footer(); ?>
