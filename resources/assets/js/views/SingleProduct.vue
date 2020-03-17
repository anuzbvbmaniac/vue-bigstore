<template>
    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <img :src="product.image" :alt="product.name">
                <h3 class="title" v-html="product.name"></h3>
                <p class="text-muted">{{product.description}}</p>
                <h4>
                    <span class="small-text text-muted float-left">$ {{product.price}}</span>
                    <span class="small-text float-right">Available Quantity: {{product.units}}</span>
                </h4>
                <br>
                <hr>
                <router-link :to="{ path: '/checkout?pid='+product.productId }" class="col-md-4 btn btn-sm btn-primary float-right">Buy Now</router-link>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return {
                product : []
            }
        },
        /**
         * beforeMount is called before the component is rendered,
         * so it fetches the necessary data for rendering the component.
         * If we get the data after the component has mounted, we would have errors
         * before the component updates
         */
        beforeMount(){
            let url = `/api/products/${this.$route.params.id}`
            axios.get(url).then(response => this.product = response.data)
        }
    }
</script>

<style scoped>
    .small-text { font-size: 18px; }
    .title { font-size: 36px; }
</style>
