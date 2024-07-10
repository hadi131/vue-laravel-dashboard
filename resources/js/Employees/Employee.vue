<template>
    <div class="row col-md-12">
        <div class="d-flex justify-content-between my-2">
            <form v-on:submit.prevent="updateURL">
                <div class="form-group">
                    <input
                        class="form-control"
                        type="search"
                        placeholder="Search here ..."
                        aria-label="Search"
                        v-model="searchQuery"
                        @input="updateURL"
                    />
                </div>
            </form>
            <RouterLink to="/addemployee" type="button" class="btn btn-warning">

                {{ $t('Add New Employee') }}
            </RouterLink>
        </div>
    </div>
    <div class="row">
        <div class="page-inner">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">

                            <h4 class="card-title">{{ $t('All Employees') }}</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table
                                    class="table-responsive table table-bordered table-striped table-hover"
                                >
                                    <thead>
                                        <tr>
                                            <th @click="toggleSort('id')">
                                                <span>{{ $t('ID') }}</span>
                                                <i
                                                    v-if="sortField === 'id'"
                                                    class="fa-solid"
                                                    :class="
                                                        sortDirection === 'DESC'
                                                            ? 'fa-sort-down'
                                                            : 'fa-sort-up'
                                                    "
                                                ></i>
                                            </th>
                                            <th @click="toggleSort('name')">
                                                <span>{{ $t('Name') }}</span>
                                                <i
                                                    v-if="sortField === 'name'"
                                                    class="fa-solid"
                                                    :class="
                                                        sortDirection === 'DESC'
                                                            ? 'fa-sort-down'
                                                            : 'fa-sort-up'
                                                    "
                                                ></i>
                                            </th>

                                            <th @click="toggleSort('email')">
                                                <span>{{ $t('Email') }}</span>
                                                <i
                                                    v-if="sortField === 'email'"
                                                    class="fa-solid"
                                                    :class="
                                                        sortDirection === 'DESC'
                                                            ? 'fa-sort-down'
                                                            : 'fa-sort-up'
                                                    "
                                                ></i>
                                            </th>
                                            <th
                                                @click="toggleSort('city_name')"
                                            >
                                                <span>{{ $t('City') }}</span>
                                                <i
                                                    v-if="
                                                        sortField ===
                                                        'city_name'
                                                    "
                                                    class="fa-solid"
                                                    :class="
                                                        sortDirection === 'DESC'
                                                            ? 'fa-sort-down'
                                                            : 'fa-sort-up'
                                                    "
                                                ></i>
                                            </th>
                                            <th
                                                @click="
                                                    toggleSort('state_name')
                                                "
                                            >
                                                <span>{{ $t('State') }}</span>
                                                <i
                                                    v-if="
                                                        sortField ===
                                                        'state_name'
                                                    "
                                                    class="fa-solid"
                                                    :class="
                                                        sortDirection === 'DESC'
                                                            ? 'fa-sort-down'
                                                            : 'fa-sort-up'
                                                    "
                                                ></i>
                                            </th>
                                            <th
                                                @click="
                                                    toggleSort('country_name')
                                                "
                                            >
                                                <span>{{ $t('Country') }}</span>
                                                <i
                                                    v-if="
                                                        sortField ===
                                                        'country_name'
                                                    "
                                                    class="fa-solid"
                                                    :class="
                                                        sortDirection === 'DESC'
                                                            ? 'fa-sort-down'
                                                            : 'fa-sort-up'
                                                    "
                                                ></i>
                                            </th>
                                        </tr>
                                    </thead>

                                    <tbody v-if="lists?.data?.length > 0">
                                        <tr v-for="i in lists.data" :key="i.id">
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
                                                        {{ $t('Update') }}
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

                                <div>
                                    <Paginator
                                        @next="fetchNextPage"
                                        @prev="fetchPrevPage"
                                        :from="this.from"
                                        :to="this.to"
                                        :total="this.total"
                                        :nextPage="this.next"
                                        :prevPage="this.prev"
                                    />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
// import { loadLocaleMessages } from "../i18n";

import axios from "axios";
import Button from "../components/Button.vue";
import LinkComponent from "../components/LinkComponent.vue";
import Swal from "sweetalert2";
import Paginator from "../components/Paginator.vue";
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
            page: 1,
            Pagination: false,
            sortField: "id",
            sortDirection: "DESC",
            next: "",
            prev: "",
            from: "",
            to: "",
            total: "",

            searchQuery: this.$route.query.search || "",
        };
    },
    components: {
        LinkComponent,
        Button,
        Paginator,
    },
    mounted() {
        this.fetchAll();
    },

    watch: {
        "$route.query": {
            handler(newQuery) {
                this.searchQuery = newQuery.search || "";

                this.fetchAll();
            },
            immediate: true,
        },

    },
    methods: {
        // async changeLanguage(locale) {
        //     await loadLocaleMessages(locale);

        // },
        fetchNextPage() {
            this.page++;
            this.fetchAll();
        },
        fetchPrevPage() {
            this.page--;
            this.fetchAll();
        },
        updateURL() {
            const query = {
                search: this.searchQuery,
                page: this.page,
            };

            this.$router.push({ query });
        },
        toggleSort(sortField) {
            if (this.sortDirection === "ASC") {
                (this.sortField = sortField), (this.sortDirection = "DESC");
                // this.fetchAll();
            } else {
                this.sortField = sortField;
                this.sortDirection = "ASC";
            }
            this.fetchAll();
        },
        fetchAll(url = null) {
            const params = {
                page: this.page,
                search: this.searchQuery,
                // Pagination: !this.Pagination,
                sortField: this.sortField,
                sortDirection: this.sortDirection,
            };
            let fetchUrl = url || "/api/employee";
            axios
                .get(fetchUrl, {
                    params,
                })
                .then((res) => {
                    console.log(res);
                    (this.lists = res.data),
                        (this.next = this.lists.links.next);
                    this.prev = this.lists.links.prev;
                    this.from = this.lists.meta.from;
                    this.to = this.lists.meta.to;
                    this.total = this.lists.meta.total;
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
