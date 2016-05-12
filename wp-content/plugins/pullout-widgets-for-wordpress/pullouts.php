<?php
/*
  Plugin Name: Pullout Widgets
  Plugin URI: http://simplerealtytheme.com/plugins/pullout-widgets/
  Description: Turn regular sidebar widgets into a slick pull out widget: from left, right, top or bottom of the screen.
  Author: Max Chirkov
  Version: 2.9.2
  Author URI: http://SimpleRealtyTheme.com
 */

//supports: false (bool), phone, tablet, mobile
if( !defined('POW_OFF') )
    define('POW_OFF', 'phone');

define('POW_JS_MIN', false); //load minified main JS file


pow_off();
function pow_off()
{
    if( false == POW_OFF )
    {
        pow_actions();
        return;
    }

    if( !class_exists('Mobile_Detect') )
        include( dirname(__FILE__) . '/lib/Mobile_Detect.php' );

    $detect = new Mobile_Detect();
    switch( POW_OFF )
    {
        case "phone":
            if ( $detect->isMobile() && !$detect->isTablet() )
                return;
            break;
        case "tablet":
            if ( $detect->isTablet() )
                return;
            break;
        case "mobile":
            if ( $detect->isMobile() )
                return;
            break;
    }
    pow_actions();
}


function pow_actions()
{
    add_action('pow_vars_initialized', 'pow_scripts');
    add_action('admin_init', 'pow_admin_scripts');
    add_action('in_widget_form', 'pow_add_widget_fields');
    add_filter('widget_update_callback', 'pow_widget_update_callback', 1, 4);
    add_filter('sidebars_widgets', 'pow_js_vars', 20);
    add_action('register_sidebar', 'pow_fix_widget_ids', 20);
    add_action('widgets_init', 'init_pullout_sidebar');

    // Priority -10 to load it as early as possible (before footer js)
    // NextGen Gallery changes the order of loaded items, which messes things up
    add_action('wp_footer', 'add_pullout_sidebar_into_footer', -10);
}


global $pow_js_vars;

function pow_scripts(){
    global $pow_js_vars;

    if( !$pow_js_vars )
        return;

    $pow_js = ( POW_JS_MIN ) ? 'pullouts.min.js' : 'pullouts.js';

    wp_enqueue_style('pullouts', plugins_url() . '/' . plugin_basename(dirname( __FILE__ )) . '/css/pullouts.css');
    wp_register_script('pullouts', plugins_url() . '/' . plugin_basename(dirname( __FILE__ )) . '/js/' . $pow_js, array('jquery'), '2.8', true);
    wp_register_script('jquery-appear', plugins_url() . '/' . plugin_basename(dirname( __FILE__ )) . '/js/jquery.appear-1.1.1.min.js', array('jquery'), '1.1.1', true);
    wp_enqueue_script('jquery');
    wp_enqueue_script('jquery-ui-core');
    wp_enqueue_script('jquery-effects-core');
    wp_enqueue_script('pullouts');
    wp_enqueue_script('jquery-appear');
    wp_localize_script( 'pullouts', 'powVars', $pow_js_vars );
}


function pow_admin_scripts(){
    //grab URL's basename and separate if from any uri queries
    $current_url =  explode( '?', basename( $_SERVER['REQUEST_URI'] ) );
    //make sure we're loading scripts on widgets.php page
    if( 'widgets.php' ==  $current_url[0] ){
        wp_enqueue_script('jquery');
        wp_enqueue_script('jquery-ui-core');
        wp_enqueue_script('jquery-ui-accordion');
        wp_enqueue_script('jquery-ui-widget');
        wp_enqueue_script('jquery-ui-dialog');
        wp_enqueue_style('wp-jquery-ui-dialog');
        wp_enqueue_style( 'farbtastic' );
        wp_enqueue_script( 'farbtastic' );

        $widgets_css = plugins_url() . '/' . plugin_basename(dirname( __FILE__ )) . '/css/admin_widgets.css';
        wp_enqueue_style( 'pullouts_admin_widgets_css', $widgets_css );
        $widgets_js = plugins_url() . '/' . plugin_basename(dirname( __FILE__ )) . '/js/admin_widgets.js';
        wp_register_script( 'pullouts_admin_widgets_js', $widgets_js, array('jquery-ui-dialog',), '1.0', true );
        wp_enqueue_script( 'pullouts_admin_widgets_js' );
    }
}


