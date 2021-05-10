<template>
    <div>
        <loading 
        :active.sync="isLoading" 
        :can-cancel="false" 
        :on-cancel="onCancel"
        :is-full-page="fullPage"></loading>

        <div class="header bg-gradient-primary pt-5 pt-md-6">
            <div class="container-fluid">

                <!-- Header -->
                <div class="header  pb-6">
                <div class="container-fluid">
                    <div class="header-body">
                    <div class="row align-items-center py-4">
                        <div class="col-lg-6 col-7">
                        <h6 class="h2 text-white d-inline-block mb-0">Condominios</h6>
                        <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                            <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                            <li class="breadcrumb-item"><a :href="ruta_home"><i class="fas fa-home"></i></a></li>
                            <li class="breadcrumb-item"><a :href="ruta_home">Inicio</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Condominios</li>
                            </ol>
                        </nav>
                        </div>
                        <div class="col-lg-6 col-5 text-right">
                        <button type="button" class="btn btn-sm btn-neutral" @click="nuevoCondominio();" id="NuevoCondominio">Nuevo</button>
                        <button type="button" class="btn btn-sm btn-neutral" @click="listarCondominios();">Recargar</button>
                        </div>
                    </div>
                    </div>
                </div>
                </div>

            </div>
            </div>

            <!-- Page content -->
            <div class="container-fluid mt--6">
            <div class="row">
                <div class="col">
                <div class="card">
                    <!-- Card header -->
                    <div class="card-header border-0">
                        
                        <div class="form-group">
                            <div class="input-group mb-4">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="ni ni-zoom-split-in"></i></span>
                            </div>
                            <input v-model="filter" class="form-control" placeholder="Buscar Nombre - Calle" type="text">
                            </div>
                        </div>
                    </div>
                    
                    <!-- Light table -->
                    <div class="table-responsive">
                        <table class="table align-items-center table-flush">
                        <thead class="thead-light">
                            <tr>
                            <th scope="col" class="sort" data-sort="name">Nombre</th>
                            <th scope="col" class="sort" data-sort="budget">m2</th>
                            <th scope="col" class="sort" data-sort="status">Costo X m2</th>
                            <th scope="col" class="sort" data-sort="status">Costo Mensual</th>
                            <th scope="col">Dirección</th>
                            <th scope="col"></th>
                            </tr>
                        </thead>
                        <paginate name="cond" :per="10" :list="filteredRows" tag="tbody" class="list">
                            <tr v-for="condominio in paginated('cond')" :key="condominio.id">
                                <th scope="row">
                                    <div class="media align-items-center">
                                    <div class="media-body">
                                        <span class="name mb-0 text-sm" v-html="highlightMatches(condominio.nombre)"></span>
                                    </div>
                                    </div>
                                </th>
                                <td class="budget">
                                    {{ condominio.m2 | number('0,0.00') }}
                                </td>
                                <td>
                                    <span class="status"> {{ condominio.costo_m2 | currency }}</span>
                                </td>
                                <td>
                                    <span class="status"> {{ condominio.m2 * condominio.costo_m2 | currency }}</span>
                                </td>
                                <td>
                                    <div class="media align-items-center">
                                    <div class="media-body">
                                        <span class="name mb-0 text-sm" v-html="highlightMatches(condominio.calle) + ' ' + condominio.numero"></span>
                                    </div>
                                    </div>
                                </td>
                                <td class="text-right">
                                    <div class="dropdown">
                                    <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                        <button class="dropdown-item" @click="editarCondominio(condominio)" >
                                            <span class="btn-inner--icon"><i class="ni ni-collection"></i></span>
                                            <span class="btn-inner--text">Editar</span>
                                        </button>
                                        <button class="dropdown-item" @click="modalEliminar(condominio)">
                                            <span class="btn-inner--icon"><i class="ni ni-fat-remove"></i></span>
                                            <span class="btn-inner--text">Eliminar</span>
                                        </button>
                                    </div>
                                    </div>
                                </td>
                            </tr>
                        </paginate>
                      
                        </table>
                    </div>
                    

                    <!-- Card footer -->
                    <div class="card-footer py-4">
                        <nav aria-label="...">
                            <paginate-links ref="paginator" @change="onLangsPageChange" :async="true" :show-step-links="true" for="cond" :classes="{'ul': ['pagination','justify-content-end','mb-0'], 'li': 'page-item', 'a': 'page-link'}"></paginate-links>
                        </nav>
                    </div>


                </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <form>
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="h4 modal-title" id="exampleModalLabel">Condominio</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">Cliente</label>
                                <select v-model="newCondominio.id_cliente" class="form-control" id="exampleFormControlSelect1">
                                    <option v-for="cliente in clientes" v-bind:key="cliente.CIDCLIENTEPROVEEDOR" v-bind:value="cliente.CIDCLIENTEPROVEEDOR">
                                        {{ cliente.CRAZONSOCIAL }}
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nombre Condominio</label>
                                <input type="text" v-model="newCondominio.nombre" placeholder="Nombre del Condominio"  class="form-control" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Metros Cuadrados</label>
                                <input type="number" v-model.number="newCondominio.m2" class="form-control" placeholder="Metros Cuadrados">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Costo Mensual X M2</label>
                                <input type="number" v-model.number="newCondominio.costo_m2"  placeholder="Costo X M2" class="form-control" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Calle</label>
                                <input type="text" v-model="newCondominio.calle"  class="form-control" placeholder="Calle">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>No.</label>
                                <input type="text" v-model="newCondominio.numero" placeholder="Numero" class="form-control" />
                            </div>
                        </div>
                    </div>                        
                    <div class="alert alert-danger" role="alert" v-if="hayError">
                        <strong>Ocurrio un Error!</strong> {{detalleError}}
                    </div>  
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="cerrarModal" data-dismiss="modal">Cerrar</button>
                    <button type="button" @click="guardar" class="btn btn-primary">Guardar</button>
                </div>
                </div>
            </div>
        </form>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="modal-notification" tabindex="-1" role="dialog" aria-labelledby="modal-notification" aria-hidden="true">
            <div class="modal-dialog modal-danger modal-dialog-centered modal-" role="document">
                <div class="modal-content bg-gradient-danger">
                    
                    <div class="modal-header">
                        <h6 class="h4 modal-title" id="modal-title-notification">Su atención es requerida!!</h6>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    
                    <div class="modal-body">
                        
                        <div class="py-3 text-center">
                            <i class="ni ni-bell-55 ni-3x"></i>
                            <h4 class="heading mt-4">¿ Esta seguro de querer eliminar el condominio</h4>
                            <p>{{ delCondominio.nombre }} ?</p>
                        </div>
                        
                    </div>
                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-white" @click="eliminarCondominio">
                            <span class="btn-inner--icon"><i class="ni ni-fat-remove"></i></span>
                            <span class="btn-inner--text">Eliminar</span>
                        </button>
                        <button type="button" class="btn btn-link text-white ml-auto" data-dismiss="modal">Cerrar</button> 
                    </div>
                    
                </div>
            </div>
        </div>

    </div>
