<template>
    <div
        class="row mt-2 h-100 d-flex justify-content-center align-items-center"
    >
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Update Country</div>
                </div>
                <div class="card-body">
                    <form v-on:submit.prevent="save">
                    <div class="row">
                        <div class="col-md-12">
                            <Input
                                label="Name"
                                type="text"
                                placeholder="Enter Country Name"
                                name="name"
                                :selectedValue="name"
                                vmodel="name"
                                @some-event="callback"
                            />
                            <small class="text-danger">{{ errorMsg }}</small>
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="d-flex gap-2">
                            <Button
                             
                                name="Update"
                                color="warning"
                            />
                            <RouterLink
                                to="/country"
                                type="button"
                                class="btn btn-warning"
                            >
                                Back
                            </RouterLink>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Input from "../components/Input.vue";
import Button from "../components/Button.vue";
import axios from "axios";
import Swal from "sweetalert2";
import { resolveDirective } from "vue";
export default {
    data() {
        return {
            errorMsg: "",

            name: "",
            search: "",
            lists: [],
            temp_id: null,
            isEditting: false,
        };
    },
    components: {
        Input,
        Button,
    },
    mounted() {
        this.getCountryData(this.$route.params.id);
        this.temp_id = this.$route.params.id;
    },

    methods: {
        getCountryData(id) {
            axios
                .get(`/api/country/${id}`)
                .then((res) => (this.name = res.data[0].name));
        },
        callback(modelName, value) {
            this[modelName] = value;
        },
        async save() {
            try {
                await axios
                    .put(`/api/country/${this.temp_id}`, {
                        name: this.name,
                    })
                    .then((res) => {
                        // this.fetchAll(),
                        const Toast = Swal.mixin({
                            toast: true,
                            position: "top-end",
                            showConfirmButton: false,
                            timer: 2000,
                            timerProgressBar: true,
                            didOpen: (toast) => {
                                toast.onmouseenter = Swal.stopTimer;
                                toast.onmouseleave = Swal.resumeTimer;
                            },
                        });
                        Toast.fire({
                            icon: "success",
                            title: "Country Updated successfully",
                        });
                        this.name = "";
                        this.temp_id = null;
                        this.isEditting = false;
                        this.$router.push("/country");
                    });
            } catch (e) {
                this.errorMsg = e.response.data.message;
            }
        },
    },
};
</script>
