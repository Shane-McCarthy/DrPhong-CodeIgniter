
<?php $this->load->view('web/template_top'); ?>

<div id="content">
	<div class="span-12">
		<div class="corner-all column">
			<div class="column-padding">
				
				<h1>Latest Music posted by <a href="<?php echo $blog->url; ?>"><?php echo $blog->name; ?></a></h1>
				<?php $this->load->view('web/template_list', array('tracks' => cTrack::findByBlog($blog->id))); ?>
				
			</div>
		</div>
	</div>
	<?php $this->load->view('web/template_sidebar'); ?>
</div>

<?php $this->load->view('web/template_bottom'); ?>
