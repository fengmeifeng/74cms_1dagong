function hookEvent(el, eventName, callback) {
	if(typeof el == 'string')
		el = document.getElementById(el);
	if(!el) return;
	if(el.addEventListener)
		el.addEventListener(eventName, callback, false);
	else if (el.attachEvent)
		el.attachEvent('on' + eventName, callback);
}

function unhookEvent(el, eventName, callback) {
	if(typeof el == 'string')
		el = document.getElementById(el);
	if(!el) return;
	if(el.removeEventListener)
		el.removeEventListener(eventName, callback, false);
	else if(el.detachEvent) 
		el.detachEvent('on' + eventName, callback);
}

function getStyle(el, property) {
	if(typeof el == 'string')
		el = document.getElementById(el);
	if(!el || !property) return;
	var value = el.style[property];
	if(!value) {
		if(document.defaultView && document.defaultView.getComputedStyle) {
			var css = document.defaultView.getComputedStyle(el, null);
			value = css ? css.getPropertyValue(property) : null;
		} else if (el.currentStyle) {
			value = el.currentStyle[property];
		}
	}
	return value == 'auto' ? '' : value;
}

function cancelEvent(e) {
	e = e ? e : window.event;
	if(e.stopPropagation)
		e.stopPropagation();
	if(e.preventDefault)
		e.preventDefault();
	e.cancelBubble = true;
	e.returnValue = false;
	return false;
}

function Position(x, y) {
	this.X = x;
	this.Y = y;
}
Position.prototype = {
	constructor: Position,
		
	add : function(val) {
		var newPos = new Position(this.X, this.Y);
		if (val) {
			newPos.X += val.X;
			newPos.Y += val.Y;
		}
		return newPos;
	},

	subtract : function(val) {
		var newPos = new Position(this.X, this.Y);
		if (val) {
			newPos.X -= val.X;
			newPos.Y -= val.Y;
		}
		return newPos;
	},

	min : function(val) {
		var newPos = new Position(this.X, this.Y);
		if (val) {
			newPos.X = this.X > val.X ? val.X : this.X;
			newPos.Y = this.Y > val.Y ? val.Y : this.Y;
			return newPos;
		}
		return newPos;
	},

	max : function(val) {
		var newPos = new Position(this.X, this.Y);
		if (val) {
			newPos.X = this.X < val.X ? val.X : this.X;
			newPos.Y = this.Y < val.Y ? val.Y : this.Y;
			return newPos;
		}
		return newPos;
	},

	bound : function(lower, upper) {
		var newPos = this.max(lower);
		return newPos.min(upper);
	},

	check : function() {
		var newPos = new Position(this.X, this.Y);
		if (isNaN(newPos.X))
			newPos.X = 0;
		if (isNaN(newPos.Y))
			newPos.Y = 0;
		return newPos;
	},
	
	apply : function(el) {
		if(typeof el == 'string')
			el = document.getElementById(el);
		if(!el) return;
		el.style.left = this.X + 'px';
		el.style.top = this.Y + 'px';
	}
};

function absoluteCursorPosition(e) {
	e = e ? e : window.event;
	var x = e.clientX + (document.documentElement || document.body).scrollLeft;
	var y = e.clientY + (document.documentElement || document.body).scrollTop;
	return new Position(x, y);
}

/**
 * el, attachEl, lowerBound, upperBound, startCallback, moveCallback, endCallback, attachLater
 */
function DragObject(cfg) {
	var el = cfg.el,
	    attachEl = cfg.attachEl,
	    lowerBound = cfg.lowerBound,
	    upperBound = cfg.upperBound,
	    startCallback = cfg.startCallback,
	    moveCallback = cfg.moveCallback,
	    endCallback = cfg.endCallback,
	    attachLater = cfg.attachLater;
	
	if(typeof el == 'string')
		el = document.getElementById(el);
	if(!el) return;
	
	if(lowerBound != undefined && upperBound != undefined) {
		var tempPos = lowerBound.min(upperBound);
		upperBound = lowerBound.max(upperBound);
		lowerBound = tempPos;
	}
	
	var cursorStartPos,
		elementStartPos,
		dragging = false,
		listening = false,
		disposed = false;
	
	function dragStart(eventObj) {
		if(dragging || !listening || disposed) return;
		dragging = true;
		
		if(startCallback)
			startCallback(eventObj, el);
		
		cursorStartPos = absoluteCursorPosition(eventObj);
		
		elementStartPos = new Position(parseInt(getStyle(el, 'left')), parseInt(getStyle(el, 'top')));
		
		elementStartPos = elementStartPos.check();
		
		hookEvent(document, 'mousemove', dragGo);
		hookEvent(document, 'mouseup', dragStopHook);
		
		return cancelEvent(eventObj);
	}
	
	function dragGo(e) {
		if(!dragging || disposed) return;
		var newPos = absoluteCursorPosition(e);
		newPos = newPos.add(elementStartPos)
					   .subtract(cursorStartPos)
					   .bound(lowerBound, upperBound);
		newPos.apply(el);
		if(moveCallback)
			moveCallback(newPos, el);
		
		return cancelEvent(e);
	}
	
	function dragStopHook(e) {
		dragStop();
		return cancelEvent(e);
	}
	
	function dragStop() {
		if(!dragging || disposed) return;
		unhookEvent(document, 'mousemove', dragGo);
		unhookEvent(document, 'mouseup', dragStopHook);
		cursorStartPos = null;
		elementStartPos = null;
		if(endCallback)
			endCallback(el);
		dragging = false;
	}
	
	this.startListening = function() {
		if(listening || disposed) return;
		
		listening = true;
		hookEvent(attachEl, 'mousedown', dragStart);
	};
	
	this.stopListening = function(stopCurrentDragging) {
		if(!listening || disposed)
			return;
		
		unhookEvent(attachEl, 'mousedown', dragStart);
		listening = false;
		
		if(stopCurrentDragging && dragging)
			dragStop();
	};
	
	this.dispose = function() {
		if(disposed) return;
		this.stopListening(true);
		el = null;
	    attachEl = null;
	    lowerBound = null;
	    upperBound = null;
	    startCallback = null;
	    moveCallback = null;
	    endCallback = null;
	    disposed = true;
	};
	
	this.isDragging = function() {
		return dragging;
	};
	
	this.isListening = function() {
		return listening;
	};
	
	this.isDisposed = function() {
		return disposed;
	};
	
	if(typeof attachEl == 'string')
		attachEl = document.getElementById(attachEl);
	if(!attachEl) attachEl = el;
	
	if(!attachLater)
		this.startListening();
}




	
	

	
	
