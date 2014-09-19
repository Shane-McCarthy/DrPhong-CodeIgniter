
<?php $this->load->view('web/template_top'); ?>

<div id="content">

	<div class="span-12">
		<div class="corner-all column">
			<div class="column-padding">
				 <div id="splitter">
			<div id="subnav">
				<div class="container">
					
				</div>
			</div>
		</div>
				<?php $this->load->view('web/template_suggested', array('tracks' => $tracks)); ?>
				
				<?php echo $this->pagination->create_links(); ?>
				
			</div>
		</div>
	</div>
	<?php $this->load->view('web/template_sidebar'); ?>
</div>

<?php $this->load->view('web/template_bottom'); ?>
