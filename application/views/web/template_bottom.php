				</div>
			</div>
		</div>
		
		<div id="splitter-bottom">
			<div id="footer">
				<div class="container">
					<ul id="nav">
						<li><a href="http://doctorphong.com/blog/sort-of-about-us/" class="nohack">About</a></li>
						<li><a href="mailto:rx@doctorphong.com" class="nohack">Contact Us</a></li>
						<li><a href="http://doctorphong.com/blog/" class="nohack">Our Blog</a></li>
					</ul>
				</div>
			</div>
		</div>
		
		<div id="copyright">
			<div class="container">
				<p>
					Dr Phong is a Music Blog Aggregator that posts music blog posts so music lovers can find and enjoy tracks, songs, artists, DJ's, Bands and any other type of music producer that you can think of. If you want your blog added to or removed from Dr Phong <a href="mailto:rx@doctorphong.com" class="nohack">click here</a>, if you have comments or suggestions <a href="mailto:rx@doctorphong.com" class="nohack">click here</a>.
				</p>
				&copy; 2011 Doctor Phong. All Rights Reserved.<br />
				<small><a href="/#/legal/terms">Terms of Use</a> &bull; <a href="/#/legal/privacy">Privacy Policy</a></small>
			</div>
		</div>
		
		<div id="logindialog" style="display:none;">
			
			<img src="/static/images/logo.jpg" alt="Doctor Phong Login" />
				
			<h1 style="color:#373C80; margin-bottom:1em;">You must login to Doctor Phong to rate music!</h1>
			
			<div class="errorcontainer"></div>
			
			<form method="POST" action="/session/login">
				
				<div>
					<label for="username">Username</label><br>
					<input type="text" name="username" class="text">
				</div>
				
				<div>
					<label for="username">Password</label><br>
					<input type="password" name="password" class="text">
				</div>
				
				<div style="margin-top: 1em;"><button type="submit">Log-In</button></div>
				
				<div style="margin-top: 1em;"><a href="/#/session/signup">Dont have an account? Sign-up now!</a></div>
				
			</form>
			
		</div>
		
		<div id="ads" style="display:none;">
			<script type="text/javascript">
				<!--
					google_ad_client = "ca-pub-5591769107531037";
					/* phong-1 */
					google_ad_slot = "5159120016";
					google_ad_width = 160;
					google_ad_height = 600;
				//-->
			</script>
			<script type="text/javascript" src="http://pagead2.googlesyndication.com/pagead/show_ads.js"></script>
		</div>
		
		<script type="text/javascript">
			
			var phongPlayer;
			var logged_in_user = <?php echo (!empty($logged_in_user)) ? 'true' : 'false'; ?>;
			
			$(function(){
				
				if (($.browser.safari && /chrome/.test(navigator.userAgent.toLowerCase()))) {
					$('.phong-chrome').show();
				}
				
				soundManager.url = "/static/swf";
				soundManager.debugMode = false;
				soundManager.onready(function() {
					var phongPlayer = soundManager.createSound({
					   id: 'aSound',
					   nullUrl: 'about:blank'
					});
					phongPlayer.unload();
				});
				
				$.ajaxSetup({
					headers: {"X-Requested-With": "XMLHttpRequest"}
				}); 
				
				var cache = {
					'': $('.phong-default'),
					'/': $('.phong-default')
				};
				
				function setup(url) {
					
					$( '.current' ).removeClass( 'current' );
					$( '#main' ).children( ':visible' ).hide();
					
					if (url) {
						if ($( '#subnav a[href="/#' + url + '"]' ).length > 0) {
							$( '#subnav a[href="/#' + url + '"]' ).addClass( 'current' ).parent().addClass( 'current' );
						}
					}
					
				}
				
				function showLoginWindow() {
					$.openDOMWindow({ 
						height:360, 
						width:330, 
						loader:1, 
						loaderImagePath:'animationProcessing.gif', 
						loaderHeight:16, 
						loaderWidth:17,
						windowBGColor:'#ADCFE6',
						windowSourceID: '#logindialog' 
					});
				}
				
				$(window).bind( 'hashchange', function(e) {
					
					currentTrackId = 0;
					currentTrack = '';
					
					$.closeDOMWindow();
					
					var url = $.param.fragment();
					if (!url) url = '/';
					
					setup(url);
					
					$( '.phong-loading' ).show();
					$( '.phong-default' ).remove();
					$( '.phong-item' ).remove();
					$( '<div class="phong-item"/>' )
						.appendTo( '#main' )
						.load( url + ' .phong-default', function(responseText, textStatus, req){
							if (req.status == 400) {
								window.location = '/#/session/login';
							} else if (req.status == 403) {
								$( '.phong-accessdenied' ).show();
							} else if (textStatus == "error") {
								$( '.phong-error' ).show();
							}
							$( '.phong-loading' ).hide();
							$.getScript('http://platform.twitter.com/widgets.js');
							$("#ads ins:first").clone().appendTo('#ads-target');
						});
					$("#ads iframe").appendTo('#ads-target');
				})
					
				$('.delete').live('click', function(e){
					e.preventDefault();
					obj = $(this);
                    Boxy.confirm("Are you sure you want to delete this item?", function() { window.location = obj.attr("href") }, {title: 'Confirm Deletion'});
					return false;
                });
				
				$("form").live('submit',function(event){
					$this = $(this);
					if ($(this).attr('action').match("^/ph") != '/ph') {
						event.preventDefault();
						//console.dir(event);
						$.ajax({
							url: $(this).attr('action'),
							error: function(XMLHttpRequest, textStatus, errorThrown) { },
							type: "POST",
							data: $(this).serialize(),
							dataType: "json",
							processData: false,
							success: function(data, textStatus, XMLHttpRequest) {
								if (data.Action == 'error') {
									errordesc = '<div class="error"><ul style="margin-bottom:0;">';
									for (error in data.Errors) {
										errordesc = errordesc + '<li>' + data.Errors[error] + '</li>';
									}
									errordesc = errordesc + '</ul><div>';
									$('.errorcontainer', $this.parent()).html(errordesc);
								} else if (data.Action == 'success') {
									successdesc = '<div class="success"><ul style="margin-bottom:0;">';
									successdesc = successdesc + '<li>' + data.Message + '</li>';
									successdesc = successdesc + '</ul><div>';
									$('.errorcontainer', $this.parent()).html('');
									$('.successcontainer', $this.parent()).html(successdesc);
								} else {
									window.location = data.Location;
								}
							}
						});
					}
				});
				
				$('.like').live('click', function(event) {
					event.preventDefault();
					
					if (!logged_in_user) {
						showLoginWindow();
					} else {
						
						track_id = $(this).attr('data-id');
						track_object = $(this);
						$.ajax({
							url: '/like/track/'+track_id,
							error: function(XMLHttpRequest, textStatus, errorThrown) { },
							type: "GET",
							dataType: "json",
							processData: false,
							success: function(data, textStatus, XMLHttpRequest) {
								track_object.addClass('fav-on');
								$(".favcount-up", track_object.parent()).text(parseInt($(".favcount-up", track_object.parent()).text())+1);
							}
						});
						
					}
					
				});

				$('.unlike').live('click', function(event) {
					event.preventDefault();
					
					if (!logged_in_user) {
						showLoginWindow();
					} else {
						
						track_id = $(this).attr('data-id');
						track_object = $(this);
						$.ajax({
							url: '/unlike/track/'+track_id,
							error: function(XMLHttpRequest, textStatus, errorThrown) { },
							type: "GET",
							dataType: "json",
							processData: false,
							success: function(data, textStatus, XMLHttpRequest) {
								track_object.removeClass('fav-on');
								$(".favcount-down", track_object.parent()).text(parseInt($(".favcount-down", track_object.parent()).text())+1);
							}
						});
						
					}
					
				});
				
				$('a[href^="/"]').live('click', function(e) {
					if (!$(this).hasClass('nohack')) {
						if (($(this).attr('href').match("^/#") != '/#') && ($(this).attr('href').match("^/ph") != '/ph')) {
							e.preventDefault();
							window.location = '/#'+$(this).attr('href');
						}
					}
				});
				
				$('a[href^="http://<?php echo $_SERVER['SERVER_NAME']; ?>/"]').live('click', function(e) {
					if (!$(this).hasClass('nohack')) {
						e.preventDefault();
						window.location = '/#'+$(this).attr('href').replace('http://<?php echo $_SERVER['SERVER_NAME']; ?>', '');
					}
				});
				
				var url = $.param.fragment();
				if (!url) url = '/';
				if (url != '/') {
					$(window).trigger( 'hashchange' );
				}
				$.getScript('http://platform.twitter.com/widgets.js');
				$("#ads ins:first").clone().appendTo('#ads-target');
				
				$('#btnSearch').live('click', function(e) {
					e.preventDefault();
					window.location = '/#/search/'+$('#searchType').val()+'/'+$('#searchKeyword').val();
				});
				
				$("#searchKeyword").live('keyup', function(event){
					if(event.keyCode == 13){
						$("#btnSearch").click();
					}
				});
				
			});
		</script>
		<!-- Piwik -->
<script type="text/javascript"> 
  var _paq = _paq || [];
  _paq.push(['trackPageView']);
  _paq.push(['enableLinkTracking']);
  (function() {
    var u=(("https:" == document.location.protocol) ? "https" : "http") + "://doctorphong.com/analytics/piwik//";
    _paq.push(['setTrackerUrl', u+'piwik.php']);
    _paq.push(['setSiteId', 1]);
    var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0]; g.type='text/javascript';
    g.defer=true; g.async=true; g.src=u+'piwik.js'; s.parentNode.insertBefore(g,s);
  })();

</script>
<noscript><p><img src="http://doctorphong.com/analytics/piwik/piwik.php?idsite=1" style="border:0" alt="" /></p></noscript>
<!-- End Piwik Code -->

	</body>
</html>
