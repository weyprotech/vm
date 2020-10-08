! function (t) {
    "function" == typeof define && define.amd ? define(["jquery"], t) : "object" == typeof module && module.exports ? module.exports = t(require("jquery")) : t(jQuery)
}(function (t) {
    var e = Array.prototype.slice,
        i = Array.prototype.splice,
        o = {
            topSpacing: 0,
            bottomSpacing: 0,
            className: "is-sticky",
            wrapperClassName: "sticky-wrapper",
            center: !1,
            getWidthFrom: "",
            widthFromWrapper: !0,
            responsiveWidth: !1,
            zIndex: "inherit"
        },
        n = t(window),
        r = t(document),
        s = [],
        a = n.height(),
        l = function () {
            for (var e = n.scrollTop(), i = r.height(), o = i - a, l = e > o ? o - e : 0, c = 0, d = s.length; c < d; c++) {
                var u = s[c],
                    p = u.stickyWrapper.offset().top,
                    h = p - u.topSpacing - l;
                if (u.stickyWrapper.css("height", u.stickyElement.outerHeight()), e <= h) null !== u.currentTop && (u.stickyElement.css({
                    width: "",
                    position: "",
                    top: "",
                    "z-index": ""
                }), u.stickyElement.parent().removeClass(u.className), u.stickyElement.trigger("sticky-end", [u]), u.currentTop = null);
                else {
                    var f = i - u.stickyElement.outerHeight() - u.topSpacing - u.bottomSpacing - e - l;
                    if (f < 0 ? f += u.topSpacing : f = u.topSpacing, u.currentTop !== f) {
                        var m;
                        u.getWidthFrom ? (padding = u.stickyElement.innerWidth() - u.stickyElement.width(), m = t(u.getWidthFrom).width() - padding || null) : u.widthFromWrapper && (m = u.stickyWrapper.width()), null == m && (m = u.stickyElement.width()), u.stickyElement.css("width", m).css("position", "fixed").css("top", f).css("z-index", u.zIndex), u.stickyElement.parent().addClass(u.className), null === u.currentTop ? u.stickyElement.trigger("sticky-start", [u]) : u.stickyElement.trigger("sticky-update", [u]), u.currentTop === u.topSpacing && u.currentTop > f || null === u.currentTop && f < u.topSpacing ? u.stickyElement.trigger("sticky-bottom-reached", [u]) : null !== u.currentTop && f === u.topSpacing && u.currentTop < f && u.stickyElement.trigger("sticky-bottom-unreached", [u]), u.currentTop = f
                    }
                    var g = u.stickyWrapper.parent();
                    u.stickyElement.offset().top + u.stickyElement.outerHeight() >= g.offset().top + g.outerHeight() && u.stickyElement.offset().top <= u.topSpacing ? u.stickyElement.css("position", "absolute").css("top", "").css("bottom", 0).css("z-index", "") : u.stickyElement.css("position", "fixed").css("top", f).css("bottom", "").css("z-index", u.zIndex)
                }
            }
        },
        c = function () {
            a = n.height();
            for (var e = 0, i = s.length; e < i; e++) {
                var o = s[e],
                    r = null;
                o.getWidthFrom ? o.responsiveWidth && (r = t(o.getWidthFrom).width()) : o.widthFromWrapper && (r = o.stickyWrapper.width()), null != r && o.stickyElement.css("width", r)
            }
        },
        d = {
            init: function (e) {
                return this.each(function () {
                    var i = t.extend({}, o, e),
                        n = t(this),
                        r = n.attr("id"),
                        a = r ? r + "-" + o.wrapperClassName : o.wrapperClassName,
                        l = t("<div></div>").attr("id", a).addClass(i.wrapperClassName);
                    n.wrapAll(function () {
                        if (0 == t(this).parent("#" + a).length) return l
                    });
                    var c = n.parent();
                    i.center && c.css({
                        width: n.outerWidth(),
                        marginLeft: "auto",
                        marginRight: "auto"
                    }), "right" === n.css("float") && n.css({
                        float: "none"
                    }).parent().css({
                        float: "right"
                    }), i.stickyElement = n, i.stickyWrapper = c, i.currentTop = null, s.push(i), d.setWrapperHeight(this), d.setupChangeListeners(this)
                })
            },
            setWrapperHeight: function (e) {
                var i = t(e),
                    o = i.parent();
                o && o.css("height", i.outerHeight())
            },
            setupChangeListeners: function (t) {
                if (window.MutationObserver) {
                    new window.MutationObserver(function (e) {
                        (e[0].addedNodes.length || e[0].removedNodes.length) && d.setWrapperHeight(t)
                    }).observe(t, {
                        subtree: !0,
                        childList: !0
                    })
                } else window.addEventListener ? (t.addEventListener("DOMNodeInserted", function () {
                    d.setWrapperHeight(t)
                }, !1), t.addEventListener("DOMNodeRemoved", function () {
                    d.setWrapperHeight(t)
                }, !1)) : window.attachEvent && (t.attachEvent("onDOMNodeInserted", function () {
                    d.setWrapperHeight(t)
                }), t.attachEvent("onDOMNodeRemoved", function () {
                    d.setWrapperHeight(t)
                }))
            },
            update: l,
            unstick: function (e) {
                return this.each(function () {
                    for (var e = this, o = t(e), n = -1, r = s.length; r-- > 0;) s[r].stickyElement.get(0) === e && (i.call(s, r, 1), n = r); - 1 !== n && (o.unwrap(), o.css({
                        width: "",
                        position: "",
                        top: "",
                        float: "",
                        "z-index": ""
                    }))
                })
            }
        };
    window.addEventListener ? (window.addEventListener("scroll", l, !1), window.addEventListener("resize", c, !1)) : window.attachEvent && (window.attachEvent("onscroll", l), window.attachEvent("onresize", c)), t.fn.sticky = function (i) {
        return d[i] ? d[i].apply(this, e.call(arguments, 1)) : "object" != typeof i && i ? void t.error("Method " + i + " does not exist on jQuery.sticky") : d.init.apply(this, arguments)
    }, t.fn.unstick = function (i) {
        return d[i] ? d[i].apply(this, e.call(arguments, 1)) : "object" != typeof i && i ? void t.error("Method " + i + " does not exist on jQuery.sticky") : d.unstick.apply(this, arguments)
    }, t(function () {
        setTimeout(l, 0)
    })
}),
function (t) {
    t.fn.sidebar = function (e) {
        function i() {
            o.trigger("sidebar:close", [{
                speed: 0
            }])
        }
        var o = this;
        if (o.length > 1) return o.each(function () {
            t(this).sidebar(e)
        });
        var n = (o.outerWidth(), o.outerHeight(), t.extend({
            speed: 200,
            side: "left",
            isClosed: !1,
            close: !0
        }, e));
        return o.on("sidebar:open", function (e, i) {
            var r = {};
            r[n.side] = 0, n.isClosed = null, o.stop().animate(r, t.extend({}, n, i).speed, function () {
                n.isClosed = !1, o.trigger("sidebar:opened")
            })
        }), o.on("sidebar:close", function (e, i) {
            var r = {};
            "left" === n.side || "right" === n.side ? r[n.side] = -o.outerWidth() : r[n.side] = -o.outerHeight(), n.isClosed = null, o.stop().animate(r, t.extend({}, n, i).speed, function () {
                n.isClosed = !0, o.trigger("sidebar:closed")
            })
        }), o.on("sidebar:toggle", function (t, e) {
            n.isClosed ? o.trigger("sidebar:open", [e]) : o.trigger("sidebar:close", [e])
        }), !n.isClosed && n.close && i(), t(window).on("resize", function () {
            n.isClosed && i()
        }), o.data("sidebar", n), o
    }, t.fn.sidebar.version = "3.3.2"
}(jQuery),
function (t) {
    "use strict";
    "function" == typeof define && define.amd ? define(["jquery"], t) : "undefined" != typeof exports ? module.exports = t(require("jquery")) : t(jQuery)
}(function (t) {
    "use strict";
    var e = window.Slick || {};
    (e = function () {
        var e = 0;
        return function (i, o) {
            var n, r = this;
            r.defaults = {
                accessibility: !0,
                adaptiveHeight: !1,
                appendArrows: t(i),
                appendDots: t(i),
                arrows: !0,
                asNavFor: null,
                prevArrow: '<button class="slick-prev" aria-label="Previous" type="button">Previous</button>',
                nextArrow: '<button class="slick-next" aria-label="Next" type="button">Next</button>',
                autoplay: !1,
                autoplaySpeed: 3e3,
                centerMode: !1,
                centerPadding: "50px",
                cssEase: "ease",
                customPaging: function (e, i) {
                    return t('<button type="button" />').text(i + 1)
                },
                dots: !1,
                dotsClass: "slick-dots",
                draggable: !0,
                easing: "linear",
                edgeFriction: .35,
                fade: !1,
                focusOnSelect: !1,
                focusOnChange: !1,
                infinite: !0,
                initialSlide: 0,
                lazyLoad: "ondemand",
                mobileFirst: !1,
                pauseOnHover: !0,
                pauseOnFocus: !0,
                pauseOnDotsHover: !1,
                respondTo: "window",
                responsive: null,
                rows: 1,
                rtl: !1,
                slide: "",
                slidesPerRow: 1,
                slidesToShow: 1,
                slidesToScroll: 1,
                speed: 500,
                swipe: !0,
                swipeToSlide: !1,
                touchMove: !0,
                touchThreshold: 5,
                useCSS: !0,
                useTransform: !0,
                variableWidth: !1,
                vertical: !1,
                verticalSwiping: !1,
                waitForAnimate: !0,
                zIndex: 1e3
            }, r.initials = {
                animating: !1,
                dragging: !1,
                autoPlayTimer: null,
                currentDirection: 0,
                currentLeft: null,
                currentSlide: 0,
                direction: 1,
                $dots: null,
                listWidth: null,
                listHeight: null,
                loadIndex: 0,
                $nextArrow: null,
                $prevArrow: null,
                scrolling: !1,
                slideCount: null,
                slideWidth: null,
                $slideTrack: null,
                $slides: null,
                sliding: !1,
                slideOffset: 0,
                swipeLeft: null,
                swiping: !1,
                $list: null,
                touchObject: {},
                transformsEnabled: !1,
                unslicked: !1
            }, t.extend(r, r.initials), r.activeBreakpoint = null, r.animType = null, r.animProp = null, r.breakpoints = [], r.breakpointSettings = [], r.cssTransitions = !1, r.focussed = !1, r.interrupted = !1, r.hidden = "hidden", r.paused = !0, r.positionProp = null, r.respondTo = null, r.rowCount = 1, r.shouldClick = !0, r.$slider = t(i), r.$slidesCache = null, r.transformType = null, r.transitionType = null, r.visibilityChange = "visibilitychange", r.windowWidth = 0, r.windowTimer = null, n = t(i).data("slick") || {}, r.options = t.extend({}, r.defaults, o, n), r.currentSlide = r.options.initialSlide, r.originalSettings = r.options, void 0 !== document.mozHidden ? (r.hidden = "mozHidden", r.visibilityChange = "mozvisibilitychange") : void 0 !== document.webkitHidden && (r.hidden = "webkitHidden", r.visibilityChange = "webkitvisibilitychange"), r.autoPlay = t.proxy(r.autoPlay, r), r.autoPlayClear = t.proxy(r.autoPlayClear, r), r.autoPlayIterator = t.proxy(r.autoPlayIterator, r), r.changeSlide = t.proxy(r.changeSlide, r), r.clickHandler = t.proxy(r.clickHandler, r), r.selectHandler = t.proxy(r.selectHandler, r), r.setPosition = t.proxy(r.setPosition, r), r.swipeHandler = t.proxy(r.swipeHandler, r), r.dragHandler = t.proxy(r.dragHandler, r), r.keyHandler = t.proxy(r.keyHandler, r), r.instanceUid = e++, r.htmlExpr = /^(?:\s*(<[\w\W]+>)[^>]*)$/, r.registerBreakpoints(), r.init(!0)
        }
    }()).prototype.activateADA = function () {
        this.$slideTrack.find(".slick-active").attr({
            "aria-hidden": "false"
        }).find("a, input, button, select").attr({
            tabindex: "0"
        })
    }, e.prototype.addSlide = e.prototype.slickAdd = function (e, i, o) {
        var n = this;
        if ("boolean" == typeof i) o = i, i = null;
        else if (i < 0 || i >= n.slideCount) return !1;
        n.unload(), "number" == typeof i ? 0 === i && 0 === n.$slides.length ? t(e).appendTo(n.$slideTrack) : o ? t(e).insertBefore(n.$slides.eq(i)) : t(e).insertAfter(n.$slides.eq(i)) : !0 === o ? t(e).prependTo(n.$slideTrack) : t(e).appendTo(n.$slideTrack), n.$slides = n.$slideTrack.children(this.options.slide), n.$slideTrack.children(this.options.slide).detach(), n.$slideTrack.append(n.$slides), n.$slides.each(function (e, i) {
            t(i).attr("data-slick-index", e)
        }), n.$slidesCache = n.$slides, n.reinit()
    }, e.prototype.animateHeight = function () {
        var t = this;
        if (1 === t.options.slidesToShow && !0 === t.options.adaptiveHeight && !1 === t.options.vertical) {
            var e = t.$slides.eq(t.currentSlide).outerHeight(!0);
            t.$list.animate({
                height: e
            }, t.options.speed)
        }
    }, e.prototype.animateSlide = function (e, i) {
        var o = {},
            n = this;
        n.animateHeight(), !0 === n.options.rtl && !1 === n.options.vertical && (e = -e), !1 === n.transformsEnabled ? !1 === n.options.vertical ? n.$slideTrack.animate({
            left: e
        }, n.options.speed, n.options.easing, i) : n.$slideTrack.animate({
            top: e
        }, n.options.speed, n.options.easing, i) : !1 === n.cssTransitions ? (!0 === n.options.rtl && (n.currentLeft = -n.currentLeft), t({
            animStart: n.currentLeft
        }).animate({
            animStart: e
        }, {
            duration: n.options.speed,
            easing: n.options.easing,
            step: function (t) {
                t = Math.ceil(t), !1 === n.options.vertical ? (o[n.animType] = "translate(" + t + "px, 0px)", n.$slideTrack.css(o)) : (o[n.animType] = "translate(0px," + t + "px)", n.$slideTrack.css(o))
            },
            complete: function () {
                i && i.call()
            }
        })) : (n.applyTransition(), e = Math.ceil(e), !1 === n.options.vertical ? o[n.animType] = "translate3d(" + e + "px, 0px, 0px)" : o[n.animType] = "translate3d(0px," + e + "px, 0px)", n.$slideTrack.css(o), i && setTimeout(function () {
            n.disableTransition(), i.call()
        }, n.options.speed))
    }, e.prototype.getNavTarget = function () {
        var e = this,
            i = e.options.asNavFor;
        return i && null !== i && (i = t(i).not(e.$slider)), i
    }, e.prototype.asNavFor = function (e) {
        var i = this.getNavTarget();
        null !== i && "object" == typeof i && i.each(function () {
            var i = t(this).slick("getSlick");
            i.unslicked || i.slideHandler(e, !0)
        })
    }, e.prototype.applyTransition = function (t) {
        var e = this,
            i = {};
        !1 === e.options.fade ? i[e.transitionType] = e.transformType + " " + e.options.speed + "ms " + e.options.cssEase : i[e.transitionType] = "opacity " + e.options.speed + "ms " + e.options.cssEase, !1 === e.options.fade ? e.$slideTrack.css(i) : e.$slides.eq(t).css(i)
    }, e.prototype.autoPlay = function () {
        var t = this;
        t.autoPlayClear(), t.slideCount > t.options.slidesToShow && (t.autoPlayTimer = setInterval(t.autoPlayIterator, t.options.autoplaySpeed))
    }, e.prototype.autoPlayClear = function () {
        var t = this;
        t.autoPlayTimer && clearInterval(t.autoPlayTimer)
    }, e.prototype.autoPlayIterator = function () {
        var t = this,
            e = t.currentSlide + t.options.slidesToScroll;
        t.paused || t.interrupted || t.focussed || (!1 === t.options.infinite && (1 === t.direction && t.currentSlide + 1 === t.slideCount - 1 ? t.direction = 0 : 0 === t.direction && (e = t.currentSlide - t.options.slidesToScroll, t.currentSlide - 1 == 0 && (t.direction = 1))), t.slideHandler(e))
    }, e.prototype.buildArrows = function () {
        var e = this;
        !0 === e.options.arrows && (e.$prevArrow = t(e.options.prevArrow).addClass("slick-arrow"), e.$nextArrow = t(e.options.nextArrow).addClass("slick-arrow"), e.slideCount > e.options.slidesToShow ? (e.$prevArrow.removeClass("slick-hidden").removeAttr("aria-hidden tabindex"), e.$nextArrow.removeClass("slick-hidden").removeAttr("aria-hidden tabindex"), e.htmlExpr.test(e.options.prevArrow) && e.$prevArrow.prependTo(e.options.appendArrows), e.htmlExpr.test(e.options.nextArrow) && e.$nextArrow.appendTo(e.options.appendArrows), !0 !== e.options.infinite && e.$prevArrow.addClass("slick-disabled").attr("aria-disabled", "true")) : e.$prevArrow.add(e.$nextArrow).addClass("slick-hidden").attr({
            "aria-disabled": "true",
            tabindex: "-1"
        }))
    }, e.prototype.buildDots = function () {
        var e, i, o = this;
        if (!0 === o.options.dots) {
            for (o.$slider.addClass("slick-dotted"), i = t("<ul />").addClass(o.options.dotsClass), e = 0; e <= o.getDotCount(); e += 1) i.append(t("<li />").append(o.options.customPaging.call(this, o, e)));
            o.$dots = i.appendTo(o.options.appendDots), o.$dots.find("li").first().addClass("slick-active")
        }
    }, e.prototype.buildOut = function () {
        var e = this;
        e.$slides = e.$slider.children(e.options.slide + ":not(.slick-cloned)").addClass("slick-slide"), e.slideCount = e.$slides.length, e.$slides.each(function (e, i) {
            t(i).attr("data-slick-index", e).data("originalStyling", t(i).attr("style") || "")
        }), e.$slider.addClass("slick-slider"), e.$slideTrack = 0 === e.slideCount ? t('<div class="slick-track"/>').appendTo(e.$slider) : e.$slides.wrapAll('<div class="slick-track"/>').parent(), e.$list = e.$slideTrack.wrap('<div class="slick-list"/>').parent(), e.$slideTrack.css("opacity", 0), !0 !== e.options.centerMode && !0 !== e.options.swipeToSlide || (e.options.slidesToScroll = 1), t("img[data-lazy]", e.$slider).not("[src]").addClass("slick-loading"), e.setupInfinite(), e.buildArrows(), e.buildDots(), e.updateDots(), e.setSlideClasses("number" == typeof e.currentSlide ? e.currentSlide : 0), !0 === e.options.draggable && e.$list.addClass("draggable")
    }, e.prototype.buildRows = function () {
        var t, e, i, o, n, r, s, a = this;
        if (o = document.createDocumentFragment(), r = a.$slider.children(), a.options.rows > 1) {
            for (s = a.options.slidesPerRow * a.options.rows, n = Math.ceil(r.length / s), t = 0; t < n; t++) {
                var l = document.createElement("div");
                for (e = 0; e < a.options.rows; e++) {
                    var c = document.createElement("div");
                    for (i = 0; i < a.options.slidesPerRow; i++) {
                        var d = t * s + (e * a.options.slidesPerRow + i);
                        r.get(d) && c.appendChild(r.get(d))
                    }
                    l.appendChild(c)
                }
                o.appendChild(l)
            }
            a.$slider.empty().append(o), a.$slider.children().children().children().css({
                width: 100 / a.options.slidesPerRow + "%",
                display: "inline-block"
            })
        }
    }, e.prototype.checkResponsive = function (e, i) {
        var o, n, r, s = this,
            a = !1,
            l = s.$slider.width(),
            c = window.innerWidth || t(window).width();
        if ("window" === s.respondTo ? r = c : "slider" === s.respondTo ? r = l : "min" === s.respondTo && (r = Math.min(c, l)), s.options.responsive && s.options.responsive.length && null !== s.options.responsive) {
            n = null;
            for (o in s.breakpoints) s.breakpoints.hasOwnProperty(o) && (!1 === s.originalSettings.mobileFirst ? r < s.breakpoints[o] && (n = s.breakpoints[o]) : r > s.breakpoints[o] && (n = s.breakpoints[o]));
            null !== n ? null !== s.activeBreakpoint ? (n !== s.activeBreakpoint || i) && (s.activeBreakpoint = n, "unslick" === s.breakpointSettings[n] ? s.unslick(n) : (s.options = t.extend({}, s.originalSettings, s.breakpointSettings[n]), !0 === e && (s.currentSlide = s.options.initialSlide), s.refresh(e)), a = n) : (s.activeBreakpoint = n, "unslick" === s.breakpointSettings[n] ? s.unslick(n) : (s.options = t.extend({}, s.originalSettings, s.breakpointSettings[n]), !0 === e && (s.currentSlide = s.options.initialSlide), s.refresh(e)), a = n) : null !== s.activeBreakpoint && (s.activeBreakpoint = null, s.options = s.originalSettings, !0 === e && (s.currentSlide = s.options.initialSlide), s.refresh(e), a = n), e || !1 === a || s.$slider.trigger("breakpoint", [s, a])
        }
    }, e.prototype.changeSlide = function (e, i) {
        var o, n, r, s = this,
            a = t(e.currentTarget);
        switch (a.is("a") && e.preventDefault(), a.is("li") || (a = a.closest("li")), r = s.slideCount % s.options.slidesToScroll != 0, o = r ? 0 : (s.slideCount - s.currentSlide) % s.options.slidesToScroll, e.data.message) {
            case "previous":
                n = 0 === o ? s.options.slidesToScroll : s.options.slidesToShow - o, s.slideCount > s.options.slidesToShow && s.slideHandler(s.currentSlide - n, !1, i);
                break;
            case "next":
                n = 0 === o ? s.options.slidesToScroll : o, s.slideCount > s.options.slidesToShow && s.slideHandler(s.currentSlide + n, !1, i);
                break;
            case "index":
                var l = 0 === e.data.index ? 0 : e.data.index || a.index() * s.options.slidesToScroll;
                s.slideHandler(s.checkNavigable(l), !1, i), a.children().trigger("focus");
                break;
            default:
                return
        }
    }, e.prototype.checkNavigable = function (t) {
        var e, i;
        if (e = this.getNavigableIndexes(), i = 0, t > e[e.length - 1]) t = e[e.length - 1];
        else
            for (var o in e) {
                if (t < e[o]) {
                    t = i;
                    break
                }
                i = e[o]
            }
        return t
    }, e.prototype.cleanUpEvents = function () {
        var e = this;
        e.options.dots && null !== e.$dots && (t("li", e.$dots).off("click.slick", e.changeSlide).off("mouseenter.slick", t.proxy(e.interrupt, e, !0)).off("mouseleave.slick", t.proxy(e.interrupt, e, !1)), !0 === e.options.accessibility && e.$dots.off("keydown.slick", e.keyHandler)), e.$slider.off("focus.slick blur.slick"), !0 === e.options.arrows && e.slideCount > e.options.slidesToShow && (e.$prevArrow && e.$prevArrow.off("click.slick", e.changeSlide), e.$nextArrow && e.$nextArrow.off("click.slick", e.changeSlide), !0 === e.options.accessibility && (e.$prevArrow && e.$prevArrow.off("keydown.slick", e.keyHandler), e.$nextArrow && e.$nextArrow.off("keydown.slick", e.keyHandler))), e.$list.off("touchstart.slick mousedown.slick", e.swipeHandler), e.$list.off("touchmove.slick mousemove.slick", e.swipeHandler), e.$list.off("touchend.slick mouseup.slick", e.swipeHandler), e.$list.off("touchcancel.slick mouseleave.slick", e.swipeHandler), e.$list.off("click.slick", e.clickHandler), t(document).off(e.visibilityChange, e.visibility), e.cleanUpSlideEvents(), !0 === e.options.accessibility && e.$list.off("keydown.slick", e.keyHandler), !0 === e.options.focusOnSelect && t(e.$slideTrack).children().off("click.slick", e.selectHandler), t(window).off("orientationchange.slick.slick-" + e.instanceUid, e.orientationChange), t(window).off("resize.slick.slick-" + e.instanceUid, e.resize), t("[draggable!=true]", e.$slideTrack).off("dragstart", e.preventDefault), t(window).off("load.slick.slick-" + e.instanceUid, e.setPosition)
    }, e.prototype.cleanUpSlideEvents = function () {
        var e = this;
        e.$list.off("mouseenter.slick", t.proxy(e.interrupt, e, !0)), e.$list.off("mouseleave.slick", t.proxy(e.interrupt, e, !1))
    }, e.prototype.cleanUpRows = function () {
        var t, e = this;
        e.options.rows > 1 && ((t = e.$slides.children().children()).removeAttr("style"), e.$slider.empty().append(t))
    }, e.prototype.clickHandler = function (t) {
        !1 === this.shouldClick && (t.stopImmediatePropagation(), t.stopPropagation(), t.preventDefault())
    }, e.prototype.destroy = function (e) {
        var i = this;
        i.autoPlayClear(), i.touchObject = {}, i.cleanUpEvents(), t(".slick-cloned", i.$slider).detach(), i.$dots && i.$dots.remove(), i.$prevArrow && i.$prevArrow.length && (i.$prevArrow.removeClass("slick-disabled slick-arrow slick-hidden").removeAttr("aria-hidden aria-disabled tabindex").css("display", ""), i.htmlExpr.test(i.options.prevArrow) && i.$prevArrow.remove()), i.$nextArrow && i.$nextArrow.length && (i.$nextArrow.removeClass("slick-disabled slick-arrow slick-hidden").removeAttr("aria-hidden aria-disabled tabindex").css("display", ""), i.htmlExpr.test(i.options.nextArrow) && i.$nextArrow.remove()), i.$slides && (i.$slides.removeClass("slick-slide slick-active slick-center slick-visible slick-current").removeAttr("aria-hidden").removeAttr("data-slick-index").each(function () {
            t(this).attr("style", t(this).data("originalStyling"))
        }), i.$slideTrack.children(this.options.slide).detach(), i.$slideTrack.detach(), i.$list.detach(), i.$slider.append(i.$slides)), i.cleanUpRows(), i.$slider.removeClass("slick-slider"), i.$slider.removeClass("slick-initialized"), i.$slider.removeClass("slick-dotted"), i.unslicked = !0, e || i.$slider.trigger("destroy", [i])
    }, e.prototype.disableTransition = function (t) {
        var e = this,
            i = {};
        i[e.transitionType] = "", !1 === e.options.fade ? e.$slideTrack.css(i) : e.$slides.eq(t).css(i)
    }, e.prototype.fadeSlide = function (t, e) {
        var i = this;
        !1 === i.cssTransitions ? (i.$slides.eq(t).css({
            zIndex: i.options.zIndex
        }), i.$slides.eq(t).animate({
            opacity: 1
        }, i.options.speed, i.options.easing, e)) : (i.applyTransition(t), i.$slides.eq(t).css({
            opacity: 1,
            zIndex: i.options.zIndex
        }), e && setTimeout(function () {
            i.disableTransition(t), e.call()
        }, i.options.speed))
    }, e.prototype.fadeSlideOut = function (t) {
        var e = this;
        !1 === e.cssTransitions ? e.$slides.eq(t).animate({
            opacity: 0,
            zIndex: e.options.zIndex - 2
        }, e.options.speed, e.options.easing) : (e.applyTransition(t), e.$slides.eq(t).css({
            opacity: 0,
            zIndex: e.options.zIndex - 2
        }))
    }, e.prototype.filterSlides = e.prototype.slickFilter = function (t) {
        var e = this;
        null !== t && (e.$slidesCache = e.$slides, e.unload(), e.$slideTrack.children(this.options.slide).detach(), e.$slidesCache.filter(t).appendTo(e.$slideTrack), e.reinit())
    }, e.prototype.focusHandler = function () {
        var e = this;
        e.$slider.off("focus.slick blur.slick").on("focus.slick blur.slick", "*", function (i) {
            i.stopImmediatePropagation();
            var o = t(this);
            setTimeout(function () {
                e.options.pauseOnFocus && (e.focussed = o.is(":focus"), e.autoPlay())
            }, 0)
        })
    }, e.prototype.getCurrent = e.prototype.slickCurrentSlide = function () {
        return this.currentSlide
    }, e.prototype.getDotCount = function () {
        var t = this,
            e = 0,
            i = 0,
            o = 0;
        if (!0 === t.options.infinite)
            if (t.slideCount <= t.options.slidesToShow) ++o;
            else
                for (; e < t.slideCount;) ++o, e = i + t.options.slidesToScroll, i += t.options.slidesToScroll <= t.options.slidesToShow ? t.options.slidesToScroll : t.options.slidesToShow;
        else if (!0 === t.options.centerMode) o = t.slideCount;
        else if (t.options.asNavFor)
            for (; e < t.slideCount;) ++o, e = i + t.options.slidesToScroll, i += t.options.slidesToScroll <= t.options.slidesToShow ? t.options.slidesToScroll : t.options.slidesToShow;
        else o = 1 + Math.ceil((t.slideCount - t.options.slidesToShow) / t.options.slidesToScroll);
        return o - 1
    }, e.prototype.getLeft = function (t) {
        var e, i, o, n, r = this,
            s = 0;
        return r.slideOffset = 0, i = r.$slides.first().outerHeight(!0), !0 === r.options.infinite ? (r.slideCount > r.options.slidesToShow && (r.slideOffset = r.slideWidth * r.options.slidesToShow * -1, n = -1, !0 === r.options.vertical && !0 === r.options.centerMode && (2 === r.options.slidesToShow ? n = -1.5 : 1 === r.options.slidesToShow && (n = -2)), s = i * r.options.slidesToShow * n), r.slideCount % r.options.slidesToScroll != 0 && t + r.options.slidesToScroll > r.slideCount && r.slideCount > r.options.slidesToShow && (t > r.slideCount ? (r.slideOffset = (r.options.slidesToShow - (t - r.slideCount)) * r.slideWidth * -1, s = (r.options.slidesToShow - (t - r.slideCount)) * i * -1) : (r.slideOffset = r.slideCount % r.options.slidesToScroll * r.slideWidth * -1, s = r.slideCount % r.options.slidesToScroll * i * -1))) : t + r.options.slidesToShow > r.slideCount && (r.slideOffset = (t + r.options.slidesToShow - r.slideCount) * r.slideWidth, s = (t + r.options.slidesToShow - r.slideCount) * i), r.slideCount <= r.options.slidesToShow && (r.slideOffset = 0, s = 0), !0 === r.options.centerMode && r.slideCount <= r.options.slidesToShow ? r.slideOffset = r.slideWidth * Math.floor(r.options.slidesToShow) / 2 - r.slideWidth * r.slideCount / 2 : !0 === r.options.centerMode && !0 === r.options.infinite ? r.slideOffset += r.slideWidth * Math.floor(r.options.slidesToShow / 2) - r.slideWidth : !0 === r.options.centerMode && (r.slideOffset = 0, r.slideOffset += r.slideWidth * Math.floor(r.options.slidesToShow / 2)), e = !1 === r.options.vertical ? t * r.slideWidth * -1 + r.slideOffset : t * i * -1 + s, !0 === r.options.variableWidth && (o = r.slideCount <= r.options.slidesToShow || !1 === r.options.infinite ? r.$slideTrack.children(".slick-slide").eq(t) : r.$slideTrack.children(".slick-slide").eq(t + r.options.slidesToShow), e = !0 === r.options.rtl ? o[0] ? -1 * (r.$slideTrack.width() - o[0].offsetLeft - o.width()) : 0 : o[0] ? -1 * o[0].offsetLeft : 0, !0 === r.options.centerMode && (o = r.slideCount <= r.options.slidesToShow || !1 === r.options.infinite ? r.$slideTrack.children(".slick-slide").eq(t) : r.$slideTrack.children(".slick-slide").eq(t + r.options.slidesToShow + 1), e = !0 === r.options.rtl ? o[0] ? -1 * (r.$slideTrack.width() - o[0].offsetLeft - o.width()) : 0 : o[0] ? -1 * o[0].offsetLeft : 0, e += (r.$list.width() - o.outerWidth()) / 2)), e
    }, e.prototype.getOption = e.prototype.slickGetOption = function (t) {
        return this.options[t]
    }, e.prototype.getNavigableIndexes = function () {
        var t, e = this,
            i = 0,
            o = 0,
            n = [];
        for (!1 === e.options.infinite ? t = e.slideCount : (i = -1 * e.options.slidesToScroll, o = -1 * e.options.slidesToScroll, t = 2 * e.slideCount); i < t;) n.push(i), i = o + e.options.slidesToScroll, o += e.options.slidesToScroll <= e.options.slidesToShow ? e.options.slidesToScroll : e.options.slidesToShow;
        return n
    }, e.prototype.getSlick = function () {
        return this
    }, e.prototype.getSlideCount = function () {
        var e, i, o = this;
        return i = !0 === o.options.centerMode ? o.slideWidth * Math.floor(o.options.slidesToShow / 2) : 0, !0 === o.options.swipeToSlide ? (o.$slideTrack.find(".slick-slide").each(function (n, r) {
            if (r.offsetLeft - i + t(r).outerWidth() / 2 > -1 * o.swipeLeft) return e = r, !1
        }), Math.abs(t(e).attr("data-slick-index") - o.currentSlide) || 1) : o.options.slidesToScroll
    }, e.prototype.goTo = e.prototype.slickGoTo = function (t, e) {
        this.changeSlide({
            data: {
                message: "index",
                index: parseInt(t)
            }
        }, e)
    }, e.prototype.init = function (e) {
        var i = this;
        t(i.$slider).hasClass("slick-initialized") || (t(i.$slider).addClass("slick-initialized"), i.buildRows(), i.buildOut(), i.setProps(), i.startLoad(), i.loadSlider(), i.initializeEvents(), i.updateArrows(), i.updateDots(), i.checkResponsive(!0), i.focusHandler()), e && i.$slider.trigger("init", [i]), !0 === i.options.accessibility && i.initADA(), i.options.autoplay && (i.paused = !1, i.autoPlay())
    }, e.prototype.initADA = function () {
        var e = this,
            i = Math.ceil(e.slideCount / e.options.slidesToShow),
            o = e.getNavigableIndexes().filter(function (t) {
                return t >= 0 && t < e.slideCount
            });
        e.$slides.add(e.$slideTrack.find(".slick-cloned")).attr({
            "aria-hidden": "true",
            tabindex: "-1"
        }).find("a, input, button, select").attr({
            tabindex: "-1"
        }), null !== e.$dots && (e.$slides.not(e.$slideTrack.find(".slick-cloned")).each(function (i) {
            var n = o.indexOf(i);
            t(this).attr({
                role: "tabpanel",
                id: "slick-slide" + e.instanceUid + i,
                tabindex: -1
            }), -1 !== n && t(this).attr({
                "aria-describedby": "slick-slide-control" + e.instanceUid + n
            })
        }), e.$dots.attr("role", "tablist").find("li").each(function (n) {
            var r = o[n];
            t(this).attr({
                role: "presentation"
            }), t(this).find("button").first().attr({
                role: "tab",
                id: "slick-slide-control" + e.instanceUid + n,
                "aria-controls": "slick-slide" + e.instanceUid + r,
                "aria-label": n + 1 + " of " + i,
                "aria-selected": null,
                tabindex: "-1"
            })
        }).eq(e.currentSlide).find("button").attr({
            "aria-selected": "true",
            tabindex: "0"
        }).end());
        for (var n = e.currentSlide, r = n + e.options.slidesToShow; n < r; n++) e.$slides.eq(n).attr("tabindex", 0);
        e.activateADA()
    }, e.prototype.initArrowEvents = function () {
        var t = this;
        !0 === t.options.arrows && t.slideCount > t.options.slidesToShow && (t.$prevArrow.off("click.slick").on("click.slick", {
            message: "previous"
        }, t.changeSlide), t.$nextArrow.off("click.slick").on("click.slick", {
            message: "next"
        }, t.changeSlide), !0 === t.options.accessibility && (t.$prevArrow.on("keydown.slick", t.keyHandler), t.$nextArrow.on("keydown.slick", t.keyHandler)))
    }, e.prototype.initDotEvents = function () {
        var e = this;
        !0 === e.options.dots && (t("li", e.$dots).on("click.slick", {
            message: "index"
        }, e.changeSlide), !0 === e.options.accessibility && e.$dots.on("keydown.slick", e.keyHandler)), !0 === e.options.dots && !0 === e.options.pauseOnDotsHover && t("li", e.$dots).on("mouseenter.slick", t.proxy(e.interrupt, e, !0)).on("mouseleave.slick", t.proxy(e.interrupt, e, !1))
    }, e.prototype.initSlideEvents = function () {
        var e = this;
        e.options.pauseOnHover && (e.$list.on("mouseenter.slick", t.proxy(e.interrupt, e, !0)), e.$list.on("mouseleave.slick", t.proxy(e.interrupt, e, !1)))
    }, e.prototype.initializeEvents = function () {
        var e = this;
        e.initArrowEvents(), e.initDotEvents(), e.initSlideEvents(), e.$list.on("touchstart.slick mousedown.slick", {
            action: "start"
        }, e.swipeHandler), e.$list.on("touchmove.slick mousemove.slick", {
            action: "move"
        }, e.swipeHandler), e.$list.on("touchend.slick mouseup.slick", {
            action: "end"
        }, e.swipeHandler), e.$list.on("touchcancel.slick mouseleave.slick", {
            action: "end"
        }, e.swipeHandler), e.$list.on("click.slick", e.clickHandler), t(document).on(e.visibilityChange, t.proxy(e.visibility, e)), !0 === e.options.accessibility && e.$list.on("keydown.slick", e.keyHandler), !0 === e.options.focusOnSelect && t(e.$slideTrack).children().on("click.slick", e.selectHandler), t(window).on("orientationchange.slick.slick-" + e.instanceUid, t.proxy(e.orientationChange, e)), t(window).on("resize.slick.slick-" + e.instanceUid, t.proxy(e.resize, e)), t("[draggable!=true]", e.$slideTrack).on("dragstart", e.preventDefault), t(window).on("load.slick.slick-" + e.instanceUid, e.setPosition), t(e.setPosition)
    }, e.prototype.initUI = function () {
        var t = this;
        !0 === t.options.arrows && t.slideCount > t.options.slidesToShow && (t.$prevArrow.show(), t.$nextArrow.show()), !0 === t.options.dots && t.slideCount > t.options.slidesToShow && t.$dots.show()
    }, e.prototype.keyHandler = function (t) {
        var e = this;
        t.target.tagName.match("TEXTAREA|INPUT|SELECT") || (37 === t.keyCode && !0 === e.options.accessibility ? e.changeSlide({
            data: {
                message: !0 === e.options.rtl ? "next" : "previous"
            }
        }) : 39 === t.keyCode && !0 === e.options.accessibility && e.changeSlide({
            data: {
                message: !0 === e.options.rtl ? "previous" : "next"
            }
        }))
    }, e.prototype.lazyLoad = function () {
        function e(e) {
            t("img[data-lazy]", e).each(function () {
                var e = t(this),
                    i = t(this).attr("data-lazy"),
                    o = t(this).attr("data-srcset"),
                    n = t(this).attr("data-sizes") || r.$slider.attr("data-sizes"),
                    s = document.createElement("img");
                s.onload = function () {
                    e.animate({
                        opacity: 0
                    }, 100, function () {
                        o && (e.attr("srcset", o), n && e.attr("sizes", n)), e.attr("src", i).animate({
                            opacity: 1
                        }, 200, function () {
                            e.removeAttr("data-lazy data-srcset data-sizes").removeClass("slick-loading")
                        }), r.$slider.trigger("lazyLoaded", [r, e, i])
                    })
                }, s.onerror = function () {
                    e.removeAttr("data-lazy").removeClass("slick-loading").addClass("slick-lazyload-error"), r.$slider.trigger("lazyLoadError", [r, e, i])
                }, s.src = i
            })
        }
        var i, o, n, r = this;
        if (!0 === r.options.centerMode ? !0 === r.options.infinite ? n = (o = r.currentSlide + (r.options.slidesToShow / 2 + 1)) + r.options.slidesToShow + 2 : (o = Math.max(0, r.currentSlide - (r.options.slidesToShow / 2 + 1)), n = r.options.slidesToShow / 2 + 1 + 2 + r.currentSlide) : (o = r.options.infinite ? r.options.slidesToShow + r.currentSlide : r.currentSlide, n = Math.ceil(o + r.options.slidesToShow), !0 === r.options.fade && (o > 0 && o--, n <= r.slideCount && n++)), i = r.$slider.find(".slick-slide").slice(o, n), "anticipated" === r.options.lazyLoad)
            for (var s = o - 1, a = n, l = r.$slider.find(".slick-slide"), c = 0; c < r.options.slidesToScroll; c++) s < 0 && (s = r.slideCount - 1), i = (i = i.add(l.eq(s))).add(l.eq(a)), s--, a++;
        e(i), r.slideCount <= r.options.slidesToShow ? e(r.$slider.find(".slick-slide")) : r.currentSlide >= r.slideCount - r.options.slidesToShow ? e(r.$slider.find(".slick-cloned").slice(0, r.options.slidesToShow)) : 0 === r.currentSlide && e(r.$slider.find(".slick-cloned").slice(-1 * r.options.slidesToShow))
    }, e.prototype.loadSlider = function () {
        var t = this;
        t.setPosition(), t.$slideTrack.css({
            opacity: 1
        }), t.$slider.removeClass("slick-loading"), t.initUI(), "progressive" === t.options.lazyLoad && t.progressiveLazyLoad()
    }, e.prototype.next = e.prototype.slickNext = function () {
        this.changeSlide({
            data: {
                message: "next"
            }
        })
    }, e.prototype.orientationChange = function () {
        var t = this;
        t.checkResponsive(), t.setPosition()
    }, e.prototype.pause = e.prototype.slickPause = function () {
        var t = this;
        t.autoPlayClear(), t.paused = !0
    }, e.prototype.play = e.prototype.slickPlay = function () {
        var t = this;
        t.autoPlay(), t.options.autoplay = !0, t.paused = !1, t.focussed = !1, t.interrupted = !1
    }, e.prototype.postSlide = function (e) {
        var i = this;
        i.unslicked || (i.$slider.trigger("afterChange", [i, e]), i.animating = !1, i.slideCount > i.options.slidesToShow && i.setPosition(), i.swipeLeft = null, i.options.autoplay && i.autoPlay(), !0 === i.options.accessibility && (i.initADA(), i.options.focusOnChange && t(i.$slides.get(i.currentSlide)).attr("tabindex", 0).focus()))
    }, e.prototype.prev = e.prototype.slickPrev = function () {
        this.changeSlide({
            data: {
                message: "previous"
            }
        })
    }, e.prototype.preventDefault = function (t) {
        t.preventDefault()
    }, e.prototype.progressiveLazyLoad = function (e) {
        e = e || 1;
        var i, o, n, r, s, a = this,
            l = t("img[data-lazy]", a.$slider);
        l.length ? (i = l.first(), o = i.attr("data-lazy"), n = i.attr("data-srcset"), r = i.attr("data-sizes") || a.$slider.attr("data-sizes"), (s = document.createElement("img")).onload = function () {
            n && (i.attr("srcset", n), r && i.attr("sizes", r)), i.attr("src", o).removeAttr("data-lazy data-srcset data-sizes").removeClass("slick-loading"), !0 === a.options.adaptiveHeight && a.setPosition(), a.$slider.trigger("lazyLoaded", [a, i, o]), a.progressiveLazyLoad()
        }, s.onerror = function () {
            e < 3 ? setTimeout(function () {
                a.progressiveLazyLoad(e + 1)
            }, 500) : (i.removeAttr("data-lazy").removeClass("slick-loading").addClass("slick-lazyload-error"), a.$slider.trigger("lazyLoadError", [a, i, o]), a.progressiveLazyLoad())
        }, s.src = o) : a.$slider.trigger("allImagesLoaded", [a])
    }, e.prototype.refresh = function (e) {
        var i, o, n = this;
        o = n.slideCount - n.options.slidesToShow, !n.options.infinite && n.currentSlide > o && (n.currentSlide = o), n.slideCount <= n.options.slidesToShow && (n.currentSlide = 0), i = n.currentSlide, n.destroy(!0), t.extend(n, n.initials, {
            currentSlide: i
        }), n.init(), e || n.changeSlide({
            data: {
                message: "index",
                index: i
            }
        }, !1)
    }, e.prototype.registerBreakpoints = function () {
        var e, i, o, n = this,
            r = n.options.responsive || null;
        if ("array" === t.type(r) && r.length) {
            n.respondTo = n.options.respondTo || "window";
            for (e in r)
                if (o = n.breakpoints.length - 1, r.hasOwnProperty(e)) {
                    for (i = r[e].breakpoint; o >= 0;) n.breakpoints[o] && n.breakpoints[o] === i && n.breakpoints.splice(o, 1), o--;
                    n.breakpoints.push(i), n.breakpointSettings[i] = r[e].settings
                } n.breakpoints.sort(function (t, e) {
                return n.options.mobileFirst ? t - e : e - t
            })
        }
    }, e.prototype.reinit = function () {
        var e = this;
        e.$slides = e.$slideTrack.children(e.options.slide).addClass("slick-slide"), e.slideCount = e.$slides.length, e.currentSlide >= e.slideCount && 0 !== e.currentSlide && (e.currentSlide = e.currentSlide - e.options.slidesToScroll), e.slideCount <= e.options.slidesToShow && (e.currentSlide = 0), e.registerBreakpoints(), e.setProps(), e.setupInfinite(), e.buildArrows(), e.updateArrows(), e.initArrowEvents(), e.buildDots(), e.updateDots(), e.initDotEvents(), e.cleanUpSlideEvents(), e.initSlideEvents(), e.checkResponsive(!1, !0), !0 === e.options.focusOnSelect && t(e.$slideTrack).children().on("click.slick", e.selectHandler), e.setSlideClasses("number" == typeof e.currentSlide ? e.currentSlide : 0), e.setPosition(), e.focusHandler(), e.paused = !e.options.autoplay, e.autoPlay(), e.$slider.trigger("reInit", [e])
    }, e.prototype.resize = function () {
        var e = this;
        t(window).width() !== e.windowWidth && (clearTimeout(e.windowDelay), e.windowDelay = window.setTimeout(function () {
            e.windowWidth = t(window).width(), e.checkResponsive(), e.unslicked || e.setPosition()
        }, 50))
    }, e.prototype.removeSlide = e.prototype.slickRemove = function (t, e, i) {
        var o = this;
        if (t = "boolean" == typeof t ? !0 === (e = t) ? 0 : o.slideCount - 1 : !0 === e ? --t : t, o.slideCount < 1 || t < 0 || t > o.slideCount - 1) return !1;
        o.unload(), !0 === i ? o.$slideTrack.children().remove() : o.$slideTrack.children(this.options.slide).eq(t).remove(), o.$slides = o.$slideTrack.children(this.options.slide), o.$slideTrack.children(this.options.slide).detach(), o.$slideTrack.append(o.$slides), o.$slidesCache = o.$slides, o.reinit()
    }, e.prototype.setCSS = function (t) {
        var e, i, o = this,
            n = {};
        !0 === o.options.rtl && (t = -t), e = "left" == o.positionProp ? Math.ceil(t) + "px" : "0px", i = "top" == o.positionProp ? Math.ceil(t) + "px" : "0px", n[o.positionProp] = t, !1 === o.transformsEnabled ? o.$slideTrack.css(n) : (n = {}, !1 === o.cssTransitions ? (n[o.animType] = "translate(" + e + ", " + i + ")", o.$slideTrack.css(n)) : (n[o.animType] = "translate3d(" + e + ", " + i + ", 0px)", o.$slideTrack.css(n)))
    }, e.prototype.setDimensions = function () {
        var t = this;
        !1 === t.options.vertical ? !0 === t.options.centerMode && t.$list.css({
            padding: "0px " + t.options.centerPadding
        }) : (t.$list.height(t.$slides.first().outerHeight(!0) * t.options.slidesToShow), !0 === t.options.centerMode && t.$list.css({
            padding: t.options.centerPadding + " 0px"
        })), t.listWidth = t.$list.width(), t.listHeight = t.$list.height(), !1 === t.options.vertical && !1 === t.options.variableWidth ? (t.slideWidth = Math.ceil(t.listWidth / t.options.slidesToShow), t.$slideTrack.width(Math.ceil(t.slideWidth * t.$slideTrack.children(".slick-slide").length))) : !0 === t.options.variableWidth ? t.$slideTrack.width(5e3 * t.slideCount) : (t.slideWidth = Math.ceil(t.listWidth), t.$slideTrack.height(Math.ceil(t.$slides.first().outerHeight(!0) * t.$slideTrack.children(".slick-slide").length)));
        var e = t.$slides.first().outerWidth(!0) - t.$slides.first().width();
        !1 === t.options.variableWidth && t.$slideTrack.children(".slick-slide").width(t.slideWidth - e)
    }, e.prototype.setFade = function () {
        var e, i = this;
        i.$slides.each(function (o, n) {
            e = i.slideWidth * o * -1, !0 === i.options.rtl ? t(n).css({
                position: "relative",
                right: e,
                top: 0,
                zIndex: i.options.zIndex - 2,
                opacity: 0
            }) : t(n).css({
                position: "relative",
                left: e,
                top: 0,
                zIndex: i.options.zIndex - 2,
                opacity: 0
            })
        }), i.$slides.eq(i.currentSlide).css({
            zIndex: i.options.zIndex - 1,
            opacity: 1
        })
    }, e.prototype.setHeight = function () {
        var t = this;
        if (1 === t.options.slidesToShow && !0 === t.options.adaptiveHeight && !1 === t.options.vertical) {
            var e = t.$slides.eq(t.currentSlide).outerHeight(!0);
            t.$list.css("height", e)
        }
    }, e.prototype.setOption = e.prototype.slickSetOption = function () {
        var e, i, o, n, r, s = this,
            a = !1;
        if ("object" === t.type(arguments[0]) ? (o = arguments[0], a = arguments[1], r = "multiple") : "string" === t.type(arguments[0]) && (o = arguments[0], n = arguments[1], a = arguments[2], "responsive" === arguments[0] && "array" === t.type(arguments[1]) ? r = "responsive" : void 0 !== arguments[1] && (r = "single")), "single" === r) s.options[o] = n;
        else if ("multiple" === r) t.each(o, function (t, e) {
            s.options[t] = e
        });
        else if ("responsive" === r)
            for (i in n)
                if ("array" !== t.type(s.options.responsive)) s.options.responsive = [n[i]];
                else {
                    for (e = s.options.responsive.length - 1; e >= 0;) s.options.responsive[e].breakpoint === n[i].breakpoint && s.options.responsive.splice(e, 1), e--;
                    s.options.responsive.push(n[i])
                } a && (s.unload(), s.reinit())
    }, e.prototype.setPosition = function () {
        var t = this;
        t.setDimensions(), t.setHeight(), !1 === t.options.fade ? t.setCSS(t.getLeft(t.currentSlide)) : t.setFade(), t.$slider.trigger("setPosition", [t])
    }, e.prototype.setProps = function () {
        var t = this,
            e = document.body.style;
        t.positionProp = !0 === t.options.vertical ? "top" : "left", "top" === t.positionProp ? t.$slider.addClass("slick-vertical") : t.$slider.removeClass("slick-vertical"), void 0 === e.WebkitTransition && void 0 === e.MozTransition && void 0 === e.msTransition || !0 === t.options.useCSS && (t.cssTransitions = !0), t.options.fade && ("number" == typeof t.options.zIndex ? t.options.zIndex < 3 && (t.options.zIndex = 3) : t.options.zIndex = t.defaults.zIndex), void 0 !== e.OTransform && (t.animType = "OTransform", t.transformType = "-o-transform", t.transitionType = "OTransition", void 0 === e.perspectiveProperty && void 0 === e.webkitPerspective && (t.animType = !1)), void 0 !== e.MozTransform && (t.animType = "MozTransform", t.transformType = "-moz-transform", t.transitionType = "MozTransition", void 0 === e.perspectiveProperty && void 0 === e.MozPerspective && (t.animType = !1)), void 0 !== e.webkitTransform && (t.animType = "webkitTransform", t.transformType = "-webkit-transform", t.transitionType = "webkitTransition", void 0 === e.perspectiveProperty && void 0 === e.webkitPerspective && (t.animType = !1)), void 0 !== e.msTransform && (t.animType = "msTransform", t.transformType = "-ms-transform", t.transitionType = "msTransition", void 0 === e.msTransform && (t.animType = !1)), void 0 !== e.transform && !1 !== t.animType && (t.animType = "transform", t.transformType = "transform", t.transitionType = "transition"), t.transformsEnabled = t.options.useTransform && null !== t.animType && !1 !== t.animType
    }, e.prototype.setSlideClasses = function (t) {
        var e, i, o, n, r = this;
        if (i = r.$slider.find(".slick-slide").removeClass("slick-active slick-center slick-current").attr("aria-hidden", "true"), r.$slides.eq(t).addClass("slick-current"), !0 === r.options.centerMode) {
            var s = r.options.slidesToShow % 2 == 0 ? 1 : 0;
            e = Math.floor(r.options.slidesToShow / 2), !0 === r.options.infinite && (t >= e && t <= r.slideCount - 1 - e ? r.$slides.slice(t - e + s, t + e + 1).addClass("slick-active").attr("aria-hidden", "false") : (o = r.options.slidesToShow + t, i.slice(o - e + 1 + s, o + e + 2).addClass("slick-active").attr("aria-hidden", "false")), 0 === t ? i.eq(i.length - 1 - r.options.slidesToShow).addClass("slick-center") : t === r.slideCount - 1 && i.eq(r.options.slidesToShow).addClass("slick-center")), r.$slides.eq(t).addClass("slick-center")
        } else t >= 0 && t <= r.slideCount - r.options.slidesToShow ? r.$slides.slice(t, t + r.options.slidesToShow).addClass("slick-active").attr("aria-hidden", "false") : i.length <= r.options.slidesToShow ? i.addClass("slick-active").attr("aria-hidden", "false") : (n = r.slideCount % r.options.slidesToShow, o = !0 === r.options.infinite ? r.options.slidesToShow + t : t, r.options.slidesToShow == r.options.slidesToScroll && r.slideCount - t < r.options.slidesToShow ? i.slice(o - (r.options.slidesToShow - n), o + n).addClass("slick-active").attr("aria-hidden", "false") : i.slice(o, o + r.options.slidesToShow).addClass("slick-active").attr("aria-hidden", "false"));
        "ondemand" !== r.options.lazyLoad && "anticipated" !== r.options.lazyLoad || r.lazyLoad()
    }, e.prototype.setupInfinite = function () {
        var e, i, o, n = this;
        if (!0 === n.options.fade && (n.options.centerMode = !1), !0 === n.options.infinite && !1 === n.options.fade && (i = null, n.slideCount > n.options.slidesToShow)) {
            for (o = !0 === n.options.centerMode ? n.options.slidesToShow + 1 : n.options.slidesToShow, e = n.slideCount; e > n.slideCount - o; e -= 1) i = e - 1, t(n.$slides[i]).clone(!0).attr("id", "").attr("data-slick-index", i - n.slideCount).prependTo(n.$slideTrack).addClass("slick-cloned");
            for (e = 0; e < o + n.slideCount; e += 1) i = e, t(n.$slides[i]).clone(!0).attr("id", "").attr("data-slick-index", i + n.slideCount).appendTo(n.$slideTrack).addClass("slick-cloned");
            n.$slideTrack.find(".slick-cloned").find("[id]").each(function () {
                t(this).attr("id", "")
            })
        }
    }, e.prototype.interrupt = function (t) {
        var e = this;
        t || e.autoPlay(), e.interrupted = t
    }, e.prototype.selectHandler = function (e) {
        var i = this,
            o = t(e.target).is(".slick-slide") ? t(e.target) : t(e.target).parents(".slick-slide"),
            n = parseInt(o.attr("data-slick-index"));
        n || (n = 0), i.slideCount <= i.options.slidesToShow ? i.slideHandler(n, !1, !0) : i.slideHandler(n)
    }, e.prototype.slideHandler = function (t, e, i) {
        var o, n, r, s, a, l = null,
            c = this;
        if (e = e || !1, !(!0 === c.animating && !0 === c.options.waitForAnimate || !0 === c.options.fade && c.currentSlide === t))
            if (!1 === e && c.asNavFor(t), o = t, l = c.getLeft(o), s = c.getLeft(c.currentSlide), c.currentLeft = null === c.swipeLeft ? s : c.swipeLeft, !1 === c.options.infinite && !1 === c.options.centerMode && (t < 0 || t > c.getDotCount() * c.options.slidesToScroll)) !1 === c.options.fade && (o = c.currentSlide, !0 !== i ? c.animateSlide(s, function () {
                c.postSlide(o)
            }) : c.postSlide(o));
            else if (!1 === c.options.infinite && !0 === c.options.centerMode && (t < 0 || t > c.slideCount - c.options.slidesToScroll)) !1 === c.options.fade && (o = c.currentSlide, !0 !== i ? c.animateSlide(s, function () {
            c.postSlide(o)
        }) : c.postSlide(o));
        else {
            if (c.options.autoplay && clearInterval(c.autoPlayTimer), n = o < 0 ? c.slideCount % c.options.slidesToScroll != 0 ? c.slideCount - c.slideCount % c.options.slidesToScroll : c.slideCount + o : o >= c.slideCount ? c.slideCount % c.options.slidesToScroll != 0 ? 0 : o - c.slideCount : o, c.animating = !0, c.$slider.trigger("beforeChange", [c, c.currentSlide, n]), r = c.currentSlide, c.currentSlide = n, c.setSlideClasses(c.currentSlide), c.options.asNavFor && (a = (a = c.getNavTarget()).slick("getSlick")).slideCount <= a.options.slidesToShow && a.setSlideClasses(c.currentSlide), c.updateDots(), c.updateArrows(), !0 === c.options.fade) return !0 !== i ? (c.fadeSlideOut(r), c.fadeSlide(n, function () {
                c.postSlide(n)
            })) : c.postSlide(n), void c.animateHeight();
            !0 !== i ? c.animateSlide(l, function () {
                c.postSlide(n)
            }) : c.postSlide(n)
        }
    }, e.prototype.startLoad = function () {
        var t = this;
        !0 === t.options.arrows && t.slideCount > t.options.slidesToShow && (t.$prevArrow.hide(), t.$nextArrow.hide()), !0 === t.options.dots && t.slideCount > t.options.slidesToShow && t.$dots.hide(), t.$slider.addClass("slick-loading")
    }, e.prototype.swipeDirection = function () {
        var t, e, i, o, n = this;
        return t = n.touchObject.startX - n.touchObject.curX, e = n.touchObject.startY - n.touchObject.curY, i = Math.atan2(e, t), (o = Math.round(180 * i / Math.PI)) < 0 && (o = 360 - Math.abs(o)), o <= 45 && o >= 0 ? !1 === n.options.rtl ? "left" : "right" : o <= 360 && o >= 315 ? !1 === n.options.rtl ? "left" : "right" : o >= 135 && o <= 225 ? !1 === n.options.rtl ? "right" : "left" : !0 === n.options.verticalSwiping ? o >= 35 && o <= 135 ? "down" : "up" : "vertical"
    }, e.prototype.swipeEnd = function (t) {
        var e, i, o = this;
        if (o.dragging = !1, o.swiping = !1, o.scrolling) return o.scrolling = !1, !1;
        if (o.interrupted = !1, o.shouldClick = !(o.touchObject.swipeLength > 10), void 0 === o.touchObject.curX) return !1;
        if (!0 === o.touchObject.edgeHit && o.$slider.trigger("edge", [o, o.swipeDirection()]), o.touchObject.swipeLength >= o.touchObject.minSwipe) {
            switch (i = o.swipeDirection()) {
                case "left":
                case "down":
                    e = o.options.swipeToSlide ? o.checkNavigable(o.currentSlide + o.getSlideCount()) : o.currentSlide + o.getSlideCount(), o.currentDirection = 0;
                    break;
                case "right":
                case "up":
                    e = o.options.swipeToSlide ? o.checkNavigable(o.currentSlide - o.getSlideCount()) : o.currentSlide - o.getSlideCount(), o.currentDirection = 1
            }
            "vertical" != i && (o.slideHandler(e), o.touchObject = {}, o.$slider.trigger("swipe", [o, i]))
        } else o.touchObject.startX !== o.touchObject.curX && (o.slideHandler(o.currentSlide), o.touchObject = {})
    }, e.prototype.swipeHandler = function (t) {
        var e = this;
        if (!(!1 === e.options.swipe || "ontouchend" in document && !1 === e.options.swipe || !1 === e.options.draggable && -1 !== t.type.indexOf("mouse"))) switch (e.touchObject.fingerCount = t.originalEvent && void 0 !== t.originalEvent.touches ? t.originalEvent.touches.length : 1, e.touchObject.minSwipe = e.listWidth / e.options.touchThreshold, !0 === e.options.verticalSwiping && (e.touchObject.minSwipe = e.listHeight / e.options.touchThreshold), t.data.action) {
            case "start":
                e.swipeStart(t);
                break;
            case "move":
                e.swipeMove(t);
                break;
            case "end":
                e.swipeEnd(t)
        }
    }, e.prototype.swipeMove = function (t) {
        var e, i, o, n, r, s, a = this;
        return r = void 0 !== t.originalEvent ? t.originalEvent.touches : null, !(!a.dragging || a.scrolling || r && 1 !== r.length) && (e = a.getLeft(a.currentSlide), a.touchObject.curX = void 0 !== r ? r[0].pageX : t.clientX, a.touchObject.curY = void 0 !== r ? r[0].pageY : t.clientY, a.touchObject.swipeLength = Math.round(Math.sqrt(Math.pow(a.touchObject.curX - a.touchObject.startX, 2))), s = Math.round(Math.sqrt(Math.pow(a.touchObject.curY - a.touchObject.startY, 2))), !a.options.verticalSwiping && !a.swiping && s > 4 ? (a.scrolling = !0, !1) : (!0 === a.options.verticalSwiping && (a.touchObject.swipeLength = s), i = a.swipeDirection(), void 0 !== t.originalEvent && a.touchObject.swipeLength > 4 && (a.swiping = !0, t.preventDefault()), n = (!1 === a.options.rtl ? 1 : -1) * (a.touchObject.curX > a.touchObject.startX ? 1 : -1), !0 === a.options.verticalSwiping && (n = a.touchObject.curY > a.touchObject.startY ? 1 : -1), o = a.touchObject.swipeLength, a.touchObject.edgeHit = !1, !1 === a.options.infinite && (0 === a.currentSlide && "right" === i || a.currentSlide >= a.getDotCount() && "left" === i) && (o = a.touchObject.swipeLength * a.options.edgeFriction, a.touchObject.edgeHit = !0), !1 === a.options.vertical ? a.swipeLeft = e + o * n : a.swipeLeft = e + o * (a.$list.height() / a.listWidth) * n, !0 === a.options.verticalSwiping && (a.swipeLeft = e + o * n), !0 !== a.options.fade && !1 !== a.options.touchMove && (!0 === a.animating ? (a.swipeLeft = null, !1) : void a.setCSS(a.swipeLeft))))
    }, e.prototype.swipeStart = function (t) {
        var e, i = this;
        if (i.interrupted = !0, 1 !== i.touchObject.fingerCount || i.slideCount <= i.options.slidesToShow) return i.touchObject = {}, !1;
        void 0 !== t.originalEvent && void 0 !== t.originalEvent.touches && (e = t.originalEvent.touches[0]), i.touchObject.startX = i.touchObject.curX = void 0 !== e ? e.pageX : t.clientX, i.touchObject.startY = i.touchObject.curY = void 0 !== e ? e.pageY : t.clientY, i.dragging = !0
    }, e.prototype.unfilterSlides = e.prototype.slickUnfilter = function () {
        var t = this;
        null !== t.$slidesCache && (t.unload(), t.$slideTrack.children(this.options.slide).detach(), t.$slidesCache.appendTo(t.$slideTrack), t.reinit())
    }, e.prototype.unload = function () {
        var e = this;
        t(".slick-cloned", e.$slider).remove(), e.$dots && e.$dots.remove(), e.$prevArrow && e.htmlExpr.test(e.options.prevArrow) && e.$prevArrow.remove(), e.$nextArrow && e.htmlExpr.test(e.options.nextArrow) && e.$nextArrow.remove(), e.$slides.removeClass("slick-slide slick-active slick-visible slick-current").attr("aria-hidden", "true").css("width", "")
    }, e.prototype.unslick = function (t) {
        var e = this;
        e.$slider.trigger("unslick", [e, t]), e.destroy()
    }, e.prototype.updateArrows = function () {
        var t = this;
        Math.floor(t.options.slidesToShow / 2), !0 === t.options.arrows && t.slideCount > t.options.slidesToShow && !t.options.infinite && (t.$prevArrow.removeClass("slick-disabled").attr("aria-disabled", "false"), t.$nextArrow.removeClass("slick-disabled").attr("aria-disabled", "false"), 0 === t.currentSlide ? (t.$prevArrow.addClass("slick-disabled").attr("aria-disabled", "true"), t.$nextArrow.removeClass("slick-disabled").attr("aria-disabled", "false")) : t.currentSlide >= t.slideCount - t.options.slidesToShow && !1 === t.options.centerMode ? (t.$nextArrow.addClass("slick-disabled").attr("aria-disabled", "true"), t.$prevArrow.removeClass("slick-disabled").attr("aria-disabled", "false")) : t.currentSlide >= t.slideCount - 1 && !0 === t.options.centerMode && (t.$nextArrow.addClass("slick-disabled").attr("aria-disabled", "true"), t.$prevArrow.removeClass("slick-disabled").attr("aria-disabled", "false")))
    }, e.prototype.updateDots = function () {
        var t = this;
        null !== t.$dots && (t.$dots.find("li").removeClass("slick-active").end(), t.$dots.find("li").eq(Math.floor(t.currentSlide / t.options.slidesToScroll)).addClass("slick-active"))
    }, e.prototype.visibility = function () {
        var t = this;
        t.options.autoplay && (document[t.hidden] ? t.interrupted = !0 : t.interrupted = !1)
    }, t.fn.slick = function () {
        var t, i, o = this,
            n = arguments[0],
            r = Array.prototype.slice.call(arguments, 1),
            s = o.length;
        for (t = 0; t < s; t++)
            if ("object" == typeof n || void 0 === n ? o[t].slick = new e(o[t], n) : i = o[t].slick[n].apply(o[t].slick, r), void 0 !== i) return i;
        return o
    }
}),
function (t) {
    "function" == typeof define && define.amd ? define(["jquery"], t) : "undefined" != typeof module && module.exports ? module.exports = t : t(jQuery, window, document)
}(function (t) {
    ! function (e) {
        var i = "function" == typeof define && define.amd,
            o = "undefined" != typeof module && module.exports,
            n = "https:" == document.location.protocol ? "https:" : "http:";
        i || (o ? require("jquery-mousewheel")(t) : t.event.special.mousewheel || t("head").append(decodeURI("%3Cscript src=" + n + "//cdnjs.cloudflare.com/ajax/libs/jquery-mousewheel/3.1.13/jquery.mousewheel.min.js%3E%3C/script%3E"))),
            function () {
                var e, i = "mCustomScrollbar",
                    o = {
                        setTop: 0,
                        setLeft: 0,
                        axis: "y",
                        scrollbarPosition: "inside",
                        scrollInertia: 950,
                        autoDraggerLength: !0,
                        alwaysShowScrollbar: 0,
                        snapOffset: 0,
                        mouseWheel: {
                            enable: !0,
                            scrollAmount: "auto",
                            axis: "y",
                            deltaFactor: "auto",
                            disableOver: ["select", "option", "keygen", "datalist", "textarea"]
                        },
                        scrollButtons: {
                            scrollType: "stepless",
                            scrollAmount: "auto"
                        },
                        keyboard: {
                            enable: !0,
                            scrollType: "stepless",
                            scrollAmount: "auto"
                        },
                        contentTouchScroll: 25,
                        documentTouchScroll: !0,
                        advanced: {
                            autoScrollOnFocus: "input,textarea,select,button,datalist,keygen,a[tabindex],area,object,[contenteditable='true']",
                            updateOnContentResize: !0,
                            updateOnImageLoad: "auto",
                            autoUpdateTimeout: 60
                        },
                        theme: "light",
                        callbacks: {
                            onTotalScrollOffset: 0,
                            onTotalScrollBackOffset: 0,
                            alwaysTriggerOffsets: !0
                        }
                    },
                    n = 0,
                    r = {},
                    s = window.attachEvent && !window.addEventListener ? 1 : 0,
                    a = !1,
                    l = ["mCSB_dragger_onDrag", "mCSB_scrollTools_onDrag", "mCS_img_loaded", "mCS_disabled", "mCS_destroyed", "mCS_no_scrollbar", "mCS-autoHide", "mCS-dir-rtl", "mCS_no_scrollbar_y", "mCS_no_scrollbar_x", "mCS_y_hidden", "mCS_x_hidden", "mCSB_draggerContainer", "mCSB_buttonUp", "mCSB_buttonDown", "mCSB_buttonLeft", "mCSB_buttonRight"],
                    c = {
                        init: function (e) {
                            var e = t.extend(!0, {}, o, e),
                                i = d.call(this);
                            if (e.live) {
                                var s = e.liveSelector || this.selector || ".mCustomScrollbar",
                                    a = t(s);
                                if ("off" === e.live) return void p(s);
                                r[s] = setTimeout(function () {
                                    a.mCustomScrollbar(e), "once" === e.live && a.length && p(s)
                                }, 500)
                            } else p(s);
                            return e.setWidth = e.set_width ? e.set_width : e.setWidth, e.setHeight = e.set_height ? e.set_height : e.setHeight, e.axis = e.horizontalScroll ? "x" : h(e.axis), e.scrollInertia = e.scrollInertia > 0 && e.scrollInertia < 17 ? 17 : e.scrollInertia, "object" != typeof e.mouseWheel && 1 == e.mouseWheel && (e.mouseWheel = {
                                enable: !0,
                                scrollAmount: "auto",
                                axis: "y",
                                preventDefault: !1,
                                deltaFactor: "auto",
                                normalizeDelta: !1,
                                invert: !1
                            }), e.mouseWheel.scrollAmount = e.mouseWheelPixels ? e.mouseWheelPixels : e.mouseWheel.scrollAmount, e.mouseWheel.normalizeDelta = e.advanced.normalizeMouseWheelDelta ? e.advanced.normalizeMouseWheelDelta : e.mouseWheel.normalizeDelta, e.scrollButtons.scrollType = f(e.scrollButtons.scrollType), u(e), t(i).each(function () {
                                var i = t(this);
                                if (!i.data("mCS")) {
                                    i.data("mCS", {
                                        idx: ++n,
                                        opt: e,
                                        scrollRatio: {
                                            y: null,
                                            x: null
                                        },
                                        overflowed: null,
                                        contentReset: {
                                            y: null,
                                            x: null
                                        },
                                        bindEvents: !1,
                                        tweenRunning: !1,
                                        sequential: {},
                                        langDir: i.css("direction"),
                                        cbOffsets: null,
                                        trigger: null,
                                        poll: {
                                            size: {
                                                o: 0,
                                                n: 0
                                            },
                                            img: {
                                                o: 0,
                                                n: 0
                                            },
                                            change: {
                                                o: 0,
                                                n: 0
                                            }
                                        }
                                    });
                                    var o = i.data("mCS"),
                                        r = o.opt,
                                        s = i.data("mcs-axis"),
                                        a = i.data("mcs-scrollbar-position"),
                                        d = i.data("mcs-theme");
                                    s && (r.axis = s), a && (r.scrollbarPosition = a), d && (r.theme = d, u(r)), m.call(this), o && r.callbacks.onCreate && "function" == typeof r.callbacks.onCreate && r.callbacks.onCreate.call(this), t("#mCSB_" + o.idx + "_container img:not(." + l[2] + ")").addClass(l[2]), c.update.call(null, i)
                                }
                            })
                        },
                        update: function (e, i) {
                            var o = e || d.call(this);
                            return t(o).each(function () {
                                var e = t(this);
                                if (e.data("mCS")) {
                                    var o = e.data("mCS"),
                                        n = o.opt,
                                        r = t("#mCSB_" + o.idx + "_container"),
                                        s = t("#mCSB_" + o.idx),
                                        a = [t("#mCSB_" + o.idx + "_dragger_vertical"), t("#mCSB_" + o.idx + "_dragger_horizontal")];
                                    if (!r.length) return;
                                    o.tweenRunning && Y(e), i && o && n.callbacks.onBeforeUpdate && "function" == typeof n.callbacks.onBeforeUpdate && n.callbacks.onBeforeUpdate.call(this), e.hasClass(l[3]) && e.removeClass(l[3]), e.hasClass(l[4]) && e.removeClass(l[4]), s.css("max-height", "none"), s.height() !== e.height() && s.css("max-height", e.height()), v.call(this), "y" === n.axis || n.advanced.autoExpandHorizontalScroll || r.css("width", g(r)), o.overflowed = x.call(this), T.call(this), n.autoDraggerLength && w.call(this), b.call(this), k.call(this);
                                    var c = [Math.abs(r[0].offsetTop), Math.abs(r[0].offsetLeft)];
                                    "x" !== n.axis && (o.overflowed[0] ? a[0].height() > a[0].parent().height() ? C.call(this) : (Q(e, c[0].toString(), {
                                        dir: "y",
                                        dur: 0,
                                        overwrite: "none"
                                    }), o.contentReset.y = null) : (C.call(this), "y" === n.axis ? _.call(this) : "yx" === n.axis && o.overflowed[1] && Q(e, c[1].toString(), {
                                        dir: "x",
                                        dur: 0,
                                        overwrite: "none"
                                    }))), "y" !== n.axis && (o.overflowed[1] ? a[1].width() > a[1].parent().width() ? C.call(this) : (Q(e, c[1].toString(), {
                                        dir: "x",
                                        dur: 0,
                                        overwrite: "none"
                                    }), o.contentReset.x = null) : (C.call(this), "x" === n.axis ? _.call(this) : "yx" === n.axis && o.overflowed[0] && Q(e, c[0].toString(), {
                                        dir: "y",
                                        dur: 0,
                                        overwrite: "none"
                                    }))), i && o && (2 === i && n.callbacks.onImageLoad && "function" == typeof n.callbacks.onImageLoad ? n.callbacks.onImageLoad.call(this) : 3 === i && n.callbacks.onSelectorChange && "function" == typeof n.callbacks.onSelectorChange ? n.callbacks.onSelectorChange.call(this) : n.callbacks.onUpdate && "function" == typeof n.callbacks.onUpdate && n.callbacks.onUpdate.call(this)), N.call(this)
                                }
                            })
                        },
                        scrollTo: function (e, i) {
                            if (void 0 !== e && null != e) {
                                var o = d.call(this);
                                return t(o).each(function () {
                                    var o = t(this);
                                    if (o.data("mCS")) {
                                        var n = o.data("mCS"),
                                            r = n.opt,
                                            s = {
                                                trigger: "external",
                                                scrollInertia: r.scrollInertia,
                                                scrollEasing: "mcsEaseInOut",
                                                moveDragger: !1,
                                                timeout: 60,
                                                callbacks: !0,
                                                onStart: !0,
                                                onUpdate: !0,
                                                onComplete: !0
                                            },
                                            a = t.extend(!0, {}, s, i),
                                            l = F.call(this, e),
                                            c = a.scrollInertia > 0 && a.scrollInertia < 17 ? 17 : a.scrollInertia;
                                        l[0] = R.call(this, l[0], "y"), l[1] = R.call(this, l[1], "x"), a.moveDragger && (l[0] *= n.scrollRatio.y, l[1] *= n.scrollRatio.x), a.dur = it() ? 0 : c, setTimeout(function () {
                                            null !== l[0] && void 0 !== l[0] && "x" !== r.axis && n.overflowed[0] && (a.dir = "y", a.overwrite = "all", Q(o, l[0].toString(), a)), null !== l[1] && void 0 !== l[1] && "y" !== r.axis && n.overflowed[1] && (a.dir = "x", a.overwrite = "none", Q(o, l[1].toString(), a))
                                        }, a.timeout)
                                    }
                                })
                            }
                        },
                        stop: function () {
                            var e = d.call(this);
                            return t(e).each(function () {
                                var e = t(this);
                                e.data("mCS") && Y(e)
                            })
                        },
                        disable: function (e) {
                            var i = d.call(this);
                            return t(i).each(function () {
                                var i = t(this);
                                if (i.data("mCS")) {
                                    i.data("mCS");
                                    N.call(this, "remove"), _.call(this), e && C.call(this), T.call(this, !0), i.addClass(l[3])
                                }
                            })
                        },
                        destroy: function () {
                            var e = d.call(this);
                            return t(e).each(function () {
                                var o = t(this);
                                if (o.data("mCS")) {
                                    var n = o.data("mCS"),
                                        r = n.opt,
                                        s = t("#mCSB_" + n.idx),
                                        a = t("#mCSB_" + n.idx + "_container"),
                                        c = t(".mCSB_" + n.idx + "_scrollbar");
                                    r.live && p(r.liveSelector || t(e).selector), N.call(this, "remove"), _.call(this), C.call(this), o.removeData("mCS"), Z(this, "mcs"), c.remove(), a.find("img." + l[2]).removeClass(l[2]), s.replaceWith(a.contents()), o.removeClass(i + " _mCS_" + n.idx + " " + l[6] + " " + l[7] + " " + l[5] + " " + l[3]).addClass(l[4])
                                }
                            })
                        }
                    },
                    d = function () {
                        return "object" != typeof t(this) || t(this).length < 1 ? ".mCustomScrollbar" : this
                    },
                    u = function (e) {
                        var i = ["rounded", "rounded-dark", "rounded-dots", "rounded-dots-dark"],
                            o = ["rounded-dots", "rounded-dots-dark", "3d", "3d-dark", "3d-thick", "3d-thick-dark", "inset", "inset-dark", "inset-2", "inset-2-dark", "inset-3", "inset-3-dark"],
                            n = ["minimal", "minimal-dark"],
                            r = ["minimal", "minimal-dark"],
                            s = ["minimal", "minimal-dark"];
                        e.autoDraggerLength = !(t.inArray(e.theme, i) > -1) && e.autoDraggerLength, e.autoExpandScrollbar = !(t.inArray(e.theme, o) > -1) && e.autoExpandScrollbar, e.scrollButtons.enable = !(t.inArray(e.theme, n) > -1) && e.scrollButtons.enable, e.autoHideScrollbar = t.inArray(e.theme, r) > -1 || e.autoHideScrollbar, e.scrollbarPosition = t.inArray(e.theme, s) > -1 ? "outside" : e.scrollbarPosition
                    },
                    p = function (t) {
                        r[t] && (clearTimeout(r[t]), Z(r, t))
                    },
                    h = function (t) {
                        return "yx" === t || "xy" === t || "auto" === t ? "yx" : "x" === t || "horizontal" === t ? "x" : "y"
                    },
                    f = function (t) {
                        return "stepped" === t || "pixels" === t || "step" === t || "click" === t ? "stepped" : "stepless"
                    },
                    m = function () {
                        var e = t(this),
                            o = e.data("mCS"),
                            n = o.opt,
                            r = n.autoExpandScrollbar ? " " + l[1] + "_expand" : "",
                            s = ["<div id='mCSB_" + o.idx + "_scrollbar_vertical' class='mCSB_scrollTools mCSB_" + o.idx + "_scrollbar mCS-" + n.theme + " mCSB_scrollTools_vertical" + r + "'><div class='" + l[12] + "'><div id='mCSB_" + o.idx + "_dragger_vertical' class='mCSB_dragger' style='position:absolute;'><div class='mCSB_dragger_bar' /></div><div class='mCSB_draggerRail' /></div></div>", "<div id='mCSB_" + o.idx + "_scrollbar_horizontal' class='mCSB_scrollTools mCSB_" + o.idx + "_scrollbar mCS-" + n.theme + " mCSB_scrollTools_horizontal" + r + "'><div class='" + l[12] + "'><div id='mCSB_" + o.idx + "_dragger_horizontal' class='mCSB_dragger' style='position:absolute;'><div class='mCSB_dragger_bar' /></div><div class='mCSB_draggerRail' /></div></div>"],
                            a = "yx" === n.axis ? "mCSB_vertical_horizontal" : "x" === n.axis ? "mCSB_horizontal" : "mCSB_vertical",
                            c = "yx" === n.axis ? s[0] + s[1] : "x" === n.axis ? s[1] : s[0],
                            d = "yx" === n.axis ? "<div id='mCSB_" + o.idx + "_container_wrapper' class='mCSB_container_wrapper' />" : "",
                            u = n.autoHideScrollbar ? " " + l[6] : "",
                            p = "x" !== n.axis && "rtl" === o.langDir ? " " + l[7] : "";
                        n.setWidth && e.css("width", n.setWidth), n.setHeight && e.css("height", n.setHeight), n.setLeft = "y" !== n.axis && "rtl" === o.langDir ? "989999px" : n.setLeft, e.addClass(i + " _mCS_" + o.idx + u + p).wrapInner("<div id='mCSB_" + o.idx + "' class='mCustomScrollBox mCS-" + n.theme + " " + a + "'><div id='mCSB_" + o.idx + "_container' class='mCSB_container' style='position:relative; top:" + n.setTop + "; left:" + n.setLeft + ";' dir='" + o.langDir + "' /></div>");
                        var h = t("#mCSB_" + o.idx),
                            f = t("#mCSB_" + o.idx + "_container");
                        "y" === n.axis || n.advanced.autoExpandHorizontalScroll || f.css("width", g(f)), "outside" === n.scrollbarPosition ? ("static" === e.css("position") && e.css("position", "relative"), e.css("overflow", "visible"), h.addClass("mCSB_outside").after(c)) : (h.addClass("mCSB_inside").append(c), f.wrap(d)), y.call(this);
                        var m = [t("#mCSB_" + o.idx + "_dragger_vertical"), t("#mCSB_" + o.idx + "_dragger_horizontal")];
                        m[0].css("min-height", m[0].height()), m[1].css("min-width", m[1].width())
                    },
                    g = function (e) {
                        var i = [e[0].scrollWidth, Math.max.apply(Math, e.children().map(function () {
                                return t(this).outerWidth(!0)
                            }).get())],
                            o = e.parent().width();
                        return i[0] > o ? i[0] : i[1] > o ? i[1] : "100%"
                    },
                    v = function () {
                        var e = t(this),
                            i = e.data("mCS"),
                            o = i.opt,
                            n = t("#mCSB_" + i.idx + "_container");
                        if (o.advanced.autoExpandHorizontalScroll && "y" !== o.axis) {
                            n.css({
                                width: "auto",
                                "min-width": 0,
                                "overflow-x": "scroll"
                            });
                            var r = Math.ceil(n[0].scrollWidth);
                            3 === o.advanced.autoExpandHorizontalScroll || 2 !== o.advanced.autoExpandHorizontalScroll && r > n.parent().width() ? n.css({
                                width: r,
                                "min-width": "100%",
                                "overflow-x": "inherit"
                            }) : n.css({
                                "overflow-x": "inherit",
                                position: "absolute"
                            }).wrap("<div class='mCSB_h_wrapper' style='position:relative; left:0; width:999999px;' />").css({
                                width: Math.ceil(n[0].getBoundingClientRect().right + .4) - Math.floor(n[0].getBoundingClientRect().left),
                                "min-width": "100%",
                                position: "relative"
                            }).unwrap()
                        }
                    },
                    y = function () {
                        var e = t(this),
                            i = e.data("mCS"),
                            o = i.opt,
                            n = t(".mCSB_" + i.idx + "_scrollbar:first"),
                            r = tt(o.scrollButtons.tabindex) ? "tabindex='" + o.scrollButtons.tabindex + "'" : "",
                            s = ["<a href='#' class='" + l[13] + "' " + r + " />", "<a href='#' class='" + l[14] + "' " + r + " />", "<a href='#' class='" + l[15] + "' " + r + " />", "<a href='#' class='" + l[16] + "' " + r + " />"],
                            a = ["x" === o.axis ? s[2] : s[0], "x" === o.axis ? s[3] : s[1], s[2], s[3]];
                        o.scrollButtons.enable && n.prepend(a[0]).append(a[1]).next(".mCSB_scrollTools").prepend(a[2]).append(a[3])
                    },
                    w = function () {
                        var e = t(this),
                            i = e.data("mCS"),
                            o = t("#mCSB_" + i.idx),
                            n = t("#mCSB_" + i.idx + "_container"),
                            r = [t("#mCSB_" + i.idx + "_dragger_vertical"), t("#mCSB_" + i.idx + "_dragger_horizontal")],
                            a = [o.height() / n.outerHeight(!1), o.width() / n.outerWidth(!1)],
                            l = [parseInt(r[0].css("min-height")), Math.round(a[0] * r[0].parent().height()), parseInt(r[1].css("min-width")), Math.round(a[1] * r[1].parent().width())],
                            c = s && l[1] < l[0] ? l[0] : l[1],
                            d = s && l[3] < l[2] ? l[2] : l[3];
                        r[0].css({
                            height: c,
                            "max-height": r[0].parent().height() - 10
                        }).find(".mCSB_dragger_bar").css({
                            "line-height": l[0] + "px"
                        }), r[1].css({
                            width: d,
                            "max-width": r[1].parent().width() - 10
                        })
                    },
                    b = function () {
                        var e = t(this),
                            i = e.data("mCS"),
                            o = t("#mCSB_" + i.idx),
                            n = t("#mCSB_" + i.idx + "_container"),
                            r = [t("#mCSB_" + i.idx + "_dragger_vertical"), t("#mCSB_" + i.idx + "_dragger_horizontal")],
                            s = [n.outerHeight(!1) - o.height(), n.outerWidth(!1) - o.width()],
                            a = [s[0] / (r[0].parent().height() - r[0].height()), s[1] / (r[1].parent().width() - r[1].width())];
                        i.scrollRatio = {
                            y: a[0],
                            x: a[1]
                        }
                    },
                    S = function (t, e, i) {
                        var o = i ? l[0] + "_expanded" : "",
                            n = t.closest(".mCSB_scrollTools");
                        "active" === e ? (t.toggleClass(l[0] + " " + o), n.toggleClass(l[1]), t[0]._draggable = t[0]._draggable ? 0 : 1) : t[0]._draggable || ("hide" === e ? (t.removeClass(l[0]), n.removeClass(l[1])) : (t.addClass(l[0]), n.addClass(l[1])))
                    },
                    x = function () {
                        var e = t(this),
                            i = e.data("mCS"),
                            o = t("#mCSB_" + i.idx),
                            n = t("#mCSB_" + i.idx + "_container"),
                            r = null == i.overflowed ? n.height() : n.outerHeight(!1),
                            s = null == i.overflowed ? n.width() : n.outerWidth(!1),
                            a = n[0].scrollHeight,
                            l = n[0].scrollWidth;
                        return a > r && (r = a), l > s && (s = l), [r > o.height(), s > o.width()]
                    },
                    C = function () {
                        var e = t(this),
                            i = e.data("mCS"),
                            o = i.opt,
                            n = t("#mCSB_" + i.idx),
                            r = t("#mCSB_" + i.idx + "_container"),
                            s = [t("#mCSB_" + i.idx + "_dragger_vertical"), t("#mCSB_" + i.idx + "_dragger_horizontal")];
                        if (Y(e), ("x" !== o.axis && !i.overflowed[0] || "y" === o.axis && i.overflowed[0]) && (s[0].add(r).css("top", 0), Q(e, "_resetY")), "y" !== o.axis && !i.overflowed[1] || "x" === o.axis && i.overflowed[1]) {
                            var a = dx = 0;
                            "rtl" === i.langDir && (a = n.width() - r.outerWidth(!1), dx = Math.abs(a / i.scrollRatio.x)), r.css("left", a), s[1].css("left", dx), Q(e, "_resetX")
                        }
                    },
                    k = function () {
                        function e() {
                            r = setTimeout(function () {
                                t.event.special.mousewheel ? (clearTimeout(r), $.call(i[0])) : e()
                            }, 100)
                        }
                        var i = t(this),
                            o = i.data("mCS"),
                            n = o.opt;
                        if (!o.bindEvents) {
                            if (O.call(this), n.contentTouchScroll && I.call(this), z.call(this), n.mouseWheel.enable) {
                                var r;
                                e()
                            }
                            B.call(this), W.call(this), n.advanced.autoScrollOnFocus && D.call(this), n.scrollButtons.enable && H.call(this), n.keyboard.enable && j.call(this), o.bindEvents = !0
                        }
                    },
                    _ = function () {
                        var e = t(this),
                            i = e.data("mCS"),
                            o = i.opt,
                            n = "mCS_" + i.idx,
                            r = ".mCSB_" + i.idx + "_scrollbar",
                            s = t("#mCSB_" + i.idx + ",#mCSB_" + i.idx + "_container,#mCSB_" + i.idx + "_container_wrapper," + r + " ." + l[12] + ",#mCSB_" + i.idx + "_dragger_vertical,#mCSB_" + i.idx + "_dragger_horizontal," + r + ">a"),
                            a = t("#mCSB_" + i.idx + "_container");
                        o.advanced.releaseDraggableSelectors && s.add(t(o.advanced.releaseDraggableSelectors)), o.advanced.extraDraggableSelectors && s.add(t(o.advanced.extraDraggableSelectors)), i.bindEvents && (t(document).add(t(!P() || top.document)).unbind("." + n), s.each(function () {
                            t(this).unbind("." + n)
                        }), clearTimeout(e[0]._focusTimeout), Z(e[0], "_focusTimeout"), clearTimeout(i.sequential.step), Z(i.sequential, "step"), clearTimeout(a[0].onCompleteTimeout), Z(a[0], "onCompleteTimeout"), i.bindEvents = !1)
                    },
                    T = function (e) {
                        var i = t(this),
                            o = i.data("mCS"),
                            n = o.opt,
                            r = t("#mCSB_" + o.idx + "_container_wrapper"),
                            s = r.length ? r : t("#mCSB_" + o.idx + "_container"),
                            a = [t("#mCSB_" + o.idx + "_scrollbar_vertical"), t("#mCSB_" + o.idx + "_scrollbar_horizontal")],
                            c = [a[0].find(".mCSB_dragger"), a[1].find(".mCSB_dragger")];
                        "x" !== n.axis && (o.overflowed[0] && !e ? (a[0].add(c[0]).add(a[0].children("a")).css("display", "block"), s.removeClass(l[8] + " " + l[10])) : (n.alwaysShowScrollbar ? (2 !== n.alwaysShowScrollbar && c[0].css("display", "none"), s.removeClass(l[10])) : (a[0].css("display", "none"), s.addClass(l[10])), s.addClass(l[8]))), "y" !== n.axis && (o.overflowed[1] && !e ? (a[1].add(c[1]).add(a[1].children("a")).css("display", "block"), s.removeClass(l[9] + " " + l[11])) : (n.alwaysShowScrollbar ? (2 !== n.alwaysShowScrollbar && c[1].css("display", "none"), s.removeClass(l[11])) : (a[1].css("display", "none"), s.addClass(l[11])), s.addClass(l[9]))), o.overflowed[0] || o.overflowed[1] ? i.removeClass(l[5]) : i.addClass(l[5])
                    },
                    E = function (e) {
                        var i = e.type,
                            o = e.target.ownerDocument !== document && null !== frameElement ? [t(frameElement).offset().top, t(frameElement).offset().left] : null,
                            n = P() && e.target.ownerDocument !== top.document && null !== frameElement ? [t(e.view.frameElement).offset().top, t(e.view.frameElement).offset().left] : [0, 0];
                        switch (i) {
                            case "pointerdown":
                            case "MSPointerDown":
                            case "pointermove":
                            case "MSPointerMove":
                            case "pointerup":
                            case "MSPointerUp":
                                return o ? [e.originalEvent.pageY - o[0] + n[0], e.originalEvent.pageX - o[1] + n[1], !1] : [e.originalEvent.pageY, e.originalEvent.pageX, !1];
                            case "touchstart":
                            case "touchmove":
                            case "touchend":
                                var r = e.originalEvent.touches[0] || e.originalEvent.changedTouches[0],
                                    s = e.originalEvent.touches.length || e.originalEvent.changedTouches.length;
                                return e.target.ownerDocument !== document ? [r.screenY, r.screenX, s > 1] : [r.pageY, r.pageX, s > 1];
                            default:
                                return o ? [e.pageY - o[0] + n[0], e.pageX - o[1] + n[1], !1] : [e.pageY, e.pageX, !1]
                        }
                    },
                    O = function () {
                        function e(t, e, o, n) {
                            if (p[0].idleTimer = c.scrollInertia < 233 ? 250 : 0, i.attr("id") === u[1]) var s = "x",
                                a = (i[0].offsetLeft - e + n) * l.scrollRatio.x;
                            else var s = "y",
                                a = (i[0].offsetTop - t + o) * l.scrollRatio.y;
                            Q(r, a.toString(), {
                                dir: s,
                                drag: !0
                            })
                        }
                        var i, o, n, r = t(this),
                            l = r.data("mCS"),
                            c = l.opt,
                            d = "mCS_" + l.idx,
                            u = ["mCSB_" + l.idx + "_dragger_vertical", "mCSB_" + l.idx + "_dragger_horizontal"],
                            p = t("#mCSB_" + l.idx + "_container"),
                            h = t("#" + u[0] + ",#" + u[1]),
                            f = c.advanced.releaseDraggableSelectors ? h.add(t(c.advanced.releaseDraggableSelectors)) : h,
                            m = c.advanced.extraDraggableSelectors ? t(!P() || top.document).add(t(c.advanced.extraDraggableSelectors)) : t(!P() || top.document);
                        h.bind("contextmenu." + d, function (t) {
                            t.preventDefault()
                        }).bind("mousedown." + d + " touchstart." + d + " pointerdown." + d + " MSPointerDown." + d, function (e) {
                            if (e.stopImmediatePropagation(), e.preventDefault(), K(e)) {
                                a = !0, s && (document.onselectstart = function () {
                                    return !1
                                }), M.call(p, !1), Y(r), i = t(this);
                                var l = i.offset(),
                                    d = E(e)[0] - l.top,
                                    u = E(e)[1] - l.left,
                                    h = i.height() + l.top,
                                    f = i.width() + l.left;
                                d < h && d > 0 && u < f && u > 0 && (o = d, n = u), S(i, "active", c.autoExpandScrollbar)
                            }
                        }).bind("touchmove." + d, function (t) {
                            t.stopImmediatePropagation(), t.preventDefault();
                            var r = i.offset(),
                                s = E(t)[0] - r.top,
                                a = E(t)[1] - r.left;
                            e(o, n, s, a)
                        }), t(document).add(m).bind("mousemove." + d + " pointermove." + d + " MSPointerMove." + d, function (t) {
                            if (i) {
                                var r = i.offset(),
                                    s = E(t)[0] - r.top,
                                    a = E(t)[1] - r.left;
                                if (o === s && n === a) return;
                                e(o, n, s, a)
                            }
                        }).add(f).bind("mouseup." + d + " touchend." + d + " pointerup." + d + " MSPointerUp." + d, function (t) {
                            i && (S(i, "active", c.autoExpandScrollbar), i = null), a = !1, s && (document.onselectstart = null), M.call(p, !0)
                        })
                    },
                    I = function () {
                        function i(t) {
                            if (!J(t) || a || E(t)[2]) return void(e = 0);
                            e = 1, S = 0, x = 0, c = 1, C.removeClass("mCS_touch_action");
                            var i = I.offset();
                            d = E(t)[0] - i.top, u = E(t)[1] - i.left, B = [E(t)[0], E(t)[1]]
                        }

                        function o(t) {
                            if (J(t) && !a && !E(t)[2] && (_.documentTouchScroll || t.preventDefault(), t.stopImmediatePropagation(), (!x || S) && c)) {
                                m = X();
                                var e = O.offset(),
                                    i = E(t)[0] - e.top,
                                    o = E(t)[1] - e.left;
                                if ($.push(i), A.push(o), B[2] = Math.abs(E(t)[0] - B[0]), B[3] = Math.abs(E(t)[1] - B[1]), k.overflowed[0]) var n = z[0].parent().height() - z[0].height(),
                                    r = d - i > 0 && i - d > -n * k.scrollRatio.y && (2 * B[3] < B[2] || "yx" === _.axis);
                                if (k.overflowed[1]) var s = z[1].parent().width() - z[1].width(),
                                    p = u - o > 0 && o - u > -s * k.scrollRatio.x && (2 * B[2] < B[3] || "yx" === _.axis);
                                r || p ? (H || t.preventDefault(), S = 1) : (x = 1, C.addClass("mCS_touch_action")), H && t.preventDefault(), w = "yx" === _.axis ? [d - i, u - o] : "x" === _.axis ? [null, u - o] : [d - i, null], I[0].idleTimer = 250, k.overflowed[0] && l(w[0], M, "mcsLinearOut", "y", "all", !0), k.overflowed[1] && l(w[1], M, "mcsLinearOut", "x", L, !0)
                            }
                        }

                        function n(t) {
                            if (!J(t) || a || E(t)[2]) return void(e = 0);
                            e = 1, t.stopImmediatePropagation(), Y(C), f = X();
                            var i = O.offset();
                            p = E(t)[0] - i.top, h = E(t)[1] - i.left, $ = [], A = []
                        }

                        function r(t) {
                            if (J(t) && !a && !E(t)[2]) {
                                c = 0, t.stopImmediatePropagation(), S = 0, x = 0, g = X();
                                var e = O.offset(),
                                    i = E(t)[0] - e.top,
                                    o = E(t)[1] - e.left;
                                if (!(g - m > 30)) {
                                    y = 1e3 / (g - f);
                                    var n = y < 2.5,
                                        r = n ? [$[$.length - 2], A[A.length - 2]] : [0, 0];
                                    v = n ? [i - r[0], o - r[1]] : [i - p, o - h];
                                    var d = [Math.abs(v[0]), Math.abs(v[1])];
                                    y = n ? [Math.abs(v[0] / 4), Math.abs(v[1] / 4)] : [y, y];
                                    var u = [Math.abs(I[0].offsetTop) - v[0] * s(d[0] / y[0], y[0]), Math.abs(I[0].offsetLeft) - v[1] * s(d[1] / y[1], y[1])];
                                    w = "yx" === _.axis ? [u[0], u[1]] : "x" === _.axis ? [null, u[1]] : [u[0], null], b = [4 * d[0] + _.scrollInertia, 4 * d[1] + _.scrollInertia];
                                    var C = parseInt(_.contentTouchScroll) || 0;
                                    w[0] = d[0] > C ? w[0] : 0, w[1] = d[1] > C ? w[1] : 0, k.overflowed[0] && l(w[0], b[0], "mcsEaseOut", "y", L, !1), k.overflowed[1] && l(w[1], b[1], "mcsEaseOut", "x", L, !1)
                                }
                            }
                        }

                        function s(t, e) {
                            var i = [1.5 * e, 2 * e, e / 1.5, e / 2];
                            return t > 90 ? e > 4 ? i[0] : i[3] : t > 60 ? e > 3 ? i[3] : i[2] : t > 30 ? e > 8 ? i[1] : e > 6 ? i[0] : e > 4 ? e : i[2] : e > 8 ? e : i[3]
                        }

                        function l(t, e, i, o, n, r) {
                            t && Q(C, t.toString(), {
                                dur: e,
                                scrollEasing: i,
                                dir: o,
                                overwrite: n,
                                drag: r
                            })
                        }
                        var c, d, u, p, h, f, m, g, v, y, w, b, S, x, C = t(this),
                            k = C.data("mCS"),
                            _ = k.opt,
                            T = "mCS_" + k.idx,
                            O = t("#mCSB_" + k.idx),
                            I = t("#mCSB_" + k.idx + "_container"),
                            z = [t("#mCSB_" + k.idx + "_dragger_vertical"), t("#mCSB_" + k.idx + "_dragger_horizontal")],
                            $ = [],
                            A = [],
                            M = 0,
                            L = "yx" === _.axis ? "none" : "all",
                            B = [],
                            D = I.find("iframe"),
                            W = ["touchstart." + T + " pointerdown." + T + " MSPointerDown." + T, "touchmove." + T + " pointermove." + T + " MSPointerMove." + T, "touchend." + T + " pointerup." + T + " MSPointerUp." + T],
                            H = void 0 !== document.body.style.touchAction && "" !== document.body.style.touchAction;
                        I.bind(W[0], function (t) {
                            i(t)
                        }).bind(W[1], function (t) {
                            o(t)
                        }), O.bind(W[0], function (t) {
                            n(t)
                        }).bind(W[2], function (t) {
                            r(t)
                        }), D.length && D.each(function () {
                            t(this).bind("load", function () {
                                P(this) && t(this.contentDocument || this.contentWindow.document).bind(W[0], function (t) {
                                    i(t), n(t)
                                }).bind(W[1], function (t) {
                                    o(t)
                                }).bind(W[2], function (t) {
                                    r(t)
                                })
                            })
                        })
                    },
                    z = function () {
                        function i() {
                            return window.getSelection ? window.getSelection().toString() : document.selection && "Control" != document.selection.type ? document.selection.createRange().text : 0
                        }

                        function o(t, e, i) {
                            c.type = i && n ? "stepped" : "stepless", c.scrollAmount = 10, q(r, t, e, "mcsLinearOut", i ? 60 : null)
                        }
                        var n, r = t(this),
                            s = r.data("mCS"),
                            l = s.opt,
                            c = s.sequential,
                            d = "mCS_" + s.idx,
                            u = t("#mCSB_" + s.idx + "_container"),
                            p = u.parent();
                        u.bind("mousedown." + d, function (t) {
                            e || n || (n = 1, a = !0)
                        }).add(document).bind("mousemove." + d, function (t) {
                            if (!e && n && i()) {
                                var r = u.offset(),
                                    a = E(t)[0] - r.top + u[0].offsetTop,
                                    d = E(t)[1] - r.left + u[0].offsetLeft;
                                a > 0 && a < p.height() && d > 0 && d < p.width() ? c.step && o("off", null, "stepped") : ("x" !== l.axis && s.overflowed[0] && (a < 0 ? o("on", 38) : a > p.height() && o("on", 40)), "y" !== l.axis && s.overflowed[1] && (d < 0 ? o("on", 37) : d > p.width() && o("on", 39)))
                            }
                        }).bind("mouseup." + d + " dragend." + d, function (t) {
                            e || (n && (n = 0, o("off", null)), a = !1)
                        })
                    },
                    $ = function () {
                        function e(e, r) {
                            if (Y(i), !L(i, e.target)) {
                                var c = "auto" !== n.mouseWheel.deltaFactor ? parseInt(n.mouseWheel.deltaFactor) : s && e.deltaFactor < 100 ? 100 : e.deltaFactor || 100,
                                    d = n.scrollInertia;
                                if ("x" === n.axis || "x" === n.mouseWheel.axis) var u = "x",
                                    p = [Math.round(c * o.scrollRatio.x), parseInt(n.mouseWheel.scrollAmount)],
                                    h = "auto" !== n.mouseWheel.scrollAmount ? p[1] : p[0] >= a.width() ? .9 * a.width() : p[0],
                                    f = Math.abs(t("#mCSB_" + o.idx + "_container")[0].offsetLeft),
                                    m = l[1][0].offsetLeft,
                                    g = l[1].parent().width() - l[1].width(),
                                    v = "y" === n.mouseWheel.axis ? e.deltaY || r : e.deltaX;
                                else var u = "y",
                                    p = [Math.round(c * o.scrollRatio.y), parseInt(n.mouseWheel.scrollAmount)],
                                    h = "auto" !== n.mouseWheel.scrollAmount ? p[1] : p[0] >= a.height() ? .9 * a.height() : p[0],
                                    f = Math.abs(t("#mCSB_" + o.idx + "_container")[0].offsetTop),
                                    m = l[0][0].offsetTop,
                                    g = l[0].parent().height() - l[0].height(),
                                    v = e.deltaY || r;
                                "y" === u && !o.overflowed[0] || "x" === u && !o.overflowed[1] || ((n.mouseWheel.invert || e.webkitDirectionInvertedFromDevice) && (v = -v), n.mouseWheel.normalizeDelta && (v = v < 0 ? -1 : 1), (v > 0 && 0 !== m || v < 0 && m !== g || n.mouseWheel.preventDefault) && (e.stopImmediatePropagation(), e.preventDefault()), e.deltaFactor < 5 && !n.mouseWheel.normalizeDelta && (h = e.deltaFactor, d = 17), Q(i, (f - v * h).toString(), {
                                    dir: u,
                                    dur: d
                                }))
                            }
                        }
                        if (t(this).data("mCS")) {
                            var i = t(this),
                                o = i.data("mCS"),
                                n = o.opt,
                                r = "mCS_" + o.idx,
                                a = t("#mCSB_" + o.idx),
                                l = [t("#mCSB_" + o.idx + "_dragger_vertical"), t("#mCSB_" + o.idx + "_dragger_horizontal")],
                                c = t("#mCSB_" + o.idx + "_container").find("iframe");
                            c.length && c.each(function () {
                                t(this).bind("load", function () {
                                    P(this) && t(this.contentDocument || this.contentWindow.document).bind("mousewheel." + r, function (t, i) {
                                        e(t, i)
                                    })
                                })
                            }), a.bind("mousewheel." + r, function (t, i) {
                                e(t, i)
                            })
                        }
                    },
                    A = new Object,
                    P = function (e) {
                        var i = !1,
                            o = !1,
                            n = null;
                        if (void 0 === e ? o = "#empty" : void 0 !== t(e).attr("id") && (o = t(e).attr("id")), !1 !== o && void 0 !== A[o]) return A[o];
                        if (e) {
                            try {
                                var r = e.contentDocument || e.contentWindow.document;
                                n = r.body.innerHTML
                            } catch (t) {}
                            i = null !== n
                        } else {
                            try {
                                var r = top.document;
                                n = r.body.innerHTML
                            } catch (t) {}
                            i = null !== n
                        }
                        return !1 !== o && (A[o] = i), i
                    },
                    M = function (t) {
                        var e = this.find("iframe");
                        if (e.length) {
                            var i = t ? "auto" : "none";
                            e.css("pointer-events", i)
                        }
                    },
                    L = function (e, i) {
                        var o = i.nodeName.toLowerCase(),
                            n = e.data("mCS").opt.mouseWheel.disableOver,
                            r = ["select", "textarea"];
                        return t.inArray(o, n) > -1 && !(t.inArray(o, r) > -1 && !t(i).is(":focus"))
                    },
                    B = function () {
                        var e, i = t(this),
                            o = i.data("mCS"),
                            n = "mCS_" + o.idx,
                            r = t("#mCSB_" + o.idx + "_container"),
                            s = r.parent(),
                            c = t(".mCSB_" + o.idx + "_scrollbar ." + l[12]);
                        c.bind("mousedown." + n + " touchstart." + n + " pointerdown." + n + " MSPointerDown." + n, function (i) {
                            a = !0, t(i.target).hasClass("mCSB_dragger") || (e = 1)
                        }).bind("touchend." + n + " pointerup." + n + " MSPointerUp." + n, function (t) {
                            a = !1
                        }).bind("click." + n, function (n) {
                            if (e && (e = 0, t(n.target).hasClass(l[12]) || t(n.target).hasClass("mCSB_draggerRail"))) {
                                Y(i);
                                var a = t(this),
                                    c = a.find(".mCSB_dragger");
                                if (a.parent(".mCSB_scrollTools_horizontal").length > 0) {
                                    if (!o.overflowed[1]) return;
                                    var d = "x",
                                        u = n.pageX > c.offset().left ? -1 : 1,
                                        p = Math.abs(r[0].offsetLeft) - u * (.9 * s.width())
                                } else {
                                    if (!o.overflowed[0]) return;
                                    var d = "y",
                                        u = n.pageY > c.offset().top ? -1 : 1,
                                        p = Math.abs(r[0].offsetTop) - u * (.9 * s.height())
                                }
                                Q(i, p.toString(), {
                                    dir: d,
                                    scrollEasing: "mcsEaseInOut"
                                })
                            }
                        })
                    },
                    D = function () {
                        var e = t(this),
                            i = e.data("mCS"),
                            o = i.opt,
                            n = "mCS_" + i.idx,
                            r = t("#mCSB_" + i.idx + "_container"),
                            s = r.parent();
                        r.bind("focusin." + n, function (i) {
                            var n = t(document.activeElement),
                                a = r.find(".mCustomScrollBox").length;
                            n.is(o.advanced.autoScrollOnFocus) && (Y(e), clearTimeout(e[0]._focusTimeout), e[0]._focusTimer = a ? 17 * a : 0, e[0]._focusTimeout = setTimeout(function () {
                                var t = [et(n)[0], et(n)[1]],
                                    i = [r[0].offsetTop, r[0].offsetLeft],
                                    a = [i[0] + t[0] >= 0 && i[0] + t[0] < s.height() - n.outerHeight(!1), i[1] + t[1] >= 0 && i[0] + t[1] < s.width() - n.outerWidth(!1)],
                                    l = "yx" !== o.axis || a[0] || a[1] ? "all" : "none";
                                "x" === o.axis || a[0] || Q(e, t[0].toString(), {
                                    dir: "y",
                                    scrollEasing: "mcsEaseInOut",
                                    overwrite: l,
                                    dur: 0
                                }), "y" === o.axis || a[1] || Q(e, t[1].toString(), {
                                    dir: "x",
                                    scrollEasing: "mcsEaseInOut",
                                    overwrite: l,
                                    dur: 0
                                })
                            }, e[0]._focusTimer))
                        })
                    },
                    W = function () {
                        var e = t(this),
                            i = e.data("mCS"),
                            o = "mCS_" + i.idx,
                            n = t("#mCSB_" + i.idx + "_container").parent();
                        n.bind("scroll." + o, function (e) {
                            0 === n.scrollTop() && 0 === n.scrollLeft() || t(".mCSB_" + i.idx + "_scrollbar").css("visibility", "hidden")
                        })
                    },
                    H = function () {
                        var e = t(this),
                            i = e.data("mCS"),
                            o = i.opt,
                            n = i.sequential,
                            r = "mCS_" + i.idx,
                            s = ".mCSB_" + i.idx + "_scrollbar";
                        t(s + ">a").bind("contextmenu." + r, function (t) {
                            t.preventDefault()
                        }).bind("mousedown." + r + " touchstart." + r + " pointerdown." + r + " MSPointerDown." + r + " mouseup." + r + " touchend." + r + " pointerup." + r + " MSPointerUp." + r + " mouseout." + r + " pointerout." + r + " MSPointerOut." + r + " click." + r, function (r) {
                            function s(t, i) {
                                n.scrollAmount = o.scrollButtons.scrollAmount, q(e, t, i)
                            }
                            if (r.preventDefault(), K(r)) {
                                var l = t(this).attr("class");
                                switch (n.type = o.scrollButtons.scrollType, r.type) {
                                    case "mousedown":
                                    case "touchstart":
                                    case "pointerdown":
                                    case "MSPointerDown":
                                        if ("stepped" === n.type) return;
                                        a = !0, i.tweenRunning = !1, s("on", l);
                                        break;
                                    case "mouseup":
                                    case "touchend":
                                    case "pointerup":
                                    case "MSPointerUp":
                                    case "mouseout":
                                    case "pointerout":
                                    case "MSPointerOut":
                                        if ("stepped" === n.type) return;
                                        a = !1, n.dir && s("off", l);
                                        break;
                                    case "click":
                                        if ("stepped" !== n.type || i.tweenRunning) return;
                                        s("on", l)
                                }
                            }
                        })
                    },
                    j = function () {
                        function e(e) {
                            function s(t, e) {
                                r.type = n.keyboard.scrollType, r.scrollAmount = n.keyboard.scrollAmount, "stepped" === r.type && o.tweenRunning || q(i, t, e)
                            }
                            switch (e.type) {
                                case "blur":
                                    o.tweenRunning && r.dir && s("off", null);
                                    break;
                                case "keydown":
                                case "keyup":
                                    var a = e.keyCode ? e.keyCode : e.which,
                                        u = "on";
                                    if ("x" !== n.axis && (38 === a || 40 === a) || "y" !== n.axis && (37 === a || 39 === a)) {
                                        if ((38 === a || 40 === a) && !o.overflowed[0] || (37 === a || 39 === a) && !o.overflowed[1]) return;
                                        "keyup" === e.type && (u = "off"), t(document.activeElement).is(d) || (e.preventDefault(), e.stopImmediatePropagation(), s(u, a))
                                    } else if (33 === a || 34 === a) {
                                        if ((o.overflowed[0] || o.overflowed[1]) && (e.preventDefault(), e.stopImmediatePropagation()), "keyup" === e.type) {
                                            Y(i);
                                            var p = 34 === a ? -1 : 1;
                                            if ("x" === n.axis || "yx" === n.axis && o.overflowed[1] && !o.overflowed[0]) var h = "x",
                                                f = Math.abs(l[0].offsetLeft) - p * (.9 * c.width());
                                            else var h = "y",
                                                f = Math.abs(l[0].offsetTop) - p * (.9 * c.height());
                                            Q(i, f.toString(), {
                                                dir: h,
                                                scrollEasing: "mcsEaseInOut"
                                            })
                                        }
                                    } else if ((35 === a || 36 === a) && !t(document.activeElement).is(d) && ((o.overflowed[0] || o.overflowed[1]) && (e.preventDefault(), e.stopImmediatePropagation()), "keyup" === e.type)) {
                                        if ("x" === n.axis || "yx" === n.axis && o.overflowed[1] && !o.overflowed[0]) var h = "x",
                                            f = 35 === a ? Math.abs(c.width() - l.outerWidth(!1)) : 0;
                                        else var h = "y",
                                            f = 35 === a ? Math.abs(c.height() - l.outerHeight(!1)) : 0;
                                        Q(i, f.toString(), {
                                            dir: h,
                                            scrollEasing: "mcsEaseInOut"
                                        })
                                    }
                            }
                        }
                        var i = t(this),
                            o = i.data("mCS"),
                            n = o.opt,
                            r = o.sequential,
                            s = "mCS_" + o.idx,
                            a = t("#mCSB_" + o.idx),
                            l = t("#mCSB_" + o.idx + "_container"),
                            c = l.parent(),
                            d = "input,textarea,select,datalist,keygen,[contenteditable='true']",
                            u = l.find("iframe"),
                            p = ["blur." + s + " keydown." + s + " keyup." + s];
                        u.length && u.each(function () {
                            t(this).bind("load", function () {
                                P(this) && t(this.contentDocument || this.contentWindow.document).bind(p[0], function (t) {
                                    e(t)
                                })
                            })
                        }), a.attr("tabindex", "0").bind(p[0], function (t) {
                            e(t)
                        })
                    },
                    q = function (e, i, o, n, r) {
                        function s(t) {
                            c.snapAmount && (d.scrollAmount = c.snapAmount instanceof Array ? "x" === d.dir[0] ? c.snapAmount[1] : c.snapAmount[0] : c.snapAmount);
                            var i = "stepped" !== d.type,
                                o = r || (t ? i ? h / 1.5 : f : 1e3 / 60),
                                l = t ? i ? 7.5 : 40 : 2.5,
                                p = [Math.abs(u[0].offsetTop), Math.abs(u[0].offsetLeft)],
                                m = [a.scrollRatio.y > 10 ? 10 : a.scrollRatio.y, a.scrollRatio.x > 10 ? 10 : a.scrollRatio.x],
                                g = "x" === d.dir[0] ? p[1] + d.dir[1] * (m[1] * l) : p[0] + d.dir[1] * (m[0] * l),
                                v = "x" === d.dir[0] ? p[1] + d.dir[1] * parseInt(d.scrollAmount) : p[0] + d.dir[1] * parseInt(d.scrollAmount),
                                y = "auto" !== d.scrollAmount ? v : g,
                                w = n || (t ? i ? "mcsLinearOut" : "mcsEaseInOut" : "mcsLinear"),
                                b = !!t;
                            if (t && o < 17 && (y = "x" === d.dir[0] ? p[1] : p[0]), Q(e, y.toString(), {
                                    dir: d.dir[0],
                                    scrollEasing: w,
                                    dur: o,
                                    onComplete: b
                                }), t) return void(d.dir = !1);
                            clearTimeout(d.step), d.step = setTimeout(function () {
                                s()
                            }, o)
                        }
                        var a = e.data("mCS"),
                            c = a.opt,
                            d = a.sequential,
                            u = t("#mCSB_" + a.idx + "_container"),
                            p = "stepped" === d.type,
                            h = c.scrollInertia < 26 ? 26 : c.scrollInertia,
                            f = c.scrollInertia < 1 ? 17 : c.scrollInertia;
                        switch (i) {
                            case "on":
                                if (d.dir = [o === l[16] || o === l[15] || 39 === o || 37 === o ? "x" : "y", o === l[13] || o === l[15] || 38 === o || 37 === o ? -1 : 1], Y(e), tt(o) && "stepped" === d.type) return;
                                s(p);
                                break;
                            case "off":
                                ! function () {
                                    clearTimeout(d.step), Z(d, "step"), Y(e)
                                }(), (p || a.tweenRunning && d.dir) && s(!0)
                        }
                    },
                    F = function (e) {
                        var i = t(this).data("mCS").opt,
                            o = [];
                        return "function" == typeof e && (e = e()), e instanceof Array ? o = e.length > 1 ? [e[0], e[1]] : "x" === i.axis ? [null, e[0]] : [e[0], null] : (o[0] = e.y ? e.y : e.x || "x" === i.axis ? null : e, o[1] = e.x ? e.x : e.y || "y" === i.axis ? null : e), "function" == typeof o[0] && (o[0] = o[0]()), "function" == typeof o[1] && (o[1] = o[1]()), o
                    },
                    R = function (e, i) {
                        if (null != e && void 0 !== e) {
                            var o = t(this),
                                n = o.data("mCS"),
                                r = n.opt,
                                s = t("#mCSB_" + n.idx + "_container"),
                                a = s.parent(),
                                l = typeof e;
                            i || (i = "x" === r.axis ? "x" : "y");
                            var d = "x" === i ? s.outerWidth(!1) - a.width() : s.outerHeight(!1) - a.height(),
                                u = "x" === i ? s[0].offsetLeft : s[0].offsetTop,
                                p = "x" === i ? "left" : "top";
                            switch (l) {
                                case "function":
                                    return e();
                                case "object":
                                    var h = e.jquery ? e : t(e);
                                    if (!h.length) return;
                                    return "x" === i ? et(h)[1] : et(h)[0];
                                case "string":
                                case "number":
                                    if (tt(e)) return Math.abs(e);
                                    if (-1 !== e.indexOf("%")) return Math.abs(d * parseInt(e) / 100);
                                    if (-1 !== e.indexOf("-=")) return Math.abs(u - parseInt(e.split("-=")[1]));
                                    if (-1 !== e.indexOf("+=")) {
                                        var f = u + parseInt(e.split("+=")[1]);
                                        return f >= 0 ? 0 : Math.abs(f)
                                    }
                                    if (-1 !== e.indexOf("px") && tt(e.split("px")[0])) return Math.abs(e.split("px")[0]);
                                    if ("top" === e || "left" === e) return 0;
                                    if ("bottom" === e) return Math.abs(a.height() - s.outerHeight(!1));
                                    if ("right" === e) return Math.abs(a.width() - s.outerWidth(!1));
                                    if ("first" === e || "last" === e) {
                                        var h = s.find(":" + e);
                                        return "x" === i ? et(h)[1] : et(h)[0]
                                    }
                                    return t(e).length ? "x" === i ? et(t(e))[1] : et(t(e))[0] : (s.css(p, e), void c.update.call(null, o[0]))
                            }
                        }
                    },
                    N = function (e) {
                        function i() {
                            if (clearTimeout(u[0].autoUpdate), 0 === s.parents("html").length) return void(s = null);
                            u[0].autoUpdate = setTimeout(function () {
                                return d.advanced.updateOnSelectorChange && (a.poll.change.n = n(), a.poll.change.n !== a.poll.change.o) ? (a.poll.change.o = a.poll.change.n, void r(3)) : d.advanced.updateOnContentResize && (a.poll.size.n = s[0].scrollHeight + s[0].scrollWidth + u[0].offsetHeight + s[0].offsetHeight + s[0].offsetWidth, a.poll.size.n !== a.poll.size.o) ? (a.poll.size.o = a.poll.size.n, void r(1)) : !d.advanced.updateOnImageLoad || "auto" === d.advanced.updateOnImageLoad && "y" === d.axis || (a.poll.img.n = u.find("img").length, a.poll.img.n === a.poll.img.o) ? void((d.advanced.updateOnSelectorChange || d.advanced.updateOnContentResize || d.advanced.updateOnImageLoad) && i()) : (a.poll.img.o = a.poll.img.n, void u.find("img").each(function () {
                                    o(this)
                                }))
                            }, d.advanced.autoUpdateTimeout)
                        }

                        function o(e) {
                            function i() {
                                this.onload = null, t(e).addClass(l[2]), r(2)
                            }
                            if (t(e).hasClass(l[2])) return void r();
                            var o = new Image;
                            o.onload = function (t, e) {
                                return function () {
                                    return e.apply(t, arguments)
                                }
                            }(o, i), o.src = e.src
                        }

                        function n() {
                            !0 === d.advanced.updateOnSelectorChange && (d.advanced.updateOnSelectorChange = "*");
                            var t = 0,
                                e = u.find(d.advanced.updateOnSelectorChange);
                            return d.advanced.updateOnSelectorChange && e.length > 0 && e.each(function () {
                                t += this.offsetHeight + this.offsetWidth
                            }), t
                        }

                        function r(t) {
                            clearTimeout(u[0].autoUpdate), c.update.call(null, s[0], t)
                        }
                        var s = t(this),
                            a = s.data("mCS"),
                            d = a.opt,
                            u = t("#mCSB_" + a.idx + "_container");
                        if (e) return clearTimeout(u[0].autoUpdate), void Z(u[0], "autoUpdate");
                        i()
                    },
                    U = function (t, e, i) {
                        return Math.round(t / e) * e - i
                    },
                    Y = function (e) {
                        var i = e.data("mCS");
                        t("#mCSB_" + i.idx + "_container,#mCSB_" + i.idx + "_container_wrapper,#mCSB_" + i.idx + "_dragger_vertical,#mCSB_" + i.idx + "_dragger_horizontal").each(function () {
                            G.call(this)
                        })
                    },
                    Q = function (e, i, o) {
                        function n(t) {
                            return a && l.callbacks[t] && "function" == typeof l.callbacks[t]
                        }

                        function r() {
                            return [l.callbacks.alwaysTriggerOffsets || w >= b[0] + C, l.callbacks.alwaysTriggerOffsets || w <= -k]
                        }

                        function s() {
                            var t = [p[0].offsetTop, p[0].offsetLeft],
                                i = [v[0].offsetTop, v[0].offsetLeft],
                                n = [p.outerHeight(!1), p.outerWidth(!1)],
                                r = [u.height(), u.width()];
                            e[0].mcs = {
                                content: p,
                                top: t[0],
                                left: t[1],
                                draggerTop: i[0],
                                draggerLeft: i[1],
                                topPct: Math.round(100 * Math.abs(t[0]) / (Math.abs(n[0]) - r[0])),
                                leftPct: Math.round(100 * Math.abs(t[1]) / (Math.abs(n[1]) - r[1])),
                                direction: o.dir
                            }
                        }
                        var a = e.data("mCS"),
                            l = a.opt,
                            c = {
                                trigger: "internal",
                                dir: "y",
                                scrollEasing: "mcsEaseOut",
                                drag: !1,
                                dur: l.scrollInertia,
                                overwrite: "all",
                                callbacks: !0,
                                onStart: !0,
                                onUpdate: !0,
                                onComplete: !0
                            },
                            o = t.extend(c, o),
                            d = [o.dur, o.drag ? 0 : o.dur],
                            u = t("#mCSB_" + a.idx),
                            p = t("#mCSB_" + a.idx + "_container"),
                            h = p.parent(),
                            f = l.callbacks.onTotalScrollOffset ? F.call(e, l.callbacks.onTotalScrollOffset) : [0, 0],
                            m = l.callbacks.onTotalScrollBackOffset ? F.call(e, l.callbacks.onTotalScrollBackOffset) : [0, 0];
                        if (a.trigger = o.trigger, 0 === h.scrollTop() && 0 === h.scrollLeft() || (t(".mCSB_" + a.idx + "_scrollbar").css("visibility", "visible"), h.scrollTop(0).scrollLeft(0)), "_resetY" !== i || a.contentReset.y || (n("onOverflowYNone") && l.callbacks.onOverflowYNone.call(e[0]), a.contentReset.y = 1), "_resetX" !== i || a.contentReset.x || (n("onOverflowXNone") && l.callbacks.onOverflowXNone.call(e[0]), a.contentReset.x = 1), "_resetY" !== i && "_resetX" !== i) {
                            if (!a.contentReset.y && e[0].mcs || !a.overflowed[0] || (n("onOverflowY") && l.callbacks.onOverflowY.call(e[0]), a.contentReset.x = null), !a.contentReset.x && e[0].mcs || !a.overflowed[1] || (n("onOverflowX") && l.callbacks.onOverflowX.call(e[0]), a.contentReset.x = null), l.snapAmount) {
                                var g = l.snapAmount instanceof Array ? "x" === o.dir ? l.snapAmount[1] : l.snapAmount[0] : l.snapAmount;
                                i = U(i, g, l.snapOffset)
                            }
                            switch (o.dir) {
                                case "x":
                                    var v = t("#mCSB_" + a.idx + "_dragger_horizontal"),
                                        y = "left",
                                        w = p[0].offsetLeft,
                                        b = [u.width() - p.outerWidth(!1), v.parent().width() - v.width()],
                                        x = [i, 0 === i ? 0 : i / a.scrollRatio.x],
                                        C = f[1],
                                        k = m[1],
                                        _ = C > 0 ? C / a.scrollRatio.x : 0,
                                        T = k > 0 ? k / a.scrollRatio.x : 0;
                                    break;
                                case "y":
                                    var v = t("#mCSB_" + a.idx + "_dragger_vertical"),
                                        y = "top",
                                        w = p[0].offsetTop,
                                        b = [u.height() - p.outerHeight(!1), v.parent().height() - v.height()],
                                        x = [i, 0 === i ? 0 : i / a.scrollRatio.y],
                                        C = f[0],
                                        k = m[0],
                                        _ = C > 0 ? C / a.scrollRatio.y : 0,
                                        T = k > 0 ? k / a.scrollRatio.y : 0
                            }
                            x[1] < 0 || 0 === x[0] && 0 === x[1] ? x = [0, 0] : x[1] >= b[1] ? x = [b[0], b[1]] : x[0] = -x[0], e[0].mcs || (s(), n("onInit") && l.callbacks.onInit.call(e[0])), clearTimeout(p[0].onCompleteTimeout), V(v[0], y, Math.round(x[1]), d[1], o.scrollEasing), !a.tweenRunning && (0 === w && x[0] >= 0 || w === b[0] && x[0] <= b[0]) || V(p[0], y, Math.round(x[0]), d[0], o.scrollEasing, o.overwrite, {
                                onStart: function () {
                                    o.callbacks && o.onStart && !a.tweenRunning && (n("onScrollStart") && (s(), l.callbacks.onScrollStart.call(e[0])), a.tweenRunning = !0, S(v), a.cbOffsets = r())
                                },
                                onUpdate: function () {
                                    o.callbacks && o.onUpdate && n("whileScrolling") && (s(), l.callbacks.whileScrolling.call(e[0]))
                                },
                                onComplete: function () {
                                    if (o.callbacks && o.onComplete) {
                                        "yx" === l.axis && clearTimeout(p[0].onCompleteTimeout);
                                        var t = p[0].idleTimer || 0;
                                        p[0].onCompleteTimeout = setTimeout(function () {
                                            n("onScroll") && (s(), l.callbacks.onScroll.call(e[0])), n("onTotalScroll") && x[1] >= b[1] - _ && a.cbOffsets[0] && (s(), l.callbacks.onTotalScroll.call(e[0])), n("onTotalScrollBack") && x[1] <= T && a.cbOffsets[1] && (s(), l.callbacks.onTotalScrollBack.call(e[0])), a.tweenRunning = !1, p[0].idleTimer = 0, S(v, "hide")
                                        }, t)
                                    }
                                }
                            })
                        }
                    },
                    V = function (t, e, i, o, n, r, s) {
                        function a() {
                            w.stop || (g || p.call(), g = X() - m, l(), g >= w.time && (w.time = g > w.time ? g + d - (g - w.time) : g + d - 1, w.time < g + 1 && (w.time = g + 1)), w.time < o ? w.id = u(a) : f.call())
                        }

                        function l() {
                            o > 0 ? (w.currVal = c(w.time, v, b, o, n), y[e] = Math.round(w.currVal) + "px") : y[e] = i + "px", h.call()
                        }

                        function c(t, e, i, o, n) {
                            switch (n) {
                                case "linear":
                                case "mcsLinear":
                                    return i * t / o + e;
                                case "mcsLinearOut":
                                    return t /= o, t--, i * Math.sqrt(1 - t * t) + e;
                                case "easeInOutSmooth":
                                    return (t /= o / 2) < 1 ? i / 2 * t * t + e : (t--, -i / 2 * (t * (t - 2) - 1) + e);
                                case "easeInOutStrong":
                                    return (t /= o / 2) < 1 ? i / 2 * Math.pow(2, 10 * (t - 1)) + e : (t--, i / 2 * (2 - Math.pow(2, -10 * t)) + e);
                                case "easeInOut":
                                case "mcsEaseInOut":
                                    return (t /= o / 2) < 1 ? i / 2 * t * t * t + e : (t -= 2, i / 2 * (t * t * t + 2) + e);
                                case "easeOutSmooth":
                                    return t /= o, t--, -i * (t * t * t * t - 1) + e;
                                case "easeOutStrong":
                                    return i * (1 - Math.pow(2, -10 * t / o)) + e;
                                case "easeOut":
                                case "mcsEaseOut":
                                default:
                                    var r = (t /= o) * t,
                                        s = r * t;
                                    return e + i * (.499999999999997 * s * r + -2.5 * r * r + 5.5 * s + -6.5 * r + 4 * t)
                            }
                        }
                        t._mTween || (t._mTween = {
                            top: {},
                            left: {}
                        });
                        var d, u, s = s || {},
                            p = s.onStart || function () {},
                            h = s.onUpdate || function () {},
                            f = s.onComplete || function () {},
                            m = X(),
                            g = 0,
                            v = t.offsetTop,
                            y = t.style,
                            w = t._mTween[e];
                        "left" === e && (v = t.offsetLeft);
                        var b = i - v;
                        w.stop = 0, "none" !== r && function () {
                                null != w.id && (window.requestAnimationFrame ? window.cancelAnimationFrame(w.id) : clearTimeout(w.id), w.id = null)
                            }(),
                            function () {
                                d = 1e3 / 60, w.time = g + d, u = window.requestAnimationFrame ? window.requestAnimationFrame : function (t) {
                                    return l(), setTimeout(t, .01)
                                }, w.id = u(a)
                            }()
                    },
                    X = function () {
                        return window.performance && window.performance.now ? window.performance.now() : window.performance && window.performance.webkitNow ? window.performance.webkitNow() : Date.now ? Date.now() : (new Date).getTime()
                    },
                    G = function () {
                        var t = this;
                        t._mTween || (t._mTween = {
                            top: {},
                            left: {}
                        });
                        for (var e = ["top", "left"], i = 0; i < e.length; i++) {
                            var o = e[i];
                            t._mTween[o].id && (window.requestAnimationFrame ? window.cancelAnimationFrame(t._mTween[o].id) : clearTimeout(t._mTween[o].id), t._mTween[o].id = null, t._mTween[o].stop = 1)
                        }
                    },
                    Z = function (t, e) {
                        try {
                            delete t[e]
                        } catch (i) {
                            t[e] = null
                        }
                    },
                    K = function (t) {
                        return !(t.which && 1 !== t.which)
                    },
                    J = function (t) {
                        var e = t.originalEvent.pointerType;
                        return !(e && "touch" !== e && 2 !== e)
                    },
                    tt = function (t) {
                        return !isNaN(parseFloat(t)) && isFinite(t)
                    },
                    et = function (t) {
                        var e = t.parents(".mCSB_container");
                        return [t.offset().top - e.offset().top, t.offset().left - e.offset().left]
                    },
                    it = function () {
                        var t = function () {
                            var t = ["webkit", "moz", "ms", "o"];
                            if ("hidden" in document) return "hidden";
                            for (var e = 0; e < t.length; e++)
                                if (t[e] + "Hidden" in document) return t[e] + "Hidden";
                            return null
                        }();
                        return !!t && document[t]
                    };
                t.fn[i] = function (e) {
                    return c[e] ? c[e].apply(this, Array.prototype.slice.call(arguments, 1)) : "object" != typeof e && e ? void t.error("Method " + e + " does not exist") : c.init.apply(this, arguments)
                }, t[i] = function (e) {
                    return c[e] ? c[e].apply(this, Array.prototype.slice.call(arguments, 1)) : "object" != typeof e && e ? void t.error("Method " + e + " does not exist") : c.init.apply(this, arguments)
                }, t[i].defaults = o, window[i] = !0, t(window).bind("load", function () {
                    t(".mCustomScrollbar")[i](), t.extend(t.expr[":"], {
                        mcsInView: t.expr[":"].mcsInView || function (e) {
                            var i, o, n = t(e),
                                r = n.parents(".mCSB_container");
                            if (r.length) return i = r.parent(), o = [r[0].offsetTop, r[0].offsetLeft], o[0] + et(n)[0] >= 0 && o[0] + et(n)[0] < i.height() - n.outerHeight(!1) && o[1] + et(n)[1] >= 0 && o[1] + et(n)[1] < i.width() - n.outerWidth(!1)
                        },
                        mcsInSight: t.expr[":"].mcsInSight || function (e, i, o) {
                            var n, r, s, a, l = t(e),
                                c = l.parents(".mCSB_container"),
                                d = "exact" === o[3] ? [
                                    [1, 0],
                                    [1, 0]
                                ] : [
                                    [.9, .1],
                                    [.6, .4]
                                ];
                            if (c.length) return n = [l.outerHeight(!1), l.outerWidth(!1)], s = [c[0].offsetTop + et(l)[0], c[0].offsetLeft + et(l)[1]], r = [c.parent()[0].offsetHeight, c.parent()[0].offsetWidth], a = [n[0] < r[0] ? d[0] : d[1], n[1] < r[1] ? d[0] : d[1]], s[0] - r[0] * a[0][0] < 0 && s[0] + n[0] - r[0] * a[0][1] >= 0 && s[1] - r[1] * a[1][0] < 0 && s[1] + n[1] - r[1] * a[1][1] >= 0
                        },
                        mcsOverflow: t.expr[":"].mcsOverflow || function (e) {
                            var i = t(e).data("mCS");
                            if (i) return i.overflowed[0] || i.overflowed[1]
                        }
                    })
                })
            }()
    }()
}),
function (t, e) {
    "function" == typeof define && define.amd ? define("ev-emitter/ev-emitter", e) : "object" == typeof module && module.exports ? module.exports = e() : t.EvEmitter = e()
}("undefined" != typeof window ? window : this, function () {
    function t() {}
    var e = t.prototype;
    return e.on = function (t, e) {
        if (t && e) {
            var i = this._events = this._events || {},
                o = i[t] = i[t] || [];
            return -1 == o.indexOf(e) && o.push(e), this
        }
    }, e.once = function (t, e) {
        if (t && e) {
            this.on(t, e);
            var i = this._onceEvents = this._onceEvents || {};
            return (i[t] = i[t] || {})[e] = !0, this
        }
    }, e.off = function (t, e) {
        var i = this._events && this._events[t];
        if (i && i.length) {
            var o = i.indexOf(e);
            return -1 != o && i.splice(o, 1), this
        }
    }, e.emitEvent = function (t, e) {
        var i = this._events && this._events[t];
        if (i && i.length) {
            i = i.slice(0), e = e || [];
            for (var o = this._onceEvents && this._onceEvents[t], n = 0; n < i.length; n++) {
                var r = i[n];
                o && o[r] && (this.off(t, r), delete o[r]), r.apply(this, e)
            }
            return this
        }
    }, e.allOff = function () {
        delete this._events, delete this._onceEvents
    }, t
}),
function (t, e) {
    "use strict";
    "function" == typeof define && define.amd ? define(["ev-emitter/ev-emitter"], function (i) {
        return e(t, i)
    }) : "object" == typeof module && module.exports ? module.exports = e(t, require("ev-emitter")) : t.imagesLoaded = e(t, t.EvEmitter)
}("undefined" != typeof window ? window : this, function (t, e) {
    function i(t, e) {
        for (var i in e) t[i] = e[i];
        return t
    }

    function o(t) {
        return Array.isArray(t) ? t : "object" == typeof t && "number" == typeof t.length ? c.call(t) : [t]
    }

    function n(t, e, r) {
        if (!(this instanceof n)) return new n(t, e, r);
        var s = t;
        if ("string" == typeof t && (s = document.querySelectorAll(t)), !s) return void l.error("Bad element for imagesLoaded " + (s || t));
        this.elements = o(s), this.options = i({}, this.options), "function" == typeof e ? r = e : i(this.options, e), r && this.on("always", r), this.getImages(), a && (this.jqDeferred = new a.Deferred), setTimeout(this.check.bind(this))
    }

    function r(t) {
        this.img = t
    }

    function s(t, e) {
        this.url = t, this.element = e, this.img = new Image
    }
    var a = t.jQuery,
        l = t.console,
        c = Array.prototype.slice;
    n.prototype = Object.create(e.prototype), n.prototype.options = {}, n.prototype.getImages = function () {
        this.images = [], this.elements.forEach(this.addElementImages, this)
    }, n.prototype.addElementImages = function (t) {
        "IMG" == t.nodeName && this.addImage(t), !0 === this.options.background && this.addElementBackgroundImages(t);
        var e = t.nodeType;
        if (e && d[e]) {
            for (var i = t.querySelectorAll("img"), o = 0; o < i.length; o++) {
                var n = i[o];
                this.addImage(n)
            }
            if ("string" == typeof this.options.background) {
                var r = t.querySelectorAll(this.options.background);
                for (o = 0; o < r.length; o++) {
                    var s = r[o];
                    this.addElementBackgroundImages(s)
                }
            }
        }
    };
    var d = {
        1: !0,
        9: !0,
        11: !0
    };
    return n.prototype.addElementBackgroundImages = function (t) {
        var e = getComputedStyle(t);
        if (e)
            for (var i = /url\((['"])?(.*?)\1\)/gi, o = i.exec(e.backgroundImage); null !== o;) {
                var n = o && o[2];
                n && this.addBackground(n, t), o = i.exec(e.backgroundImage)
            }
    }, n.prototype.addImage = function (t) {
        var e = new r(t);
        this.images.push(e)
    }, n.prototype.addBackground = function (t, e) {
        var i = new s(t, e);
        this.images.push(i)
    }, n.prototype.check = function () {
        function t(t, i, o) {
            setTimeout(function () {
                e.progress(t, i, o)
            })
        }
        var e = this;
        if (this.progressedCount = 0, this.hasAnyBroken = !1, !this.images.length) return void this.complete();
        this.images.forEach(function (e) {
            e.once("progress", t), e.check()
        })
    }, n.prototype.progress = function (t, e, i) {
        this.progressedCount++, this.hasAnyBroken = this.hasAnyBroken || !t.isLoaded, this.emitEvent("progress", [this, t, e]), this.jqDeferred && this.jqDeferred.notify && this.jqDeferred.notify(this, t), this.progressedCount == this.images.length && this.complete(), this.options.debug && l && l.log("progress: " + i, t, e)
    }, n.prototype.complete = function () {
        var t = this.hasAnyBroken ? "fail" : "done";
        if (this.isComplete = !0, this.emitEvent(t, [this]), this.emitEvent("always", [this]), this.jqDeferred) {
            var e = this.hasAnyBroken ? "reject" : "resolve";
            this.jqDeferred[e](this)
        }
    }, r.prototype = Object.create(e.prototype), r.prototype.check = function () {
        if (this.getIsImageComplete()) return void this.confirm(0 !== this.img.naturalWidth, "naturalWidth");
        this.proxyImage = new Image, this.proxyImage.addEventListener("load", this), this.proxyImage.addEventListener("error", this), this.img.addEventListener("load", this), this.img.addEventListener("error", this), this.proxyImage.src = this.img.src
    }, r.prototype.getIsImageComplete = function () {
        return this.img.complete && this.img.naturalWidth
    }, r.prototype.confirm = function (t, e) {
        this.isLoaded = t, this.emitEvent("progress", [this, this.img, e])
    }, r.prototype.handleEvent = function (t) {
        var e = "on" + t.type;
        this[e] && this[e](t)
    }, r.prototype.onload = function () {
        this.confirm(!0, "onload"), this.unbindEvents()
    }, r.prototype.onerror = function () {
        this.confirm(!1, "onerror"), this.unbindEvents()
    }, r.prototype.unbindEvents = function () {
        this.proxyImage.removeEventListener("load", this), this.proxyImage.removeEventListener("error", this), this.img.removeEventListener("load", this), this.img.removeEventListener("error", this)
    }, s.prototype = Object.create(r.prototype), s.prototype.check = function () {
        this.img.addEventListener("load", this), this.img.addEventListener("error", this), this.img.src = this.url, this.getIsImageComplete() && (this.confirm(0 !== this.img.naturalWidth, "naturalWidth"), this.unbindEvents())
    }, s.prototype.unbindEvents = function () {
        this.img.removeEventListener("load", this), this.img.removeEventListener("error", this)
    }, s.prototype.confirm = function (t, e) {
        this.isLoaded = t, this.emitEvent("progress", [this, this.element, e])
    }, n.makeJQueryPlugin = function (e) {
        (e = e || t.jQuery) && (a = e, a.fn.imagesLoaded = function (t, e) {
            return new n(this, t, e).jqDeferred.promise(a(this))
        })
    }, n.makeJQueryPlugin(), n
}),
function (t, e) {
    "function" == typeof define && define.amd ? define("jquery-bridget/jquery-bridget", ["jquery"], function (i) {
        return e(t, i)
    }) : "object" == typeof module && module.exports ? module.exports = e(t, require("jquery")) : t.jQueryBridget = e(t, t.jQuery)
}(window, function (t, e) {
    "use strict";

    function i(i, r, a) {
        function l(t, e, o) {
            var n, r = "$()." + i + '("' + e + '")';
            return t.each(function (t, l) {
                var c = a.data(l, i);
                if (!c) return void s(i + " not initialized. Cannot call methods, i.e. " + r);
                var d = c[e];
                if (!d || "_" == e.charAt(0)) return void s(r + " is not a valid method");
                var u = d.apply(c, o);
                n = void 0 === n ? u : n
            }), void 0 !== n ? n : t
        }

        function c(t, e) {
            t.each(function (t, o) {
                var n = a.data(o, i);
                n ? (n.option(e), n._init()) : (n = new r(o, e), a.data(o, i, n))
            })
        }(a = a || e || t.jQuery) && (r.prototype.option || (r.prototype.option = function (t) {
            a.isPlainObject(t) && (this.options = a.extend(!0, this.options, t))
        }), a.fn[i] = function (t) {
            if ("string" == typeof t) {
                return l(this, t, n.call(arguments, 1))
            }
            return c(this, t), this
        }, o(a))
    }

    function o(t) {
        !t || t && t.bridget || (t.bridget = i)
    }
    var n = Array.prototype.slice,
        r = t.console,
        s = void 0 === r ? function () {} : function (t) {
            r.error(t)
        };
    return o(e || t.jQuery), i
}),
function (t, e) {
    "function" == typeof define && define.amd ? define("ev-emitter/ev-emitter", e) : "object" == typeof module && module.exports ? module.exports = e() : t.EvEmitter = e()
}("undefined" != typeof window ? window : this, function () {
    function t() {}
    var e = t.prototype;
    return e.on = function (t, e) {
        if (t && e) {
            var i = this._events = this._events || {},
                o = i[t] = i[t] || [];
            return -1 == o.indexOf(e) && o.push(e), this
        }
    }, e.once = function (t, e) {
        if (t && e) {
            this.on(t, e);
            var i = this._onceEvents = this._onceEvents || {};
            return (i[t] = i[t] || {})[e] = !0, this
        }
    }, e.off = function (t, e) {
        var i = this._events && this._events[t];
        if (i && i.length) {
            var o = i.indexOf(e);
            return -1 != o && i.splice(o, 1), this
        }
    }, e.emitEvent = function (t, e) {
        var i = this._events && this._events[t];
        if (i && i.length) {
            i = i.slice(0), e = e || [];
            for (var o = this._onceEvents && this._onceEvents[t], n = 0; n < i.length; n++) {
                var r = i[n];
                o && o[r] && (this.off(t, r), delete o[r]), r.apply(this, e)
            }
            return this
        }
    }, e.allOff = function () {
        delete this._events, delete this._onceEvents
    }, t
}),
function (t, e) {
    "function" == typeof define && define.amd ? define("get-size/get-size", e) : "object" == typeof module && module.exports ? module.exports = e() : t.getSize = e()
}(window, function () {
    "use strict";

    function t(t) {
        var e = parseFloat(t);
        return -1 == t.indexOf("%") && !isNaN(e) && e
    }

    function e() {}

    function i() {
        for (var t = {
                width: 0,
                height: 0,
                innerWidth: 0,
                innerHeight: 0,
                outerWidth: 0,
                outerHeight: 0
            }, e = 0; e < c; e++) {
            t[l[e]] = 0
        }
        return t
    }

    function o(t) {
        var e = getComputedStyle(t);
        return e || a("Style returned " + e + ". Are you running this code in a hidden iframe on Firefox? See https://bit.ly/getsizebug1"), e
    }

    function n() {
        if (!d) {
            d = !0;
            var e = document.createElement("div");
            e.style.width = "200px", e.style.padding = "1px 2px 3px 4px", e.style.borderStyle = "solid", e.style.borderWidth = "1px 2px 3px 4px", e.style.boxSizing = "border-box";
            var i = document.body || document.documentElement;
            i.appendChild(e);
            var n = o(e);
            s = 200 == Math.round(t(n.width)), r.isBoxSizeOuter = s, i.removeChild(e)
        }
    }

    function r(e) {
        if (n(), "string" == typeof e && (e = document.querySelector(e)), e && "object" == typeof e && e.nodeType) {
            var r = o(e);
            if ("none" == r.display) return i();
            var a = {};
            a.width = e.offsetWidth, a.height = e.offsetHeight;
            for (var d = a.isBorderBox = "border-box" == r.boxSizing, u = 0; u < c; u++) {
                var p = l[u],
                    h = r[p],
                    f = parseFloat(h);
                a[p] = isNaN(f) ? 0 : f
            }
            var m = a.paddingLeft + a.paddingRight,
                g = a.paddingTop + a.paddingBottom,
                v = a.marginLeft + a.marginRight,
                y = a.marginTop + a.marginBottom,
                w = a.borderLeftWidth + a.borderRightWidth,
                b = a.borderTopWidth + a.borderBottomWidth,
                S = d && s,
                x = t(r.width);
            !1 !== x && (a.width = x + (S ? 0 : m + w));
            var C = t(r.height);
            return !1 !== C && (a.height = C + (S ? 0 : g + b)), a.innerWidth = a.width - (m + w), a.innerHeight = a.height - (g + b), a.outerWidth = a.width + v, a.outerHeight = a.height + y, a
        }
    }
    var s, a = "undefined" == typeof console ? e : function (t) {},
        l = ["paddingLeft", "paddingRight", "paddingTop", "paddingBottom", "marginLeft", "marginRight", "marginTop", "marginBottom", "borderLeftWidth", "borderRightWidth", "borderTopWidth", "borderBottomWidth"],
        c = l.length,
        d = !1;
    return r
}),
function (t, e) {
    "use strict";
    "function" == typeof define && define.amd ? define("desandro-matches-selector/matches-selector", e) : "object" == typeof module && module.exports ? module.exports = e() : t.matchesSelector = e()
}(window, function () {
    "use strict";
    var t = function () {
        var t = window.Element.prototype;
        if (t.matches) return "matches";
        if (t.matchesSelector) return "matchesSelector";
        for (var e = ["webkit", "moz", "ms", "o"], i = 0; i < e.length; i++) {
            var o = e[i],
                n = o + "MatchesSelector";
            if (t[n]) return n
        }
    }();
    return function (e, i) {
        return e[t](i)
    }
}),
function (t, e) {
    "function" == typeof define && define.amd ? define("fizzy-ui-utils/utils", ["desandro-matches-selector/matches-selector"], function (i) {
        return e(t, i)
    }) : "object" == typeof module && module.exports ? module.exports = e(t, require("desandro-matches-selector")) : t.fizzyUIUtils = e(t, t.matchesSelector)
}(window, function (t, e) {
    var i = {};
    i.extend = function (t, e) {
        for (var i in e) t[i] = e[i];
        return t
    }, i.modulo = function (t, e) {
        return (t % e + e) % e
    };
    var o = Array.prototype.slice;
    i.makeArray = function (t) {
        return Array.isArray(t) ? t : null === t || void 0 === t ? [] : "object" == typeof t && "number" == typeof t.length ? o.call(t) : [t]
    }, i.removeFrom = function (t, e) {
        var i = t.indexOf(e); - 1 != i && t.splice(i, 1)
    }, i.getParent = function (t, i) {
        for (; t.parentNode && t != document.body;)
            if (t = t.parentNode, e(t, i)) return t
    }, i.getQueryElement = function (t) {
        return "string" == typeof t ? document.querySelector(t) : t
    }, i.handleEvent = function (t) {
        var e = "on" + t.type;
        this[e] && this[e](t)
    }, i.filterFindElements = function (t, o) {
        t = i.makeArray(t);
        var n = [];
        return t.forEach(function (t) {
            if (t instanceof HTMLElement) {
                if (!o) return void n.push(t);
                e(t, o) && n.push(t);
                for (var i = t.querySelectorAll(o), r = 0; r < i.length; r++) n.push(i[r])
            }
        }), n
    }, i.debounceMethod = function (t, e, i) {
        i = i || 100;
        var o = t.prototype[e],
            n = e + "Timeout";
        t.prototype[e] = function () {
            var t = this[n];
            clearTimeout(t);
            var e = arguments,
                r = this;
            this[n] = setTimeout(function () {
                o.apply(r, e), delete r[n]
            }, i)
        }
    }, i.docReady = function (t) {
        var e = document.readyState;
        "complete" == e || "interactive" == e ? setTimeout(t) : document.addEventListener("DOMContentLoaded", t)
    }, i.toDashed = function (t) {
        return t.replace(/(.)([A-Z])/g, function (t, e, i) {
            return e + "-" + i
        }).toLowerCase()
    };
    var n = t.console;
    return i.htmlInit = function (e, o) {
        i.docReady(function () {
            var r = i.toDashed(o),
                s = "data-" + r,
                a = document.querySelectorAll("[" + s + "]"),
                l = document.querySelectorAll(".js-" + r),
                c = i.makeArray(a).concat(i.makeArray(l)),
                d = s + "-options",
                u = t.jQuery;
            c.forEach(function (t) {
                var i, r = t.getAttribute(s) || t.getAttribute(d);
                try {
                    i = r && JSON.parse(r)
                } catch (e) {
                    return void(n && n.error("Error parsing " + s + " on " + t.className + ": " + e))
                }
                var a = new e(t, i);
                u && u.data(t, o, a)
            })
        })
    }, i
}),
function (t, e) {
    "function" == typeof define && define.amd ? define("outlayer/item", ["ev-emitter/ev-emitter", "get-size/get-size"], e) : "object" == typeof module && module.exports ? module.exports = e(require("ev-emitter"), require("get-size")) : (t.Outlayer = {}, t.Outlayer.Item = e(t.EvEmitter, t.getSize))
}(window, function (t, e) {
    "use strict";

    function i(t) {
        for (var e in t) return !1;
        return null, !0
    }

    function o(t, e) {
        t && (this.element = t, this.layout = e, this.position = {
            x: 0,
            y: 0
        }, this._create())
    }
    var n = document.documentElement.style,
        r = "string" == typeof n.transition ? "transition" : "WebkitTransition",
        s = "string" == typeof n.transform ? "transform" : "WebkitTransform",
        a = {
            WebkitTransition: "webkitTransitionEnd",
            transition: "transitionend"
        } [r],
        l = {
            transform: s,
            transition: r,
            transitionDuration: r + "Duration",
            transitionProperty: r + "Property",
            transitionDelay: r + "Delay"
        },
        c = o.prototype = Object.create(t.prototype);
    c.constructor = o, c._create = function () {
        this._transn = {
            ingProperties: {},
            clean: {},
            onEnd: {}
        }, this.css({
            position: "absolute"
        })
    }, c.handleEvent = function (t) {
        var e = "on" + t.type;
        this[e] && this[e](t)
    }, c.getSize = function () {
        this.size = e(this.element)
    }, c.css = function (t) {
        var e = this.element.style;
        for (var i in t) {
            e[l[i] || i] = t[i]
        }
    }, c.getPosition = function () {
        var t = getComputedStyle(this.element),
            e = this.layout._getOption("originLeft"),
            i = this.layout._getOption("originTop"),
            o = t[e ? "left" : "right"],
            n = t[i ? "top" : "bottom"],
            r = parseFloat(o),
            s = parseFloat(n),
            a = this.layout.size; - 1 != o.indexOf("%") && (r = r / 100 * a.width), -1 != n.indexOf("%") && (s = s / 100 * a.height), r = isNaN(r) ? 0 : r, s = isNaN(s) ? 0 : s, r -= e ? a.paddingLeft : a.paddingRight, s -= i ? a.paddingTop : a.paddingBottom, this.position.x = r, this.position.y = s
    }, c.layoutPosition = function () {
        var t = this.layout.size,
            e = {},
            i = this.layout._getOption("originLeft"),
            o = this.layout._getOption("originTop"),
            n = i ? "paddingLeft" : "paddingRight",
            r = i ? "left" : "right",
            s = i ? "right" : "left",
            a = this.position.x + t[n];
        e[r] = this.getXValue(a), e[s] = "";
        var l = o ? "paddingTop" : "paddingBottom",
            c = o ? "top" : "bottom",
            d = o ? "bottom" : "top",
            u = this.position.y + t[l];
        e[c] = this.getYValue(u), e[d] = "", this.css(e), this.emitEvent("layout", [this])
    }, c.getXValue = function (t) {
        var e = this.layout._getOption("horizontal");
        return this.layout.options.percentPosition && !e ? t / this.layout.size.width * 100 + "%" : t + "px"
    }, c.getYValue = function (t) {
        var e = this.layout._getOption("horizontal");
        return this.layout.options.percentPosition && e ? t / this.layout.size.height * 100 + "%" : t + "px"
    }, c._transitionTo = function (t, e) {
        this.getPosition();
        var i = this.position.x,
            o = this.position.y,
            n = t == this.position.x && e == this.position.y;
        if (this.setPosition(t, e), n && !this.isTransitioning) return void this.layoutPosition();
        var r = t - i,
            s = e - o,
            a = {};
        a.transform = this.getTranslate(r, s), this.transition({
            to: a,
            onTransitionEnd: {
                transform: this.layoutPosition
            },
            isCleaning: !0
        })
    }, c.getTranslate = function (t, e) {
        var i = this.layout._getOption("originLeft"),
            o = this.layout._getOption("originTop");
        return t = i ? t : -t, e = o ? e : -e, "translate3d(" + t + "px, " + e + "px, 0)"
    }, c.goTo = function (t, e) {
        this.setPosition(t, e), this.layoutPosition()
    }, c.moveTo = c._transitionTo, c.setPosition = function (t, e) {
        this.position.x = parseFloat(t), this.position.y = parseFloat(e)
    }, c._nonTransition = function (t) {
        this.css(t.to), t.isCleaning && this._removeStyles(t.to);
        for (var e in t.onTransitionEnd) t.onTransitionEnd[e].call(this)
    }, c.transition = function (t) {
        if (!parseFloat(this.layout.options.transitionDuration)) return void this._nonTransition(t);
        var e = this._transn;
        for (var i in t.onTransitionEnd) e.onEnd[i] = t.onTransitionEnd[i];
        for (i in t.to) e.ingProperties[i] = !0, t.isCleaning && (e.clean[i] = !0);
        if (t.from) {
            this.css(t.from);
            this.element.offsetHeight;
            null
        }
        this.enableTransition(t.to), this.css(t.to), this.isTransitioning = !0
    };
    var d = "opacity," + function (t) {
        return t.replace(/([A-Z])/g, function (t) {
            return "-" + t.toLowerCase()
        })
    }(s);
    c.enableTransition = function () {
        if (!this.isTransitioning) {
            var t = this.layout.options.transitionDuration;
            t = "number" == typeof t ? t + "ms" : t, this.css({
                transitionProperty: d,
                transitionDuration: t,
                transitionDelay: this.staggerDelay || 0
            }), this.element.addEventListener(a, this, !1)
        }
    }, c.onwebkitTransitionEnd = function (t) {
        this.ontransitionend(t)
    }, c.onotransitionend = function (t) {
        this.ontransitionend(t)
    };
    var u = {
        "-webkit-transform": "transform"
    };
    c.ontransitionend = function (t) {
        if (t.target === this.element) {
            var e = this._transn,
                o = u[t.propertyName] || t.propertyName;
            if (delete e.ingProperties[o], i(e.ingProperties) && this.disableTransition(), o in e.clean && (this.element.style[t.propertyName] = "", delete e.clean[o]), o in e.onEnd) {
                e.onEnd[o].call(this), delete e.onEnd[o]
            }
            this.emitEvent("transitionEnd", [this])
        }
    }, c.disableTransition = function () {
        this.removeTransitionStyles(), this.element.removeEventListener(a, this, !1), this.isTransitioning = !1
    }, c._removeStyles = function (t) {
        var e = {};
        for (var i in t) e[i] = "";
        this.css(e)
    };
    var p = {
        transitionProperty: "",
        transitionDuration: "",
        transitionDelay: ""
    };
    return c.removeTransitionStyles = function () {
        this.css(p)
    }, c.stagger = function (t) {
        t = isNaN(t) ? 0 : t, this.staggerDelay = t + "ms"
    }, c.removeElem = function () {
        this.element.parentNode.removeChild(this.element), this.css({
            display: ""
        }), this.emitEvent("remove", [this])
    }, c.remove = function () {
        if (!r || !parseFloat(this.layout.options.transitionDuration)) return void this.removeElem();
        this.once("transitionEnd", function () {
            this.removeElem()
        }), this.hide()
    }, c.reveal = function () {
        delete this.isHidden, this.css({
            display: ""
        });
        var t = this.layout.options,
            e = {};
        e[this.getHideRevealTransitionEndProperty("visibleStyle")] = this.onRevealTransitionEnd, this.transition({
            from: t.hiddenStyle,
            to: t.visibleStyle,
            isCleaning: !0,
            onTransitionEnd: e
        })
    }, c.onRevealTransitionEnd = function () {
        this.isHidden || this.emitEvent("reveal")
    }, c.getHideRevealTransitionEndProperty = function (t) {
        var e = this.layout.options[t];
        if (e.opacity) return "opacity";
        for (var i in e) return i
    }, c.hide = function () {
        this.isHidden = !0, this.css({
            display: ""
        });
        var t = this.layout.options,
            e = {};
        e[this.getHideRevealTransitionEndProperty("hiddenStyle")] = this.onHideTransitionEnd, this.transition({
            from: t.visibleStyle,
            to: t.hiddenStyle,
            isCleaning: !0,
            onTransitionEnd: e
        })
    }, c.onHideTransitionEnd = function () {
        this.isHidden && (this.css({
            display: "none"
        }), this.emitEvent("hide"))
    }, c.destroy = function () {
        this.css({
            position: "",
            left: "",
            right: "",
            top: "",
            bottom: "",
            transition: "",
            transform: ""
        })
    }, o
}),
function (t, e) {
    "use strict";
    "function" == typeof define && define.amd ? define("outlayer/outlayer", ["ev-emitter/ev-emitter", "get-size/get-size", "fizzy-ui-utils/utils", "./item"], function (i, o, n, r) {
        return e(t, i, o, n, r)
    }) : "object" == typeof module && module.exports ? module.exports = e(t, require("ev-emitter"), require("get-size"), require("fizzy-ui-utils"), require("./item")) : t.Outlayer = e(t, t.EvEmitter, t.getSize, t.fizzyUIUtils, t.Outlayer.Item)
}(window, function (t, e, i, o, n) {
    "use strict";

    function r(t, e) {
        var i = o.getQueryElement(t);
        if (!i) return void(l && l.error("Bad element for " + this.constructor.namespace + ": " + (i || t)));
        this.element = i, c && (this.$element = c(this.element)), this.options = o.extend({}, this.constructor.defaults), this.option(e);
        var n = ++u;
        this.element.outlayerGUID = n, p[n] = this, this._create(), this._getOption("initLayout") && this.layout()
    }

    function s(t) {
        function e() {
            t.apply(this, arguments)
        }
        return e.prototype = Object.create(t.prototype), e.prototype.constructor = e, e
    }

    function a(t) {
        if ("number" == typeof t) return t;
        var e = t.match(/(^\d*\.?\d*)(\w*)/),
            i = e && e[1],
            o = e && e[2];
        return i.length ? (i = parseFloat(i)) * (f[o] || 1) : 0
    }
    var l = t.console,
        c = t.jQuery,
        d = function () {},
        u = 0,
        p = {};
    r.namespace = "outlayer", r.Item = n, r.defaults = {
        containerStyle: {
            position: "relative"
        },
        initLayout: !0,
        originLeft: !0,
        originTop: !0,
        resize: !0,
        resizeContainer: !0,
        transitionDuration: "0.4s",
        hiddenStyle: {
            opacity: 0,
            transform: "scale(0.001)"
        },
        visibleStyle: {
            opacity: 1,
            transform: "scale(1)"
        }
    };
    var h = r.prototype;
    o.extend(h, e.prototype), h.option = function (t) {
        o.extend(this.options, t)
    }, h._getOption = function (t) {
        var e = this.constructor.compatOptions[t];
        return e && void 0 !== this.options[e] ? this.options[e] : this.options[t]
    }, r.compatOptions = {
        initLayout: "isInitLayout",
        horizontal: "isHorizontal",
        layoutInstant: "isLayoutInstant",
        originLeft: "isOriginLeft",
        originTop: "isOriginTop",
        resize: "isResizeBound",
        resizeContainer: "isResizingContainer"
    }, h._create = function () {
        this.reloadItems(), this.stamps = [], this.stamp(this.options.stamp), o.extend(this.element.style, this.options.containerStyle), this._getOption("resize") && this.bindResize()
    }, h.reloadItems = function () {
        this.items = this._itemize(this.element.children)
    }, h._itemize = function (t) {
        for (var e = this._filterFindItemElements(t), i = this.constructor.Item, o = [], n = 0; n < e.length; n++) {
            var r = e[n],
                s = new i(r, this);
            o.push(s)
        }
        return o
    }, h._filterFindItemElements = function (t) {
        return o.filterFindElements(t, this.options.itemSelector)
    }, h.getItemElements = function () {
        return this.items.map(function (t) {
            return t.element
        })
    }, h.layout = function () {
        this._resetLayout(), this._manageStamps();
        var t = this._getOption("layoutInstant"),
            e = void 0 !== t ? t : !this._isLayoutInited;
        this.layoutItems(this.items, e), this._isLayoutInited = !0
    }, h._init = h.layout, h._resetLayout = function () {
        this.getSize()
    }, h.getSize = function () {
        this.size = i(this.element)
    }, h._getMeasurement = function (t, e) {
        var o, n = this.options[t];
        n ? ("string" == typeof n ? o = this.element.querySelector(n) : n instanceof HTMLElement && (o = n), this[t] = o ? i(o)[e] : n) : this[t] = 0
    }, h.layoutItems = function (t, e) {
        t = this._getItemsForLayout(t), this._layoutItems(t, e), this._postLayout()
    }, h._getItemsForLayout = function (t) {
        return t.filter(function (t) {
            return !t.isIgnored
        })
    }, h._layoutItems = function (t, e) {
        if (this._emitCompleteOnItems("layout", t), t && t.length) {
            var i = [];
            t.forEach(function (t) {
                var o = this._getItemLayoutPosition(t);
                o.item = t, o.isInstant = e || t.isLayoutInstant, i.push(o)
            }, this), this._processLayoutQueue(i)
        }
    }, h._getItemLayoutPosition = function () {
        return {
            x: 0,
            y: 0
        }
    }, h._processLayoutQueue = function (t) {
        this.updateStagger(), t.forEach(function (t, e) {
            this._positionItem(t.item, t.x, t.y, t.isInstant, e)
        }, this)
    }, h.updateStagger = function () {
        var t = this.options.stagger;
        return null === t || void 0 === t ? void(this.stagger = 0) : (this.stagger = a(t), this.stagger)
    }, h._positionItem = function (t, e, i, o, n) {
        o ? t.goTo(e, i) : (t.stagger(n * this.stagger), t.moveTo(e, i))
    }, h._postLayout = function () {
        this.resizeContainer()
    }, h.resizeContainer = function () {
        if (this._getOption("resizeContainer")) {
            var t = this._getContainerSize();
            t && (this._setContainerMeasure(t.width, !0), this._setContainerMeasure(t.height, !1))
        }
    }, h._getContainerSize = d, h._setContainerMeasure = function (t, e) {
        if (void 0 !== t) {
            var i = this.size;
            i.isBorderBox && (t += e ? i.paddingLeft + i.paddingRight + i.borderLeftWidth + i.borderRightWidth : i.paddingBottom + i.paddingTop + i.borderTopWidth + i.borderBottomWidth), t = Math.max(t, 0), this.element.style[e ? "width" : "height"] = t + "px"
        }
    }, h._emitCompleteOnItems = function (t, e) {
        function i() {
            n.dispatchEvent(t + "Complete", null, [e])
        }

        function o() {
            ++s == r && i()
        }
        var n = this,
            r = e.length;
        if (!e || !r) return void i();
        var s = 0;
        e.forEach(function (e) {
            e.once(t, o)
        })
    }, h.dispatchEvent = function (t, e, i) {
        var o = e ? [e].concat(i) : i;
        if (this.emitEvent(t, o), c)
            if (this.$element = this.$element || c(this.element), e) {
                var n = c.Event(e);
                n.type = t, this.$element.trigger(n, i)
            } else this.$element.trigger(t, i)
    }, h.ignore = function (t) {
        var e = this.getItem(t);
        e && (e.isIgnored = !0)
    }, h.unignore = function (t) {
        var e = this.getItem(t);
        e && delete e.isIgnored
    }, h.stamp = function (t) {
        (t = this._find(t)) && (this.stamps = this.stamps.concat(t), t.forEach(this.ignore, this))
    }, h.unstamp = function (t) {
        (t = this._find(t)) && t.forEach(function (t) {
            o.removeFrom(this.stamps, t), this.unignore(t)
        }, this)
    }, h._find = function (t) {
        if (t) return "string" == typeof t && (t = this.element.querySelectorAll(t)), t = o.makeArray(t)
    }, h._manageStamps = function () {
        this.stamps && this.stamps.length && (this._getBoundingRect(), this.stamps.forEach(this._manageStamp, this))
    }, h._getBoundingRect = function () {
        var t = this.element.getBoundingClientRect(),
            e = this.size;
        this._boundingRect = {
            left: t.left + e.paddingLeft + e.borderLeftWidth,
            top: t.top + e.paddingTop + e.borderTopWidth,
            right: t.right - (e.paddingRight + e.borderRightWidth),
            bottom: t.bottom - (e.paddingBottom + e.borderBottomWidth)
        }
    }, h._manageStamp = d, h._getElementOffset = function (t) {
        var e = t.getBoundingClientRect(),
            o = this._boundingRect,
            n = i(t);
        return {
            left: e.left - o.left - n.marginLeft,
            top: e.top - o.top - n.marginTop,
            right: o.right - e.right - n.marginRight,
            bottom: o.bottom - e.bottom - n.marginBottom
        }
    }, h.handleEvent = o.handleEvent, h.bindResize = function () {
        t.addEventListener("resize", this), this.isResizeBound = !0
    }, h.unbindResize = function () {
        t.removeEventListener("resize", this), this.isResizeBound = !1
    }, h.onresize = function () {
        this.resize()
    }, o.debounceMethod(r, "onresize", 100), h.resize = function () {
        this.isResizeBound && this.needsResizeLayout() && this.layout()
    }, h.needsResizeLayout = function () {
        var t = i(this.element);
        return this.size && t && t.innerWidth !== this.size.innerWidth
    }, h.addItems = function (t) {
        var e = this._itemize(t);
        return e.length && (this.items = this.items.concat(e)), e
    }, h.appended = function (t) {
        var e = this.addItems(t);
        e.length && (this.layoutItems(e, !0), this.reveal(e))
    }, h.prepended = function (t) {
        var e = this._itemize(t);
        if (e.length) {
            var i = this.items.slice(0);
            this.items = e.concat(i), this._resetLayout(), this._manageStamps(), this.layoutItems(e, !0), this.reveal(e), this.layoutItems(i)
        }
    }, h.reveal = function (t) {
        if (this._emitCompleteOnItems("reveal", t), t && t.length) {
            var e = this.updateStagger();
            t.forEach(function (t, i) {
                t.stagger(i * e), t.reveal()
            })
        }
    }, h.hide = function (t) {
        if (this._emitCompleteOnItems("hide", t), t && t.length) {
            var e = this.updateStagger();
            t.forEach(function (t, i) {
                t.stagger(i * e), t.hide()
            })
        }
    }, h.revealItemElements = function (t) {
        var e = this.getItems(t);
        this.reveal(e)
    }, h.hideItemElements = function (t) {
        var e = this.getItems(t);
        this.hide(e)
    }, h.getItem = function (t) {
        for (var e = 0; e < this.items.length; e++) {
            var i = this.items[e];
            if (i.element == t) return i
        }
    }, h.getItems = function (t) {
        t = o.makeArray(t);
        var e = [];
        return t.forEach(function (t) {
            var i = this.getItem(t);
            i && e.push(i)
        }, this), e
    }, h.remove = function (t) {
        var e = this.getItems(t);
        this._emitCompleteOnItems("remove", e), e && e.length && e.forEach(function (t) {
            t.remove(), o.removeFrom(this.items, t)
        }, this)
    }, h.destroy = function () {
        var t = this.element.style;
        t.height = "", t.position = "", t.width = "", this.items.forEach(function (t) {
            t.destroy()
        }), this.unbindResize();
        var e = this.element.outlayerGUID;
        delete p[e], delete this.element.outlayerGUID, c && c.removeData(this.element, this.constructor.namespace)
    }, r.data = function (t) {
        t = o.getQueryElement(t);
        var e = t && t.outlayerGUID;
        return e && p[e]
    }, r.create = function (t, e) {
        var i = s(r);
        return i.defaults = o.extend({}, r.defaults), o.extend(i.defaults, e), i.compatOptions = o.extend({}, r.compatOptions), i.namespace = t, i.data = r.data, i.Item = s(n), o.htmlInit(i, t), c && c.bridget && c.bridget(t, i), i
    };
    var f = {
        ms: 1,
        s: 1e3
    };
    return r.Item = n, r
}),
function (t, e) {
    "function" == typeof define && define.amd ? define(["outlayer/outlayer", "get-size/get-size"], e) : "object" == typeof module && module.exports ? module.exports = e(require("outlayer"), require("get-size")) : t.Masonry = e(t.Outlayer, t.getSize)
}(window, function (t, e) {
    var i = t.create("masonry");
    i.compatOptions.fitWidth = "isFitWidth";
    var o = i.prototype;
    return o._resetLayout = function () {
        this.getSize(), this._getMeasurement("columnWidth", "outerWidth"), this._getMeasurement("gutter", "outerWidth"), this.measureColumns(), this.colYs = [];
        for (var t = 0; t < this.cols; t++) this.colYs.push(0);
        this.maxY = 0, this.horizontalColIndex = 0
    }, o.measureColumns = function () {
        if (this.getContainerWidth(), !this.columnWidth) {
            var t = this.items[0],
                i = t && t.element;
            this.columnWidth = i && e(i).outerWidth || this.containerWidth
        }
        var o = this.columnWidth += this.gutter,
            n = this.containerWidth + this.gutter,
            r = n / o,
            s = o - n % o,
            a = s && s < 1 ? "round" : "floor";
        r = Math[a](r), this.cols = Math.max(r, 1)
    }, o.getContainerWidth = function () {
        var t = this._getOption("fitWidth"),
            i = t ? this.element.parentNode : this.element,
            o = e(i);
        this.containerWidth = o && o.innerWidth
    }, o._getItemLayoutPosition = function (t) {
        t.getSize();
        var e = t.size.outerWidth % this.columnWidth,
            i = e && e < 1 ? "round" : "ceil",
            o = Math[i](t.size.outerWidth / this.columnWidth);
        o = Math.min(o, this.cols);
        for (var n = this.options.horizontalOrder ? "_getHorizontalColPosition" : "_getTopColPosition", r = this[n](o, t), s = {
                x: this.columnWidth * r.col,
                y: r.y
            }, a = r.y + t.size.outerHeight, l = o + r.col, c = r.col; c < l; c++) this.colYs[c] = a;
        return s
    }, o._getTopColPosition = function (t) {
        var e = this._getTopColGroup(t),
            i = Math.min.apply(Math, e);
        return {
            col: e.indexOf(i),
            y: i
        }
    }, o._getTopColGroup = function (t) {
        if (t < 2) return this.colYs;
        for (var e = [], i = this.cols + 1 - t, o = 0; o < i; o++) e[o] = this._getColGroupY(o, t);
        return e
    }, o._getColGroupY = function (t, e) {
        if (e < 2) return this.colYs[t];
        var i = this.colYs.slice(t, t + e);
        return Math.max.apply(Math, i)
    }, o._getHorizontalColPosition = function (t, e) {
        var i = this.horizontalColIndex % this.cols;
        i = t > 1 && i + t > this.cols ? 0 : i;
        var o = e.size.outerWidth && e.size.outerHeight;
        return this.horizontalColIndex = o ? i + t : this.horizontalColIndex, {
            col: i,
            y: this._getColGroupY(i, t)
        }
    }, o._manageStamp = function (t) {
        var i = e(t),
            o = this._getElementOffset(t),
            n = this._getOption("originLeft"),
            r = n ? o.left : o.right,
            s = r + i.outerWidth,
            a = Math.floor(r / this.columnWidth);
        a = Math.max(0, a);
        var l = Math.floor(s / this.columnWidth);
        l -= s % this.columnWidth ? 0 : 1, l = Math.min(this.cols - 1, l);
        for (var c = this._getOption("originTop"), d = (c ? o.top : o.bottom) + i.outerHeight, u = a; u <= l; u++) this.colYs[u] = Math.max(d, this.colYs[u])
    }, o._getContainerSize = function () {
        this.maxY = Math.max.apply(Math, this.colYs);
        var t = {
            height: this.maxY
        };
        return this._getOption("fitWidth") && (t.width = this._getContainerFitWidth()), t
    }, o._getContainerFitWidth = function () {
        for (var t = 0, e = this.cols; --e && 0 === this.colYs[e];) t++;
        return (this.cols - t) * this.columnWidth - this.gutter
    }, o.needsResizeLayout = function () {
        var t = this.containerWidth;
        return this.getContainerWidth(), t != this.containerWidth
    }, i
}),
function (t) {
    "function" == typeof define && define.amd ? define(["jquery"], t) : t("object" == typeof exports ? require("jquery") : window.jQuery || window.Zepto)
}(function (t) {
    var e, i, o, n, r, s, a = function () {},
        l = !!window.jQuery,
        c = t(window),
        d = function (t, i) {
            e.ev.on("mfp" + t + ".mfp", i)
        },
        u = function (e, i, o, n) {
            var r = document.createElement("div");
            return r.className = "mfp-" + e, o && (r.innerHTML = o), n ? i && i.appendChild(r) : (r = t(r), i && r.appendTo(i)), r
        },
        p = function (i, o) {
            e.ev.triggerHandler("mfp" + i, o), e.st.callbacks && (i = i.charAt(0).toLowerCase() + i.slice(1), e.st.callbacks[i] && e.st.callbacks[i].apply(e, t.isArray(o) ? o : [o]))
        },
        h = function (i) {
            return i === s && e.currTemplate.closeBtn || (e.currTemplate.closeBtn = t(e.st.closeMarkup.replace("%title%", e.st.tClose)), s = i), e.currTemplate.closeBtn
        },
        f = function () {
            t.magnificPopup.instance || (e = new a, e.init(), t.magnificPopup.instance = e)
        },
        m = function () {
            var t = document.createElement("p").style,
                e = ["ms", "O", "Moz", "Webkit"];
            if (void 0 !== t.transition) return !0;
            for (; e.length;)
                if (e.pop() + "Transition" in t) return !0;
            return !1
        };
    a.prototype = {
        constructor: a,
        init: function () {
            var i = navigator.appVersion;
            e.isLowIE = e.isIE8 = document.all && !document.addEventListener, e.isAndroid = /android/gi.test(i), e.isIOS = /iphone|ipad|ipod/gi.test(i), e.supportsTransition = m(), e.probablyMobile = e.isAndroid || e.isIOS || /(Opera Mini)|Kindle|webOS|BlackBerry|(Opera Mobi)|(Windows Phone)|IEMobile/i.test(navigator.userAgent), o = t(document), e.popupsCache = {}
        },
        open: function (i) {
            var n;
            if (!1 === i.isObj) {
                e.items = i.items.toArray(), e.index = 0;
                var s, a = i.items;
                for (n = 0; n < a.length; n++)
                    if (s = a[n], s.parsed && (s = s.el[0]), s === i.el[0]) {
                        e.index = n;
                        break
                    }
            } else e.items = t.isArray(i.items) ? i.items : [i.items], e.index = i.index || 0;
            if (e.isOpen) return void e.updateItemHTML();
            e.types = [], r = "", i.mainEl && i.mainEl.length ? e.ev = i.mainEl.eq(0) : e.ev = o, i.key ? (e.popupsCache[i.key] || (e.popupsCache[i.key] = {}), e.currTemplate = e.popupsCache[i.key]) : e.currTemplate = {}, e.st = t.extend(!0, {}, t.magnificPopup.defaults, i), e.fixedContentPos = "auto" === e.st.fixedContentPos ? !e.probablyMobile : e.st.fixedContentPos, e.st.modal && (e.st.closeOnContentClick = !1, e.st.closeOnBgClick = !1, e.st.showCloseBtn = !1, e.st.enableEscapeKey = !1), e.bgOverlay || (e.bgOverlay = u("bg").on("click.mfp", function () {
                e.close()
            }), e.wrap = u("wrap").attr("tabindex", -1).on("click.mfp", function (t) {
                e._checkIfClose(t.target) && e.close()
            }), e.container = u("container", e.wrap)), e.contentContainer = u("content"), e.st.preloader && (e.preloader = u("preloader", e.container, e.st.tLoading));
            var l = t.magnificPopup.modules;
            for (n = 0; n < l.length; n++) {
                var f = l[n];
                f = f.charAt(0).toUpperCase() + f.slice(1), e["init" + f].call(e)
            }
            p("BeforeOpen"), e.st.showCloseBtn && (e.st.closeBtnInside ? (d("MarkupParse", function (t, e, i, o) {
                i.close_replaceWith = h(o.type)
            }), r += " mfp-close-btn-in") : e.wrap.append(h())), e.st.alignTop && (r += " mfp-align-top"), e.fixedContentPos ? e.wrap.css({
                overflow: e.st.overflowY,
                overflowX: "hidden",
                overflowY: e.st.overflowY
            }) : e.wrap.css({
                top: c.scrollTop(),
                position: "absolute"
            }), (!1 === e.st.fixedBgPos || "auto" === e.st.fixedBgPos && !e.fixedContentPos) && e.bgOverlay.css({
                height: o.height(),
                position: "absolute"
            }), e.st.enableEscapeKey && o.on("keyup.mfp", function (t) {
                27 === t.keyCode && e.close()
            }), c.on("resize.mfp", function () {
                e.updateSize()
            }), e.st.closeOnContentClick || (r += " mfp-auto-cursor"), r && e.wrap.addClass(r);
            var m = e.wH = c.height(),
                g = {};
            if (e.fixedContentPos && e._hasScrollBar(m)) {
                var v = e._getScrollbarSize();
                v && (g.marginRight = v)
            }
            e.fixedContentPos && (e.isIE7 ? t("body, html").css("overflow", "hidden") : g.overflow = "hidden");
            var y = e.st.mainClass;
            return e.isIE7 && (y += " mfp-ie7"), y && e._addClassToMFP(y), e.updateItemHTML(), p("BuildControls"), t("html").css(g), e.bgOverlay.add(e.wrap).prependTo(e.st.prependTo || t(document.body)), e._lastFocusedEl = document.activeElement, setTimeout(function () {
                e.content ? (e._addClassToMFP("mfp-ready"), e._setFocus()) : e.bgOverlay.addClass("mfp-ready"), o.on("focusin.mfp", e._onFocusIn)
            }, 16), e.isOpen = !0, e.updateSize(m), p("Open"), i
        },
        close: function () {
            e.isOpen && (p("BeforeClose"), e.isOpen = !1, e.st.removalDelay && !e.isLowIE && e.supportsTransition ? (e._addClassToMFP("mfp-removing"), setTimeout(function () {
                e._close()
            }, e.st.removalDelay)) : e._close())
        },
        _close: function () {
            p("Close");
            var i = "mfp-removing mfp-ready ";
            if (e.bgOverlay.detach(), e.wrap.detach(), e.container.empty(), e.st.mainClass && (i += e.st.mainClass + " "), e._removeClassFromMFP(i), e.fixedContentPos) {
                var n = {
                    marginRight: ""
                };
                e.isIE7 ? t("body, html").css("overflow", "") : n.overflow = "", t("html").css(n)
            }
            o.off("keyup.mfp focusin.mfp"), e.ev.off(".mfp"), e.wrap.attr("class", "mfp-wrap").removeAttr("style"), e.bgOverlay.attr("class", "mfp-bg"), e.container.attr("class", "mfp-container"), !e.st.showCloseBtn || e.st.closeBtnInside && !0 !== e.currTemplate[e.currItem.type] || e.currTemplate.closeBtn && e.currTemplate.closeBtn.detach(), e.st.autoFocusLast && e._lastFocusedEl && t(e._lastFocusedEl).focus(), e.currItem = null, e.content = null, e.currTemplate = null, e.prevHeight = 0, p("AfterClose")
        },
        updateSize: function (t) {
            if (e.isIOS) {
                var i = document.documentElement.clientWidth / window.innerWidth,
                    o = window.innerHeight * i;
                e.wrap.css("height", o), e.wH = o
            } else e.wH = t || c.height();
            e.fixedContentPos || e.wrap.css("height", e.wH), p("Resize")
        },
        updateItemHTML: function () {
            var i = e.items[e.index];
            e.contentContainer.detach(), e.content && e.content.detach(), i.parsed || (i = e.parseEl(e.index));
            var o = i.type;
            if (p("BeforeChange", [e.currItem ? e.currItem.type : "", o]), e.currItem = i, !e.currTemplate[o]) {
                var r = !!e.st[o] && e.st[o].markup;
                p("FirstMarkupParse", r), e.currTemplate[o] = !r || t(r)
            }
            n && n !== i.type && e.container.removeClass("mfp-" + n + "-holder");
            var s = e["get" + o.charAt(0).toUpperCase() + o.slice(1)](i, e.currTemplate[o]);
            e.appendContent(s, o), i.preloaded = !0, p("Change", i), n = i.type, e.container.prepend(e.contentContainer), p("AfterChange")
        },
        appendContent: function (t, i) {
            e.content = t, t ? e.st.showCloseBtn && e.st.closeBtnInside && !0 === e.currTemplate[i] ? e.content.find(".mfp-close").length || e.content.append(h()) : e.content = t : e.content = "", p("BeforeAppend"), e.container.addClass("mfp-" + i + "-holder"), e.contentContainer.append(e.content)
        },
        parseEl: function (i) {
            var o, n = e.items[i];
            if (n.tagName ? n = {
                    el: t(n)
                } : (o = n.type, n = {
                    data: n,
                    src: n.src
                }), n.el) {
                for (var r = e.types, s = 0; s < r.length; s++)
                    if (n.el.hasClass("mfp-" + r[s])) {
                        o = r[s];
                        break
                    } n.src = n.el.attr("data-mfp-src"), n.src || (n.src = n.el.attr("href"))
            }
            return n.type = o || e.st.type || "inline", n.index = i, n.parsed = !0, e.items[i] = n, p("ElementParse", n), e.items[i]
        },
        addGroup: function (t, i) {
            var o = function (o) {
                o.mfpEl = this, e._openClick(o, t, i)
            };
            i || (i = {});
            var n = "click.magnificPopup";
            i.mainEl = t, i.items ? (i.isObj = !0, t.off(n).on(n, o)) : (i.isObj = !1, i.delegate ? t.off(n).on(n, i.delegate, o) : (i.items = t, t.off(n).on(n, o)))
        },
        _openClick: function (i, o, n) {
            if ((void 0 !== n.midClick ? n.midClick : t.magnificPopup.defaults.midClick) || !(2 === i.which || i.ctrlKey || i.metaKey || i.altKey || i.shiftKey)) {
                var r = void 0 !== n.disableOn ? n.disableOn : t.magnificPopup.defaults.disableOn;
                if (r)
                    if (t.isFunction(r)) {
                        if (!r.call(e)) return !0
                    } else if (c.width() < r) return !0;
                i.type && (i.preventDefault(), e.isOpen && i.stopPropagation()), n.el = t(i.mfpEl), n.delegate && (n.items = o.find(n.delegate)), e.open(n)
            }
        },
        updateStatus: function (t, o) {
            if (e.preloader) {
                i !== t && e.container.removeClass("mfp-s-" + i), o || "loading" !== t || (o = e.st.tLoading);
                var n = {
                    status: t,
                    text: o
                };
                p("UpdateStatus", n), t = n.status, o = n.text, e.preloader.html(o), e.preloader.find("a").on("click", function (t) {
                    t.stopImmediatePropagation()
                }), e.container.addClass("mfp-s-" + t), i = t
            }
        },
        _checkIfClose: function (i) {
            if (!t(i).hasClass("mfp-prevent-close")) {
                var o = e.st.closeOnContentClick,
                    n = e.st.closeOnBgClick;
                if (o && n) return !0;
                if (!e.content || t(i).hasClass("mfp-close") || e.preloader && i === e.preloader[0]) return !0;
                if (i === e.content[0] || t.contains(e.content[0], i)) {
                    if (o) return !0
                } else if (n && t.contains(document, i)) return !0;
                return !1
            }
        },
        _addClassToMFP: function (t) {
            e.bgOverlay.addClass(t), e.wrap.addClass(t)
        },
        _removeClassFromMFP: function (t) {
            this.bgOverlay.removeClass(t), e.wrap.removeClass(t)
        },
        _hasScrollBar: function (t) {
            return (e.isIE7 ? o.height() : document.body.scrollHeight) > (t || c.height())
        },
        _setFocus: function () {
            (e.st.focus ? e.content.find(e.st.focus).eq(0) : e.wrap).focus()
        },
        _onFocusIn: function (i) {
            if (i.target !== e.wrap[0] && !t.contains(e.wrap[0], i.target)) return e._setFocus(), !1
        },
        _parseMarkup: function (e, i, o) {
            var n;
            o.data && (i = t.extend(o.data, i)), p("MarkupParse", [e, i, o]), t.each(i, function (i, o) {
                if (void 0 === o || !1 === o) return !0;
                if (n = i.split("_"), n.length > 1) {
                    var r = e.find(".mfp-" + n[0]);
                    if (r.length > 0) {
                        var s = n[1];
                        "replaceWith" === s ? r[0] !== o[0] && r.replaceWith(o) : "img" === s ? r.is("img") ? r.attr("src", o) : r.replaceWith(t("<img>").attr("src", o).attr("class", r.attr("class"))) : r.attr(n[1], o)
                    }
                } else e.find(".mfp-" + i).html(o)
            })
        },
        _getScrollbarSize: function () {
            if (void 0 === e.scrollbarSize) {
                var t = document.createElement("div");
                t.style.cssText = "width: 99px; height: 99px; overflow: scroll; position: absolute; top: -9999px;", document.body.appendChild(t), e.scrollbarSize = t.offsetWidth - t.clientWidth, document.body.removeChild(t)
            }
            return e.scrollbarSize
        }
    }, t.magnificPopup = {
        instance: null,
        proto: a.prototype,
        modules: [],
        open: function (e, i) {
            return f(), e = e ? t.extend(!0, {}, e) : {}, e.isObj = !0, e.index = i || 0, this.instance.open(e)
        },
        close: function () {
            return t.magnificPopup.instance && t.magnificPopup.instance.close()
        },
        registerModule: function (e, i) {
            i.options && (t.magnificPopup.defaults[e] = i.options), t.extend(this.proto, i.proto), this.modules.push(e)
        },
        defaults: {
            disableOn: 0,
            key: null,
            midClick: !1,
            mainClass: "",
            preloader: !0,
            focus: "",
            closeOnContentClick: !1,
            closeOnBgClick: !0,
            closeBtnInside: !0,
            showCloseBtn: !0,
            enableEscapeKey: !0,
            modal: !1,
            alignTop: !1,
            removalDelay: 0,
            prependTo: null,
            fixedContentPos: "auto",
            fixedBgPos: "auto",
            overflowY: "auto",
            closeMarkup: '<button title="%title%" type="button" class="mfp-close">&#215;</button>',
            tClose: "Close (Esc)",
            tLoading: "Loading...",
            autoFocusLast: !0
        }
    }, t.fn.magnificPopup = function (i) {
        f();
        var o = t(this);
        if ("string" == typeof i)
            if ("open" === i) {
                var n, r = l ? o.data("magnificPopup") : o[0].magnificPopup,
                    s = parseInt(arguments[1], 10) || 0;
                r.items ? n = r.items[s] : (n = o, r.delegate && (n = n.find(r.delegate)), n = n.eq(s)), e._openClick({
                    mfpEl: n
                }, o, r)
            } else e.isOpen && e[i].apply(e, Array.prototype.slice.call(arguments, 1));
        else i = t.extend(!0, {}, i), l ? o.data("magnificPopup", i) : o[0].magnificPopup = i, e.addGroup(o, i);
        return o
    };
    var g, v, y, w = function () {
        y && (v.after(y.addClass(g)).detach(), y = null)
    };
    t.magnificPopup.registerModule("inline", {
        options: {
            hiddenClass: "hide",
            markup: "",
            tNotFound: "Content not found"
        },
        proto: {
            initInline: function () {
                e.types.push("inline"), d("Close.inline", function () {
                    w()
                })
            },
            getInline: function (i, o) {
                if (w(), i.src) {
                    var n = e.st.inline,
                        r = t(i.src);
                    if (r.length) {
                        var s = r[0].parentNode;
                        s && s.tagName && (v || (g = n.hiddenClass, v = u(g), g = "mfp-" + g), y = r.after(v).detach().removeClass(g)), e.updateStatus("ready")
                    } else e.updateStatus("error", n.tNotFound), r = t("<div>");
                    return i.inlineElement = r, r
                }
                return e.updateStatus("ready"), e._parseMarkup(o, {}, i), o
            }
        }
    });
    var b, S = function () {
            b && t(document.body).removeClass(b)
        },
        x = function () {
            S(), e.req && e.req.abort()
        };
    t.magnificPopup.registerModule("ajax", {
        options: {
            settings: null,
            cursor: "mfp-ajax-cur",
            tError: '<a href="%url%">The content</a> could not be loaded.'
        },
        proto: {
            initAjax: function () {
                e.types.push("ajax"), b = e.st.ajax.cursor, d("Close.ajax", x), d("BeforeChange.ajax", x)
            },
            getAjax: function (i) {
                b && t(document.body).addClass(b), e.updateStatus("loading");
                var o = t.extend({
                    url: i.src,
                    success: function (o, n, r) {
                        var s = {
                            data: o,
                            xhr: r
                        };
                        p("ParseAjax", s), e.appendContent(t(s.data), "ajax"), i.finished = !0, S(), e._setFocus(), setTimeout(function () {
                            e.wrap.addClass("mfp-ready")
                        }, 16), e.updateStatus("ready"), p("AjaxContentAdded")
                    },
                    error: function () {
                        S(), i.finished = i.loadError = !0, e.updateStatus("error", e.st.ajax.tError.replace("%url%", i.src))
                    }
                }, e.st.ajax.settings);
                return e.req = t.ajax(o), ""
            }
        }
    });
    var C, k = function (i) {
        if (i.data && void 0 !== i.data.title) return i.data.title;
        var o = e.st.image.titleSrc;
        if (o) {
            if (t.isFunction(o)) return o.call(e, i);
            if (i.el) return i.el.attr(o) || ""
        }
        return ""
    };
    t.magnificPopup.registerModule("image", {
        options: {
            markup: '<div class="mfp-figure"><div class="mfp-close"></div><figure><div class="mfp-img"></div><figcaption><div class="mfp-bottom-bar"><div class="mfp-title"></div><div class="mfp-counter"></div></div></figcaption></figure></div>',
            cursor: "mfp-zoom-out-cur",
            titleSrc: "title",
            verticalFit: !0,
            tError: '<a href="%url%">The image</a> could not be loaded.'
        },
        proto: {
            initImage: function () {
                var i = e.st.image,
                    o = ".image";
                e.types.push("image"), d("Open" + o, function () {
                    "image" === e.currItem.type && i.cursor && t(document.body).addClass(i.cursor)
                }), d("Close" + o, function () {
                    i.cursor && t(document.body).removeClass(i.cursor), c.off("resize.mfp")
                }), d("Resize" + o, e.resizeImage), e.isLowIE && d("AfterChange", e.resizeImage)
            },
            resizeImage: function () {
                var t = e.currItem;
                if (t && t.img && e.st.image.verticalFit) {
                    var i = 0;
                    e.isLowIE && (i = parseInt(t.img.css("padding-top"), 10) + parseInt(t.img.css("padding-bottom"), 10)), t.img.css("max-height", e.wH - i)
                }
            },
            _onImageHasSize: function (t) {
                t.img && (t.hasSize = !0, C && clearInterval(C), t.isCheckingImgSize = !1, p("ImageHasSize", t), t.imgHidden && (e.content && e.content.removeClass("mfp-loading"), t.imgHidden = !1))
            },
            findImageSize: function (t) {
                var i = 0,
                    o = t.img[0],
                    n = function (r) {
                        C && clearInterval(C), C = setInterval(function () {
                            if (o.naturalWidth > 0) return void e._onImageHasSize(t);
                            i > 200 && clearInterval(C), i++, 3 === i ? n(10) : 40 === i ? n(50) : 100 === i && n(500)
                        }, r)
                    };
                n(1)
            },
            getImage: function (i, o) {
                var n = 0,
                    r = function () {
                        i && (i.img[0].complete ? (i.img.off(".mfploader"), i === e.currItem && (e._onImageHasSize(i), e.updateStatus("ready")), i.hasSize = !0, i.loaded = !0, p("ImageLoadComplete")) : (n++, n < 200 ? setTimeout(r, 100) : s()))
                    },
                    s = function () {
                        i && (i.img.off(".mfploader"), i === e.currItem && (e._onImageHasSize(i), e.updateStatus("error", a.tError.replace("%url%", i.src))), i.hasSize = !0, i.loaded = !0, i.loadError = !0)
                    },
                    a = e.st.image,
                    l = o.find(".mfp-img");
                if (l.length) {
                    var c = document.createElement("img");
                    c.className = "mfp-img", i.el && i.el.find("img").length && (c.alt = i.el.find("img").attr("alt")), i.img = t(c).on("load.mfploader", r).on("error.mfploader", s), c.src = i.src, l.is("img") && (i.img = i.img.clone()), c = i.img[0], c.naturalWidth > 0 ? i.hasSize = !0 : c.width || (i.hasSize = !1)
                }
                return e._parseMarkup(o, {
                    title: k(i),
                    img_replaceWith: i.img
                }, i), e.resizeImage(), i.hasSize ? (C && clearInterval(C), i.loadError ? (o.addClass("mfp-loading"), e.updateStatus("error", a.tError.replace("%url%", i.src))) : (o.removeClass("mfp-loading"), e.updateStatus("ready")), o) : (e.updateStatus("loading"), i.loading = !0, i.hasSize || (i.imgHidden = !0, o.addClass("mfp-loading"), e.findImageSize(i)), o)
            }
        }
    });
    var _, T = function () {
        return void 0 === _ && (_ = void 0 !== document.createElement("p").style.MozTransform), _
    };
    t.magnificPopup.registerModule("zoom", {
        options: {
            enabled: !1,
            easing: "ease-in-out",
            duration: 300,
            opener: function (t) {
                return t.is("img") ? t : t.find("img")
            }
        },
        proto: {
            initZoom: function () {
                var t, i = e.st.zoom,
                    o = ".zoom";
                if (i.enabled && e.supportsTransition) {
                    var n, r, s = i.duration,
                        a = function (t) {
                            var e = t.clone().removeAttr("style").removeAttr("class").addClass("mfp-animated-image"),
                                o = "all " + i.duration / 1e3 + "s " + i.easing,
                                n = {
                                    position: "fixed",
                                    zIndex: 9999,
                                    left: 0,
                                    top: 0,
                                    "-webkit-backface-visibility": "hidden"
                                },
                                r = "transition";
                            return n["-webkit-" + r] = n["-moz-" + r] = n["-o-" + r] = n[r] = o, e.css(n), e
                        },
                        l = function () {
                            e.content.css("visibility", "visible")
                        };
                    d("BuildControls" + o, function () {
                        if (e._allowZoom()) {
                            if (clearTimeout(n), e.content.css("visibility", "hidden"), !(t = e._getItemToZoom())) return void l();
                            r = a(t), r.css(e._getOffset()), e.wrap.append(r), n = setTimeout(function () {
                                r.css(e._getOffset(!0)), n = setTimeout(function () {
                                    l(), setTimeout(function () {
                                        r.remove(), t = r = null, p("ZoomAnimationEnded")
                                    }, 16)
                                }, s)
                            }, 16)
                        }
                    }), d("BeforeClose" + o, function () {
                        if (e._allowZoom()) {
                            if (clearTimeout(n), e.st.removalDelay = s, !t) {
                                if (!(t = e._getItemToZoom())) return;
                                r = a(t)
                            }
                            r.css(e._getOffset(!0)), e.wrap.append(r), e.content.css("visibility", "hidden"), setTimeout(function () {
                                r.css(e._getOffset())
                            }, 16)
                        }
                    }), d("Close" + o, function () {
                        e._allowZoom() && (l(), r && r.remove(), t = null)
                    })
                }
            },
            _allowZoom: function () {
                return "image" === e.currItem.type
            },
            _getItemToZoom: function () {
                return !!e.currItem.hasSize && e.currItem.img
            },
            _getOffset: function (i) {
                var o;
                o = i ? e.currItem.img : e.st.zoom.opener(e.currItem.el || e.currItem);
                var n = o.offset(),
                    r = parseInt(o.css("padding-top"), 10),
                    s = parseInt(o.css("padding-bottom"), 10);
                n.top -= t(window).scrollTop() - r;
                var a = {
                    width: o.width(),
                    height: (l ? o.innerHeight() : o[0].offsetHeight) - s - r
                };
                return T() ? a["-moz-transform"] = a.transform = "translate(" + n.left + "px," + n.top + "px)" : (a.left = n.left, a.top = n.top), a
            }
        }
    });
    var E = function (t) {
        if (e.currTemplate.iframe) {
            var i = e.currTemplate.iframe.find("iframe");
            i.length && (t || (i[0].src = "//about:blank"), e.isIE8 && i.css("display", t ? "block" : "none"))
        }
    };
    t.magnificPopup.registerModule("iframe", {
        options: {
            markup: '<div class="mfp-iframe-scaler"><div class="mfp-close"></div><iframe class="mfp-iframe" src="//about:blank" frameborder="0" allowfullscreen></iframe></div>',
            srcAction: "iframe_src",
            patterns: {
                youtube: {
                    index: "youtube.com",
                    id: "v=",
                    src: "//www.youtube.com/embed/%id%?autoplay=1"
                },
                vimeo: {
                    index: "vimeo.com/",
                    id: "/",
                    src: "//player.vimeo.com/video/%id%?autoplay=1"
                },
                gmaps: {
                    index: "//maps.google.",
                    src: "%id%&output=embed"
                }
            }
        },
        proto: {
            initIframe: function () {
                e.types.push("iframe"), d("BeforeChange", function (t, e, i) {
                    e !== i && ("iframe" === e ? E() : "iframe" === i && E(!0))
                }), d("Close.iframe", function () {
                    E()
                })
            },
            getIframe: function (i, o) {
                var n = i.src,
                    r = e.st.iframe;
                t.each(r.patterns, function () {
                    if (n.indexOf(this.index) > -1) return this.id && (n = "string" == typeof this.id ? n.substr(n.lastIndexOf(this.id) + this.id.length, n.length) : this.id.call(this, n)), n = this.src.replace("%id%", n), !1
                });
                var s = {};
                return r.srcAction && (s[r.srcAction] = n), e._parseMarkup(o, s, i), e.updateStatus("ready"), o
            }
        }
    });
    var O = function (t) {
            var i = e.items.length;
            return t > i - 1 ? t - i : t < 0 ? i + t : t
        },
        I = function (t, e, i) {
            return t.replace(/%curr%/gi, e + 1).replace(/%total%/gi, i)
        };
    t.magnificPopup.registerModule("gallery", {
        options: {
            enabled: !1,
            arrowMarkup: '<button title="%title%" type="button" class="mfp-arrow mfp-arrow-%dir%"></button>',
            preload: [0, 2],
            navigateByImgClick: !0,
            arrows: !0,
            tPrev: "Previous (Left arrow key)",
            tNext: "Next (Right arrow key)",
            tCounter: "%curr% of %total%"
        },
        proto: {
            initGallery: function () {
                var i = e.st.gallery,
                    n = ".mfp-gallery";
                if (e.direction = !0, !i || !i.enabled) return !1;
                r += " mfp-gallery", d("Open" + n, function () {
                    i.navigateByImgClick && e.wrap.on("click" + n, ".mfp-img", function () {
                        if (e.items.length > 1) return e.next(), !1
                    }), o.on("keydown" + n, function (t) {
                        37 === t.keyCode ? e.prev() : 39 === t.keyCode && e.next()
                    })
                }), d("UpdateStatus" + n, function (t, i) {
                    i.text && (i.text = I(i.text, e.currItem.index, e.items.length))
                }), d("MarkupParse" + n, function (t, o, n, r) {
                    var s = e.items.length;
                    n.counter = s > 1 ? I(i.tCounter, r.index, s) : ""
                }), d("BuildControls" + n, function () {
                    if (e.items.length > 1 && i.arrows && !e.arrowLeft) {
                        var o = i.arrowMarkup,
                            n = e.arrowLeft = t(o.replace(/%title%/gi, i.tPrev).replace(/%dir%/gi, "left")).addClass("mfp-prevent-close"),
                            r = e.arrowRight = t(o.replace(/%title%/gi, i.tNext).replace(/%dir%/gi, "right")).addClass("mfp-prevent-close");
                        n.click(function () {
                            e.prev()
                        }), r.click(function () {
                            e.next()
                        }), e.container.append(n.add(r))
                    }
                }), d("Change" + n, function () {
                    e._preloadTimeout && clearTimeout(e._preloadTimeout), e._preloadTimeout = setTimeout(function () {
                        e.preloadNearbyImages(), e._preloadTimeout = null
                    }, 16)
                }), d("Close" + n, function () {
                    o.off(n), e.wrap.off("click" + n), e.arrowRight = e.arrowLeft = null
                })
            },
            next: function () {
                e.direction = !0, e.index = O(e.index + 1), e.updateItemHTML()
            },
            prev: function () {
                e.direction = !1, e.index = O(e.index - 1), e.updateItemHTML()
            },
            goTo: function (t) {
                e.direction = t >= e.index, e.index = t, e.updateItemHTML()
            },
            preloadNearbyImages: function () {
                var t, i = e.st.gallery.preload,
                    o = Math.min(i[0], e.items.length),
                    n = Math.min(i[1], e.items.length);
                for (t = 1; t <= (e.direction ? n : o); t++) e._preloadItem(e.index + t);
                for (t = 1; t <= (e.direction ? o : n); t++) e._preloadItem(e.index - t)
            },
            _preloadItem: function (i) {
                if (i = O(i), !e.items[i].preloaded) {
                    var o = e.items[i];
                    o.parsed || (o = e.parseEl(i)), p("LazyLoad", o), "image" === o.type && (o.img = t('<img class="mfp-img" />').on("load.mfploader", function () {
                        o.hasSize = !0
                    }).on("error.mfploader", function () {
                        o.hasSize = !0, o.loadError = !0, p("LazyLoadError", o)
                    }).attr("src", o.src)), o.preloaded = !0
                }
            }
        }
    });
    t.magnificPopup.registerModule("retina", {
        options: {
            replaceSrc: function (t) {
                return t.src.replace(/\.\w+$/, function (t) {
                    return "@2x" + t
                })
            },
            ratio: 1
        },
        proto: {
            initRetina: function () {
                if (window.devicePixelRatio > 1) {
                    var t = e.st.retina,
                        i = t.ratio;
                    i = isNaN(i) ? i() : i, i > 1 && (d("ImageHasSize.retina", function (t, e) {
                        e.img.css({
                            "max-width": e.img[0].naturalWidth / i,
                            width: "100%"
                        })
                    }), d("ElementParse.retina", function (e, o) {
                        o.src = t.replaceSrc(o, i)
                    }))
                }
            }
        }
    }), f()
}),
function (t) {
    "use strict";
    t.fn.fitVids = function (e) {
        var i = {
            customSelector: null,
            ignore: null
        };
        if (!document.getElementById("fit-vids-style")) {
            var o = document.head || document.getElementsByTagName("head")[0],
                n = document.createElement("div");
            n.innerHTML = '<p>x</p><style id="fit-vids-style">.fluid-width-video-wrapper{width:100%;position:relative;padding:0;}.fluid-width-video-wrapper iframe,.fluid-width-video-wrapper object,.fluid-width-video-wrapper embed {position:absolute;top:0;left:0;width:100%;height:100%;}</style>', o.appendChild(n.childNodes[1])
        }
        return e && t.extend(i, e), this.each(function () {
            var e = ['iframe[src*="player.vimeo.com"]', 'iframe[src*="youtube.com"]', 'iframe[src*="youtube-nocookie.com"]', 'iframe[src*="kickstarter.com"][src*="video.html"]', "object", "embed"];
            i.customSelector && e.push(i.customSelector);
            var o = ".fitvidsignore";
            i.ignore && (o = o + ", " + i.ignore);
            var n = t(this).find(e.join(","));
            n = n.not("object object"), n = n.not(o), n.each(function () {
                var e = t(this);
                if (!(e.parents(o).length > 0 || "embed" === this.tagName.toLowerCase() && e.parent("object").length || e.parent(".fluid-width-video-wrapper").length)) {
                    e.css("height") || e.css("width") || !isNaN(e.attr("height")) && !isNaN(e.attr("width")) || (e.attr("height", 9), e.attr("width", 16));
                    var i = "object" === this.tagName.toLowerCase() || e.attr("height") && !isNaN(parseInt(e.attr("height"), 10)) ? parseInt(e.attr("height"), 10) : e.height(),
                        n = isNaN(parseInt(e.attr("width"), 10)) ? e.width() : parseInt(e.attr("width"), 10),
                        r = i / n;
                    if (!e.attr("name")) {
                        var s = "fitvid" + t.fn.fitVids._count;
                        e.attr("name", s), t.fn.fitVids._count++
                    }
                    e.wrap('<div class="fluid-width-video-wrapper"></div>').parent(".fluid-width-video-wrapper").css("padding-top", 100 * r + "%"), e.removeAttr("height").removeAttr("width")
                }
            })
        })
    }, t.fn.fitVids._count = 0
}(window.jQuery || window.Zepto),
function (t) {
    "use strict";

    function e() {
        var t = !1;
        return function (e) {
            (/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino|android|ipad|playbook|silk/i.test(e) || /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(e.substr(0, 4))) && (t = !0)
        }(navigator.userAgent || navigator.vendor || window.opera), t
    }

    function i(t, e, i) {
        return t === e ? t = e : t === i && (t = i), t
    }

    function o(t, e, i) {
        if (!(t >= e && t <= i)) throw Error("Invalid Rating, expected value between " + e + " and " + i);
        return t
    }

    function n(t) {
        return void 0 !== t
    }

    function r(t, e, i) {
        var o = i / 100 * (e - t);
        return o = Math.round(t + o).toString(16), 1 === o.length && (o = "0" + o), o
    }

    function s(t, e, i) {
        if (!t || !e) return null;
        i = n(i) ? i : 0, t = g(t), e = g(e);
        var o = r(t.r, e.r, i),
            s = r(t.b, e.b, i);
        return "#" + o + r(t.g, e.g, i) + s
    }

    function a(r, l) {
        function d(t) {
            n(t) || (t = l.rating), Z = t;
            var e = t / q,
                i = e * R;
            e > 1 && (i += (Math.ceil(e) - 1) * U), v(l.ratedFill), i = l.rtl ? 100 - i : i, i < 0 ? i = 0 : i > 100 && (i = 100), X.css("width", i + "%")
        }

        function u() {
            Y = F * l.numStars + N * (l.numStars - 1), R = F / Y * 100, U = N / Y * 100, r.width(Y), d()
        }

        function h(t) {
            var e = l.starWidth = t;
            return F = window.parseFloat(l.starWidth.replace("px", "")), V.find("svg").attr({
                width: l.starWidth,
                height: e
            }), X.find("svg").attr({
                width: l.starWidth,
                height: e
            }), u(), r
        }

        function m(t) {
            return l.spacing = t, N = parseFloat(l.spacing.replace("px", "")), V.find("svg:not(:first-child)").css({
                "margin-left": t
            }), X.find("svg:not(:first-child)").css({
                "margin-left": t
            }), u(), r
        }

        function g(t) {
            return l.normalFill = t, (l.rtl ? X : V).find("svg").attr({
                fill: l.normalFill
            }), r
        }

        function v(t) {
            if (l.multiColor) {
                var e = Z - G,
                    i = e / l.maxValue * 100,
                    o = l.multiColor || {};
                t = s(o.startColor || f.startColor, o.endColor || f.endColor, i)
            } else J = t;
            return l.ratedFill = t, (l.rtl ? V : X).find("svg").attr({
                fill: l.ratedFill
            }), r
        }

        function y(t) {
            t = !!t, l.rtl = t, g(l.normalFill), d()
        }

        function w(t) {
            l.multiColor = t, v(t || J)
        }

        function b(e) {
            l.numStars = e, q = l.maxValue / l.numStars, V.empty(), X.empty();
            for (var i = 0; i < l.numStars; i++) V.append(t(l.starSvg || p)), X.append(t(l.starSvg || p));
            return h(l.starWidth), g(l.normalFill), m(l.spacing), d(), r
        }

        function S(t) {
            return l.maxValue = t, q = l.maxValue / l.numStars, l.rating > t && O(t), d(), r
        }

        function x(t) {
            return l.precision = t, O(l.rating), r
        }

        function C(t) {
            return l.halfStar = t, r
        }

        function k(t) {
            return l.fullStar = t, r
        }

        function _(t) {
            var e = t % q,
                i = q / 2,
                o = l.halfStar,
                n = l.fullStar;
            return n || o ? (n || o && e > i ? t += q - e : (t -= e, e > 0 && (t += i)), t) : t
        }

        function T(t) {
            var e = V.offset(),
                i = e.left,
                o = i + V.width(),
                n = l.maxValue,
                r = t.pageX,
                s = 0;
            if (r < i) s = G;
            else if (r > o) s = n;
            else {
                var a = (r - i) / (o - i);
                if (N > 0) {
                    a *= 100;
                    for (var c = a; c > 0;) c > R ? (s += q, c -= R + U) : (s += c / R * q, c = 0)
                } else s = a * l.maxValue;
                s = _(s)
            }
            return l.rtl && (s = n - s), parseFloat(s)
        }

        function E(t) {
            return l.readOnly = t, r.attr("readonly", !0), H(), t || (r.removeAttr("readonly"), W()), r
        }

        function O(t) {
            var e = t,
                n = l.maxValue;
            return "string" == typeof e && ("%" === e[e.length - 1] && (e = e.substr(0, e.length - 1), n = 100, S(n)), e = parseFloat(e)), o(e, G, n), e = parseFloat(e.toFixed(l.precision)), i(parseFloat(e), G, n), l.rating = e, d(), K && r.trigger("rateyo.set", {
                rating: e
            }), r
        }

        function I(t) {
            return l.onInit = t, r
        }

        function z(t) {
            return l.onSet = t, r
        }

        function $(t) {
            return l.onChange = t, r
        }

        function A(t) {
            var e = T(t).toFixed(l.precision),
                o = l.maxValue;
            e = i(parseFloat(e), G, o), d(e), r.trigger("rateyo.change", {
                rating: e
            })
        }

        function P() {
            e() || (d(), r.trigger("rateyo.change", {
                rating: l.rating
            }))
        }

        function M(t) {
            var e = T(t).toFixed(l.precision);
            e = parseFloat(e), j.rating(e)
        }

        function L(t, e) {
            l.onInit && "function" == typeof l.onInit && l.onInit.apply(this, [e.rating, j])
        }

        function B(t, e) {
            l.onChange && "function" == typeof l.onChange && l.onChange.apply(this, [e.rating, j])
        }

        function D(t, e) {
            l.onSet && "function" == typeof l.onSet && l.onSet.apply(this, [e.rating, j])
        }

        function W() {
            r.on("mousemove", A).on("mouseenter", A).on("mouseleave", P).on("click", M).on("rateyo.init", L).on("rateyo.change", B).on("rateyo.set", D)
        }

        function H() {
            r.off("mousemove", A).off("mouseenter", A).off("mouseleave", P).off("click", M).off("rateyo.init", L).off("rateyo.change", B).off("rateyo.set", D)
        }
        this.node = r.get(0);
        var j = this;
        r.empty().addClass("jq-ry-container");
        var q, F, R, N, U, Y, Q = t("<div/>").addClass("jq-ry-group-wrapper").appendTo(r),
            V = t("<div/>").addClass("jq-ry-normal-group").addClass("jq-ry-group").appendTo(Q),
            X = t("<div/>").addClass("jq-ry-rated-group").addClass("jq-ry-group").appendTo(Q),
            G = 0,
            Z = l.rating,
            K = !1,
            J = l.ratedFill;
        this.rating = function (t) {
            return n(t) ? (O(t), r) : l.rating
        }, this.destroy = function () {
            return l.readOnly || H(), a.prototype.collection = c(r.get(0), this.collection), r.removeClass("jq-ry-container").children().remove(), r
        }, this.method = function (t) {
            if (!t) throw Error("Method name not specified!");
            if (!n(this[t])) throw Error("Method " + t + " doesn't exist!");
            var e = Array.prototype.slice.apply(arguments, []),
                i = e.slice(1);
            return this[t].apply(this, i)
        }, this.option = function (t, e) {
            if (!n(t)) return l;
            var i;
            switch (t) {
                case "starWidth":
                    i = h;
                    break;
                case "numStars":
                    i = b;
                    break;
                case "normalFill":
                    i = g;
                    break;
                case "ratedFill":
                    i = v;
                    break;
                case "multiColor":
                    i = w;
                    break;
                case "maxValue":
                    i = S;
                    break;
                case "precision":
                    i = x;
                    break;
                case "rating":
                    i = O;
                    break;
                case "halfStar":
                    i = C;
                    break;
                case "fullStar":
                    i = k;
                    break;
                case "readOnly":
                    i = E;
                    break;
                case "spacing":
                    i = m;
                    break;
                case "rtl":
                    i = y;
                    break;
                case "onInit":
                    i = I;
                    break;
                case "onSet":
                    i = z;
                    break;
                case "onChange":
                    i = $;
                    break;
                default:
                    throw Error("No such option as " + t)
            }
            return n(e) ? i(e) : l[t]
        }, b(l.numStars), E(l.readOnly), l.rtl && y(l.rtl), this.collection.push(this), this.rating(l.rating, !0), K = !0, r.trigger("rateyo.init", {
            rating: l.rating
        })
    }

    function l(e, i) {
        var o;
        return t.each(i, function () {
            if (e === this.node) return o = this, !1
        }), o
    }

    function c(e, i) {
        return t.each(i, function (t) {
            if (e === this.node) {
                var o = i.slice(0, t),
                    n = i.slice(t + 1, i.length);
                return i = o.concat(n), !1
            }
        }), i
    }

    function d(e) {
        var i = a.prototype.collection,
            o = t(this);
        if (0 === o.length) return o;
        var n = Array.prototype.slice.apply(arguments, []);
        if (0 === n.length) e = n[0] = {};
        else {
            if (1 !== n.length || "object" != typeof n[0]) {
                if (n.length >= 1 && "string" == typeof n[0]) {
                    var r = n[0],
                        s = n.slice(1),
                        c = [];
                    return t.each(o, function (t, e) {
                        var o = l(e, i);
                        if (!o) throw Error("Trying to set options before even initialization");
                        var n = o[r];
                        if (!n) throw Error("Method " + r + " does not exist!");
                        var a = n.apply(o, s);
                        c.push(a)
                    }), c = 1 === c.length ? c[0] : c
                }
                throw Error("Invalid Arguments")
            }
            e = n[0]
        }
        return e = t.extend({}, h, e), t.each(o, function () {
            var o = l(this, i);
            if (o) return o;
            var n = t(this),
                r = {},
                s = t.extend({}, e);
            return t.each(n.data(), function (t, e) {
                if (0 === t.indexOf("rateyo")) {
                    var i = t.replace(/^rateyo/, "");
                    i = i[0].toLowerCase() + i.slice(1), r[i] = e, delete s[i]
                }
            }), new a(t(this), t.extend({}, r, s))
        })
    }

    function u() {
        return d.apply(this, Array.prototype.slice.apply(arguments, []))
    }
    var p = '<?xml version="1.0" encoding="utf-8"?><svg version="1.1"xmlns="http://www.w3.org/2000/svg"viewBox="0 12.705 512 486.59"x="0px" y="0px"xml:space="preserve"><polygon points="256.814,12.705 317.205,198.566 512.631,198.566 354.529,313.435 414.918,499.295 256.814,384.427 98.713,499.295 159.102,313.435 1,198.566 196.426,198.566 "/></svg>',
        h = {
            starWidth: "32px",
            normalFill: "gray",
            ratedFill: "#f39c12",
            numStars: 5,
            maxValue: 5,
            precision: 1,
            rating: 0,
            fullStar: !1,
            halfStar: !1,
            readOnly: !1,
            spacing: "0px",
            rtl: !1,
            multiColor: null,
            onInit: null,
            onChange: null,
            onSet: null,
            starSvg: null
        },
        f = {
            startColor: "#c0392b",
            endColor: "#f1c40f"
        },
        m = /^#([0-9a-f]{2})([0-9a-f]{2})([0-9a-f]{2})$/i,
        g = function (t) {
            if (!m.test(t)) return null;
            var e = m.exec(t);
            return {
                r: parseInt(e[1], 16),
                g: parseInt(e[2], 16),
                b: parseInt(e[3], 16)
            }
        };
    a.prototype.collection = [], window.RateYo = a, t.fn.rateYo = u
}(window.jQuery),
function (t) {
    t.fn.tabber = function (i) {
        return e[i] ? e[i].apply(this, Array.prototype.slice.call(arguments, 1)) : "object" != typeof i && i ? void t.error("Method " + i + " does not exist on jQuery.tooltip") : e.init.apply(this, arguments)
    };
    var e = {
        init: function (e) {
            var i, o, n, r, s = {
                    anchor: ".tabber-anchor",
                    content: ".tabber-content"
                },
                a = t.extend(s, e);
            return this, this.find(".tabber-selectors"), i = t(a.anchor), this.find(".tabber-contents"), o = t(a.content), this.each(function () {
                i.length == o.length && (i.each(function (e) {
                    t(this).attr("rel", e)
                }), o.each(function (e) {
                    t(this).attr("rel", e)
                }), i.on("click", function (e) {
                    i = t(this), n = t(this).attr("rel"), o.each(function (e) {
                        if (r = t(this).attr("rel"), n === r) return i.parent().siblings().find(a.anchor).removeClass("active"), i.addClass("active"), t(this).siblings().hide(), t(this).fadeIn(), !1
                    })
                }))
            })
        }
    }
}(jQuery),
function (t, e) {
    "object" == typeof exports && "object" == typeof module ? module.exports = e() : "function" == typeof define && define.amd ? define("Noty", [], e) : "object" == typeof exports ? exports.Noty = e() : t.Noty = e()
}(this, function () {
    return function (t) {
        function e(o) {
            if (i[o]) return i[o].exports;
            var n = i[o] = {
                i: o,
                l: !1,
                exports: {}
            };
            return t[o].call(n.exports, n, n.exports, e), n.l = !0, n.exports
        }
        var i = {};
        return e.m = t, e.c = i, e.i = function (t) {
            return t
        }, e.d = function (t, i, o) {
            e.o(t, i) || Object.defineProperty(t, i, {
                configurable: !1,
                enumerable: !0,
                get: o
            })
        }, e.n = function (t) {
            var i = t && t.__esModule ? function () {
                return t.default
            } : function () {
                return t
            };
            return e.d(i, "a", i), i
        }, e.o = function (t, e) {
            return Object.prototype.hasOwnProperty.call(t, e)
        }, e.p = "", e(e.s = 6)
    }([function (t, e, i) {
        "use strict";

        function o(t, e, i) {
            var o = void 0;
            if (!i) {
                for (o in e)
                    if (e.hasOwnProperty(o) && e[o] === t) return !0
            } else
                for (o in e)
                    if (e.hasOwnProperty(o) && e[o] === t) return !0;
            return !1
        }

        function n(t) {
            t = t || window.event, void 0 !== t.stopPropagation ? t.stopPropagation() : t.cancelBubble = !0
        }

        function r() {
            var t = arguments.length > 0 && void 0 !== arguments[0] ? arguments[0] : "",
                e = "noty_" + t + "_";
            return e += "xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx".replace(/[xy]/g, function (t) {
                var e = 16 * Math.random() | 0;
                return ("x" === t ? e : 3 & e | 8).toString(16)
            })
        }

        function s(t) {
            var e = t.offsetHeight,
                i = window.getComputedStyle(t);
            return e += parseInt(i.marginTop) + parseInt(i.marginBottom)
        }

        function a(t, e, i) {
            var o = arguments.length > 3 && void 0 !== arguments[3] && arguments[3];
            e = e.split(" ");
            for (var n = 0; n < e.length; n++) document.addEventListener ? t.addEventListener(e[n], i, o) : document.attachEvent && t.attachEvent("on" + e[n], i)
        }

        function l(t, e) {
            return ("string" == typeof t ? t : p(t)).indexOf(" " + e + " ") >= 0
        }

        function c(t, e) {
            var i = p(t),
                o = i + e;
            l(i, e) || (t.className = o.substring(1))
        }

        function d(t, e) {
            var i = p(t),
                o = void 0;
            l(t, e) && (o = i.replace(" " + e + " ", " "), t.className = o.substring(1, o.length - 1))
        }

        function u(t) {
            t.parentNode && t.parentNode.removeChild(t)
        }

        function p(t) {
            return (" " + (t && t.className || "") + " ").replace(/\s+/gi, " ")
        }

        function h() {
            function t() {
                y.PageHidden = document[s], o()
            }

            function e() {
                y.PageHidden = !0, o()
            }

            function i() {
                y.PageHidden = !1, o()
            }

            function o() {
                y.PageHidden ? n() : r()
            }

            function n() {
                setTimeout(function () {
                    Object.keys(y.Store).forEach(function (t) {
                        y.Store.hasOwnProperty(t) && y.Store[t].options.visibilityControl && y.Store[t].stop()
                    })
                }, 100)
            }

            function r() {
                setTimeout(function () {
                    Object.keys(y.Store).forEach(function (t) {
                        y.Store.hasOwnProperty(t) && y.Store[t].options.visibilityControl && y.Store[t].resume()
                    }), y.queueRenderAll()
                }, 100)
            }
            var s = void 0,
                l = void 0;
            void 0 !== document.hidden ? (s = "hidden", l = "visibilitychange") : void 0 !== document.msHidden ? (s = "msHidden", l = "msvisibilitychange") : void 0 !== document.webkitHidden && (s = "webkitHidden", l = "webkitvisibilitychange"), l && a(document, l, t), a(window, "blur", e), a(window, "focus", i)
        }

        function f(t) {
            if (t.hasSound) {
                var e = document.createElement("audio");
                t.options.sounds.sources.forEach(function (t) {
                    var i = document.createElement("source");
                    i.src = t, i.type = "audio/" + m(t), e.appendChild(i)
                }), t.barDom ? t.barDom.appendChild(e) : document.querySelector("body").appendChild(e), e.volume = t.options.sounds.volume, t.soundPlayed || (e.play(), t.soundPlayed = !0), e.onended = function () {
                    u(e)
                }
            }
        }

        function m(t) {
            return t.match(/\.([^.]+)$/)[1]
        }
        Object.defineProperty(e, "__esModule", {
            value: !0
        }), e.css = e.deepExtend = e.animationEndEvents = void 0;
        var g = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (t) {
            return typeof t
        } : function (t) {
            return t && "function" == typeof Symbol && t.constructor === Symbol && t !== Symbol.prototype ? "symbol" : typeof t
        };
        e.inArray = o, e.stopPropagation = n, e.generateID = r, e.outerHeight = s, e.addListener = a, e.hasClass = l, e.addClass = c, e.removeClass = d, e.remove = u, e.classList = p, e.visibilityChangeFlow = h, e.createAudioElements = f;
        var v = i(1),
            y = function (t) {
                if (t && t.__esModule) return t;
                var e = {};
                if (null != t)
                    for (var i in t) Object.prototype.hasOwnProperty.call(t, i) && (e[i] = t[i]);
                return e.default = t, e
            }(v);
        e.animationEndEvents = "webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend", e.deepExtend = function t(e) {
            e = e || {};
            for (var i = 1; i < arguments.length; i++) {
                var o = arguments[i];
                if (o)
                    for (var n in o) o.hasOwnProperty(n) && (Array.isArray(o[n]) ? e[n] = o[n] : "object" === g(o[n]) && null !== o[n] ? e[n] = t(e[n], o[n]) : e[n] = o[n])
            }
            return e
        }, e.css = function () {
            function t(t) {
                return t.replace(/^-ms-/, "ms-").replace(/-([\da-z])/gi, function (t, e) {
                    return e.toUpperCase()
                })
            }

            function e(t) {
                var e = document.body.style;
                if (t in e) return t;
                for (var i = n.length, o = t.charAt(0).toUpperCase() + t.slice(1), r = void 0; i--;)
                    if ((r = n[i] + o) in e) return r;
                return t
            }

            function i(i) {
                return i = t(i), r[i] || (r[i] = e(i))
            }

            function o(t, e, o) {
                e = i(e), t.style[e] = o
            }
            var n = ["Webkit", "O", "Moz", "ms"],
                r = {};
            return function (t, e) {
                var i = arguments,
                    n = void 0,
                    r = void 0;
                if (2 === i.length)
                    for (n in e) e.hasOwnProperty(n) && void 0 !== (r = e[n]) && e.hasOwnProperty(n) && o(t, n, r);
                else o(t, i[1], i[2])
            }
        }()
    }, function (t, e, i) {
        "use strict";

        function o() {
            var t = arguments.length > 0 && void 0 !== arguments[0] ? arguments[0] : "global",
                e = 0,
                i = T;
            return E.hasOwnProperty(t) && (i = E[t].maxVisible, Object.keys(O).forEach(function (i) {
                O[i].options.queue !== t || O[i].closed || e++
            })), {
                current: e,
                maxVisible: i
            }
        }

        function n(t) {
            E.hasOwnProperty(t.options.queue) || (E[t.options.queue] = {
                maxVisible: T,
                queue: []
            }), E[t.options.queue].queue.push(t)
        }

        function r(t) {
            if (E.hasOwnProperty(t.options.queue)) {
                var e = [];
                Object.keys(E[t.options.queue].queue).forEach(function (i) {
                    E[t.options.queue].queue[i].id !== t.id && e.push(E[t.options.queue].queue[i])
                }), E[t.options.queue].queue = e
            }
        }

        function s() {
            var t = arguments.length > 0 && void 0 !== arguments[0] ? arguments[0] : "global";
            if (E.hasOwnProperty(t)) {
                var e = E[t].queue.shift();
                e && e.show()
            }
        }

        function a() {
            Object.keys(E).forEach(function (t) {
                s(t)
            })
        }

        function l(t) {
            var e = x.generateID("ghost"),
                i = document.createElement("div");
            i.setAttribute("id", e), x.css(i, {
                height: x.outerHeight(t.barDom) + "px"
            }), t.barDom.insertAdjacentHTML("afterend", i.outerHTML), x.remove(t.barDom), i = document.getElementById(e), x.addClass(i, "noty_fix_effects_height"), x.addListener(i, x.animationEndEvents, function () {
                x.remove(i)
            })
        }

        function c(t) {
            m(t);
            var e = '<div class="noty_body">' + t.options.text + "</div>" + u(t) + '<div class="noty_progressbar"></div>';
            t.barDom = document.createElement("div"), t.barDom.setAttribute("id", t.id), x.addClass(t.barDom, "noty_bar noty_type__" + t.options.type + " noty_theme__" + t.options.theme), t.barDom.innerHTML = e, y(t, "onTemplate")
        }

        function d(t) {
            return !(!t.options.buttons || !Object.keys(t.options.buttons).length)
        }

        function u(t) {
            if (d(t)) {
                var e = document.createElement("div");
                return x.addClass(e, "noty_buttons"), Object.keys(t.options.buttons).forEach(function (i) {
                    e.appendChild(t.options.buttons[i].dom)
                }), t.options.buttons.forEach(function (t) {
                    e.appendChild(t.dom)
                }), e.outerHTML
            }
            return ""
        }

        function p(t) {
            t.options.modal && (0 === C && f(), e.DocModalCount = C += 1)
        }

        function h(t) {
            if (t.options.modal && C > 0 && (e.DocModalCount = C -= 1, C <= 0)) {
                var i = document.querySelector(".noty_modal");
                i && (x.removeClass(i, "noty_modal_open"), x.addClass(i, "noty_modal_close"), x.addListener(i, x.animationEndEvents, function () {
                    x.remove(i)
                }))
            }
        }

        function f() {
            var t = document.querySelector("body"),
                e = document.createElement("div");
            x.addClass(e, "noty_modal"), t.insertBefore(e, t.firstChild), x.addClass(e, "noty_modal_open"), x.addListener(e, x.animationEndEvents, function () {
                x.removeClass(e, "noty_modal_open")
            })
        }

        function m(t) {
            if (t.options.container) return void(t.layoutDom = document.querySelector(t.options.container));
            var e = "noty_layout__" + t.options.layout;
            t.layoutDom = document.querySelector("div#" + e), t.layoutDom || (t.layoutDom = document.createElement("div"), t.layoutDom.setAttribute("id", e), t.layoutDom.setAttribute("role", "alert"), t.layoutDom.setAttribute("aria-live", "polite"), x.addClass(t.layoutDom, "noty_layout"), document.querySelector("body").appendChild(t.layoutDom))
        }

        function g(t) {
            t.options.timeout && (t.options.progressBar && t.progressDom && x.css(t.progressDom, {
                transition: "width " + t.options.timeout + "ms linear",
                width: "0%"
            }), clearTimeout(t.closeTimer), t.closeTimer = setTimeout(function () {
                t.close()
            }, t.options.timeout))
        }

        function v(t) {
            t.options.timeout && t.closeTimer && (clearTimeout(t.closeTimer), t.closeTimer = -1, t.options.progressBar && t.progressDom && x.css(t.progressDom, {
                transition: "width 0ms linear",
                width: "100%"
            }))
        }

        function y(t, e) {
            t.listeners.hasOwnProperty(e) && t.listeners[e].forEach(function (e) {
                "function" == typeof e && e.apply(t)
            })
        }

        function w(t) {
            y(t, "afterShow"), g(t), x.addListener(t.barDom, "mouseenter", function () {
                v(t)
            }), x.addListener(t.barDom, "mouseleave", function () {
                g(t)
            })
        }

        function b(t) {
            delete O[t.id], t.closing = !1, y(t, "afterClose"), x.remove(t.barDom), 0 !== t.layoutDom.querySelectorAll(".noty_bar").length || t.options.container || x.remove(t.layoutDom), (x.inArray("docVisible", t.options.titleCount.conditions) || x.inArray("docHidden", t.options.titleCount.conditions)) && _.decrement(), s(t.options.queue)
        }
        Object.defineProperty(e, "__esModule", {
            value: !0
        }), e.Defaults = e.Store = e.Queues = e.DefaultMaxVisible = e.docTitle = e.DocModalCount = e.PageHidden = void 0, e.getQueueCounts = o, e.addToQueue = n, e.removeFromQueue = r, e.queueRender = s, e.queueRenderAll = a, e.ghostFix = l, e.build = c, e.hasButtons = d, e.handleModal = p, e.handleModalClose = h, e.queueClose = g, e.dequeueClose = v, e.fire = y, e.openFlow = w, e.closeFlow = b;
        var S = i(0),
            x = function (t) {
                if (t && t.__esModule) return t;
                var e = {};
                if (null != t)
                    for (var i in t) Object.prototype.hasOwnProperty.call(t, i) && (e[i] = t[i]);
                return e.default = t, e
            }(S),
            C = (e.PageHidden = !1, e.DocModalCount = 0),
            k = {
                originalTitle: null,
                count: 0,
                changed: !1,
                timer: -1
            },
            _ = e.docTitle = {
                increment: function () {
                    k.count++, _._update()
                },
                decrement: function () {
                    if (--k.count <= 0) return void _._clear();
                    _._update()
                },
                _update: function () {
                    var t = document.title;
                    k.changed ? document.title = "(" + k.count + ") " + k.originalTitle : (k.originalTitle = t, document.title = "(" + k.count + ") " + t, k.changed = !0)
                },
                _clear: function () {
                    k.changed && (k.count = 0, document.title = k.originalTitle, k.changed = !1)
                }
            },
            T = e.DefaultMaxVisible = 5,
            E = e.Queues = {
                global: {
                    maxVisible: T,
                    queue: []
                }
            },
            O = e.Store = {};
        e.Defaults = {
            type: "alert",
            layout: "topRight",
            theme: "mint",
            text: "",
            timeout: !1,
            progressBar: !0,
            closeWith: ["click"],
            animation: {
                open: "noty_effects_open",
                close: "noty_effects_close"
            },
            id: !1,
            force: !1,
            killer: !1,
            queue: "global",
            container: !1,
            buttons: [],
            callbacks: {
                beforeShow: null,
                onShow: null,
                afterShow: null,
                onClose: null,
                afterClose: null,
                onClick: null,
                onHover: null,
                onTemplate: null
            },
            sounds: {
                sources: [],
                volume: 1,
                conditions: []
            },
            titleCount: {
                conditions: []
            },
            modal: !1,
            visibilityControl: !1
        }
    }, function (t, e, i) {
        "use strict";

        function o(t, e) {
            if (!(t instanceof e)) throw new TypeError("Cannot call a class as a function")
        }
        Object.defineProperty(e, "__esModule", {
            value: !0
        }), e.NotyButton = void 0;
        var n = i(0),
            r = function (t) {
                if (t && t.__esModule) return t;
                var e = {};
                if (null != t)
                    for (var i in t) Object.prototype.hasOwnProperty.call(t, i) && (e[i] = t[i]);
                return e.default = t, e
            }(n);
        e.NotyButton = function t(e, i, n) {
            var s = this,
                a = arguments.length > 3 && void 0 !== arguments[3] ? arguments[3] : {};
            return o(this, t), this.dom = document.createElement("button"), this.dom.innerHTML = e, this.id = a.id = a.id || r.generateID("button"), this.cb = n, Object.keys(a).forEach(function (t) {
                s.dom.setAttribute(t, a[t])
            }), r.addClass(this.dom, i || "noty_btn"), this
        }
    }, function (t, e, i) {
        "use strict";

        function o(t, e) {
            if (!(t instanceof e)) throw new TypeError("Cannot call a class as a function")
        }
        Object.defineProperty(e, "__esModule", {
            value: !0
        });
        var n = function () {
            function t(t, e) {
                for (var i = 0; i < e.length; i++) {
                    var o = e[i];
                    o.enumerable = o.enumerable || !1, o.configurable = !0, "value" in o && (o.writable = !0), Object.defineProperty(t, o.key, o)
                }
            }
            return function (e, i, o) {
                return i && t(e.prototype, i), o && t(e, o), e
            }
        }();
        e.Push = function () {
            function t() {
                var e = arguments.length > 0 && void 0 !== arguments[0] ? arguments[0] : "/service-worker.js";
                return o(this, t), this.subData = {}, this.workerPath = e, this.listeners = {
                    onPermissionGranted: [],
                    onPermissionDenied: [],
                    onSubscriptionSuccess: [],
                    onSubscriptionCancel: [],
                    onWorkerError: [],
                    onWorkerSuccess: [],
                    onWorkerNotSupported: []
                }, this
            }
            return n(t, [{
                key: "on",
                value: function (t) {
                    var e = arguments.length > 1 && void 0 !== arguments[1] ? arguments[1] : function () {};
                    return "function" == typeof e && this.listeners.hasOwnProperty(t) && this.listeners[t].push(e), this
                }
            }, {
                key: "fire",
                value: function (t) {
                    var e = this,
                        i = arguments.length > 1 && void 0 !== arguments[1] ? arguments[1] : [];
                    this.listeners.hasOwnProperty(t) && this.listeners[t].forEach(function (t) {
                        "function" == typeof t && t.apply(e, i)
                    })
                }
            }, {
                key: "create",
                value: function () {}
            }, {
                key: "isSupported",
                value: function () {
                    var t = !1;
                    try {
                        t = window.Notification || window.webkitNotifications || navigator.mozNotification || window.external && void 0 !== window.external.msIsSiteMode()
                    } catch (t) {}
                    return t
                }
            }, {
                key: "getPermissionStatus",
                value: function () {
                    var t = "default";
                    if (window.Notification && window.Notification.permissionLevel) t = window.Notification.permissionLevel;
                    else if (window.webkitNotifications && window.webkitNotifications.checkPermission) switch (window.webkitNotifications.checkPermission()) {
                        case 1:
                            t = "default";
                            break;
                        case 0:
                            t = "granted";
                            break;
                        default:
                            t = "denied"
                    } else window.Notification && window.Notification.permission ? t = window.Notification.permission : navigator.mozNotification ? t = "granted" : window.external && void 0 !== window.external.msIsSiteMode() && (t = window.external.msIsSiteMode() ? "granted" : "default");
                    return t.toString().toLowerCase()
                }
            }, {
                key: "getEndpoint",
                value: function (t) {
                    var e = t.endpoint,
                        i = t.subscriptionId;
                    return i && -1 === e.indexOf(i) && (e += "/" + i), e
                }
            }, {
                key: "isSWRegistered",
                value: function () {
                    try {
                        return "activated" === navigator.serviceWorker.controller.state
                    } catch (t) {
                        return !1
                    }
                }
            }, {
                key: "unregisterWorker",
                value: function () {
                    var t = this;
                    "serviceWorker" in navigator && navigator.serviceWorker.getRegistrations().then(function (e) {
                        var i = !0,
                            o = !1,
                            n = void 0;
                        try {
                            for (var r, s = e[Symbol.iterator](); !(i = (r = s.next()).done); i = !0) {
                                r.value.unregister(), t.fire("onSubscriptionCancel")
                            }
                        } catch (t) {
                            o = !0, n = t
                        } finally {
                            try {
                                !i && s.return && s.return()
                            } finally {
                                if (o) throw n
                            }
                        }
                    })
                }
            }, {
                key: "requestSubscription",
                value: function () {
                    var t = this,
                        e = !(arguments.length > 0 && void 0 !== arguments[0]) || arguments[0],
                        i = this,
                        o = this.getPermissionStatus(),
                        n = function (o) {
                            "granted" === o ? (t.fire("onPermissionGranted"), "serviceWorker" in navigator ? navigator.serviceWorker.register(t.workerPath).then(function () {
                                navigator.serviceWorker.ready.then(function (t) {
                                    i.fire("onWorkerSuccess"), t.pushManager.subscribe({
                                        userVisibleOnly: e
                                    }).then(function (t) {
                                        var e = t.getKey("p256dh"),
                                            o = t.getKey("auth");
                                        i.subData = {
                                            endpoint: i.getEndpoint(t),
                                            p256dh: e ? window.btoa(String.fromCharCode.apply(null, new Uint8Array(e))) : null,
                                            auth: o ? window.btoa(String.fromCharCode.apply(null, new Uint8Array(o))) : null
                                        }, i.fire("onSubscriptionSuccess", [i.subData])
                                    }).catch(function (t) {
                                        i.fire("onWorkerError", [t])
                                    })
                                })
                            }) : i.fire("onWorkerNotSupported")) : "denied" === o && (t.fire("onPermissionDenied"), t.unregisterWorker())
                        };
                    "default" === o ? window.Notification && window.Notification.requestPermission ? window.Notification.requestPermission(n) : window.webkitNotifications && window.webkitNotifications.checkPermission && window.webkitNotifications.requestPermission(n) : n(o)
                }
            }]), t
        }()
    }, function (t, e, i) {
        (function (e, o) {
            ! function (e, i) {
                t.exports = i()
            }(0, function () {
                "use strict";

                function t(t) {
                    var e = typeof t;
                    return null !== t && ("object" === e || "function" === e)
                }

                function n(t) {
                    return "function" == typeof t
                }

                function r(t) {
                    U = t
                }

                function s(t) {
                    Y = t
                }

                function a() {
                    return void 0 !== N ? function () {
                        N(c)
                    } : l()
                }

                function l() {
                    var t = setTimeout;
                    return function () {
                        return t(c, 1)
                    }
                }

                function c() {
                    for (var t = 0; t < R; t += 2) {
                        (0, K[t])(K[t + 1]), K[t] = void 0, K[t + 1] = void 0
                    }
                    R = 0
                }

                function d(t, e) {
                    var i = arguments,
                        o = this,
                        n = new this.constructor(p);
                    void 0 === n[tt] && $(n);
                    var r = o._state;
                    return r ? function () {
                        var t = i[r - 1];
                        Y(function () {
                            return O(r, n, t, o._result)
                        })
                    }() : k(o, n, t, e), n
                }

                function u(t) {
                    var e = this;
                    if (t && "object" == typeof t && t.constructor === e) return t;
                    var i = new e(p);
                    return b(i, t), i
                }

                function p() {}

                function h() {
                    return new TypeError("You cannot resolve a promise with itself")
                }

                function f() {
                    return new TypeError("A promises callback cannot return that same promise.")
                }

                function m(t) {
                    try {
                        return t.then
                    } catch (t) {
                        return nt.error = t, nt
                    }
                }

                function g(t, e, i, o) {
                    try {
                        t.call(e, i, o)
                    } catch (t) {
                        return t
                    }
                }

                function v(t, e, i) {
                    Y(function (t) {
                        var o = !1,
                            n = g(i, e, function (i) {
                                o || (o = !0, e !== i ? b(t, i) : x(t, i))
                            }, function (e) {
                                o || (o = !0, C(t, e))
                            }, "Settle: " + (t._label || " unknown promise"));
                        !o && n && (o = !0, C(t, n))
                    }, t)
                }

                function y(t, e) {
                    e._state === it ? x(t, e._result) : e._state === ot ? C(t, e._result) : k(e, void 0, function (e) {
                        return b(t, e)
                    }, function (e) {
                        return C(t, e)
                    })
                }

                function w(t, e, i) {
                    e.constructor === t.constructor && i === d && e.constructor.resolve === u ? y(t, e) : i === nt ? (C(t, nt.error), nt.error = null) : void 0 === i ? x(t, e) : n(i) ? v(t, e, i) : x(t, e)
                }

                function b(e, i) {
                    e === i ? C(e, h()) : t(i) ? w(e, i, m(i)) : x(e, i)
                }

                function S(t) {
                    t._onerror && t._onerror(t._result), _(t)
                }

                function x(t, e) {
                    t._state === et && (t._result = e, t._state = it, 0 !== t._subscribers.length && Y(_, t))
                }

                function C(t, e) {
                    t._state === et && (t._state = ot, t._result = e, Y(S, t))
                }

                function k(t, e, i, o) {
                    var n = t._subscribers,
                        r = n.length;
                    t._onerror = null, n[r] = e, n[r + it] = i, n[r + ot] = o, 0 === r && t._state && Y(_, t)
                }

                function _(t) {
                    var e = t._subscribers,
                        i = t._state;
                    if (0 !== e.length) {
                        for (var o = void 0, n = void 0, r = t._result, s = 0; s < e.length; s += 3) o = e[s], n = e[s + i], o ? O(i, o, n, r) : n(r);
                        t._subscribers.length = 0
                    }
                }

                function T() {
                    this.error = null
                }

                function E(t, e) {
                    try {
                        return t(e)
                    } catch (t) {
                        return rt.error = t, rt
                    }
                }

                function O(t, e, i, o) {
                    var r = n(i),
                        s = void 0,
                        a = void 0,
                        l = void 0,
                        c = void 0;
                    if (r) {
                        if (s = E(i, o), s === rt ? (c = !0, a = s.error, s.error = null) : l = !0, e === s) return void C(e, f())
                    } else s = o, l = !0;
                    e._state !== et || (r && l ? b(e, s) : c ? C(e, a) : t === it ? x(e, s) : t === ot && C(e, s))
                }

                function I(t, e) {
                    try {
                        e(function (e) {
                            b(t, e)
                        }, function (e) {
                            C(t, e)
                        })
                    } catch (e) {
                        C(t, e)
                    }
                }

                function z() {
                    return st++
                }

                function $(t) {
                    t[tt] = st++, t._state = void 0, t._result = void 0, t._subscribers = []
                }

                function A(t, e) {
                    this._instanceConstructor = t, this.promise = new t(p), this.promise[tt] || $(this.promise), F(e) ? (this.length = e.length, this._remaining = e.length, this._result = new Array(this.length), 0 === this.length ? x(this.promise, this._result) : (this.length = this.length || 0, this._enumerate(e), 0 === this._remaining && x(this.promise, this._result))) : C(this.promise, P())
                }

                function P() {
                    return new Error("Array Methods must be provided an Array")
                }

                function M(t) {
                    return new A(this, t).promise
                }

                function L(t) {
                    var e = this;
                    return new e(F(t) ? function (i, o) {
                        for (var n = t.length, r = 0; r < n; r++) e.resolve(t[r]).then(i, o)
                    } : function (t, e) {
                        return e(new TypeError("You must pass an array to race."))
                    })
                }

                function B(t) {
                    var e = this,
                        i = new e(p);
                    return C(i, t), i
                }

                function D() {
                    throw new TypeError("You must pass a resolver function as the first argument to the promise constructor")
                }

                function W() {
                    throw new TypeError("Failed to construct 'Promise': Please use the 'new' operator, this object constructor cannot be called as a function.")
                }

                function H(t) {
                    this[tt] = z(), this._result = this._state = void 0, this._subscribers = [], p !== t && ("function" != typeof t && D(), this instanceof H ? I(this, t) : W())
                }

                function j() {
                    var t = void 0;
                    if (void 0 !== o) t = o;
                    else if ("undefined" != typeof self) t = self;
                    else try {
                        t = Function("return this")()
                    } catch (t) {
                        throw new Error("polyfill failed because global object is unavailable in this environment")
                    }
                    var e = t.Promise;
                    if (e) {
                        var i = null;
                        try {
                            i = Object.prototype.toString.call(e.resolve())
                        } catch (t) {}
                        if ("[object Promise]" === i && !e.cast) return
                    }
                    t.Promise = H
                }
                var q = void 0;
                q = Array.isArray ? Array.isArray : function (t) {
                    return "[object Array]" === Object.prototype.toString.call(t)
                };
                var F = q,
                    R = 0,
                    N = void 0,
                    U = void 0,
                    Y = function (t, e) {
                        K[R] = t, K[R + 1] = e, 2 === (R += 2) && (U ? U(c) : J())
                    },
                    Q = "undefined" != typeof window ? window : void 0,
                    V = Q || {},
                    X = V.MutationObserver || V.WebKitMutationObserver,
                    G = "undefined" == typeof self && void 0 !== e && "[object process]" === {}.toString.call(e),
                    Z = "undefined" != typeof Uint8ClampedArray && "undefined" != typeof importScripts && "undefined" != typeof MessageChannel,
                    K = new Array(1e3),
                    J = void 0;
                J = G ? function () {
                    return function () {
                        return e.nextTick(c)
                    }
                }() : X ? function () {
                    var t = 0,
                        e = new X(c),
                        i = document.createTextNode("");
                    return e.observe(i, {
                            characterData: !0
                        }),
                        function () {
                            i.data = t = ++t % 2
                        }
                }() : Z ? function () {
                    var t = new MessageChannel;
                    return t.port1.onmessage = c,
                        function () {
                            return t.port2.postMessage(0)
                        }
                }() : void 0 === Q ? function () {
                    try {
                        var t = i(9);
                        return N = t.runOnLoop || t.runOnContext, a()
                    } catch (t) {
                        return l()
                    }
                }() : l();
                var tt = Math.random().toString(36).substring(16),
                    et = void 0,
                    it = 1,
                    ot = 2,
                    nt = new T,
                    rt = new T,
                    st = 0;
                return A.prototype._enumerate = function (t) {
                    for (var e = 0; this._state === et && e < t.length; e++) this._eachEntry(t[e], e)
                }, A.prototype._eachEntry = function (t, e) {
                    var i = this._instanceConstructor,
                        o = i.resolve;
                    if (o === u) {
                        var n = m(t);
                        if (n === d && t._state !== et) this._settledAt(t._state, e, t._result);
                        else if ("function" != typeof n) this._remaining--, this._result[e] = t;
                        else if (i === H) {
                            var r = new i(p);
                            w(r, t, n), this._willSettleAt(r, e)
                        } else this._willSettleAt(new i(function (e) {
                            return e(t)
                        }), e)
                    } else this._willSettleAt(o(t), e)
                }, A.prototype._settledAt = function (t, e, i) {
                    var o = this.promise;
                    o._state === et && (this._remaining--, t === ot ? C(o, i) : this._result[e] = i), 0 === this._remaining && x(o, this._result)
                }, A.prototype._willSettleAt = function (t, e) {
                    var i = this;
                    k(t, void 0, function (t) {
                        return i._settledAt(it, e, t)
                    }, function (t) {
                        return i._settledAt(ot, e, t)
                    })
                }, H.all = M, H.race = L, H.resolve = u, H.reject = B, H._setScheduler = r, H._setAsap = s, H._asap = Y, H.prototype = {
                    constructor: H,
                    then: d,
                    catch: function (t) {
                        return this.then(null, t)
                    }
                }, H.polyfill = j, H.Promise = H, H
            })
        }).call(e, i(7), i(8))
    }, function (t, e) {}, function (t, e, i) {
        "use strict";

        function o(t) {
            if (t && t.__esModule) return t;
            var e = {};
            if (null != t)
                for (var i in t) Object.prototype.hasOwnProperty.call(t, i) && (e[i] = t[i]);
            return e.default = t, e
        }

        function n(t, e) {
            if (!(t instanceof e)) throw new TypeError("Cannot call a class as a function")
        }
        Object.defineProperty(e, "__esModule", {
            value: !0
        });
        var r = function () {
            function t(t, e) {
                for (var i = 0; i < e.length; i++) {
                    var o = e[i];
                    o.enumerable = o.enumerable || !1, o.configurable = !0, "value" in o && (o.writable = !0), Object.defineProperty(t, o.key, o)
                }
            }
            return function (e, i, o) {
                return i && t(e.prototype, i), o && t(e, o), e
            }
        }();
        i(5);
        var s = i(4),
            a = function (t) {
                return t && t.__esModule ? t : {
                    default: t
                }
            }(s),
            l = i(0),
            c = o(l),
            d = i(1),
            u = o(d),
            p = i(2),
            h = i(3),
            f = function () {
                function t() {
                    var e = arguments.length > 0 && void 0 !== arguments[0] ? arguments[0] : {};
                    return n(this, t), this.options = c.deepExtend({}, u.Defaults, e), this.id = this.options.id || c.generateID("bar"), this.closeTimer = -1, this.barDom = null, this.layoutDom = null, this.progressDom = null, this.showing = !1, this.shown = !1, this.closed = !1, this.closing = !1, this.killable = this.options.timeout || this.options.closeWith.length > 0, this.hasSound = this.options.sounds.sources.length > 0, this.soundPlayed = !1, this.listeners = {
                        beforeShow: [],
                        onShow: [],
                        afterShow: [],
                        onClose: [],
                        afterClose: [],
                        onClick: [],
                        onHover: [],
                        onTemplate: []
                    }, this.promises = {
                        show: null,
                        close: null
                    }, this.on("beforeShow", this.options.callbacks.beforeShow), this.on("onShow", this.options.callbacks.onShow), this.on("afterShow", this.options.callbacks.afterShow), this.on("onClose", this.options.callbacks.onClose), this.on("afterClose", this.options.callbacks.afterClose), this.on("onClick", this.options.callbacks.onClick), this.on("onHover", this.options.callbacks.onHover), this.on("onTemplate", this.options.callbacks.onTemplate), this
                }
                return r(t, [{
                    key: "on",
                    value: function (t) {
                        var e = arguments.length > 1 && void 0 !== arguments[1] ? arguments[1] : function () {};
                        return "function" == typeof e && this.listeners.hasOwnProperty(t) && this.listeners[t].push(e), this
                    }
                }, {
                    key: "show",
                    value: function () {
                        var e = this;
                        !0 === this.options.killer ? t.closeAll() : "string" == typeof this.options.killer && t.closeAll(this.options.killer);
                        var i = u.getQueueCounts(this.options.queue);
                        if (i.current >= i.maxVisible || u.PageHidden && this.options.visibilityControl) return u.addToQueue(this), u.PageHidden && this.hasSound && c.inArray("docHidden", this.options.sounds.conditions) && c.createAudioElements(this), u.PageHidden && c.inArray("docHidden", this.options.titleCount.conditions) && u.docTitle.increment(), this;
                        if (u.Store[this.id] = this, u.fire(this, "beforeShow"), this.showing = !0, this.closing) return this.showing = !1, this;
                        if (u.build(this), u.handleModal(this), this.options.force ? this.layoutDom.insertBefore(this.barDom, this.layoutDom.firstChild) : this.layoutDom.appendChild(this.barDom), this.hasSound && !this.soundPlayed && c.inArray("docVisible", this.options.sounds.conditions) && c.createAudioElements(this), c.inArray("docVisible", this.options.titleCount.conditions) && u.docTitle.increment(), this.shown = !0, this.closed = !1, u.hasButtons(this) && Object.keys(this.options.buttons).forEach(function (t) {
                                var i = e.barDom.querySelector("#" + e.options.buttons[t].id);
                                c.addListener(i, "click", function (i) {
                                    c.stopPropagation(i), e.options.buttons[t].cb()
                                })
                            }), this.progressDom = this.barDom.querySelector(".noty_progressbar"), c.inArray("click", this.options.closeWith) && (c.addClass(this.barDom, "noty_close_with_click"), c.addListener(this.barDom, "click", function (t) {
                                c.stopPropagation(t), u.fire(e, "onClick"), e.close()
                            }, !1)), c.addListener(this.barDom, "mouseenter", function () {
                                u.fire(e, "onHover")
                            }, !1), this.options.timeout && c.addClass(this.barDom, "noty_has_timeout"), this.options.progressBar && c.addClass(this.barDom, "noty_has_progressbar"), c.inArray("button", this.options.closeWith)) {
                            c.addClass(this.barDom, "noty_close_with_button");
                            var o = document.createElement("div");
                            c.addClass(o, "noty_close_button"), o.innerHTML = "×", this.barDom.appendChild(o), c.addListener(o, "click", function (t) {
                                c.stopPropagation(t), e.close()
                            }, !1)
                        }
                        return u.fire(this, "onShow"), null === this.options.animation.open ? this.promises.show = new a.default(function (t) {
                            t()
                        }) : "function" == typeof this.options.animation.open ? this.promises.show = new a.default(this.options.animation.open.bind(this)) : (c.addClass(this.barDom, this.options.animation.open), this.promises.show = new a.default(function (t) {
                            c.addListener(e.barDom, c.animationEndEvents, function () {
                                c.removeClass(e.barDom, e.options.animation.open), t()
                            })
                        })), this.promises.show.then(function () {
                            var t = e;
                            setTimeout(function () {
                                u.openFlow(t)
                            }, 100)
                        }), this
                    }
                }, {
                    key: "stop",
                    value: function () {
                        return u.dequeueClose(this), this
                    }
                }, {
                    key: "resume",
                    value: function () {
                        return u.queueClose(this), this
                    }
                }, {
                    key: "setTimeout",
                    value: function (t) {
                        function e(e) {
                            return t.apply(this, arguments)
                        }
                        return e.toString = function () {
                            return t.toString()
                        }, e
                    }(function (t) {
                        if (this.stop(), this.options.timeout = t, this.barDom) {
                            this.options.timeout ? c.addClass(this.barDom, "noty_has_timeout") : c.removeClass(this.barDom, "noty_has_timeout");
                            var e = this;
                            setTimeout(function () {
                                e.resume()
                            }, 100)
                        }
                        return this
                    })
                }, {
                    key: "setText",
                    value: function (t) {
                        var e = arguments.length > 1 && void 0 !== arguments[1] && arguments[1];
                        return this.barDom && (this.barDom.querySelector(".noty_body").innerHTML = t), e && (this.options.text = t), this
                    }
                }, {
                    key: "setType",
                    value: function (t) {
                        var e = this,
                            i = arguments.length > 1 && void 0 !== arguments[1] && arguments[1];
                        if (this.barDom) {
                            c.classList(this.barDom).split(" ").forEach(function (t) {
                                "noty_type__" === t.substring(0, 11) && c.removeClass(e.barDom, t)
                            }), c.addClass(this.barDom, "noty_type__" + t)
                        }
                        return i && (this.options.type = t), this
                    }
                }, {
                    key: "setTheme",
                    value: function (t) {
                        var e = this,
                            i = arguments.length > 1 && void 0 !== arguments[1] && arguments[1];
                        if (this.barDom) {
                            c.classList(this.barDom).split(" ").forEach(function (t) {
                                "noty_theme__" === t.substring(0, 12) && c.removeClass(e.barDom, t)
                            }), c.addClass(this.barDom, "noty_theme__" + t)
                        }
                        return i && (this.options.theme = t), this
                    }
                }, {
                    key: "close",
                    value: function () {
                        var t = this;
                        return this.closed ? this : this.shown ? (u.fire(this, "onClose"), this.closing = !0, null === this.options.animation.close ? this.promises.close = new a.default(function (t) {
                            t()
                        }) : "function" == typeof this.options.animation.close ? this.promises.close = new a.default(this.options.animation.close.bind(this)) : (c.addClass(this.barDom, this.options.animation.close), this.promises.close = new a.default(function (e) {
                            c.addListener(t.barDom, c.animationEndEvents, function () {
                                t.options.force ? c.remove(t.barDom) : u.ghostFix(t), e()
                            })
                        })), this.promises.close.then(function () {
                            u.closeFlow(t), u.handleModalClose(t)
                        }), this.closed = !0, this) : (u.removeFromQueue(this), this)
                    }
                }], [{
                    key: "closeAll",
                    value: function () {
                        var t = arguments.length > 0 && void 0 !== arguments[0] && arguments[0];
                        return Object.keys(u.Store).forEach(function (e) {
                            t ? u.Store[e].options.queue === t && u.Store[e].killable && u.Store[e].close() : u.Store[e].killable && u.Store[e].close()
                        }), this
                    }
                }, {
                    key: "overrideDefaults",
                    value: function (t) {
                        return u.Defaults = c.deepExtend({}, u.Defaults, t), this
                    }
                }, {
                    key: "setMaxVisible",
                    value: function () {
                        var t = arguments.length > 0 && void 0 !== arguments[0] ? arguments[0] : u.DefaultMaxVisible,
                            e = arguments.length > 1 && void 0 !== arguments[1] ? arguments[1] : "global";
                        return u.Queues.hasOwnProperty(e) || (u.Queues[e] = {
                            maxVisible: t,
                            queue: []
                        }), u.Queues[e].maxVisible = t, this
                    }
                }, {
                    key: "button",
                    value: function (t) {
                        var e = arguments.length > 1 && void 0 !== arguments[1] ? arguments[1] : null,
                            i = arguments[2],
                            o = arguments.length > 3 && void 0 !== arguments[3] ? arguments[3] : {};
                        return new p.NotyButton(t, e, i, o)
                    }
                }, {
                    key: "version",
                    value: function () {
                        return "3.1.4"
                    }
                }, {
                    key: "Push",
                    value: function (t) {
                        return new h.Push(t)
                    }
                }]), t
            }();
        e.default = f, c.visibilityChangeFlow(), t.exports = e.default
    }, function (t, e) {
        function i() {
            throw new Error("setTimeout has not been defined")
        }

        function o() {
            throw new Error("clearTimeout has not been defined")
        }

        function n(t) {
            if (d === setTimeout) return setTimeout(t, 0);
            if ((d === i || !d) && setTimeout) return d = setTimeout, setTimeout(t, 0);
            try {
                return d(t, 0)
            } catch (e) {
                try {
                    return d.call(null, t, 0)
                } catch (e) {
                    return d.call(this, t, 0)
                }
            }
        }

        function r(t) {
            if (u === clearTimeout) return clearTimeout(t);
            if ((u === o || !u) && clearTimeout) return u = clearTimeout, clearTimeout(t);
            try {
                return u(t)
            } catch (e) {
                try {
                    return u.call(null, t)
                } catch (e) {
                    return u.call(this, t)
                }
            }
        }

        function s() {
            m && h && (m = !1, h.length ? f = h.concat(f) : g = -1, f.length && a())
        }

        function a() {
            if (!m) {
                var t = n(s);
                m = !0;
                for (var e = f.length; e;) {
                    for (h = f, f = []; ++g < e;) h && h[g].run();
                    g = -1, e = f.length
                }
                h = null, m = !1, r(t)
            }
        }

        function l(t, e) {
            this.fun = t, this.array = e
        }

        function c() {}
        var d, u, p = t.exports = {};
        ! function () {
            try {
                d = "function" == typeof setTimeout ? setTimeout : i
            } catch (t) {
                d = i
            }
            try {
                u = "function" == typeof clearTimeout ? clearTimeout : o
            } catch (t) {
                u = o
            }
        }();
        var h, f = [],
            m = !1,
            g = -1;
        p.nextTick = function (t) {
            var e = new Array(arguments.length - 1);
            if (arguments.length > 1)
                for (var i = 1; i < arguments.length; i++) e[i - 1] = arguments[i];
            f.push(new l(t, e)), 1 !== f.length || m || n(a)
        }, l.prototype.run = function () {
            this.fun.apply(null, this.array)
        }, p.title = "browser", p.browser = !0, p.env = {}, p.argv = [], p.version = "", p.versions = {}, p.on = c, p.addListener = c, p.once = c, p.off = c, p.removeListener = c, p.removeAllListeners = c, p.emit = c, p.prependListener = c, p.prependOnceListener = c, p.listeners = function (t) {
            return []
        }, p.binding = function (t) {
            throw new Error("process.binding is not supported")
        }, p.cwd = function () {
            return "/"
        }, p.chdir = function (t) {
            throw new Error("process.chdir is not supported")
        }, p.umask = function () {
            return 0
        }
    }, function (t, e) {
        var i;
        i = function () {
            return this
        }();
        try {
            i = i || Function("return this")() || (0, eval)("this")
        } catch (t) {
            "object" == typeof window && (i = window)
        }
        t.exports = i
    }, function (t, e) {}])
}), jQuery.fn.retina = function (t) {
    var e = {
        retina_part: "-2x"
    };
    t && jQuery.extend(config, e), window.devicePixelRatio >= 2 && this.each(function (t, i) {
        if ($(i).attr("src")) {
            var o = $(i).attr("src").replace(/(.+)(\.\w{3,4})$/, "$1" + e.retina_part + "$2");
            $.ajax({
                url: o,
                type: "HEAD",
                success: function () {
                    $(i).attr("src", o)
                }
            })
        }
    })
};