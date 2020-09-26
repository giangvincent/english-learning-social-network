<template>
  <div class="left-0 top-0 w-screen h-screen fixed">
    <div
      class="bg-white top-0 fixed flex flex-wrap h-10 justify-between mx-auto pb-2 pt-3 px-4 w-full z-10"
    >
      <label class="cursor-pointer block" @click="cancelEdit()">
        <svg
          class="color-black w-5"
          xmlns="http://www.w3.org/2000/svg"
          fill="none"
          viewBox="0 0 24 24"
          stroke="currentColor"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M6 18L18 6M6 6l12 12"
          />
        </svg>
      </label>
      <button
        type="button"
        class="cursor-pointer block"
        @click="undoEvent()"
        v-show="isDrawingMode"
        :disabled="undoDisable"
      >
        <svg
          class="color-black w-5 mx-auto"
          xmlns="http://www.w3.org/2000/svg"
          fill="none"
          viewBox="0 0 24 24"
          stroke="currentColor"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"
          />
        </svg>
      </button>
      <!-- Undo -->

      <button
        type="button"
        class="cursor-pointer block"
        @click="redoEvent()"
        v-show="isDrawingMode"
        :disabled="redoDisable"
      >
        <svg
          class="color-black w-5 mirror mx-auto"
          xmlns="http://www.w3.org/2000/svg"
          fill="none"
          viewBox="0 0 24 24"
          stroke="currentColor"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"
          />
        </svg>
      </button>
      <!-- redo -->
      <label
        class="cursor-pointer block"
        v-show="isDrawingMode"
        @click="isDrawingMode = false"
      >
        <svg
          class="color-black w-5"
          xmlns="http://www.w3.org/2000/svg"
          fill="none"
          viewBox="0 0 24 24"
          stroke="currentColor"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"
          />
        </svg>
      </label>
      <label
        class="cursor-pointer block"
        @click="cancelEditText()"
        v-show="activeObject"
      >
        <svg
          class="color-black w-5"
          xmlns="http://www.w3.org/2000/svg"
          fill="none"
          viewBox="0 0 24 24"
          stroke="currentColor"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
          />
        </svg>
      </label>
      <label class="cursor-pointer block" @click="finishEdit()">
        <svg
          class="color-black w-5"
          xmlns="http://www.w3.org/2000/svg"
          fill="none"
          viewBox="0 0 24 24"
          stroke="currentColor"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M5 13l4 4L19 7"
          />
        </svg>
      </label>
    </div>
    <!--Finish or Discard image creator-->
    <div
      class="bg-gray-400 w-full h-full py-10 flex flex-wrap content-center"
      ref="canvasContainer"
      @click="clickCanvasHandle"
    >
      <canvas
        id="createCanvas"
        :width="canvasSize[0]"
        :height="canvasSize[1]"
      ></canvas>
    </div>
    <!-- image container -->

    <div
      class="bg-white bottom-0 fixed flex flex-wrap h-10 justify-between mx-auto px-4 w-full z-10"
    >
      <button
        type="button"
        ref="undo"
        class="w-1/5 cursor-pointer block"
        @click="undoEvent()"
        :disabled="undoDisable"
      >
        <svg
          class="color-black w-5 mx-auto"
          xmlns="http://www.w3.org/2000/svg"
          fill="none"
          viewBox="0 0 24 24"
          stroke="currentColor"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"
          />
        </svg>
      </button>
      <!-- Undo -->

      <button
        type="button"
        ref="redo"
        class="w-1/5 cursor-pointer block"
        @click="redoEvent()"
        :disabled="redoDisable"
      >
        <svg
          class="color-black w-5 mirror mx-auto"
          xmlns="http://www.w3.org/2000/svg"
          fill="none"
          viewBox="0 0 24 24"
          stroke="currentColor"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"
          />
        </svg>
      </button>
      <!-- redo -->
      <button class="w-1/5 cursor-pointer block" @click="isDrawingMode = true">
        <svg
          class="color-black w-5 mx-auto"
          xmlns="http://www.w3.org/2000/svg"
          x="0px"
          y="0px"
          viewBox="0 0 469.336 469.336"
          style="enable-background: new 0 0 469.336 469.336"
          xml:space="preserve"
          stroke="currentColor"
        >
          <g>
            <g>
              <path
                d="M456.836,76.168l-64-64.054c-16.125-16.139-44.177-16.17-60.365,0.031L45.763,301.682
                    c-1.271,1.282-2.188,2.857-2.688,4.587L0.409,455.73c-1.063,3.722-0.021,7.736,2.719,10.478c2.031,2.033,4.75,3.128,7.542,3.128
                    c0.979,0,1.969-0.136,2.927-0.407l149.333-42.703c1.729-0.5,3.302-1.418,4.583-2.69l289.323-286.983
                    c8.063-8.069,12.5-18.787,12.5-30.192S464.899,84.237,456.836,76.168z M285.989,89.737l39.264,39.264L120.257,333.998
                    l-14.712-29.434c-1.813-3.615-5.5-5.896-9.542-5.896H78.921L285.989,89.737z M26.201,443.137L40.095,394.5l34.742,34.742
                    L26.201,443.137z M149.336,407.96l-51.035,14.579l-51.503-51.503l14.579-51.035h28.031l18.385,36.771
                    c1.031,2.063,2.708,3.74,4.771,4.771l36.771,18.385V407.96z M170.67,390.417v-17.082c0-4.042-2.281-7.729-5.896-9.542
                    l-29.434-14.712l204.996-204.996l39.264,39.264L170.67,390.417z M441.784,121.72l-47.033,46.613l-93.747-93.747l46.582-47.001
                    c8.063-8.063,22.104-8.063,30.167,0l64,64c4.031,4.031,6.25,9.385,6.25,15.083S445.784,117.72,441.784,121.72z"
              />
            </g>
          </g>
          <g />
          <g />
          <g />
          <g />
          <g />
          <g />
          <g />
          <g />
          <g />
          <g />
          <g />
          <g />
          <g />
          <g />
          <g />
        </svg>
      </button>
      <!-- Free draw -->
      <button class="w-1/5 cursor-pointer block" @click="createText">
        <svg
          class="color-black w-5 mx-auto"
          xmlns="http://www.w3.org/2000/svg"
          x="0px"
          y="0px"
          enable-background="new 0 0 467.765 467.765"
          viewBox="0 0 467.765 467.765"
          xml:space="preserve"
          stroke="currentColor"
        >
          <path
            d="m175.412 87.706h58.471v29.235h58.471v-87.706h-292.354v87.706h58.471v-29.235h58.471v292.353h-58.471v58.471h175.383v-58.471h-58.442z"
          />
          <path
            d="m233.882 175.412v87.706h58.471v-29.235h29.235v146.176h-29.235v58.471h116.941v-58.471h-29.235v-146.177h29.235v29.235h58.471v-87.706h-233.883z"
          />
        </svg>
      </button>
      <!-- Text -->
      <button class="w-1/5 cursor-pointer block">
        <svg
          class="color-black w-5 mx-auto"
          version="1.1"
          xmlns="http://www.w3.org/2000/svg"
          xmlns:xlink="http://www.w3.org/1999/xlink"
          x="0px"
          y="0px"
          viewBox="0 0 469.333 469.333"
          style="enable-background: new 0 0 469.333 469.333"
          xml:space="preserve"
          stroke="currentColor"
        >
          <g>
            <g>
              <g>
                <path
                  d="M426.667,0h-384C19.146,0,0,19.135,0,42.667v384c0,23.531,19.146,42.667,42.667,42.667h384
				c23.521,0,42.667-19.135,42.667-42.667v-384C469.333,19.135,450.188,0,426.667,0z M448,426.667
				c0,11.76-9.563,21.333-21.333,21.333H377.75L448,377.75V426.667z M362.667,432.917V384c0-11.76,9.563-21.333,21.333-21.333
				h48.917L362.667,432.917z M448,341.333h-64c-23.521,0-42.667,19.135-42.667,42.667v64H42.667
				c-11.771,0-21.333-9.573-21.333-21.333V345.75l96-96l67.125,67.125c4.167,4.167,10.917,4.167,15.083,0
				c4.167-4.167,4.167-10.917,0-15.083l-19.125-19.125L288,175.083l160,160V341.333z M448,304.917L295.542,152.458
				c-4.167-4.167-10.917-4.167-15.083,0L165.333,267.583l-40.458-40.458c-4.167-4.167-10.917-4.167-15.083,0l-88.458,88.458V42.667
				c0-11.76,9.563-21.333,21.333-21.333h384c11.771,0,21.333,9.573,21.333,21.333V304.917z"
                />
                <path
                  d="M160,85.333c-29.417,0-53.333,23.927-53.333,53.333S130.583,192,160,192c29.417,0,53.333-23.927,53.333-53.333
				S189.417,85.333,160,85.333z M160,170.667c-17.646,0-32-14.354-32-32s14.354-32,32-32c17.646,0,32,14.354,32,32
				S177.646,170.667,160,170.667z"
                />
              </g>
            </g>
          </g>
          <g />
          <g />
          <g />
          <g />
          <g />
          <g />
          <g />
          <g />
          <g />
          <g />
          <g />
          <g />
          <g />
          <g />
          <g />
        </svg>
      </button>
      <!-- Sticker -->
    </div>
    <!-- Basic tools -->

    <div
      class="bg-white bottom-0 fixed flex flex-wrap justify-between mx-auto pb-2 pt-3 px-4 w-full z-20"
      v-show="showTextTool"
    >
      <div class="flex w-full">
        <div
          class="w-1/12 h-8 cursor-pointer"
          v-for="(color, index) in colorList"
          :key="'color-' + index"
          :style="{ 'background-color': color }"
          @click="changeTextProp(color, 'fill')"
        ></div>
      </div>
      <!-- adjust color -->
      <div class="w-full">
        <label class="w-full"
          >Cỡ chữ
          <input type="range" v-model="fontSize" min="1" max="100" />
        </label>
      </div>
      <!-- fontsize -->
    </div>
    <!-- text editor -->
    <div
      class="bg-white bottom-0 fixed flex flex-wrap justify-between mx-auto pb-2 pt-3 px-4 w-full z-20"
      v-show="isDrawingMode"
    >
      <div class="flex w-full">
        <div
          class="w-1/12 h-8 cursor-pointer"
          v-for="(color, index) in colorList"
          :key="'color-' + index"
          :style="{ 'background-color': color }"
          @click="bushColor = color"
        ></div>
      </div>
      <!-- adjust color -->
      <div class="w-full">
        <label class="w-full"
          >Cỡ bút
          <input type="range" v-model="bushSize" min="1" max="100" />
        </label>
      </div>
      <!-- bushSzie -->
    </div>
    <!-- Free draw option -->
  </div>
