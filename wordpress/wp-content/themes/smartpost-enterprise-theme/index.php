<?php get_header(); ?>

<h2>
SmartPost Enterprise Portal
</h2>


<?php

if (have_posts()) :

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

else:

echo "No content found";

endif;

?>

<?php get_footer(); ?>