<template>
    <div class="popup">
      <h1>Cadastre-se</h1>
      <form @submit.prevent="cadastrarUsuario">
        <input v-model="form.name" type="text" placeholder="Nome" required />
        <input v-model="form.email" type="email" placeholder="Email" required />
        <input v-model="form.senha" type="password" placeholder="Senha" required />
        <button class="btn-menu" type="submit">Cadastrar</button>
        <button class="btn-menu" @click="recarregarPagina">Voltar</button>
      </form>
      <p v-if="mensagem">{{ mensagem }}</p>
    </div>
    
  </template>
  
  <script>
  export default {
    data() {
      return {
        form: {
          name: '',
          email: '',
          senha: '',
          idcargo: '1',
          saldo:'0.00'
        },
        mensagem: ''
      };
    },
  methods: {
    async emailExiste(email) {
      try {
        const emailLimpo = email.trim().toLowerCase().replace(/\s+/g, '');
        const url = `http://localhost:3000/cadastro?email=${encodeURIComponent(emailLimpo)}`;
        const response = await fetch(url);
        if (!response.ok) throw new Error('Falha na verificação do e-mail.');

        const data = await response.json();

        console.log("Comparando com e-mails existentes:");
        for (const usuario of data) {
          const emailExistente = (usuario.email || '').trim().toLowerCase().replace(/\s+/g, '');
          console.log(`Digitado: ${emailLimpo} | Existente: ${emailExistente}`);
          if (emailExistente === emailLimpo) {
            return true; // e-mail já cadastrado
          }
        }

        return false; // e-mail não encontrado
      } catch (error) {
        console.error('Erro ao verificar e-mail:', error);
        this.mensagem = 'Erro ao verificar se o e-mail já está cadastrado.';
        return true; // evitar cadastro em caso de erro
      }
    },

    async cadastrarUsuario() {
      const jaExiste = await this.emailExiste(this.form.email);
      if (jaExiste) {
        this.mensagem = 'E-mail já cadastrado.';
        return;
      }

      try {
        const response = await fetch('http://localhost:3000/cadastro', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify(this.form)
        });

        if (response.ok) {
          this.mensagem = 'Usuário cadastrado com sucesso!';
          this.form = { name: '', email: '', senha: '', idcargo: '1', saldo:'' };
        } else {
          this.mensagem = 'Erro ao cadastrar usuário.';
        }
      } catch (error) {
        this.mensagem = 'Não foi possível conectar ao servidor.';
        console.error(error);
      }
    },

    recarregarPagina() {
      window.location.reload();
    }
  }
};
</script>