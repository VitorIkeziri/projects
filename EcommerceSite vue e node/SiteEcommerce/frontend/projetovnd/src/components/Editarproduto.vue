<script setup>
import { ref, onMounted } from 'vue'
import { RouterLink, RouterView } from 'vue-router'

const produtos = ref([])
const filtro = ref('')
const resultado = ref([])
const produtoSelecionado = ref(null)
const tamanhosDisponiveis = Array.from({ length: 19 }, (_, i) => 30 + i)

const buscarProdutos = async () => {
  try {
    const res = await fetch('http://localhost:3000/produtos')
    const data = await res.json()
    produtos.value = data
    resultado.value = data.filter(p =>
      p.nome?.toLowerCase().includes(filtro.value.toLowerCase()) ||
      p.modelo?.toLowerCase().includes(filtro.value.toLowerCase()) ||
      p.cor?.toLowerCase().includes(filtro.value.toLowerCase()) ||
      p.id?.toString().includes(filtro.value)
    )
  } catch (err) {
    mensagem.value = 'Erro ao buscar produtos:'
  }
}

const selecionarProduto = (produto) => {
  produtoSelecionado.value = {
    ...produto,
    tamanhos: Array.isArray(produto.tamanhos) ? [...produto.tamanhos] : []
  }
}

const salvarAlteracoes = async () => {
  try {
    const resGet = await fetch('http://localhost:3000/produtos')
    const lista = await resGet.json()
    const index = lista.findIndex(p => p.id === produtoSelecionado.value.id)
    const mensagem = ref('')

    if (index !== -1) {
      lista[index] = produtoSelecionado.value
      await fetch('http://localhost:3000/produtos', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(produtoSelecionado.value)
      })
      mensagem.value = 'Produto alterado com sucesso!'
      await buscarProdutos()
      setTimeout(() => {
        window.location.reload()
        }, 3000)
    }
  } catch (err) {
    mensagem.value = 'Erro ao salvar produto:'
  }
}

onMounted(buscarProdutos)
</script>

<template>
  <div class="menucaixa">
    <h1 class="text-2xl font-bold mb-4">Buscar e Editar Produto</h1>

    <input
      v-model="filtro"
      @input="buscarProdutos"
      placeholder="Buscar por nome, modelo, cor ou ID"
      class="border px-4 py-2 w-full mb-4 rounded"
    />

    <div v-if="resultado.length === 0" class="text-gray-500">Nenhum produto encontrado</div>

    <ul class="mb-6">
        <li
            v-for="p in resultado"
            :key="p.id"
            @click="selecionarProduto(p)"
            class="cursor-pointer p-2 border-b hover:bg-gray-100 flex flex-col items-center"
        >
            <!-- Exibição da imagem -->
            <img
            v-if="p.imagem"
            :src="p.imagem"
            alt="Imagem do produto"
            class="w-16 h-16 object-cover mb-2 rounded"
            />

            <!-- Descrição do produto -->
            <div class="text-center">
            <p class="font-bold">{{ p.id }} - {{ p.nome }}</p>
            <p>({{ p.modelo }})</p>
            <p>{{ p.cor }}</p>
            </div>
        </li>
        </ul>

    <div v-if="produtoSelecionado" class="submenucaixa">
        
      <h2 class="text-xl font-semibold mb-2">Editar Produto</h2>

        <img
            v-if="produtoSelecionado.imagem"
            :src="produtoSelecionado.imagem"
            alt="Imagem do Produto"
            class="imagem-produto mb-3"
        /><hr></br>
      
      <label class="block mb-1">Nome:</label>
      <input v-model="produtoSelecionado.nome" class="border px-3 py-1 w-full mb-2 rounded" />

      <label class="block mb-1">Modelo:</label>
      <input v-model="produtoSelecionado.modelo" class="border px-3 py-1 w-full mb-2 rounded" />

      <label class="block mb-1">Cor:</label>
      <input v-model="produtoSelecionado.cor" class="border px-3 py-1 w-full mb-2 rounded" />

      <label class="block mb-1">Preço:</label>
      <input v-model="produtoSelecionado.preco" class="border px-3 py-1 w-full mb-2 rounded" />

      <label class="block mb-1">Tamanhos:</label>
      <div class="flex flex-wrap gap-2 mb-4">
        <label v-for="t in tamanhosDisponiveis" :key="t" class="flex items-center gap-1">
          <input
            type="checkbox"
            :value="t"
            v-model="produtoSelecionado.tamanhos"
            class="form-checkbox"
          />
          {{ t }}
        </label>
        <p v-if="mensagem" class="text-green-600 mt-2">{{ mensagem }}</p>
      </div>
    </div>

    <div class="butom-lado">
      <button @click="salvarAlteracoes" class="todos-btn">Salvar</button>
      <RouterLink to='/prodedit' class="todos-btn">Voltar</RouterLink>
    </div>
  </div>
</template>

<style scoped>
input {
  font-family: 'Roboto', sans-serif;
}

.form-checkbox {
  accent-color: #2FC3D3;
}

.flex {
  display: flex;
}

.flex-wrap {
  flex-wrap: wrap;
}

.gap-2 {
  gap: 0.5rem;
}
</style>
