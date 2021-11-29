<template>
<div class="container">
    <div class="row justify-content-center">

        <div class="col-lg-8 mx-auto">
            <div v-if="loading">
                <div class="d-flex justify-content-center">
                <img src="/img/tenor.gif">
              </div>
            </div>
            <div v-else class="card border-0 bg-light mb-3 shadow-sm"
                 v-for="(item, index) in entregas"
                 :key="index">
              <div class="card-header d-flex justify-content-between align-items-center"
                   data-toggle="collapse"
                   v-bind:data-target="'#collapse'+item.id">
                <h5>
                  <i class="fas fa-calendar-check text-primary pr-2"></i> Pedido: <b>#{{item.id}}</b>
                </h5>
                <div class="d-flex justify-content-end align-items-center">
                   <i class="fas fa-users text-danger mr-3"  v-if="user.privilegio === 'Administrador' && validarPedidoAsignado(item.id) === true "></i>
                   <i class="fas fa-truck text-success" :hidden="item.status !== 'completed'"></i>
                   <button class="btn btn-link"><i class="fas fa-angle-double-up"></i></button>
                </div>
              </div>
              <div v-bind:id="'collapse'+item.id" class="collapse">
              <div class="card-body">
                <div class="row">
                  <div class="col-md-6 col-sm-8">
                    <div class="d-flex flex-column bd-highlight mb-5">
                      <div class="p-2 bd-highlight">
                        <h5>Envia:</h5>
                      </div>
                      <div class="p-2 bd-highlight"><i class="fas fa-paper-plane text-primary pr-2"></i>  {{item.billing.first_name}} {{item.billing.last_name}}
                      </div>

                      <div class="p-2 bd-highlight">
                        <i class="fas fa-at text-primary pr-2"></i>{{item.billing.email}}
                      </div>

                      <div class="p-2 bd-highlight"><i class="fas fa-map-marked text-primary pr-2"></i> {{item.billing.address_1}}, {{item.billing.city}}
                      </div>
                      <div class="p-2 bd-highlight"><i class="fas fa-phone text-primary pr-2"></i><a v-bind:href="'tel:'+item.billing.phone">{{item.billing.phone}}</a>
                      </div>
                    </div>
                  </div>

                  <div class="col-md-6 col-sm-8">
                    <div class="d-flex flex-column bd-highlight mb-5">
                      <div class="p-2 bd-highlight">
                        <h5>Recibe:</h5>
                      </div>
                      <div class="p-2 bd-highlight"><i class="fas fa-paper-plane text-primary pr-2"></i> {{item.shipping.first_name}} {{item.shipping.last_name}}
                      </div>

                      <div class="p-2 bd-highlight" v-for="meta_data in item.meta_data" v-if="meta_data.key === 'hora-de-entrega'">
                        <i class="far fa-clock text-primary pr-2"></i></i>{{meta_data.value}}
                      </div>

                      <div class="p-2 bd-highlight"><i class="fas fa-map-marked text-primary pr-2"></i>  {{item.shipping.address_1}}, {{item.shipping.state}}
                      </div>
                      <div class="p-2 bd-highlight" v-for="meta_data in item.meta_data" v-if="meta_data.key === 'fecha-de-entrega'">

                        <i class="fas fa-calendar-alt text-primary pr-2"></i>{{meta_data.value}}
                      </div>
                    </div>
                  </div>
                </div>

              </div>
              <div class="card-footer">
                <div class="d-flex justify-content-between align-items-center">
                  <button  class="btn btn-primary" :disabled="item.status === 'completed'" data-target="#modalConfirmar"  data-toggle="modal"  @click="modalEntregarPedido(index, item)" ><i class="fas fa-truck pr-1"></i> Entregado</button>
                  <div class="d-flex justify-content-end align-items-center col-7 col-lg-5"  v-if="user.privilegio === 'Administrador'">
                    <span style="font-size: 1.7em">
                      <i class="fas fa-users text-primary pr-2"></i>
                    </span>


                    <select class="form-control "
                            aria-label="Default select example"
                            @change="asignarUsuario($event,item.id)"
                            :disabled="item.status === 'completed'">

                      <option value="sinAsignar">Sin Asignar</option>
                      <option v-for="(usuario, index) in usuarios"
                              :selected="buscarId(usuario.id, item.id)"
                              :value="usuario.id">
                              {{usuario.name}}
                       </option>

                      </select>
                  </div>

                </div>
              </div>
              </div>
            </div>
        </div>



    </div>
    <div class="modal fade" id="modalConfirmar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Entregar Pedido</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <h3>Entrega del Pedido: {{this.orden.id}}</h3>
            <div class="custom-file" v-if="seleccionarFoto">
              <input class="custom-file-input" type="file" id="file" ref="file" v-on:change="getImage()" accept="image/*">
              <label class="custom-file-label" for="file" accept="image/*" capture="camera">Seleccionar Foto</label>
            </div>
            <div class="alert alert-success" role="alert" v-if="pedidoEntregado">
              Pedido Entregado Correctamente
            </div>
            <div v-if="loadingFoto">
              <div class="d-flex justify-content-center">
                <img src="/img/tenor.gif">
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" id="cerrarEntrega" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            <button type="button" id="entregarPd" class="btn btn-primary" @click="entregarPedido()">Entregar</button>
          </div>
        </div>
      </div>
    </div>
