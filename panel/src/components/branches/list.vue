<template>
    <f7-page name="branchesList">
        <f7-navbar :sliding="true" back-link="Atrás" title="Listado de Sucursales">
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
        <f7-block>
            <f7-card>
                <f7-card-content>
                    <f7-list form style="margin: 15px;max-width: 100%;">
                        <f7-list-input
                                class="kingans-border"
                                label="Buscar por Nombre"
                                placeholder="EJ: Colón"
                                type="text"
                                :value="search"
                                clear-button
                                @input="search = $event.target.value"
                        ></f7-list-input>
                    </f7-list>
                    <f7-list style="margin: 8px;">
                        <f7-list-item>
                            <span><strong>Nombre</strong> / Ciudad</span>
                            <span>Acciones</span>
                        </f7-list-item>
                        <f7-list-item v-for="(item, index) in filteredList" :key="index">
                            <span style="padding-bottom: 7px">
                                <img class="circle-image" style="width: 25px;top:5px;position:relative" :src="$store.state.application.config.api + 'images/branches/' + item.svg" />
                                <strong>{{item.name}}</strong> / {{item.city}}
                            </span>
                            <span>
                                <f7-button @click="editItem(item)" style="float:left">
                                    <f7-icon class="icon-btn" material="edit"></f7-icon>
                                </f7-button>
                                <f7-button @click="deleteItem(item.id)" style="float:left">
                                    <f7-icon class="icon-btn" material="delete"></f7-icon>
                                </f7-button>
                            </span>
                        </f7-list-item>
                    </f7-list>
                </f7-card-content>
            </f7-card>
        </f7-block>
        <f7-popup class="" :opened="popupEditOpened" @popup:closed="popupEditOpened = false">
            <f7-page>
                <f7-navbar :title="'Editar sucursal: ' + itemToEdit.name">
                    <f7-nav-right>
                        <f7-link popup-close>Cancelar</f7-link>
                    </f7-nav-right>
                </f7-navbar>
                <f7-block>
                    <f7-card>
                        <f7-card-content>
                            <f7-list form style="margin: 15px;">
                                <f7-list-input
                                        class="kingans-border"
                                        label="Nombre de la sucursal"
                                        placeholder="EJ: Colón"
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
                                        label="Ciudad"
                                        type="text"
                                        placeholder="EJ: Torreón"
                                        info="Obligatorio"
                                        :value="itemToEdit.city"
                                        validate
                                        required
                                        :error-message="'Campo Obligatorio'"
                                        clear-button
                                        @input="itemToEdit.city = $event.target.value"
                                ></f7-list-input>
                                <f7-list-input
                                        class="kingans-border"
                                        label="Dirección"
                                        placeholder="EJ: C. Falsa, #123."
                                        type="text"
                                        info="Obligatorio"
                                        :value="itemToEdit.address"
                                        clear-button
                                        validate
                                        required
                                        :error-message="'Campo Obligatorio'"
                                        @input="itemToEdit.address = $event.target.value"
                                ></f7-list-input>
                                <f7-list-input
                                        class="kingans-border"
                                        label="Teléfono"
                                        placeholder="EJ: +520011223344"
                                        type="text"
                                        info="Obligatorio"
                                        :value="itemToEdit.phone"
                                        clear-button
                                        validate
                                        required
                                        :error-message="'Campo Obligatorio'"
                                        @input="itemToEdit.phone = $event.target.value"
                                ></f7-list-input>

                              <f7-list-input
                                  class="kingans-border"
                                  label="WhatsApp"
                                  placeholder="EJ: URL/WA.ME/XXXXXX"
                                  type="text"
                                  info="Obligatorio"
                                  :value="items.wa_url"
                                  clear-button
                                  validate
                                  required
                                  :error-message="'Campo Obligatorio'"
                                  @input="items.wa_url = $event.target.value"
                              ></f7-list-input>
                              <f7-list-input
                                  class="kingans-border"
                                  label="Pedido en Línea URL / Sucursal"
                                  placeholder="EJ: wansoft.xxx/xxxx/xxx"
                                  type="text"
                                  info="Obligatorio"
                                  :value="items.menu_url"
                                  clear-button
                                  validate
                                  required
                                  :error-message="'Campo Obligatorio'"
                                  @input="items.menu_url = $event.target.value"
                              ></f7-list-input>
                                <f7-list-input
                                        class="kingans-border"
                                        label="Horarios"
                                        placeholder="EJ: L-V 00:00Hrs - 00:00Hrs / S-D 00:00Hrs - 00:00Hrs"
                                        type="text"
                                        info="Obligatorio"
                                        :value="itemToEdit.scheduling"
                                        clear-button
                                        validate
                                        required
                                        :error-message="'Campo Obligatorio'"
                                        @input="itemToEdit.scheduling = $event.target.value"
                                ></f7-list-input>
                                <f7-list-input
                                        class="kingans-border"
                                        label="Facebook URL"
                                        placeholder="EJ: https://..."
                                        type="text"
                                        info="Obligatorio"
                                        :value="itemToEdit.facebook"
                                        clear-button
                                        validate
                                        required
                                        :error-message="'Campo Obligatorio'"
                                        @input="itemToEdit.facebook = $event.target.value"
                                ></f7-list-input>
                                <f7-list-input
                                        class="kingans-border"
                                        label="Instagram URL"
                                        placeholder="EJ: https://..."
                                        type="text"
                                        info="Obligatorio"
                                        :value="itemToEdit.instagram"
                                        clear-button
                                        validate
                                        required
                                        :error-message="'Campo Obligatorio'"
                                        @input="itemToEdit.instagram = $event.target.value"
                                ></f7-list-input>
                                <f7-list-input
                                        class="kingans-border"
                                        label="GMaps URL"
                                        placeholder="EJ: https://..."
                                        type="text"
                                        info="Obligatorio"
                                        :value="itemToEdit.map"
                                        clear-button
                                        validate
                                        required
                                        :error-message="'Campo Obligatorio'"
                                        @input="itemToEdit.map = $event.target.value"
                                ></f7-list-input>
                                <input type="file" ref="file"
                                       accept="image/*"
                                       required
                                       @change="onChangeFileUpload"/>
                            </f7-list>
                            <f7-button style="margin: 15px"
                                       class="btn-primary"
                                       large @click="sendForm">
                                EDITAR SUCURSAL
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
        name: "branchesList",
        data() {
            return {
                popupEditOpened: false,
                search: '',
                items: [],
                itemToEdit: {
                    id: '',
                    name: '',
                    city: '',
                    address: '',
                    phone: '',
                    scheduling: '',
                    instagram: '',
                    map: '',
                    facebook: '',
                    svg: '',
                    wa_url:'',
                    menu_url:'',
                }
            }
        },
        computed: {
            filteredList() {
                return this.items.filter(item => {
                    return item.name.toLowerCase().includes(this.search.toLowerCase())
                })
            },
        },
        mounted: function () {
            this.getList()
        },
        methods: {
            getList() {
                let vm = this
                vm.$f7.dialog.preloader('Obteniendo datos...');
                this.$http.post(this.$store.state.application.config.api + 'branches/get').then(response => {
                    vm.$f7.dialog.close();
                    vm.items = response.data
                }, response => {
                    console.log(response, 'error on getList branches/get');
                    this.$f7.dialog.close();
                    this.$f7.dialog.alert("Servidor no disponible", 'Intente más tarde');
                });
            },
            editItem(item) {
                this.itemToEdit = item;
                this.popupEditOpened = true;
            },
            deleteItem(id) {
                let vm = this;

                vm.$f7.dialog.preloader('Enviando datos...');
                this.$http.post(this.$store.state.application.config.api + 'branches/delete', {
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
                    console.log(response, 'error on checkForm branches/delete');
                    this.$f7.dialog.close();
                    this.$f7.dialog.alert("Servidor no disponible", 'Intente más tarde');
                });
            },
            checkForm() {
                let vm = this;
                let isValid = true;
                Object.keys(this.itemToEdit).forEach(function (index, item) {
                    if (vm.itemToEdit[index] === "") {
                        isValid = false
                    }
                });
                return isValid;
            },
            sendForm: function () {
                let vm = this
                if (this.checkForm()) {
                    this.$f7.dialog.preloader('Enviando datos...');

                    let formData = new FormData();
                    formData.append('id', this.itemToEdit.id);
                    formData.append('name', this.itemToEdit.name);
                    formData.append('city', this.itemToEdit.city);
                    formData.append('address', this.itemToEdit.address);
                    formData.append('phone', this.itemToEdit.phone);
                    formData.append('scheduling', this.itemToEdit.scheduling);
                    formData.append('map', this.itemToEdit.map);
                    formData.append('facebook', this.itemToEdit.facebook);
                    formData.append('wa_url', this.items.wa_url);
                    formData.append('menu_url', this.items.menu_url);
                    formData.append('instagram', this.itemToEdit.instagram);
                    formData.append('svg', this.itemToEdit.svg);
                    formData.append('updated_by', this.$store.state.application.user.id);

                    this.$http.post(this.$store.state.application.config.api + 'branches/edit', formData).then(response => {
                        vm.$f7.dialog.close();
                        vm.$f7.dialog.alert("Datos enviados", "Éxito");
                        vm.itemToEdit = {
                            name: '', city: '', address: '',
                            phone: '', scheduling: '', instagram: '',
                            map: '', facebook: '',  svg: '', wa_url: '', menu_url: '',
                        }
                        vm.popupEditOpened = false;
                        vm.$f7.dialog.close();

                        vm.getList();
                    }, response => {
                        console.log(response, 'error on checkForm branches/add');
                        vm.$f7.dialog.close();
                        vm.$f7.dialog.alert("Servidor no disponible", 'Intente más tarde');
                    });

                } else {
                    this.$f7.dialog.alert("Todos los campos son requeridos.");
                }
            },
            onChangeFileUpload: function () {
                this.itemToEdit.svg = this.$refs.file.files[0];
            }
        },
    }
</script>

<style scoped>

</style>
