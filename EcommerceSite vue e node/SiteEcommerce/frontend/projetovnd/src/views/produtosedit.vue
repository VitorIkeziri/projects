<script>
import { ref, reactive, onMounted } from 'vue'
import { RouterLink, RouterView } from 'vue-router';
</script>
<template>
  <div class="Menubotom">
<RouterLink to='/Procurarprouto' class="nav-btn">Procurar Produto</RouterLink>
<RouterLink to='/Adicionaproduto' class="nav-btn">Adiciona Produto</RouterLink>
<RouterLink to='/Editarproduto' class="nav-btn">Editar Produto</RouterLink>
<RouterLink to='/Removerproduto' class="nav-btn">Remover Produto</RouterLink>
  </div>
</template>