<?php

/**
 *
 * @author Bilal Hassan <bilal@smartcat.ca>
 * @date September 17th, 2015
 *
 * Renders the full team directory
 *
 */
$args = $this->sc_get_args( $group );
$members = new WP_Query( $args );
?>

<script type="text/javascript">
jQuery(document).ready( function($){

});

</script>

<div id="sc_our_team" class="<?php
echo $template == '' ? $this->options[ 'template' ] : $template;
echo ' sc-col' . $this->options[ 'columns' ];
?>">
    <div class="clear"></div>



    <?php
    if ( $members->have_posts() ) { ?>

    <table class="dataTable hover sc-team-table responsive">
        <thead>
            <tr>
                <th><?php _e( 'Name', 'sc-team') ?></th>
                
                
                <?php if( isset( $this->options['directory_title_bool'] ) && $this->options['directory_title_bool'] == 'yes' ) : ?>
                <th><?php echo $this->options['directory_title'] ? $this->options['directory_title'] : ''; ?></th>
                <?php endif; ?>
                
                <?php if( isset( $this->options['directory_group_bool'] ) && $this->options['directory_group_bool'] == 'yes' ) : ?>
                <th><?php echo $this->options['directory_group'] ? $this->options['directory_group'] : ''; ?></th>
                <?php endif; ?>
                
                <?php if( isset( $this->options['directory_phone_bool'] ) && $this->options['directory_phone_bool'] == 'yes' ) : ?>
                <th><?php echo $this->options['directory_phone'] ? $this->options['directory_phone'] : ''; ?></th>
                <?php endif; ?>
                
            </tr>
        </thead>
        <tbody>

        <?php while ( $members->have_posts() ) {
            $members->the_post();
            ?>
            <tr itemscope itemtype="http://schema.org/Person" class="sc_team_member">
                <!--<div class="sc_team_member_inner">-->
                <td>
                    <?php if ( 'yes' == $this->options[ 'name' ] ) : ?>
                        <div itemprop="name" class="sc_team_member_name">
                            <a href="<?php the_permalink() ?>" rel="bookmark" class="<?php echo $this->check_clicker( $single_template ); ?>">
                                <?php the_title() ?>
                            </a>
                        </div>
                    <?php endif; ?>
                    
<div class="sc_team_content">
                        <?php the_content(); ?>
                    </div>

                    <div class='icons <?php echo 'yes' == $this->options[ 'social' ] ? '' : 'hidden'; ?>'>

                        <?php $this->set_social( get_the_ID() ); ?>

                    </div>
                    
                    <?php
                    if ( has_post_thumbnail() )
                        echo the_post_thumbnail( 'medium' );
                    else {
                        echo '<img src="' . SC_TEAM_URL . 'inc/img/noprofile.jpg" class="attachment-medium wp-post-image"/>';
                    }
                    ?>
                    
                    <?php if( null !== get_post_meta( get_the_ID(), 'team_member_article_bool', true ) && get_post_meta( get_the_ID(), 'team_member_article_bool', true ) == 'on' ) : ?>
                    <div class="sc_team_posts">
                        <h3 class="skills-title"><?php echo get_post_meta( get_the_ID(), 'team_member_article_title', true ) ?></h3>
                        <?php $this->set_posts( get_the_ID() ); ?>
                    </div>
                    <?php endif; ?>

                    <?php if( null !== get_post_meta( get_the_ID(), 'team_member_skill_bool', true ) && get_post_meta( get_the_ID(), 'team_member_skill_bool', true ) == 'on' ) : ?>
                    <div class="sc_team_skills">
                        <h3 class="skills-title"><?php echo get_post_meta( get_the_ID(), 'team_member_skill_title', true ) ?></h3>
                        <?php include 'skills.php'; ?>
                    </div>  
                    <?php endif; ?>

                    <?php if( null !== get_post_meta( get_the_ID(), 'team_member_tags_bool', true ) && get_post_meta( get_the_ID(), 'team_member_tags_bool', true ) == 'on' ) : ?>
                    <div class="sc_team_tags">
                        <h3 class="skills-title"><?php echo get_post_meta( get_the_ID(), 'team_member_tags_title', true ) ?></h3>
                        <?php $tags =  explode( ',', get_post_meta( get_the_ID(), 'team_member_tags', true ) ); ?>
                        <?php if( $tags ) : ?>

                            <?php foreach( $tags as $tag ) : ?>

                            <span class="sc-single-tag"><?php echo $tag; ?></span>

                            <?php endforeach; ?>

                        <?php endif; ?>

                    </div>  
                    <?php endif; ?>                     
                    
                </td>
                
                <?php if( isset( $this->options['directory_title_bool'] ) && $this->options['directory_title_bool'] == 'yes' ) : ?>
                <td>
                    <?php if ( 'yes' == $this->options[ 'title' ] && get_post_meta( get_the_ID(), 'team_member_title', true )) : ?>
                        <div itemprop="jobtitle" class="sc_team_member_jobtitle">
                            <?php echo get_post_meta( get_the_ID(), 'team_member_title', true ); ?>
                        </div>
                    <?php endif; ?>
                </td>
                <?php endif; ?>
                
                
                <?php if( isset( $this->options['directory_group_bool'] ) && $this->options['directory_group_bool'] == 'yes' ) : ?>
                <td>
                    <?php //$terms = get_terms('team_member_position') ? get_terms('team_member_position') : ''; ?>
                    <?php $terms = wp_get_post_terms(get_the_ID(), 'team_member_position') ? wp_get_post_terms(get_the_ID(), 'team_member_position') : ''; ?>
                    
                    <?php echo( $terms ? $terms[0]->name : ''); ?>
                    <div class="sc_personal_quote">
                        <?php if( get_post_meta(get_the_ID(), 'team_member_qoute', true ) ) : ?>
                            <span class="sc_team_icon-quote-left"></span>
                            <span class="sc_personal_quote_content"><?php echo get_post_meta(get_the_ID(), 'team_member_qoute', true ); ?></span>
                        <?php endif; ?>
                    </div>


                    


                </td>
                <?php endif; ?>
                
                
                <?php if( isset( $this->options['directory_phone_bool'] ) && $this->options['directory_phone_bool'] == 'yes' ) : ?>
                <td><?php echo get_post_meta(get_the_ID(), 'team_member_phone', true ); ?></td>
                <?php endif; ?>
                <!--</div>-->

            </tr>
            <?php
        }
        wp_reset_postdata(); ?>

    </tbody>
    </table>

    <?php } else {
        echo 'There are no team members to display';
    }
    ?>
    <div class="clear"></div>
</div>

<?php

if( $this->load_single_widget( $single_template ) ) :

    include_once $this->load_single_widget( $single_template );

endif;

?>