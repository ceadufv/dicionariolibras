$(function() {
  // Colorbox effects
  $('a[href*="youtube"]').colorbox({iframe: true, width: 640, height: 390, href:function(){
    var videoId = new RegExp('[\\?&]v=([^&#]*)').exec(this.href);
    if (videoId && videoId[1]) {
      return 'http://youtube.com/embed/'+videoId[1]+'?rel=0&wmode=transparent';
    }
  }});
  $('a[href$=".pdf"]').colorbox({iframe:true, width:"1120", height:"690"});
  $('a[href$=".swf"]').colorbox({iframe:true, width:"1120", height:"690"});

  // Custombox search
  $('a[rel="search"]').on('click', function( e ) {
    Custombox.open({
      target: '#modal',
      effect: 'fadein',
      overlayColor: '#B56A58',
      overlayOpacity: 0.6,
      speed: 300
    });
    e.preventDefault();
  });

  // Sidebar login transitions
  $('.login .close').click(function(e) {
    $('.login').fadeOut('300', function() {
      $(this).addClass('hidden');
      $('.monitoring').removeClass('hidden').show();
    });

    e.preventDefault();
  });
  $('.monitoring .no-monit').click(function(e) {
    $('.monitoring').fadeOut('300', function() {
      $(this).addClass('hidden');
      $('.login').removeClass('hidden').show();
    });

    e.preventDefault();
  });
});
