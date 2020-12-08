(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[5],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Form/ImageEditor.vue?vue&type=script&lang=js&":
/*!***************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/Form/ImageEditor.vue?vue&type=script&lang=js& ***!
  \***************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var vuex__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vuex */ "./node_modules/vuex/dist/vuex.esm.js");
function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); if (enumerableOnly) symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; }); keys.push.apply(keys, symbols); } return keys; }

function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i] != null ? arguments[i] : {}; if (i % 2) { ownKeys(Object(source), true).forEach(function (key) { _defineProperty(target, key, source[key]); }); } else if (Object.getOwnPropertyDescriptors) { Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)); } else { ownKeys(Object(source)).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } } return target; }

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

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
//
//
//
//
//
//
//
//
//

var canvas;

function setAttr(name, value, ob) {
  ob.toObject = function (toObject) {
    return function () {
      return fabric.util.object.extend(toObject.call(this), _defineProperty({}, name, value));
    };
  }(ob.toObject);
}

function setActiveStyle(styleName, value, object) {
  object = object || canvas.getActiveObject();
  console.log(object);
  if (!object) return;

  if (object.setSelectionStyles && object.isEditing) {
    var style = {};
    style[styleName] = value;
    object.setSelectionStyles(style);
    object.setCoords();
  } else {
    object.set(styleName, value);
  }

  object.setCoords();
  canvas.requestRenderAll();
}

function setActiveProp(name, value) {
  var object = canvas.getActiveObject();
  console.log(object);
  if (!object) return;
  object.set(name, value).setCoords();
  canvas.renderAll();
}

fabric.Object.prototype.transparentCorners = false;
fabric.Object.prototype.cornerColor = " #574b90";
fabric.Object.prototype.cornerStyle = "circle";
fabric.Object.prototype.set({
  borderColor: "#303a52",
  borderScaleFactor: 2,
  cornerSize: 20
});

fabric.Object.prototype.resizeToScale = function (scaleX, scaleY, belongsToGroup) {
  var objectScaleX = scaleX || this.scaleX;
  var objectScaleY = scaleY || this.scaleY;
  console.log(objectScaleX, objectScaleY, belongsToGroup);

  switch (this.type) {
    case "textbox":
      if (objectScaleX < 1) {
        this.fontSize -= 2;
      } else {
        this.fontSize += 2;
      }

      this.scaleX = 1;
      this.scaleY = 1;

      if (belongsToGroup) {
        this.left *= objectScaleX;
        this.top *= objectScaleY;
      }

      break;

    default:
      this.width = parseInt(this.width * objectScaleX);
      this.height = parseInt(this.height * objectScaleY);
      this.scaleX = 1;
      this.scaleY = 1;

      if (belongsToGroup) {
        this.left *= objectScaleX;
        this.top *= objectScaleY;
      }

      break;
  }

  canvas.renderAll();
};