</template>

<script>
    // Import components
    import Loading from 'vue-loading-overlay';
    import 'vue-loading-overlay/dist/vue-loading.css';
    import Vue2Filters from 'vue2-filters';
    import VuePaginate from 'vue-paginate';
    import Swal from 'sweetalert2';
    import 'sweetalert2/dist/sweetalert2.min.css';

    export default {
        created(){
            console.log('Component created.')
            this.listarCondominios();
        },
        mounted() {
            console.log('Component mounted.')
        },
        computed: {
            filteredRows(){
                return this.condominios.filter(row => {
                    return row.nombre.toLowerCase().includes(this.filter.toLowerCase()) || 
                            row.calle.toLowerCase().includes(this.filter.toLowerCase())
                });
            }
        },
        data(){
            return {
                condominios:[],
                clientes: [],
                hayError: false,
                detalleError: '',
                newCondominio: {},
                isLoading: true,
                fullPage: true,
                delCondominio:{},
                paginate: ['cond'],
                modals: false,
                filter: '',
            }
        },
        components: {
            Loading,
        },
        props: ['ruta_home','ruta_lista_clientes','ruta_lista_condominios','ruta_guarda_condominio','ruta_elmina_condominio'],
        methods: {
            async listarCondominios(){
                this.isLoading = true; 

                await axios.get(this.ruta_lista_condominios)
                            .then((response) => {
                                this.condominios = response.data;
                                this.isLoading = false;
                            })
                            .catch((error) => {
                                console.log(error); //Logs a string: Error: Request failed with status code 404
                                window.location.href = '/condominios';
                            });
            },
            nuevoCondominio(){
                this.isLoading = true; 
                this.limpiarDatosNuevoCondominio();
                this.listarClientes(); 
            },
            async listarClientes(){
                await axios.get(this.ruta_lista_clientes)
                            .then((response) => {
                                this.clientes = response.data;
                                this.isLoading = false;
                                $('#exampleModal').modal('toggle');
                            })
                            .catch((error) => {
                                console.log(error); //Logs a string: Error: Request failed with status code 404
                                window.location.href = '/condominios';
                            });
            },
            async guardar(){
                await axios.post(this.ruta_guarda_condominio,this.newCondominio)
                            .then((response) => {
                                $('#exampleModal').modal('toggle');
                                this.limpiarDatosNuevoCondominio();
                                this.listarCondominios();                              
                            })
                            .catch((error) => {
                                this.hayError = true;
                                console.error("There was an error!", error.response);
                                if(error.response.data.errors != null){
                                    var llaves = Object.keys(error.response.data.errors);                                    
                                    this.detalleError = error.response.data.errors[llaves[0]][0];
                                }else{
                                    this.detalleError = error.message;
                                }
                            });

            },
            limpiarDatosNuevoCondominio(){
                this.hayError = false;
                this.detalleError = '';
                this.newCondominio = {};
            },
            editarCondominio(condominio){
                this.newCondominio = JSON.parse(JSON.stringify(condominio));
                this.listarClientes();
            },
            modalEliminar(condominio){
                $('#modal-notification').modal('toggle');
                this.delCondominio = condominio;
            },
            async eliminarCondominio(){
                $('#modal-notification').modal('toggle');
                //`api/condominios/eliminar/${this.delCondominio.id}`
                var ok = false;

                await axios.post(this.ruta_elmina_condominio.replace('*condominio*',this.delCondominio.id))
                            .then((response) => {
                                ok = true;
                            })
                            .catch((error) => {
                                //this.errorMessage = error.message;
                                this.hayError = true;
                                this.detalleError = error.message;
                                console.error("There was an error!", error.message);
                                console.error("There was an error!", error.response);
                            });

                if(ok){
                    await this.listarCondominios();
                    Swal.fire('Condominio','Elimado Correctamente!!','success')
                }
            },
            onCancel() {
                console.log('User cancelled the loader.')
            },
            onLangsPageChange (toPage, fromPage) {
                 if (this.$refs.paginator.currentPage == -1){
                     this.$refs.paginator.currentPage = 0;
                 }
            },

            highlightMatches(text) {
                const matchExists = text.toLowerCase().includes(this.filter.toLowerCase());
                if (!matchExists) return text;

                const re = new RegExp(this.filter, 'ig');
                return text.replace(re, matchedText => `<strong class="text-success">${matchedText}</strong>`);
            },
        },
    }
</script>
