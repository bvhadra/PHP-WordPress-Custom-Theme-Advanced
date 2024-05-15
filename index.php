<?php get_header(); ?>

<div class="container content">
    <div class="main block">
        <?php
        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
        $args = array(
            'posts_per_page' => 4,
            'paged' => $paged
        );
        $blog_query = new WP_Query($args);

        if ($blog_query->have_posts()) :
            while ($blog_query->have_posts()) : $blog_query->the_post();
                get_template_part('content', get_post_format());
            endwhile;

			// Pagination links
			echo '<div class="pagination-container">';
			echo paginate_links(array(
				'base' => str_replace(999999999, '%#%', get_pagenum_link(999999999)),
				'format' => '?paged=%#%',
				'current' => max(1, $paged),
				'total' => $blog_query->max_num_pages,
				'prev_text' => __('&laquo; Previous'),
				'next_text' => __('Next &raquo;')
			));
			echo '</div>';

            wp_reset_postdata();
        else :
            echo apautop('Sorry, no posts were found');
        endif;
        ?>
    </div>

    <div class="side">
        <?php if (is_active_sidebar('sidebar')) : ?>
            <?php dynamic_sidebar('sidebar'); ?>
        <?php endif; ?>
    </div>
</div>

<?php get_footer(); ?>