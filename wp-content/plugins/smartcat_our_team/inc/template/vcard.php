<?php
get_header();
$options = get_option( 'smartcat_team_options' );
?>
<?php
$facebook = get_post_meta( get_the_ID(), 'team_member_facebook', true );
$twitter = get_post_meta( get_the_ID(), 'team_member_twitter', true );
$linkedin = get_post_meta( get_the_ID(), 'team_member_linkedin', true );
$gplus = get_post_meta( get_the_ID(), 'team_member_gplus', true );
$email = get_post_meta( get_the_ID(), 'team_member_email', true );
?>
<div>
    <?php while ( have_posts() ) : the_post(); ?>
        <div class="sc_team_single_member <?php echo $options[ 'single_template' ]; ?>">

            <div class="sc_single_side <?php echo $options[ 'single_image_style' ]; ?>" itemscope itemtype="http://schema.org/Person">
                
                <div class="inner">
                    <?php echo the_post_thumbnail( 'medium' ); ?>
                    <h2 class="name" itemprop="name"><?php echo the_title(); ?></h2>
                    <h3 class="title" itemprop="jobtitle"><?php echo get_post_meta( get_the_ID(), 'team_member_title', true ); ?></h3>
                    <ul class="social">
                        <?php if ( $facebook ) : ?><li><a href="<?php echo $facebook; ?>"><img src="<?php echo SC_TEAM_URL; ?>inc/img/fb.png" class="sc-social"/>Facebook</a></li><?php endif; ?>
                        <?php if ( $twitter ) : ?><li><a href="<?php echo $twitter; ?>"><img src="<?php echo SC_TEAM_URL; ?>inc/img/twitter.png" class="sc-social"/>Twitter</a></li><?php endif; ?>
                        <?php if ( $linkedin ) : ?><li><a href="<?php echo $linkedin; ?>"><img src="<?php echo SC_TEAM_URL; ?>inc/img/linkedin.png" class="sc-social"/>Linkedin</a></li><?php endif; ?>
                        <?php if ( $gplus ) : ?><li><a href="<?php echo $gplus; ?>"><img src="<?php echo SC_TEAM_URL; ?>inc/img/google.png" class="sc-social"/>Google Plus</a></li><?php endif; ?>
                        <?php if ( $email ) : ?><li><a href="mailto:<?php echo $email; ?>"><img src="<?php echo SC_TEAM_URL; ?>inc/img/email.png" class="sc-social"/><?php echo $email; ?></a></li><?php endif; ?>
                    </ul>
                </div>
            </div>
            
            <div class="sc_single_main <?php echo 'yes' == $options['single_skills'] ? 'sc-skills' : ''; ?>">              
                <?php echo the_content(); ?>             
            </div>
            <?php if( 'yes' == $options['single_skills'] ) : ?>
            <div class="sc_team_single_skills">
                <div class="inner">
                <?php //echo get_post_meta(  get_the_ID(), 'team_member_skill1', TRUE); ?>
                    <div class="progress">
                      <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
                        <span class="sr-only">40% Complete (success)</span>
                      </div>
                    </div>

                    <div class="progress">
                      <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
                        <span class="sr-only">40% Complete (success)</span>
                      </div>
                    </div>

                    <div class="progress">
                      <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
                        <span class="sr-only">40% Complete (success)</span>
                      </div>
                    </div>

                    <div class="progress">
                      <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
                        <span class="sr-only">40% Complete (success)</span>
                      </div>
                    </div>
                </div>
             </div>             
            <?php endif; ?>
        </div>

    <?php endwhile; ?>
</div>
<?php get_footer(); ?>