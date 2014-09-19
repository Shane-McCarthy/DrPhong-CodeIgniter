<div class="span-9" style="float: right;">
    <div class="corner-all column">
        <div class="column-padding">

            

                <?php
                
                $page = end($this->uri->segments);

                $promoTracks = cTrack::findPromoted(394);

                // Only show if we are on index page or latest
                if ((empty($page) || $page == 'latest') && !empty($promoTracks)) {

                    print '<div class="promo-box"><div style="background: #000; padding: 5px;"><span style="font-weight: bold; color: #fff;">Promoted</span></li></div>';

                    $this->load->view('web/template_listpromo', array('tracks' => $promoTracks));

                    print '</div>';
                }

                ?>
            
<div id="facebook"> <iframe src="//www.facebook.com/plugins/likebox.php?href=https%3A%2F%2Fwww.facebook.com%2Fpages%2FDr-Phong%2F175963841709%3Fref%3Dts%26fref%3Dts&amp;width=350&amp;height=258&amp;show_faces=true&amp;colorscheme=dark&amp;stream=false&amp;border_color&amp;header=false&amp;appId=150576085012420" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:350px; height:258px;" allowTransparency="true"></iframe></div> 
<div id="twitter"><a class="twitter-timeline" width="350" height="258" href="https://twitter.com/doctorphong" data-widget-id="317389378873868288">Tweets by @doctorphong</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
</div>
            
            
        </div>
    </div>
</div>
