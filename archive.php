<?php get_header(); ?>

<div class="container content">
    <div class="main block">
        <h1 class="page-header">
            <?php
            if (is_category()) {
                single_cat_title();
            } elseif (is_author()) {
                the_post();
                echo 'Archives By Author: ' . get_the_author();
                rewind_posts();
            } elseif (is_tag()) {
                single_tag_title();
            } elseif (is_day()) {
                echo 'Archives By Day: ' . get_the_date();
            } elseif (is_month()) {
                echo 'Archives By Month: ' . get_the_date('F Y');
            } elseif (is_year()) {
                echo 'Archives By Year: ' . get_the_date('Y');
            } else {
                echo 'Archives';
            }
            ?>
        </h1>

        <?php
        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
        $args = array(
            'posts_per_page' => 4,
            'paged' => $paged
        );
        $archive_query = new WP_Query($args);

        if ($archive_query->have_posts()) :
            while ($archive_query->have_posts()) : $archive_query->the_post();
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
