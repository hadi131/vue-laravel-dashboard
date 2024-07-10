<template>
    <div class="card-action">
        <button class="btn" :class="`btn-${color}`">{{ $t(name) }}</button>
    </div>
</template>
<script>
export default {
    props: {
        color: String,
        name: String,
    },
};
</script>
