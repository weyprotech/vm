!function(n){function t(n){return n<10?"0"+n:n}n.fn.showclock=function(){var s=new Date,a=n(this).data("date").split("-"),o=[0,0];void 0!=n(this).data("time")&&(o=n(this).data("time").split(":"));var c=new Date(a[0],a[1]-1,a[2],o[0],o[1]),e=c.getTime()/1e3-s.getTime()/1e3;if(e<=0||isNaN(e))return this.hide(),this;var i=Math.floor(e/86400);e%=86400;var u=Math.floor(e/3600);e%=3600;var d=Math.floor(e/60);e=Math.floor(e%60);var l="";0!=i&&(l+='<div class="countdown-container days">',l+='<span class="countdown_value">'+t(i)+"</span>",l+='<span class="countdown_title">Days</span>',l+="</div>"),l+='<div class="countdown-container hours">',l+='<span class="countdown_value">'+t(u)+"</span>",l+='<span class="countdown_title">Hours</span>',l+="</div>",l+='<div class="countdown-container minutes">',l+='<span class="countdown_value">'+t(d)+"</span>",l+='<span class="countdown_title">Mins</span>',l+="</div>",l+='<div class="countdown-container seconds">',l+='<span class="countdown_value">'+t(e)+"</span>",l+='<span class="countdown_title">Sec</span>',l+="</div>",this.html(l)},n.fn.countdown=function(){var t=n(this);t.showclock(),setInterval(function(){t.showclock()},1e3)}}(jQuery),jQuery(document).ready(function(){jQuery(".countdown").length>0&&jQuery(".countdown").each(function(){jQuery(this).countdown()})});