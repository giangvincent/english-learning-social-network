import { Comment, Fragment, cloneVNode, h } from 'vue';

const componentName = 'masonry';

const props = {
  tag: {
    type: [String],
    default: 'div',
  },
  cols: {
    type: [Object, Number, String],
    default: 2,
  },
  gutter: {
    type: [Object, Number, String],
    default: 0,
  },
  css: {
    type: [Boolean],
    default: true,
  },
  columnTag: {
    type: [String],
    default: 'div',
  },
  columnClass: {
    type: [String, Array, Object],
    default: () => [],
  },
  columnAttr: {
    type: [Object],
    default: () => ({}),
  },
};

const breakpointValue = (mixed, windowWidth) => {
  const valueAsNum = parseInt(mixed, 10);

  if (valueAsNum > -1) {
    return mixed;
  }
  if (typeof mixed !== 'object' || mixed === null) {
    return 0;
  }

  let matchedBreakpoint = Infinity;
  let matchedValue = mixed.default || 0;

  Object.keys(mixed).forEach((key) => {
    const breakpoint = parseInt(key, 10);
    const breakpointValRaw = mixed[key];
    const breakpointVal = parseInt(breakpointValRaw, 10);

    if (Number.isNaN(breakpoint) || Number.isNaN(breakpointVal)) {
      return;
    }

    const isNewBreakpoint = windowWidth <= breakpoint && breakpoint < matchedBreakpoint;
    if (isNewBreakpoint) {
      matchedBreakpoint = breakpoint;
      matchedValue = breakpointValRaw;
    }
  });

  return matchedValue;
};

const flattenChildren = (children, result = []) => {
  children.forEach((child) => {
    if (!child) {
      return;
    }

    if (Array.isArray(child)) {
      flattenChildren(child, result);
      return;
    }

    if (child.type === Comment) {
      return;
    }

    if (child.type === Fragment) {
      const fragmentChildren = Array.isArray(child.children) ? child.children : [];
      flattenChildren(fragmentChildren, result);
      return;
    }

    result.push(child);
  });

  return result;
};

const Masonry = {
  name: 'Masonry',
  props,
  data() {
    return {
      displayColumns: 2,
      displayGutter: 0,
      windowWidth: Infinity,
    };
  },
  mounted() {
    this.$nextTick(this.reCalculate);
    if (typeof window !== 'undefined') {
      window.addEventListener('resize', this.reCalculate);
    }
  },
  updated() {
    this.$nextTick(this.reCalculate);
  },
  beforeUnmount() {
    if (typeof window !== 'undefined') {
      window.removeEventListener('resize', this.reCalculate);
    }
  },
  methods: {
    reCalculate() {
      const previousWindowWidth = this.windowWidth;
      this.windowWidth =
        typeof window !== 'undefined' ? window.innerWidth || Infinity : Infinity;

      if (previousWindowWidth === this.windowWidth) {
        return;
      }

      this._reCalculateColumnCount(this.windowWidth);
      this._reCalculateGutterSize(this.windowWidth);
    },
    _reCalculateGutterSize(windowWidth) {
      this.displayGutter = breakpointValue(this.gutter, windowWidth);
    },
    _reCalculateColumnCount(windowWidth) {
      let newColumns = breakpointValue(this.cols, windowWidth);
      newColumns = Math.max(1, Number(newColumns) || 0);
      this.displayColumns = newColumns;
    },
    _getChildItemsInColumnsArray() {
      const slot = this.$slots.default ? this.$slots.default() : [];
      const childItems = flattenChildren(slot);

      const columns = [];

      childItems.forEach((child, index) => {
        const columnIndex = index % this.displayColumns;
        if (!columns[columnIndex]) {
          columns[columnIndex] = [];
        }

        const clonedChild = cloneVNode(child, {
          key:
            child.key != null
              ? `masonry-${columnIndex}-${child.key}`
              : `masonry-${columnIndex}-${index}`,
        });
        columns[columnIndex].push(clonedChild);
      });

      return columns;
    },
  },
  render() {
    const columnsContainingChildren = this._getChildItemsInColumnsArray();
    const parsedGutter = parseInt(this.displayGutter, 10);
    const isGutterSizeUnitless = parsedGutter === this.displayGutter * 1;
    const gutterSizeWithUnit = isGutterSizeUnitless
      ? `${this.displayGutter}px`
      : this.displayGutter;

    const columnBaseStyle = {
      boxSizing: 'border-box',
      backgroundClip: 'padding-box',
      width: `${100 / this.displayColumns}%`,
      border: '0 solid transparent',
      borderLeftWidth: gutterSizeWithUnit,
    };

    const columns = columnsContainingChildren.map((children, index) => {
      const key = `${index}-${columnsContainingChildren.length}`;
      const columnProps = {
        key,
        class: this.columnClass,
        ...this.columnAttr,
      };

      if (this.css) {
        const existingStyle = columnProps.style || {};
        columnProps.style = { ...existingStyle, ...columnBaseStyle };
      }

      return h(this.columnTag, columnProps, children);
    });

    const containerProps = this.css
      ? {
          style: {
            display: ['-webkit-box', '-ms-flexbox', 'flex'],
            marginLeft: `-${gutterSizeWithUnit}`,
          },
        }
      : {};

    return h(this.tag, containerProps, columns);
  },
};

const MasonryPlugin = {
  install(app, options = {}) {
    if (this.installed) {
      return;
    }

    const name = options.name || componentName;
    app.component(name, Masonry);
    this.installed = true;
  },
};

export { Masonry };
export default MasonryPlugin;
