<template>
    <div class="infinite-loading">
        <div v-if="status === 'loading'" class="infinite-loading__spinner">
            <slot name="spinner">Loading...</slot>
        </div>
        <div v-else-if="status === 'complete'" class="infinite-loading__complete">
            <slot name="no-more">No more results</slot>
        </div>
        <div v-else-if="status === 'no-results'" class="infinite-loading__empty">
            <slot name="no-results">No results found</slot>
        </div>
        <div v-else class="infinite-loading__sentinel" ref="sentinel"></div>
    </div>
</template>

<script>
import { onBeforeUnmount, onMounted, ref } from 'vue';

export default {
    name: 'InfiniteLoading',
    emits: ['infinite'],
    setup(props, { emit, expose }) {
        const sentinel = ref(null);
        const status = ref('idle');
        const hasLoaded = ref(false);
        let observer;
        let isFetching = false;

        const disconnect = () => {
            if (observer) {
                observer.disconnect();
                observer = undefined;
            }
        };

        const createObserver = () => {
            if (observer || !sentinel.value) {
                return;
            }

            observer = new IntersectionObserver(entries => {
                const [entry] = entries;
                if (!entry || !entry.isIntersecting || isFetching || status.value === 'complete' || status.value === 'no-results') {
                    return;
                }

                isFetching = true;
                status.value = 'loading';
                emit('infinite', stateApi);
            }, {
                rootMargin: '0px 0px 200px 0px',
            });

            observer.observe(sentinel.value);
        };

        const stateApi = {
            loaded() {
                hasLoaded.value = true;
                isFetching = false;
                status.value = 'idle';
                requestAnimationFrame(() => {
                    if (sentinel.value) {
                        disconnect();
                        createObserver();
                    }
                });
            },
            complete() {
                isFetching = false;
                status.value = hasLoaded.value ? 'complete' : 'no-results';
                disconnect();
            },
            reset() {
                hasLoaded.value = false;
                isFetching = false;
                status.value = 'idle';
                disconnect();
                createObserver();
            },
        };

        onMounted(() => {
            createObserver();
        });

        onBeforeUnmount(() => {
            disconnect();
        });

        expose({
            reset: stateApi.reset,
        });

        return {
            sentinel,
            status,
        };
    },
};
</script>

<style scoped>
.infinite-loading {
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
    min-height: 3rem;
}

.infinite-loading__sentinel {
    width: 100%;
    height: 1px;
}
</style>
