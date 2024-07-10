import { createRouter, createWebHistory } from "vue-router";
import Country from "../Countries/Country.vue";
import AddCountry from "../Countries/AddCountry.vue";
import State from "../States/State.vue";
import AddState from "../States/AddState.vue";
import City from "../Cities/City.vue";
import AddCity from "../Cities/AddCity.vue";
import Employee from "../Employees/Employee.vue";
import AddEmployee from "../Employees/AddEmployee.vue";
import AddLanguage from "../Languages/AddLanguage.vue";
import Language from "../Languages/Language.vue";
const routes = [

    {
        path: "/",

        component: Employee,
    },
    {
        path: "/addemployee",
        component: AddEmployee,
    },
    {
        path: "/employee/:id/edit",
        component: AddEmployee,
    },
    {
        path: "/country",
        component: Country,
    },
    {
        path: "/addcountry",
        component: AddCountry,
    },
    {
        path: "/country/:id/edit",
        component: AddCountry,
    },
    {
        path: "/state",
        component: State,
    },
    {
        path: "/addstate",
        component: AddState,
    },
    {
        path: "/state/:id/edit",
        component: AddState,
    },
    {
        path: "/city",
        component: City,
    },

    {
        path: "/addcity",
        component: AddCity,
    },

    {
        path: "/city/:id/edit",
        component: AddCity,
    },
    {
        path: "/addlanguage",
        component: AddLanguage,
    },
    {
        path: "/language",
        component: Language,
    },
];
const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
