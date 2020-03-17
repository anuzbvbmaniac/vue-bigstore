<template>
    <div>
        <div class="container-fluid hero-section d-flex align-content-center justify-content-center flex-wrap ml-auto">
            <h2 class="title">Welcome to the bigStore</h2>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-4 product-box" v-for="(product,index) in products" @key="index">
                            <router-link :to="{ path: '/products/'+product.productId}">
                                <img :src="product.image" :alt="product.name">
                                <!--  We use the v-html attribute to render raw HTML, which makes it easy for us to use special characters in the product name.-->
                                <h5><span v-html="product.name"></span>
                                    <span class="small-text text-muted float-right">$ {{product.price}}</span>
                                </h5>
                                <button class="col-md-4 btn btn-sm btn-primary float-right">Buy Now</button>
                            </router-link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        // data holds all the variables we can use in our template.
        data() {
            return {
                products : []
            }
        },
        // mounted is called after the component is loaded.
        // We load our products from the API then set the products variable so that our template will have naya/updated Data.
        mounted() {
            axios.get('api/products/')
                .then(response => this.products = response.data)
                .catch(error => console.log(error));
        }
    }
</script>

<!--  Scoped rakhyo bhaney these styles will be used only within this component -->
<style scoped>
    .small-text {
        font-size: 14px;
    }
    .product-box {
        border: 1px solid #cccccc;
        padding: 10px 15px;
    }
    .hero-section {
        height: 30vh;
        background: #ababab;
        align-items: center;
        margin-bottom: 20px;
        margin-top: -20px;
    }
    .title {
        font-size: 60px;
        color: #ffffff;
    }
</style>
