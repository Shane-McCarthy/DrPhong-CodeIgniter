
<?php $this->load->view('web/template_top'); ?>

<div id="content">
	<div class="span-16">
		<div class="corner-all column">
			<div class="column-padding">
				
				<h1>Doctor Phong Edit User</h1>
				
				<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="POST">
					
					<div>
						<label for="username">Email</label><br />
						<input type="text" class="text" name="email" value="<?php echo $user->email; ?>" />
					</div>
					
					<div>
						<label for="username">Username</label><br />
						<input type="text" class="text" name="username" value="<?php echo $user->username; ?>" />
					</div>
					
					<div>
						<label for="username">Password</label><br />
						<input type="password" class="text" name="password" value="" />
					</div>
					
					<div>
						<label for="username">Is Admin</label><br />
						<input type="checkbox" name="admin" <?php echo set_checkbox('admin', '1', ($user->admin = 1)); ?> />
					</div>
					
					<button type="submit">Save</button>
					
				</form>
				
			</div>
		</div>
	</div>
</div>

<?php $this->load->view('web/template_bottom'); ?>