/* harmony default export */ __webpack_exports__["default"] = ({
  name: "editor",
  props: {
    imageEdit: String
  },
  data: function data() {
    return {
      isDrawingMode: false,
      bushColor: "#FFFFFF",
      bushSize: 30,
      postTitle: "",
      tags: [],
      curTag: "",
      showTextTool: false,
      fontSize: 40,
      colorList: ["#ff0000", "#ffa500", "#008000", "#2196F3", "#009688", "#9C27B0", "#FFEB3B", "#afbbc9", "#4CAF50", "#2d3748", "#f56565", "#ed64a6"],
      canvas: null,
      canvasState: null,
      undoStates: [],
      redoStates: [],
      undoDisable: false,
      redoDisable: false,
      canvasSize: [675, 900],
      canvasResultsJson: [],
      imagesDataUrl: [],
      activeObject: null,
      windowWidth: window.innerWidth,
      windowHeight: window.innerHeight,
      characterLimit: 240,
      previewImage: null
    };
  },
  computed: _objectSpread(_objectSpread({}, Object(vuex__WEBPACK_IMPORTED_MODULE_0__["mapState"])({
    popupEditor: function popupEditor(state) {
      return state.popupEditor;
    }
  })), {}, {
    limitTitle: function limitTitle() {
      return this.postTitle.substring(0, this.characterLimit);
    }
  }),
  watch: {
    activeObject: function activeObject(newVal, oldVal) {
      console.log(newVal);

      if (typeof newVal !== "undefined" && newVal !== oldVal && newVal !== null && newVal.type === "textbox") {
        this.showTextTool = true;
      } else {
        this.showTextTool = false;
      }
    },
    fontSize: function fontSize(newVal, oldVal) {
      if (newVal !== oldVal && newVal !== null) {
        this.changeTextProp(newVal, "fontSize");
        this.historySave();
      }
    },
    isDrawingMode: function isDrawingMode(newVal, oldVal) {
      if (newVal !== oldVal && newVal !== null) {
        canvas.isDrawingMode = newVal;

        if (newVal) {
          this.historySave();
          var brush = canvas.freeDrawingBrush;
          brush.color = this.bushColor;
          brush.width = this.bushSize;
        }
      }
    },
    bushColor: function bushColor(newVal, oldVal) {
      if (newVal !== oldVal && newVal !== null) {
        canvas.freeDrawingBrush.color = newVal;
      }
    },
    bushSize: function bushSize(newVal, oldVal) {
      if (newVal !== oldVal && newVal !== null) {
        canvas.freeDrawingBrush.width = newVal;
      }
    }
  },
  mounted: function mounted() {
    this.handlePreviewImage();
  },
  methods: _objectSpread(_objectSpread(_objectSpread({}, Object(vuex__WEBPACK_IMPORTED_MODULE_0__["mapMutations"])(["TOGGLE_SIDEBAR", "Toggle_popupEditor"])), Object(vuex__WEBPACK_IMPORTED_MODULE_0__["mapActions"])(["createContent"])), {}, {
    cancelEdit: function cancelEdit() {
      canvas.clear();
      this.startCreate = false;
      this.Toggle_popupEditor();
      this.$emit("cancel");
    },
    finishEdit: function finishEdit() {
      var imageChange = canvas.toDataURL();
      console.log(imageChange);
      this.Toggle_popupEditor();
      this.$emit("onDoneEvent", imageChange);
    },
    historySave: function historySave() {
      // clear the redo stack
      this.redoStates = [];
      this.redoDisable = true; // initial call won't have a state

      if (this.canvasState) {
        this.undoStates.push(this.canvasState);
        this.undoDisable = false;
      }

      this.canvasState = JSON.stringify(canvas);
    },
    historyReplay: function historyReplay(playStack, saveStack, buttonsOn, buttonsOff) {
      saveStack.push(this.canvasState);
      this.canvasState = playStack.pop();
      var on = buttonsOn + "Disable";
      var off = buttonsOff + "Disable"; // turn both buttons off for the moment to prevent rapid clicking

      eval("this." + on + "= true;");
      eval("this." + off + "= true;");
      canvas.clear();
      var self = this;
      canvas.loadFromJSON(this.canvasState, function () {
        canvas.renderAll(); // now turn the buttons back on if applicable

        eval("self." + on + "= false;");

        if (playStack.length) {
          eval("self." + off + "= false;");
        }
      });
    },
    undoEvent: function undoEvent() {
      this.historyReplay(this.undoStates, this.redoStates, "redo", "undo");
    },
    redoEvent: function redoEvent() {
      this.historyReplay(this.redoStates, this.undoStates, "undo", "redo");
    },
    handlePreviewImage: function handlePreviewImage() {
      var self = this;

      if (this.imageEdit) {
        this.previewImage = this.imageEdit;
        this.$set(this, "canvasSize", [this.$refs.canvasContainer.clientWidth, this.$refs.canvasContainer.clientHeight - 80]);
        this.startCreate = true;
        this.initCanvas();
      }
    },
    initCanvas: function initCanvas() {
      canvas = new fabric.Canvas("createCanvas");
      canvas.selectionColor = "rgba(0,0,0,0.5)";
      canvas.selectionBorderColor = "gray";
      canvas.selectionLineWidth = 1;
      fabric.Object.prototype.objectCaching = false; // console.log(this.__canvas);

      canvas.setDimensions({
        width: this.canvasSize[0],
        height: this.canvasSize[1]
      });
      canvas.backgroundColor = "#303a52";
      var self = this;
      fabric.Image.fromURL(this.previewImage, function (oImg) {
        var scale = self.canvasSize[0] / oImg.width;
        canvas.setDimensions({
          width: self.canvasSize[0],
          height: oImg.height * scale
        });
        oImg.set({
          width: oImg.width,
          height: oImg.height,
          scaleX: scale,
          scaleY: scale,
          crossOrigin: "anonymous",
          selectable: false,
          evented: false
        }); // console.log(oImg);

        if (oImg.width >= self.canvasSize[0] && oImg.width >= oImg.height) {
          oImg.scaleToWidth(self.canvasSize[0]);
        }

        if (oImg.height >= self.canvasSize[1] && oImg.height >= oImg.width) {
          oImg.scaleToHeight(self.canvasSize[1]);
        }

        canvas.add(oImg); // set the object to be centered to the Canvas

        canvas.centerObject(oImg);
        oImg.setCoords();
        canvas.renderAll();
      });
      this.historySave();
      canvas.on("object:modified", function () {
        self.historySave();
      });
    },
    changeTextProp: function changeTextProp(val, prop) {
      setActiveProp(prop, val);
    },
    createText: function createText() {
      var textProp = {
        fontSize: 40,
        left: 50,
        top: 50,
        fontFamily: "helvetica",
        angle: 0,
        fill: "#f0f0f0",
        scaleX: 1,
        scaleY: 1,
        fontWeight: "bold",
        originX: "left",
        padding: 35,
        width: 100,
        height: 100,
        hasRotatingPoint: true,
        centerTransform: true,
        textAlign: "center"
      };
      var textbox = new fabric.Textbox("text", textProp);
      canvas.add(textbox);
      canvas.setActiveObject(textbox);
      this.activeObject = canvas.getActiveObject();
      this.showTextTool = true;
    },
    cancelEditText: function cancelEditText() {
      var activeObjects = canvas.getActiveObjects();
      canvas.discardActiveObject();

      if (activeObjects.length) {
        canvas.remove.apply(canvas, activeObjects);
      }

      this.activeObject = null;
      this.showTextTool = false;
      canvas.renderAll();
    },
    clickCanvasHandle: function clickCanvasHandle() {
      console.log("clickCanvasHandle");
      this.activeObject = canvas.getActiveObject();

      if (this.activeObject && this.activeObject.type === "textbox") {
        this.fontSize = this.activeObject.fontSize;
      }
    }
  })
});

