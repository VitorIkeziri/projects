<template>
    <div class="container">
      <h2>Adicionar Produto</h2>
      <form @submit.prevent="adicionarProduto">
        <input v-model="nome" placeholder="Nome do Produto" required />
        <input v-model.number="preco" type="number" placeholder="Preço" required />
        <input v-model="cor" placeholder="Cor" required />
        <input v-model="modelo" placeholder="Modelo" required />
        
        
        <div class="tamanhos">
          <label v-for="t in tamanhosDisponiveis" :key="t">
            <input type="checkbox" :value="t" v-model="tamanhos" />
            {{ t }}
          </label>
        </div>
              
          <button type="button" class="todos-btn" @click="selecionarTodosTamanhos">
            Todos os Tamanhos
          </button>

          <div class="classes">
            <label v-for="c in classesDisponiveis" :key="c">
              <input type="checkbox" :value="c" v-model="classes" />
              {{ c }}
            </label>
          </div>
          <button type="button" class="todos-btn" @click="selecionarTodasClasses">
            Todas as Classes
          </button>
      
        <!-- Imagem (URL) -->
        <input type="file" @change="handleImageUpload" accept="image/*" required />
  
        <button type="submit">Salvar</button>
        <RouterLink to='/prodedit' class="todos-btn">Voltar</RouterLink>
      </form>
    </div>
  </template>
  
  <script>
  import { ref, reactive, onMounted } from 'vue';
  import { RouterLink, RouterView } from 'vue-router';
  
  export default {
    data() {
      return {
        destino: 'http://localhost:3000/produtos',
        nome: '',
        preco: '',
        cor: '',
        modelo: '',
        imagem: '', // base64 será salvo aqui
        tamanhos: [],
        classes: [],
        tamanhosDisponiveis: Array.from({ length: 19 }, (_, i) => 30 + i),
        classesDisponiveis: ['Casual', 'Promoção', 'Sportes', 'Outlet', 'Outros']
      };
    },
    methods: {
      handleImageUpload(event) {
        const file = event.target.files[0];
        const reader = new FileReader();
  
        reader.onload = (e) => {
          const img = new Image();
          img.onload = () => {
            // Criando o canvas para redimensionar a imagem
            const canvas = document.createElement('canvas');
            const ctx = canvas.getContext('2d');
  
            // Definindo o novo tamanho
            canvas.width = 250;
            canvas.height = 199;
  
            // Desenhando a imagem no canvas com o tamanho desejado
            ctx.drawImage(img, 0, 0, 250, 199);
  
            // Convertendo a imagem redimensionada para base64
            const resizedImage = canvas.toDataURL('image/jpeg'); 
  
            // Salvando a imagem redimensionada
            this.imagem = resizedImage;
          };
  
          img.src = e.target.result;
        };
  
        if (file) {
          reader.readAsDataURL(file);
        }
      },
      async adicionarProduto() {
        const novoProduto = {
          nome: this.nome,
          preco: this.preco,
          cor: this.cor,
          modelo: this.modelo,
          imagem: this.imagem,
          tamanhos: this.tamanhos,
          classes: this.classes
        };
  
        try {
          await fetch(this.destino, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(novoProduto)
          });
  
          alert('Produto adicionado com sucesso!');
          this.resetarCampos();
        } catch (error) {
          console.error('Erro ao adicionar produto:', error);
          alert('Erro ao adicionar produto.');
        }
      },
      resetarCampos() {
        this.nome = '';
        this.preco = '';
        this.cor = '';
        this.modelo = '';
        this.imagem = '';
        this.tamanhos = [];
        this.classes = [];
      },
      selecionarTodosTamanhos() {
        this.tamanhos = [...this.tamanhosDisponiveis];
      },
      selecionarTodasClasses() {
        this.classes = [...this.classesDisponiveis];
      }
    }
  };
  </script>
  
  <style scoped>
  .container {
    max-width: 500px;
    margin: auto;
    padding: 20px;
  }
  input, button {
    display: block;
    width: 100%;
    margin: 10px 0;
    padding: 8px;
  }
  .tamanhos, .classes {
    display: flex;
    flex-wrap: wrap;
    gap: 5px;
    margin: 10px 0;
  }
  .tamanhos label {
    display: flex;
    align-items: center;
    gap: 5px;
  }
  .todos-btn {
    margin-top: 10px;
    padding: 10px 10px;
    background-color: #761d09;
    color: white;
    border: none;
    cursor: pointer;
    border-radius: 4px;
  }
  .todos-btn:hover {
    background-color: #e15c48;
  }
  </style>
  