function pow_add_widget_fields($widget, $instance = false){
    if( !$instance && is_numeric($widget->number) ){
        $widget_settings = get_option($widget->option_name);
        $instance = $widget_settings[$widget->number];
    }
    //don't generate fields for "available", but not used widgets
    if( '__i__' == substr($widget->id, -5) )
         return;
    ?>
    <div id="wrap-pow-<?php echo $widget->id; ?>" class="wrap-pow-opt">
        <div class="alignleft">
            <label for="<?php echo $widget->get_field_id('pow_on'); ?>" title="<?php _e('Turn Pullout On', 'pow');?>" style="display:inline"><?php _e('Turn Pullout On', 'pow');?></label>
            <input type="checkbox" id="<?php echo $widget->get_field_id('pow_on'); ?>" name="<?php echo $widget->get_field_name('pow_on'); ?>" value="1" <?php checked( @$instance['pow_on'], '1'  );?> />
        </div>
        <div class="alignright">
            <a href="#" rel="pow-<?php echo $widget->id; ?>" class="pow_dialog button" title="<?php _e('Pullout Widget Options', 'pow');?>" ><?php _e('Pullout Options', 'pow');?></a>
        </div>
        <div style="clear: both"></div>

        <div id="pow-<?php echo $widget->id; ?>" class="pow_options">

            <div class="pow-accordion">

                <h3><a href="#">Positioning</a></h3>
                <div>
                    <p>
                        <label for="<?php echo $widget->get_field_id('pow_side'); ?>" title="<?php _e('Screen Side', 'pow');?>" style="display:inline-block; width: 40%;"><?php _e('Screen Side', 'pow');?></label>
                        <select id="<?php echo $widget->get_field_id('pow_side'); ?>" name="<?php echo $widget->get_field_name('pow_side'); ?>"  style="display:inline-block; width: 40%">
                            <option value="left" <?php selected(@$instance['pow_side'], 'left');?>>Left</option>
                            <option value="right" <?php selected(@$instance['pow_side'], 'right');?>>Right</option>
                            <option value="top" <?php selected(@$instance['pow_side'], 'top');?>>Top</option>
                            <option value="bottom" <?php selected(@$instance['pow_side'], 'bottom');?>>Bottom</option>
                        </select>
                    </p>
                    <p>
                        <label for="<?php echo $widget->get_field_id('pow_anchor'); ?>" title="<?php _e('Position on the Side', 'pow');?>" style="display:inline-block; width: 40%;"><?php _e('Position on the Side', 'pow');?></label>
                        <input id="<?php echo $widget->get_field_id('pow_anchor'); ?>" name="<?php echo $widget->get_field_name('pow_anchor'); ?>" type="text" value="<?php echo ( @$instance['pow_anchor'] ) ? @$instance['pow_anchor'] : '30%'; ?>" style="display:inline-block; width: 20%" /> <small>Examples: 30% or 300px.</small>
                    </p>
                    <p>
                        <label for="<?php echo $widget->get_field_id('pow_scroll'); ?>" title="<?php _e('Scroll with Page', 'pow');?>" style="display:inline-block; width: 40%;"><?php _e('Scroll with Page', 'pow');?></label>
                        <input type="checkbox" id="<?php echo $widget->get_field_id('pow_scroll'); ?>" name="<?php echo $widget->get_field_name('pow_scroll'); ?>" value="1" <?php checked( @$instance['pow_scroll'], '1'  );?> /><br /><small>By default all pullouts have fixed positions. Bottom widgets do not scroll.</small>
                    </p>
                </div>


                <h3><a href="#">Behavior</a></h3>
                <div>
                    <p>
                        <label for="<?php echo $widget->get_field_id('pow_show_on'); ?>" title="<?php _e('Show', 'pow');?>" style="display:inline-block; width: 40%;"><?php _e('Show/Slide Out', 'pow');?></label>
                        <select id="<?php echo $widget->get_field_id('pow_show_on'); ?>" name="<?php echo $widget->get_field_name('pow_show_on'); ?>"  style="display:inline-block; width: 50%">
                            <option value="click" <?php selected(@$instance['pow_show_on'], 'click');?>>on Click</option>
                            <option value="mouseover" <?php selected(@$instance['pow_show_on'], 'mouseover');?>>on Mouse Over</option>
                            <option value="appear_once" <?php selected(@$instance['pow_show_on'], 'appear_once');?>>Once - when Element Appears on Screen</option>
                            <option value="appear" <?php selected(@$instance['pow_show_on'], 'appear');?>>Always - when Element Appears on Screen</option>
                            <option value="timer_once" <?php selected(@$instance['pow_show_on'], 'timer_once');?>>Once - After X Seconds</option>
                            <option value="timer" <?php selected(@$instance['pow_show_on'], 'timer');?>>Always - After X Seconds</option>
                            <option value="n_pages_once" <?php selected(@$instance['pow_show_on'], 'n_pages_once');?>>Once - After Visiting X Pages</option>
                            <option value="n_pages" <?php selected(@$instance['pow_show_on'], 'n_pages');?>>Always - After Visiting X Pages</option>
                        </select>
                    </p>
                    <p class="pow_element">
                        <label for="<?php echo $widget->get_field_id('pow_element'); ?>" title="<?php _e('Element ID/Class', 'pow');?>" style="display:inline-block; width: 40%;"><?php _e('Element ID/Class', 'pow');?></label>
                        <input id="<?php echo $widget->get_field_id('pow_element'); ?>" name="<?php echo $widget->get_field_name('pow_element'); ?>" type="text" value="<?php echo @$instance['pow_element']; ?>" />
                        <br /><small>Element ID/Class should be entered like in CSS: #my_id or .my_class.</small>
                    </p>
                    <p class="pow_timer">
                        <label for="<?php echo $widget->get_field_id('pow_timer'); ?>" title="<?php _e('Set Timer', 'pow');?>" style="display:inline-block; width: 40%;"><?php _e('Set Timer', 'pow');?></label>
                        <input id="<?php echo $widget->get_field_id('pow_timer'); ?>" name="<?php echo $widget->get_field_name('pow_timer'); ?>" type="text" value="<?php echo @$instance['pow_timer']; ?>" />
                    </p>
                    <p class="pow_n_pages">
                        <label for="<?php echo $widget->get_field_id('pow_n_pages'); ?>" title="<?php _e('Number of Pages', 'pow');?>" style="display:inline-block; width: 40%;"><?php _e('Number of Pages', 'pow');?></label>
                        <input id="<?php echo $widget->get_field_id('pow_n_pages'); ?>" name="<?php echo $widget->get_field_name('pow_n_pages'); ?>" type="text" value="<?php echo @$instance['pow_n_pages']; ?>" />
                    </p>
                    <p>
                        <label for="<?php echo $widget->get_field_id('pow_easing'); ?>" title="<?php _e('Easing Effect', 'pow');?>" style="display:inline-block; width: 40%;"><?php _e('Easing Effect', 'pow');?></label>
                        <select id="<?php echo $widget->get_field_id('pow_easing'); ?>" name="<?php echo $widget->get_field_name('pow_easing'); ?>"  style="display:inline-block; width: 50%">
                            <?php
                            $easing = array(
                                'linear',
                                'swing',
                                'easeInQuad',
                                'easeOutQuad',
                                'easeInOutQuad',
                                'easeInCubic',
                                'easeOutCubic',
                                'easeInOutCubic',
                                'easeInQuart',
                                'easeOutQuart',
                                'easeInOutQuart',
                                'easeInQuint',
                                'easeOutQuint',
                                'easeInOutQuint',
                                'easeInSine',
                                'easeOutSine',
                                'easeInOutSine',
                                'easeInExpo',
                                'easeOutExpo',
                                'easeInOutExpo',
                                'easeInCirc',
                                'easeOutCirc',
                                'easeInOutCirc',
                                'easeInElastic',
                                'easeOutElastic',
                                'easeInOutElastic',
                                'easeInBack',
                                'easeOutBack',
                                'easeInOutBack',
                                'easeInBounce',
                                'easeOutBounce',
                                'easeInOutBounce',
                            );

                            foreach($easing as $ez){
                                echo '<option value="' . $ez . '" ' . selected(@$instance['pow_easing'], $ez) . '>' . $ez . '</option>' . "\n";
                            }
                            ?>
                        </select>
                        <br /><small>"Easing" is a sliding effect. <a href="http://jqueryui.com/demos/effect/easing.html" target="_blank">View this demo</a> to see all effects in action.</small>
                    </p>
                    <p>
                        <label for="<?php echo $widget->get_field_id('pow_speed'); ?>" title="<?php _e('Sliding Speed', 'pow');?>" style="display:inline-block; width: 40%;"><?php _e('Sliding Speed', 'pow');?></label>
                        <input type="text" id="<?php echo $widget->get_field_id('pow_speed'); ?>" name="<?php echo $widget->get_field_name('pow_speed'); ?>"  style="display:inline-block; width: 25%" value="<?php if(@$instance['pow_speed']) { echo @$instance['pow_speed']; }else{ echo '1000'; }?>" /> <small>milli seconds</small>
                    </p>
                </div>


                <h3><a href="#">Style</a></h3>
                <div>
                    <p>
                        <label for="<?php echo $widget->get_field_id('pow_width'); ?>" title="<?php _e('Widget Width', 'pow');?>" style="display:inline-block; width: 40%;"><?php _e('Widget Width', 'pow');?></label>
                        <input id="<?php echo $widget->get_field_id('pow_width'); ?>" name="<?php echo $widget->get_field_name('pow_width'); ?>" type="text" value="<?php echo @$instance['pow_width']; ?>" style="display:inline-block; width: 20%" />px
                    </p>
                    <p>
                        <label for="<?php echo $widget->get_field_id('pow_color'); ?>" title="<?php _e('Background Color', 'pow');?>" style="display:inline-block; width: 40%;"><?php _e('Background Color', 'pow');?></label>
                        <?php
                        $color = ( @$instance['pow_color'] ) ? @$instance['pow_color'] : '#';
                        ?>
                        <input id="<?php echo $widget->get_field_id('pow_color'); ?>" name="<?php echo $widget->get_field_name('pow_color'); ?>" class="pow_color" type="text" value="<?php echo $color; ?>" />
                    </p>
                    <div class="color-picker" style="position: relative;">
                        <div style="position: absolute;" id="colorpicker-<?php echo $widget->get_field_id('pow_color'); ?>"></div>
                    </div>
                    <p>
                        <label for="<?php echo $widget->get_field_id('pow_border_color'); ?>" title="<?php _e('Border Color', 'pow');?>" style="display:inline-block; width: 40%;"><?php _e('Border Color', 'pow');?></label>
                        <?php
                        $text_color = ( @$instance['pow_border_color'] ) ? @$instance['pow_border_color'] : '#';
                        ?>
                        <input id="<?php echo $widget->get_field_id('pow_border_color'); ?>" name="<?php echo $widget->get_field_name('pow_border_color'); ?>" class="pow_color" type="text" value="<?php echo $text_color; ?>" />
                    </p>
                    <div class="color-picker" style="position: relative;">
                        <div style="position: absolute;" id="colorpicker-<?php echo $widget->get_field_id('pow_border_color'); ?>"></div>
                    </div>
                    <p>
                        <label for="<?php echo $widget->get_field_id('pow_text_color'); ?>" title="<?php _e('Text Color', 'pow');?>" style="display:inline-block; width: 40%;"><?php _e('Text Color', 'pow');?></label>
                        <?php
                        $text_color = ( @$instance['pow_text_color'] ) ? @$instance['pow_text_color'] : '#';
                        ?>
                        <input id="<?php echo $widget->get_field_id('pow_text_color'); ?>" name="<?php echo $widget->get_field_name('pow_text_color'); ?>" class="pow_color" type="text" value="<?php echo $text_color; ?>" />
                    </p>
                    <div class="color-picker" style="position: relative;">
                        <div style="position: absolute;" id="colorpicker-<?php echo $widget->get_field_id('pow_text_color'); ?>"></div>
                    </div>
                    <p>
                        <label for="<?php echo $widget->get_field_id('pow_link_color'); ?>" title="<?php _e('Link Color', 'pow');?>" style="display:inline-block; width: 40%;"><?php _e('Link Color', 'pow');?></label>
                        <?php
                        $text_color = ( @$instance['pow_link_color'] ) ? @$instance['pow_link_color'] : '#';
                        ?>
                        <input id="<?php echo $widget->get_field_id('pow_link_color'); ?>" name="<?php echo $widget->get_field_name('pow_link_color'); ?>" class="pow_color" type="text" value="<?php echo $text_color; ?>" />
                    </p>
                    <div class="color-picker" style="position: relative;">
                        <div style="position: absolute;" id="colorpicker-<?php echo $widget->get_field_id('pow_link_color'); ?>"></div>
                    </div>

                    <p>
                        <label title="<?php _e('Trim Styles', 'pow');?>" style="display:inline-block; width: 40%;"><?php _e('Trim Styles', 'pow');?></label>
                        <input type="checkbox" id="<?php echo $widget->get_field_id('pow_rounded_corners'); ?>" name="<?php echo $widget->get_field_name('pow_rounded_corners'); ?>" value="1" <?php checked( @$instance['pow_rounded_corners'], '1'  );?> /> <?php _e('Rounded Corners', 'pow');?>
                        <input type="checkbox" id="<?php echo $widget->get_field_id('pow_borders'); ?>" name="<?php echo $widget->get_field_name('pow_borders'); ?>" value="1" <?php checked( @$instance['pow_borders'], '1'  );?> /> <?php _e('Borders', 'pow');?>
                    </p>
                </div>

                <h3><a href="#">PullOut Tab</a></h3>
                <div>
                    <p>
                        <label for="<?php echo $widget->get_field_id('pow_tab_offset'); ?>" title="<?php _e('Tab Offset', 'pow');?>" style="display:inline-block; width: 40%;"><?php _e('Tab Offset', 'pow');?></label>
                        <input size="5" type="text" id="<?php echo $widget->get_field_id('pow_tab_offset'); ?>" name="<?php echo $widget->get_field_name('pow_tab_offset'); ?>" value="<?php echo (@$instance['pow_tab_offset']) ? @$instance['pow_tab_offset'] : 0; ?>" />
                        <select name="<?php echo $widget->get_field_name('pow_tab_offset_type'); ?>" id="<?php echo $widget->get_field_id('pow_tab_offset_type'); ?>">
                            <option value="%" <?php selected( @$instance['pow_tab_offset_type'], '%'  );?>>%</option>
                            <option value="px" <?php selected( @$instance['pow_tab_offset_type'], 'px'  );?>>px</option>
                        </select>
                    </p>
                    <p>
                        <label for="<?php echo $widget->get_field_id('pow_rotate'); ?>" title="<?php _e('Vertical Tab', 'pow');?>" style="display:inline-block; width: 40%;"><?php _e('Vertical Tab', 'pow');?></label>
                        <input type="checkbox" id="<?php echo $widget->get_field_id('pow_rotate'); ?>" name="<?php echo $widget->get_field_name('pow_rotate'); ?>" value="1" <?php checked( @$instance['pow_rotate'], '1'  );?> /><br /><small>Diplays tab vertically along the side of the screen. Left and right sides only.</small>
                    </p>

                    <label for="<?php echo $widget->get_field_id('pow_icon'); ?>" title="<?php _e('Tab Icon', 'pow');?>" style="display:inline-block; width: 40%;"><?php _e('Tab Icon', 'pow');?></label>
                    <input id="<?php echo $widget->get_field_id('pow_icon'); ?>" name="<?php echo $widget->get_field_name('pow_icon'); ?>" type="hidden" value="<?php echo @$instance['pow_icon']; ?>" />
                    <?php
                    pow_icons_selector($widget->id, $widget->get_field_id('pow_icon'), @$instance['pow_icon']);
                    ?>
                    <p>
                        <label for="<?php echo $widget->get_field_id('pow_open_label'); ?>" title="<?php _e('"Open" Label', 'pow');?>" style="display:inline-block; width: 40%;"><?php _e('"Open" Label', 'pow');?></label>
                        <input id="<?php echo $widget->get_field_id('pow_open_label'); ?>" name="<?php echo $widget->get_field_name('pow_open_label'); ?>" type="text" value="<?php echo @$instance['pow_open_label']; ?>"/>
                    </p>
                    <p>
                        <label for="<?php echo $widget->get_field_id('pow_close_label'); ?>" title="<?php _e('"Close" Label', 'pow');?>" style="display:inline-block; width: 40%;"><?php _e('"Close" Label', 'pow');?></label>
                        <input id="<?php echo $widget->get_field_id('pow_close_label'); ?>" name="<?php echo $widget->get_field_name('pow_close_label'); ?>" type="text" value="<?php echo @$instance['pow_close_label']; ?>"/>
                    </p>
                    <p>
                        <label for="<?php echo $widget->get_field_id('pow_no_label'); ?>" title="<?php _e('Hide Text Label', 'pow');?>" style="display:inline-block; width: 40%;"><?php _e('Hide Text Label', 'pow');?></label>
                        <input type="checkbox" id="<?php echo $widget->get_field_id('pow_no_label'); ?>" name="<?php echo $widget->get_field_name('pow_no_label'); ?>" value="1" <?php checked( @$instance['pow_no_label'], '1'  );?> /><small>In case you wish to display icon only.</small>
                    </p>
                </div>

            </div>

        </div>
    </div>
    <?php
}

