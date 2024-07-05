import { createRouter, createWebHistory } from "vue-router";
import Country from '../Countries/Country.vue';
import AddCountry from '../Countries/AddCountry.vue';
import UpdateCountry from '../Countries/UpdateCountry.vue';
import State from '../States/State.vue';
import AddState from '../States/AddState.vue';
import UpdateState from '../States/UpdateState.vue';
import City from '../Cities/City.vue';
import AddCity from '../Cities/AddCity.vue';
import UpdateCity from '../Cities/UpdateCity.vue';
import Employee from '../Employees/Employee.vue';
import AddEmployee from '../Employees/AddEmployee.vue';
import UpdateEmployee from '../Employees/UpdateEmployee.vue';

const routes=[
    {
        path:'/',

        component:Employee
    },
    {
        path:'/addemployee',
        component:AddEmployee
    },
    {
        path:'/employee/:id/edit',
        component:UpdateEmployee
    },
    {
        path:'/country',
        component:Country
    },
    {
        path:'/addcountry',
        component:AddCountry
    },
    {
        path:'/country/:id/edit',
        component:UpdateCountry
    },
    {
        path:'/state',
        component:State
    },
    {
        path:'/addstate',
        component:AddState
    },
    {
        path:'/state/:id/edit',
        component:UpdateState
    },
    {
        path:'/city',
        component:City
    },
    {
        path:'/addcity',
        component:AddCity
    },
    {
        path:'/city/:id/edit',
        component:UpdateCity
    },
]
const router=createRouter({
    history:createWebHistory(),
    routes
})

export default router;
