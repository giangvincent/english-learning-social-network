<template>
  <div class="slide-images">
    <img :src="currentImage" class="slide-images__item" alt="Slide image" />
    <button type="button" class="slide-images__nav slide-images__nav--prev" @click="prev">
      <slot name="prevButton">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
        </svg>
      </slot>
    </button>
    <button type="button" class="slide-images__nav slide-images__nav--next" @click="next">
      <slot name="nextButton">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
      </slot>
    </button>
  </div>
</template>

<script>
import { computed, ref, watch } from 'vue';
import defaultImage from '@/assets/images/default.jpg';

const FALLBACK_IMAGES = [
  'https://3.bp.blogspot.com/-Chu20FDi9Ek/WoOD-ehQ29I/AAAAAAAAK7U/mc4CAiTYOY8VzOFzBKdR52aLRiyjqu0MwCLcBGAs/s1600/DSC04596%2B%25282%2529.JPG',
  defaultImage,
];

export default {
  name: 'SlideImages',
  props: {
    modelValue: {
      type: Number,
      default: 0,
    },
    sources: {
      type: Array,
      default: () => FALLBACK_IMAGES,
    },
  },
  emits: ['update:modelValue'],
  setup(props, { emit }) {
    const images = computed(() => (props.sources.length ? props.sources : FALLBACK_IMAGES));

    const clampIndex = (index) => {
      const total = images.value.length;
      if (total === 0) {
        return 0;
      }
      return (index + total) % total;
    };

    const currentIndex = ref(clampIndex(props.modelValue));

    watch(
      () => props.modelValue,
      (value) => {
        currentIndex.value = clampIndex(value);
      }
    );

    const updateIndex = (nextIndex) => {
      currentIndex.value = clampIndex(nextIndex);
      emit('update:modelValue', currentIndex.value);
    };

    const currentImage = computed(() => images.value[clampIndex(currentIndex.value)] || defaultImage);

    const prev = () => updateIndex(currentIndex.value - 1);
    const next = () => updateIndex(currentIndex.value + 1);

    return {
      currentImage,
      prev,
      next,
    };
  },
};
</script>

<style scoped>
.slide-images {
  position: relative;
}

.slide-images__item {
  display: block;
  height: 500px;
  object-fit: cover;
  width: 100%;
}

.slide-images__nav {
  background: transparent;
  border: none;
  color: #fff;
  cursor: pointer;
  font-size: 24px;
  height: 100%;
  position: absolute;
  top: 0;
  transition-duration: 0.3s;
  width: 80px;
}

.slide-images__nav:hover {
  background-color: rgba(0, 0, 0, 0.5);
  opacity: 1;
}

.slide-images__nav--prev {
  left: 0;
}

.slide-images__nav--next {
  right: 0;
}
</style>
