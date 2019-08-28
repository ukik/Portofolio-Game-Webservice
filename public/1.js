// { "framework": "Vue"} 

webpackJsonp([1],[
    /* 0 */,
    /* 1 */,
    /* 2 */,
    /* 3 */,
    /* 4 */,
    /* 5 */
    /***/ (function(module, exports, __webpack_require__) {
    
    var __vue_exports__, __vue_options__
    var __vue_styles__ = []
    
    /* styles */
    __vue_styles__.push(__webpack_require__(6)
    )
    
    /* script */
    __vue_exports__ = __webpack_require__(7)
    
    /* template */
    var __vue_template__ = __webpack_require__(8)
    __vue_options__ = __vue_exports__ = __vue_exports__ || {}
    if (
      typeof __vue_exports__.default === "object" ||
      typeof __vue_exports__.default === "function"
    ) {
    if (Object.keys(__vue_exports__).some(function (key) { return key !== "default" && key !== "__esModule" })) {console.error("named exports are not supported in *.vue files.")}
    __vue_options__ = __vue_exports__ = __vue_exports__.default
    }
    if (typeof __vue_options__ === "function") {
      __vue_options__ = __vue_options__.options
    }
    __vue_options__.__file = "G:\\- PROGRAMMER - WEEX\\awesome-app\\src\\components\\ScanQRCode.vue"
    __vue_options__.render = __vue_template__.render
    __vue_options__.staticRenderFns = __vue_template__.staticRenderFns
    __vue_options__._scopeId = "data-v-73d07d70"
    __vue_options__.style = __vue_options__.style || {}
    __vue_styles__.forEach(function (module) {
      for (var name in module) {
        __vue_options__.style[name] = module[name]
      }
    })
    if (typeof __register_static_styles__ === "function") {
      __register_static_styles__(__vue_options__._scopeId, __vue_styles__)
    }
    
    module.exports = __vue_exports__
    
    
    /***/ }),
    /* 6 */
    /***/ (function(module, exports) {
    
    module.exports = {
      "wrapper": {
        "backgroundColor": "#FFFFFF"
      },
      "center": {
        "justifyContent": "center",
        "alignItems": "center"
      },
      "logo": {
        "width": "750",
        "height": "318"
      },
      "btn": {
        "width": "450",
        "height": "160",
        "marginTop": "50",
        "marginRight": "50",
        "marginBottom": "50",
        "marginLeft": "50",
        "opacity": 0.7,
        "opacity:active": 1
      },
      "scan-bg": {
        "width": "450",
        "height": "160",
        "position": "absolute",
        "top": 0,
        "left": 0
      },
      "btn-text": {
        "color": "#505050",
        "fontSize": "56",
        "textAlign": "center"
      }
    }
    
    /***/ }),
    /* 7 */
    /***/ (function(module, exports, __webpack_require__) {
    
    "use strict";
    
    
    Object.defineProperty(exports, "__esModule", {
      value: true
    });
    //
    //
    //
    //
    //
    //
    //
    //
    //
    //
    //
    //
    
    var navigator = weex.requireModule('navigator');
    var event = weex.requireModule('event');
    exports.default = {
      methods: {
        scan: function scan() {
          try {
            event.openURL('weex://go/scan');
          } catch (e) {
            try {
              navigator.push({ url: 'weex://go/scan' });
            } catch (e) {}
          }
        },
    
        back: function back() {
          this.$router.back();
        }
      }
    };
    
    /***/ }),
    /* 8 */
    /***/ (function(module, exports) {
    
    module.exports={render:function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
      return _c('div', {
        staticClass: ["wrapper", "center"],
        on: {
          "androidback": _vm.back
        }
      }, [_c('div', {
        staticClass: ["center"]
      }, [_c('image', {
        staticClass: ["logo"],
        attrs: {
          "src": "https://gw.alicdn.com/tfs/TB1Q9VBkRfH8KJjy1XbXXbLdXXa-3799-1615.png"
        }
      }), _c('div', {
        staticClass: ["btn", "center"],
        on: {
          "click": _vm.scan
        }
      }, [_c('image', {
        staticClass: ["scan-bg"],
        attrs: {
          "src": "https://gw.alicdn.com/tfs/TB1qnO0kLDH8KJjy1XcXXcpdXXa-900-320.png"
        }
      }), _c('text', {
        staticClass: ["btn-text"]
      }, [_vm._v("Scan QR Code")])])])])
    },staticRenderFns: []}
    module.exports.render._withStripped = true
    
    /***/ })
    ]);