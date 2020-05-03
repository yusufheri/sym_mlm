(window["webpackJsonp"] = window["webpackJsonp"] || []).push([["js/utils"],{

/***/ "./assets/js/utils.js":
/*!****************************!*\
  !*** ./assets/js/utils.js ***!
  \****************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


__webpack_require__(/*! core-js/modules/es.date.now */ "./node_modules/core-js/modules/es.date.now.js");

__webpack_require__(/*! core-js/modules/es.date.to-string */ "./node_modules/core-js/modules/es.date.to-string.js");

__webpack_require__(/*! core-js/modules/es.regexp.exec */ "./node_modules/core-js/modules/es.regexp.exec.js");

__webpack_require__(/*! core-js/modules/es.string.match */ "./node_modules/core-js/modules/es.string.match.js");

window.chartColors = {
  red: 'rgb(255, 99, 132)',
  orange: 'rgb(255, 159, 64)',
  yellow: 'rgb(255, 205, 86)',
  green: 'rgb(75, 192, 192)',
  blue: 'rgb(54, 162, 235)',
  purple: 'rgb(153, 102, 255)',
  grey: 'rgb(201, 203, 207)'
};

(function (global) {
  var MONTHS = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
  var COLORS = ['#4dc9f6', '#f67019', '#f53794', '#537bc4', '#acc236', '#166a8f', '#00a950', '#58595b', '#8549ba'];
  var Samples = global.Samples || (global.Samples = {});
  var Color = global.Color;
  Samples.utils = {
    // Adapted from http://indiegamr.com/generate-repeatable-random-numbers-in-js/
    srand: function srand(seed) {
      this._seed = seed;
    },
    rand: function rand(min, max) {
      var seed = this._seed;
      min = min === undefined ? 0 : min;
      max = max === undefined ? 1 : max;
      this._seed = (seed * 9301 + 49297) % 233280;
      return min + this._seed / 233280 * (max - min);
    },
    numbers: function numbers(config) {
      var cfg = config || {};
      var min = cfg.min || 0;
      var max = cfg.max || 1;
      var from = cfg.from || [];
      var count = cfg.count || 8;
      var decimals = cfg.decimals || 8;
      var continuity = cfg.continuity || 1;
      var dfactor = Math.pow(10, decimals) || 0;
      var data = [];
      var i, value;

      for (i = 0; i < count; ++i) {
        value = (from[i] || 0) + this.rand(min, max);

        if (this.rand() <= continuity) {
          data.push(Math.round(dfactor * value) / dfactor);
        } else {
          data.push(null);
        }
      }

      return data;
    },
    labels: function labels(config) {
      var cfg = config || {};
      var min = cfg.min || 0;
      var max = cfg.max || 100;
      var count = cfg.count || 8;
      var step = (max - min) / count;
      var decimals = cfg.decimals || 8;
      var dfactor = Math.pow(10, decimals) || 0;
      var prefix = cfg.prefix || '';
      var values = [];
      var i;

      for (i = min; i < max; i += step) {
        values.push(prefix + Math.round(dfactor * i) / dfactor);
      }

      return values;
    },
    months: function months(config) {
      var cfg = config || {};
      var count = cfg.count || 12;
      var section = cfg.section;
      var values = [];
      var i, value;

      for (i = 0; i < count; ++i) {
        value = MONTHS[Math.ceil(i) % 12];
        values.push(value.substring(0, section));
      }

      return values;
    },
    color: function color(index) {
      return COLORS[index % COLORS.length];
    },
    transparentize: function transparentize(color, opacity) {
      var alpha = opacity === undefined ? 0.5 : 1 - opacity;
      return Color(color).alpha(alpha).rgbString();
    }
  }; // DEPRECATED

  window.randomScalingFactor = function () {
    return Math.round(Samples.utils.rand(-100, 100));
  }; // INITIALIZATION


  Samples.utils.srand(Date.now()); // Google Analytics

  /* eslint-disable */

  if (document.location.hostname.match(/^(www\.)?chartjs\.org$/)) {
    (function (i, s, o, g, r, a, m) {
      i['GoogleAnalyticsObject'] = r;
      i[r] = i[r] || function () {
        (i[r].q = i[r].q || []).push(arguments);
      }, i[r].l = 1 * new Date();
      a = s.createElement(o), m = s.getElementsByTagName(o)[0];
      a.async = 1;
      a.src = g;
      m.parentNode.insertBefore(a, m);
    })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');

    ga('create', 'UA-28909194-3', 'auto');
    ga('send', 'pageview');
  }
  /* eslint-enable */

})(this);

/***/ }),

