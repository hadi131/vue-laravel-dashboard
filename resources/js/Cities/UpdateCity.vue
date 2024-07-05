<template>
    <div
        class="row mt-2 h-100 d-flex justify-content-center align-items-center"
    >
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Update City</div>
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
                                <small class="text-danger">{{
                                    errorMsg.name
                                }}</small>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <v-select
                                    class="mt-2"
                                    :value="this.stateName"
                                    v-model="state_id"
                                    label="name"
                                    placeholder="Select State"
                                    :options="states"
                                    @search="fetchAllStates"
                                />
                                <small class="text-danger">{{
                                    errorMsg.state_id
                                }}</small>
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="d-flex gap-2">
                                <Button
                                
                                    name="Update"
                                    color="warning"
                                />
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
import { resolveDirective } from "vue";
import vSelect from "vue-select";
import "vue-select/dist/vue-select.css";
export default {
    data() {
        return {
            errorMsg: {
                state_id: "",
                name: "",
            },
            stateName: "",
            name: "",
            state_id: "",
            search: "",
            states: [],
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
        this.getCityData(this.$route.params.id);
        this.temp_id = this.$route.params.id;
        this.fetchAllstates();
    },

    methods: {
        fetchAllstates() {
            axios.get("/api/state").then((res) => {
                this.states = res.data;
            });
        },
        getCityData(id) {
            axios.get(`/api/city/${id}`).then((res) => {
                (this.name = res.data[0].name),
                    (this.state_id = res.data[0].state.name);
            });
        },
        callback(modelName, value) {
            this[modelName] = value;
        },
        async save() {
            try {
                await axios
                    .put(`/api/city/${this.temp_id}`, {
                        name: this.name,
                        state_id: this.state_id.id,
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
                            title: "State Updated successfully",
                        });
                        this.name = "";
                        this.temp_id = null;
                        this.isEditting = false;
                        this.$router.push("/city");
                    });
            } catch (e) {
                this.errorMsg.name = e.response.data.errors.name[0];
                this.errorMsg.state_id = e.response.data.errors.state_id[0];
            }
        },
    },
};
</script>