function pow_icons_selector($widget_id, $field_id, $pow_icon = false)
{
    $pow_icons_grid_template = str_replace('%widget_id%', $widget_id, _icons_grid());
    $pow_icons_grid_template = str_replace('%field_id%', $field_id, $pow_icons_grid_template);

    $x = 0;
    $y = 0;
    if( $pow_icon )
    {
        $pow_icons_grid = str_replace('icon_id_' . $pow_icon, 'pow_icon_selected', $pow_icons_grid_template);
        $x_y = explode('_', $pow_icon);
        $x = intval($x_y[0]) * 36;
        $y = intval($x_y[1]) * 36;
    }
    else
    {
         $pow_icons_grid =  $pow_icons_grid_template;
    }

    $icon_preview = ($x-7)*(-1) . "px " . ($y-7)*(-1) . "px";


    $preview_style = ( isset($icon_preview) ) ? ' style="background-position: '. $icon_preview .'"' : '';
    echo '<span class="pow_icon_preview"'. $preview_style .'"></span>';
    echo '<div class="pow_icons_wrap"><div id="icons_' . $widget_id .'" class="pow_icons">'. $pow_icons_grid . '</div></div>';

}


function _icons_grid()
{
    $cols = 10;
    $rows = 29;
    $icon_preview = false;
    $options = '';
    for($n = 0; $n<$cols; $n++){
        for($i = 0; $i<$rows; $i++){
            $x = $n * 36;
            $y = $i * 36;
            $icon_id = $n . '_' . $i;
            $class = ' class="pow_icon icon_id_' . $icon_id . '"';

            $options .= '<div widget_id="%widget_id%" rel="%field_id%" id="' . $n . '_' . $i . '" style="position: absolute; top: ' . $y .'px; left: ' . $x . 'px;"' . $class . '></div>';
        }
    }
    return $options;
}


