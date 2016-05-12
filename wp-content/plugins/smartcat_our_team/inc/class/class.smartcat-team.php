<?php

function sc_team_update_order() {
    $post_id = $_POST['id'];
    $sc_member_order = $_POST['sc_member_order'];
    //update_post_meta($post_id, $meta_key, $sc_member_order)
    update_post_meta($post_id, 'sc_member_order', $sc_member_order);
    exit();
}

add_action('wp_ajax_sc_team_update_order', 'sc_team_update_order');
add_action('wp_ajax_sc_team_update_order', 'sc_team_update_order');

class SmartcatTeamPlugin {

    const VERSION = '3.0';
    const NAME = 'Our Team Showcase Pro';

    private static $instance;
    private $options;

    public static function instance() {
        if (!self::$instance) :
            self::$instance = new self;
            self::$instance->get_options();
            self::$instance->add_hooks();
        endif;
    }

    public static function activate() {

        $options = array(
            'template' => 'grid',
            'social' => 'yes',
            'single_social' => 'yes',
            'name' => 'yes',
            'title' => 'yes',
            'profile_link' => 'yes',
            'member_count' => -1,
            'text_color' => '1F7DCF',
            'honeycomb_color' => '37C2E5',
            'columns' => '3',
            'margin' => 5,
            'height' => 170,
            'single_template' => 'panel',
            'redirect' => true,
            'single_image_style' => 'square',
            'single_skills' => 'yes',
            'single_image_size' => 'small',
            'skills_title' => 'Skills',
            'social_link' => 'new',
            'name_font_size' => 18,
            'title_font_size' => 18,
            'card_margin' => 100,
            'panel_margin' => 0,
            'social_link_style' => 'round',
            'word_count' => 30,
            'slug' => 'team_member',
            'single_posts' => 'no',
            'posts_title' => 'Favorite Posts',
            'carousel_play' => 5000,
            'directory_phone' => 'Phone Number',
            'directory_phone_bool' => 'yes',
            'directory_group' => 'Department',
            'directory_group_bool' => 'yes',
            'directory_title' => 'Position',
            'directory_title_bool' => 'yes',
            'directory_search_bool' => 1,
            'directory_search' => 'Search',
            'directory_sort_bool'   => 1,
            'updatev3'              => true
            
        );

        if (!get_option('smartcat_team_options')) :

            add_option('smartcat_team_options', $options);
            $options['redirect'] = true;
            update_option('smartcat_team_options', $options);

        endif;

        flush_rewrite_rules();
    }

    public static function deactivate() {
        
    }

    public function update() {

        
        $options = get_option('smartcat_team_options');
        
        //var_dump( $options['updatev3'] );
        
        if( isset( $options['updatev3'] ) && $options['updatev3'] === true ) :
            return;
        endif;
        
        if( isset( $options['single_skills'] ) && $options['single_skills'] == 'yes' ) :
            $args = array(
                'post_type' => 'team_member',           
            );
            $members = get_posts( $args );
            if( $members ) :

                foreach( $members as $member ) :

                    update_post_meta( $member->ID, 'team_member_skill_bool', 'on' );
                    update_post_meta( $member->ID, 'team_member_skill_title', $options['skills_title'] );

                endforeach;

            endif;
        endif;

        if (!isset($options['updatev3'])) :
            $options['updatev3'] = true;
        endif;

        if (!isset($options['social_link'])) :
            $options['social_link'] = 'new';
        endif;

        if (!isset($options['slug'])) :
            $options['slug'] = 'team_member';
        endif;

        if (!isset($options['social_link_style'])) :
            $options['social_link_style'] = 'round';
        endif;

        if (!isset($options['name_font_size'])) :
            $options['name_font_size'] = '18';
        endif;

        if (!isset($options['title_font_size'])) :
            $options['title_font_size'] = '18';
        endif;

        if (!isset($options['word_count'])) :
            $options['word_count'] = '30';
        endif;

        if (!isset($options['card_margin'])) :
            $options['card_margin'] = '100';
        endif;

        if (!isset($options['single_skills'])) :
            $options['single_skills'] = 'yes';
        endif;

        if (!isset($options['skills_title'])) :
            $options['skills_title'] = 'Skills';
        endif;

        if (!isset($options['single_posts'])) :
            $options['single_posts'] = 'no';
        endif;

        if (!isset($options['posts_title'])) :
            $options['posts_title'] = 'Favorite Posts';
        endif;

        if (!isset($options['carousel_play'])) :
            $options['carousel_play'] = 5000;
        endif;

        if (!isset($options['single_posts_template'])) :
            $options['single_posts_template'] = 'stacked';
        endif;

        if (!isset($options['single_image_style'])) :
            $options['single_image_style'] = 'square';
            $options['single_template'] = 'panel';
        endif;

        if (!isset($options['directory_title_bool'])) :
            $options['directory_title_bool'] = 'yes';
        endif;

        if (!isset($options['directory_title'])) :
            $options['directory_title'] = 'Position';
        endif;

        if (!isset($options['directory_group_bool'])) :
            $options['directory_group_bool'] = 'yes';
        endif;

        if (!isset($options['directory_group'])) :
            $options['directory_group'] = 'Department';
        endif;

        if (!isset($options['directory_phone_bool'])) :
            $options['directory_phone_bool'] = 'yes';
        endif;

        if (!isset($options['directory_phone'])) :
            $options['directory_phone'] = 'Phone Number';
        endif;

        if (!isset($options['directory_search_bool'])) :
            $options['directory_search_bool'] = 1;
        endif;

        if (!isset($options['directory_search'])) :
            $options['directory_search'] = 'Search';
        endif;

        if (!isset($options['directory_sort_bool'])) :
            $options['directory_sort_bool'] = 1;
        endif;

        if (!isset($options['panel_margin'])) :
            $options['panel_margin'] = 0;
        endif;


        update_option('smartcat_team_options', $options);
        
    }

