<?php $license = get_option('smartcat_our_team_key'); $status = get_option('smartcat_our_team_status'); ?>
<form name="post_form" method="post" action="" enctype="multipart/form-data">
    <?php settings_fields('smartcat_our_team_license_settings'); ?>
    <table class="widefat" id="license">
        <thead>
            <tr>
                <th colspan="2"><?php _e('License', 'sc-construction'); ?></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><?php _e('Enter your license key'); ?></td>
                <td>

                    <?php if ( $this->strap_pl() ) { ?>
                        <span style="color:green;"><?php _e('License Activated'); ?><i class="fa fa-check"></i></span>
                        <?php wp_nonce_field('smartcat_our_team_nonce', 'smartcat_our_team_nonce'); ?>
                        <input type="submit" class="button-secondary" name="smartcat_our_team_deactivate" value="<?php _e('Deactivate License'); ?>"/>
                        <?php
                    } else {
                        wp_nonce_field('smartcat_our_team_nonce', 'smartcat_our_team_nonce');
                        ?>
                        <p style="color: red">You have not activated your License. Please enter your license key and click Activate</p>
                        <input id="smartcat_our_team_key" name="smartcat_our_team_key" type="text" class="regular-text" value="<?php esc_attr_e($license); ?>" />
                        <input type="submit" class="button-secondary" name="smartcat_our_team_activate" value="<?php _e('Activate License'); ?>"/>
                    <?php } ?>

                </td>
            </tr>
        </tbody>
    </table>              
</form>