
<?php $this->load->view('web/template_top'); ?>

<div id="content">
	<div class="span-16">
		<div class="corner-all column">
			<div class="column-padding">
				
				<h1>Register at Doctor Phong</h1>
				
				<div class="errorcontainer"></div>
				
				<form action="/session/signup" method="POST">
					
					<div>
						<label for="username">Email</label><br />
						<input type="text" class="text" name="email" />
					</div>
					
					<div>
						<label for="username">Username</label><br />
						<input type="text" class="text" name="username" />
					</div>
					
					<div>
						<label for="username">Password</label><br />
						<input type="password" class="text" name="password" />
					</div>
					
					<button type="submit">Sign Up</button>
					
				</form>
			</div>
		</div>
	</div>
</div>

<?php $this->load->view('web/template_bottom'); ?>
