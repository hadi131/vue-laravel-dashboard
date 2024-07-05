<template>
    <div
        class="row mt-2 h-100 d-flex justify-content-center align-items-center"
    >
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Add new State</div>
                </div>
                <div class="card-body">
                    <form v-on:submit.prevent="save">

                    <div class="row">
                        <div class="col-md-12">
                            <Input
                                value=""
                                label="Name"
                                type="text"
                                placeholder="Enter State Name"
                                name="name"
                                vmodel="name"
                                @some-event="callback"
                            />
                            <small class="text-danger">{{
                                errorMsg.name
                            }}</small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">


                            <v-select
                            class="mt-2"
                              v-model="country_id"
                              label="name"
                              placeholder="Select Country"
                              :options="countries"
                              @search="fetchAllCountries"
                            />


                            <small class="text-danger">{{
                                errorMsg.country_id
                            }}</small>
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="d-flex gap-2">
                            <Button name="Add" color="primary" />

                            <RouterLink
                                to="/state"
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
import vSelect from "vue-select";
import "vue-select/dist/vue-select.css";
export default {
    data() {
        return {
            errorMsg: {
                country_id: "",
                name: "",
            },
            name: "",
            country_id: "",
            search: "",
            countries: [],
            lists: [],
            temp_id: null,
            isEditting: false,
        };
    },
    components: {
        Input,
        Button,
        vSelect,
    },
    mounted() {
        this.fetchAllCountries();
    },
    methods: {
        fetchAllCountries() {
            axios
                .get("/api/country",{ params: { search: this.search } })
                .then((res) => (this.countries = res.data));
        },
        callback(modelName, value) {
            this[modelName] = value;
        },
        async save() {
            try {
                await axios
                    .post("/api/state", {
                        name: this.name,
                        country_id: this.country_id.id,
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
                            title: "Country Added successfully",
                        });
                        this.name = "";
                        this.temp_id = null;
                        this.isEditting = false;
                        this.$router.push("/state");
                    });
            } catch (e) {
                console.log(e);
                this.errorMsg.name = e.response.data.errors.name[0];
                this.errorMsg.country_id = e.response.data.errors.country_id[0];
            }
        },
    },
};
</script>
