<?php
/*
 * Short description
 * @author bilal hassan <info@smartcatdesign.net>
 * 
 */
$args = $this->sc_get_args( $group );
$members = new WP_Query( $args );


?>
<script type="text/javascript">
jQuery(document).ready( function($){
    jQuery('#sc_our_team').owlCarousel({
        items : <?php echo esc_js(  $this->options[ 'columns' ] ) ?>,
        autoPlay : <?php echo esc_js(  $this->options[ 'carousel_play' ] ) ?>,
    });
});

</script>
<div id="sc_our_team" class="<?php 
    echo $template == '' ? $this->options[ 'template' ] : $template;
    //echo ' sc-col' . $this->options[ 'columns' ];
?>">
    <?php
    if ( $members->have_posts() ) {
        while ( $members->have_posts() ) {
            $members->the_post();
            ?>
            <div itemscope itemtype="http://schema.org/Person" class="sc_team_member">
                <div class="sc_team_member_inner">

                    <?php
                    if ( has_post_thumbnail() ) { ?>
                    <a href="<?php the_permalink() ?>" rel="bookmark" class="<?php echo $this->check_clicker( $single_template ); ?>"> 
                        <?php echo the_post_thumbnail( 'medium' ); ?>
                    </a>
                    <?php } else {
                        echo '<img src="' . SC_TEAM_URL . 'inc/img/noprofile.jpg" class="attachment-medium wp-post-image"/>';
                    }
                    ?>

                    <?php if ( 'yes' == $this->options[ 'name' ] ) : ?>
                        <div itemprop="name" class="sc_team_member_name">
                            <a href="<?php the_permalink() ?>" rel="bookmark" class="<?php echo $this->check_clicker( $single_template ); ?>">                            
                                <?php the_title() ?>
                            </a>
                        </div>
                    <?php endif; ?>

                    <?php if ( 'yes' == $this->options[ 'title' ] ) : ?>
                        <div itemprop="jobtitle" class="sc_team_member_jobtitle">
                            <?php echo get_post_meta( get_the_ID(), 'team_member_title', true ); ?>
                        </div>
                    <?php endif; ?>
                    
                    
                    
                    <div class="">
                        <?php echo wp_trim_words( get_the_content( '...' ), 20 ); ?>
                    </div>

                    <?php if( get_post_meta(get_the_ID(), 'team_member_qoute', true ) ) : ?>
                    <div class="sc_personal_quote">
                        <span class="sc_team_icon-quote-left"></span>
                        <span class="sc_personal_quote_content"><?php echo get_post_meta(get_the_ID(), 'team_member_qoute', true ); ?></span>
                    </div>                    
                    <?php endif; ?>
                    
                    <div class="sc_team_content">
                        <?php echo get_the_content(); ?>
                    </div>

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
                    
                    <div class='icons <?php echo 'yes' == $this->options[ 'social' ] ? '' : 'hidden'; ?>'>

                        <?php $this->set_social( get_the_ID() ); ?>

                    </div>
                    
                </div>

            </div>
            <?php
        }
        wp_reset_postdata();
    } else {
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

