var snapper = new Snap({
element: document.getElementById('page-content'),
dragger: document.getElementById('header')
});
  
var addEvent = function addEvent(element, eventName, func) {
	if (element.addEventListener) {
    	return element.addEventListener(eventName, func, false);
    } else if (element.attachEvent) {
        return element.attachEvent("on" + eventName, func);
    }
};

addEvent(document.getElementById('toggle-menu'), 'click', function(){
	var toggle = document.getElementById('toggle-menu');
	if (toggle.getAttribute('title') == 'open') {
		snapper.open('left');
		toggle.setAttribute('title','close')
	}
	else {
		snapper.close();
		toggle.setAttribute('title','open')
	}
});

/* Prevent Safari opening links when viewing as a Mobile App */
(function (a, b, c) {
    if(c in b && b[c]) {
        var d, e = a.location,
            f = /^(a|html)$/i;
        a.addEventListener("click", function (a) {
            d = a.target;
            while(!f.test(d.nodeName)) d = d.parentNode;
            "href" in d && (d.href.indexOf("http") || ~d.href.indexOf(e.host)) && (a.preventDefault(), e.href = d.href)
        }, !1)
    }
})(document, window.navigator, "standalone");