</template>

<script>
import { mapState, mapMutations, mapActions } from "vuex";

var canvas;
function setAttr(name, value, ob) {
  ob.toObject = (function (toObject) {
    return function () {
      return fabric.util.object.extend(toObject.call(this), {
        [name]: value,
      });
    };
  })(ob.toObject);
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
  cornerSize: 20,
});

fabric.Object.prototype.resizeToScale = function (
  scaleX,
  scaleY,
  belongsToGroup
) {
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

export default {
  name: "editor",
  props: {
    imageEdit: String,
  },
  data() {
    return {
      isDrawingMode: false,
      bushColor: "#FFFFFF",
      bushSize: 30,
      postTitle: "",
      tags: [],
      curTag: "",
      showTextTool: false,
      fontSize: 40,
      colorList: [
        "#ff0000",
        "#ffa500",
        "#008000",
        "#2196F3",
        "#009688",
        "#9C27B0",
        "#FFEB3B",
        "#afbbc9",
        "#4CAF50",
        "#2d3748",
        "#f56565",
        "#ed64a6",
      ],
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
      previewImage: null,
    };
  },
  computed: {
    ...mapState({
      popupEditor: (state) => state.popupEditor,
    }),
    limitTitle: function () {
      return this.postTitle.substring(0, this.characterLimit);
    },
  },
  watch: {
    activeObject: function (newVal, oldVal) {
      console.log(newVal);
      if (
        typeof newVal !== "undefined" &&
        newVal !== oldVal &&
        newVal !== null &&
        newVal.type === "textbox"
      ) {
        this.showTextTool = true;
      } else {
        this.showTextTool = false;
      }
    },
    fontSize: function (newVal, oldVal) {
      if (newVal !== oldVal && newVal !== null) {
        this.changeTextProp(newVal, "fontSize");
        this.historySave();
      }
    },
    isDrawingMode: function (newVal, oldVal) {
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
    bushColor: function (newVal, oldVal) {
      if (newVal !== oldVal && newVal !== null) {
        canvas.freeDrawingBrush.color = newVal;
      }
    },
    bushSize: function (newVal, oldVal) {
      if (newVal !== oldVal && newVal !== null) {
        canvas.freeDrawingBrush.width = newVal;
      }
    },
  },
  mounted() {
    this.handlePreviewImage();
  },
  methods: {
    ...mapMutations(["TOGGLE_SIDEBAR", "Toggle_popupEditor"]),
    ...mapActions(["createContent"]),
    cancelEdit() {
      canvas.clear();
      this.startCreate = false;
      this.Toggle_popupEditor();
      this.$emit("cancel");
    },
    finishEdit() {
      let imageChange = canvas.toDataURL();
      console.log(imageChange);
      this.Toggle_popupEditor();
      this.$emit("onDoneEvent", imageChange);
    },
    historySave() {
      // clear the redo stack
      this.redoStates = [];
      this.redoDisable = true;
      // initial call won't have a state
      if (this.canvasState) {
        this.undoStates.push(this.canvasState);
        this.undoDisable = false;
      }
      this.canvasState = JSON.stringify(canvas);
    },
    historyReplay(playStack, saveStack, buttonsOn, buttonsOff) {
      saveStack.push(this.canvasState);
      this.canvasState = playStack.pop();
      var on = buttonsOn + "Disable";
      var off = buttonsOff + "Disable";
      // turn both buttons off for the moment to prevent rapid clicking
      eval("this." + on + "= true;");
      eval("this." + off + "= true;");
      canvas.clear();
      var self = this;
      canvas.loadFromJSON(this.canvasState, function () {
        canvas.renderAll();
        // now turn the buttons back on if applicable

        eval("self." + on + "= false;");
        if (playStack.length) {
          eval("self." + off + "= false;");
        }
      });
    },
    undoEvent() {
      this.historyReplay(this.undoStates, this.redoStates, "redo", "undo");
    },
    redoEvent() {
      this.historyReplay(this.redoStates, this.undoStates, "undo", "redo");
    },
    handlePreviewImage() {
      var self = this;
      if (this.imageEdit) {
        this.previewImage = this.imageEdit;
        this.$set(this, "canvasSize", [
          this.$refs.canvasContainer.clientWidth,
          this.$refs.canvasContainer.clientHeight - 80,
        ]);
        this.startCreate = true;
        this.initCanvas();
      }
    },
    initCanvas() {
      canvas = new fabric.Canvas("createCanvas");
      canvas.selectionColor = "rgba(0,0,0,0.5)";
      canvas.selectionBorderColor = "gray";
      canvas.selectionLineWidth = 1;
      fabric.Object.prototype.objectCaching = false;
      // console.log(this.__canvas);
      canvas.setDimensions({
        width: this.canvasSize[0],
        height: this.canvasSize[1],
      });

      canvas.backgroundColor = "#303a52";
      var self = this;
      fabric.Image.fromURL(this.previewImage, function (oImg) {
        let scale = self.canvasSize[0] / oImg.width;
        canvas.setDimensions({
          width: self.canvasSize[0],
          height: oImg.height * scale,
        });
        oImg.set({
          width: oImg.width,
          height: oImg.height,
          scaleX: scale,
          scaleY: scale,
          crossOrigin: "anonymous",
          selectable: false,
          evented: false,
        });
        // console.log(oImg);

        if (oImg.width >= self.canvasSize[0] && oImg.width >= oImg.height) {
          oImg.scaleToWidth(self.canvasSize[0]);
        }
        if (oImg.height >= self.canvasSize[1] && oImg.height >= oImg.width) {
          oImg.scaleToHeight(self.canvasSize[1]);
        }
        canvas.add(oImg);
        // set the object to be centered to the Canvas
        canvas.centerObject(oImg);
        oImg.setCoords();
        canvas.renderAll();
      });

      this.historySave();
      canvas.on("object:modified", function () {
        self.historySave();
      });
    },
    changeTextProp(val, prop) {
      setActiveProp(prop, val);
    },
    createText() {
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
        textAlign: "center",
      };
      var textbox = new fabric.Textbox("text", textProp);
      canvas.add(textbox);
      canvas.setActiveObject(textbox);
      this.activeObject = canvas.getActiveObject();
      this.showTextTool = true;
    },
    cancelEditText() {
      var activeObjects = canvas.getActiveObjects();
      canvas.discardActiveObject();
      if (activeObjects.length) {
        canvas.remove.apply(canvas, activeObjects);
      }
      this.activeObject = null;
      this.showTextTool = false;
      canvas.renderAll();
    },
    clickCanvasHandle() {
      console.log("clickCanvasHandle");
      this.activeObject = canvas.getActiveObject();
      if (this.activeObject && this.activeObject.type === "textbox") {
        this.fontSize = this.activeObject.fontSize;
      }
    },
  },
};
</script>

<style lang="css">
input[type="range"] {
  height: 26px;
  -webkit-appearance: none;
  margin: 10px 0;
  width: 100%;
}
input[type="range"]:focus {
  outline: none;
}
input[type="range"]::-webkit-slider-runnable-track {
  width: 100%;
  height: 14px;
  cursor: pointer;
  animate: 0.2s;
  box-shadow: 1px 1px 1px #50555c;
  background: #50555c;
  border-radius: 14px;
  border: 0px solid #000000;
}
input[type="range"]::-webkit-slider-thumb {
  box-shadow: 0px 0px 0px #000000;
  border: 0px solid #000000;
  height: 20px;
  width: 40px;
  border-radius: 12px;
  background: #529de1;
  cursor: pointer;
  -webkit-appearance: none;
  margin-top: -3px;
}
input[type="range"]:focus::-webkit-slider-runnable-track {
  background: #50555c;
}
input[type="range"]::-moz-range-track {
  width: 100%;
  height: 14px;
  cursor: pointer;
  animate: 0.2s;
  box-shadow: 1px 1px 1px #50555c;
  background: #50555c;
  border-radius: 14px;
  border: 0px solid #000000;
}
input[type="range"]::-moz-range-thumb {
  box-shadow: 0px 0px 0px #000000;
  border: 0px solid #000000;
  height: 20px;
  width: 40px;
  border-radius: 12px;
  background: #529de1;
  cursor: pointer;
}
input[type="range"]::-ms-track {
  width: 100%;
  height: 14px;
  cursor: pointer;
  animate: 0.2s;
  background: transparent;
  border-color: transparent;
  color: transparent;
}
input[type="range"]::-ms-fill-lower {
  background: #50555c;
  border: 0px solid #000000;
  border-radius: 28px;
  box-shadow: 1px 1px 1px #50555c;
}
input[type="range"]::-ms-fill-upper {
  background: #50555c;
  border: 0px solid #000000;
  border-radius: 28px;
  box-shadow: 1px 1px 1px #50555c;
}
input[type="range"]::-ms-thumb {
  margin-top: 1px;
  box-shadow: 0px 0px 0px #000000;
  border: 0px solid #000000;
  height: 20px;
  width: 40px;
  border-radius: 12px;
  background: #529de1;
  cursor: pointer;
}
input[type="range"]:focus::-ms-fill-lower {
  background: #50555c;
}
input[type="range"]:focus::-ms-fill-upper {
  background: #50555c;
}
</style>