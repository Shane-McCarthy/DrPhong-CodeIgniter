
<?php $this->load->view('web/template_top'); ?>

<div id="content">

    <?php if (empty($logged_in_user)): ?>
        <div id="intro_wrap">
            <div class="column-padding">
                <div class="intro">
                    Dr Phong brings you music that other people are talking about, <a href="/#/session/signup">SIGN UP</a> so you can create a <img src="/static/images/up.png" /> playlist of the songs you like.
                </div>
            </div>
        </div>
    <?php endif; ?>

    <div class="span-14">
        <div class="corner-all column">
            <div class="column-padding">
                <div id="splitter">
                    <div id="subnav">
                        <div class="container">
                            <ul id="nav">

                                <li><a href="/#/latest">Latest</a></li>
                                <li><a href="/#/popular">Popular Random</a></li>
                                <li><a href="/#/popular_vote">Popular By Vote</a></li><li><a href="/#/popular_date">Popular By Date</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <?php $this->load->view('web/template_list', array('tracks' => $tracks)); ?>
                <?php echo $this->pagination->create_links(); ?>
            </div>
        </div>

    </div>
    <?php $this->load->view('web/template_sidebar'); ?>
</div>

<?php $this->load->view('web/template_bottom'); ?>
