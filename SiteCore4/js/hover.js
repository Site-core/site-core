$(document).ready(function() {
	var durationIn = 210;
	var durationOut = 170;
	var done = false;
	$('.slide .inner').each(
		function() {
			$(this).css('marginTop',$(this).parent().outerHeight());
		}
	);
	var el;
	var dfd;
	var promise;
	
    $(".slide").hover(
		function(e) {
			var $hint = $('.inner',this);
			var edge = getSide ( $(this), { x : e.pageX, y : e.pageY } );
		//	var edge = closestEdge(e.pageX, e.pageY, $(this).width(), $(this).height());
			var $action = {'margin':0};
			var $margin = set_margin(edge,this);
			$hint.css('margin', 0);
			$hint.css($margin);

			if (typeof dfd != 'undefined') {

				$.when(dfd).done(function(){
					dfd = $.Deferred();
					//promise = dfd.promise();
					animation();
				});
			} else {	
				dfd = $.Deferred();
				animation();
				//console.log(promise.state());
			}
			
			function animation() {
				$hint.animate($action, durationIn,function(){
					dfd.resolve();
				});
			}
		},
		function(e) {
		
			var $hint = $('.inner',this);
			var edge = getSide( $(this), { x : e.pageX, y : e.pageY } );
			var $action = set_margin(edge,this);
			
			$.when(dfd).done(function(){
				dfd = $.Deferred();
				animation();
			});
			function animation() {
				$hint.stop().animate($action, durationOut,function(){
					dfd.resolve();
				});
			}
		}
	);

	function getSide ( $el, coordinates ) {
	
	// the width and height of the current div
		var w = $el.width(),
			h = $el.height(),

			// calculate the x and y to get an angle to the center of the div from that x and y.
			// gets the x value relative to the center of the DIV and "normalize" it
			x = ( coordinates.x - $el.offset().left - ( w/2 )) * ( w > h ? ( h/w ) : 1 ),
			y = ( coordinates.y - $el.offset().top  - ( h/2 )) * ( h > w ? ( w/h ) : 1 ),
		
			// the angle and the direction from where the mouse came in/went out clockwise (TRBL=0123);
			// first calculate the angle of the point,
			// add 180 deg to get rid of the negative values
			// divide by 90 to get the quadrant
			// add 3 and do a modulo by 4  to shift the quadrants to a proper clockwise TRBL (top/right/bottom/left) **/
			direction = Math.round( ( ( ( Math.atan2(y, x) * (180 / Math.PI) ) + 180 ) / 90 ) + 3 ) % 4;
			switch( direction ) {
			case 0:
				// from top
				return direction = 'top';
				break;
			case 1:
				// from right
				return direction = 'right';
				break;
			case 2:
				// from bottom
				return direction = 'bottom';
				break;
			case 3:
				// from left
				return direction = 'left';
				break;
		};
	};
});

function set_margin(edge,block) {
	var $margin;
	switch (edge) {
		case 'left':
			$margin = {'margin-left': $(block).outerWidth()};
			break;
		case 'right':
			$margin = {'margin-left': -$(block).outerWidth()};
			break;
		case 'top':
			$margin = {"margin-top": $(block).outerHeight()};
			break;
		case 'bottom':
			$margin = {"margin-top": -$(block).outerHeight()};
			break;
	}
	return $margin;
}