<template>
    <div class="container">
      <h2>Casuais</h2>
      
      <input v-model="searchTerm" placeholder="Buscar produto..." class="search-bar"/>
  
      <div v-if="produtosFiltrados.length" class="produtos-list">
        <div 
          v-for="produto in produtosFiltrados" 
          :key="produto.nome" 
          class="produto-card"
        >
          <img :src="produto.imagem" alt="Imagem do Produto" class="produto-imagem"/>
          <h3>{{ produto.nome }}</h3>
          <p>Preço: R$ {{ produto.preco }}</p>
          <p>Modelo: {{ produto.modelo }}</p>
          <p>Cor: {{ produto.cor }}</p>
          <p>Tamanhos: {{ produto.tamanhos.join(', ') }}</p>
          <p>Modalidae: {{ produto.classes.join(', ') }}</p>
        </div>
      </div>
  
      <!-- Mensagem se não houver produtos -->
      <div v-else>
        <p>Nenhum produto casual encontrado.</p>
      </div>
      <RouterLink to='/produto' class="todos-btn">Voltar</RouterLink>
    </div>
  </template>
  
  <script>
  import { ref, onMounted } from 'vue';
  
  export default {
    data() {
      return {
        destino: 'http://localhost:3000/produtos',
        produtos: [],
        searchTerm: '',
      };
    },
    computed: {
      produtosFiltrados() {
        // Filtra os produtos da classe 'Casual' e busca pelo termo digitado
        return this.produtos
          .filter(produto => produto.classes.includes('Casual'))
          .filter(produto => 
            produto.nome.toLowerCase().includes(this.searchTerm.toLowerCase())
          );
      }
    },
    methods: {
      async carregarProdutos() {
        try {
          const response = await fetch(this.destino);
          const data = await response.json();
          this.produtos = data;
        } catch (error) {
          console.error('Erro ao carregar produtos:', error);
        }
      }
    },
    mounted() {
      this.carregarProdutos();
    }
  };
  </script>
  
  <style>
  .container {
    max-width: 600px;
    margin: auto;
    text-align: center;
  }
  
  .search-bar {
    width: 100%;
    padding: 8px;
    margin: 10px 0;
    border: 1px solid #ccc;
    border-radius: 5px;
    color: white;
  }
  
  .produtos-list {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 15px;
  }
  
  .produto-card {
    border: 1px solid #ccc;
    border-radius: 5px;
    padding: 10px;
    background-color: #f9f9f9;
  }
  
  .produto-imagem {
    width: 100%;
    height: auto;
  }
  p{
    font-size: 18px;
    font-family:'Roboto', sans-serif;
    font-weight:bolder;
  }
  </style>
  