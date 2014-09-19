
<?php $this->load->view('web/template_top'); ?>

<div id="content">
	<div class="span-16">
		<div class="corner-all column">
			<div class="column-padding">
				
				<h1>Doctor Phong Add/Edit Blog</h1>
				
				<form action="/phongalator/feeds/edit/<?php echo $feed->id; ?>" method="POST">
					
					<div>
						<label for="name">Site Name</label><br />
						<input type="text" class="text" name="name" value="<?php echo $feed->name; ?>" />
					</div>
					
					<div>
						<label for="url">Site URL</label><br />
						<input type="text" class="text" name="url" value="<?php echo $feed->url; ?>" />
					</div>
					
					<div>
						<label for="feed_url">Feed URL</label><br />
						<input type="text" class="text" name="feed_url" value="<?php echo $feed->feed_url; ?>" />
					</div>
					
					<div>
						<label for="feed_url">Site Description</label><br />
						<textarea name="description"><?php echo $feed->description; ?></textarea>
					</div>
					
					<button type="submit">Save</button> or <a href="/#/phongalator/feeds/delete/<?php echo $feed->id; ?>">Delete</a>
					
				</form>
				
			</div>
		</div>
	</div>
</div>

<?php $this->load->view('web/template_bottom'); ?>
