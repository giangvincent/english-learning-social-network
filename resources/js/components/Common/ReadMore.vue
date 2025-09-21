<template>
    <div class="read-more">
        <div v-html="displayHtml"></div>
        <button
            v-if="isTruncatable"
            type="button"
            class="mt-2 text-blue-500 hover:underline focus:outline-none"
            @click="toggle"
        >
            {{ expanded ? lessLabel : moreLabel }}
        </button>
    </div>
</template>

<script>
import { computed, ref, watch } from 'vue';
import truncate from 'html-truncate';

export default {
    name: 'ReadMore',
    props: {
        text: {
            type: String,
            default: '',
        },
        maxChars: {
            type: Number,
            default: 700,
        },
        moreStr: {
            type: String,
            default: 'Read more',
        },
        lessStr: {
            type: String,
            default: 'Read less',
        },
    },
    setup(props) {
        const expanded = ref(false);
        const truncated = ref('');

        const updateTruncate = () => {
            truncated.value = truncate(props.text || '', props.maxChars, { ellipsis: '...' });
        };

        watch(
            () => [props.text, props.maxChars],
            () => {
                expanded.value = false;
                updateTruncate();
            },
            { immediate: true }
        );

        const isTruncatable = computed(() => (props.text || '').length > props.maxChars);

        const displayHtml = computed(() => {
            if (!isTruncatable.value || expanded.value) {
                return props.text || '';
            }
            return truncated.value;
        });

        const toggle = () => {
            expanded.value = !expanded.value;
        };

        const lessLabel = computed(() => props.lessStr);
        const moreLabel = computed(() => props.moreStr);

        return {
            displayHtml,
            expanded,
            isTruncatable,
            toggle,
            lessLabel,
            moreLabel,
        };
    },
};
</script>

<style scoped>
.read-more button {
    font-weight: 600;
}
</style>
