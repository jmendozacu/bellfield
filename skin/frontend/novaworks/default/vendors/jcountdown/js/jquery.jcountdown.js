(function($) {
    $.fn.countdown = function( method /*, options*/ ) {
        var msPerHr = 3600000,
            secPerYear = 31557600,
            secPerMonth = 2629800,
            secPerWeek = 604800,
            secPerDay = 86400,
            secPerHr = 3600,
            secPerMin = 60,
            secPerSec = 1,
            rTemplateTokens = /%y|%m|%w|%d|%h|%i|%s/g,
            rDigitGlobal = /\d/g,
            localNumber = function( numToConvert, settings ) {
                var arr = numToConvert.toString().match(rDigitGlobal),
                    localeNumber = "";
                $.each( arr, function(i,num) {
                    num = Number(num);
                    localeNumber += (""+ settings.digits[num]) || ""+num;
                });
			return localeNumber; },
            generateTemplateCustom = function( settings ) {
                var template = settings.template,
                    $parent = $('<div>'),
                    $timeWrapElement = settings.dom.$time.addClass( settings.timeWrapClass ),
                    $textWrapElement = $("<"+settings.textWrapElement+">").addClass( settings.textWrapClass ),
                    sep = settings.timeSeparator,
                    yearsLeft = settings.yearsLeft,
                    monthsLeft = settings.monthsLeft,
                    weeksLeft = settings.weeksLeft,
                    daysLeft = settings.daysLeft,
                    hrsLeft = settings.hrsLeft,
                    minsLeft = settings.minsLeft,
                    secLeft = settings.secLeft,
                    hideYears = false,
                    hideMonths = false,
                    hideWeeks = false,
                    hideDays = false,
                    hideHours = false,
                    hideMins = false,
                    hideSecs = false,
                    timeTasks = [],
                    formatTime = function(time, text, showSeparator) {
                        return '<span>'+time+'</span><span>'+text+'</span>';
                    };

                if( settings.omitZero ) {
                    if( settings.yearsAndMonths ) {
                        if( !settings.yearsLeft ) {hideYears = true;}
                        if( !settings.monthsLeft ) {hideMonths = true;}
                    }
                    if( settings.weeks && ( ( settings.yearsAndMonths && hideMonths && !settings.weeksLeft ) || ( !settings.yearsAndMonths && !settings.weeksLeft ) ) ) {
					hideWeeks = true;}
                    if( hideWeeks && !daysLeft ) {hideDays = true; }
                    if( hideDays && !hrsLeft ) {hideHours = true;}
                    if( hideHours && !minsLeft ) {hideMins = true;}
                }
                if( settings.leadingZero ) {
                    if( yearsLeft < 10 ) {yearsLeft = "0" + yearsLeft;}
                    if( monthsLeft < 10 ) {monthsLeft = "0" + monthsLeft;}
                    if( weeksLeft < 10 ) {weeksLeft = "0" + weeksLeft;}
                    if( daysLeft < 10 ) {daysLeft = "0" + daysLeft;}
                    if( hrsLeft < 10 ) { hrsLeft = "0" + hrsLeft;}
                    if( minsLeft < 10 ) {minsLeft = "0" + minsLeft;}
                    if( secLeft < 10 ) {secLeft = "0" + secLeft;}
                }
                yearsLeft = localNumber( yearsLeft, settings );
                monthsLeft = localNumber( monthsLeft, settings );
                weeksLeft = localNumber( weeksLeft, settings );
                daysLeft = localNumber( daysLeft, settings );
                hrsLeft = localNumber( hrsLeft, settings );
                minsLeft = localNumber( minsLeft, settings );
                secLeft = localNumber( secLeft, settings );
                if( settings.yearsAndMonths ) {
                    if( !settings.omitZero || !hideYears  ) {
                        template = template.replace('%y', formatTime(yearsLeft, (yearsLeft == 1 && settings.yearSingularText) ? settings.yearSingularText : settings.yearText, true));
                    }
                    if( !settings.omitZero || ( !hideYears && monthsLeft ) || ( !hideYears && !hideMonths ) ) {
                        template = template.replace('%m', formatTime(monthsLeft, (monthsLeft == 1 && settings.monthSingularText) ? settings.monthSingularText : settings.monthText, true));
                    } else {
                        template = template.replace('%m', '');
                    }
                }

                if( settings.weeks && !hideWeeks ) {
                    template = template.replace('%w', formatTime(weeksLeft, (weeksLeft == 1 && settings.weekSingularText) ? settings.weekSingularText : settings.weekText, true));
                } else { template = template.replace('%w', '');}
                if( !hideDays ) {
                    template = template.replace('%d', formatTime(daysLeft, (daysLeft == 1 && settings.daySingularText) ? settings.daySingularText : settings.dayText, true));
                } else {template = template.replace('%d', ''); }
                if( !hideHours ) {
                    template = template.replace('%h', formatTime(hrsLeft, (hrsLeft == 1 && settings.hourSingularText) ? settings.hourSingularText : settings.hourText, true));
                } else {template = template.replace('%h', ''); }
                if( !hideMins ) {
                    template = template.replace('%i', formatTime(minsLeft, (minsLeft == 1 && settings.minSingularText) ? settings.minSingularText : settings.minText, true));
                } else {template = template.replace('%i', ''); }
                template = template.replace('%s', formatTime(secLeft, (secLeft == 1 && settings.secSingularText) ? settings.secSingularText : settings.secText));
                template = template.replace(rTemplateTokens,'');
                return template;
            },
            generateTemplate = function( settings ) {
                var $parent = $('<div>'),
                    $timeWrapElement = $("<"+settings.timeWrapElement+">").addClass( settings.timeWrapClass ),
                    $textWrapElement = $("<"+settings.textWrapElement+">").addClass( settings.textWrapClass ),
                    sep = settings.timeSeparator,
                    yearsLeft = settings.yearsLeft,
                    monthsLeft = settings.monthsLeft,
                    weeksLeft = settings.weeksLeft,
                    daysLeft = settings.daysLeft,
                    hrsLeft = settings.hrsLeft,
                    minsLeft = settings.minsLeft,
                    secLeft = settings.secLeft,
                    template = settings.template,
                    hasTemplate = !!settings.template,
                    hideYears = false,
                    hideMonths = false,
                    hideWeeks = false,
                    hideDays = false,
                    hideHours = false,
                    hideMins = false,
                    hideSecs = false,
                    timeTasks = [],
                    addTime = function( time ) {
                        timeTasks.push(function() {
                            $parent.append( $timeWrapElement.clone().html( time + settings.spaceCharacter ) );
                        });
                    },
                    addText = function( text ) {
                        timeTasks.push(function() {
                            $parent.append( $textWrapElement.clone().html( text + settings.spaceCharacter ) );
                        });
                    },
                    addSeparator = function() {
                        timeTasks.push(function() {
                            $parent.append( $textWrapElement.clone().html( settings.spaceCharacter + sep + settings.spaceCharacter) );
                        });
                    },
                    formatTime = function(time, text, showSeparator) {
                        return '<span>'+time+'</span><span>'+text+'</span>';
                    };
                if( settings.template ){return generateTemplateCustom( settings );}
                if( settings.omitZero ) {
                    if( settings.yearsAndMonths ) {
					if( !settings.yearsLeft ) {hideYears = true;}
                        if( !settings.monthsLeft ) {hideMonths = true;}
                    }
                    if( settings.weeks && ( ( settings.yearsAndMonths && hideMonths && !settings.weeksLeft ) || ( !settings.yearsAndMonths && !settings.weeksLeft ) ) ) {
                        hideWeeks = true;
                    }
                    if( hideWeeks && !daysLeft ) {hideDays = true;}
                    if( hideDays && !hrsLeft ) {hideHours = true;}
                    if( hideHours && !minsLeft ) {hideMins = true;}
                }
                if( settings.leadingZero ) {
                    if( yearsLeft < 10 ) {yearsLeft = "0" + yearsLeft;}
                    if( monthsLeft < 10 ) {monthsLeft = "0" + monthsLeft;}
                    if( weeksLeft < 10 ) {weeksLeft = "0" + weeksLeft;}
                    if( daysLeft < 10 ) {daysLeft = "0" + daysLeft;}
                    if( hrsLeft < 10 ) {hrsLeft = "0" + hrsLeft;}
                    if( minsLeft < 10 ) {minsLeft = "0" + minsLeft;}
                    if( secLeft < 10 ) {secLeft = "0" + secLeft;}
                }
                yearsLeft = localNumber( yearsLeft, settings );
                monthsLeft = localNumber( monthsLeft, settings );
                weeksLeft = localNumber( weeksLeft, settings );
                daysLeft = localNumber( daysLeft, settings );
                hrsLeft = localNumber( hrsLeft, settings );
                minsLeft = localNumber( minsLeft, settings );
                secLeft = localNumber( secLeft, settings );
                if( settings.yearsAndMonths ) {
                    if( !settings.omitZero || !hideYears  ) {
                        addTime( yearsLeft );
                        addText( (yearsLeft == 1 && settings.yearSingularText) ? settings.yearSingularText : settings.yearText );
                        addSeparator();
                    }
                    if( !settings.omitZero || ( !hideYears && monthsLeft ) || ( !hideYears && !hideMonths ) ) {
                        addTime( monthsLeft );
                        addText( (monthsLeft == 1 && settings.monthSingularText) ? settings.monthSingularText : settings.monthText );
                        addSeparator();
                    }
                }
                if( settings.weeks && !hideWeeks ) {
                    addTime( weeksLeft );
                    addText( (weeksLeft == 1 && settings.weekSingularText) ? settings.weekSingularText : settings.weekText );
                    addSeparator();
                }
                if( !hideDays ) {
                    addTime( daysLeft );
                    addText( (daysLeft == 1 && settings.daySingularText) ? settings.daySingularText : settings.dayText );
                    addSeparator();
                }
                if( !hideHours ) {
                    addTime( hrsLeft );
                    addText( (hrsLeft == 1 && settings.hourSingularText) ? settings.hourSingularText : settings.hourText );
                    addSeparator();
                }
                if( !hideMins ) {
                    addTime( minsLeft );
                    addText( (minsLeft == 1 && settings.minSingularText) ? settings.minSingularText  : settings.minText );
                    addSeparator();
                }
                addTime( secLeft );
                addText( (secLeft == 1 && settings.secSingularText) ? settings.secSingularText  : settings.secText );
                if( settings.isRTL === true ) {timeTasks.reverse();}
                $.each( timeTasks, function(i,task ) {task(); });
                template = $parent.html();
                return template;
            },
            dateNow = function( $this ) {
                var now = new Date(),
                    settings = $this.data("jcdData");
                if( !settings ) {return new Date(); }
                if( settings.offset !== null ) {now = getTZDate( settings.offset );}
                now.setMilliseconds(0);
                return now;
            },
            getTZDate = function( offset ) {
                var hrs,
                    dateMS,
                    curHrs,
                    tmpDate = new Date();
                if( offset !== null ) {
                    hrs = offset * msPerHr;
                    curHrs = tmpDate.getTime() - ( ( -tmpDate.getTimezoneOffset() / 60 ) * msPerHr ) + hrs;
                    dateMS = tmpDate.setTime( curHrs );
                }
                return new Date( dateMS );
            },
            timerFunc = function() {
                var $this = this,
                    template,
                    now,
                    date,
                    timeLeft,
                    yearsLeft = 0,
                    monthsLeft = 0,
                    weeksLeft = 0,
                    daysLeft = 0,
                    hrsLeft = 0,
                    minsLeft = 0,
                    secLeft = 0,
                    time = "",
                    diff,
                    hideYears = false,
                    hideMonths = false,
                    hideWeeks = false,
                    hideDays = false,
                    hideHours = false,
                    hideMins = false,
                    hideSecs = false,
                    extractSection = function( numSecs ) {
                        var amount;
                        amount = Math.floor( diff / numSecs );
                        diff -= amount * numSecs;
                        return amount;
                    },
                    settings = $this.data("jcdData");
                if( !settings ) { return false;   }
                template = settings.htmlTemplate;
                now = dateNow( $this );
                if( settings.serverDiff !== null ) {
                    date = new Date( settings.serverDiff + settings.clientdateNow.getTime() );
                } else {
                    date = settings.dateObj; 
                }
                date.setMilliseconds(0);
                timeLeft = ( settings.direction === "down" ) ? date.getTime() - now.getTime() : now.getTime() - date.getTime();
                diff = Math.round( timeLeft / 1000 );
                daysLeft = extractSection( secPerDay );
                hrsLeft = extractSection( secPerHr );
                minsLeft = extractSection( secPerMin );
                secLeft = extractSection( secPerSec );
                if( settings.yearsAndMonths ) {
                    diff += ( daysLeft * secPerDay );
                    yearsLeft = extractSection( secPerYear );
                    monthsLeft = extractSection( secPerMonth );
                    daysLeft = extractSection( secPerDay );
                }
                if( settings.weeks ) {
                    diff += ( daysLeft * secPerDay );
                    weeksLeft = extractSection( secPerWeek );
                    daysLeft = extractSection( secPerDay );
                }
                if( settings.hoursOnly || settings.minsOnly || settings.secsOnly )
                {
                    if( settings.yearsAndMonths ) {
                        diff += ( yearsLeft * secPerYear );
                        diff += ( monthsLeft * secPerMonth );
                        yearsLeft = monthsLeft = 0;
                    }
                    if( settings.weeks ) {
                        diff += ( weeksLeft * secPerWeek );
                        weeksLeft = 0;
                    }
                }
                if( settings.hoursOnly ) {
                    diff += ( daysLeft * secPerDay );
                    diff += ( hrsLeft * secPerHr );
                    hrsLeft = extractSection( secPerHr );
                }
                if( settings.minsOnly ) {
                   diff += ( daysLeft * secPerDay );
                    daysLeft = 0;
                    diff += ( hrsLeft * secPerHr );
                    hrsLeft = 0;
                    diff += ( minsLeft * secPerMin );
                    minsLeft = extractSection( secPerMin );
                }
                if( settings.secsOnly ) {
                    diff += ( daysLeft * secPerDay );
                    daysLeft = 0;
                    diff += ( hrsLeft * secPerHr );
                    hrsLeft = 0;
                    diff += ( minsLeft * secPerMin );
                    minsLeft = 0;
                    diff += secLeft;
                    secLeft = extractSection( secPerSec );
                }
                settings.yearsLeft = yearsLeft;
                settings.monthsLeft = monthsLeft;
                settings.weeksLeft = weeksLeft;
                settings.daysLeft = daysLeft;
                settings.hrsLeft = hrsLeft;
                settings.minsLeft = minsLeft;
                settings.secLeft = secLeft;
                $this.data("jcdData", settings);
                if ( ( settings.direction === "down" && ( now < date || settings.minus ) ) || ( settings.direction === "up" && ( date < now || settings.minus )  ) ) {
                    time = generateTemplate( settings );
                } else {
                    settings.yearsLeft = settings.monthsLeft = settings.weeksLeft = settings.daysLeft = settings.hrsLeft = settings.minsLeft = settings.secLeft = 0;

                    time = generateTemplate( settings );
                    settings.hasCompleted = true;
                }
                $this.html( time ).triggerMulti("change.jcdevt,countChange", [settings]);
                if ( settings.hasCompleted ) {
                    $this.triggerMulti("complete.jcdevt,countComplete");
                    clearInterval( settings.timer );
                }
            },
            methods = {
                init: function( options ) {
                    var opts = $.extend( {}, $.fn.countdown.defaults, options ),
                        local = null,
                        testDate,
                        testString;
                    return this.each(function() {
                        var $this = $(this),
                            settings = {},
                            func;
                        if( $this.data("jcdData") ) {
                            $this.countdown("changeSettings", options, true);
                            opts = $this.data("jcdData");
                       }
                        if( opts.date === null && opts.dataAttr === null ) {
                            $.error("No Date passed to jCountdown. date option is required.");
                            return true;
                        }
                        if( opts.date ) {testString = opts.date;
                        } else {testString = $this.data(opts.dataAttr); }
                        testDate = new Date(testString);
                        if( testDate.toString() === "Invalid Date" ) {
                            $.error("Invalid Date passed to jCountdown: " + testString);
                        }
                        if( opts.onStart ) {$this.on("start.jcdevt", opts.onStart ); }
                        if( opts.onChange ) {$this.on("change.jcdevt", opts.onChange );}
                        if( opts.onComplete ) {$this.on("complete.jcdevt", opts.onComplete );}
                        if( opts.onPause ) {$this.on("pause.jcdevt", opts.onPause );}
                        if( opts.onResume ) {$this.on("resume.jcdevt", opts.onResume );}
                        if( opts.onLocaleChange ) {$this.on("locale.jcdevt", opts.onLocaleChange );}
                        settings = $.extend( {}, opts );
                        settings.dom = {};
                        settings.dom.$time = $("<"+settings.timeWrapElement+">").addClass( settings.timeWrapClass );
                        settings.dom.$text = $("<"+settings.textWrapElement+">").addClass( settings.textWrapClass );
                        settings.clientdateNow = new Date();
                        settings.clientdateNow.setMilliseconds(0);
                        settings.originalHTML = $this.html();
                        settings.dateObj = new Date( testString );
                        settings.dateObj.setMilliseconds(0);
                        settings.hasCompleted = false;
                        settings.timer = 0;
                        settings.yearsLeft = settings.monthsLeft = settings.weeksLeft = settings.daysLeft = settings.hrsLeft = settings.minsLeft = settings.secLeft = 0;
                        settings.difference = null;
                        func = $.proxy( timerFunc, $this );
                        settings.timer = setInterval( func, settings.updateTime );
                        $this.data("jcdData", settings).triggerMulti("start.jcdevt,countStart", [settings]);
                        func();
                    });
                },
                changeSettings: function( options, internal ) {
                    return this.each(function() {
                        var $this  = $(this),
                            settings,
                            testDate,
                            func = $.proxy( timerFunc, $this );
                        if( !$this.data("jcdData") ) {return true; }
                        settings = $.extend( {}, $this.data("jcdData"), options );
                        if( options.hasOwnProperty("date") ) {
                            testDate = new Date(options.date);
                            if( testDate.toString() === "Invalid Date" ) {
                                $.error("Invalid Date passed to jCountdown: " + options.date);
                            }
                        }
                        settings.completed = false;
                        settings.dateObj  = new Date( options.date );
                        clearInterval( settings.timer );
                        $this.off(".jcdevt").data("jcdData", settings);
                        if( !internal ) {
                            if( settings.onChange ) {$this.on("change.jcdevt", settings.onChange);}
                            if( settings.onComplete ) {$this.on("complete.jcdevt", settings.onComplete);}
                            if( settings.onPause ) {$this.on("pause.jcdevt", settings.onPause );}
                            if( settings.onResume ) {$this.on("resume.jcdevt", settings.onResume );}
                            settings.timer = setInterval( func, settings.updateTime );
                            $this.data("jcdData", settings);
                            func();
                        }
                        settings = null;
                    });
                },
                resume: function() {
                    return this.each(function() {
                        var $this = $(this),
                            settings = $this.data("jcdData"),
                            func = $.proxy( timerFunc, $this );
                        if( !settings ) {
                            return true;
                        }
                        $this.data("jcdData", settings).triggerMulti("resume.jcdevt,countResume", [settings] );
                        if( !settings.hasCompleted ) {
                            settings.timer = setInterval( func, settings.updateTime );
                            if( settings.stopwatch && settings.direction === "up" ) {
                                var t = dateNow( $this ).getTime() - settings.pausedAt.getTime(),
                                    d = new Date();
                                d.setTime( settings.dateObj.getTime() + t );
                                settings.dateObj = d; //This is internal date
                            }
                            func();
                        }
                    });
                },
                pause: function() {
                    return this.each(function() {
                        var $this = $(this),
                            settings = $this.data("jcdData");
                        if( !settings ) {
                            return true;
                        }
                        if( settings.stopwatch ) {
                            settings.pausedAt = dateNow( $this );
                        }
                        clearInterval( settings.timer );
                        $this.data("jcdData", settings).triggerMulti("pause.jcdevt,countPause", [settings] );
                    });
                },
                complete: function() {
                    return this.each(function() {
                        var $this = $(this),
                            settings = $this.data("jcdData");
                        if( !settings ) {
                            return true;
                        }
                        clearInterval( settings.timer );
                        settings.hasCompleted = true;
                        $this.data("jcdData", settings).triggerMulti("complete.jcdevt,countComplete", [settings]);
                    });
                },
                destroy: function() {
                    return this.each(function() {
                        var $this = $(this),
                            settings = $this.data("jcdData");
                        if( !settings ) {
                            return true;
                        }
                        clearInterval( settings.timer );
                        $this.off(".jcdevt").removeData("jcdData").html( settings.originalHTML );
                    });
                },
                getSettings: function( name ) {
                    var $this = $(this),
                        settings = $this.data("jcdData");
                    if( name && settings ) {
                        if( settings.hasOwnProperty( name ) ) {
                            return settings[name];
                        }
                        return undefined;
                    }
                    return settings;
                },
                changeLocale: function( locale ) { //new in v1.5.0
                    var $this = $(this),
                        settings = $this.data("jcdData");
                    if( !$.fn.countdown.locale[locale] ) {
                        $.error("Locale '" + locale + "' does not exist");
                        return false;
                    }
                    $.extend( settings, $.fn.countdown.locale[locale] );
                    $this.data("jcdData", settings).triggerMulti("locale.jcdevt,localeChange", [settings]);
                    return true;
                }
            };
        if( methods[ method ] ) {
            return methods[ method ].apply( this, Array.prototype.slice.call( arguments, 1 ) );
        } else if ( typeof method === "object" || !method ) {
            return methods.init.apply( this, arguments );
        } else {
            $.error("Method "+ method +" does not exist in the jCountdown Plugin");
        }
    };
    $.fn.countdown.defaults = {
        date: null,
        dataAttr: null,
        updateTime: 1000,
        yearText: 'years',
        monthText: 'months',
        weekText: 'weeks',
        dayText: 'days',
        hourText: 'hours',
        minText: 'mins',
        secText: 'sec',
        yearSingularText: 'year',
        monthSingularText: 'month',
        weekSingularText: 'week',
        daySingularText: 'day',
        hourSingularText: 'hour',
        minSingularText: 'min',
        secSingularText: 'sec',
        digits : [0,1,2,3,4,5,6,7,8,9],
        timeWrapElement: 'span',
        textWrapElement: 'span',
        timeWrapClass: '',
        textWrapClass: 'cd-time',
        timeSeparator: '',
        isRTL: false,
        minus: false,
        onStart: null,
        onChange: null,
        onComplete: null,
        onResume: null,
        onPause: null,
        onLocaleChange: null,
        leadingZero: false,
        offset: null,
        serverDiff:null,
        spaceCharacter: ' ',
        hoursOnly: false,
        minsOnly: false,
        secsOnly: false,
        weeks: false,
        hours: false,
        yearsAndMonths: false,
        direction: "down",
        stopwatch: false,
        omitZero: false,
        template: null
    };
    $.fn.countdown.locale = [];
    $.fn.triggerMulti = function( eventTypes, extraParameters ) {
        var events = eventTypes.split(",");
        return this.each(function() {
            var $this = $(this);
            for( var i = 0; i < events.length; i++) {
                $this.trigger( events[i], extraParameters );
            }
        });
    };
})(jQuery);