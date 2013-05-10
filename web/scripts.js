function goTo(_where) {
  $.scrollTo(_where, 2000);
}

$('a[data-scroll-to]').on('click', function(e) {
    goTo($(this).attr('href'));
    e.preventDefault();
});

var pos = 1;
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

function windowLocation(href, hash) {
  hash = hash || '';

  if( hash )
    href += '#' + hash;

  if( href )
    return (window.location.href = href);
}

$(window).ready(function() {
  if( window.location.hash ) {
    hash = window.location.hash.substring(1);
    el = $('#' + hash).parents('tr[tabindex]');
    var pos = el.attr('tabindex');
    el.focus();
  }
  else
  {
    el = $('tr[tabindex=1]');
    var pos = el.attr('tabindex');
    el.focus(); 
  }
});

$(document).bind('keydown', 'space', function () {
  goTo('#content');
  e.preventDefault();
});

$(window).bind('keypress', function(e) {
  switch(e.keyCode) {
    case 32 : // spacebar
      break;
    
    case 38 : // DOWN
      focusTabIndex(-1); e.preventDefault();
      break;

    case 40 : // UP
      focusTabIndex(1); e.preventDefault();
      break;

    case 37 : // LEFT
      windowLocation($('a.prev').attr('href'), $('.ariane li:last-child a').attr('data-id'));
      break;

    case 13 : // ENTER
    case 39 : // RIGHT
      windowLocation($('tr[tabindex]:focus a.link').attr('href'));
      e.preventDefault();
      break;

    default:
      console.log('key:' + e.keyCode);
      break;
  }
});