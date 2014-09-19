
var total_playlist_song=0;
var current_playlist_song=0;
var currentTrack = '';
var currentTrackId = 0;

$.createPlayer = function() { 
		$('#player_ul').remove();
		
		if ($('a[href$="mp3"]').size()<=1) {
			return false;
		} else {
			var e= $(document.createElement('ul'));
			e.attr('id','player_ul');
			e.css('display','none');
			$('body').append(e);
			
			$('a[href$="mp3"]').each(function(){
				total_playlist_song++;
                var mark=$('<li id='+total_playlist_song+'><a href='+$(this).attr('href')+'>'+$(this).html()+'</a></li>');
				$('#player_ul').append(mark);
            });
		}
};

function LoadData(){
	seconds=parseInt(this.duration,10)/1000;
	loading_width=(parseInt(this.duration,10)/parseInt(this.durationEstimate,10))*100;
	$("#player-progress-loading").css('width',loading_width+'%');
	$("#player-time-total").html(Math.floor(seconds/ 60) + ":" + (seconds % 60).toFixed().pad(2, "0"));
}

function PlayData(){
	seconds=parseInt(this.position,10)/1000;
	$("#player-time-position").html(Math.floor(seconds/ 60) + ":" + (seconds % 60).toFixed().pad(2, "0"));
	playing_width=(parseInt(this.position,10)/parseInt(this.durationEstimate,10))*100;
	$("#player-progress-playing").css('width',playing_width+'%');
}

function UpdateProgress(event_width,offset){
	playing_width=(event_width-offset)*0.23;
	var mySound = soundManager.getSoundById('phong');
	new_position=(playing_width*mySound.durationEstimate)/100;
	soundManager.setPosition('phong',new_position);
	if ($('#player-progress-loading').width()<playing_width) {
		$('#player-progress-playing').css('width',$('#player-progress-loading').css('width')+'%');
	} else{
		$('#player-progress-playing').css('width',playing_width+'%');
	}
}

String.prototype.pad = function(l, s){
	return (l -= this.length) > 0 
		? (s = new Array(Math.ceil(l / s.length) + 1).join(s)).substr(0, s.length) + this + s.substr(0, l - s.length) 
		: this;
};

function getCurrentPlayingSong(songLink) {
	$('#player_ul li').each(function(){
		if (songLink === $(this).find('a').attr('data-media')) {
			current_playlist_song=parseInt($(this).attr('id'), 10);
			return false;
		}
	});
}

function NextSong(){

    next_url=$('#track-'+(currentTrackId+1)).attr('data-media');
    track_id = $('#track-'+(currentTrackId+1)).attr('data-trackid');
    
    if (next_url) {
        
        var mySound = CreateSound(next_url);
        $('#track-'+currentTrackId).removeClass('pause');
        currentTrackId = currentTrackId+1;
        currentTrack = next_url;
        var trackName = $('#track-'+currentTrackId).html();
        $('.trackTitle').empty();
        $('.trackTitle').html('<a href="#/" class="like fav-up" data-id="'+track_id+'" style="float:left; margin-top:4px;"></a><a href="#/" class="unlike fav-down" data-id="'+track_id+'" style="float:left; margin-top:4px; margin-right:25px;"></a>'+trackName).fadeIn('slow');
        
        mySound.play();
        getCurrentPlayingSong(next_url);
        
        $('#track-'+(currentTrackId)).addClass('pause');
        
    }
	
}

function PrevSong(){

    previous_url=$('#track-'+(currentTrackId-1)).attr('data-media');
    track_id = $('#track-'+(currentTrackId-1)).attr('data-trackid');
    
    if (previous_url){
        
        var mySound = CreateSound(previous_url);
        $('#track-'+currentTrackId).removeClass('pause');
        currentTrackId = currentTrackId-1;
        currentTrack = previous_url;
        var trackName = $('#track-'+currentTrackId).html();
        $('.trackTitle').empty();
        $('.trackTitle').html('<a href="#/" class="like fav-up" data-id="'+track_id+'" style="float:left; margin-top:4px;"></a><a href="#/" class="unlike fav-down" data-id="'+track_id+'" style="float:left; margin-top:4px; margin-right:25px;"></a>'+trackName).fadeIn('slow');
        
        mySound.play();
        getCurrentPlayingSong(previous_url);

        $('#track-'+(currentTrackId)).addClass('pause');
        
    }
}

function CreateSound(trackUrl){

    soundManager.destroySound('phong');

    var phongPlayer = soundManager.createSound({
        id: 'phong',
        url: trackUrl,
        multiShotEvents: true,
        whileloading:LoadData,
        whileplaying:PlayData,
        onfinish:function(){
            setTimeout(function(){
                NextSong();
            },3000);
        },
        volume:$('#volume_slider').slider( "option", "value" )  
    });

    return phongPlayer;
}

$(document).ready(function(){
    
    $('#volume_slider').slider({
        animate:false,
        value:80,
        min:0,
        slide:function() {
            //console.log('sound ',$('#volume_slider').slider( "option", "value" ));
            soundManager.setVolume('phong',$('#volume_slider').slider( "option", "value" ));
        }
    });
    
    $('a.playpause').click(function(event) {
        event.preventDefault();
        sound = soundManager.togglePause('phong');
        if (sound.paused){
            $('img', $(this)).attr('src','/static/images/play.png');
            $('.pause').removeClass('pause');
        } else {
            $('a[href="'+currentTrack+'"]').addClass('pause');
            $('img', $(this)).attr('src','/static/images/pause.png');
        }
    });

    $('a.previousTrack').click(function(event){
        event.preventDefault();
        PrevSong();
    });
    

    $('a.nextTrack').click(function(event){
        
        event.preventDefault();
        NextSong();
        
    });

    $('#player-progress-outer').click(function(event){
        event_width=event.pageX;
        var off=$(this).offset();
        event.stopPropagation();
        UpdateProgress(event_width, off.left);
    });

    $('a[data-media$="mp3"]').live('click', function(e){
	
        e.preventDefault();
        
        $('#player-container').show('fast');
        


        if ($(this).attr('data-media') === currentTrack) {

            var phongPlayer = soundManager.getSoundById('phong');

            phongPlayer.togglePause('phong');
            if(phongPlayer.paused){
                $(this).removeClass('pause');
                $(this).find('img').attr('src', '/static/images/play.png');
            }else{
                $(this).addClass('pause');
                $(this).find('img').attr('src', '/static/images/pause.png');
            }
        } else {
            $(".pause").removeClass('pause');
            currentTrack = $(this).attr('data-media');
            track_id = $(this).attr('data-trackid');
            currentTrackId = parseInt($(this).attr('id').substring(6), 10);

            var phongPlayer = CreateSound(currentTrack);
            $('.trackTitle').empty();
            $('.trackTitle').html('<a href="#/" class="like fav-up" data-id="'+track_id+'" style="float:left; margin-top:4px;"></a><a href="#/" class="unlike fav-down" data-id="'+track_id+'" style="float:left; margin-top:4px; margin-right:25px;"></a>'+$(this).text()).fadeIn('slow');
            phongPlayer.play();
            getCurrentPlayingSong(currentTrack);
            $(this).addClass('pause');
        }
        
        
    });
    
    $('#player-container').hover(function(){
        $('#player-timebar').show();
    },function(){
        $('#player-timebar').hide();
    });
    
});

