<?php
get_header();

echo \InfiniteEye\Media\Media::image(6)
    ->srcset([
        // at 1024 display 400px wide image
        1024 => 400,
        // at 768 display 200px wide image
        768 => 200,
        // at 480 display 100px wide image
        480 => 100
    ])
    ->size(500);

if (have_posts()) {
    while (have_posts()) {
        the_post();
    }
}

get_footer();
