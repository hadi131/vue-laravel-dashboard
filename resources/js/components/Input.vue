<template>

    <div class="form-group">
        <label for="email2">{{label}}</label>
        <input  :type="type" :name="name" class="form-control" id="email2"
            :placeholder='placeholder' @input="someEvent($event.target.value)" :value="selectedValue" />
    </div>

</template>
<script>
export default {
    props:{
        label: String,
        type: String,
        name: String,
        placeholder: String,
        vmodel:String,
        selectedValue:String,
    },
    methods:{
        someEvent(value){
            this.$emit('someEvent', this.vmodel, value);
        }
    }
}
</script>
