<script setup>
import { ref, onMounted, computed } from 'vue'

const produtos = ref([])
const selecionados = ref([])
const searchTerm = ref('')
const pesquisaAtiva = ref('')

// Buscar do backend
const buscarProdutos = async () => {
  try {
    const res = await fetch('http://localhost:3000/produtos')
    produtos.value = await res.json()
  } catch (err) {
    console.error('Erro ao carregar produtos:', err)
  }
}

// Remover
const removerSelecionados = async () => {
  try {
    const restantes = produtos.value.filter(p => !selecionados.value.includes(p.id))
    for (const id of selecionados.value) {
      await fetch(`http://localhost:3000/produtos/${id}`, {
        method: 'DELETE'
      })
    }
    produtos.value = restantes
    selecionados.value = []
  } catch (err) {
    console.error('Erro ao remover:', err)
  }
}

// Aplicar filtro
const aplicarBusca = () => {
  pesquisaAtiva.value = searchTerm.value.trim().toLowerCase()
}

// Filtrar produtos por busca
const produtosFiltrados = computed(() => {
  if (!pesquisaAtiva.value) return produtos.value
  return produtos.value.filter(p =>
    `${p.nome} ${p.modelo} ${p.cor}`.toLowerCase().includes(pesquisaAtiva.value)
  )
})

// Ativar Enter para buscar
const onEnter = (e) => {
  if (e.key === 'Enter') aplicarBusca()
}

onMounted(buscarProdutos)
</script>


<template>
    <div class="remover-container">
      <h2>Remover Produtos</h2>
  
      <div class="busca-container">
        <input
          v-model="searchTerm"
          @keyup="onEnter"
          placeholder="Buscar por nome, modelo ou cor..."
          class="campo-busca"
        />
        <button @click="aplicarBusca" class="btn-buscar">Buscar</button>
      </div>
  
      <ul class="lista-produtos">
        <li v-for="produto in produtosFiltrados" :key="produto.id" class="item-produto">
          <label class="item-label">
            <input
              type="checkbox"
              :value="produto.id"
              v-model="selecionados"
              class="checkbox"
            />
            <span class="descricao">
              <strong>{{ produto.nome }}</strong> - {{ produto.modelo }} - {{ produto.cor }}
            </span>
          </label>
        </li>
      </ul>
  
      <button @click="removerSelecionados" class="btn-remover">
        Remover Selecionados
      </button>

      <RouterLink to='/prodedit' class="todos-btn">Voltar</RouterLink>
    </div>
  </template>
  
  
  

<style scoped>
.remover-container {
  max-width: 600px;
  margin: 30px auto;
  padding: 20px;
  font-family: 'Poppins', sans-serif;
  background: #2f2f2f;
  border-radius: 12px;
  box-shadow: 0 2px 8px rgba(0,0,0,0.1);
  color: white;
}

.busca-container {
  display: flex;
  gap: 10px;
  margin-bottom: 20px;
}

.campo-busca {
  flex: 1;
  padding: 10px;
  border-radius: 8px;
  border: 1px solid #ccc;
  font-size: 15px;
}

.btn-buscar {
  background: #2FC3D3;
  border: none;
  color: black;
  padding: 10px 15px;
  border-radius: 8px;
  cursor: pointer;
  font-weight: bold;
}

.lista-produtos {
  list-style: none;
  padding: 0;
  margin-bottom: 20px;
}

.item-produto {
  background: #000000;
  padding: 12px;
  margin-bottom: 8px;
  border: 1px solid #ddd;
  border-radius: 8px;
}

.item-label {
  display: flex;
  align-items: center;
  gap: 10px;
}

.checkbox {
  height: 30px;
  width:30px;
  accent-color: #2FC3D3;
}

.descricao {
  flex: 1;
}

.btn-remover {
  background: #e53935;
  color: white;
  padding: 10px 18px;
  border: none;
  border-radius: 8px;
  cursor: pointer;
  font-weight: bold;
  transition: background 0.3s;
}

.btn-remover:hover {
  background: #c62828;
}
</style>
