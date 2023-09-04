<?php

namespace InfiniteEye\Theme;

class Loop
{
    public static function content($name = null)
    {
        get_header();

        if (have_posts()) {
            while (have_posts()) {
                the_post();

                get_template_part('template-parts/content', $name);
            }
        }

        get_footer();
    }
}
