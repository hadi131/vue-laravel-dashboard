<template>
    <div
        class="row mt-2 h-100 d-flex justify-content-center align-items-center"
    >
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        {{ isEditing ? $t('Update Employee') : $t('Add New Employee') }}
                    </div>
                </div>
                <div class="card-body">
                    <form v-on:submit.prevent="save">
                        <div class="row">
                            <div class="col-md-6">
                                <Input
                                    label="Name"
                                    type="text"
                                    placeholder="Enter Employee Name"
                                    name="name"
                                    vmodel="name"
                                    @some-event="callback"
                                    :selectedValue="name"
                                />
                                <small class="text-danger">{{
                                    errorMsg?.name?.[0]
                                }}</small>
                            </div>
                            <div class="col-md-6">
                                <Input
                                    value=""
                                    label="Email"
                                    type="text"
                                    placeholder="Enter Employee Email"
                                    name="email"
                                    vmodel="email"
                                    :selectedValue="email"
                                    @some-event="callback"
                                />
                                <small class="text-danger">{{
                                    errorMsg?.email?.[0]
                                }}</small>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <v-select
                                    class="mt-2"
                                    v-model="country_id"
                                    label="name"
                                    placeholder="Select Country"
                                    :options="countries"
                                    @search="fetchAllCountries"
                                />

                                <small class="text-danger">{{
                                    errorMsg?.country_id?.[0]
                                }}</small>
                            </div>
                            <div class="col-md-4">
                                <v-select
                                    class="mt-2"
                                    v-model="state_id"
                                    label="name"
                                    placeholder="Select State"
                                    :options="states"
                                    @search="fetchAllStates"
                                />

                                <small class="text-danger">{{
                                    errorMsg?.state_id?.[0]
                                }}</small>
                            </div>
                            <div class="col-md-4">
                                <v-select
                                    class="mt-2"
                                    v-model="city_id"
                                    label="name"
                                    placeholder="Select City"
                                    :options="cities"
                                    @search="fetchAllCities"
                                />

                                <small class="text-danger">{{
                                    errorMsg?.city_id?.[0]
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
                                    to="/"
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
                email: "",
                city_id: "",
                state_id: "",
                country_id: "",
            },
            name: "",
            email: "",
            city_id: "",
            state_id: "",
            country_id: "",
            search: "",
            cities: [],
            states: [],
            countries: [],
            lists: [],
            temp_id: null,
            isEditing: false,
            Pagination: false,
            sortField: "id",
            sortDirection: "DESC",
            countryID: "",
            stateID: "",
        };
    },
    components: {
        Input,
        Button,
        vSelect,
    },
    mounted() {
        if (this.$route.params.id) {
            this.fetchAllCountries();
            this.getEmployeeData(this.$route.params.id);
            this.temp_id = this.$route.params.id;
            this.isEditing = true;
        } else {
            this.fetchAllCountries();
        }
    },

    watch: {
        country_id(newCountry, oldCountry) {
            if (newCountry !== oldCountry) {
                this.fetchAllStates();
                // this.state_id = "";
                // this.city_id = "";
                if (this.country_id !== this.countryID) {
                    this.state_id = [];
                    this.fetchAllStates();
                }
                this.states = [];
                this.cities = [];
            }
        },
        state_id(newState, oldState) {
            if (newState !== oldState) {
                this.fetchAllCities();
                // this.city_id = "";
                if (this.state_id !== this.stateID) {
                    this.city_id = [];
                    this.fetchAllStates();
                }
                this.cities = [];
            }
        },
    },
    methods: {
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
        getEmployeeData(id) {
            axios.get(`/api/employee/${id}`).then((res) => {
                (this.name = res.data.data.name),
                    (this.email = res.data.data.email),
                    (this.countryID = this.country_id =
                        res.data.data.address.country),
                    (this.stateID = this.state_id =
                        res.data.data.address.state);
                this.city_id = res.data.data.address.city;
            });
        },
        fetchAllStates() {
            if (this.country_id?.id) {
                axios
                    .get(`/api/state?country_id=${this.country_id.id}`)
                    .then((res) => {
                        this.states = res.data.data;
                        // if(this.country_id !== this.country_id.id){
                        //     this.state_id=[]
                        //     // this.fetchAllStates()
                        //     console.log("chnaged");
                        // }else{
                        //     console.log("no");
                        // }
                    });
            } else {
                this.states = [];
            }
        },
        fetchAllCities() {
            if (this.state_id.id) {
                axios
                    .get(`/api/city?state_id=${this.state_id.id}`)
                    .then((res) => {
                        this.cities = res.data.data;
                    });
            } else {
                this.cities = [];
            }
        },

        callback(modelName, value) {
            this[modelName] = value;
        },
        async save() {
            let method = axios.post;
            let url = "/api/employee";
            if (this.isEditing) {
                method = axios.put;
                url = `/api/employee/${this.temp_id}`;
            }
            try {
                await method(url, {
                    name: this.name,
                    email: this.email,
                    city_id: this.city_id.id,
                    state_id: this.state_id.id,
                    country_id: this.country_id.id,
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
                        title: `Employee ${
                            this.isEditing ? "Updated" : "Added"
                        }  successfully`,
                    });
                    this.name = "";
                    (this.email = ""),
                        (this.city_id = ""),
                        (this.state_id = ""),
                        (this.country_id = ""),
                        (this.temp_id = null);
                    this.isEditing = false;
                    this.$router.push("/");
                });
            } catch (e) {
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
                    icon: "error",
                    title: "InValid Credentials",
                });

                this.errorMsg = e.response.data.errors;
            }
        },
    },
};
</script>
