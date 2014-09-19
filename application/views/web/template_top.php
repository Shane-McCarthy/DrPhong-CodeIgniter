<!DOCTYPE html>
	
<html lang="en">
	
	<?php $this->load->view('web/template_top_head'); ?>

	<body>
		
		<div id="player-container" style="height:40px">
			<div id="player_inside">
				<div>
					<a href="javascript:void(0);" class="previousTrack"><img src="/static/images/backward.png" /></a>
					<a href="#" class="playpause"><img src="/static/images/pause.png" /></a>
					<a href="#" class="nextTrack"><img src="/static/images/forward.png" /></a>
					<div class="trackTitle"></div>
				</div>
				<div id="player-timebar">
					<div id="player-time-position">00:00</div>
					<div id="player-progress-outer">
						<div id="player-progress-loading">&nbsp;</div>
						<div id="player-progress-playing">&nbsp;</div>
					</div>
					<div id="player-time-total">00</div>
					<div id="volume_controller">
						<div id="volume_image"></div>
						<div id="volume_slider"></div>
					</div>
				</div>
			</div>
		</div>
		
		<div id="header">
			<div class="container">
				<div id="header-left" class="span-12">
					<a href="http://doctorphong.com/" id="home_link" class="nohack" title="Real Music, Real People"> </a>
				</div>
				<div id="header-right" class="span-12 last">
					<strong>Search</strong>
					<select name="" style="margin: 0 5px;" id="searchType">
						<option value="artist">Artist</option>
                        <option value="track">Track Name</option>
						<option value="blog">Blogs</option>
                        
					</select>
					<input type="text" name="k" id="searchKeyword" />
					<button type="submit" id="btnSearch">Search</button>
				</div>
			</div>
		</div>
		<div id="splitter">
			<div id="subnav">
				<div class="container">
					<ul id="nav">
						<li><a href="/#/" class="current">Music</a></li>
						
						<!--<li><a href="/#/popular">Popular</a></li>
                                    <li><a href="/#/artists">Artists *BETA*</a></li>
     <li><a href="/#/events">Events</a></li>-->
      <li><a href="/#/blogs">Blogs</a></li>
    <li style="float:left;"><a href="/#/my" style="background-image:url(/static/images/up.png); background-position: 5px 7px; background-repeat: no-repeat; padding-left:25px;<?php if (!isset($logged_in_user)): ?>display:none;<?php endif; ?>" id="my_button">My Music</a></li>
                        
						
                        <li style="float:right;"><a href="/session/logout" style="<?php if (empty($logged_in_user)): ?>display:none;<?php endif; ?>" id="logout_button" class="nohack">Logout</a></li>
						<li style="float:right;"><a href="/#/my" style="<?php if (empty($logged_in_user)): ?>display:none;<?php endif; ?>" id="welcome_button" class="nohack">Welcome back, <?php if (!empty($logged_in_user)): ?><?php echo $logged_in_user->username; ?><?php endif; ?></a></li>
						
                   <li style="float:right;"><a href="/x/admin.php" class="nohack"  >Artist Login</a></li>
                    <li style="float:right;"><a href="/x/index.php?t=signup&quota_id=1" class="nohack"  >Artist Signup</a></li>
						<li style="float:right;"><a href="/session/login" style="<?php if (!empty($logged_in_user)): ?>display:none;<?php endif; ?>" id="login_button">Log In</a></li>
                        <li style="float:right;"><a href="/session/signup" style="<?php if (!empty($logged_in_user)): ?>display:none;<?php endif; ?>" id="signup_button">Sign Up</a></li>
                  
                    
					</ul>
				</div>
			</div>
		</div>
		<div id="content">
			<div id="main" class="container">
				<div class="phong-error error" style="display:none;"><div class="message_box_content">An error occurred retrieving the page. Try again in a few seconds.</div></div>
				<div class="phong-accessdenied error" style="display:none;"><div class="message_box_content"><strong>Access Denied by ACL.</strong><br />Access to the given resource has been denied due to ACL permissions.</div></div>
				<div class="phong-loading" style="display:none;"><img src="/static/images/ajaxload-15-white.gif" alt="Loading"/></div>
				<!--<div class="phong-chrome notice" style="display:none; margin-top: 1em;"><div class="message_box_content"><strong>There is a known problem with Doctor Phong and Google Chrome.</strong><br />Some tracks may not play in Doctor Phong while using Google Chrome, it is recommended you use either Internet Explorer, Firefox or Safari.</div></div>-->
				<div class="phong-default">
					