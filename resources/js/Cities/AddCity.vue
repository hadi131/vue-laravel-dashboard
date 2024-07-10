<template>
    <div
        class="row mt-2 h-100 d-flex justify-content-center align-items-center"
    >
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        {{ isEditing ? $t("Update City") : $t("Add New City") }}
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
                                <!-- Use v-select for state selection -->
                                <v-select
                                    :value="this.stateName"
                                    class="mt-2"
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
                                <Button :name="isEditing ? 'Update' : 'Add'"
                                :color="isEditing ? 'warning' : 'primary'" />
                                <RouterLink
                                    to="/city"
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
    components: {
        Input,
        Button,
        vSelect,
    },
    data() {
        return {
            errorMsg: {
                state_id: "",
                name: "",
            },
            name: "",
            state_id: null,
            search: "",
            states: [],
            Pagination: false,
            sortField: "id",
            sortDirection: "DESC",
            temp_id: null,
            isEditting: false,
        };
    },

    mounted() {
        if (this.$route.params.id) {

            this.getCityData(this.$route.params.id);
            this.temp_id = this.$route.params.id;
            this.isEditing = true;
            this.fetchAllStates()
        }
        else{
            this.fetchAllStates()

        }
    },
    methods: {
        getCityData(id) {
            axios.get(`/api/city/${id}`).then((res) => {
                this.name = res.data.data.name,
                    this.state_id = res.data.data.state.name

            });
        },
        fetchAllStates() {
            const params = {
                search: this.search,
                Pagination: !this.Pagination,
                sortField: this.sortField,
                sortDirection: this.sortDirection,
            };
            axios
                .get("/api/state", { params })
                .then((res) => {
                    this.states = res.data.data;
                })
                .catch((error) => {
                    console.error("Error fetching states:", error);
                });
        },
        callback(modelName, value) {
            this[modelName] = value;
        },
        async save() {
            let method=axios.post;
            let url = "/api/city";
            if (this.isEditing) {
                method = axios.put;
                url = `/api/city/${this.temp_id}`;
            }
            try {
                const response = await method(url, {
                    name: this.name,
                    state_id: this.state_id.id,
                });
                if (response.status === 200) {
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
                        title: `City ${this.isEditing ? 'Updated' : 'Added'}  successfully`,
                    });
                    this.$router.push("/city");
                }
            } catch (error) {
                if (error.response) {
                    this.errorMsg.name = error.response.data.errors.name[0];
                    this.errorMsg.state_id =
                        error.response.data.errors.state_id[0];
                }
                console.error("Error saving city:", error);
            }
        },
    },
};
</script>
