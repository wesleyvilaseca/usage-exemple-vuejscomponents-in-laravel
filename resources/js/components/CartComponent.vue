<template>
  <div>
    <li class="nav-item">
      <a data-scroll-nav="0" href="/checkout">
        <i class="fas fa-shopping-cart"></i> <b>{{ cartItens }}</b>
      </a>
    </li>
  </div>
</template>

<script>
export default {
  props: {},
  data() {
    return {
      cartItens: "",
    };
  },
  methods: {
    async getCartItensOnPageLoad() {
      let { data } = await axios.get("/cart");
      this.cartItens = data.cartItens;
    },
  },
  mounted() {
    this.$root.$on("changeInCart", (item) => {
      this.cartItens = item;
    });
  },
  created() {
    this.getCartItensOnPageLoad();
  },
};
</script>