/**
 * Update instance parameters with visibility conditions on widget save action.
 */
function pow_widget_update_callback($instance, $new_instance, $old_instance, $this){
    //sometimes for unknown to me reason all widget settings get lost
    //since I can't pin-point the issue, hopefully the code below will prevent that
    if( $old_instance && (empty($new_instance) || '' == $new_instance || !$new_instance) )
        return $old_instance;

    $instance['pow_on']             = $new_instance['pow_on'];
    $instance['pow_side']           = $new_instance['pow_side'];
    $instance['pow_anchor']         = $new_instance['pow_anchor'];
    $instance['pow_scroll']         = $new_instance['pow_scroll'];
    $instance['pow_show_on']        = $new_instance['pow_show_on'];
    $instance['pow_timer']          = $new_instance['pow_timer'];
    $instance['pow_n_pages']        = $new_instance['pow_n_pages'];
    $instance['pow_color']          = $new_instance['pow_color'];
    $instance['pow_border_color']   = $new_instance['pow_border_color'];
    $instance['pow_text_color']     = $new_instance['pow_text_color'];
    $instance['pow_link_color']     = $new_instance['pow_link_color'];
    $instance['pow_speed']          = $new_instance['pow_speed'];
    $instance['pow_rotate']         = $new_instance['pow_rotate'];
    $instance['pow_width']          = $new_instance['pow_width'];
    $instance['pow_icon']           = ( '0_0' == $new_instance['pow_icon'] ) ? false : $new_instance['pow_icon'];
    $instance['pow_no_label']       = $new_instance['pow_no_label'];
    $instance['pow_rounded_corners'] = $new_instance['pow_rounded_corners'];
    $instance['pow_borders']        = $new_instance['pow_borders'];
    $instance['pow_tab_offset']     = $new_instance['pow_tab_offset'];
    $instance['pow_tab_offset_type']= $new_instance['pow_tab_offset_type'];
    $instance['pow_element']        = $new_instance['pow_element'];
    $instance['pow_easing']         = $new_instance['pow_easing'];
    $instance['pow_open_label']     = $new_instance['pow_open_label'];
    $instance['pow_close_label']    = $new_instance['pow_close_label'];

    return $instance;
}


