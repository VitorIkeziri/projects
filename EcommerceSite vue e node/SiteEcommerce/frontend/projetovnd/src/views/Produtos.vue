<script setup lang="ts">
import { ref, onMounted } from 'vue'

const produtos = ref<any[]>([])

const detalhesAbertos = ref<number | null>(null)

const carregarProdutos = async () => {
  try {
    const response = await fetch('http://localhost:3000/produtos')
    const data = await response.json()
    produtos.value = data
  } catch (error) {
    console.error('Erro ao carregar os produtos:', error)
  }
}

const toggleDetalhes = (id: number) => {
  detalhesAbertos.value = detalhesAbertos.value === id ? null : id
}

onMounted(() => {
  carregarProdutos()
})


function agruparTamanhos(tamanhos) {
  tamanhos.sort((a, b) => a - b); 
  const tamanhosAgrupados = [];
  let grupo = [tamanhos[0]];

  for (let i = 1; i < tamanhos.length; i++) {
    if (tamanhos[i] === tamanhos[i - 1] + 1) {
      grupo.push(tamanhos[i]); 
    } else {
      if (grupo.length > 1) {
        tamanhosAgrupados.push(`${grupo[0]}-${grupo[grupo.length - 1]}`);
      } else {
        tamanhosAgrupados.push(grupo[0]);
      }
      grupo = [tamanhos[i]];
    }
  }

  if (grupo.length > 1) {
    tamanhosAgrupados.push(`${grupo[0]}-${grupo[grupo.length - 1]}`);
  } else {
    tamanhosAgrupados.push(grupo[0]);
  }

  return tamanhosAgrupados.join(', ');
}
</script>

<template>
  <div class="product-container max-w-7xl mx-auto flex flex-wrap gap-6 justify-center">
    <div
      v-for="produto in produtos"
      :key="produto.id"
      class="bg-white rounded-xl shadow-md p-4 w-64 hover:shadow-lg transition duration-300"
    >
     
      <img :src="produto.imagem" alt="Imagem do Produto" class="w-full h-40 object-cover rounded mb-2" />
      <h2 class="text-lg font-semibold text-gray-700">{{ produto.nome }}</h2>
      <p class="text-blue-600 font-bold">R${{ produto.preco }}</p>
      <button
        class="mt-2 text-sm text-gray-600 underline hover:text-blue-600"
        @click="toggleDetalhes(produto.id)"
      >
        {{ detalhesAbertos === produto.id ? 'Menos -' : 'Mais +' }}
      </button>

      <div v-if="detalhesAbertos === produto.id" class="mt-2 text-sm text-gray-600 space-y-1">
        <p><strong>Cor:</strong> {{ produto.cor }}</p>
        <p><strong>Modelo:</strong> {{ produto.modelo }}</p>
        <p><strong>Tamanhos:</strong> {{ agruparTamanhos(produto.tamanhos) }}</p>
      </div>
    </div>
  </div>
</template>

<style lang="css">
h2{
  font-family: 'Roboto', sans-serif;
}
p{
  font-family: 'Roboto', sans-serif;
}
</style>