/***/ "./node_modules/core-js/modules/es.date.now.js":
/*!*****************************************************!*\
  !*** ./node_modules/core-js/modules/es.date.now.js ***!
  \*****************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

var $ = __webpack_require__(/*! ../internals/export */ "./node_modules/core-js/internals/export.js");

// `Date.now` method
// https://tc39.github.io/ecma262/#sec-date.now
$({ target: 'Date', stat: true }, {
  now: function now() {
    return new Date().getTime();
  }
});


/***/ }),

/***/ "./node_modules/core-js/modules/es.string.match.js":
/*!*********************************************************!*\
  !*** ./node_modules/core-js/modules/es.string.match.js ***!
  \*********************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";

var fixRegExpWellKnownSymbolLogic = __webpack_require__(/*! ../internals/fix-regexp-well-known-symbol-logic */ "./node_modules/core-js/internals/fix-regexp-well-known-symbol-logic.js");
var anObject = __webpack_require__(/*! ../internals/an-object */ "./node_modules/core-js/internals/an-object.js");
var toLength = __webpack_require__(/*! ../internals/to-length */ "./node_modules/core-js/internals/to-length.js");
var requireObjectCoercible = __webpack_require__(/*! ../internals/require-object-coercible */ "./node_modules/core-js/internals/require-object-coercible.js");
var advanceStringIndex = __webpack_require__(/*! ../internals/advance-string-index */ "./node_modules/core-js/internals/advance-string-index.js");
var regExpExec = __webpack_require__(/*! ../internals/regexp-exec-abstract */ "./node_modules/core-js/internals/regexp-exec-abstract.js");

// @@match logic
fixRegExpWellKnownSymbolLogic('match', 1, function (MATCH, nativeMatch, maybeCallNative) {
  return [
    // `String.prototype.match` method
    // https://tc39.github.io/ecma262/#sec-string.prototype.match
    function match(regexp) {
      var O = requireObjectCoercible(this);
      var matcher = regexp == undefined ? undefined : regexp[MATCH];
      return matcher !== undefined ? matcher.call(regexp, O) : new RegExp(regexp)[MATCH](String(O));
    },
    // `RegExp.prototype[@@match]` method
    // https://tc39.github.io/ecma262/#sec-regexp.prototype-@@match
    function (regexp) {
      var res = maybeCallNative(nativeMatch, regexp, this);
      if (res.done) return res.value;

      var rx = anObject(regexp);
      var S = String(this);

      if (!rx.global) return regExpExec(rx, S);

      var fullUnicode = rx.unicode;
      rx.lastIndex = 0;
      var A = [];
      var n = 0;
      var result;
      while ((result = regExpExec(rx, S)) !== null) {
        var matchStr = String(result[0]);
        A[n] = matchStr;
        if (matchStr === '') rx.lastIndex = advanceStringIndex(S, toLength(rx.lastIndex), fullUnicode);
        n++;
      }
      return n === 0 ? null : A;
    }
  ];
});


