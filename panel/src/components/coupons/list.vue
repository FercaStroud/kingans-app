<template>
    <f7-page name="couponsList">
        <f7-navbar :sliding="true" back-link="Atrás" title="Lista de Cupones">
            <f7-nav-right>
                <f7-link @click="getList">
                    <f7-icon material="cached"></f7-icon>
                </f7-link>
                <f7-link icon-ios="f7:menu"
                         icon-aurora="f7:menu"
                         icon-md="material:menu"
                         panel-open="left">
                </f7-link>
            </f7-nav-right>
        </f7-navbar>
        <f7-card>
            <f7-card-content style="padding-top:35px; padding-bottom:35px">
                <f7-block>
                    <f7-row>
                        <f7-col>
                            <vue-good-table
                                    title="Cupones"
                                    :columns="columns"
                                    :fixed-header="true"
                                    :rows="rows"
                                    :paginate="true"
                                    :search-options="{enabled: true}">
                                <template slot="table-row" slot-scope="props">
                                    <span v-if="props.column.field == 'actions'">
                                        <f7-link v-if="$store.state.application.user.type === 'A' ||
                                                 $store.state.application.user.type === 'G'"
                                                 @click="editItem(props.row)">
                                            <f7-icon class="icon-btn" material="edit"></f7-icon>
                                        </f7-link>
                                        <f7-link v-if="$store.state.application.user.type === 'A' ||
                                                 $store.state.application.user.type === 'G'"
                                                 @click="deleteItem(props.row.id)">
                                            <f7-icon class="icon-btn" material="delete"></f7-icon>
                                        </f7-link>
                                    </span>
                                    <span v-if="props.column.field == 'src'">
                                        <strong v-if="props.row.src === null">SIN IMAGEN</strong>
                                        <img v-else
                                             :src="$store.state.application.config.api + 'images/coupons/'+props.row.src"
                                             alt=""
                                             style="width:50px; cursor:pointer"
                                             @click="windowsOpen(props.row.src)"
                                        >
                                    </span>
                                    <span v-else>
                                      {{props.formattedRow[props.column.field]}}
                                    </span>
                                </template>
                            </vue-good-table>
                        </f7-col>
                    </f7-row>
                </f7-block>
            </f7-card-content>
        </f7-card>
        <f7-popup class="" :opened="popupEditOpened" @popup:closed="popupEditOpened = false">
            <f7-page>
                <f7-navbar :title="'Editar Código: ' + itemToEdit.name">
                    <f7-nav-right>
                        <f7-link popup-close>Cancelar</f7-link>
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
                                        :value="itemToEdit.name"
                                        clear-button
                                        validate
                                        required
                                        :error-message="'Campo Obligatorio'"
                                        @input="itemToEdit.name = $event.target.value"
                                ></f7-list-input>
                                <f7-list-input
                                        class="kingans-border"
                                        label="Descripción de código"
                                        placeholder=""
                                        type="textarea"
                                        info="Obligatorio"
                                        :value="itemToEdit.description"
                                        clear-button
                                        validate
                                        required
                                        :error-message="'Campo Obligatorio'"
                                        @input="itemToEdit.description = $event.target.value"
                                ></f7-list-input>
                                <f7-list-input
                                        class="kingans-border"
                                        label="Código de cupón"
                                        placeholder="EJ: FRAPPE2X1"
                                        type="text"
                                        info="Obligatorio"
                                        :value="itemToEdit.code"
                                        clear-button
                                        validate
                                        required
                                        :error-message="'Campo Obligatorio'"
                                        @input="itemToEdit.code = $event.target.value"
                                ></f7-list-input>
                                <f7-list-input
                                        class="kingans-border"
                                        label="Sucursal"
                                        type="select"
                                        info="Obligatorio"
                                        placeholder="Sucursal"
                                        :value="itemToEdit.branch_id"
                                        validate
                                        required
                                        :error-message="'Campo Obligatorio'"
                                        @input="itemToEdit.branch_id = $event.target.value"
                                >
                                    <option value="0">Todas</option>
                                    <option v-for="(branch, index) in branches" :key="index"
                                            :value="branch.id">{{branch.name}}
                                    </option>
                                </f7-list-input>
                                <f7-list-input
                                        class="kingans-border"
                                        label="Visitas requeridas"
                                        placeholder="EJ: 2"
                                        type="number"
                                        info="Obligatorio"
                                        :value="itemToEdit.required_number"
                                        clear-button
                                        validate
                                        required
                                        min="0"
                                        :error-message="'Campo Obligatorio'"
                                        @input="itemToEdit.required_number = $event.target.value"
                                ></f7-list-input>
                                <f7-list-input
                                        label="Fecha de inicio"
                                        type="datepicker"
                                        placeholder="Selecciona una Fecha"
                                        clear-button
                                        :value="setVarStartDate"
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
                                        :value="setVarEndDate"
                                        @calendar:change="setCalendarEndDate"
                                        validate
                                        required
                                        readonly
                                        :error-message="'Campo Obligatorio'"
                                        :calendar-params="calendarParams">
                                </f7-list-input>
                            </f7-list>
                            <input type="file" ref="file"
                                   accept="image/*"
                                   required
                                   @change="onChangeFileUpload"/>
                            <f7-block>
                                <p style="margin:15px; font-size:1.2em;">
                                    <strong>NOTA:</strong> Asegúrese de que la imagen esté optimizada para
                                    ser utilizada en una aplicación. <br/>
                                    <strong>SE RECOMIENDA</strong> que su peso no exceda a 1Mb.
                                </p>
                            </f7-block>
                            <f7-button
                                    style="margin: 15px"
                                    class="btn-primary"
                                    large @click="sendForm">
                                EDITAR CUPÓN
                            </f7-button>
                        </f7-card-content>
                    </f7-card>

                </f7-block>
            </f7-page>
        </f7-popup>

    </f7-page>
