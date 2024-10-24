<div class="sightline-filtered-posts">
    <?php
    if ($post_query->have_posts()) {
        ?>
        <div class="gb-grid-wrapper">
            <?php
            while ($post_query->have_posts()) {
                $post_query->the_post();
                $excerpt = get_the_excerpt();
                $excerpt = substr($excerpt, 0, 200); // Only display first 200 characters of excerpt
                $excerpt_result = substr($excerpt, 0, strrpos($excerpt, ' ')) . '...';

                if ($filter_for == 'search') {
                    ?>

                    <div class="gb-grid-column gb-query-loop-item post-<?php echo get_the_ID(); ?> news_item type-news_item status-publish hentry publications-npr is-loop-template-item">
                        <div class="gb-container">
                            <h4 class="gb-headline gb-headline-text"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>

                            <p class="gb-headline gb-headline-text"><?php echo $excerpt_result; ?></p>

                            <a class="gb-button ReadMore_Button" href="<?php echo get_permalink(); ?>">
                                <span class="gb-button-text"><?php echo __('Read More', 'generatepress'); ?></span>
                                <span class="gb-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 22 21" height="21" width="22">
                                        <path fill="#517D99" d="M9.6458 1.68328L10.6891 0.639929C11.1309 0.198149 11.8453 0.198149 12.2824 0.639929L21.4187 9.77157C21.8605 10.2133 21.8605 10.9277 21.4187 11.3648L12.2824 20.5011C11.8406 20.9429 11.1262 20.9429 10.6891 20.5011L9.6458 19.4578C9.19932 19.0113 9.20872 18.2828 9.6646 17.8458L15.3278 12.4504H1.82069C1.19562 12.4504 0.692749 11.9475 0.692749 11.3225V9.81857C0.692749 9.1935 1.19562 8.69063 1.82069 8.69063H15.3278L9.6646 3.2953C9.20402 2.85822 9.19462 2.12976 9.6458 1.68328Z"></path>
                                    </svg>
                                </span>
                            </a>
                            <div class="gb-grid-wrapper">
                                <div class="gb-grid-column">
                                    <div class="gb-container">
                                        <p class="gb-headline gb-headline-text"><time class="entry-date published" datetime="2024-07-31T07:30:00-07:00"><?php echo get_the_date(); ?></time></p>
                                    </div>
                                </div>
                                <div class="gb-grid-column">
                                    <div class="gb-container">
                                        <h6 class="gb-headline gb-headline-text"><?php echo __('Author', 'generatepress'); ?>: <a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>"><?php echo get_the_author(); ?></a></h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php
                } elseif ($filter_for == 'sightline_press') {
                    $url = get_post_meta(get_the_ID(), 'sightlinepresslink', true);
                    $term_obj_list = get_the_terms(get_the_ID(), 'publications');
                    $terms_string = join(', ', wp_list_pluck($term_obj_list, 'name'));
                    ?>
                    <div class="gb-grid-column gb-query-loop-item post-<?php echo get_the_ID(); ?> news_item type-news_item status-publish hentry publications-npr is-loop-template-item">
                        <div class="gb-container">
                            <h4 class="gb-headline gb-headline-text"><a href="<?php echo $url; ?>"><?php the_title(); ?></a></h4>
                            <p class="gb-headline gb-headline-text"><span class="post-term-item term-kgw8"><?php echo $terms_string; ?></span></p>
                        </div>
                    </div>
                    <?php
                } elseif ($filter_for == 'release') {
                    $term_obj_list = get_the_terms(get_the_ID(), 'category');
                    ?>
                    <div class="gb-grid-column gb-query-loop-item post-<?php echo get_the_ID(); ?> news_item type-news_item status-publish hentry publications-npr is-loop-template-item">
                        <div class="gb-container">
                            <div class="post-terms">
                                <?php foreach ($term_obj_list as $term) { ?>
                                    <a class="gb-button gb-button-text post-term-item post-term-<?php echo $term->slug; ?>" href="<?php echo esc_attr(get_term_link($term->slug, 'category')); ?>"><?php echo $term->name; ?></a>
                                <?php } ?>
                            </div>
                            <h4 class="gb-headline gb-headline-text"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>

                            <p class="gb-headline gb-headline-text"><?php echo $excerpt_result; ?></p>

                            <a class="gb-button ReadMore_Button" href="<?php echo get_permalink(); ?>">
                                <span class="gb-button-text"><?php echo __('Read More', 'generatepress'); ?></span>
                                <span class="gb-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 22 21" height="21" width="22">
                                        <path fill="#517D99" d="M9.6458 1.68328L10.6891 0.639929C11.1309 0.198149 11.8453 0.198149 12.2824 0.639929L21.4187 9.77157C21.8605 10.2133 21.8605 10.9277 21.4187 11.3648L12.2824 20.5011C11.8406 20.9429 11.1262 20.9429 10.6891 20.5011L9.6458 19.4578C9.19932 19.0113 9.20872 18.2828 9.6646 17.8458L15.3278 12.4504H1.82069C1.19562 12.4504 0.692749 11.9475 0.692749 11.3225V9.81857C0.692749 9.1935 1.19562 8.69063 1.82069 8.69063H15.3278L9.6646 3.2953C9.20402 2.85822 9.19462 2.12976 9.6458 1.68328Z"></path>
                                    </svg>
                                </span>
                            </a>
                            <div class="gb-grid-wrapper">
                                <div class="gb-grid-column">
                                    <div class="gb-container">
                                        <p class="gb-headline gb-headline-text"><time class="entry-date published" datetime="2024-07-31T07:30:00-07:00"><?php echo get_the_date(); ?></time></p>
                                    </div>
                                </div>
                                <div class="gb-grid-column">
                                    <div class="gb-container">
                                        <div class="media-contacts">
                                            <h6 class="gb-headline gb-headline-text"><strong><?php echo __('Media Contact', 'generatepress'); ?>:</strong></h6>
                                            <p class="gb-headline gb-headline-text"><?php echo get_the_author(); ?></p>
                                            <p class="gb-headline gb-headline-text"><?php echo get_the_author_meta('user_email'); ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            }
            ?>
        </div>
        <div class="gb-container">
            <?php echo $pagination_html; ?>
        </div>
        <?php
    } else {
        //generate_do_template_part('none');
        echo '<div class="nothing-found">' . __('It seems we can’t find what you’re looking for.', 'generatepress') . '</div>';
    }
    ?>
</div>