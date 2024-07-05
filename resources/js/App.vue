<script>
import Navbar from '../js/components/Navbar.vue'
export default{
    components: {
        Navbar
    },
}
</script>

<template>
    <div>
        <Navbar/>
        <div class="container-fluid py-2">

            <router-view/>
        </div>
    </div>
</template>

