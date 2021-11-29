<template>
	<div class="input-group col-5">
        <div class="input-group-prepend ">
        	<span class="input-group-text" id="basic-addon1"><i class="fas fa-search"></i></span>
        </div>
		<input type="email" v-model="value" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Buscar N° Pedido"  @input="filterResults(value)">
	</div>
</template>
<script>
	export default {
		data(){
            return{
            	value: null
            }
        },
		methods: {
			filterResults(value){
				EventBus.$emit('message', value);
			}
		}
	}
</script>