/***/ }),

/***/ "./node_modules/css-loader/index.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Form/ImageEditor.vue?vue&type=style&index=0&lang=css&":
/*!**********************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader??ref--7-1!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src??ref--7-2!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/Form/ImageEditor.vue?vue&type=style&index=0&lang=css& ***!
  \**********************************************************************************************************************************************************************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(/*! ../../../../node_modules/css-loader/lib/css-base.js */ "./node_modules/css-loader/lib/css-base.js")(false);
// imports


// module
exports.push([module.i, "\ninput[type=\"range\"] {\r\n  height: 26px;\r\n  -webkit-appearance: none;\r\n  margin: 10px 0;\r\n  width: 100%;\n}\ninput[type=\"range\"]:focus {\r\n  outline: none;\n}\ninput[type=\"range\"]::-webkit-slider-runnable-track {\r\n  width: 100%;\r\n  height: 14px;\r\n  cursor: pointer;\r\n  animate: 0.2s;\r\n  box-shadow: 1px 1px 1px #50555c;\r\n  background: #50555c;\r\n  border-radius: 14px;\r\n  border: 0px solid #000000;\n}\ninput[type=\"range\"]::-webkit-slider-thumb {\r\n  box-shadow: 0px 0px 0px #000000;\r\n  border: 0px solid #000000;\r\n  height: 20px;\r\n  width: 40px;\r\n  border-radius: 12px;\r\n  background: #529de1;\r\n  cursor: pointer;\r\n  -webkit-appearance: none;\r\n  margin-top: -3px;\n}\ninput[type=\"range\"]:focus::-webkit-slider-runnable-track {\r\n  background: #50555c;\n}\ninput[type=\"range\"]::-moz-range-track {\r\n  width: 100%;\r\n  height: 14px;\r\n  cursor: pointer;\r\n  animate: 0.2s;\r\n  box-shadow: 1px 1px 1px #50555c;\r\n  background: #50555c;\r\n  border-radius: 14px;\r\n  border: 0px solid #000000;\n}\ninput[type=\"range\"]::-moz-range-thumb {\r\n  box-shadow: 0px 0px 0px #000000;\r\n  border: 0px solid #000000;\r\n  height: 20px;\r\n  width: 40px;\r\n  border-radius: 12px;\r\n  background: #529de1;\r\n  cursor: pointer;\n}\ninput[type=\"range\"]::-ms-track {\r\n  width: 100%;\r\n  height: 14px;\r\n  cursor: pointer;\r\n  animate: 0.2s;\r\n  background: transparent;\r\n  border-color: transparent;\r\n  color: transparent;\n}\ninput[type=\"range\"]::-ms-fill-lower {\r\n  background: #50555c;\r\n  border: 0px solid #000000;\r\n  border-radius: 28px;\r\n  box-shadow: 1px 1px 1px #50555c;\n}\ninput[type=\"range\"]::-ms-fill-upper {\r\n  background: #50555c;\r\n  border: 0px solid #000000;\r\n  border-radius: 28px;\r\n  box-shadow: 1px 1px 1px #50555c;\n}\ninput[type=\"range\"]::-ms-thumb {\r\n  margin-top: 1px;\r\n  box-shadow: 0px 0px 0px #000000;\r\n  border: 0px solid #000000;\r\n  height: 20px;\r\n  width: 40px;\r\n  border-radius: 12px;\r\n  background: #529de1;\r\n  cursor: pointer;\n}\ninput[type=\"range\"]:focus::-ms-fill-lower {\r\n  background: #50555c;\n}\ninput[type=\"range\"]:focus::-ms-fill-upper {\r\n  background: #50555c;\n}\r\n", ""]);

