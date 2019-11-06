<template>
    <f7-page name="surveys">
        <f7-navbar :sliding="true" back-link="Atrás" title="Cupones">
            <f7-nav-right>
                <f7-link icon-ios="f7:menu"
                         icon-aurora="f7:menu"
                         icon-md="material:menu"
                         panel-open="left">
                </f7-link>
            </f7-nav-right>
        </f7-navbar>
        <f7-block>
            <f7-card>
                <f7-card-content>
                    <f7-list form style="margin: 15px;max-width: 100%;">
                        <f7-list-input
                                class="kingans-border"
                                label="Nombre del cupón"
                                placeholder="EJ: Nuevos Usuarios"
                                type="text"
                                info="Obligatorio"
                                :value="items.name"
                                clear-button
                                validate
                                required
                                :error-message="'Campo Obligatorio'"
                                @input="items.name = $event.target.value"
                        ></f7-list-input>
                        <f7-list-input
                                class="kingans-border"
                                label="Descripción de código"
                                placeholder=""
                                type="textarea"
                                info="Obligatorio"
                                :value="items.description"
                                clear-button
                                validate
                                required
                                :error-message="'Campo Obligatorio'"
                                @input="items.description = $event.target.value"
                        ></f7-list-input>
                        <f7-list-input
                                class="kingans-border"
                                label="Código de cupón"
                                placeholder="EJ: FRAPPE2X1"
                                type="text"
                                info="Obligatorio"
                                :value="items.code"
                                clear-button
                                validate
                                required
                                :error-message="'Campo Obligatorio'"
                                @input="items.code = $event.target.value"
                        ></f7-list-input>
                        <f7-list-input
                                class="kingans-border"
                                label="Sucursal"
                                type="select"
                                info="Obligatorio"
                                placeholder="Sucursal"
                                :value="items.branch_id"
                                validate
                                required
                                :error-message="'Campo Obligatorio'"
                                @input="items.branch_id = $event.target.value"
                        >
                            <option value="0">Todas</option>
                            <option v-for="(branch, index) in branches" :key="index"
                                    :value="branch.id">{{branch.name}}</option>
                        </f7-list-input>
                        <f7-list-input
                                class="kingans-border"
                                label="Visitas requeridas"
                                placeholder="EJ: 2"
                                type="number"
                                info="Obligatorio"
                                :value="items.required_number"
                                clear-button
                                validate
                                required
                                min="0"
                                :error-message="'Campo Obligatorio'"
                                @input="items.required_number = $event.target.value"
                        ></f7-list-input>
                        <f7-list-input
                                label="Fecha de inicio"
                                type="datepicker"
                                placeholder="Selecciona una Fecha"
                                clear-button
                                @calendar:change="setCalendarStartDate"
                                validate
                                required
                                readonly
                                :error-message="'Campo Obligatorio'"
                                :calendar-params="calendarParams">
                        </f7-list-input>
                        <f7-list-input
                                label="Fecha de fin"
                                type="datepicker"
                                placeholder="Selecciona una Fecha"
                                clear-button
                                @calendar:change="setCalendarEndDate"
                                validate
                                required
                                readonly
                                :error-message="'Campo Obligatorio'"
                                :calendar-params="calendarParams">
                        </f7-list-input>
                        <f7-button style="margin: 15px"
                                   class="btn-primary"
                                   large @click="sendForm">
                            REGISTRAR USUARIO A LA APLICACIÓN
                        </f7-button>
                    </f7-list>
            </f7-card-content>
        </f7-card>
        </f7-block>
    </f7-page>
</template>
<script>
    export default {
        name: "couponsAdd",
        data() {
            return {
                calendarParams: {
                    closeOnSelect: true,
                    header: true,
                    footer: false,
                    dateFormat: 'dd MM yyyy',
                },
                branches:[],
                items:{
                    branch_id:'',
                    name:'',
                    description: '',
                    code: '',
                    required_number: '',
                    start: '',
                    end: ''
                }
            }
        },
        created: function(){
            this.getBranches()
        },
        methods: {
            getDateSQLFormat(e) {
                let d = new Date(e);
                let month = '' + (d.getMonth()+1);
                let day = '' + d.getDate();
                let year = d.getFullYear();

                if (month.length < 2) {
                    month = '0' + month;
                }
                if (day.length < 2) {
                    day = '0' + day;
                }
                return [year, month, day].join('-');
            },
            setCalendarStartDate: function (e) {
                this.items.start = this.getDateSQLFormat(e);
            },
            setCalendarEndDate: function (e) {
                this.items.end = this.getDateSQLFormat(e);
            },
            checkForm() {
                let vm = this;
                let isValid = true;
                Object.keys(this.items).forEach(function (index, item) {
                    if (vm.items[index] === "") {
                        isValid = false
                    }
                });
                return isValid;

            },
            getBranches() {
                let vm = this
                vm.$f7.dialog.preloader('Obteniendo datos...');
                this.$http.post(this.$store.state.application.config.api + 'branches/get').then(response => {
                    vm.$f7.dialog.close();
                    vm.branches = response.data
                }, response => {
                    console.log(response, 'error on getBranches branches/get');
                    this.$f7.dialog.close();
                    this.$f7.dialog.alert("Servidor no disponible", 'Intente más tarde');
                });
            },
            sendForm: function () {
                if (this.checkForm()) {
                    this.$f7.dialog.preloader('Enviando datos...');
                    this.$http.post(this.$store.state.application.config.api + 'coupons/add', {
                        branch_id: this.items.branch_id,
                        name: this.items.name,
                        description: this.items.description,
                        code: this.items.code,
                        required_number: this.items.required_number,
                        start: this.items.start,
                        end: this.items.end,
                        created_by: this.$store.state.application.user.id,
                    }).then(response => {
                        this.$f7.dialog.close();
                        this.$f7.dialog.alert("Datos enviados", "Éxito");
                        this.items = {
                            branch_id:'',
                            name:'',
                            description: '',
                            code: '',
                            required_number: '',
                            start: '',
                            end: ''
                        }
                    }, response => {
                        console.log(response, 'error on checkForm coupons/add');
                        this.$f7.dialog.close();
                        this.$f7.dialog.alert("Servidor no disponible y/o Datos duplicados", 'Intente más tarde');
                    });

                } else {
                    this.$f7.dialog.alert("Todos los campos son requeridos.");
                }
            },
        }
    }
</script>

<style scoped>

</style>