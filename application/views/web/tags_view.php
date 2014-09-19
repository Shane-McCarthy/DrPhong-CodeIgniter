
<?php $this->load->view('web/template_top'); ?>

<div id="content">
    <div class="span-12">
		<div class="corner-all column">
			<div class="column-padding">
				
				<h1>Latest Music tagged '<?php echo ucwords($tag->tag_name); ?>'</h1>
				<?php $this->load->view('web/template_list', array('tracks' => $tracks)); ?>
				
				<?php echo $this->pagination->create_links(); ?>
				
			</div>
		</div>
    </div>
	<?php $this->load->view('web/template_sidebar'); ?>
</div>

<?php $this->load->view('web/template_bottom'); ?>