// exports


/***/ }),

/***/ "./node_modules/style-loader/index.js!./node_modules/css-loader/index.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Form/ImageEditor.vue?vue&type=style&index=0&lang=css&":
/*!**************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/style-loader!./node_modules/css-loader??ref--7-1!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src??ref--7-2!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/Form/ImageEditor.vue?vue&type=style&index=0&lang=css& ***!
  \**************************************************************************************************************************************************************************************************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {


var content = __webpack_require__(/*! !../../../../node_modules/css-loader??ref--7-1!../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../node_modules/postcss-loader/src??ref--7-2!../../../../node_modules/vue-loader/lib??vue-loader-options!./ImageEditor.vue?vue&type=style&index=0&lang=css& */ "./node_modules/css-loader/index.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Form/ImageEditor.vue?vue&type=style&index=0&lang=css&");

if(typeof content === 'string') content = [[module.i, content, '']];

var transform;
var insertInto;



var options = {"hmr":true}

options.transform = transform
options.insertInto = undefined;

var update = __webpack_require__(/*! ../../../../node_modules/style-loader/lib/addStyles.js */ "./node_modules/style-loader/lib/addStyles.js")(content, options);

if(content.locals) module.exports = content.locals;

if(false) {}

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Form/ImageEditor.vue?vue&type=template&id=1ee97da8&":
/*!*******************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/Form/ImageEditor.vue?vue&type=template&id=1ee97da8& ***!
  \*******************************************************************************************************************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "render", function() { return render; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return staticRenderFns; });
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "div",
    { staticClass: "left-0 top-0 w-screen h-screen fixed  z-50" },
    [
      _c(
        "div",
        {
          staticClass:
            "bg-white top-0 fixed flex flex-wrap h-10 justify-between mx-auto pb-2 pt-3 px-4 w-full z-10"
        },
        [
          _c(
            "label",
            {
              staticClass: "cursor-pointer block",
              on: {
                click: function($event) {
                  return _vm.cancelEdit()
                }
              }
            },
            [
              _c(
                "svg",
                {
                  staticClass: "color-black w-5",
                  attrs: {
                    xmlns: "http://www.w3.org/2000/svg",
                    fill: "none",
                    viewBox: "0 0 24 24",
                    stroke: "currentColor"
                  }
                },
                [
                  _c("path", {
                    attrs: {
                      "stroke-linecap": "round",
                      "stroke-linejoin": "round",
                      "stroke-width": "2",
                      d: "M6 18L18 6M6 6l12 12"
                    }
                  })
                ]
              )
            ]
          ),
          _vm._v(" "),
          _c(
            "button",
            {
              directives: [
                {
                  name: "show",
                  rawName: "v-show",
                  value: _vm.isDrawingMode,
                  expression: "isDrawingMode"
                }
              ],
              staticClass: "cursor-pointer block",
              attrs: { type: "button", disabled: _vm.undoDisable },
              on: {
                click: function($event) {
                  return _vm.undoEvent()
                }
              }
            },
            [
              _c(
                "svg",
                {
                  staticClass: "color-black w-5 mx-auto",
                  attrs: {
                    xmlns: "http://www.w3.org/2000/svg",
                    fill: "none",
                    viewBox: "0 0 24 24",
                    stroke: "currentColor"
                  }
                },
                [
                  _c("path", {
                    attrs: {
                      "stroke-linecap": "round",
                      "stroke-linejoin": "round",
                      "stroke-width": "2",
                      d: "M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"
                    }
                  })
                ]
              )
            ]
          ),
          _vm._v(" "),
          _c(
            "button",
            {
              directives: [
                {
                  name: "show",
                  rawName: "v-show",
                  value: _vm.isDrawingMode,
                  expression: "isDrawingMode"
                }
              ],
              staticClass: "cursor-pointer block",
              attrs: { type: "button", disabled: _vm.redoDisable },
              on: {
                click: function($event) {
                  return _vm.redoEvent()
                }
              }
            },
            [
              _c(
                "svg",
                {
                  staticClass: "color-black w-5 mirror mx-auto",
                  attrs: {
                    xmlns: "http://www.w3.org/2000/svg",
                    fill: "none",
                    viewBox: "0 0 24 24",
                    stroke: "currentColor"
                  }
                },
                [
                  _c("path", {
                    attrs: {
                      "stroke-linecap": "round",
                      "stroke-linejoin": "round",
                      "stroke-width": "2",
                      d: "M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"
                    }
                  })
                ]
              )
            ]
          ),
          _vm._v(" "),
          _c(
            "label",
            {
              directives: [
                {
                  name: "show",
                  rawName: "v-show",
                  value: _vm.isDrawingMode,
                  expression: "isDrawingMode"
                }
              ],
              staticClass: "cursor-pointer block",
              on: {
                click: function($event) {
                  _vm.isDrawingMode = false
                }
              }
            },
            [
              _c(
                "svg",
                {
                  staticClass: "color-black w-5",
                  attrs: {
                    xmlns: "http://www.w3.org/2000/svg",
                    fill: "none",
                    viewBox: "0 0 24 24",
                    stroke: "currentColor"
                  }
                },
                [
                  _c("path", {
                    attrs: {
                      "stroke-linecap": "round",
                      "stroke-linejoin": "round",
                      "stroke-width": "2",
                      d:
                        "M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"
                    }
                  })
                ]
              )
            ]
          ),
          _vm._v(" "),
          _c(
            "label",
            {
              directives: [
                {
                  name: "show",
                  rawName: "v-show",
                  value: _vm.activeObject,
                  expression: "activeObject"
                }
              ],
              staticClass: "cursor-pointer block",
              on: {
                click: function($event) {
                  return _vm.cancelEditText()
                }
              }
            },
            [
              _c(
                "svg",
                {
                  staticClass: "color-black w-5",
                  attrs: {
                    xmlns: "http://www.w3.org/2000/svg",
                    fill: "none",
                    viewBox: "0 0 24 24",
                    stroke: "currentColor"
                  }
                },
                [
                  _c("path", {
                    attrs: {
                      "stroke-linecap": "round",
                      "stroke-linejoin": "round",
                      "stroke-width": "2",
                      d:
                        "M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                    }
                  })
                ]
              )
            ]
          ),
          _vm._v(" "),
          _c(
            "label",
            {
              staticClass: "cursor-pointer block",
              on: {
                click: function($event) {
                  return _vm.finishEdit()
                }
              }
            },
            [
              _c(
                "svg",
                {
                  staticClass: "color-black w-5",
                  attrs: {
                    xmlns: "http://www.w3.org/2000/svg",
                    fill: "none",
                    viewBox: "0 0 24 24",
                    stroke: "currentColor"
                  }
                },
                [
                  _c("path", {
                    attrs: {
                      "stroke-linecap": "round",
                      "stroke-linejoin": "round",
                      "stroke-width": "2",
                      d: "M5 13l4 4L19 7"
                    }
                  })
                ]
              )
            ]
          )
        ]
      ),
      _vm._v(" "),
      _c(
        "div",
        {
          ref: "canvasContainer",
          staticClass:
            "bg-gray-400 w-full h-full py-10 flex flex-wrap content-center",
          on: { click: _vm.clickCanvasHandle }
        },
        [
          _c("canvas", {
            attrs: {
              id: "createCanvas",
              width: _vm.canvasSize[0],
              height: _vm.canvasSize[1]
            }
          })
        ]
      ),
      _vm._v(" "),
      _c(
        "div",
        {
          staticClass:
            "bg-white bottom-0 fixed flex flex-wrap h-10 justify-between mx-auto px-4 w-full z-10"
        },
        [
          _c(
            "button",
            {
              ref: "undo",
              staticClass: "w-1/5 cursor-pointer block",
              attrs: { type: "button", disabled: _vm.undoDisable },
              on: {
                click: function($event) {
                  return _vm.undoEvent()
                }
              }
            },
            [
              _c(
                "svg",
                {
                  staticClass: "color-black w-5 mx-auto",
                  attrs: {
                    xmlns: "http://www.w3.org/2000/svg",
                    fill: "none",
                    viewBox: "0 0 24 24",
                    stroke: "currentColor"
                  }
                },
                [
                  _c("path", {
                    attrs: {
                      "stroke-linecap": "round",
                      "stroke-linejoin": "round",
                      "stroke-width": "2",
                      d: "M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"
                    }
                  })
                ]
              )
            ]
          ),
          _vm._v(" "),
          _c(
            "button",
            {
              ref: "redo",
              staticClass: "w-1/5 cursor-pointer block",
              attrs: { type: "button", disabled: _vm.redoDisable },
              on: {
                click: function($event) {
                  return _vm.redoEvent()
                }
              }
            },
            [
              _c(
                "svg",
                {
                  staticClass: "color-black w-5 mirror mx-auto",
                  attrs: {
                    xmlns: "http://www.w3.org/2000/svg",
                    fill: "none",
                    viewBox: "0 0 24 24",
                    stroke: "currentColor"
                  }
                },
                [
                  _c("path", {
                    attrs: {
                      "stroke-linecap": "round",
                      "stroke-linejoin": "round",
                      "stroke-width": "2",
                      d: "M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"
                    }
                  })
                ]
              )
            ]
          ),
          _vm._v(" "),
          _c(
            "button",
            {
              staticClass: "w-1/5 cursor-pointer block",
              on: {
                click: function($event) {
                  _vm.isDrawingMode = true
                }
              }
            },
            [
              _c(
                "svg",
                {
                  staticClass: "color-black w-5 mx-auto",
                  staticStyle: {
                    "enable-background": "new 0 0 469.336 469.336"
                  },
                  attrs: {
                    xmlns: "http://www.w3.org/2000/svg",
                    x: "0px",
                    y: "0px",
                    viewBox: "0 0 469.336 469.336",
                    "xml:space": "preserve",
                    stroke: "currentColor"
                  }
                },
                [
                  _c("g", [
                    _c("g", [
                      _c("path", {
                        attrs: {
                          d:
                            "M456.836,76.168l-64-64.054c-16.125-16.139-44.177-16.17-60.365,0.031L45.763,301.682\n                    c-1.271,1.282-2.188,2.857-2.688,4.587L0.409,455.73c-1.063,3.722-0.021,7.736,2.719,10.478c2.031,2.033,4.75,3.128,7.542,3.128\n                    c0.979,0,1.969-0.136,2.927-0.407l149.333-42.703c1.729-0.5,3.302-1.418,4.583-2.69l289.323-286.983\n                    c8.063-8.069,12.5-18.787,12.5-30.192S464.899,84.237,456.836,76.168z M285.989,89.737l39.264,39.264L120.257,333.998\n                    l-14.712-29.434c-1.813-3.615-5.5-5.896-9.542-5.896H78.921L285.989,89.737z M26.201,443.137L40.095,394.5l34.742,34.742\n                    L26.201,443.137z M149.336,407.96l-51.035,14.579l-51.503-51.503l14.579-51.035h28.031l18.385,36.771\n                    c1.031,2.063,2.708,3.74,4.771,4.771l36.771,18.385V407.96z M170.67,390.417v-17.082c0-4.042-2.281-7.729-5.896-9.542\n                    l-29.434-14.712l204.996-204.996l39.264,39.264L170.67,390.417z M441.784,121.72l-47.033,46.613l-93.747-93.747l46.582-47.001\n                    c8.063-8.063,22.104-8.063,30.167,0l64,64c4.031,4.031,6.25,9.385,6.25,15.083S445.784,117.72,441.784,121.72z"
                        }
                      })
                    ])
                  ]),
                  _vm._v(" "),
                  _c("g"),
                  _vm._v(" "),
                  _c("g"),
                  _vm._v(" "),
                  _c("g"),
                  _vm._v(" "),
                  _c("g"),
                  _vm._v(" "),
                  _c("g"),
                  _vm._v(" "),
                  _c("g"),
                  _vm._v(" "),
                  _c("g"),
                  _vm._v(" "),
                  _c("g"),
                  _vm._v(" "),
                  _c("g"),
                  _vm._v(" "),
                  _c("g"),
                  _vm._v(" "),
                  _c("g"),
                  _vm._v(" "),
                  _c("g"),
                  _vm._v(" "),
                  _c("g"),
                  _vm._v(" "),
                  _c("g"),
                  _vm._v(" "),
                  _c("g")
                ]
              )
            ]
          ),
          _vm._v(" "),
          _c(
            "button",
            {
              staticClass: "w-1/5 cursor-pointer block",
              on: { click: _vm.createText }
            },
            [
              _c(
                "svg",
                {
                  staticClass: "color-black w-5 mx-auto",
                  attrs: {
                    xmlns: "http://www.w3.org/2000/svg",
                    x: "0px",
                    y: "0px",
                    "enable-background": "new 0 0 467.765 467.765",
                    viewBox: "0 0 467.765 467.765",
                    "xml:space": "preserve",
                    stroke: "currentColor"
                  }
                },
                [
                  _c("path", {
                    attrs: {
                      d:
                        "m175.412 87.706h58.471v29.235h58.471v-87.706h-292.354v87.706h58.471v-29.235h58.471v292.353h-58.471v58.471h175.383v-58.471h-58.442z"
                    }
                  }),
                  _vm._v(" "),
                  _c("path", {
                    attrs: {
                      d:
                        "m233.882 175.412v87.706h58.471v-29.235h29.235v146.176h-29.235v58.471h116.941v-58.471h-29.235v-146.177h29.235v29.235h58.471v-87.706h-233.883z"
                    }
                  })
                ]
              )
            ]
          ),
          _vm._v(" "),
          _c("button", { staticClass: "w-1/5 cursor-pointer block" }, [
            _c(
              "svg",
              {
                staticClass: "color-black w-5 mx-auto",
                staticStyle: { "enable-background": "new 0 0 469.333 469.333" },
                attrs: {
                  version: "1.1",
                  xmlns: "http://www.w3.org/2000/svg",
                  "xmlns:xlink": "http://www.w3.org/1999/xlink",
                  x: "0px",
                  y: "0px",
                  viewBox: "0 0 469.333 469.333",
                  "xml:space": "preserve",
                  stroke: "currentColor"
                }
              },
              [
                _c("g", [
                  _c("g", [
                    _c("g", [
                      _c("path", {
                        attrs: {
                          d:
                            "M426.667,0h-384C19.146,0,0,19.135,0,42.667v384c0,23.531,19.146,42.667,42.667,42.667h384\n\t\t\t\tc23.521,0,42.667-19.135,42.667-42.667v-384C469.333,19.135,450.188,0,426.667,0z M448,426.667\n\t\t\t\tc0,11.76-9.563,21.333-21.333,21.333H377.75L448,377.75V426.667z M362.667,432.917V384c0-11.76,9.563-21.333,21.333-21.333\n\t\t\t\th48.917L362.667,432.917z M448,341.333h-64c-23.521,0-42.667,19.135-42.667,42.667v64H42.667\n\t\t\t\tc-11.771,0-21.333-9.573-21.333-21.333V345.75l96-96l67.125,67.125c4.167,4.167,10.917,4.167,15.083,0\n\t\t\t\tc4.167-4.167,4.167-10.917,0-15.083l-19.125-19.125L288,175.083l160,160V341.333z M448,304.917L295.542,152.458\n\t\t\t\tc-4.167-4.167-10.917-4.167-15.083,0L165.333,267.583l-40.458-40.458c-4.167-4.167-10.917-4.167-15.083,0l-88.458,88.458V42.667\n\t\t\t\tc0-11.76,9.563-21.333,21.333-21.333h384c11.771,0,21.333,9.573,21.333,21.333V304.917z"
                        }
                      }),
                      _vm._v(" "),
                      _c("path", {
                        attrs: {
                          d:
                            "M160,85.333c-29.417,0-53.333,23.927-53.333,53.333S130.583,192,160,192c29.417,0,53.333-23.927,53.333-53.333\n\t\t\t\tS189.417,85.333,160,85.333z M160,170.667c-17.646,0-32-14.354-32-32s14.354-32,32-32c17.646,0,32,14.354,32,32\n\t\t\t\tS177.646,170.667,160,170.667z"
                        }
                      })
                    ])
                  ])
                ]),
                _vm._v(" "),
                _c("g"),
                _vm._v(" "),
                _c("g"),
                _vm._v(" "),
                _c("g"),
                _vm._v(" "),
                _c("g"),
                _vm._v(" "),
                _c("g"),
                _vm._v(" "),
                _c("g"),
                _vm._v(" "),
                _c("g"),
                _vm._v(" "),
                _c("g"),
                _vm._v(" "),
                _c("g"),
                _vm._v(" "),
                _c("g"),
                _vm._v(" "),
                _c("g"),
                _vm._v(" "),
                _c("g"),
                _vm._v(" "),
                _c("g"),
                _vm._v(" "),
                _c("g"),
                _vm._v(" "),
                _c("g")
              ]
            )
          ])
        ]
      ),
      _vm._v(" "),
      _c(
        "div",
        {
          directives: [
            {
              name: "show",
              rawName: "v-show",
              value: _vm.showTextTool,
              expression: "showTextTool"
            }
          ],
          staticClass:
            "bg-white bottom-0 fixed flex flex-wrap justify-between mx-auto pb-2 pt-3 px-4 w-full z-20"
        },
        [
          _c(
            "div",
            { staticClass: "flex w-full" },
            _vm._l(_vm.colorList, function(color, index) {
              return _c("div", {
                key: "color-" + index,
                staticClass: "w-1/12 h-8 cursor-pointer",
                style: { "background-color": color },
                on: {
                  click: function($event) {
                    return _vm.changeTextProp(color, "fill")
                  }
                }
              })
            }),
            0
          ),
          _vm._v(" "),
          _c("div", { staticClass: "w-full" }, [
            _c("label", { staticClass: "w-full" }, [
              _vm._v("Cỡ chữ\n          "),
              _c("input", {
                directives: [
                  {
                    name: "model",
                    rawName: "v-model",
                    value: _vm.fontSize,
                    expression: "fontSize"
                  }
                ],
                attrs: { type: "range", min: "1", max: "100" },
                domProps: { value: _vm.fontSize },
                on: {
                  __r: function($event) {
                    _vm.fontSize = $event.target.value
                  }
                }
              })
            ])
          ])
        ]
      ),
      _vm._v(" "),
      _c(
        "div",
        {
          directives: [
            {
              name: "show",
              rawName: "v-show",
              value: _vm.isDrawingMode,
              expression: "isDrawingMode"
            }
          ],
          staticClass:
            "bg-white bottom-0 fixed flex flex-wrap justify-between mx-auto pb-2 pt-3 px-4 w-full z-20"
        },
        [
          _c(
            "div",
            { staticClass: "flex w-full" },
            _vm._l(_vm.colorList, function(color, index) {
              return _c("div", {
                key: "color-" + index,
                staticClass: "w-1/12 h-8 cursor-pointer",
                style: { "background-color": color },
                on: {
                  click: function($event) {
                    _vm.bushColor = color
                  }
                }
              })
            }),
            0
          ),
          _vm._v(" "),
          _c("div", { staticClass: "w-full" }, [
            _c("label", { staticClass: "w-full" }, [
              _vm._v("Cỡ bút\n          "),
              _c("input", {
                directives: [
                  {
                    name: "model",
                    rawName: "v-model",
                    value: _vm.bushSize,
                    expression: "bushSize"
                  }
                ],
                attrs: { type: "range", min: "1", max: "100" },
                domProps: { value: _vm.bushSize },
                on: {
                  __r: function($event) {
                    _vm.bushSize = $event.target.value
                  }
                }
              })
            ])
          ])
        ]
      )
    ]
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./resources/js/components/Form/ImageEditor.vue":
/*!******************************************************!*\
  !*** ./resources/js/components/Form/ImageEditor.vue ***!
  \******************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _ImageEditor_vue_vue_type_template_id_1ee97da8___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./ImageEditor.vue?vue&type=template&id=1ee97da8& */ "./resources/js/components/Form/ImageEditor.vue?vue&type=template&id=1ee97da8&");
