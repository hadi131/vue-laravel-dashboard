<template>
    <div
        class="row mt-2 h-100 d-flex justify-content-center align-items-center"
    >
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        {{ isEditing ? $t("Update State") : $t("Add New State") }}
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
                                    placeholder="Enter State Name"
                                    name="name"
                                    vmodel="name"
                                    :selectedValue="name"
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
                                    :value="this.countryName"
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
                                <Button :name="isEditing ? 'Update' : 'Add'"
                                :color="isEditing ? 'warning' : 'primary'" />

                                <RouterLink
                                    to="/state"
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
            isEditing: false,
            Pagination: false,
            sortField: "id",
            sortDirection: "DESC",
        };
    },
    components: {
        Input,
        Button,
        vSelect,
    },
    mounted() {
        if (this.$route.params.id) {

            this.getStateData(this.$route.params.id);
            this.temp_id = this.$route.params.id;
            this.isEditing = true;
            this.fetchAllCountries()
        }
        else{
            this.fetchAllCountries()

        }
    },
    methods: {
        getStateData(id) {
            axios
                .get(`/api/state/${id}`)
                .then((res) => {
                    this.name = res.data.data.name,
                    this.country_id=res.data.data.country.name

                });

        },
        fetchAllCountries() {
            const params = {
                search: this.search,
                Pagination: !this.Pagination,
                sortField: this.sortField,
                sortDirection: this.sortDirection,
            };
            axios
                .get("/api/country", {
                    params,
                })
                .then((res) => {
                    this.countries = res.data.data;
                });
        },
        callback(modelName, value) {
            this[modelName] = value;
        },
        async save() {
            let method=axios.post;
            let url = "/api/state";
            if (this.isEditing) {
                method = axios.put;
                url = `/api/state/${this.temp_id}`;
            }
            try {
                await method(url, {
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
                            title: `State ${this.isEditing ? 'Updated' : 'Added'}  successfully`,
                        });
                        this.name = "";
                        this.temp_id = null;
                        this.isEditing = false;
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