    private function add_hooks() {
        add_action('init', array($this, 'team_members'));
        add_action('init', array($this, 'team_member_positions'), 0);
        add_action('admin_init', array($this, 'smartcat_team_activation_redirect'));
        add_action('admin_menu', array($this, 'smartcat_team_menu'));
        add_action('admin_enqueue_scripts', array($this, 'smartcat_team_load_admin_styles_scripts'));
        add_action('wp_enqueue_scripts', array($this, 'smartcat_team_load_styles_scripts'));
        add_shortcode('our-team', array($this, 'set_our_team'));
        add_action('add_meta_boxes', array($this, 'smartcat_team_member_info_box'));
        add_action('save_post', array($this, 'team_member_box_save'));
        add_action('widgets_init', array($this, 'wpb_load_widget'));
        add_action('wp_ajax_smartcat_team_update_pm', array($this, 'smartcat_team_update_order'));
        add_action('wp_head', array($this, 'sc_custom_styles'));
        add_filter('the_content', array($this, 'smartcat_set_single_content'));
        add_filter('single_template', array($this, 'smartcat_team_get_single_template'));
        add_action('admin_init', array($this, 'deactivate_license'));
        add_action('admin_init', array($this, 'activate_license'));
        add_action('admin_init', array($this, 'register_option'));
        add_action('after_setup_theme', array($this, 'add_featured_image_support'));
        add_action('plugins_loaded', array($this, 'update'));

        add_filter('manage_edit-team_member_columns', array($this, 'set_columns'));
        add_action('manage_team_member_posts_custom_column', array($this, 'custom_columns'), 10, 2);
    }

    public function set_columns($columns) {
        unset($columns['date']);

        $columns['team_member_title'] = __('Title');
        $columns['team_member_image'] = __('Image');



        return $columns;
    }

    public function custom_columns($column, $post_id) {

        switch ($column) :

            case 'team_member_title' :
                echo get_post_meta($post_id, 'team_member_title', TRUE);
                break;

            case 'team_member_image' :
                echo get_the_post_thumbnail($post_id, array(50, 50));
                break;


        endswitch;
    }

    private function get_options() {
        if (get_option('smartcat_team_options')) :
            $this->options = get_option('smartcat_team_options');
        endif;
    }

    public function smartcat_team_activation_redirect() {
        if ($this->options['redirect']) :
            $old_val = $this->options;
            $old_val['redirect'] = false;
            update_option('smartcat_team_options', $old_val);
            wp_safe_redirect(admin_url('edit.php?post_type=team_member&page=smartcat_team_settings'));
        endif;
    }

    public function add_featured_image_support() {
        add_theme_support('post-thumbnails');
    }

    public function smartcat_team_menu() {

        add_submenu_page('edit.php?post_type=team_member', 'Settings', 'Settings', 'administrator', 'smartcat_team_settings', array($this, 'smartcat_team_settings'));
        add_submenu_page('edit.php?post_type=team_member', 'Re-Order Members', 'Re-Order Members', 'administrator', 'smartcat_team_reorder', array($this, 'smartcat_team_reorder'));
        add_submenu_page('edit.php?post_type=team_member', 'License', 'License', 'administrator', 'smartcat_team_license', array($this, 'smartcat_team_license'));
        add_submenu_page('edit.php?post_type=team_member', 'Documentation', 'Documentation', 'administrator', 'smartcat_team_documentation', array($this, 'smartcat_team_documentation'));
    }

    public function smartcat_team_documentation() {

        include_once SC_TEAM_PATH . 'admin/documentation.php';
    }

    public function smartcat_team_license() {

        include_once SC_TEAM_PATH . 'admin/license.php';
    }

    public function smartcat_team_reorder() {
        include_once SC_TEAM_PATH . 'admin/reorder.php';
    }

    public function smartcat_team_settings() {

        if (isset($_REQUEST['sc_our_team_save']) && $_REQUEST['sc_our_team_save'] == 'Update') :
            update_option('smartcat_team_options', $_REQUEST['smartcat_team_options']);
        endif;

        include_once SC_TEAM_PATH . 'admin/options.php';
    }

    public function smartcat_team_load_admin_styles_scripts($hook) {
        wp_enqueue_style('smartcat_team_admin_style', SC_TEAM_URL . 'inc/style/sc_our_team_admin.css');
        wp_enqueue_script('smartcat_team_color_script', SC_TEAM_URL . 'inc/script/jscolor/jscolor.js', array('jquery'));
        wp_enqueue_script('smartcat_team_script', SC_TEAM_URL . 'inc/script/sc_our_team_admin.js', array('jquery'));
    }

    function smartcat_team_load_styles_scripts() {

        wp_enqueue_script('jquery-ui-tabs');

        // plugin main style
        wp_enqueue_style('smartcat_team_default_style', SC_TEAM_URL . 'inc/style/sc_our_team.css', false, '1.0');
        wp_enqueue_style('smartcat_team_dt_style', '//cdn.datatables.net/1.10.9/css/jquery.dataTables.min.css', false, '1.0');

        // plugin main script
        wp_enqueue_script('smartcat_team_dt_script', '//cdn.datatables.net/1.10.9/js/jquery.dataTables.min.js', array('jquery'), '1.0');
        wp_enqueue_script('smartcat_team_hc_script', SC_TEAM_URL . 'inc/script/hc.js', array('jquery'), '1.0');
        wp_enqueue_script('smartcat_team_carousel_script', SC_TEAM_URL . 'inc/script/carousel.js', array('jquery'), '1.0');
        wp_enqueue_script('smartcat_team_default_script', SC_TEAM_URL . 'inc/script/sc_our_team.js', array('jquery', 'jquery-ui-tabs'), '1.0');
    }

    function set_our_team($atts) {

        extract(shortcode_atts(array(
            'group' => '',
            'template' => '',
            'single_template' => '',
                        ), $atts));
        global $content;

        ob_start();

        if (!$this->strap_pl()) :

            exit();

        endif;

        if ($template == '') :
            if ($this->options['template'] === false or $this->options['template'] == '') :
                include SC_TEAM_PATH . 'inc/template/grid.php';
            else :
                include SC_TEAM_PATH . 'inc/template/' . $this->options['template'] . '.php';
            endif;
        else :

            if (file_exists(SC_TEAM_PATH . 'inc/template/' . $template . '.php')) :

                include SC_TEAM_PATH . 'inc/template/' . $template . '.php';
            else :
                include SC_TEAM_PATH . 'inc/template/grid.php';
            endif;
        endif;

        $output = ob_get_clean();
        return $output;
    }

    function team_members() {
        $labels = array(
            'name' => _x('Team', 'post type general name'),
            'singular_name' => _x('Team Member', 'post type singular name'),
            'add_new' => _x('Add New', 'team_member'),
            'add_new_item' => __('Add New Member'),
            'edit_item' => __('Edit Member'),
            'new_item' => __('New Team Member'),
            'all_items' => __('All Team Members'),
            'view_item' => __('View Team Member'),
            'search_items' => __('Search Team Members'),
            'not_found' => __('No member found'),
            'not_found_in_trash' => __('No member found in the Trash'),
            'parent_item_colon' => '',
        );
        $args = array(
            'labels' => $labels,
            'public' => true,
            'publicly_queryable' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'query_var' => true,
            'rewrite' => true,
            'capability_type' => 'post',
            'has_archive' => true,
            'rewrite' => array('slug' => $this->options['slug'], 'with_front' => false),
            'hierarchical' => false,
            'menu_position' => null,
            'menu_icon' => SC_TEAM_URL . 'inc/img/icon.png',
            'supports' => array('title', 'editor', 'thumbnail'),
        );
        register_post_type('team_member', $args);
    }

