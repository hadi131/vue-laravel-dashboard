<template>
    <div
        class="row mt-2 h-100 d-flex justify-content-center align-items-center"
    >
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        {{ isEditing ? $t("Update Language") :$t( "Add New Language") }}
                    </div>
                </div>
                <div class="card-body">
                    <form v-on:submit.prevent="save">
                        <div class="row">
                            <div class="col-md-12">
                                <Input
                                    value=""
                                    label="Name"
                                    type="text"
                                    placeholder="Enter Language Name"
                                    name="name"
                                    vmodel="name"
                                    :selectedValue="name"
                                    @some-event="callback"
                                />
                                <small class="text-danger">{{
                                    errorMsg?.name?.[0]
                                }}</small>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <Input
                                    value=""
                                    label="Code"
                                    type="text"
                                    placeholder="Enter Language Code"
                                    name="code"
                                    vmodel="code"
                                    :selectedValue="code"
                                    @some-event="callback"
                                />
                                <small class="text-danger">{{
                                    errorMsg?.code?.[0]
                                }}</small>
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="d-flex gap-2">
                                <Button
                                    :name="isEditing ? 'Update' : 'Add'"
                                    :color="isEditing ? 'warning' : 'primary'"
                                />

                                <RouterLink
                                    to="/country"
                                    type="button"
                                    class="btn btn-warning"
                                >
                                    {{$t("Back")}}
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
export default {
    data() {
        return {
            errorMsg: {
                name: "",
                code: "",
            },
            name: "",
            code: "",
            search: "",
            lists: [],
            temp_id: null,
            isEditing: false,
        };
    },
    components: {
        Input,
        Button,
    },
    mounted() {
        if (this.$route.params.id) {
            this.getCountryData(this.$route.params.id);
            this.temp_id = this.$route.params.id;
            this.isEditing = true;
        }
    },
    methods: {
        callback(modelName, value) {
            this[modelName] = value;
        },
        // getCountryData(id) {
        //     axios
        //         .get(`/api/country/${id}`)
        //         .then((res) => (this.name = res.data.data.name));
        // },
        async save() {
            let method = axios.post;
            let url = "/api/language";
            if (this.isEditing) {
                method = axios.put;
                url = `/api/language/${this.temp_id}`;
            }
            try {
                await method(url, {
                    name: this.name,
                    code: this.code,
                }).then((res) => {
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
                        title: `Country ${this.isEditing ? 'Updated' : 'Added'}  successfully`,
                    });
                    this.name = "";
                    this.temp_id = null;
                    this.isEditing = false;
                    this.$router.push("/language");
                });
            } catch (e) {
                this.errorMsg = e.response.data.errors;
            }
        },
    },
};
</script>
