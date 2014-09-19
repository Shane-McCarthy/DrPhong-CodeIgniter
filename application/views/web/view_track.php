
<?php $this->load->view('web/template_top'); ?>

<div id="content">
	<div class="span-12">
		<div class="corner-all column">
			<div class="column-padding">
				
                <h3 class="track_name">
                    <a id="track-1" href="#" title="Play" data-media="<?php echo $track->media_url; ?>" data-post="<?php echo $track->url; ?>" data-trackid="<?php echo $track->track_id; ?>" class="play-ctrl play"><?php echo $track->artist; ?> - <?php echo $track->track; ?><span></span></a>
                    <a href="/#/search/artist/<?php echo urlencode($track->artist); ?>" title="<?php echo $track->artist; ?>" class="artist"><?php echo $track->artist; ?></a> - <a href="/#/artist/<?php echo urlencode($track->artist); ?>/<?php echo urlencode($track->track_id); ?>/<?php echo urlencode($track->track); ?>" title="<?php echo $track->track; ?> - go to page for this track"><?php echo $track->track; ?></a>
                </h3> 
				
			</div>
		</div>
	</div>
	<?php $this->load->view('web/template_sidebar'); ?>
</div>

<?php $this->load->view('web/template_bottom'); ?>
