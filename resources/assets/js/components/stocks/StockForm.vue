<template>
    <div class="container">
        <navbar></navbar>
        <div class="card">
            <div class="card-header">
                <span class="card-title">Stock Detail</span>
                <div>
                     <router-link :to="`/seller/stocks/`" class="btn btn-secondary">
                            Cancel
                    </router-link>
                    <button class="btn btn-primary" @click="onSave">Save</button>
                </div>
            </div>
           <div class="card-body">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">Product</th>
                            <th scope="col">Price</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Amout</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(item, index) in stock.items">
                            <td>{{ item.product_id }}</td>
                            <td>{{ item.price | currency('R ') }}</td>
                            <td>{{ item.quantity }}</td>
                            <td>{{ item.amount | currency('R ') }}</td>
                        </tr>
                    </tbody>
                </table>
           </div>
        </div>

    </div>
</template>
<script type="text/javascript">
import Navbar from '../partials/navbar.vue'
    export default {
        components: {
            Navbar
        },
        methods: {
            onSave() {
                alert(1);
            }
        }
    }
</script>

<style scoped>
.card-header{
    background: #fff;
}
.card-title {
    font-size: 18px;
    line-height: 24px;
}
</style>