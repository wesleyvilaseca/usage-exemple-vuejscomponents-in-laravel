<template>
  <div>
    <hr />
    <button
      class="btn btn-sm btn-block btn-warning"
      @click="addProductToCart()"
    >
      Add To Cart
    </button>
  </div>
</template>

<script>
export default {
  props: {
    productid: Number,
    userid: Number,
  },
  data() {
    return {};
  },
  methods: {
    async addProductToCart() {
      if (this.userid == 0) {
        return this.$toastr.e("You need to login, to add this product in cart");
      }

      let { data } = await axios.post("/cart", {
        product_id: this.productid,
      });

      return this.$toastr.s(data.message);

    },
  },
  mounted() {
    console.log("Component mounted.");
  },
};
</script>
