<template>
    <div>
        <h2>Agregar comida</h2>
        <form @submit.prevent="saveData" enctype="multipart/form-data">
            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group row">
                        <div class="col-lg-4">
                           Código de comida
                        </div>
                        <div class="col-lg-8">
                            <input type="text" v-model="code" class="form-control">
                                <span v-if="allerros.code" class="text-sm text-red-600">{{ allerros.code[0] }}</span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-4">
                               Nombre dde la comida
                            </div>
                            <div class="col-lg-8">
                                <input type="text" v-model="name" class="form-control">
                                    <span v-if="allerros.name" class="text-sm text-red-600">{{ allerros.name[0] }}</span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-lg-4">
                                    Categoria de la comida
                                </div>
                                <div class="col-lg-8">
                                    <select class='form-control' v-model='category_id'>
                                        <option value=''>Seleccionar categoria</option>
                                        <option v-for='item in categories' :value='item.category_id'>{{ item.category }}</option>
                                    </select>
                                    <span v-if="allerros.category_id" class="text-sm text-red-600">{{ allerros.category_id[0] }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group row">
                                <div class="col-lg-4">
                                    Descripción
                                </div>
                                <div class="col-lg-8 ">
                                    <input type="text" v-model="descripcion" class="form-control">
                                        <span v-if="allerros.descripcion" class="text-sm text-red-600">{{ allerros.descripcion[0] }}</span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-lg-4">
                                       cubrir
                                    </div>
                                    <div class="col-lg-8">
                                        <input type="file" v-on:change="onFileChange" class="form-control">
                                            <span v-if="allerros.imagen" class="text-sm text-red-600">{{ allerros.imagen[0] }}</span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <router-link :to="{name: 'product'}" class="btn btn-default">Cancelado</router-link>
                                        <button type="submit" class="btn btn-primary">SAVE</button>
                                    </div>
                                </div>
                            </div>
                        </form>

                    </div>
                </template>
                <script>
                    export default {
                        data() {
                            return {
                                categories: {},
                                errors: [],
                                allerros: [],
                                success: false,
                                message: '',
                                codigo: '',
                                nombre: '',
                                descripcion: '',
                                category_id: '',
                                imagen: '',
                                precio: ''
                            }
                        },
                        created() {
                            this
                                .axios
                                .get('/api/product/create')
                                .then(response => {
                                    //this.msg = response.data.message;
                                    this.categories = response.data.categories;

                                });
                            if (this.$route.params.id) {
                                this
                                    .axios
                                    .get('/api/product/'+this.$route.params.id+'/edit')
                                    .then((response) => {
                                        this.codigo = response.data.codigo;
                                        this.nombre = response.data.nombre;
                                        this.descripcion = response.data.descripcion;
                                        this.category_id = response.data.category_id;
                                        this.imagen = response.data.imagen;
                                          this.precio = response.data.precio;
                                    });
                            }
                        },
                        methods: {
                            onFileChange(e) {
                                this.cover = e
                                    .target
                                    .files[0];
                            },
                            saveData(e) {
                                e.preventDefault();
                                let formData = new FormData();
                                formData.append('codigo', this.codigo);
                                formData.append('nombre', this.nombre);
                                formData.append('descripcion', this.descripcion);
                                formData.append('category_id', this.category_id);
                                formData.append('imagen', this.imagen);
                                formData.append('precio', this.precio);
                                // this.axios     .post('/api/patient', this.patient)     .then(response => (
                                // this.$router.push({ name: 'patient' })     ))
                                //update
                                if (this.$route.params.id) {
                                    //utilizando el método post debido a un error en el método put
                                    //mejor usar el metodo put/pacth
                                    this
                                        .axios
                                        .post('/api/product/'+this.$route.params.id, formData, {
                                            headers: {
                                                'content-type': 'multipart/form-data'
                                            }
                                        })
                                        .then(response => {
                                            this
                                                .$swal
                                                .fire(
                                                    {title: 'Success!', text: response.data.message, icon: 'success', timer: 1000}
                                                );
                                            this
                                                .$router
                                                .push({name: 'product'});
                                        })
                                        .catch((error) => {
                                            console.log(error);
                                            this.allerros = error.response.data.errors;
                                            this.success = false;
                                        })
                                        . finally(() => this.loading = false)
                                } else {
                                    this
                                        .axios
                                        .post('/api/product', formData, {
                                            headers: {
                                                'content-type': 'multipart/form-data'
                                            }
                                        })
                                        .then(response => {
                                            this
                                                .$swal
                                                .fire(
                                                    {title: 'Success!', text: response.data.message, icon: 'success', timer: 1000}
                                                );
                                            this
                                                .$router
                                                .push({name: 'product'});
                                        })
                                        .catch((error) => {
                                            console.log(error);
                                            this.allerros = error.response.data.errors;
                                            this.success = false;
                                        })
                                        . finally(() => this.loading = false)
                                }
                            }
                        }
                    }
                </script>
