<template>


    <div class="card-action">
        <RouterLink :to="ref" type="button"
        class="btn" :class="`btn-${color}`">

        {{name}}
    </RouterLink>
    </div>



</template>
<script>
export default {
    props:{
        color: String,
        name: String,
        ref:String
    }
}
</script>
