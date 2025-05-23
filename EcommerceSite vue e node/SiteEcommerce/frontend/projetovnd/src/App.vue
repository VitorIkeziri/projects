<script setup lang="ts">
import ProdutosGrid from './views/Produtos.vue'
import botaomenu from './views/barradebotao.vue'
</script>

<template>
  <div id="app">
    <botaomenu/>
    <main class="mt-10 w-full px-6 ">
      <RouterView/>
      <div class="produtos-container">
        <ProdutosGrid />
      </div>
    </main>
  </div>
</template>
