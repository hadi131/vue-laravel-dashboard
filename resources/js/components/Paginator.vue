<template>
    <nav aria-label="Page navigation example">
        <ul
            class="pagination d-flex align-items-center"
        >
            <li class="page-item">
                <button
v-if="prevPage != null"
                    @click="
                        prev
                    "
                    class="page-link"
                >

                    {{ $t("Previous") }}

                </button>
                <button
                v-else
                    class="page-link btn disabled"
                    disabled
                >
                {{ $t("Previous") }}

                </button>
            </li>
            <li class="mx-2">
                showing {{from}} to
                {{ to }} of
                {{ total }}
            </li>
            <li class="page-item">
                <button
                v-if="nextPage != null"

                    @click="
                       next
                    "
                    class="page-link btn"
                >
                {{ $t("Next") }}

                </button>
                <button
                v-else
                    class="page-link btn disabled"
                    disabled
                >
                {{ $t("Next") }}

                </button>
            </li>
        </ul>
    </nav>
</template>
<script>
export default {
    props:{
to:String,
from:String,
total:String,
nextPage:String,
prevPage:String
    },
    methods:{
        next(){
            this.$emit('next');
        },
        prev(){
            this.$emit('prev');
        }
    }
}
</script>
