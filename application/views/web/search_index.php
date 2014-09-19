
<?php $this->load->view('web/template_top'); ?>

<div id="content">
	
	<?php if (empty($logged_in_user)): ?>
	<div class="corner-all column">
		<div class="column-padding">
			<div class="intro">
				Dr Phong brings you music that other people are talking about, <a href="/session/login">login</a> so you can create a <img src="/static/images/up.png" /> playlist of the songs you like.
			</div>
		</div>
	</div>
	<?php endif; ?>

	<div class="span-12">
		<div class="corner-all column">
			<div class="column-padding">
				
				<h1>Search Results</h1>
				
				<?php $this->load->view('web/template_list', array('tracks' => $tracks)); ?>
				
				<?php echo $this->pagination->create_links(); ?>
				
			</div>
		</div>
	</div>
	<?php $this->load->view('web/template_sidebar'); ?>
</div>

<?php $this->load->view('web/template_bottom'); ?>