/* harmony import */ var _ImageEditor_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./ImageEditor.vue?vue&type=script&lang=js& */ "./resources/js/components/Form/ImageEditor.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _ImageEditor_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./ImageEditor.vue?vue&type=style&index=0&lang=css& */ "./resources/js/components/Form/ImageEditor.vue?vue&type=style&index=0&lang=css&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");






/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__["default"])(
  _ImageEditor_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _ImageEditor_vue_vue_type_template_id_1ee97da8___WEBPACK_IMPORTED_MODULE_0__["render"],
  _ImageEditor_vue_vue_type_template_id_1ee97da8___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/Form/ImageEditor.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/Form/ImageEditor.vue?vue&type=script&lang=js&":
/*!*******************************************************************************!*\
  !*** ./resources/js/components/Form/ImageEditor.vue?vue&type=script&lang=js& ***!
  \*******************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ImageEditor_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./ImageEditor.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Form/ImageEditor.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ImageEditor_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/Form/ImageEditor.vue?vue&type=style&index=0&lang=css&":
/*!***************************************************************************************!*\
  !*** ./resources/js/components/Form/ImageEditor.vue?vue&type=style&index=0&lang=css& ***!
  \***************************************************************************************/
/*! no static exports found */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_7_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_7_2_node_modules_vue_loader_lib_index_js_vue_loader_options_ImageEditor_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/style-loader!../../../../node_modules/css-loader??ref--7-1!../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../node_modules/postcss-loader/src??ref--7-2!../../../../node_modules/vue-loader/lib??vue-loader-options!./ImageEditor.vue?vue&type=style&index=0&lang=css& */ "./node_modules/style-loader/index.js!./node_modules/css-loader/index.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Form/ImageEditor.vue?vue&type=style&index=0&lang=css&");
/* harmony import */ var _node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_7_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_7_2_node_modules_vue_loader_lib_index_js_vue_loader_options_ImageEditor_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_7_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_7_2_node_modules_vue_loader_lib_index_js_vue_loader_options_ImageEditor_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_0__);
/* harmony reexport (unknown) */ for(var __WEBPACK_IMPORT_KEY__ in _node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_7_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_7_2_node_modules_vue_loader_lib_index_js_vue_loader_options_ImageEditor_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_0__) if(["default"].indexOf(__WEBPACK_IMPORT_KEY__) < 0) (function(key) { __webpack_require__.d(__webpack_exports__, key, function() { return _node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_7_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_7_2_node_modules_vue_loader_lib_index_js_vue_loader_options_ImageEditor_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_0__[key]; }) }(__WEBPACK_IMPORT_KEY__));


/***/ }),

/***/ "./resources/js/components/Form/ImageEditor.vue?vue&type=template&id=1ee97da8&":
/*!*************************************************************************************!*\
  !*** ./resources/js/components/Form/ImageEditor.vue?vue&type=template&id=1ee97da8& ***!
  \*************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ImageEditor_vue_vue_type_template_id_1ee97da8___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib??vue-loader-options!./ImageEditor.vue?vue&type=template&id=1ee97da8& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Form/ImageEditor.vue?vue&type=template&id=1ee97da8&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ImageEditor_vue_vue_type_template_id_1ee97da8___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ImageEditor_vue_vue_type_template_id_1ee97da8___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);