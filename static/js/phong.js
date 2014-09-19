var currentTrack = '';
var phongPlayer;

$(function(){
    
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
        
        if (!url) url = '/';
        
        $( '.current' ).removeClass( 'current' );
        $( '#main' ).children( ':visible' ).hide();
        
        if (url) {
            if ($( '#subnav a[href="/#' + url + '"]' ).length > 0) {
                $( '#subnav a[href="/#' + url + '"]' ).addClass( 'current' ).parent().addClass( 'current' );
            }
        }
        
    }
    
    $(window).bind( 'hashchange', function(e) {
        
        var url = $.param.fragment();
        
        setup(url);
        
        if ( cache[ url ] ) {
            cache[ url ].show();
        } else {
            $( '.phong-loading' ).show();
            $( '<div class="phong-item"/>' )
                .appendTo( '#main' )
                .load( url + ' #content', function(responseText, textStatus, req){
                    if (req.status == 400) {
                        window.location = '/session/?return_to='+escape('/#' + url);
                    } else if (req.status == 403) {
                        $( '.phong-accessdenied' ).show();
                    } else if (textStatus == "error") {
                        $( '.phong-error' ).show();
                    }
                    $( '.phong-loading' ).hide();
                });
        }
            
    })
        
    $('.delete').live('click', function(e){
        e.preventDefault();
        obj = $(this);
        Boxy.confirm("Are you sure you want to delete this item?", function() { window.location = obj.attr("href") }, {title: 'Confirm Deletion'});
        return false;
    });
    
    $('a[href$="mp3"]').live('click', function(e){
            
            e.preventDefault();
            
            $('#player-container').show('fast');
            
            if ($(this).attr('href') == currentTrack) {
                phongPlayer.togglePause('aSound');
                if(phongPlayer.paused){
                    $(this).removeClass('pause');
                    $(this).find('img').attr('src', '/static/images/play.png');
                }else{
                    $(this).addClass('pause');
                    $(this).find('img').attr('src', '/static/images/pause.png');
                }
            } else {
                $(".pause").removeClass('pause');
                currentTrack = $(this).attr('href');
                if (phongPlayer) soundManager.destroySound('phong');
                phongPlayer = CreateSound();
                $('.trackTitle').empty();
                $('.trackTitle').html($(this).text()).fadeIn('slow');
                phongPlayer.play({url:currentTrack});
                getCurrentPlayingSong(currentTrack);
                $(this).addClass('pause');
            }
            
        
    });
    
    $('#player-container').hover(function(){
        $('#player-timebar').show();
    },function(){
        $('#player-timebar').hide();
    });
    
    $("form").live('submit',function(event){
        event.preventDefault();
        //console.dir(event);
        var url = $.param.fragment();
    
        $.ajax({
            url: url,
            error: function(XMLHttpRequest, textStatus, errorThrown) { },
            type: "POST",
            data: $(this).serialize(),
            dataType: "json",
            processData: false,
            success: function(data, textStatus, XMLHttpRequest) {
                location.hash = data.Location;
                if (data.Action == 'login') {
                    $('#my_button').show();
                    $('#logout_button').show();
                    $('#welcome_button').show().text("Welcome back, " + data.Username);
                    $('#signup_button').hide();
                    $('#login_button').hide();
                    if (data.Admin == '1') {
                        $('#admin_button').show();
                    }
                }
            }
        });
    });
    
    $('.like').live('click', function(event) {
        event.preventDefault();
        track_id = $(this).attr('data-id');
        track_object = $(this);
        if (!track_object.hasClass('fav-on')) {
            $.ajax({
                url: '/like/track/'+track_id,
                error: function(XMLHttpRequest, textStatus, errorThrown) { },
                type: "GET",
                dataType: "json",
                processData: false,
                success: function(data, textStatus, XMLHttpRequest) {
                    track_object.addClass('fav-on');
                    $(".favcount", track_object.parent()).text(parseInt($(".favcount", track_object.parent()).text())+1);
                }
            });
        } else {
            $.ajax({
                url: '/unlike/track/'+track_id,
                error: function(XMLHttpRequest, textStatus, errorThrown) { },
                type: "GET",
                dataType: "json",
                processData: false,
                success: function(data, textStatus, XMLHttpRequest) {
                    track_object.removeClass('fav-on');
                    $(".favcount", track_object.parent()).text(parseInt($(".favcount", track_object.parent()).text())-1);
                }
            });
        }
    });

    $(window).trigger( 'hashchange' );
    
});
