<div class="art-sidebar2"> 

<div class="art-Block">
    <div class="art-Block-body">
<div class="art-BlockHeader">
    <div class="art-header-tag-icon">
        <div class="t"><?php _e('Реклама', 'kubrick'); ?></div>
    </div>
</div><div class="art-BlockContent">
    <div class="art-BlockContent-tl"></div>
    <div class="art-BlockContent-tr"></div>
    <div class="art-BlockContent-bl"></div>
    <div class="art-BlockContent-br"></div>
    <div class="art-BlockContent-tc"></div>
    <div class="art-BlockContent-bc"></div>
    <div class="art-BlockContent-cl"></div>
    <div class="art-BlockContent-cr"></div>
    <div class="art-BlockContent-cc"></div>
    <div class="art-BlockContent-body">
<center><?php $adsense_250 = get_option('hunt_adsense_250'); echo stripslashes($adsense_250); ?></center>
    </div>
</div>

    </div>
</div>

     
<?php if (!art_sidebar(2)): ?>
<div class="art-Block">
    <div class="art-Block-body">
<div class="art-BlockHeader">
    <div class="art-header-tag-icon">
        <div class="t"><?php _e('Categories', 'kubrick'); ?></div>
    </div>
</div><div class="art-BlockContent">
    <div class="art-BlockContent-tl"></div>
    <div class="art-BlockContent-tr"></div>
    <div class="art-BlockContent-bl"></div>
    <div class="art-BlockContent-br"></div>
    <div class="art-BlockContent-tc"></div>
    <div class="art-BlockContent-bc"></div>
    <div class="art-BlockContent-cl"></div>
    <div class="art-BlockContent-cr"></div>
    <div class="art-BlockContent-cc"></div>
    <div class="art-BlockContent-body">
<ul>
  <?php wp_list_categories('show_count=1&title_li='); ?>
</ul>
    </div>
</div>

    </div>
</div>
<div class="art-Block">
    <div class="art-Block-body">
<div class="art-BlockHeader">
    <div class="art-header-tag-icon">
        <div class="t"><?php _e('Links:', 'kubrick'); ?></div>
    </div>
</div><div class="art-BlockContent">
    <div class="art-BlockContent-tl"></div>
    <div class="art-BlockContent-tr"></div>
    <div class="art-BlockContent-bl"></div>
    <div class="art-BlockContent-br"></div>
    <div class="art-BlockContent-tc"></div>
    <div class="art-BlockContent-bc"></div>
    <div class="art-BlockContent-cl"></div>
    <div class="art-BlockContent-cr"></div>
    <div class="art-BlockContent-cc"></div>
    <div class="art-BlockContent-body">
<ul>
      <?php wp_list_bookmarks('title_li=&categorize=0'); ?>
      </ul>
    </div>
</div>

    </div>
</div>

<?php endif ?>
</div>
