
<?php $this->load->view('web/template_top'); ?>

<script language="JavaScript">
<!--
function autoResize(id){
    var newheight;
    var newwidth;

    if(document.getElementById){
        newheight=document.getElementById(id).contentWindow.document .body.scrollHeight;
        newwidth=document.getElementById(id).contentWindow.document .body.scrollWidth;
    }

    document.getElementById(id).height= (newheight) + "px";
    document.getElementById(id).width= (newwidth) + "px";
}
//-->
</script>

<div id="content">
	<div class="span-24">
		<div class="corner-all column">
			<div class="column-padding">
				<IFRAME SRC="usagelogs/default.aspx" width="100%" height="200px" id="jamFrame" marginheight="0" frameborder="0" onLoad="autoResize('jamFrame');"></iframe>
			</div>
		</div>
	</div>
</div>

<?php $this->load->view('web/template_bottom'); ?>
