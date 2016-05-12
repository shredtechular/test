<article id="post-<?php the_ID(); ?>" class="hkb-article" <?php //post_class(); ?>>

    <h3 class="hkb-article__title" itemprop="headline" style="font-size: 16px;font-weight: normal;">
        <a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
    </h3>

    <?php //hkb_get_template_part( 'hkb-article-meta' ); ?>

</article>