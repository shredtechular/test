<?php include_once 'setting.php'; extract( get_option('smartcat_team_options')); ?>

<?php if( ! $this->strap_pl() ) : exit( 'Please activate your license <a class="button-primary" href="' . admin_url( 'edit.php?post_type=team_member&page=smartcat_team_license' ) . '">Activate</a>' ); endif; ?>

<div class="width70 left">
    <p>To display the Team, copy and paste this shortcode into the page or widget where you want to show it. 
        <input type="text" readonly="readonly" value="[our-team]" style="width: 130px" onfocus="this.select()"/>
    <div>You can set the <strong>template</strong>, <strong>single_template</strong> and group in the <strong>shortcode</strong></div>
    </p>
    <p><iframe src="//www.facebook.com/plugins/like.php?href=https%3A%2F%2Fwww.facebook.com%2FSmartcatDesign&amp;width&amp;layout=standard&amp;action=like&amp;show_faces=false&amp;share=false&amp;height=35&amp;appId=233286813420319" scrolling="no" frameborder="0" style="border:none; overflow:hidden; height:35px;" allowTransparency="true"></iframe></p>
    
    <form name="sc_our_team_post_form" method="post" action="" enctype="multipart/form-data">
        <table class="widefat">
            <thead>
                <tr>
                    <th colspan="2"><b>Team View Settings</b></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Template</td>
                    <td>
                        <select name="smartcat_team_options[template]" id="sc_our_team_template">
                            <option>Select Template</option>
                            <option value="grid" <?php echo 'grid' == esc_attr( $template ) ? 'selected=selected' : ''; ?>>Grid - Boxes</option>
                            <option value="grid_circles" <?php echo 'grid_circles' == esc_attr( $template ) ? 'selected=selected' : ''; ?>>Grid - Circles</option>
                            <option value="grid_circles2" <?php echo 'grid_circles2' == esc_attr( $template ) ? 'selected=selected' : ''; ?>>Grid - Circles Version 2</option>
                            <option value="stacked" <?php echo 'stacked' == esc_attr( $template ) ? 'selected=selected' : ''; ?>>List - Stacked</option>
                            <option value="hc" <?php echo 'hc' == esc_attr( $template ) ? 'selected=selected' : ''; ?>>Honey Comb</option>
                            <option value="carousel" <?php echo 'carousel' == esc_attr( $template ) ? 'selected=selected' : ''; ?>>Carousel</option>
                            <option value="directory" <?php echo 'directory' == esc_attr( $template ) ? 'selected=selected' : ''; ?>>Staff Directory</option>
                        </select>
                    </td>
                </tr>
                
                <tr>
                    <td>Carousel Slide Speed</td>
                    <td>
                        <input type="text" value="<?php echo esc_attr( $carousel_play ); ?>" name="smartcat_team_options[carousel_play]" placeholder="speed in milli-seconds"/><br>
                        <em>Set to "false" to disable slider</em>
                    </td>
                </tr>                
                
                <tr id="columns-row">
                    <td>Grid Columns</td>
                    <td>
                        <select name="smartcat_team_options[columns]">
                            <option value="2" <?php echo '2' == esc_attr ( $columns ) ? 'selected=selected' : ''; ?>>2</option>
                            <option value="3" <?php echo '3' == esc_attr ( $columns ) ? 'selected=selected' : ''; ?>>3</option>
                            <option value="4" <?php echo '4' == esc_attr( $columns ) ? 'selected=selected' : ''; ?>>4</option>
                            <option value="5" <?php echo '5' == esc_attr( $columns ) ? 'selected=selected' : ''; ?>>5</option>
                            <option value="10" <?php echo '10' == esc_attr( $columns ) ? 'selected=selected' : ''; ?>>10</option>
                        </select>
                    </td>
                </tr>                


                <tr id="margin-row">
                    <td>Margin</td>
                    <td>
                        <select name="smartcat_team_options[margin]">
                            <option value="0" <?php echo '0' == esc_attr( $margin ) ? 'selected=selected' : ''; ?>>No margin</option>
                            <option value="5" <?php echo '5' == esc_attr( $margin ) ? 'selected=selected' : ''; ?>>5</option>
                            <option value="10" <?php echo '10' == esc_attr( $margin ) ? 'selected=selected' : ''; ?>>10</option>
                            <option value="15" <?php echo '15' == esc_attr( $margin ) ? 'selected=selected' : ''; ?>>15</option>
                        </select>px
                    </td>
                </tr>                
                
                <tr id="social_icons_row">
                    <td><?php _e('Display Social Icons') ?></td>
                    <td>
                        <select name="smartcat_team_options[social]">
                            <option value="yes" <?php echo 'yes' == esc_attr( $social ) ? 'selected=selected' : ''; ?>>Yes</option>
                            <option value="no" <?php echo 'no' == esc_attr( $social ) ? 'selected=selected' : ''; ?>>No</option>
                        </select>
                    </td>
                </tr>
                
                <tr id="social_links_row">
                    <td><?php _e('Social Icon Links') ?></td>
                    <td>
                        <select name="smartcat_team_options[social_link]">
                            <option value="" <?php echo '' == esc_attr( $social_link ) ? 'selected=selected' : ''; ?>>Same Page</option>
                            <option value="new" <?php echo 'new' == esc_attr( $social_link ) ? 'selected=selected' : ''; ?>>New Page</option>
                        </select>
                    </td>
                </tr>
                
                <tr id="social_links_style_row">
                    <td><?php _e('Social Icons Style') ?></td>
                    <td>
                        <select name="smartcat_team_options[social_link_style]">
                            <option value="round" <?php echo 'round' == esc_attr( $social_link_style ) ? 'selected=selected' : ''; ?>>Round</option>
                            <option value="flat" <?php echo 'flat' == esc_attr( $social_link_style ) ? 'selected=selected' : ''; ?>>Flat</option>
                        </select>
                    </td>
                </tr>
                
                <tr id="">
                    <td>Display Name</td>
                    <td>
                        <select name="smartcat_team_options[name]">
                            <option value="yes" <?php echo 'yes' == esc_attr( $name ) ? 'selected=selected' : ''; ?>>Yes</option>
                            <option value="no" <?php echo 'no' == esc_attr( $name ) ? 'selected=selected' : ''; ?>>No</option>
                        </select>
                    </td>
                </tr>
                
                <tr id="">
                    <td>Name Font Size</td>
                    <td>
                        <input class="width25" type="text" value="<?php echo esc_attr( $name_font_size ); ?>" name="smartcat_team_options[name_font_size]"/> px<br>
                    </td>
                </tr>
                
                <tr id="">
                    <td>Display Title</td>
                    <td>
                        <select name="smartcat_team_options[title]">
                            <option value="yes" <?php echo 'yes' == esc_attr( $title )? 'selected=selected' : ''; ?>>Yes</option>
                            <option value="no" <?php echo 'no' == esc_attr( $title ) ? 'selected=selected' : ''; ?>>No</option>
                        </select>
                    </td>
                </tr>                
                
                <tr id="">
                    <td>Title Font Size</td>
                    <td>
                        <input class="width25" type="text" value="<?php echo esc_attr( $title_font_size ); ?>" name="smartcat_team_options[title_font_size]"/> px<br>
                    </td>
                </tr>
                

                <tr>
                    <td>Number of members to display</td>
                    <td>
                        <input type="text" value="<?php echo esc_attr( $member_count ); ?>" name="smartcat_team_options[member_count]" placeholder="number of members to show"/><br>
                        <em>Set to -1 to display all members</em>
                    </td>
                </tr>
                

                <tr>
                    <td>Max Word Count</td>
                    <td>
                        <input type="text" value="<?php echo esc_attr( $word_count ); ?>" name="smartcat_team_options[word_count]" placeholder="Max # of words"/><br>
                        <em>Limit the number of words to output. </em>
                    </td>
                </tr>
                
                <tr>
                    <td>Main Color</td>
                    <td>
                        <input class="wp_popup_color width25" type="text" value="<?php echo esc_attr( $text_color ); ?>" name="smartcat_team_options[text_color]"/>
                    </td>
                </tr>
                <tr id="honey-comb-row">
                    <td>Honey Comb Color</td>
                    <td>
                        <input class="wp_popup_color width25" type="text" value="<?php echo esc_attr( $honeycomb_color ) ; ?>" name="smartcat_team_options[honeycomb_color]"/>
                    </td>
                </tr>
                
                <tr>
                    <td>Single Team Member Permalink Slug</td>
                    <td>
                        <input name="smartcat_team_options[slug]" value="<?php echo esc_attr( $slug ); ?>" />
                        <p><em>Changing this value will change the default "team_member" value in the URL,<br> example: http://mysite.com/<b><?php echo $slug ?></b>/member-name</em></p>
                    </td>
                </tr>
                
            </tbody>
        </table>
        
        <table class="widefat">
            <thead>
                <tr>
                    <th colspan="2"><b>Single Member View Settings</b></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Template</td>
                    <td>
                        <select name="smartcat_team_options[single_template]">
                            <option>Select Template</option>
                            <option value="standard" <?php echo 'standard' == esc_attr( $single_template ) ? 'selected=selected' : ''; ?>>Theme Default (single post)</option>
                            <option value="custom" <?php echo 'custom' == esc_attr( $single_template ) ? 'selected=selected' : ''; ?>>Custom Template</option>
                            <option value="vcard" <?php echo 'vcard' == esc_attr( $single_template ) ? 'selected=selected' : ''; ?>>Card (pop-up)</option>
                            <option value="panel" <?php echo 'panel' == esc_attr( $single_template ) ? 'selected=selected' : ''; ?>>Side Panel</option>
                            <option value="disable" <?php echo 'disable' == esc_attr( $single_template ) ? 'selected=selected' : ''; ?>>Disabled</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Card Margin From Top</td>
                    <td>
                        <input class="width25" type="text" value="<?php echo esc_attr( $card_margin ) ; ?>" name="smartcat_team_options[card_margin]"/> px
                    </td>
                </tr>
                <tr>
                    <td>Panel Margin From Top</td>
                    <td>
                        <input class="width25" type="text" value="<?php echo esc_attr( $panel_margin ) ; ?>" name="smartcat_team_options[panel_margin]"/> px
                    </td>
                </tr>
                
                <tr id="">
                    <td>Display Social Icons</td>
                    <td>
                        <select name="smartcat_team_options[single_social]">
                            <option value="yes" <?php echo 'yes' == esc_attr( $single_social ) ? 'selected=selected' : ''; ?>>Yes</option>
                            <option value="no" <?php echo 'no' == esc_attr( $single_social ) ? 'selected=selected' : ''; ?>>No</option>
                        </select>
                    </td>
                </tr>
                