    public function team_member_positions() {
        $labels = array(
            'name' => _x('Groups', 'taxonomy general name'),
            'singular_name' => _x('Group', 'taxonomy singular name'),
            'search_items' => __('Search Groups'),
            'all_items' => __('All Groups'),
            'parent_item' => __('Parent Group'),
            'parent_item_colon' => __('Parent Group:'),
            'edit_item' => __('Edit Group'),
            'update_item' => __('Update Group'),
            'add_new_item' => __('Add New Group'),
            'new_item_name' => __('New Group'),
            'menu_name' => __('Groups'),
        );
        $args = array(
            'labels' => $labels,
            'hierarchical' => true,
        );
        register_taxonomy('team_member_position', 'team_member', $args);
    }

    public function get_groups() {

        return get_categories('taxonomy=team_member_position&type=team_member');
    }

    public function strap_pl() {

        $a = get_option('smartcat_our_team_status');

        if ($a !== false && $a == 'valid') :

            return true;

        endif;

        return false;
    }

    public function smartcat_team_member_info_box() {

        add_meta_box(
                'smartcat_team_member_info_box', __('Additional Information', 'myplugin_textdomain'), array($this, 'smartcat_team_member_info_box_content'), 'team_member', 'normal', 'high'
        );
    }

    public function smartcat_team_member_info_box_content($post) {


        //nonce
        wp_nonce_field(plugin_basename(__FILE__), 'smartcat_team_member_info_box_content_nonce');

        //social

        echo '<p><em>Fields that are left blank, will simply not display any output</em></p>';

        echo '<div class="sc_options_table">';

        echo '<table class="widefat">';

        echo '<tr><th><lablel for="team_member_qoute">Personal Quote</lablel></th>';
        echo '<td><input type="text" value="' . get_post_meta($post->ID, 'team_member_qoute', true) . '" id="team_member_qoute" name="team_member_qoute" placeholder="Enter Personal Qoute"/></td></tr>';

        echo '<tr><td><lablel for="team_member_title">Job Title</lablel></td>';
        echo '<td><input type="text" value="' . get_post_meta($post->ID, 'team_member_title', true) . '" id="team_member_title" name="team_member_title" placeholder="Enter Job Title"/></td></tr>';

        echo '<tr><td><lablel for="team_member_email"><img src="' . SC_TEAM_URL . 'inc/img/email.png" width="20px"/></label></td>';
        echo '<td><input type="text" value="' . get_post_meta($post->ID, 'team_member_email', true) . '" id="team_member_email" name="team_member_email" placeholder="Enter Email Address"/></td></tr>';

        echo '<tr><td><lablel for="team_member_facebook"><img src="' . SC_TEAM_URL . 'inc/img/fb.png" width="20px"/></label></td>';
        echo '<td><input type="text" value="' . get_post_meta($post->ID, 'team_member_facebook', true) . '" id="team_member_facebook" name="team_member_facebook" placeholder="Enter Facebook URL"/></td></tr>';

        echo '<tr><td><label for="team_member_twitter"><img src="' . SC_TEAM_URL . 'inc/img/twitter.png" width="20px"/></label></td>';
        echo '<td><input type="text" value="' . get_post_meta($post->ID, 'team_member_twitter', true) . '" id="team_member_twitter" name="team_member_twitter" placeholder="Enter Twitter URL"/></td></tr>';

        echo '<tr><td><lablel for="team_member_linkedin"><img src="' . SC_TEAM_URL . 'inc/img/linkedin.png" width="20px"/></label></td>';
        echo '<td><input type="text" value="' . get_post_meta($post->ID, 'team_member_linkedin', true) . '" id="team_member_linkedin" name="team_member_linkedin" placeholder="Enter Linkedin URL"/></td></tr>';

        echo '<tr><td><lablel for="team_member_gplus"><img src="' . SC_TEAM_URL . 'inc/img/google.png" width="20px"/></label></td>';
        echo '<td><input type="text" value="' . get_post_meta($post->ID, 'team_member_gplus', true) . '" id="team_member_gplus" name="team_member_gplus" placeholder="Enter Google Plus URL"/></td></tr>';

        echo '<tr><td><lablel for="team_member_phone"><img src="' . SC_TEAM_URL . 'inc/img/phone.png" width="20px"/></label></td>';
        echo '<td><input type="text" value="' . get_post_meta($post->ID, 'team_member_phone', true) . '" id="team_member_phone" name="team_member_phone" placeholder="Enter Phone Number"/></td></tr>';

        echo '<tr><td><lablel for="team_member_instagram"><img src="' . SC_TEAM_URL . 'inc/img/instagram.png" width="20px"/></label></td>';
        echo '<td><input type="text" value="' . get_post_meta($post->ID, 'team_member_instagram', true) . '" id="team_member_instagram" name="team_member_instagram" placeholder="Enter Instagram URL"/></td></tr>';

        echo '<tr><td><lablel for="team_member_pinterest"><img src="' . SC_TEAM_URL . 'inc/img/pinterest.png" width="20px"/></label></td>';
        echo '<td><input type="text" value="' . get_post_meta($post->ID, 'team_member_pinterest', true) . '" id="team_member_pinterest" name="team_member_pinterest" placeholder="Enter pinterest URL"/></td></tr>';

        echo '<tr><td><lablel for="team_member_website"><img src="' . SC_TEAM_URL . 'inc/img/website.png" width="20px"/></label></td>';
        echo '<td><input type="text" value="' . get_post_meta($post->ID, 'team_member_website', true) . '" id="team_member_website" name="team_member_website" placeholder="Enter Personal Website URL"/></td></tr>';

        echo '</table>';
        echo '</div><hr>';


        echo '<div class="sc_options_table">'
        . '<h4>Attributes / Skills / Ratings</h4>'
        . '<table class="widefat"><tr>'
        . '<td colspan="2">Show <input type="radio" name="team_member_skill_bool" value="on" ' . checked(get_post_meta($post->ID, 'team_member_skill_bool', true), 'on', false) . '/> '
        . 'Hide <input type="radio" name="team_member_skill_bool" value="off" ' . checked(get_post_meta($post->ID, 'team_member_skill_bool', true), 'off', false) . ' />'
        . '</td></tr><tr>'
        . '<td>Title</td><td colspan="2">'
        . '<input type="text" name="team_member_skill_title" value="' . get_post_meta($post->ID, 'team_member_skill_title', true) . '" />'
        . '</td></tr><tr>'
        . '<td>Attribute/Skill #1</td>'
        . '<td><input type="text" name="team_member_skill1" placeholder="Title" value="' . get_post_meta($post->ID, 'team_member_skill1', true) . '"/></td>'
        . '<td><input type="text" name="team_member_skill_value1" placeholder="Skill rating( 1 to 10 )" value="' . $this->sc_team_switch_skill(get_post_meta($post->ID, 'team_member_skill_value1', true)) . '"/></td></tr>'
        . '<td>Attribute/Skill #2</td>'
        . '<td><input type="text" name="team_member_skill2" placeholder="Title" value="' . get_post_meta($post->ID, 'team_member_skill2', true) . '"/></td>'
        . '<td><input type="text" name="team_member_skill_value2" placeholder="Skill rating( 1 to 10 )" value="' . $this->sc_team_switch_skill(get_post_meta($post->ID, 'team_member_skill_value2', true)) . '"/></td></tr>'
        . '<td>Attribute/Skill #3</td>'
        . '<td><input type="text" name="team_member_skill3" placeholder="Title" value="' . get_post_meta($post->ID, 'team_member_skill3', true) . '"/></td>'
        . '<td><input type="text" name="team_member_skill_value3" placeholder="Skill rating( 1 to 10 )" value="' . $this->sc_team_switch_skill(get_post_meta($post->ID, 'team_member_skill_value3', true)) . '"/</td></tr>'
        . '<td>Attribute/Skill #4</td>'
        . '<td><input type="text" name="team_member_skill4" placeholder="Title" value="' . get_post_meta($post->ID, 'team_member_skill4', true) . '"/></td>'
        . '<td><input type="text" name="team_member_skill_value4" placeholder="Skill rating( 1 to 10 )" value="' . $this->sc_team_switch_skill(get_post_meta($post->ID, 'team_member_skill_value4', true)) . '"/></td></tr>';

        echo '</table></div>'
        . '<div class="clear"></div><hr>';

        $posts = get_posts(array(
            'posts_per_page' => -1,
            'post_type' => 'post',
                ));

        echo '<div class="sc_options_table">'
        . '<h4>Authored / Favorite Articles</h4>'
        . '<table class="widefat"><tr>'
        . '<td colspan="2">Show <input type="radio" name="team_member_article_bool" value="on" ' . checked(get_post_meta($post->ID, 'team_member_article_bool', true), 'on', false) . '/> '
        . 'Hide <input type="radio" name="team_member_article_bool" value="off" ' . checked(get_post_meta($post->ID, 'team_member_article_bool', true), 'off', false) . ' />'
        . '</td>'
        . '</tr><tr><td>Title</td>'
        . '<td><input type="text" name="team_member_article_title" placeholder="Enter the title" value="' . get_post_meta($post->ID, 'team_member_article_title', true) . '"/></td></tr>';

        echo '<tr><td>Article 1</td>'
        . '<td><select name="team_member_article1">'
        . '<option value="">Select Article</option>';

        foreach ($posts as $the_post) :

            echo '<option value="' . $the_post->ID . '" ' . selected($the_post->ID, get_post_meta($post->ID, 'team_member_article1', true), true) . '>' . $the_post->post_title . '</option>';

        endforeach;

        echo '</select></td>'
        . '</tr>';


        echo '<tr><td>Article 2</td>'
        . '<td><select name="team_member_article2">'
        . '<option value="">Select Article</option>';

        foreach ($posts as $the_post) :

            echo '<option value="' . $the_post->ID . '" ' . selected($the_post->ID, get_post_meta($post->ID, 'team_member_article2', true), true) . '>' . $the_post->post_title . '</option>';

        endforeach;

        echo '</select></td>'
        . '</tr>';

        echo '<tr><td>Article 3</td>'
        . '<td><select name="team_member_article3">'
        . '<option value="">Select Article</option>';

        foreach ($posts as $the_post) :

            echo '<option value="' . $the_post->ID . '" ' . selected($the_post->ID, get_post_meta($post->ID, 'team_member_article3', true), true) . '>' . $the_post->post_title . '</option>';

        endforeach;

        echo '</select></td>'
        . '</tr>';


        echo '</table>'
        . ''
        . ''
        . '</div><hr>';
        ?>

        <div class="sc_options_table">

            <h4>Interests / Tags / Additional Skills</h4>
            <table class="widefat">
                <tr>
                    <td colspan="2">
                        Show <input type="radio" name="team_member_tags_bool" value="on" <?php checked('on', get_post_meta($post->ID, 'team_member_tags_bool', true)); ?>/> Hide <input type="radio" name="team_member_tags_bool" value="off" <?php checked('off', get_post_meta($post->ID, 'team_member_tags_bool', true)); ?>/>
                    </td>
                </tr>
                <tr>
                    <td>Title</td>
                    <td><input type="text" name="team_member_tags_title" placeholder="Enter the label for the tags" value="<?php echo get_post_meta($post->ID, 'team_member_tags_title', true) ?>"/></td>
                </tr>
                <tr>
                    <td>Attributes</td>
                    <td><textarea name="team_member_tags" placeholder="Enter attributes, comma separated" style="width: 100%"><?php echo get_post_meta($post->ID, 'team_member_tags', true) ?></textarea></td>
                </tr>


            </table>

        </div>


    <?php
    }