</template>

<script>
    export default {
        name: "couponsList",
        data() {
            return {
                branches: [],
                setVarStartDate: null,
                setVarEndDate: null,
                calendarParams: {
                    closeOnSelect: true,
                    header: true,
                    footer: false,
                    dateFormat: 'dd MM yyyy',
                },
                itemToEdit: {
                    id: '',
                    src: '',
                    branch_id: '',
                    name: '',
                    description: '',
                    code: '',
                    required_number: '',
                    start: '',
                    end: ''
                },
                search: '',
                columns: [
                    {
                        label: 'Imagen',
                        field: 'src',
                    },
                    {
                        label: 'Nombre',
                        field: 'name',
                        filterTextInput: true
                    },
                    {
                        label: 'Sucursal',
                        field: 'branch_name',
                        filterTextInput: true
                    },
                    {
                        label: 'Descripción',
                        field: 'description',
                        filterTextInput: true
                    },
                    {
                        label: 'Código',
                        field: 'code',
                        filterTextInput: true
                    },
                    {
                        label: 'Visitas requeridas',
                        field: 'required_number',
                        filterTextInput: true
                    },
                    {
                        label: 'Fecha de Inicio',
                        field: 'start',
                        //type: 'date',
                        //dateInputFormat: 'yyyy-mm-dd',
                        //dateOutputFormat: 'MMM Do yy',
                        filterTextInput: true
                    },
                    {
                        label: 'Fecha de Fin',
                        field: 'end',
                        //type: 'date',
                        //dateInputFormat: 'yyyy-mm-dd',
                        //dateOutputFormat: 'MMM Do yy',
                        filterTextInput: true
                    },
                    {
                        label: 'Acciones',
                        field: 'actions',
                    },

                ],
                rows: [],
                popupEditOpened: false,

            }
        },
        computed: {
            filteredList() {
                return this.rows.filter(item => {
                    return item.name.toLowerCase().includes(this.search.toLowerCase())
                })
            },
        },
        created: function () {
            this.getBranches()
        },
        mounted: function () {
            this.getList()
        },
        methods: {
            windowsOpen(src) {
                window.open(this.$store.state.application.config.api + 'images/coupons/' + src, '_blank');
            },
            checkForm() {
                let vm = this;
                let isValid = true;
                Object.keys(this.itemToEdit).forEach(function (index, item) {
                    if (index !== 'src') {
                        if (vm.itemToEdit[index] === "") {
                            isValid = false
                        }
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
                let vm = this

                if (this.checkForm()) {
                    this.$f7.dialog.preloader('Enviando datos...');

                    let formData = new FormData();
                    formData.append('id', this.itemToEdit.id);
                    formData.append('src', this.itemToEdit.src);
                    formData.append('branch_id', this.itemToEdit.branch_id);
                    formData.append('name', this.itemToEdit.name);
                    formData.append('description', this.itemToEdit.description);
                    formData.append('code', this.itemToEdit.code);
                    formData.append('required_number', this.itemToEdit.required_number);
                    formData.append('start', this.itemToEdit.start);
                    formData.append('end', this.itemToEdit.end);
                    formData.append('updated_by', this.$store.state.application.user.id);


                    this.$http.post(this.$store.state.application.config.api + 'coupons/edit', formData).then(response => {
                        vm.$f7.dialog.close();
                        vm.$f7.dialog.alert("Datos enviados", "Éxito");
                        vm.itemToEdit = {
                            id: '',
                            branch_id: '',
                            name: '',
                            description: '',
                            code: '',
                            required_number: '',
                            start: '',
                            end: ''
                        }
                        vm.popupEditOpened = false;
                        vm.$f7.dialog.close();

                        vm.getList();
                    }, response => {
                        console.log(response, 'error on sendForm coupons/edit');
                        vm.$f7.dialog.close();
                        vm.$f7.dialog.alert("Servidor no disponible", 'Intente más tarde');
                    });

                } else {
                    this.$f7.dialog.alert("Todos los campos son requeridos.");
                }
            },
            getDateSQLFormat(e) {
                let d = new Date(e);
                let month = '' + (d.getMonth() + 1);
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
                this.itemToEdit.start = this.getDateSQLFormat(e);
            },
            setCalendarEndDate: function (e) {
                this.itemToEdit.end = this.getDateSQLFormat(e);
            },
            editItem(item) {
                //this.itemToEdit = item;
                this.itemToEdit.id = item.id;
                this.itemToEdit.branch_id = item.branch_id;
                this.itemToEdit.name = item.name;
                this.itemToEdit.description = item.description;
                this.itemToEdit.code = item.code;
                this.itemToEdit.required_number = item.required_number;
                this.itemToEdit.start = item.start;
                this.itemToEdit.end = item.end;

                let dateStart = this.itemToEdit.start.split("-");
                this.setVarStartDate = [new Date(
                    dateStart[0], (dateStart[1] - 1), dateStart[2]
                )];
                let dateEnd = this.itemToEdit.end.split("-");
                this.setVarEndDate = [new Date(
                    dateEnd[0], (dateEnd[1] - 1), dateEnd[2]
                )];
                this.popupEditOpened = true;
            },
            deleteItem(id) {
                let vm = this;

                vm.$f7.dialog.preloader('Enviando datos...');
                this.$http.post(this.$store.state.application.config.api + 'coupons/delete', {
                    id: id
                }).then(response => {
                    vm.$f7.dialog.close();
                    if (response.data.success) {
                        vm.$f7.dialog.alert("Elemento Eliminado", 'Éxito');
                    } else {
                        vm.$f7.dialog.alert("Error desconocido", 'Intente más tarde');
                    }
                    vm.$f7.dialog.close();

                    this.getList();

                    //this.items = response.data
                }, response => {
                    console.log(response, 'error on checkForm coupons/delete');
                    this.$f7.dialog.close();
                    this.$f7.dialog.alert("Servidor no disponible", 'Intente más tarde');
                });
            },
            getList() {
                let vm = this
                vm.$f7.dialog.preloader('Obteniendo datos...');
                this.$http.post(this.$store.state.application.config.api + 'coupons/get').then(response => {
                    vm.$f7.dialog.close();
                    vm.rows = response.data
                }, response => {
                    console.log(response, 'error on getList visits/get');
                    this.$f7.dialog.close();
                    this.$f7.dialog.alert("Servidor no disponible", 'Intente más tarde');
                });
            },
            onChangeFileUpload: function () {
                this.itemToEdit.src = this.$refs.file.files[0];
            }
        }
    }
</script>

<style scoped>

</style>