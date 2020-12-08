(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[6],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/views/Auth.vue?vue&type=script&lang=js&":
/*!**********************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/views/Auth.vue?vue&type=script&lang=js& ***!
  \**********************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var vuex__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vuex */ "./node_modules/vuex/dist/vuex.esm.js");
/* harmony import */ var _components_Icons_LoadingAnimate_vue__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../components/Icons/LoadingAnimate.vue */ "./resources/js/components/Icons/LoadingAnimate.vue");
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



function validateEmail(email) {
  var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
  return re.test(String(email).toLowerCase());
}

/* harmony default export */ __webpack_exports__["default"] = ({
  name: "Authenticate",
  components: {
    LoadingIcon: _components_Icons_LoadingAnimate_vue__WEBPACK_IMPORTED_MODULE_1__["default"]
  },
  data: function data() {
    return {
      processApi: false,
      showPass: false,
      registerData: {
        full_name: "",
        nick_name: "",
        birthday: new Date().getDate(),
        email: "",
        password: "",
        password_confirm: "",
        accept_term: false
      },
      email: "",
      password: "",
      page: "login",
      keepLogin: true
    };
  },
  watch: {
    email: function email(newVal, oldVal) {
      if (newVal && newVal !== oldVal) {
        var checkEmail = validateEmail(newVal);
        console.log(checkEmail);
      }
    }
  },
  computed: _objectSpread({}, Object(vuex__WEBPACK_IMPORTED_MODULE_0__["mapState"])({
    user: function user(state) {
      return state.user.user;
    },
    user_token: function user_token(state) {
      return state.user.token;
    }
  })),
  created: function created() {
    this.page = "login";

    if (typeof this.$route.params.page !== "undefined" && this.$route.params.page === "register") {
      this.page = "register";
    }

    if (typeof this.$route.params.page !== "undefined" && this.$route.params.page === "logout") {
      if (this.isLocalStorage()) {
        localStorage.clear();
        this.SET_USER({});
        this.SET_TOKEN(null);
        this.$router.push("/");
      }
    }
  },
  mounted: function mounted() {
    if (this.isLocalStorage() && !this.user_token) {
      var user_token = localStorage.getItem("user_token");
      var user = localStorage.getItem("user");
      console.log(JSON.parse(user_token), JSON.parse(user));

      if (user_token && user) {
        this.SET_USER(JSON.parse(user));
        this.SET_TOKEN(JSON.parse(user_token));
        this.$router.go(-1);
      }
    } else {
      this.$router.go(-1);
    }
  },
  methods: _objectSpread(_objectSpread(_objectSpread({}, Object(vuex__WEBPACK_IMPORTED_MODULE_0__["mapActions"])(["LOGIN", "REGISTER"])), Object(vuex__WEBPACK_IMPORTED_MODULE_0__["mapMutations"])(["SET_USER", "SET_TOKEN"])), {}, {
    changeAuthRoute: function changeAuthRoute(Auth) {
      this.page = Auth;
      this.$router.push("/auth/" + Auth);
    },
    sendLogin: function sendLogin() {
      if (this.email !== "" && this.password !== "" && !this.processApi && validateEmail(this.email)) {
        this.processApi = true;
        var self = this;
        this.LOGIN({
          email: this.email,
          password: this.password
        }).then(function (res) {
          self.processApi = false;

          if (self.keepLogin && self.isLocalStorage()) {
            localStorage.setItem("user", JSON.stringify(res.user));
            localStorage.setItem("user_token", JSON.stringify(res.token));
          }

          self.$router.go(-1);
        })["catch"](function (err) {
          self.processApi = false;
        });
      }
    },
    sendRegister: function sendRegister() {
      var isEmpty = !Object.values(this.registerData).some(function (data) {
        return data !== null && data !== "";
      });

      if (!isEmpty && !this.processApi && validateEmail(this.registerData.email)) {
        this.processApi = true;
        var self = this;
        this.REGISTER(this.registerData).then(function (res) {
          self.processApi = false;

          if (self.isLocalStorage()) {
            localStorage.setItem("user", JSON.stringify(res.success.user));
            localStorage.setItem("user_token", JSON.stringify(res.success.token));
          }

          self.$router.go(-1);
        })["catch"](function (err) {
          self.processApi = false;
        });
      }
    }
  })
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Icons/LoadingAnimate.vue?vue&type=template&id=495914b6&":
/*!***********************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/Icons/LoadingAnimate.vue?vue&type=template&id=495914b6& ***!
  \***********************************************************************************************************************************************************************************************************************/
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
    "svg",
    {
      staticClass: "w-8 h-8",
      staticStyle: {
        margin: "auto",
        background: "rgba(0, 0, 0, 0) none repeat scroll 0% 0%",
        display: "block",
        "shape-rendering": "auto"
      },
      attrs: {
        xmlns: "http://www.w3.org/2000/svg",
        "xmlns:xlink": "http://www.w3.org/1999/xlink",
        viewBox: "0 0 100 100",
        preserveAspectRatio: "xMidYMid"
      }
    },
    [
      _c(
        "rect",
        {
          attrs: {
            x: "18",
            y: "30.5",
            width: "14",
            height: "39",
            fill: "#ffffff"
          }
        },
        [
          _c("animate", {
            attrs: {
              attributeName: "y",
              repeatCount: "indefinite",
              dur: "0.8403361344537814s",
              calcMode: "spline",
              keyTimes: "0;0.5;1",
              values: "11;30.5;30.5",
              keySplines: "0 0.5 0.5 1;0 0.5 0.5 1",
              begin: "-0.1680672268907563s"
            }
          }),
          _vm._v(" "),
          _c("animate", {
            attrs: {
              attributeName: "height",
              repeatCount: "indefinite",
              dur: "0.8403361344537814s",
              calcMode: "spline",
              keyTimes: "0;0.5;1",
              values: "78;39;39",
              keySplines: "0 0.5 0.5 1;0 0.5 0.5 1",
              begin: "-0.1680672268907563s"
            }
          })
        ]
      ),
      _vm._v(" "),
      _c(
        "rect",
        {
          attrs: {
            x: "43",
            y: "30.5",
            width: "14",
            height: "39",
            fill: "#ffffff"
          }
        },
        [
          _c("animate", {
            attrs: {
              attributeName: "y",
              repeatCount: "indefinite",
              dur: "0.8403361344537814s",
              calcMode: "spline",
              keyTimes: "0;0.5;1",
              values: "15.875;30.5;30.5",
              keySplines: "0 0.5 0.5 1;0 0.5 0.5 1",
              begin: "-0.08403361344537814s"
            }
          }),
          _vm._v(" "),
          _c("animate", {
            attrs: {
              attributeName: "height",
              repeatCount: "indefinite",
              dur: "0.8403361344537814s",
              calcMode: "spline",
              keyTimes: "0;0.5;1",
              values: "68.25;39;39",
              keySplines: "0 0.5 0.5 1;0 0.5 0.5 1",
              begin: "-0.08403361344537814s"
            }
          })
        ]
      ),
      _vm._v(" "),
      _c(
        "rect",
        {
          attrs: {
            x: "68",
            y: "30.5",
            width: "14",
            height: "39",
            fill: "#ffffff"
          }
        },
        [
          _c("animate", {
            attrs: {
              attributeName: "y",
              repeatCount: "indefinite",
              dur: "0.8403361344537814s",
              calcMode: "spline",
              keyTimes: "0;0.5;1",
              values: "15.875;30.5;30.5",
              keySplines: "0 0.5 0.5 1;0 0.5 0.5 1"
            }
          }),
          _vm._v(" "),
          _c("animate", {
            attrs: {
              attributeName: "height",
              repeatCount: "indefinite",
              dur: "0.8403361344537814s",
              calcMode: "spline",
              keyTimes: "0;0.5;1",
              values: "68.25;39;39",
              keySplines: "0 0.5 0.5 1;0 0.5 0.5 1"
            }
          })
        ]
      )
    ]
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/views/Auth.vue?vue&type=template&id=4072a947&":
/*!**************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/views/Auth.vue?vue&type=template&id=4072a947& ***!
  \**************************************************************************************************************************************************************************************************/
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
  return _c("div", [
    _vm.page === "login"
      ? _c(
          "div",
          {
            staticClass:
              "container mx-auto p-6 mnd:p-12 mt-6 relative flex flex-wrap md:w-6/12"
          },
          [
            _c(
              "div",
              {
                staticClass:
                  "w-full mb-5 pb-1 text-center font-base text-gray-700"
              },
              [
                _c(
                  "router-link",
                  {
                    staticClass:
                      "items-center hover:no-underline font-bold text-gray-800 text-xl uppercase",
                    attrs: { to: "/" }
                  },
                  [_vm._v("ohitsgood")]
                )
              ],
              1
            ),
            _vm._v(" "),
            _c(
              "div",
              { staticClass: "w-full text-sm text-center font-semibold" },
              [_vm._v("\n            Lorem ipsum dolor, sit amet?\n        ")]
            ),
            _vm._v(" "),
            _c("div", { staticClass: "mt-8 w-full mx-auto" }, [
              _c("div", { staticClass: "py-2" }, [
                _c("span", { staticClass: "px-1 text-sm text-gray-600" }, [
                  _vm._v("Địa chỉ Email")
                ]),
                _vm._v(" "),
                _c("input", {
                  directives: [
                    {
                      name: "model",
                      rawName: "v-model",
                      value: _vm.email,
                      expression: "email"
                    }
                  ],
                  staticClass:
                    "text-md block px-3 py-2 rounded-lg w-full bg-white border-2 border-gray-300 placeholder-gray-600 shadow-md focus:placeholder-gray-500 focus:bg-white focus:border-gray-600 focus:outline-none",
                  attrs: {
                    placeholder: "",
                    type: "text",
                    autocomplete: "email"
                  },
                  domProps: { value: _vm.email },
                  on: {
                    input: function($event) {
                      if ($event.target.composing) {
                        return
                      }
                      _vm.email = $event.target.value
                    }
                  }
                })
              ]),
              _vm._v(" "),
              _c(
                "div",
                { staticClass: "py-2", attrs: { "x-data": "{ show: true }" } },
                [
                  _c("span", { staticClass: "px-1 text-sm text-gray-600" }, [
                    _vm._v("Mật khẩu")
                  ]),
                  _vm._v(" "),
                  _c("div", { staticClass: "relative" }, [
                    (!_vm.showPass ? "password" : "text") === "checkbox"
                      ? _c("input", {
                          directives: [
                            {
                              name: "model",
                              rawName: "v-model",
                              value: _vm.password,
                              expression: "password"
                            }
                          ],
                          staticClass:
                            "text-md block px-3 py-2 rounded-lg w-full bg-white border-2 border-gray-300 placeholder-gray-600 shadow-md focus:placeholder-gray-500 focus:bg-white focus:border-gray-600 focus:outline-none",
                          attrs: {
                            placeholder: "",
                            autocomplete: "password",
                            type: "checkbox"
                          },
                          domProps: {
                            checked: Array.isArray(_vm.password)
                              ? _vm._i(_vm.password, null) > -1
                              : _vm.password
                          },
                          on: {
                            change: function($event) {
                              var $$a = _vm.password,
                                $$el = $event.target,
                                $$c = $$el.checked ? true : false
                              if (Array.isArray($$a)) {
                                var $$v = null,
                                  $$i = _vm._i($$a, $$v)
                                if ($$el.checked) {
                                  $$i < 0 && (_vm.password = $$a.concat([$$v]))
                                } else {
                                  $$i > -1 &&
                                    (_vm.password = $$a
                                      .slice(0, $$i)
                                      .concat($$a.slice($$i + 1)))
                                }
                              } else {
                                _vm.password = $$c
                              }
                            }
                          }
                        })
                      : (!_vm.showPass ? "password" : "text") === "radio"
                      ? _c("input", {
                          directives: [
                            {
                              name: "model",
                              rawName: "v-model",
                              value: _vm.password,
                              expression: "password"
                            }
                          ],
                          staticClass:
                            "text-md block px-3 py-2 rounded-lg w-full bg-white border-2 border-gray-300 placeholder-gray-600 shadow-md focus:placeholder-gray-500 focus:bg-white focus:border-gray-600 focus:outline-none",
                          attrs: {
                            placeholder: "",
                            autocomplete: "password",
                            type: "radio"
                          },
                          domProps: { checked: _vm._q(_vm.password, null) },
                          on: {
                            change: function($event) {
                              _vm.password = null
                            }
                          }
                        })
                      : _c("input", {
                          directives: [
                            {
                              name: "model",
                              rawName: "v-model",
                              value: _vm.password,
                              expression: "password"
                            }
                          ],
                          staticClass:
                            "text-md block px-3 py-2 rounded-lg w-full bg-white border-2 border-gray-300 placeholder-gray-600 shadow-md focus:placeholder-gray-500 focus:bg-white focus:border-gray-600 focus:outline-none",
                          attrs: {
                            placeholder: "",
                            autocomplete: "password",
                            type: !_vm.showPass ? "password" : "text"
                          },
                          domProps: { value: _vm.password },
                          on: {
                            input: function($event) {
                              if ($event.target.composing) {
                                return
                              }
                              _vm.password = $event.target.value
                            }
                          }
                        }),
                    _vm._v(" "),
                    _c(
                      "div",
                      {
                        staticClass:
                          "absolute inset-y-0 right-0 pr-3 flex items-center text-sm leading-5"
                      },
                      [
                        _c(
                          "svg",
                          {
                            staticClass: "h-6 text-gray-700",
                            class: {
                              hidden: !_vm.showPass,
                              block: _vm.showPass
                            },
                            attrs: {
                              fill: "none",
                              xmlns: "http://www.w3.org/2000/svg",
                              viewBox: "0 0 576 512"
                            },
                            on: {
                              click: function($event) {
                                _vm.showPass = !_vm.showPass
                              }
                            }
                          },
                          [
                            _c("path", {
                              attrs: {
                                fill: "currentColor",
                                d:
                                  "M572.52 241.4C518.29 135.59 410.93 64 288 64S57.68 135.64 3.48 241.41a32.35 32.35 0 0 0 0 29.19C57.71 376.41 165.07 448 288 448s230.32-71.64 284.52-177.41a32.35 32.35 0 0 0 0-29.19zM288 400a144 144 0 1 1 144-144 143.93 143.93 0 0 1-144 144zm0-240a95.31 95.31 0 0 0-25.31 3.79 47.85 47.85 0 0 1-66.9 66.9A95.78 95.78 0 1 0 288 160z"
                              }
                            })
                          ]
                        ),
                        _vm._v(" "),
                        _c(
                          "svg",
                          {
                            staticClass: "h-6 text-gray-700",
                            class: {
                              block: !_vm.showPass,
                              hidden: _vm.showPass
                            },
                            attrs: {
                              fill: "none",
                              xmlns: "http://www.w3.org/2000/svg",
                              viewBox: "0 0 640 512"
                            },
                            on: {
                              click: function($event) {
                                _vm.showPass = !_vm.showPass
                              }
                            }
                          },
                          [
                            _c("path", {
                              attrs: {
                                fill: "currentColor",
                                d:
                                  "M320 400c-75.85 0-137.25-58.71-142.9-133.11L72.2 185.82c-13.79 17.3-26.48 35.59-36.72 55.59a32.35 32.35 0 0 0 0 29.19C89.71 376.41 197.07 448 320 448c26.91 0 52.87-4 77.89-10.46L346 397.39a144.13 144.13 0 0 1-26 2.61zm313.82 58.1l-110.55-85.44a331.25 331.25 0 0 0 81.25-102.07 32.35 32.35 0 0 0 0-29.19C550.29 135.59 442.93 64 320 64a308.15 308.15 0 0 0-147.32 37.7L45.46 3.37A16 16 0 0 0 23 6.18L3.37 31.45A16 16 0 0 0 6.18 53.9l588.36 454.73a16 16 0 0 0 22.46-2.81l19.64-25.27a16 16 0 0 0-2.82-22.45zm-183.72-142l-39.3-30.38A94.75 94.75 0 0 0 416 256a94.76 94.76 0 0 0-121.31-92.21A47.65 47.65 0 0 1 304 192a46.64 46.64 0 0 1-1.54 10l-73.61-56.89A142.31 142.31 0 0 1 320 112a143.92 143.92 0 0 1 144 144c0 21.63-5.29 41.79-13.9 60.11z"
                              }
                            })
                          ]
                        )
                      ]
                    )
                  ])
                ]
              ),
              _vm._v(" "),
              _c("div", { staticClass: "flex justify-between" }, [
                _c(
                  "label",
                  { staticClass: "block text-gray-500 font-bold my-4" },
                  [
                    _c("input", {
                      directives: [
                        {
                          name: "model",
                          rawName: "v-model",
                          value: _vm.keepLogin,
                          expression: "keepLogin"
                        }
                      ],
                      staticClass: "leading-loose text-pink-600",
                      attrs: { type: "checkbox" },
                      domProps: {
                        checked: Array.isArray(_vm.keepLogin)
                          ? _vm._i(_vm.keepLogin, null) > -1
                          : _vm.keepLogin
                      },
                      on: {
                        change: function($event) {
                          var $$a = _vm.keepLogin,
                            $$el = $event.target,
                            $$c = $$el.checked ? true : false
                          if (Array.isArray($$a)) {
                            var $$v = null,
                              $$i = _vm._i($$a, $$v)
                            if ($$el.checked) {
                              $$i < 0 && (_vm.keepLogin = $$a.concat([$$v]))
                            } else {
                              $$i > -1 &&
                                (_vm.keepLogin = $$a
                                  .slice(0, $$i)
                                  .concat($$a.slice($$i + 1)))
                            }
                          } else {
                            _vm.keepLogin = $$c
                          }
                        }
                      }
                    }),
                    _vm._v(" "),
                    _c(
                      "span",
                      {
                        staticClass:
                          "pl-2 py-2 text-sm text-gray-600 leading-snug"
                      },
                      [_vm._v("Nhớ tài khoản cho lần sau")]
                    )
                  ]
                )
              ]),
              _vm._v(" "),
              _c(
                "button",
                {
                  staticClass:
                    "mt-3 text-lg font-semibold w-full text-white rounded-lg px-6 py-3 btn-hover gradient-black",
                  on: {
                    click: function($event) {
                      return _vm.sendLogin()
                    }
                  }
                },
                [
                  !_vm.processApi
                    ? _c("span", [
                        _vm._v(
                          "\n                    Đăng nhập\n                "
                        )
                      ])
                    : _vm._e(),
                  _vm._v(" "),
                  _vm.processApi ? _c("div", [_c("loading-icon")], 1) : _vm._e()
                ]
              ),
              _vm._v(" "),
              _c(
                "div",
                {
                  staticClass:
                    "flex flex-col flex-wrap content-center text-center"
                },
                [
                  _vm._m(0),
                  _vm._v(" "),
                  _c(
                    "div",
                    { staticClass: "text-sm font-semibold block py-3" },
                    [
                      _c(
                        "a",
                        {
                          staticClass: "font-normal",
                          on: {
                            click: function($event) {
                              return _vm.changeAuthRoute("register")
                            }
                          }
                        },
                        [
                          _vm._v(
                            "\n                        Bạn chưa có tài khoản?\n                        "
                          ),
                          _c("br"),
                          _vm._v(" "),
                          _c(
                            "span",
                            {
                              staticClass:
                                "font-semibold border-b-2 border-gray-400 hover:border-teal-500"
                            },
                            [_vm._v("Đăng ký ở đây nè")]
                          )
                        ]
                      )
                    ]
                  )
                ]
              )
            ])
          ]
        )
      : _vm._e(),
    _vm._v(" "),
    _vm.page === "register"
      ? _c(
          "div",
          {
            staticClass:
              "container mx-auto p-6 md:p-12 mt-6 relative flex flex-wrap md:w-6/12"
          },
          [
            _c(
              "div",
              {
                staticClass:
                  "w-full mb-5 pb-1border-b-2 text-center font-base text-gray-700"
              },
              [
                _c(
                  "router-link",
                  {
                    staticClass:
                      "items-center hover:no-underline font-bold text-gray-800 text-xl uppercase",
                    attrs: { to: "/" }
                  },
                  [_vm._v("ohitsgood")]
                )
              ],
              1
            ),
            _vm._v(" "),
            _vm._m(1),
            _vm._v(" "),
            _c("div", { staticClass: "mt-8 mx-auto w-full" }, [
              _c("div", { staticClass: "py-1" }, [
                _c("span", { staticClass: "px-1 text-sm text-gray-600" }, [
                  _vm._v("Họ tên đầy đủ")
                ]),
                _vm._v(" "),
                _c("input", {
                  directives: [
                    {
                      name: "model",
                      rawName: "v-model",
                      value: _vm.registerData.full_name,
                      expression: "registerData.full_name"
                    }
                  ],
                  staticClass:
                    "text-md block px-3 py-2 rounded-lg w-full bg-white border-2 border-gray-300 placeholder-gray-600 shadow-md focus:placeholder-gray-500 focus:bg-white focus:border-gray-600 focus:outline-none",
                  attrs: { placeholder: "", type: "text" },
                  domProps: { value: _vm.registerData.full_name },
                  on: {
                    input: function($event) {
                      if ($event.target.composing) {
                        return
                      }
                      _vm.$set(
                        _vm.registerData,
                        "full_name",
                        $event.target.value
                      )
                    }
                  }
                })
              ]),
              _vm._v(" "),
              _c("div", { staticClass: "py-1" }, [
                _c("span", { staticClass: "px-1 text-sm text-gray-600" }, [
                  _vm._v("Tên hiển thị")
                ]),
                _vm._v(" "),
                _c("input", {
                  directives: [
                    {
                      name: "model",
                      rawName: "v-model",
                      value: _vm.registerData.nick_name,
                      expression: "registerData.nick_name"
                    }
                  ],
                  staticClass:
                    "text-md block px-3 py-2 rounded-lg w-full bg-white border-2 border-gray-300 placeholder-gray-600 shadow-md focus:placeholder-gray-500 focus:bg-white focus:border-gray-600 focus:outline-none",
                  attrs: { placeholder: "", type: "text" },
                  domProps: { value: _vm.registerData.nick_name },
                  on: {
                    input: function($event) {
                      if ($event.target.composing) {
                        return
                      }
                      _vm.$set(
                        _vm.registerData,
                        "nick_name",
                        $event.target.value
                      )
                    }
                  }
                })
              ]),
              _vm._v(" "),
              _c("div", { staticClass: "py-1" }, [
                _c("span", { staticClass: "px-1 text-sm text-gray-600" }, [
                  _vm._v("Ngày sinh")
                ]),
                _vm._v(" "),
                _c("input", {
                  directives: [
                    {
                      name: "model",
                      rawName: "v-model",
                      value: _vm.registerData.birthday,
                      expression: "registerData.birthday"
                    }
                  ],
                  staticClass:
                    "text-md block px-3 py-2 rounded-lg w-full bg-white border-2 border-gray-300 placeholder-gray-600 shadow-md focus:placeholder-gray-500 focus:bg-white focus:border-gray-600 focus:outline-none",
                  attrs: { placeholder: "", type: "date" },
                  domProps: { value: _vm.registerData.birthday },
                  on: {
                    input: function($event) {
                      if ($event.target.composing) {
                        return
                      }
                      _vm.$set(
                        _vm.registerData,
                        "birthday",
                        $event.target.value
                      )
                    }
                  }
                })
              ]),
              _vm._v(" "),
              _c("div", { staticClass: "py-1" }, [
                _c("span", { staticClass: "px-1 text-sm text-gray-600" }, [
                  _vm._v("Email")
                ]),
                _vm._v(" "),
                _c("input", {
                  directives: [
                    {
                      name: "model",
                      rawName: "v-model",
                      value: _vm.registerData.email,
                      expression: "registerData.email"
                    }
                  ],
                  staticClass:
                    "text-md block px-3 py-2 rounded-lg w-full bg-white border-2 border-gray-300 placeholder-gray-600 shadow-md focus:placeholder-gray-500 focus:bg-white focus:border-gray-600 focus:outline-none",
                  attrs: { placeholder: "", type: "email" },
                  domProps: { value: _vm.registerData.email },
                  on: {
                    input: function($event) {
                      if ($event.target.composing) {
                        return
                      }
                      _vm.$set(_vm.registerData, "email", $event.target.value)
                    }
                  }
                })
              ]),
              _vm._v(" "),
              _c("div", { staticClass: "py-1" }, [
                _c("span", { staticClass: "px-1 text-sm text-gray-600" }, [
                  _vm._v("Mật khẩu")
                ]),
                _vm._v(" "),
                _c("div", { staticClass: "relative" }, [
                  (!_vm.showPass ? "password" : "text") === "checkbox"
                    ? _c("input", {
                        directives: [
                          {
                            name: "model",
                            rawName: "v-model",
                            value: _vm.registerData.password,
                            expression: "registerData.password"
                          }
                        ],
                        staticClass:
                          "text-md block px-3 py-2 rounded-lg w-full bg-white border-2 border-gray-300 placeholder-gray-600 shadow-md focus:placeholder-gray-500 focus:bg-white focus:border-gray-600 focus:outline-none",
                        attrs: { placeholder: "", type: "checkbox" },
                        domProps: {
                          checked: Array.isArray(_vm.registerData.password)
                            ? _vm._i(_vm.registerData.password, null) > -1
                            : _vm.registerData.password
                        },
                        on: {
                          change: function($event) {
                            var $$a = _vm.registerData.password,
                              $$el = $event.target,
                              $$c = $$el.checked ? true : false
                            if (Array.isArray($$a)) {
                              var $$v = null,
                                $$i = _vm._i($$a, $$v)
                              if ($$el.checked) {
                                $$i < 0 &&
                                  _vm.$set(
                                    _vm.registerData,
                                    "password",
                                    $$a.concat([$$v])
                                  )
                              } else {
                                $$i > -1 &&
                                  _vm.$set(
                                    _vm.registerData,
                                    "password",
                                    $$a.slice(0, $$i).concat($$a.slice($$i + 1))
                                  )
                              }
                            } else {
                              _vm.$set(_vm.registerData, "password", $$c)
                            }
                          }
                        }
                      })
                    : (!_vm.showPass ? "password" : "text") === "radio"
                    ? _c("input", {
                        directives: [
                          {
                            name: "model",
                            rawName: "v-model",
                            value: _vm.registerData.password,
                            expression: "registerData.password"
                          }
                        ],
                        staticClass:
                          "text-md block px-3 py-2 rounded-lg w-full bg-white border-2 border-gray-300 placeholder-gray-600 shadow-md focus:placeholder-gray-500 focus:bg-white focus:border-gray-600 focus:outline-none",
                        attrs: { placeholder: "", type: "radio" },
                        domProps: {
                          checked: _vm._q(_vm.registerData.password, null)
                        },
                        on: {
                          change: function($event) {
                            return _vm.$set(_vm.registerData, "password", null)
                          }
                        }
                      })
                    : _c("input", {
                        directives: [
                          {
                            name: "model",
                            rawName: "v-model",
                            value: _vm.registerData.password,
                            expression: "registerData.password"
                          }
                        ],
                        staticClass:
                          "text-md block px-3 py-2 rounded-lg w-full bg-white border-2 border-gray-300 placeholder-gray-600 shadow-md focus:placeholder-gray-500 focus:bg-white focus:border-gray-600 focus:outline-none",
                        attrs: {
                          placeholder: "",
                          type: !_vm.showPass ? "password" : "text"
                        },
                        domProps: { value: _vm.registerData.password },
                        on: {
                          input: function($event) {
                            if ($event.target.composing) {
                              return
                            }
                            _vm.$set(
                              _vm.registerData,
                              "password",
                              $event.target.value
                            )
                          }
                        }
                      }),
                  _vm._v(" "),
                  _c(
                    "div",
                    {
                      staticClass:
                        "absolute inset-y-0 right-0 pr-3 flex items-center text-sm leading-5"
                    },
                    [
                      _c(
                        "svg",
                        {
                          staticClass: "h-6 text-gray-700",
                          class: { hidden: !_vm.showPass, block: _vm.showPass },
                          attrs: {
                            fill: "none",
                            xmlns: "http://www.w3.org/2000/svg",
                            viewBox: "0 0 576 512"
                          },
                          on: {
                            click: function($event) {
                              _vm.showPass = !_vm.showPass
                            }
                          }
                        },
                        [
                          _c("path", {
                            attrs: {
                              fill: "currentColor",
                              d:
                                "M572.52 241.4C518.29 135.59 410.93 64 288 64S57.68 135.64 3.48 241.41a32.35 32.35 0 0 0 0 29.19C57.71 376.41 165.07 448 288 448s230.32-71.64 284.52-177.41a32.35 32.35 0 0 0 0-29.19zM288 400a144 144 0 1 1 144-144 143.93 143.93 0 0 1-144 144zm0-240a95.31 95.31 0 0 0-25.31 3.79 47.85 47.85 0 0 1-66.9 66.9A95.78 95.78 0 1 0 288 160z"
                            }
                          })
                        ]
                      ),
                      _vm._v(" "),
                      _c(
                        "svg",
                        {
                          staticClass: "h-6 text-gray-700",
                          class: { block: !_vm.showPass, hidden: _vm.showPass },
                          attrs: {
                            fill: "none",
                            xmlns: "http://www.w3.org/2000/svg",
                            viewBox: "0 0 640 512"
                          },
                          on: {
                            click: function($event) {
                              _vm.showPass = !_vm.showPass
                            }
                          }
                        },
                        [
                          _c("path", {
                            attrs: {
                              fill: "currentColor",
                              d:
                                "M320 400c-75.85 0-137.25-58.71-142.9-133.11L72.2 185.82c-13.79 17.3-26.48 35.59-36.72 55.59a32.35 32.35 0 0 0 0 29.19C89.71 376.41 197.07 448 320 448c26.91 0 52.87-4 77.89-10.46L346 397.39a144.13 144.13 0 0 1-26 2.61zm313.82 58.1l-110.55-85.44a331.25 331.25 0 0 0 81.25-102.07 32.35 32.35 0 0 0 0-29.19C550.29 135.59 442.93 64 320 64a308.15 308.15 0 0 0-147.32 37.7L45.46 3.37A16 16 0 0 0 23 6.18L3.37 31.45A16 16 0 0 0 6.18 53.9l588.36 454.73a16 16 0 0 0 22.46-2.81l19.64-25.27a16 16 0 0 0-2.82-22.45zm-183.72-142l-39.3-30.38A94.75 94.75 0 0 0 416 256a94.76 94.76 0 0 0-121.31-92.21A47.65 47.65 0 0 1 304 192a46.64 46.64 0 0 1-1.54 10l-73.61-56.89A142.31 142.31 0 0 1 320 112a143.92 143.92 0 0 1 144 144c0 21.63-5.29 41.79-13.9 60.11z"
                            }
                          })
                        ]
                      )
                    ]
                  )
                ])
              ]),
              _vm._v(" "),
              _c("div", { staticClass: "py-1" }, [
                _c("span", { staticClass: "px-1 text-sm text-gray-600" }, [
                  _vm._v("Xác nhận mật khẩu")
                ]),
                _vm._v(" "),
                _c("input", {
                  directives: [
                    {
                      name: "model",
                      rawName: "v-model",
                      value: _vm.registerData.password_confirm,
                      expression: "registerData.password_confirm"
                    }
                  ],
                  staticClass:
                    "text-md block px-3 py-2 rounded-lg w-full bg-white border-2 border-gray-300 placeholder-gray-600 shadow-md focus:placeholder-gray-500 focus:bg-white focus:border-gray-600 focus:outline-none",
                  attrs: { placeholder: "", type: "password" },
                  domProps: { value: _vm.registerData.password_confirm },
                  on: {
                    input: function($event) {
                      if ($event.target.composing) {
                        return
                      }
                      _vm.$set(
                        _vm.registerData,
                        "password_confirm",
                        $event.target.value
                      )
                    }
                  }
                })
              ]),
              _vm._v(" "),
              _c("div", { staticClass: "flex justify-start" }, [
                _c(
                  "label",
                  {
                    staticClass:
                      "block text-gray-500 font-bold my-4 flex items-center"
                  },
                  [
                    _c("input", {
                      directives: [
                        {
                          name: "model",
                          rawName: "v-model",
                          value: _vm.registerData.accept_term,
                          expression: "registerData.accept_term"
                        }
                      ],
                      staticClass: "leading-loose text-pink-600 top-0",
                      attrs: { type: "checkbox" },
                      domProps: {
                        checked: Array.isArray(_vm.registerData.accept_term)
                          ? _vm._i(_vm.registerData.accept_term, null) > -1
                          : _vm.registerData.accept_term
                      },
                      on: {
                        change: function($event) {
                          var $$a = _vm.registerData.accept_term,
                            $$el = $event.target,
                            $$c = $$el.checked ? true : false
                          if (Array.isArray($$a)) {
                            var $$v = null,
                              $$i = _vm._i($$a, $$v)
                            if ($$el.checked) {
                              $$i < 0 &&
                                _vm.$set(
                                  _vm.registerData,
                                  "accept_term",
                                  $$a.concat([$$v])
                                )
                            } else {
                              $$i > -1 &&
                                _vm.$set(
                                  _vm.registerData,
                                  "accept_term",
                                  $$a.slice(0, $$i).concat($$a.slice($$i + 1))
                                )
                            }
                          } else {
                            _vm.$set(_vm.registerData, "accept_term", $$c)
                          }
                        }
                      }
                    }),
                    _vm._v(" "),
                    _vm._m(2)
                  ]
                )
              ]),
              _vm._v(" "),
              _c(
                "button",
                {
                  staticClass:
                    "mt-3 text-lg font-semibold w-full text-white rounded-lg px-6 py-3 btn-hover gradient-black",
                  on: {
                    click: function($event) {
                      return _vm.sendRegister()
                    }
                  }
                },
                [
                  !_vm.processApi
                    ? _c("span", [
                        _vm._v(
                          "\n                    Đăng ký tài khoản\n                "
                        )
                      ])
                    : _vm._e(),
                  _vm._v(" "),
                  _vm.processApi ? _c("div", [_c("loading-icon")], 1) : _vm._e()
                ]
              ),
              _vm._v(" "),
              _c(
                "div",
                {
                  staticClass:
                    "text-sm font-semibold block py-6 flex justify-center"
                },
                [
                  _c(
                    "a",
                    {
                      staticClass:
                        "font-normal border-b-2 border-gray-200 hover:border-teal-500",
                      on: {
                        click: function($event) {
                          return _vm.changeAuthRoute("login")
                        }
                      }
                    },
                    [
                      _vm._v(
                        "\n                    Bạn đã có tài khoản?\n                    "
                      ),
                      _c("span", { staticClass: "font-semibold" }, [
                        _vm._v("Đăng nhập tại đây")
                      ])
                    ]
                  )
                ]
              )
            ])
          ]
        )
      : _vm._e()
  ])
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("label", { staticClass: "block text-gray-500 font-bold my-4" }, [
      _c(
        "a",
        {
          staticClass:
            "cursor-pointer tracking-tighter border-b-2 border-gray-400 hover:border-gray-600",
          attrs: { href: "#" }
        },
        [_c("span", [_vm._v("Quên mật khẩu?")])]
      )
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "w-full" }, [
      _c("div", { staticClass: "text-center font-semibold" }, [
        _vm._v("Lorem ipsum dolor")
      ]),
      _vm._v(" "),
      _c("div", { staticClass: "text-center font-base" }, [
        _vm._v("\n                Sed ut perspiciatis unde?\n            ")
      ])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c(
      "span",
      { staticClass: "ml-2 text-sm py-2 text-gray-600 text-left" },
      [
        _vm._v(
          "\n                        Bằng cách đánh dấu vào mục này bạn đã đồng ý tuân\n                        thủ\n                        "
        ),
        _c(
          "a",
          {
            staticClass:
              "font-semibold border-b-2 border-gray-200 hover:border-gray-500 text-black",
            attrs: { href: "#" }
          },
          [_vm._v("Điều Khoản")]
        ),
        _vm._v("\n                        và\n                        "),
        _c(
          "a",
          {
            staticClass:
              "font-semibold border-b-2 border-gray-200 hover:border-gray-500 text-black",
            attrs: { href: "#" }
          },
          [_vm._v("Chính Sách")]
        ),
        _vm._v("\n                        của website.\n                    ")
      ]
    )
  }
]
render._withStripped = true



/***/ }),

