
function sbtheme_projects_shortcode(array $atts): string
{
    $atts = shortcode_atts([
        'posts_per_page' => 12,
        'type' => '',
        'show_filters' => 'true',
    ], $atts, 'sb_projects');

    $posts_per_page = (int) $atts['posts_per_page'];
    if ($posts_per_page <= 0 || $posts_per_page > 50) {
        $posts_per_page = 12;
    }

    $base_url = get_permalink();
    $current_filter = sbtheme_get_current_project_type_filter();

    $type_slug = sanitize_title((string) $atts['type']);
    $effective_filter = $type_slug !== '' ? $type_slug : $current_filter;

    $query_args = [
        'post_type' => 'project',
        'posts_per_page' => $posts_per_page,
        'no_found_rows' => true,
    ];

    if ($effective_filter !== '') {
        $query_args['tax_query'] = [[
            'taxonomy' => 'project-type',
            'field' => 'slug',
            'terms' => $effective_filter,
        ]];
    }

    $projects = new \WP_Query($query_args);

    ob_start();

    if (strtolower((string) $atts['show_filters']) === 'true') {
        echo sbtheme_project_type_filters($base_url, $effective_filter);
    }

    if ($projects->have_posts()) {
        echo '<div class="projects-grid">';
        while ($projects->have_posts()) {
            $projects->the_post();
            get_template_part('template-parts/project', 'card');
        }
        echo '</div>';
        wp_reset_postdata();
    } else {
        echo '<p>' . esc_html__('No projects found.', 'small-business-theme') . '</p>';
    }

    return (string) ob_get_clean();
}
add_shortcode('sb_projects', 'sbtheme_projects_shortcode');