/***/ })

},[["./assets/js/utils.js","runtime","vendors~js/app~js/dashboard~js/utils"]]]);
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9hc3NldHMvanMvdXRpbHMuanMiLCJ3ZWJwYWNrOi8vLy4vbm9kZV9tb2R1bGVzL2NvcmUtanMvbW9kdWxlcy9lcy5kYXRlLm5vdy5qcyIsIndlYnBhY2s6Ly8vLi9ub2RlX21vZHVsZXMvY29yZS1qcy9tb2R1bGVzL2VzLnN0cmluZy5tYXRjaC5qcyJdLCJuYW1lcyI6WyJ3aW5kb3ciLCJjaGFydENvbG9ycyIsInJlZCIsIm9yYW5nZSIsInllbGxvdyIsImdyZWVuIiwiYmx1ZSIsInB1cnBsZSIsImdyZXkiLCJnbG9iYWwiLCJNT05USFMiLCJDT0xPUlMiLCJTYW1wbGVzIiwiQ29sb3IiLCJ1dGlscyIsInNyYW5kIiwic2VlZCIsIl9zZWVkIiwicmFuZCIsIm1pbiIsIm1heCIsInVuZGVmaW5lZCIsIm51bWJlcnMiLCJjb25maWciLCJjZmciLCJmcm9tIiwiY291bnQiLCJkZWNpbWFscyIsImNvbnRpbnVpdHkiLCJkZmFjdG9yIiwiTWF0aCIsInBvdyIsImRhdGEiLCJpIiwidmFsdWUiLCJwdXNoIiwicm91bmQiLCJsYWJlbHMiLCJzdGVwIiwicHJlZml4IiwidmFsdWVzIiwibW9udGhzIiwic2VjdGlvbiIsImNlaWwiLCJzdWJzdHJpbmciLCJjb2xvciIsImluZGV4IiwibGVuZ3RoIiwidHJhbnNwYXJlbnRpemUiLCJvcGFjaXR5IiwiYWxwaGEiLCJyZ2JTdHJpbmciLCJyYW5kb21TY2FsaW5nRmFjdG9yIiwiRGF0ZSIsIm5vdyIsImRvY3VtZW50IiwibG9jYXRpb24iLCJob3N0bmFtZSIsIm1hdGNoIiwicyIsIm8iLCJnIiwiciIsImEiLCJtIiwicSIsImFyZ3VtZW50cyIsImwiLCJjcmVhdGVFbGVtZW50IiwiZ2V0RWxlbWVudHNCeVRhZ05hbWUiLCJhc3luYyIsInNyYyIsInBhcmVudE5vZGUiLCJpbnNlcnRCZWZvcmUiLCJnYSJdLCJtYXBwaW5ncyI6Ijs7Ozs7Ozs7OztBQUFhOzs7Ozs7Ozs7O0FBRWJBLE1BQU0sQ0FBQ0Ms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RjtBQUNBQSxNQUFFLENBQUMsTUFBRCxFQUFTLFVBQVQsQ0FBRjtBQUNBO0FBQ0Q7O0FBRUEsQ0F0SUEsRUFzSUMsSUF0SUQsQ0FBRCxDOzs7Ozs7Ozs7OztBQ1pBLFFBQVEsbUJBQU8sQ0FBQyx1RUFBcUI7O0FBRXJDO0FBQ0E7QUFDQSxHQUFHLDZCQUE2QjtBQUNoQztBQUNBO0FBQ0E7QUFDQSxDQUFDOzs7Ozs7Ozs7Ozs7O0FDUlk7QUFDYixvQ0FBb0MsbUJBQU8sQ0FBQywrSEFBaUQ7QUFDN0YsZUFBZSxtQkFBTyxDQUFDLDZFQUF3QjtBQUMvQyxlQUFlLG1CQUFPLENBQUMsNkVBQXdCO0FBQy9DLDZCQUE2QixtQkFBTyxDQUFDLDJHQUF1QztBQUM1RSx5QkFBeUIsbUJBQU8sQ0FBQyxtR0FBbUM7QUFDcEUsaUJBQWlCLG1CQUFPLENBQUMsbUdBQW1DOztBQUU1RDtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQSxLQUFLO0FBQ0w7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBOztBQUVBOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQSxDQUFDIiwiZmlsZSI6ImpzL3V0aWxzLmpzIiwic291cmNlc0NvbnRlbnQiOlsiJ3VzZSBzdHJpY3QnO1xyXG5cclxud2luZG93LmNoYXJ0Q29sb3JzID0ge1xyXG5cdHJlZDogJ3JnYigyNTUsIDk5LCAxMzIpJyxcclxuXHRvcmFuZ2U6ICdyZ2IoMjU1LCAxNTksIDY0KScsXHJcblx0eWVsbG93OiAncmdiKDI1NSwgMjA1LCA4NiknLFxyXG5cdGdyZWVuOiAncmdiKDc1LCAxOTIsIDE5MiknLFxyXG5cdGJsdWU6ICdyZ2IoNTQsIDE2MiwgMjM1KScsXHJcblx0cHVycGxlOiAncmdiKDE1MywgMTAyLCAyNTUpJyxcclxuXHRncmV5OiAncmdiKDIwMSwgMjAzLCAyMDcpJ1xyXG59O1xyXG5cclxuKGZ1bmN0aW9uKGdsb2JhbCkge1xyXG5cdHZhciBNT05USFMgPSBbXHJcblx0XHQnSmFudWFyeScsXHJcblx0XHQnRmVicnVhcnknLFxyXG5cdFx0J01hcmNoJyxcclxuXHRcdCdBcHJpbCcsXHJcblx0XHQnTWF5JyxcclxuXHRcdCdKdW5lJyxcclxuXHRcdCdKdWx5JyxcclxuXHRcdCdBdWd1c3QnLFxyXG5cdFx0J1NlcHRlbWJlcicsXHJcblx0XHQnT2N0b2JlcicsXHJcblx0XHQnTm92ZW1iZXInLFxyXG5cdFx0J0RlY2VtYmVyJ1xyXG5cdF07XHJcblxyXG5cdHZhciBDT0xPUlMgPSBbXHJcblx0XHQnIzRkYzlmNicsXHJcblx0XHQnI2Y2NzAxOScsXHJcblx0XHQnI2Y1Mzc5NCcsXHJcblx0XHQnIzUzN2JjNCcsXHJcblx0XHQnI2FjYzIzNicsXHJcblx0XHQnIzE2NmE4ZicsXHJcblx0XHQnIzAwYTk1MCcsXHJcblx0XHQnIzU4NTk1YicsXHJcblx0XHQnIzg1NDliYSdcclxuXHRdO1xyXG5cclxuXHR2YXIgU2FtcGxlcyA9IGdsb2JhbC5TYW1wbGVzIHx8IChnbG9iYWwuU2FtcGxlcyA9IHt9KTtcclxuXHR2YXIgQ29sb3IgPSBnbG9iYWwuQ29sb3I7XHJcblxyXG5cdFNhbXBsZXMudXRpbHMgPSB7XHJcblx0XHQvLyBBZGFwdGVkIGZyb20gaHR0cDovL2luZGllZ2Ftci5jb20vZ2VuZXJhdGUtcmVwZWF0YWJsZS1yYW5kb20tbnVtYmVycy1pbi1qcy9cclxuXHRcdHNyYW5kOiBmdW5jdGlvbihzZWVkKSB7XHJcblx0XHRcdHRoaXMuX3NlZWQgPSBzZWVkO1xyXG5cdFx0fSxcclxuXHJcblx0XHRyYW5kOiBmdW5jdGlvbihtaW4sIG1heCkge1xyXG5cdFx0XHR2YXIgc2VlZCA9IHRoaXMuX3NlZWQ7XHJcblx0XHRcdG1pbiA9IG1pbiA9PT0gdW5kZWZpbmVkID8gMCA6IG1pbjtcclxuXHRcdFx0bWF4ID0gbWF4ID09PSB1bmRlZmluZWQgPyAxIDogbWF4O1xyXG5cdFx0XHR0aGlzLl9zZWVkID0gKHNlZWQgKiA5MzAxICsgNDkyOTcpICUgMjMzMjgwO1xyXG5cdFx0XHRyZXR1cm4gbWluICsgKHRoaXMuX3NlZWQgLyAyMzMyODApICogKG1heCAtIG1pbik7XHJcblx0XHR9LFxyXG5cclxuXHRcdG51bWJlcnM6IGZ1bmN0aW9uKGNvbmZpZykge1xyXG5cdFx0XHR2YXIgY2ZnID0gY29uZmlnIHx8IHt9O1xyXG5cdFx0XHR2YXIgbWluID0gY2ZnLm1pbiB8fCAwO1xyXG5cdFx0XHR2YXIgbWF4ID0gY2ZnLm1heCB8fCAxO1xyXG5cdFx0XHR2YXIgZnJvbSA9IGNmZy5mcm9tIHx8IFtdO1xyXG5cdFx0XHR2YXIgY291bnQgPSBjZmcuY291bnQgfHwgODtcclxuXHRcdFx0dmFyIGRlY2ltYWxzID0gY2ZnLmRlY2ltYWxzIHx8IDg7XHJcblx0XHRcdHZhciBjb250aW51aXR5ID0gY2ZnLmNvbnRpbnVpdHkgfHwgMTtcclxuXHRcdFx0dmFyIGRmYWN0b3IgPSBNYXRoLnBvdygxMCwgZGVjaW1hbHMpIHx8IDA7XHJcblx0XHRcdHZhciBkYXRhID0gW107XHJcblx0XHRcdHZhciBpLCB2YWx1ZTtcclxuXHJcblx0XHRcdGZvciAoaSA9IDA7IGkgPCBjb3VudDsgKytpKSB7XHJcblx0XHRcdFx0dmFsdWUgPSAoZnJvbVtpXSB8fCAwKSArIHRoaXMucmFuZChtaW4sIG1heCk7XHJcblx0XHRcdFx0aWYgKHRoaXMucmFuZCgpIDw9IGNvbnRpbnVpdHkpIHtcclxuXHRcdFx0XHRcdGRhdGEucHVzaChNYXRoLnJvdW5kKGRmYWN0b3IgKiB2YWx1ZSkgLyBkZmFjdG9yKTtcclxuXHRcdFx0XHR9IGVsc2Uge1xyXG5cdFx0XHRcdFx0ZGF0YS5wdXNoKG51bGwpO1xyXG5cdFx0XHRcdH1cclxuXHRcdFx0fVxyXG5cclxuXHRcdFx0cmV0dXJuIGRhdGE7XHJcblx0XHR9LFxyXG5cclxuXHRcdGxhYmVsczogZnVuY3Rpb24oY29uZmlnKSB7XHJcblx0XHRcdHZhciBjZmcgPSBjb25maWcgfHwge307XHJcblx0XHRcdHZhciBtaW4gPSBjZmcubWluIHx8IDA7XHJcblx0XHRcdHZhciBtYXggPSBjZmcubWF4IHx8IDEwMDtcclxuXHRcdFx0dmFyIGNvdW50ID0gY2ZnLmNvdW50IHx8IDg7XHJcblx0XHRcdHZhciBzdGVwID0gKG1heCAtIG1pbikgLyBjb3VudDtcclxuXHRcdFx0dmFyIGRlY2ltYWxzID0gY2ZnLmRlY2ltYWxzIHx8IDg7XHJcblx0XHRcdHZhciBkZmFjdG9yID0gTWF0aC5wb3coMTAsIGRlY2ltYWxzKSB8fCAwO1xyXG5cdFx0XHR2YXIgcHJlZml4ID0gY2ZnLnByZWZpeCB8fCAnJztcclxuXHRcdFx0dmFyIHZhbHVlcyA9IFtdO1xyXG5cdFx0XHR2YXIgaTtcclxuXHJcblx0XHRcdGZvciAoaSA9IG1pbjsgaSA8IG1heDsgaSArPSBzdGVwKSB7XHJcblx0XHRcdFx0dmFsdWVzLnB1c2gocHJlZml4ICsgTWF0aC5yb3VuZChkZmFjdG9yICogaSkgLyBkZmFjdG9yKTtcclxuXHRcdFx0fVxyXG5cclxuXHRcdFx0cmV0dXJuIHZhbHVlcztcclxuXHRcdH0sXHJcblxyXG5cdFx0bW9udGhzOiBmdW5jdGlvbihjb25maWcpIHtcclxuXHRcdFx0dmFyIGNmZyA9IGNvbmZpZyB8fCB7fTtcclxuXHRcdFx0dmFyIGNvdW50ID0gY2ZnLmNvdW50IHx8IDEyO1xyXG5cdFx0XHR2YXIgc2VjdGlvbiA9IGNmZy5zZWN0aW9uO1xyXG5cdFx0XHR2YXIgdmFsdWVzID0gW107XHJcblx0XHRcdHZhciBpLCB2YWx1ZTtcclxuXHJcblx0XHRcdGZvciAoaSA9IDA7IGkgPCBjb3VudDsgKytpKSB7XHJcblx0XHRcdFx0dmFsdWUgPSBNT05USFNbTWF0aC5jZWlsKGkpICUgMTJdO1xyXG5cdFx0XHRcdHZhbHVlcy5wdXNoKHZhbHVlLnN1YnN0cmluZygwLCBzZWN0aW9uKSk7XHJcblx0XHRcdH1cclxuXHJcblx0XHRcdHJldHVybiB2YWx1ZXM7XHJcblx0XHR9LFxyXG5cclxuXHRcdGNvbG9yOiBmdW5jdGlvbihpbmRleCkge1xyXG5cdFx0XHRyZXR1cm4gQ09MT1JTW2luZGV4ICUgQ09MT1JTLmxlbmd0aF07XHJcblx0XHR9LFxyXG5cclxuXHRcdHRyYW5zcGFyZW50aXplOiBmdW5jdGlvbihjb2xvciwgb3BhY2l0eSkge1xyXG5cdFx0XHR2YXIgYWxwaGEgPSBvcGFjaXR5ID09PSB1bmRlZmluZWQgPyAwLjUgOiAxIC0gb3BhY2l0eTtcclxuXHRcdFx0cmV0dXJuIENvbG9yKGNvbG9yKS5hbHBoYShhbHBoYSkucmdiU3RyaW5nKCk7XHJcblx0XHR9XHJcblx0fTtcclxuXHJcblx0Ly8gREVQUkVDQVRFRFxyXG5cdHdpbmRvdy5yYW5kb21TY2FsaW5nRmFjdG9yID0gZnVuY3Rpb24oKSB7XHJcblx0XHRyZXR1cm4gTWF0aC5yb3VuZChTYW1wbGVzLnV0aWxzLnJhbmQoLTEwMCwgMTAwKSk7XHJcblx0fTtcclxuXHJcblx0Ly8gSU5JVElBTElaQVRJT05cclxuXHJcblx0U2FtcGxlcy51dGlscy5zcmFuZChEYXRlLm5vdygpKTtcclxuXHJcblx0Ly8gR29vZ2xlIEFuYWx5dGljc1xyXG5cdC8qIGVzbGludC1kaXNhYmxlICovXHJcblx0aWYgKGRvY3VtZW50LmxvY2F0aW9uLmhvc3RuYW1lLm1hdGNoKC9eKHd3d1xcLik/Y2hhcnRqc1xcLm9yZyQvKSkge1xyXG5cdFx0KGZ1bmN0aW9uKGkscyxvLGcscixhLG0pe2lbJ0dvb2dsZUFuYWx5dGljc09iamVjdCddPXI7aVtyXT1pW3JdfHxmdW5jdGlvbigpe1xyXG5cdFx0KGlbcl0ucT1pW3JdLnF8fFtdKS5wdXNoKGFyZ3VtZW50cyl9LGlbcl0ubD0xKm5ldyBEYXRlKCk7YT1zLmNyZWF0ZUVsZW1lbnQobyksXHJcblx0XHRtPXMuZ2V0RWxlbWVudHNCeVRhZ05hbWUobylbMF07YS5hc3luYz0xO2Euc3JjPWc7bS5wYXJlbnROb2RlLmluc2VydEJlZm9yZShhLG0pXHJcblx0XHR9KSh3aW5kb3csZG9jdW1lbnQsJ3NjcmlwdCcsJy8vd3d3Lmdvb2dsZS1hbmFseXRpY3MuY29tL2FuYWx5dGljcy5qcycsJ2dhJyk7XHJcblx0XHRnYSgnY3JlYXRlJywgJ1VBLTI4OTA5MTk0LTMnLCAnYXV0bycpO1xyXG5cdFx0Z2EoJ3NlbmQnLCAncGFnZXZpZXcnKTtcclxuXHR9XHJcblx0LyogZXNsaW50LWVuYWJsZSAqL1xyXG5cclxufSh0aGlzKSk7IiwidmFyICQgPSByZXF1aXJlKCcuLi9pbnRlcm5hbHMvZXhwb3J0Jyk7XG5cbi8vIGBEYXRlLm5vd2AgbWV0aG9kXG4vLyBodHRwczovL3RjMzkuZ2l0aHViLmlvL2VjbWEyNjIvI3NlYy1kYXRlLm5vd1xuJCh7IHRhcmdldDogJ0RhdGUnLCBzdGF0OiB0cnVlIH0sIHtcbiAgbm93OiBmdW5jdGlvbiBub3coKSB7XG4gICAgcmV0dXJuIG5ldyBEYXRlKCkuZ2V0VGltZSgpO1xuICB9XG59KTtcbiIsIid1c2Ugc3RyaWN0JztcbnZhciBmaXhSZWdFeHBXZWxsS25vd25TeW1ib2xMb2dpYyA9IHJlcXVpcmUoJy4uL2ludGVybmFscy9maXgtcmVnZXhwLXdlbGwta25vd24tc3ltYm9sLWxvZ2ljJyk7XG52YXIgYW5PYmplY3QgPSByZXF1aXJlKCcuLi9pbnRlcm5hbHMvYW4tb2JqZWN0Jyk7XG52YXIgdG9MZW5ndGggPSByZXF1aXJlKCcuLi9pbnRlcm5hbHMvdG8tbGVuZ3RoJyk7XG52YXIgcmVxdWlyZU9iamVjdENvZXJjaWJsZSA9IHJlcXVpcmUoJy4uL2ludGVybmFscy9yZXF1aXJlLW9iamVjdC1jb2VyY2libGUnKTtcbnZhciBhZHZhbmNlU3RyaW5nSW5kZXggPSByZXF1aXJlKCcuLi9pbnRlcm5hbHMvYWR2YW5jZS1zdHJpbmctaW5kZXgnKTtcbnZhciByZWdFeHBFeGVjID0gcmVxdWlyZSgnLi4vaW50ZXJuYWxzL3JlZ2V4cC1leGVjLWFic3RyYWN0Jyk7XG5cbi8vIEBAbWF0Y2ggbG9naWNcbmZpeFJlZ0V4cFdlbGxLbm93blN5bWJvbExvZ2ljKCdtYXRjaCcsIDEsIGZ1bmN0aW9uIChNQVRDSCwgbmF0aXZlTWF0Y2gsIG1heWJlQ2FsbE5hdGl2ZSkge1xuICByZXR1cm4gW1xuICAgIC8vIGBTdHJpbmcucHJvdG90eXBlLm1hdGNoYCBtZXRob2RcbiAgICAvLyBodHRwczovL3RjMzkuZ2l0aHViLmlvL2VjbWEyNjIvI3NlYy1zdHJpbmcucHJvdG90eXBlLm1hdGNoXG4gICAgZnVuY3Rpb24gbWF0Y2gocmVnZXhwKSB7XG4gICAgICB2YXIgTyA9IHJlcXVpcmVPYmplY3RDb2VyY2libGUodGhpcyk7XG4gICAgICB2YXIgbWF0Y2hlciA9IHJlZ2V4cCA9PSB1bmRlZmluZWQgPyB1bmRlZmluZWQgOiByZWdleHBbTUFUQ0hdO1xuICAgICAgcmV0dXJuIG1hdGNoZXIgIT09IHVuZGVmaW5lZCA/IG1hdGNoZXIuY2FsbChyZWdleHAsIE8pIDogbmV3IFJlZ0V4cChyZWdleHApW01BVENIXShTdHJpbmcoTykpO1xuICAgIH0sXG4gICAgLy8gYFJlZ0V4cC5wcm90b3R5cGVbQEBtYXRjaF1gIG1ldGhvZFxuICAgIC8vIGh0dHBzOi8vdGMzOS5naXRodWIuaW8vZWNtYTI2Mi8jc2VjLXJlZ2V4cC5wcm90b3R5cGUtQEBtYXRjaFxuICAgIGZ1bmN0aW9uIChyZWdleHApIHtcbiAgICAgIHZhciByZXMgPSBtYXliZUNhbGxOYXRpdmUobmF0aXZlTWF0Y2gsIHJlZ2V4cCwgdGhpcyk7XG4gICAgICBpZiAocmVzLmRvbmUpIHJldHVybiByZXMudmFsdWU7XG5cbiAgICAgIHZhciByeCA9IGFuT2JqZWN0KHJlZ2V4cCk7XG4gICAgICB2YXIgUyA9IFN0cmluZyh0aGlzKTtcblxuICAgICAgaWYgKCFyeC5nbG9iYWwpIHJldHVybiByZWdFeHBFeGVjKHJ4LCBTKTtcblxuICAgICAgdmFyIGZ1bGxVbmljb2RlID0gcngudW5pY29kZTtcbiAgICAgIHJ4Lmxhc3RJbmRleCA9IDA7XG4gICAgICB2YXIgQSA9IFtdO1xuICAgICAgdmFyIG4gPSAwO1xuICAgICAgdmFyIHJlc3VsdDtcbiAgICAgIHdoaWxlICgocmVzdWx0ID0gcmVnRXhwRXhlYyhyeCwgUykpICE9PSBudWxsKSB7XG4gICAgICAgIHZhciBtYXRjaFN0ciA9IFN0cmluZyhyZXN1bHRbMF0pO1xuICAgICAgICBBW25dID0gbWF0Y2hTdHI7XG4gICAgICAgIGlmIChtYXRjaFN0ciA9PT0gJycpIHJ4Lmxhc3RJbmRleCA9IGFkdmFuY2VTdHJpbmdJbmRleChTLCB0b0xlbmd0aChyeC5sYXN0SW5kZXgpLCBmdWxsVW5pY29kZSk7XG4gICAgICAgIG4rKztcbiAgICAgIH1cbiAgICAgIHJldHVybiBuID09PSAwID8gbnVsbCA6IEE7XG4gICAgfVxuICBdO1xufSk7XG4iXSwic291cmNlUm9vdCI6IiJ9