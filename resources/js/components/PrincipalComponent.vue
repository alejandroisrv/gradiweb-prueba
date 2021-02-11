<template>
<div>
    <navbar />

    <div class="container my-4 py-2">
        <div class="row">
            <div class="col-3">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalVehiculo">
                    Añadir Vehículo
                </button>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-9">
                <p class="title">
                    Vehículos registrados
                </p>

                <div class="card" v-for="item in items" :key="item.id" v-if="vehicleSearch == ''">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <button class="btn btn-link text-dark" @click="toggleVehiclesByBrand(item)">
                                <b> {{ item.name }} ( {{item.vehicles_count }} )</b>
                            </button>
                        </h5>
                    </div>

                    <div v-if="item.show">
                        <div class="card-body">
                            <p v-for="vehicle in item.vehicles" :key="vehicle.id">
                                {{ vehicle.model }} {{ vehicle.placa }} Propietario: <span class="font-weight-bold"> {{ vehicle.owner.full_name }} {{ vehicle.owner.document }} </span>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="alert alert-warning" v-if="items.length == 0">
                    No hay vehiculos para mostrar
                </div>

                <div class="card text-left" v-if="vehicleSearch != ''">

                    <button class="btn btn-light" @click="vehicleSearch = ''; params.search = ''">
                        Mostrar todos
                    </button>
                    <div class="card-body">
                        <p style="font-size:18px;" class="mb-1"> {{ vehicleSearch.model }}</p>
                        <p class="mb-1"> Marca: {{ vehicleSearch.brand.name }} <small> {{ vehicleSearch.type.description }} </small> </p>
                        <p class="mb-1"> Placa: {{ vehicleSearch.placa }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 pr-0">
                <input type="text" class="form-control" @keyup.enter="searchVehicle()" placeholder="Buscar vehículo por placa, nombre o cédula" v-model="params.search">
            </div>
        </div>
    </div>

    <modal></modal>

</div>
</template>

<script>
import Navbar from './Navbar'
import Modal from './ModalAddVehicle'
import axios from 'axios';
import vue from 'Vue';

export default {
    data() {
        return {
            items: [],
            params: {
                search: ''
            },
            vehicleSearch: ''

        }
    },
    components: {
        Navbar,
        Modal
    },
    created() {

        this.getVehicleByBrands();

    },
    mounted() {
        this.$on('created_vehicle', () => {
            this.getVehicleByBrands();
        });

        let arr = [
            ['2018-12-01', 'AM', 'ID123', 5000],
            ['2018-12-01', 'AM', 'ID545', 7000],
            ['2018-12-01', 'PM', 'ID545', 3000],
            ['2018-12-02', 'AM', 'ID545', 7000]
        ];

        console.log(this.ordenarArreglo(arr));
    },
    methods: {
        ordenarArreglo(arr) {

            const arregloOrdenado = arr.reduce((acc, el) =>
                ({
                    ...acc,
                    [el[0]]: acc[el[0]] ? Object.assign(acc[el[0]], {
                        [el[1]]: acc[el[0]][el[1]] ? el[3] + acc[el[0]][el[1]] : el[3]
                    }) : {
                        [el[1]]: el[3]
                    }
                }), {});

            return arregloOrdenado;
        },
        toggleVehiclesByBrand(item) {
            Vue.set(item, 'show', !item.show)
        },
        async getVehicleByBrands() {
            const rs = await axios.get('/api/brands');
            this.items = rs.data
        },
        async searchVehicle() {
            const rs = await axios.get(`/api/vehicles?search=${this.params.search}`);
            this.vehicleSearch = rs.data
        },
    },
}
</script>

<style>
.title {
    font-size: 24px;
}
</style>
