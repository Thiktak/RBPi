function goTo(_where) {
  $.scrollTo(_where, 2000);
}

$('a[data-scroll-to]').on('click', function(e) {
    goTo($(this).attr('href'));
    e.preventDefault();
});

var pos = 0;
var maxPos = 100;

function focusTabIndex(i) {
  while( true ) {
    pos += i;
    if( pos < 0 )      pos = maxPos;
    if( pos > maxPos ) pos = 0;

    if( (el = $('*[tabindex=' + pos + ']')).length ) {
      el.focus();
      return true;
    }
  }
}

$(window).bind('keypress', function(e) {
  switch(e.keyCode) {
    case 0 : // spacebar
      goTo('#content');
      e.preventDefault();
      break;

    case 38 : // DOWN
      focusTabIndex(-1); e.preventDefault();
      break;

    case 40 : // UP
      focusTabIndex(1); e.preventDefault();
      break;

    case 13 : // ENTER
      window.location.href = $('tr[tabindex]:focus a.link').attr('href');
      e.preventDefault();
      break;
  }
});