function create_post_type() {
    register_post_type('json_data',
        array(
            'labels' => array(
                'name' => __('JSON Data'),
                'singular_name' => __('JSON Data')
            ),
            'public' => true,
            'has_archive' => true,
            'supports' => array('title', 'editor', 'custom-fields'),
        )
    );
}
add_action('init', 'create_post_type');


function display_websites_from_json() {
    // Specify the path to the JSON file
    $json_file_path = WP_CONTENT_DIR . '/uploads/wpallimport/files/websites.json';

    // Check if the file exists
    if (file_exists($json_file_path)) {
        // Get file contents
        $json_data = file_get_contents($json_file_path);
        $websites = json_decode($json_data, true);
        
        // Check if data could be decoded and is an array
        if (is_array($websites)) {
            $output = '<ul>';
            foreach ($websites as $website) {
                $name = esc_html($website['website_name']); // Accessing website_name
                $url = esc_url($website['website_url']);    // Accessing website_url
                $category = esc_html($website['website_category']); // Accessing website_category
                $output .= "<li>$name - URL: $url - Category: $category</li>";
            }
            $output .= '</ul>';
            return $output;
        } else {
            return 'No websites found in JSON or JSON is malformed.';
        }
    } else {
        return 'JSON file not found. Please check the path.';
    }
}
add_shortcode('show_websites', 'display_websites_from_json');
