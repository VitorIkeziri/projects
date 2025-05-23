<template>
  <div class="popup">
    <div class="bg-black bg-opacity-60 p-10 rounded-2xl shadow-2xl w-full max-w-md">
      <div class="text-center mb-6">
        <h1>LOGIN</h1>
        <MsgMenu />
      </div>
      <form @submit.prevent="handleLogin">
        <div class="mb-4">
          <input v-model="email" type="email" placeholder="Email" />
        </div>
        <div class="mb-6">
          <input v-model="senha" type="password" placeholder="Senha" />
        </div>
        <button class="btn-menu" type="submit">Entrar</button>
        <button class="btn-menu" type="button" @click="recarregarPagina">Voltar</button>
      </form>
      <div v-if="mensagemErro" class="text-red-500 mt-4 text-center">
        {{ mensagemErro }}
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import MsgMenu from '../components/mensagememp.vue'

const email = ref('')
const senha = ref('')
const mensagemErro = ref('')
const router = useRouter()

function recarregarPagina() {
  window.location.reload()
}

async function handleLogin() {
  mensagemErro.value = '' // Limpa mensagem

  try {
    const response = await fetch('http://localhost:3000/login', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({
        email: email.value.trim(),
        senha: senha.value.trim()
      })
    });

    const data = await response.json();

    if (response.ok) {
      mensagemErro.value = 'Logado com sucesso.'
      sessionStorage.setItem('usuarioLogado', JSON.stringify(data));
      window.location.href = '/';
    } else {
      mensagemErro.value = data.mensagem || 'Erro: usuário ou senha inválidos.'
    }
  } catch (error) {
    console.error('Erro:', error);
    mensagemErro.value = 'Erro de conexão com o servidor.'
  }
}
</script>
