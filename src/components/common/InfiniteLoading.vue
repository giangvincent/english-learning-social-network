<template>
  <div class="infinite-loading">
    <div ref="sentinel" class="infinite-loading__sentinel"></div>
    <div v-if="status === 'loading'" class="infinite-loading__feedback">
      <slot name="spinner">Loading...</slot>
    </div>
    <div v-else-if="status === 'complete'" class="infinite-loading__feedback">
      <slot name="no-more">No more results</slot>
    </div>
    <div v-else-if="status === 'empty'" class="infinite-loading__feedback">
      <slot name="no-results">No results</slot>
    </div>
  </div>
</template>

<script>
import { onBeforeUnmount, onMounted, ref } from 'vue';

export default {
  name: 'InfiniteLoading',
  emits: ['infinite'],
  setup(props, { emit }) {
    const sentinel = ref(null);
    const status = ref('idle');
    let observer = null;
    let loading = false;
    let hasLoadedAny = false;

    const cleanup = () => {
      if (observer) {
        observer.disconnect();
        observer = null;
      }
    };

    const trigger = () => {
      if (loading || status.value === 'complete' || status.value === 'empty') {
        return;
      }
      loading = true;
      status.value = 'loading';
      emit('infinite', controller);
    };

    const onIntersect = (entries) => {
      const [entry] = entries;
      if (entry && entry.isIntersecting) {
        trigger();
      }
    };

    const observe = () => {
      if (!sentinel.value) {
        return;
      }
      cleanup();
      observer = new IntersectionObserver(onIntersect, {
        rootMargin: '200px',
      });
      observer.observe(sentinel.value);
    };

    const controller = {
      loaded() {
        hasLoadedAny = true;
        loading = false;
        status.value = 'idle';
      },
      complete(showNoResults = false) {
        loading = false;
        status.value = showNoResults || !hasLoadedAny ? 'empty' : 'complete';
        cleanup();
      },
      reset() {
        hasLoadedAny = false;
        loading = false;
        status.value = 'idle';
        observe();
        trigger();
      },
    };

    onMounted(() => {
      observe();
      trigger();
    });

    onBeforeUnmount(() => {
      cleanup();
    });

    const reset = () => controller.reset();

    return {
      sentinel,
      status,
      reset,
    };
  },
};
</script>

<style scoped>
.infinite-loading {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  min-height: 3rem;
}

.infinite-loading__sentinel {
  width: 100%;
  height: 1px;
}

.infinite-loading__feedback {
  margin-top: 0.75rem;
  text-align: center;
}
</style>
