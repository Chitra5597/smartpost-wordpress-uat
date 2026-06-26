<?php get_header(); ?>


<h2>
News Article
</h2>


<?php

while (have_posts()) :

the_post();

?>

<h3>
<?php the_title(); ?>
</h3>


<div>
<?php the_content(); ?>
</div>


<?php

endwhile;

?>


<?php get_footer(); ?>