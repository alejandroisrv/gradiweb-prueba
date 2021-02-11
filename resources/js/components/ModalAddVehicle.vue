<template>
<div class="modal fade" id="modalVehiculo" tabindex="-1" role="dialog" aria-labelledby="modalVehiculoLabel" aria-hidden="true">
    <div class="modal-dialog" role="document" style="top:100px;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalVehiculoLabel">Nuevo vehículo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="#" @submit="addVehicle()">
                <div class="modal-body">
                    <div class="alert" role="alert" :class="alert.type == 'success' ? 'alert-success' : 'alert-danger' " v-if="alert.text != ''">
                        {{ alert.text }}
                    </div>

                    <div class="form-row">
                        <div class="form-group col-6">
                            <label>Nombre:</label>
                            <input type="text" required class="form-control" v-model="vehiculo.owner_name">
                        </div>
                        <div class="form-group col-6">
                            <label>Cédula:</label>
                            <input type="text" required class="form-control" v-model="vehiculo.owner_document">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-4">
                            <label>Modelo</label>
                            <input type="text" required class="form-control" v-model="vehiculo.model">
                        </div>
                        <div class="form-group col-4">
                            <label>Marca</label>
                            <input type="text" required class="form-control" v-model="vehiculo.brand">
                        </div>

                        <div class="form-group col-4">
                            <label>Placa</label>
                            <input type="text" required class="form-control" v-model="vehiculo.placa">
                        </div>
                        <div class="col-12">
                            <label>Tipo de vehículo</label>
                            <input type="text" required class="form-control" v-model="vehiculo.vehicle_types">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>

            </form>
        </div>
    </div>
</div>
</template>

<script>
export default {
    data() {
        return {
            vehiculo: {
                'model': '',
                'brand': '',
                'placa': '',
                'owner_name': '',
                'owner_document': '',
                'vehicle_types': ''
            },
            alert: {
                text: '',
                status: ''
            }
        }
    },
    methods: {
        addVehicle() {

            this.alert = {
                text: '',
                status: ''
            }

            axios.post('/api/vehicle', this.vehiculo).then(rs => {
                this.$parent.$emit('created_vehicle');

                this.vehiculo = {
                    'model': '',
                    'brand': '',
                    'placa': '',
                    'owner_name': '',
                    'owner_document': '',
                    'vehicle_types': ''
                }

                this.alert.type = "success";
                this.alert.text = "Se ha añadido el vehículo correctamente";

                setTimeout(() => {
                    $("#modalVehiculo").modal('hide');
                }, 220);

            }).catch(err => {
                this.alert.type = "error";
                this.alert.text = "Se ha producido un error";
            });
        }
    }
}
</script>

<style>

</style>
