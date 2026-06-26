<?php get_header(); ?>


<h2>
Page Template
</h2>


<?php

while (have_posts()) :

the_post();

the_title('<h3>', '</h3>');

the_content();

endwhile;

?>


<?php get_footer(); ?>