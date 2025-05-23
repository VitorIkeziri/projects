<script setup lang="ts">
import ProdutosGrid from './views/Produtos.vue'
import Menulogin from './views/Menulogin.vue'
import { ref, reactive, onMounted } from 'vue'
import { RouterLink, RouterView } from 'vue-router';

function   recarregar() {
    window.location.reload();
  }

  const usuario = reactive({
  name: '',
  saldo: 0,
  idcargo: 0
})

  // Verifica sessão
  onMounted(() => {
    const dados = sessionStorage.getItem('usuarioLogado')
    if (dados) {
      const parsed = JSON.parse(dados)
      usuario.name = parsed.name 
      usuario.saldo = parsed.saldo
      usuario.idcargo = parsed.idcargo
      console.log('Usuário carregado:', parsed)
    }
  })

  function deslogar() {
    sessionStorage.removeItem('usuarioLogado')
    usuario.name = ''
    usuario.saldo = 0
    usuario.idcargo = 0
    router.push('/login')
  }
</script>

<template>
          <!-- Barra de Navegação -->
          <nav class="Menucentral">
        <!-- Botões Esquerda -->
        <div>
          <RouterLink to='' class="nav-btn" @click.native="recarregar" >Inicio</RouterLink>
          <RouterLink to='/produto' class="nav-btn">PRODUTOS</RouterLink>
          <RouterLink to='/contato' class="nav-btn">CONTATOS</RouterLink>
        </div>

        
        <div class="logo-central">
          <img src="/logo.png" alt="Logo" class="h-16 w-16 rounded-full border-4 border-blue-500 object-cover" />
        </div>

        <!-- Botões Direita -->
        <div>
          <RouterLink to='/cadastro' class="nav-btn">CADASTRO</RouterLink>
          <RouterLink to='/login' class="nav-btn">LOGIN</RouterLink>
          <div class="flex items-center space-x-4">
              <div class="bg-white rounded-xl shadow-md px-4 py-2 text-gray-800 text-sm leading-tight">
                <RouterLink to='' @click="deslogar" class="nav-btnL">LOGOUT</RouterLink>
                <div class="usuariomenu">
                  <i class="fas fa-user-circle icon"></i>
                </div>
              </div>
            </div>
        </div>
      </nav>
      <div v-if="usuario && usuario.name" class="linha">
        <span class="label">Usuário: </span>
        <span class="valor">{{ usuario.name }}</span>
      </div>
      <div v-if="usuario && usuario.saldo !== 0" class="linha">
        <span class="label">Meu saldo: </span>
        <span class="valor">R${{ usuario.saldo.toFixed(2) }}</span>
      </div>
</template>