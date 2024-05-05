
(function( window, undefined ) {

	var Globalize;

	if ( typeof require !== "undefined" &&
		typeof exports !== "undefined" &&
		typeof module !== "undefined" ) {
// Assume CommonJS
		Globalize = require( "globalize" );
	} else {
// Global variable
		Globalize = window.Globalize;
	}

	Globalize.addCultureInfo( "us-ENG", "default", {
		name: "us-ENG",
		englishName: "English (Simplified) Legacy",
		nativeName: "English (Simplified) Legacy",
		language: "us-ENG",
		numberFormat: {
			"NaN": "Not a Number",
			negativeInfinity: "Negative Infinity",
			positiveInfinity: "Positive Infinity",
			percent: {
				pattern: ["-n%","n%"]
			},
			currency: {
				pattern: ["$-n","$n"],
				symbol: "¥"
			}
		},
		calendars: {
			standard: {
				days: {
					names: ["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"],
					namesAbbr: ["Sun","Mon","Tue","Wed","Thu","Fri","Sat"],
					namesShort: ["Su","Mo","Tu","We","Th","Fr","Sa"]
				},
				months: {
					names: ["January","February","March","April","May","June","July","August","September","October","November","December",""],
					namesAbbr: ["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec",""]
				},
				AM: ["AM","AM","AM"],
				PM: ["PM","PM","PM"],
				eras: [{"name":"AD","start":null,"offset":0}],
				patterns: {
					d: "yyyy/M/d",
					D: "yyyy'年'M'月'd'日'",
					t: "H:mm",
					T: "H:mm:ss",
					f: "yyyy'年'M'月'd'日' H:mm",
					F: "yyyy'年'M'月'd'日' H:mm:ss",
					M: "M'月'd'日'",
					Y: "yyyy'年'M'月'"
				}
			}
		}
	});

}( this ));