/***/ "./resources/js/components/Icons/LoadingAnimate.vue":
/*!**********************************************************!*\
  !*** ./resources/js/components/Icons/LoadingAnimate.vue ***!
  \**********************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _LoadingAnimate_vue_vue_type_template_id_495914b6___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./LoadingAnimate.vue?vue&type=template&id=495914b6& */ "./resources/js/components/Icons/LoadingAnimate.vue?vue&type=template&id=495914b6&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");

var script = {}


/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_1__["default"])(
  script,
  _LoadingAnimate_vue_vue_type_template_id_495914b6___WEBPACK_IMPORTED_MODULE_0__["render"],
  _LoadingAnimate_vue_vue_type_template_id_495914b6___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/Icons/LoadingAnimate.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/Icons/LoadingAnimate.vue?vue&type=template&id=495914b6&":
/*!*****************************************************************************************!*\
  !*** ./resources/js/components/Icons/LoadingAnimate.vue?vue&type=template&id=495914b6& ***!
  \*****************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_LoadingAnimate_vue_vue_type_template_id_495914b6___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib??vue-loader-options!./LoadingAnimate.vue?vue&type=template&id=495914b6& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Icons/LoadingAnimate.vue?vue&type=template&id=495914b6&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_LoadingAnimate_vue_vue_type_template_id_495914b6___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_LoadingAnimate_vue_vue_type_template_id_495914b6___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./resources/js/views/Auth.vue":
/*!*************************************!*\
  !*** ./resources/js/views/Auth.vue ***!
  \*************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _Auth_vue_vue_type_template_id_4072a947___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Auth.vue?vue&type=template&id=4072a947& */ "./resources/js/views/Auth.vue?vue&type=template&id=4072a947&");
/* harmony import */ var _Auth_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Auth.vue?vue&type=script&lang=js& */ "./resources/js/views/Auth.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _Auth_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _Auth_vue_vue_type_template_id_4072a947___WEBPACK_IMPORTED_MODULE_0__["render"],
  _Auth_vue_vue_type_template_id_4072a947___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/views/Auth.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/views/Auth.vue?vue&type=script&lang=js&":
/*!**************************************************************!*\
  !*** ./resources/js/views/Auth.vue?vue&type=script&lang=js& ***!
  \**************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Auth_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib??ref--4-0!../../../node_modules/vue-loader/lib??vue-loader-options!./Auth.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/views/Auth.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Auth_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/views/Auth.vue?vue&type=template&id=4072a947&":
/*!********************************************************************!*\
  !*** ./resources/js/views/Auth.vue?vue&type=template&id=4072a947& ***!
  \********************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Auth_vue_vue_type_template_id_4072a947___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../node_modules/vue-loader/lib??vue-loader-options!./Auth.vue?vue&type=template&id=4072a947& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/views/Auth.vue?vue&type=template&id=4072a947&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Auth_vue_vue_type_template_id_4072a947___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Auth_vue_vue_type_template_id_4072a947___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);