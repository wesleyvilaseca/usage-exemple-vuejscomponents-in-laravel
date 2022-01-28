<template>
  <div class="container">
    <div class="pt-150">
      <div class="text-center mb-2">
        <h5>Produtos no seu carrinho</h5>
      </div>
      <table class="table">
        <thead>
          <tr>
            <th>Produto</th>
            <th>Valor</th>
            <th>Quantidade</th>
            <th>Valor total</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(item, index) in cartItens" :key="index">
            <td>{{ item.name }}</td>
            <td>R$ {{ item.sale_price }}</td>
            <td>{{ item.quantity }}</td>
            <td>R$ {{ item.quantity * item.sale_price }}</td>
          </tr>
          <tr>
            <th scope="row">total</th>
            <td colspan="2"></td>
            <td>R$ {{total}}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script>
export default {
  props: {},
  data() {
    return {
      cartItens: "",
      total: "",
    };
  },
  methods: {
    async getCartItens() {
      let { data } = await axios.get("/cartitens");
      this.cartItens = data.cartItens;
      this.getValorTotal()
    },

    getValorTotal() {
      for (let item of this.cartItens) {
        this.total += item.quantity * item.sale_price;
      }
      this.total = this.total.toLocaleString('pt-br',{style: 'currency', currency: 'BRL'});
    },
  },
  mounted() {
    this.getCartItens();
  },
};
</script>
