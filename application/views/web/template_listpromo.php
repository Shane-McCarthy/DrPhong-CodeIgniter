<?php

function time_elapsed_string($ptime) {
    $etime = time() - $ptime;

    if ($etime < 1) {
        return '0 seconds';
    }

    $a = array(12 * 30 * 24 * 60 * 60 => 'year',
        30 * 24 * 60 * 60 => 'month',
        24 * 60 * 60 => 'day',
        60 * 60 => 'hour',
        60 => 'minute',
        1 => 'second'
    );

    foreach ($a as $secs => $str) {
        $d = $etime / $secs;
        if ($d >= 1) {
            $r = round($d);
            return $r . ' ' . $str . ($r > 1 ? 's' : '');
        }
    }
}

?>


<?php if (!empty($tracks)): ?>
    <div class="promolist">
        <?php $curlink = 1; ?>

        <?php foreach ($tracks as $key => $track): ?>
            <div class="section section-track section-<?php echo ($key % 2) ? 'odd' : 'even'; ?>">
                <div class="section-player">
                    <ul class="tools">		
                        <li class="favdiv" style="text-align:center; margin: 0 0 5px 5px;">
                            <a href="#/ " class="like fav-up" data-id="<?php echo $track->track_id; ?>"></a>
                            <br />
                            <a href="#/" class="unlike fav-down" data-id="<?php echo $track->track_id; ?>" style="margin-top: 3px;"></a>
                        </li>
                    </ul>
                    <h3 class="track_name">
                        <a id="track-<?php echo $curlink; ?>" href="#" title="Play" data-media="<?php echo $track->media_url; ?>" data-post="<?php echo $track->url; ?>" data-trackid="<?php echo $track->track_id; ?>" class="play-ctrl play"><?php echo $track->artist; ?> - <?php echo $track->track; ?><span></span></a>
                        <a href="/#/search/artist/<?php echo urlencode($track->artist); ?>" title="<?php echo $track->artist; ?>" class="artist"><?php echo $track->artist; ?></a> - <a href="/#/artist/<?php echo urlencode($track->artist); ?>/<?php echo urlencode($track->track_id); ?>/<?php echo urlencode($track->track); ?>" title="<?php echo $track->track; ?> - go to page for this track"><?php echo $track->track; ?></a>
                    </h3> 
                    <p style="clear: both; margin: 10px 0;">
                        <a title="Read this post: <?php echo $track->title; ?>" href="<?php echo $track->url; ?>" onmousedown="this.href='<?php echo $track->url; ?>'; return false;" target="_blank" class="readpost">
                            Posted <?php echo time_elapsed_string(mysql_to_unix($track->posted)); ?> ago</a> by 
                        <a href="/#/blog/<?php echo $track->blog_id; ?>/<?php echo urlencode($track->blog_name); ?>" title="See other tracks posted by this blog" class="blog-fav-off"><?php echo $track->blog_name; ?></a>
                    </p>
                    <div class="meta">
                        <span class="buy">
                            <?php if ($track->times_posted > 1): ?>
                                <a href="">Posted by <?php echo $track->times_posted; ?> blogs</a> &bull;
                            <?php endif; ?>
                            Download Artist: 
                            <a href="/#/" rel="nofollow">eMusic</a> &bull; <a href="http://www.amazon.com/gp/redirect.html?ie=UTF8&location=http%3A%2F%2Fwww.amazon.com%2Fs%3Fie%3DUTF8%26x%3D13%26ref_%3Dnb_sb_noss%26y%3D21%26field-keywords%3D<?php echo urlencode($track->artist); ?>%26url%3Dsearch-alias%253Dpopular&tag=doctorphong-20&linkCode=ur2&camp=1789&creative=390957" rel="nofollow" class="nohack" target="_blank">Amazon</a> &bull; <a href="/go/itunes/<?php echo $track->track_id; ?>" rel="nofollow" class="nohack" target="_blank">iTunes</a>
                        </span>
                    </div>
                    <div class="meta">
                        <a href="http://twitter.com/share?text=On Doctor Phong : <?php echo $track->artist; ?> - <?php echo $track->track; ?>&url=http://<?php echo $_SERVER['SERVER_NAME']; ?>/artist/<?php echo urlencode($track->artist); ?>/<?php echo urlencode($track->track_id); ?>/<?php echo urlencode($track->track); ?>&counturl=http://<?php echo $_SERVER['SERVER_NAME']; ?>/artist/<?php echo urlencode($track->artist); ?>/<?php echo urlencode($track->track_id); ?>/<?php echo urlencode($track->track); ?>" class="twitter-share-button">Tweet</a>
                        <iframe src="http://www.facebook.com/plugins/like.php?href=http://<?php echo $_SERVER['SERVER_NAME']; ?>/artist/<?php echo urlencode($track->artist); ?>/<?php echo urlencode($track->track_id); ?>/<?php echo urlencode($track->track); ?>&amp;layout=button_count&amp;show_faces=true&amp;width=150&amp;action=like&amp;font&amp;colorscheme=light&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:100px; height:21px;" allowTransparency="true"></iframe>
                    </div>
                </div>
            </div>
            <?php $curlink++; ?>
        <?php endforeach; ?>
    </div>
<?php else: ?>

<?php endif; ?>