function pow_js_vars($sidebar_widgets){
    global $wp_registered_widgets, $pow_js_vars;

    //if $pow_js_vars already set then no need for processing
    //don't apply conditions in the admin dashboard
    if($pow_js_vars || is_admin() || empty($sidebar_widgets))
        return $sidebar_widgets;

    $pullouts = false;

    //unset wp_inactive_widgets to get only active ones
    $active_sidebar_widgets = $sidebar_widgets;
    unset($active_sidebar_widgets['wp_inactive_widgets']);

    //loop through each sidebar
    foreach($active_sidebar_widgets as $sidebar => $widgets){
        //if sidebar has no widgets - skip the internal loop
        if( empty($widgets) )
            continue;

        //loop through each registered widget
        foreach ($widgets as $widget_id) {

            //reset widget object since we're in the loop
            $widget = false;
            $number = false; //widget instance number
            /* Note regarding the $number:
            originally I took $number from $widget->number,
            but it seems like it represents some sort of total number, which
            doesn't always reflect the current insance number. In that case the
            instance conditions were applied incorrectly.
            */
            if(isset($wp_registered_widgets[$widget_id]['callback'][0])){
                //get widget object by widget_id
                $widget = $wp_registered_widgets[$widget_id]['callback'][0];
                $number = $wp_registered_widgets[$widget_id]['params'][0]['number'];
            }


            if( !$widget || !$number )
                continue;

            //get widget settings
            $widget_settings = get_option($widget->option_name);
            //get instance of this particular widget by parameter number
            $instance = $widget_settings[$number];

            if( !isset($instance['pow_on']) || $instance['pow_on'] == false )
                continue;

            $wid = $widget_id;

            //make compatible with custom css_id in ATW
            if( isset($instance['css_id']) && $instance['css_id'] != null )
                $wid = $instance['css_id'];

            $pullouts[$wid] = array(
                'position'  => array(
                    'side'      => $instance['pow_side'], //left/right/top/bottom
                    'anchor'    => 0, // 0/1 - top/bottom for vertical and left/right for horicontal
                    'distance'  => ($instance['pow_anchor']) ? $instance['pow_anchor'] : '30%', //distance from anchor - default 30%
                    'scroll'    => ($instance['pow_scroll']) ? true : false, //false/true - scroll with content
                ),
                'style'     => array(
                    'show_on'   => $instance['pow_show_on'], // mouseover/click
                    'speed'     => $instance['pow_speed'], // normal/slow/fast
                    'color'     => $instance['pow_color'],
                    'border_color' => $instance['pow_border_color'],
                    'text_color'   => $instance['pow_text_color'],
                    'link_color'   => $instance['pow_link_color'],
                    'rotate'    => $instance['pow_rotate'],
                    'width'     => $instance['pow_width'],
                    'label'     => $instance['title'],
                    'icon'      => $instance['pow_icon'],
                    'no_label'  => $instance['pow_no_label'],
                    'rounded'   => $instance['pow_rounded_corners'],
                    'borders'   => $instance['pow_borders'],
                    'tab_offset'=> $instance['pow_tab_offset'],
                    'tab_offset_type'=> $instance['pow_tab_offset_type'],
                    'open_label'    => ($instance['pow_open_label']) ? $instance['pow_open_label'] : false,
                    'close_label'   => ($instance['pow_close_label']) ? $instance['pow_close_label'] : false,
                ),
                'behavior'  => array(
                    'timer'     => $instance['pow_timer'],
                    'n_pages'   => $instance['pow_n_pages'],
                    'element'   => $instance['pow_element'],
                    'easing'    => $instance['pow_easing'],
                ),
            );

        }
    }
    $pow_js_vars = $pullouts;
    do_action('pow_vars_initialized');

    return $sidebar_widgets;
}

