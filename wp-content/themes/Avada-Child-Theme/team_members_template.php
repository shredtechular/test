<?php
get_header();
$options = get_option('smartcat_team_options');
$team = new SmartcatTeamPlugin();
$show_skills = false;

if (null !== get_post_meta(get_the_ID(), 'team_member_skill_bool', true) && get_post_meta(get_the_ID(), 'team_member_skill_bool', true) == 'on') :
    $show_skills = true;
endif;
?>

<div class="sc-single-wrapper">

    <?php while (have_posts()) : the_post(); ?>
        <div class="sc_team_single_member <?php echo $options['single_template']; ?>">

            <div class="sc_single_side <?php echo $options['single_image_style']; ?>" itemscope itemtype="http://schema.org/Person">

                <div class="inner">
                    <?php echo the_post_thumbnail('medium'); ?>
                    <h2 class="name" itemprop="name"><?php echo the_title(); ?></h2>
                    <h3 class="title" itemprop="jobtitle"><?php echo get_post_meta(get_the_ID(), 'team_member_title', true); ?></h3>
                    <ul class="social <?php echo 'yes' == $options['social'] ? '' : 'hidden'; ?>">

                        <?php $team->set_social(get_the_ID()); ?>

                    </ul>
                </div>
            </div>

            <div class="sc_single_main <?php echo true == $show_skills ? 'sc-skills' : ''; ?>">  

                <!--<div class="sc_personal_quote">
                    <span class="sc_team_icon-quote-left"></span>
                    <span class="sc_personal_quote_content"><!--?php echo get_post_meta(get_the_ID(), 'team_member_qoute', true); ?></span>
                </div>-->

                <?php echo the_content(); ?>

                <?php if (null !== get_post_meta(get_the_ID(), 'team_member_article_bool', true) && get_post_meta(get_the_ID(), 'team_member_article_bool', true) == 'on') : ?>
                    <div class="sc_team_posts">
                        <h3 class="skills-title"><?php echo get_post_meta(get_the_ID(), 'team_member_article_title', true) ?></h3>
                        <?php $team->set_posts(get_the_ID()); ?>
                    </div>
                <?php endif; ?>                

            </div>

            <!--?php if (true == $show_skills) : ?>
                <div class="sc_team_single_skills">
                    
                    <div class="inner">
                        <h3 class="skills-title"><!--?php echo $options['skills_title']; ?></h3>
                        <!--?php include 'skills.php'; ?>                   

                    </div>

                    <!--?php if (null !== get_post_meta(get_the_ID(), 'team_member_tags_bool', true) && get_post_meta(get_the_ID(), 'team_member_tags_bool', true) == 'on') : ?>
                        <div class="inner">    
                            <div class="sc-tags">
                                <h3 class="skills-title"><!--?php echo get_post_meta(get_the_ID(), 'team_member_tags_title', true) ?></h3>
                                <!--?php $tags = explode(',', get_post_meta(get_the_ID(), 'team_member_tags', true)); ?>
                                <!--?php if ($tags) : ?>

                                    <!--?php foreach ($tags as $tag) : ?>

                                        <span class="sc-single-tag"><!--?php echo $tag; ?></span>

                                    <!--?php endforeach; ?>

                                <!--?php endif; ?>

                            </div>  
                        </div>
                    <!--?php endif; ?>                     
                </div>
            <!--?php endif; ?>-->
        </div>

    <?php endwhile; ?>
</div>
<?php get_footer(); ?>