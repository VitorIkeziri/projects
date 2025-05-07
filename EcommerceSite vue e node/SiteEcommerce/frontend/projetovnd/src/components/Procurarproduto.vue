<template>
    <div class="container">
      <h1>Pesquisa de Produtos</h1>
  
      <div class="search-bar">
        <input v-model="busca" type="text" placeholder="Digite nome, cor ou modelo..." />
        <button @click="pesquisar">Pesquisar</button>
        <RouterLink to='/prodedit' class="butomback">Voltar</RouterLink>
      </div>
  
      <div v-if="resultados.length === 0" class="no-result">
        Nenhum produto encontrado.
      </div>
  
      <div class="produtos">
        <div v-for="produto in resultados" :key="produto.id" class="card">
          <img :src="produto.imagem" alt="Imagem do produto" />
          <div class="info">
            <h2>{{ produto.nome }}</h2>
            <p><strong>Modelo:</strong> {{ produto.modelo }}</p>
            <p><strong>Cor:</strong> {{ produto.cor }}</p>
            <p><strong>Preço:</strong> R$ {{ produto.preco.toFixed(2) }}</p>
            <p><strong>Tamanhos:</strong> {{ produto.tamanhos.join(', ') }}</p>
          </div>
        </div>
      </div>
    </div>
  </template>
  
  <script setup>
  import { ref, onMounted } from 'vue'
  
  const produtos = ref([])
  const busca = ref('')
  const resultados = ref([])
  
  const buscarProdutos = async () => {
    try {
      const res = await fetch('http://localhost:3000/produtos')
      produtos.value = await res.json()
      resultados.value = produtos.value // exibe todos inicialmente
    } catch (err) {
      console.error('Erro ao buscar produtos:', err)
    }
  }
  
  const pesquisar = () => {
    const termo = busca.value.toLowerCase()
    resultados.value = produtos.value.filter(p =>
      p.nome.toLowerCase().includes(termo) ||
      p.cor.toLowerCase().includes(termo) ||
      p.modelo.toLowerCase().includes(termo)
    )
  }
  
  onMounted(buscarProdutos)
  </script>
  
  <style scoped>
  .container {
    max-width: 900px;
    margin: 30px auto;
    padding: 20px;
    font-family: 'Poppins', sans-serif;
    background: #3d3d3d;
    border-radius: 12px;
    border: 1px solid #ccc;
  }
  
  h1 {
    text-align: center;
    margin-bottom: 20px;
  }
  
  .search-bar {
    display: flex;
    gap: 10px;
    margin-bottom: 20px;
  }
  
  .search-bar input {
    flex: 1;
    padding: 10px;
    font-size: 16px;
    border-radius: 8px;
    border: 1px solid #ccc;
  }
  
  .search-bar button {
    padding: 10px 18px;
    background-color: #0e07ed;
    border: none;
    border-radius: 8px;
    color: white;
    font-weight: bold;
    cursor: pointer;
  }

  button:hover{
    background-color: #625ee4;
  }

  .butomback{
    padding: 20px 18px;
    background-color: #d01313;
    border: none;
    border-radius: 8px;
    color: white;
    font-weight: bold;
    cursor: pointer;
  }

  .butomback:hover{
   background-color: #c85e5e;
  }
  
  .produtos {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
    gap: 20px;
  }
  
  .card {
    background: rgb(65, 65, 65);
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
  }
  
  .card img {
    width: 100%;
    height: 180px;
    object-fit: cover;
  }
  
  .info {
    padding: 12px;
  }
  
  .no-result {
    text-align: center;
    color: #ffffff;
    margin-top: 20px;
  }
  </style>
  