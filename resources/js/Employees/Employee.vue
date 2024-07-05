<template>
    <div class="row col-md-12">
        <div class="d-flex justify-content-between my-2">
            <div class="form-group">
                <input
                    class="form-control"
                    type="search"
                    placeholder="Search here ..."
                    aria-label="Search"
                    v-model="search"
                    @input="this.fetchAll"
                />
            </div>

            <RouterLink to="/addemployee" type="button" class="btn btn-warning">
                Add New Employee
            </RouterLink>
        </div>
    </div>
    <div class="row">
        <div class="page-inner">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">All Employees</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table
                                    class="table-responsive table table-bordered table-striped table-hover"
                                >
                                    <thead>
                                        <tr>
                                            <th>#ID</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>City</th>
                                            <th>State</th>
                                            <th>Country</th>
                                        </tr>
                                    </thead>

                                    <tbody v-if="lists.length > 0">
                                        <tr v-for="i in lists" :key="i.id">
                                            <td>{{ i.id }}</td>
                                            <td>{{ i.name }}</td>
                                            <td>{{ i.email }}</td>
                                            <td>{{ i.address.city.name }}</td>
                                            <td>{{ i.address.state.name }}</td>
                                            <td>
                                                {{ i.address.country.name }}
                                            </td>
                                            <td>
                                                <div class="d-flex flex-row">
                                                    <span class="mx-2">
                                                        <Button
                                                            @click="
                                                                deleteEmployee(
                                                                    i.id
                                                                )
                                                            "
                                                            name="Delete"
                                                            color="danger"
                                                        />
                                                    </span>

                                                    <span class="mx-2">
                                                        <RouterLink
                                                            :to="{
                                                                path:
                                                                    '/employee/' +
                                                                    i.id +
                                                                    '/edit',
                                                            }"
                                                            type="button"
                                                            class="btn btn-warning"
                                                        >
                                                            Update
                                                        </RouterLink>
                                                    </span>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tbody v-else>
                                        <div class="col-md-6 mt-3">
                                            <h4>No data to show</h4>
                                        </div>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import axios from "axios";
import Button from "../components/Button.vue";
import LinkComponent from "../components/LinkComponent.vue";
import Swal from "sweetalert2";
export default {
    data() {
        return {
            errorMsg: {
                country_id: "",
                name: "",
                email: "",
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
            isEditting: false,
        };
    },
    components: {
        LinkComponent,
        Button,
    },
    mounted() {
        this.fetchAll();
    },

    methods: {
        fetchAll() {
            axios
                .get("/api/employee", { params: { search: this.search } })
                .then((res) => {
                    this.lists = res.data;
                });
        },
        deleteEmployee(id) {
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!",
            }).then((result) => {
                if (result.isConfirmed) {
                    axios
                        .delete(`/api/employee/${id}`)
                        .then((res) => this.fetchAll());

                    Swal.fire({
                        timer: 1000,

                        title: "Deleted!",
                        text: "Your file has been deleted.",
                        icon: "success",
                    });
                }
            });
        },
    },
};
</script>