</div>
</template>
<script>
    let user = document.head.querySelector('meta[name="user"]');

    export default {
        data(){
            return{
                value: null,
                entregas: [],
                entregasFiltro :[],
                id: 0,
                orden:[],
                usuarios:[],
                usuarioPedido: [],
                loading: true,
                loadingFoto: false,
                seleccionarFoto:true,
                pedidoEntregado:false,
                imagen : null,
                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        },
        computed:{
          user(){
            return JSON.parse(user.content);
          }
        },
        mounted(){
          EventBus.$on('message', message=>{
            this.entregas = this.entregasFiltro.filter(entrega => String(entrega.id).match(message));
        })
        },
        created(){
            axios.get('/entregas').then(res=> {
                this.entregas = res.data;
                this.entregasFiltro = res.data;
                this.loading = false;
            }).catch(error => {
              console.log(error.response.data);
            }).finally(() => this.loading = false),
            axios.get('/usuarios').then(res=> {
                this.usuarios = res.data;
                console.log(this.usuarios);
            }),
            axios.get('/usuarioPedido').then(res=> {
                this.usuarioPedido = res.data;
                console.log(this.usuarioPedido);
            })

        },
        methods: {
          entregarPedido(){
            document.getElementById("entregarPd").disabled = true;
            document.getElementById("cerrarEntrega").disabled = true;
            this.loadingFoto = true;
            this.seleccionarFoto = false;
             axios.put(`/entregas/${this.orden.id}`)
            .then(res=>{
            //Enviar Email
            var data = new  FormData();
            data.append('foto', this.imagen);
            data.append('email', this.orden.billing.email)
            data.append('id', this.orden.id)
            data.append('nombre', this.orden.billing.first_name)
            axios.post('/enviarEmail',data)
              .then(response => {
                console.log(response.data)
                this.pedidoEntregado = true;
                this.loadingFoto = false;
                document.getElementById("cerrarEntrega").disabled = false;
              })

            //Actualizar Entrega Local
             this.entregas[this.id].status = 'completed';
           })
        },
        getImage(){
          this.imagen = this.$refs.file.files[0];
          var fileName = this.imagen.name;
          $('#file').next('.custom-file-label').html(fileName);
        },
        validarPedidoAsignado(idPedido)
        {
          let pedidoAsignado = false;
          //Validar que el pedido no este asgnado a ningun usuario
          for (let userPedido of this.usuarioPedido) {
            if (userPedido.id_pedido == idPedido) {
              //Asignar
              pedidoAsignado=true;
            }
          }
          return pedidoAsignado;
        }
        ,
        asignarUsuario(event, idPedido){
          let pedidoAsignado = false;
          //Validar que el pedido no este asgnado a ningun usuario
          for (let userPedido of this.usuarioPedido) {
            if (userPedido.id_pedido == idPedido) {
              //Asignar
              pedidoAsignado=true;
            }
          }

          if(pedidoAsignado)
          {
            //Verificar si se elimina o modifica
            if(event.target.value == 'sinAsignar')
            {
              //Eliminar
              axios.delete(`/usuarioPedido/${idPedido}`)
                .then((res) => {
                console.log(res.data);
            });
            }else
            {
              alert('editar');
            }

          }else
          {
            //Agregar
            const parametros = {id_pedido: idPedido, user_id: event.target.value};
            axios.post('/usuarioPedido', parametros).then((res) => {
                this.usuarioPedido.push(res.data);
            }).catch(function (error) {
              if (error.response) {
                // Request made and server responded
                console.log(error.response.data);
                console.log(error.response.status);
                console.log(error.response.headers);
              }})
          }

        },
        modalEntregarPedido(index, item)
        {
          this.orden = item;
          this.id= index;
          this.seleccionarFoto = true;
          this.pedidoEntregado = false;
          this.imagen = null;
          $('#file').next('.custom-file-label').html('Seleccionar Foto');
          document.getElementById("entregarPd").disabled = false;
        },
        buscarId(idUsuario, idPedido)
        {
          let validacion = false;
          for (let userPedido of this.usuarioPedido) {
            if (userPedido.id_pedido == idPedido && userPedido.user_id == idUsuario) {
              validacion = true;
            }
          }
          return validacion;
        }
    }
  }
</script>