/**
 * Check if registered sidebars have correct markup that contains widget IDs
 * if not - it adds wrappers to widgets with their original IDs.
 */
function pow_fix_widget_ids($sidebar)
{
    global $wp_registered_sidebars;

    $before_widget = '<div id="%1$s">';
    $after_widget = '</div>';
    if ( isset($sidebar['before_widget']) )
    {
        if ( empty($sidebar['before_widget']) )
        {
            $sidebar['before_widget'] = $before_widget;
            $sidebar['after_widget'] = $after_widget;
        }
        elseif( !stristr($sidebar['before_widget'], '%1$s') )
        {
            $sidebar['before_widget'] = $sidebar['before_widget'] . $before_widget;
            $sidebar['after_widget'] = $after_widget . $sidebar['after_widget'];
        }

        $wp_registered_sidebars[$sidebar['id']] = $sidebar;
    }
}


/* PullOut Widgets Sidebar-Container */
function init_pullout_sidebar(){
    register_sidebar( array(
        'name' => 'PullOut Widgets Container',
        'id' => 'pullout_widgets_sidebar',
        'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ) );
}


function add_pullout_sidebar_into_footer(){
    if ( is_active_sidebar( 'pullout_widgets_sidebar' ) ) {
        dynamic_sidebar( 'pullout_widgets_sidebar' );
    }
}