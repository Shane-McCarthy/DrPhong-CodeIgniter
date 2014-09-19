
<?php $this->load->view('web/template_top'); ?>

<div class="phong-default">
	
	<div id="content">
		<div class="span-16">
			
			<h1>Latest Blogged Music</h1>
			<?php $this->load->view('web/template_list', array('tracks' => cTrack::findLatest())); ?>
			
		</div>
		
		<div class="span-8 last">
			<h4 class="sidebar">Explore by Doctor Phong Genre</h4>
			<div id="browse-genres">
				<ul>
					<li><a href="/#/tags/dance/">Dance</a></li>
					<li><a href="/#/tags/experimental">Experimental</a></li>
					<li><a href="/#/tags/electronic">Electronic</a></li>
					<li><a href="/#/tags/funk">Funk</a></li>
					<li><a href="/#/tags/hip-hop">Hip-Hop</a></li>
					<li><a href="/#/tags/indie">Indie</a></li>
					<li><a href="/#/tags/instrumental">Instrumental</a></li>
					<li><a href="/#/tags/post-punk">Post-Punk</a></li>
					<li><a href="/#/tags/rock">Rock</a></li>
					<li><a href="/#/tags/singer-songwriter">Singer-Songwriter</a></li>
					<li><a onclick="$('#tags_more').show();$(this).hide();return false;">MORE &raquo;</a></li>
				</ul>
				<ul style="display:none;" id="tags_more">
					<li><a href="/#/tags/alternative">Alternative</a></li>
					<li><a href="/#/tags/pop">Pop</a></li>
					<li><a href="/#/tags/folk">Folk</a></li>
					<li><a href="/#/tags/female vocalists">Female Vocalists</a></li>
					<li><a href="/#/tags/lo-fi">Lo-fi</a></li>
					<li><a href="/#/tags/electro">Electro</a></li>
					<li><a href="/#/tags/ambient">Ambient</a></li>
					<li><a href="/#/tags/House">House</a></li>
					<li><a href="/#/tags/british">British</a></li>
					<li><a href="/#/tags/rap">Rap</a></li>
					<li><a href="/#/tags/psychedelic">Psychedelic</a></li>
					<li><a href="/#/tags/hip hop">Hip Hop</a></li>
					<li><a href="/#/tags/dubstep">Dubstep</a></li>
					<li><a href="/#/tags/acoustic">Acoustic</a></li>
					<li><a href="/#/tags/new wave">New Wave</a></li>
					<li><a href="/#/tags/80s">80s</a></li>
					<li><a href="/#/tags/soul">Soul</a></li>
					<li><a href="/#/tags/shoegaze">Shoegaze</a></li>
					<li><a href="/#/tags/synthpop">Synthpop</a></li>
					<li><a href="/#/tags/noise">Noise</a></li>
					<li><a href="/#/tags/punk">Punk</a></li>
					<li><a href="/#/tags/rnb">Rnb</a></li>
					<li><a href="/#/tags/Canadian">Canadian</a></li>
					<li><a href="/#/tags/techno">Techno</a></li>
					<li><a href="/#/tags/Alt-country">Alt-country</a></li>
					<li><a href="/#/tags/swedish">Swedish</a></li>
				</ul>
				<br style="clear:both">
			</div>
		</div>
	</div>
	
</div>

<?php $this->load->view('web/template_bottom'); ?>
