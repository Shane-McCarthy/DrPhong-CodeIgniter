
<?php $this->load->view('web/template_top'); ?>

<div id="content">
	<div class="span-16">
		<div class="corner-all column">
			<div class="column-padding">
				<div class="pad_text"> 
				<h3>Members Login to Doctor Phong</h3>
				
				<div class="errorcontainer"></div>
				
				<form action="/session/login" method="POST">
					
					<div>
						<label for="username">Username</label><br />
						<input type="text" class="text" name="username" />
					</div>
					
					<div>
						<label for="username">Password</label><br />
						<input type="password" class="text" name="password" />
					</div>
					
					<button type="submit">Log-In</button>
					
				</form>
                <div style="padding-top: 15px;">
                <div class="underline">
                </div></div> 
				
			</div>
            </div>
            </div>
		</div>
	</div>
</div>

<?php $this->load->view('web/template_bottom'); ?>
