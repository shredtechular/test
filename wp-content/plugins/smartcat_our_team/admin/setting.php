<style>
    #gopro{
        width: 100%;
        display: block;
        clear: both;
        padding: 10px;
        margin: 10px 8px 15px 5px;
        border: 1px solid #e1e1e1;
        background: #464646;
        color: #ffffff;
        overflow: hidden;
    }
    #wrapper{
        border: 1px solid #f0f0f0;
        width: 95%;

    }
    #wrapper{
        border: 1px solid #f0f0f0;
        width: 95%;

    }
    table.widefat{
        margin-bottom: 15px;
    }
    table.widefat tr{
        transition: 0.3s all ease-in-out;
        -moz-transition: 0.3s all ease-in-out;
        -webkit-transition: 0.3s all ease-in-out;
    }
    table.widefat tr:hover{
        /*background: #E6E6E6;*/
    }

    #wrapper input[type='text']{
        width: 80%;
        transition: 0.3s all ease-in-out;
        -moz-transition: 0.3s all ease-in-out;
        -webkit-transition: 0.3s all ease-in-out;
    }
    #wrapper input[type='text']:focus{
        border: 1px solid #1784c9;
        box-shadow: 0 0 7px #1784c9;
        -moz-box-shadow: 0 0 5px #1784c9;
        -webkit-box-shadow: 0 0 5px #1784c9;
    }
    #wrapper input[type='text'].small-text{
        width: 20%;
    }
    .proversion{
        color: red;
        font-style: italic;
    }
    .choose-progress{
        display: none;
    }
    .sc_popup_mode{
        display: inline-block;
        width: 15px;
        height: 15px;
        border-radius: 100%;
        position: relative;
        top: 2px;
        box-shadow: 0 0 3px #333;
        -moz-box-shadow: 0 0 3px #333;
        -webkit-box-shadow: 0 0 3px #333;
    }

    .sc_popup_mode_off{
        background: #F54412;
    }
    .sc_popup_mode_live{
        background: #84E11F;
    }
    .sc_popup_mode_test{
        background: #FF9717;
    }
    .left{ float: left;}
    .right {float: right;}
    .center{text-align: center;}
    .width70{ width: 70%;}
    .width25{ width: 25% !important;}
    .width50{ width: 50%;}
    .larger{ font-size: larger;}
    .bold{ font-weight: bold;}
    .editcursor{ cursor: text}
</style>

<div id="wrapper">
    <div id="gopro">
        <div class="left">
            <h1><b style="color: #79D9FF">Our Team Showcase Pro</b></h1>
            <div>Professional, sleek and easily customizable Team page & widget with extra options!</div>
        </div>
<!--        <div class="right">
            <a href="https://smartcatdesign.net/products/#.wordpress-plugins" target="_blank" class="button-primary" style="padding: 40px;line-height: 0;font-size: 20px">More Plugins</a>
        </div>-->
    </div>
    <div class="width25 right">
        
        <table class="widefat">
            <thead>
            <tr>
                <th><b>Quick Reference</b> </th>
            </tr>
            <tr>
                <td>
                    <ul>
                        <li>- Image recommended size is 400x400 px. To achieve the best appearance, please ensure all team member images are the same size.</li>
                        <li>- To display the team members, add <b>[our-team]</b> shortcode in a widget, post or page</li>
                        <li>- To display members from a specific group, add <b>[our-team group="name of your group"]</b></li>
                        <li>- To override the template choice from the shortcode, add <b>[our-team template="grid"]</b> . Template Options: <em>grid, grid_circles, grid_circles2, carousel, hc, stacked</em></li>
                        <li>- To override the single template choice from the shortcode add <b>[our-team single_template="vcard"]</b>. Other option is <b>panel</b> </li>
                        <li>- Click on Re-order to arrange the order of the team members</li>
                        <li>- Click on Groups to create groups (example: department, team names)</li>
                        <li>- Custom Template: Copy /inc/template/team_members_template.php into your theme root folder and edit</li>
                    </ul>
                    
                </td>
            </tr>
            </thead>
        </table>        
        
        <table class="widefat">
            <thead>
                <tr>
                    <th><?php _e( 'Team Member Portal (add-on)', 'our-team' ); ?></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><img src="<?php echo SC_TEAM_URL ?>inc/img/member_portal_logo.png" width="100%"/></td>
                </tr>
                <tr>
                    <td>
                        This extension of Our Team Showcase creates a private portal on your site for your team members to login, view restricted content, edit their own profile details & profile picture, while giving the site admin complete control, user management, content restriction by group/department and more!                    
                    </td>
                </tr>
                <tr>
                    <td style="text-align:center">
                        <a target="_blank" href="https://smartcatdesign.net/downloads/member-login-portal/" class="button-primary"><?php _e('View Plugin', 'our-team' ); ?></a>
                    </td>
                </tr>
                
            </tbody>
        </table>
        
        <table class="widefat">
            <thead>

            <tr>
                <td>
                    <p>If you come across any bugs or issues, please <strong><a href="https://smartcatdesign.net/faqs/" target="_blank">contact us</a></strong> and let us know</p>
                </td>
            </tr>
            </thead>
        </table>


    </div>