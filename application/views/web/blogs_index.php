
<?php $this->load->view('web/template_top'); ?>

<div id="content">
	<div class="span-12">
		<div class="corner-all column">
			<div class="column-padding">
				
				<h1>Blogs</h1>
				
				<?php foreach ($blogs as $key => $blog): ?>
					<div class="section section-blog section-<?php echo ($key % 2) ? 'odd' : 'even'; ?>">
						<h3 class="track_name">
							<a href="/#/blog/<?php echo $blog->id; ?>/<?php echo urlencode($blog->name); ?>"><?php echo $blog->name; ?></a>
						</h3>
                       <h4> <div id="blog_link">
                        <a href="<?php echo $blog->url; ?>" class="nohack">Visit Blog</a>
						</div> </h4>
                        <p>
							<?php echo $blog->description; ?>
						</p>
					</div>
				<?php endforeach; ?>
				
				<?php echo $this->pagination->create_links(); ?>
				
			</div>
		</div>
	</div>
	<?php $this->load->view('web/template_sidebar'); ?>
</div>

<?php $this->load->view('web/template_bottom'); ?>