    public function team_member_box_save($post_id) {

        $slug = 'team_member';

        if (isset($_POST['post_type'])) {
            if ($slug != $_POST['post_type']) {
                return;
            }
        }

        // get var values
        if (get_post_meta($post_id, 'sc_member_order', true) == '' || get_post_meta($post_id, 'sc_member_order', true) === FALSE)
            update_post_meta($post_id, 'sc_member_order', 0);


        if (isset($_REQUEST['team_member_title'])) {
            $facebook_url = $_POST['team_member_title'];
            update_post_meta($post_id, 'team_member_title', $facebook_url);
        }

        if (isset($_REQUEST['team_member_email'])) {
            $facebook_url = $_POST['team_member_email'];
            update_post_meta($post_id, 'team_member_email', $facebook_url);
        }


        if (isset($_REQUEST['team_member_facebook'])) {
            $facebook_url = $_POST['team_member_facebook'];
            update_post_meta($post_id, 'team_member_facebook', $facebook_url);
        }

        if (isset($_REQUEST['team_member_twitter'])) {
            $twitter_url = $_POST['team_member_twitter'];
            update_post_meta($post_id, 'team_member_twitter', $twitter_url);
        }

        if (isset($_REQUEST['team_member_linkedin'])) {
            $linkedin_url = $_POST['team_member_linkedin'];
            update_post_meta($post_id, 'team_member_linkedin', $linkedin_url);
        }

        if (isset($_REQUEST['team_member_gplus'])) {
            $gplus_url = $_POST['team_member_gplus'];
            update_post_meta($post_id, 'team_member_gplus', $gplus_url);
        }

        if (isset($_REQUEST['team_member_instagram'])) {
            $instagram_url = $_POST['team_member_instagram'];
            update_post_meta($post_id, 'team_member_instagram', $instagram_url);
        }

        if (isset($_REQUEST['team_member_pinterest'])) {
            $pinterest_url = $_POST['team_member_pinterest'];
            update_post_meta($post_id, 'team_member_pinterest', $pinterest_url);
        }

        if (isset($_REQUEST['team_member_website'])) {
            $website_url = $_POST['team_member_website'];
            update_post_meta($post_id, 'team_member_website', $website_url);
        }

        if (isset($_REQUEST['team_member_skill_bool'])) {
            $skill_bool = $_POST['team_member_skill_bool'];
            update_post_meta($post_id, 'team_member_skill_bool', $skill_bool);
        }

        if (isset($_REQUEST['team_member_article_bool'])) {
            $article_bool = $_POST['team_member_article_bool'];
            update_post_meta($post_id, 'team_member_article_bool', $article_bool);
        }

        if (isset($_REQUEST['team_member_tags_bool'])) {
            $tags_bool = $_POST['team_member_tags_bool'];
            update_post_meta($post_id, 'team_member_tags_bool', $tags_bool);
        }

        if (isset($_REQUEST['team_member_tags_title'])) {
            $tags_title = $_POST['team_member_tags_title'];
            update_post_meta($post_id, 'team_member_tags_title', $tags_title);
        }

        if (isset($_REQUEST['team_member_tags'])) {
            $tags = $_POST['team_member_tags'];
            update_post_meta($post_id, 'team_member_tags', $tags);
        }

        if (isset($_REQUEST['team_member_skill_title'])) {
            $skill_title = $_POST['team_member_skill_title'];
            update_post_meta($post_id, 'team_member_skill_title', $skill_title);
        }

        if (isset($_REQUEST['team_member_phone'])) {
            update_post_meta($post_id, 'team_member_phone', $_POST['team_member_phone']);
        }

        if (isset($_REQUEST['team_member_skill1'])) {
            $skill = $_POST['team_member_skill1'];
            update_post_meta($post_id, 'team_member_skill1', $skill);
        }

        if (isset($_REQUEST['team_member_skill_value1'])) {
            $value = $_POST['team_member_skill_value1'];
            update_post_meta($post_id, 'team_member_skill_value1', $value);
        }

        if (isset($_REQUEST['team_member_skill2'])) {
            $skill = $_POST['team_member_skill2'];
            update_post_meta($post_id, 'team_member_skill2', $skill);
        }

        if (isset($_REQUEST['team_member_skill_value2'])) {
            $value = $_POST['team_member_skill_value2'];
            update_post_meta($post_id, 'team_member_skill_value2', $value);
        }

        if (isset($_REQUEST['team_member_skill3'])) {
            $skill = $_POST['team_member_skill3'];
            update_post_meta($post_id, 'team_member_skill3', $skill);
        }

        if (isset($_REQUEST['team_member_skill_value3'])) {
            $value = $_POST['team_member_skill_value3'];
            update_post_meta($post_id, 'team_member_skill_value3', $value);
        }

        if (isset($_REQUEST['team_member_skill4'])) {
            $skill = $_POST['team_member_skill4'];
            update_post_meta($post_id, 'team_member_skill4', $skill);
        }

        if (isset($_REQUEST['team_member_skill_value4'])) {
            $value = $_POST['team_member_skill_value4'];
            update_post_meta($post_id, 'team_member_skill_value4', $value);
        }

        if (isset($_REQUEST['team_member_qoute'])) {
            $value = $_POST['team_member_qoute'];
            update_post_meta($post_id, 'team_member_qoute', $value);
        }

        if (isset($_REQUEST['team_member_article_title'])) {
            $value = $_POST['team_member_article_title'];
            update_post_meta($post_id, 'team_member_article_title', $value);
        }

        if (isset($_REQUEST['team_member_article1'])) {
            $value = $_POST['team_member_article1'];
            update_post_meta($post_id, 'team_member_article1', $value);
        }

        if (isset($_REQUEST['team_member_article2'])) {
            $value = $_POST['team_member_article2'];
            update_post_meta($post_id, 'team_member_article2', $value);
        }

        if (isset($_REQUEST['team_member_article3'])) {
            $value = $_POST['team_member_article3'];
            update_post_meta($post_id, 'team_member_article3', $value);
        }
    }