<!--                <tr id="">
                    <td>Display Skills Bar</td>
                    <td>
                        <select name="smartcat_team_options[single_skills]">
                            <option value="yes" <?php echo 'yes' == esc_attr( $single_skills ) ? 'selected=selected' : ''; ?>>Yes</option>
                            <option value="no" <?php echo 'no' == esc_attr( $single_skills ) ? 'selected=selected' : ''; ?>>No</option>
                        </select>
                    </td>
                </tr>-->
                
<!--                <tr>
                    <td>Skills Title</td>
                    <td>
                        <input class="" type="text" value="<?php echo esc_attr( $skills_title ) ; ?>" name="smartcat_team_options[skills_title]"/>
                    </td>
                </tr>-->
                
<!--                <tr id="">
                    <td>Display Favorite Posts</td>
                    <td>
                        <select name="smartcat_team_options[single_posts]">
                            <option value="yes" <?php echo 'yes' == esc_attr( $single_posts ) ? 'selected=selected' : ''; ?>>Yes</option>
                            <option value="no" <?php echo 'no' == esc_attr( $single_posts ) ? 'selected=selected' : ''; ?>>No</option>
                        </select>
                    </td>
                </tr>
                
                <tr>
                    <td>Favorite Posts Title</td>
                    <td>
                        <input class="" type="text" value="<?php echo esc_attr( $posts_title ) ; ?>" name="smartcat_team_options[posts_title]"/>
                    </td>
                </tr>-->
    
                
                
                <tr>
                    <td>Image Style</td>
                    <td>
                        <select name="smartcat_team_options[single_image_style]">
                            <option>Select Style</option>
                            <option value="square" <?php echo 'square' == esc_attr( $single_image_style ) ? 'selected=selected' : ''; ?>>Square</option>
                            <option value="circle" <?php echo 'circle' == esc_attr( $single_image_style ) ? 'selected=selected' : ''; ?>>Circle</option>
                        </select>
                    </td>
                </tr>
                
                <tr>
                    <td colspan="2"><strong>Skills, Favorite Posts & additional attributes</strong> can be customized for each Team Member by going to All Team Members then click Edit on the person you want to customize</td>
                </tr>

            </tbody>
        </table>
        
        <table class="widefat">
            <thead>
                <tr>
                    <th colspan="2"><strong><?php _e( 'Staff Directory Options', '' ); ?></strong></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Display Title ?</td>
                    <td>
                        <input type="radio" name="smartcat_team_options[directory_title_bool]" value="yes" <?php checked( 'yes', $directory_title_bool ); ?>/> Yes
                        <input type="radio" name="smartcat_team_options[directory_title_bool]" value="no" <?php checked( 'no', $directory_title_bool ); ?>/> No <br>
                        
                        <input type="text" name="smartcat_team_options[directory_title]" value="<?php echo $directory_title; ?>" />
                    </td>
                </tr>
                <tr>
                    <td>Display Group ?</td>
                    <td>
                        <input type="radio" name="smartcat_team_options[directory_group_bool]" value="yes" <?php checked( 'yes', $directory_group_bool ); ?>/> Yes
                        <input type="radio" name="smartcat_team_options[directory_group_bool]" value="no" <?php checked( 'no', $directory_group_bool ); ?>/> No <br>
                        <input type="text" name="smartcat_team_options[directory_group]" value="<?php echo $directory_group; ?>" />
                    </td>
                </tr>
                <tr>
                    <td>Display Phone Number ?</td>
                    <td>
                        <input type="radio" name="smartcat_team_options[directory_phone_bool]" value="yes" <?php checked( 'yes', $directory_phone_bool ); ?>/> Yes
                        <input type="radio" name="smartcat_team_options[directory_phone_bool]" value="no" <?php checked( 'no', $directory_phone_bool ); ?>/> No <br>
                        
                        <input type="text" name="smartcat_team_options[directory_phone]" value="<?php echo $directory_phone; ?>" />
                    </td>
                </tr>
                <tr>
                    <td>Enable Search ?</td>
                    <td>
                        <input type="radio" name="smartcat_team_options[directory_search_bool]" value="1" <?php checked( '1', $directory_search_bool ); ?>/> Yes
                        <input type="radio" name="smartcat_team_options[directory_search_bool]" value="0" <?php checked( '0', $directory_search_bool ); ?>/> No <br>
                        
                        <input type="text" name="smartcat_team_options[directory_search]" value="<?php echo $directory_search; ?>" />
                    </td>
                </tr>
                <tr>
                    <td>Sort Alphabetically ?</td>
                    <td>
                        <input type="radio" name="smartcat_team_options[directory_sort_bool]" value="1" <?php checked( '1', $directory_sort_bool ); ?>/> Yes
                        <input type="radio" name="smartcat_team_options[directory_sort_bool]" value="0" <?php checked( '0', $directory_sort_bool ); ?>/> No <br>
                        
                    </td>
                </tr>
            </tbody>
        </table>
        
        <?php do_action( 'sc_team_settings_page' ); ?>
        
        <div style="text-align: right">
            <input type="hidden" name="smartcat_team_options[redirect]" value=""/>
            <input type="submit" name="sc_our_team_save" value="Update" class="button button-primary button-hero" />
        </div>
    </form>
</div>    
</div>
<script>
    function confirm_reset() {
        if (confirm("Are you sure you want to reset to defaults ?")) {
            return true;
        } else {
            return false;
        }
    }
    jQuery(document).ready(function($) {
        $("#sc_popup_shortcode").focusout(function() {
            var shortcode = jQuery(this).val();
            shortcode = shortcode.replace(/"/g, "").replace(/'/g, "");
            jQuery(this).val(shortcode);
        });

    });

</script>