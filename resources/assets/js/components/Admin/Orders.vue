<template>
    <div>
        <table class="table table-responsive table-striped">
            <thead>
            <tr>
                <td></td>
                <td>Product</td>
                <td>Quantity</td>
                <td>Cost</td>
                <td>Delivery Address</td>
                <td>is Delivered?</td>
                <td>Action</td>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(order,index) in orders" @key="index">
                <td>{{index+1}}</td>
                <td v-html="order.product.name"></td>
                <td>{{order.quantity}}</td>
                <td>{{order.quantity * order.product.price}}</td>
                <td>{{order.address}}</td>
                <td>{{order.isDelivered == 1? "Yes" : "No"}}</td>
                <td v-if="order.isDelivered == 0"><button class="btn btn-success" @click="deliver(index)">Deliver</button></td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                orders : []
            }
        },
        // In beforeMount we fetch all the orders placed before the component is rendered.
        beforeMount(){
            axios.get('/api/orders/').then(response => this.orders = response.data)
        },
        methods: {
            deliver(index) {
                let order = this.orders[index]
                axios.patch(`/api/orders/${order.id}/deliver`).then(response => {
                    this.orders[index].isDelivered = 1
                    // When the Deliver button is clicked, the deliver method is fired.
                    // We call the API for delivering orders. To get the change to reflect on the page instantly,
                    // we call [$forceUpdate](https://vuejs.org/v2/api/#vm-forceUpdate).
                    this.$forceUpdate()
                })
            }
        }
    }
</script>