    public function sc_team_switch_skill($value) {
        if ($value < 0)
            return 0;
        elseif ($value > 10)
            return 10;
        else
            return $value;
    }

    public function wpb_load_widget() {
        register_widget('smartcat_team_widget');
    }

    public function smartcat_team_update_order() {
        $post_id = $_POST['id'];
        $sc_member_order = $_POST['sc_member_order'];
        //update_post_meta($post_id, $meta_key, $sc_member_order)
        update_post_meta($post_id, 'sc_member_order', $sc_member_order);
    }

    public function sc_custom_styles() {
        ?>
        <script>
            jQuery(document).ready(function ($) {

                jQuery('.sc-team-table').dataTable({
                    bFilter: <?php echo esc_js($this->options['directory_search_bool']); ?>,
        <?php echo $this->options['directory_sort_bool'] == 1 ? '' : 'aaSorting: [],'; ?>
                });

                $("#smartcat-team-tabs").tabs({
                    collapsible: true
                });
            });
        </script>
        <style>
            #sc_our_team a,
            .sc_our_team_lightbox .name,
            .sc_personal_quote span.sc_team_icon-quote-left,.sc-team-member-posts a{ color: #<?php echo $this->options['text_color']; ?>; }
            .honeycombs .inner_span{ background-color: #<?php echo $this->options['honeycomb_color']; ?>; }
            .grid#sc_our_team .sc_team_member .sc_team_member_name,
            .grid#sc_our_team .sc_team_member .sc_team_member_jobtitle,
            .grid_circles#sc_our_team .sc_team_member .sc_team_member_jobtitle,
            .grid_circles#sc_our_team .sc_team_member .sc_team_member_name,
            #sc_our_team_lightbox .progress,
            .sc_our_team_panel .sc-right-panel .sc-name,
            #sc_our_team .sc_team_member .icons span,
            .sc_our_team_panel .sc-right-panel .sc-skills .progress,
            #sc_our_team_lightbox .sc_our_team_lightbox .social span,
            .sc_team_single_member .sc_team_single_skills .progress,
            .sc-tags .sc-single-tag{ background: #<?php echo $this->options['text_color']; ?>;}
            .sc_our_team_lightbox.honeycomb .progress{ background: #<?php echo $this->options['honeycomb_color']; ?> !important;}
            .stacked#sc_our_team .smartcat_team_member{ border-color: #<?php echo $this->options['text_color']; ?>;}
            .grid#sc_our_team .sc_team_member{ padding: <?php echo $this->options['margin']; ?>px;}
            .sc_our_team_lightbox.honeycomb .name{ color: #<?php echo $this->options['honeycomb_color']; ?>; }
            .sc_team_member .sc_team_member_name{ font-size: <?php echo $this->options['name_font_size']; ?>px !important}
            .sc_team_member .sc_team_member_jobtitle{ font-size: <?php echo $this->options['title_font_size']; ?>px !important}

            div.dataTables_wrapper table.sc-team-table thead tr{ background: #<?php echo $this->options['text_color']; ?>}
            div.dataTables_wrapper table.sc-team-table thead th{ background-color: #<?php echo $this->options['text_color']; ?>}
            #sc_our_team div.dataTables_wrapper div.dataTables_paginate.paging_simple_numbers a.paginate_button.current{
                background: #<?php echo $this->options['text_color']; ?>
            }
            @media( min-width: 480px ){

                #sc_our_team_lightbox .sc_our_team_lightbox { margin-top: <?php echo $this->options['card_margin']; ?>px }
                .sc_our_team_panel{ margin-top: <?php echo $this->options['panel_margin']; ?>px }

            }

        </style>
        <?php
    }

    public function smartcat_set_single_content($content) {
        global $post;

        if (is_single()) :
            if ($post->post_type == 'team_member' &&
                    $this->options['single_template'] == 'standard' &&
                    $this->options['single_social'] == 'yes'
            ) :
                $facebook = get_post_meta(get_the_ID(), 'team_member_facebook', true);
                $twitter = get_post_meta(get_the_ID(), 'team_member_twitter', true);
                $linkedin = get_post_meta(get_the_ID(), 'team_member_linkedin', true);
                $gplus = get_post_meta(get_the_ID(), 'team_member_gplus', true);
                $email = get_post_meta(get_the_ID(), 'team_member_email', true);
                $phone = get_post_meta(get_the_ID(), 'team_member_phone', true);
                $instagram = get_post_meta(get_the_ID(), 'team_member_instagram', true);
                $pinterest = get_post_meta(get_the_ID(), 'team_member_pinterest', true);
                $website = get_post_meta(get_the_ID(), 'team_member_website', true);


                $content .= '<div class="smartcat_team_single_icons">';
                $content .= $this->smartcat_get_social_content($facebook, $twitter, $linkedin, $gplus, $email, $phone, $instagram, $pinterest, $website);
                $content .= '</div><hr>';

                if (null !== get_post_meta(get_the_ID(), 'team_member_article_bool', true) && get_post_meta(get_the_ID(), 'team_member_article_bool', true) == 'on') :

                    $content .= '<div class="sc_team_posts sc_team_post">
                    <h3 class="skills-title">' . get_post_meta(get_the_ID(), 'team_member_article_title', true) . '</h3>';

                    $post1 = get_post_meta(get_the_ID(), 'team_member_article1', true) > 0 ? get_post(get_post_meta(get_the_ID(), 'team_member_article1', true)) : null;
                    $post2 = get_post_meta(get_the_ID(), 'team_member_article2', true) > 0 ? get_post(get_post_meta(get_the_ID(), 'team_member_article2', true)) : null;
                    $post3 = get_post_meta(get_the_ID(), 'team_member_article3', true) > 0 ? get_post(get_post_meta(get_the_ID(), 'team_member_article3', true)) : null;

                    $content .= '<div class="sc-team-member-posts">

                        <div>';
                    if (get_the_post_thumbnail($post1->ID, 'medium')) :
                        $content .= '<div class="width25 left">' . get_the_post_thumbnail($post1->ID, 'medium') . '</div>';
                    endif;

                    $content .= '<div class="width75 left">
                                <a href="' . get_the_permalink($post1->ID) . '">' . get_the_title($post1->ID) . '</a>
                            </div>
                        </div>
                        <div>';

                    if (get_the_post_thumbnail($post2->ID, 'medium')) :
                        $content .= '<div class="width25 left">' . get_the_post_thumbnail($post2->ID, 'medium') . '</div>';
                    endif;

                    $content .= '<div class="width75 left">
                            <a href="' . get_the_permalink($post2->ID) . '">' . get_the_title($post2->ID) . '></a>
                        </div>
                        </div>
                        <div>';


                    if (get_the_post_thumbnail($post3->ID, 'medium')) :
                        $content .= '<div class="width25 left">' . get_the_post_thumbnail($post3->ID, 'medium') . '</div>';
                    endif;

                    $content .= '<div class="width75 left">
                                <a href="' . get_the_permalink($post3->ID) . '">' . get_the_title($post3->ID) . '</a>
                            </div>
                        </div>
                    </div>';
                    echo '</div>';
                endif;

            endif;
        else :

        endif;

        return $content;
    }

    public function add_target() {

        if ($this->options['social_link'] == 'new') :

            return 'target="_BLANK"';

        endif;
    }

    public function set_social($id) {

        $facebook = get_post_meta($id, 'team_member_facebook', true);
        $twitter = get_post_meta($id, 'team_member_twitter', true);
        $linkedin = get_post_meta($id, 'team_member_linkedin', true);
        $gplus = get_post_meta($id, 'team_member_gplus', true);
        $email = get_post_meta($id, 'team_member_email', true);
        $phone = get_post_meta($id, 'team_member_phone', true);
        $pinterest = get_post_meta($id, 'team_member_pinterest', true);
        $instagram = get_post_meta($id, 'team_member_instagram', true);
        $website = get_post_meta($id, 'team_member_website', true);

        if ($this->options['social_link_style'] == 'round') :

            $this->get_social($facebook, $twitter, $linkedin, $gplus, $email, $phone, $pinterest, $instagram, $website);

        else :

            $this->get_social_icons($facebook, $twitter, $linkedin, $gplus, $email, $phone, $pinterest, $instagram, $website);

        endif;
    }

    public function get_social($facebook, $twitter, $linkedin, $gplus, $email, $phone, $pinterest, $instagram, $website) {

        if ($facebook != '')
            echo '<a ' . $this->add_target() . ' href="' . $facebook . '"><img src="' . SC_TEAM_URL . 'inc/img/fb.png" class="sc-social"/></a>';
        if ($twitter != '')
            echo '<a ' . $this->add_target() . ' href="' . $twitter . '"><img src="' . SC_TEAM_URL . 'inc/img/twitter.png" class="sc-social"/></a>';
        if ($gplus != '')
            echo '<a ' . $this->add_target() . ' href="' . $gplus . '"><img src="' . SC_TEAM_URL . 'inc/img/google.png" class="sc-social"/></a>';
        if ($linkedin != '')
            echo '<a ' . $this->add_target() . ' href="' . $linkedin . '"><img src="' . SC_TEAM_URL . 'inc/img/linkedin.png" class="sc-social"/></a>';

        if ($pinterest != '')
            echo '<a ' . $this->add_target() . ' href="' . $pinterest . '"><img src="' . SC_TEAM_URL . 'inc/img/pinterest.png" class="sc-social"/></a>';
        if ($instagram != '')
            echo '<a ' . $this->add_target() . ' href="' . $instagram . '"><img src="' . SC_TEAM_URL . 'inc/img/instagram.png" class="sc-social"/></a>';
        if ($website != '')
            echo '<a ' . $this->add_target() . ' href="' . $website . '"><img src="' . SC_TEAM_URL . 'inc/img/website.png" class="sc-social"/></a>';
        if ($email != '')
//            echo '<a href=mailto:' . $email . '><img src="' . SC_TEAM_URL . 'inc/img/email.png" class="sc-social"/></a>';
            echo '<a href=mailto:' . $email . ' class="fusion-social-network-icon fusion-tooltip fusion-mail fusion-icon-mail"></a>';
        if ($phone != '')
            echo '<a href=tel:' . $phone . '><img src="' . SC_TEAM_URL . 'inc/img/phone.png" class="sc-social"/></a>';
    }

    public function get_social_icons($facebook, $twitter, $linkedin, $gplus, $email, $phone, $pinterest, $instagram, $website) {

        if ($facebook != '')
            echo '<a ' . $this->add_target() . ' href="' . $facebook . '"><span class="sc_team_icon-facebook"></span></a>';
        if ($twitter != '')
            echo '<a ' . $this->add_target() . ' href="' . $twitter . '"><span class="sc_team_icon-twitter"></span></a>';
        if ($gplus != '')
            echo '<a ' . $this->add_target() . ' href="' . $gplus . '"><span class="sc_team_icon-google-plus"></span></a>';
        if ($linkedin != '')
            echo '<a ' . $this->add_target() . ' href="' . $linkedin . '"><span class="sc_team_icon-linkedin"></span></a>';

        if ($pinterest != '')
            echo '<a ' . $this->add_target() . ' href="' . $pinterest . '"><span class="sc_team_icon-pinterest-p"></span></a>';
        if ($instagram != '')
            echo '<a ' . $this->add_target() . ' href="' . $instagram . '"><span class="sc_team_icon-instagram"></span></a>';
        if ($website != '')
            echo '<a ' . $this->add_target() . ' href="' . $website . '"><span class="sc_team_icon-share-alt"></span></a>';
        if ($email != '')
            echo '<a href=mailto:' . $email . '><span class="sc_team_icon-envelope-o"></span></a>';
        if ($phone != '')
            echo '<a href=tel:' . $phone . '><span class="sc_team_icon-phone"></span></a>';
    }

    public function smartcat_get_social_content($facebook, $twitter, $linkedin, $gplus, $email, $phone, $pinterest, $instagram, $website) {

        $content = null;

        if ('yes' == $this->options['social']) {
            if ($facebook != '')
                $content .= '<a ' . $this->add_target() . ' href="' . $facebook . '"><img src="' . SC_TEAM_URL . 'inc/img/fb.png" class="sc-social"/></a>';

            if ($twitter != '')
                $content .= '<a ' . $this->add_target() . ' href="' . $twitter . '"><img src="' . SC_TEAM_URL . 'inc/img/twitter.png" class="sc-social"/></a>';

            if ($gplus != '')
                $content .= '<a ' . $this->add_target() . ' href="' . $gplus . '"><img src="' . SC_TEAM_URL . 'inc/img/google.png" class="sc-social"/></a>';

            if ($linkedin != '')
                $content .= '<a ' . $this->add_target() . ' href="' . $linkedin . '"><img src="' . SC_TEAM_URL . 'inc/img/linkedin.png" class="sc-social"/></a>';

            if ($pinterest != '')
                $content .= '<a ' . $this->add_target() . ' href="' . $pinterest . '"><img src="' . SC_TEAM_URL . 'inc/img/pinterest.png" class="sc-social"/></a>';

            if ($instagram != '')
                $content .= '<a ' . $this->add_target() . ' href="' . $instagram . '"><img src="' . SC_TEAM_URL . 'inc/img/instagram.png" class="sc-social"/></a>';

            if ($email != '')
                $content .= '<a href=mailto:' . $email . '><img src="' . SC_TEAM_URL . 'inc/img/email.png" class="sc-social"/></a>';

            if ($phone != '')
                $content .= '<a href=tel:' . $phone . '><img src="' . SC_TEAM_URL . 'inc/img/phone.png" class="sc-social"/></a>';

            if ($website != '')
                $content .= '<a href=' . $website . '><img src="' . SC_TEAM_URL . 'inc/img/website.png" class="sc-social"/></a>';
        }
        return $content;
    }

    public function set_posts($id) {

        $post1 = get_post_meta($id, 'team_member_article1', true) > 0 ? get_post(get_post_meta($id, 'team_member_article1', true)) : null;
        $post2 = get_post_meta($id, 'team_member_article2', true) > 0 ? get_post(get_post_meta($id, 'team_member_article2', true)) : null;
        $post3 = get_post_meta($id, 'team_member_article3', true) > 0 ? get_post(get_post_meta($id, 'team_member_article3', true)) : null;
        ?>


        <div class="sc-team-member-posts <?php echo $this->options['single_posts_template'] ?>">
            
            <?php if( $post1 ) : ?>
            <div>
                <?php if (get_the_post_thumbnail($post1->ID, 'medium')) : ?>
                    <div class="width25 left"><?php echo get_the_post_thumbnail($post1->ID, 'medium'); ?> </div>
                <?php endif; ?>
                <div class="width75 left">
                    <a href="<?php echo get_the_permalink($post1->ID); ?>"><?php echo get_the_title($post1->ID); ?></a>
                </div>

            </div>
            
            <div class="clear"></div>
            <?php endif; ?>
            
            <?php if( $post2 ) : ?>
            <div>
        <?php if (get_the_post_thumbnail($post2->ID, 'medium')) : ?>
                    <div class="width25 left"><?php echo get_the_post_thumbnail($post2->ID, 'medium'); ?> </div>
        <?php endif; ?>
                <div class="width75 left">
                    <a href="<?php echo get_the_permalink($post2->ID); ?>"><?php echo get_the_title($post2->ID); ?></a>
                </div>

            </div>

            <div class="clear"></div>
            <?php endif; ?>

            <?php if( $post3 ) : ?>
            <div>
        <?php if (get_the_post_thumbnail($post3->ID, 'medium')) : ?>
                    <div class="width25 left"><?php echo get_the_post_thumbnail($post3->ID, 'medium'); ?> </div>
        <?php endif; ?>
                <div class="width75 left">
                    <a href="<?php echo get_the_permalink($post3->ID); ?>"><?php echo get_the_title($post3->ID); ?></a>
                </div>
            </div>
            <?php endif; ?>

        </div>



    <?php
    }

    public function get_single_social($social) {
        if ('yes' == $this->options['social']) :
            if ($social != '')
                echo '<li><a href="' . $social . '"><img src="' . SC_TEAM_URL . 'inc/img/fb.png" class="sc-social"/></a></li>';

        endif;
    }

    public function sc_get_args($group) {
        $args = array(
            'post_type' => 'team_member',
            'meta_key' => 'sc_member_order',
            'orderby' => 'meta_value_num',
            'order' => 'ASC',
            'team_member_position' => $group,
            'posts_per_page' => $this->options['member_count'],
        );
        return $args;
    }

    public function smartcat_team_get_single_template($single_template) {

        global $post;

        if ($post->post_type == 'team_member' && 'custom' == $this->options['single_template']) :

            if (file_exists(get_stylesheet_directory() . '/team_members_template.php')) :

                $single_template = get_stylesheet_directory() . '/team_members_template.php';

            else :

                $single_template = SC_TEAM_PATH . 'inc/template/team_members_template.php';

            endif;

        endif;

        return $single_template;
    }

    public function check_clicker($single_template) {


        if ($single_template == 'vcard') :
            return 'sc_team_single_popup';
        elseif ($single_template == 'panel') :
            return 'sc_team_single_panel';
        elseif ($single_template == 'disable') :
            return 'sc_team_single_disabled';

        endif;

        if ($this->options['single_template'] == 'vcard') :
            return 'sc_team_single_popup';
        elseif ($this->options['single_template'] == 'panel') :
            return 'sc_team_single_panel';
        elseif ($this->options['single_template'] == 'disable') :
            return 'sc_team_single_disabled';
        endif;
    }

    public function load_single_widget($single_template) {

        if ($single_template == 'vcard') :
            return 'lightbox.php';
        elseif ($single_template == 'panel') :
            return 'panel.php';
        endif;


        if ($this->options['single_template'] == 'vcard') :
            return 'lightbox.php';
        elseif ($this->options['single_template'] == 'panel') :
            return 'panel.php';
        else :
            return 'panel.php';
        endif;
    }

    function activate_license() {

        if (isset($_POST['smartcat_our_team_activate'])) {

            $license_key = trim($_POST['smartcat_our_team_key']);

            if (!get_option('smartcat_our_team_key'))
                add_option('smartcat_our_team_key');

            update_option('smartcat_our_team_key', $license_key);

            // data to send in our API request
            $api_params = array(
                'edd_action' => 'activate_license',
                'license' => $license_key,
                'item_name' => urlencode(SMARTCAT_OUR_TEAM_STORE_ITEM_NAME), // the name of our product in EDD
                'url' => home_url()
            );

            $response = wp_remote_post(add_query_arg($api_params, SMARTCAT_STORE_URL), array('timeout' => 15, 'sslverify' => false));


            if (is_wp_error($response))
                return false;

            // decode the license data
            $license_data = json_decode(wp_remote_retrieve_body($response));

            update_option('smartcat_our_team_status', $license_data->license);
        }
    }

    function deactivate_license() {

        if (isset($_POST['smartcat_our_team_deactivate'])) {

            $license_key = get_option('smartcat_our_team_key');

            $api_params = array(
                'edd_action' => 'deactivate_license',
                'license' => $license_key,
                'item_name' => urlencode(SMARTCAT_OUR_TEAM_STORE_ITEM_NAME), // the name of our product in EDD
                'url' => home_url()
            );

            $response = wp_remote_post(add_query_arg($api_params, SMARTCAT_STORE_URL), array('timeout' => 15, 'sslverify' => false));

            // make sure the response came back okay
            if (is_wp_error($response))
                return false;

            $license_data = json_decode(wp_remote_retrieve_body($response));

            if ($license_data->license == 'deactivated') :
                delete_option('smartcat_our_team_status');
                delete_option('smartcat_our_team_key');
            endif;
        }
    }

    function register_option() {
        // creates our settings in the options table
        register_setting('smartcat_our_team_license_settings', 'smartcat_our_team_key', 'sanitize_license');
    }

    function sanitize_license($new) {
        $old = get_option('smartcat_our_team_key');
        if ($old && $old != $new) {
            delete_option('smartcat_our_team_status'); // new license has been entered, so must reactivate
        }
        return $new;
    }

}

class smartcat_team_widget extends WP_Widget {

    function __construct() {
        parent::__construct(
                'smartcat_team_widget', __('Our Team Sidebar Widget', 'smartcat_team_widget_domain'), array('description' => __('Use this widget to display the Our Team anywhere on the site.', 'smartcat_team_widget_domain'),)
        );
    }

    // Creating widget front-end
    // This is where the action happens
    public function widget($args, $instance) {
        $title = apply_filters('widget_title', $instance['title']);

        // before and after widget arguments are defined by themes
        echo $args['before_widget'];
        if (!empty($title))
            echo $args['before_title'] . $title . $args['after_title'];

        // This is where you run the code and display the output
        include SC_TEAM_PATH . 'inc/template/widget.php';
        //        echo $args['after_title'];
    }

    // Widget Backend
    public function form($instance) {
        if (isset($instance['title'])) {
            $title = $instance['title'];
        } else {
            $title = __('Meet Our Team', 'smartcat_team_widget_domain');
        }
        // Widget admin form
        ?>
        <p>
            <label for="////<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
            <input class="widefat" id="////<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
        </p>
        <?php
    }

    // Updating widget replacing old instances with new
    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title']) ) ? strip_tags($new_instance['title']) : '';
        return $instance;
    }

}
