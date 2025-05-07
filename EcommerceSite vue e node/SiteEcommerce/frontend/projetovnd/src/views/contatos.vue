<script setup>
import { onMounted } from 'vue';

onMounted(() => {
  console.log("Página de contato carregada.");
});
</script>

<template>
  <div class="container123">
    <h2 class="aha2">Contato</h2>
    <p class="pe">
      Agradecemos por visitar nossa plataforma! Sua opinião é muito importante para nós.  
      Caso tenha dúvidas, sugestões ou queira compartilhar sua experiência, 
      estamos à disposição para ouvir você.
    </p>
    <p class="pe">
      Entre em contato conosco pelo e-mail abaixo:  
      <strong>xxxx@email.com</strong>
    </p>
    <p class="pe">
      Nossa equipe terá o maior prazer em responder o mais breve possível.  
      Aguardamos seu contato e agradecemos pela sua colaboração para tornar nossos serviços cada vez melhores!
    </p>
  </div>
</template>

<style>
.container123 {
  max-width: 600px;
  margin: auto;
  text-align: center;
  padding: 20px;
  background-color: #000000;
  border-radius: 8px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  font-family: 'Poppins', sans-serif;
  font-weight: bolder;
}

.aha2 {
  color: #ffffff;
  margin-bottom: 15px;
}

.pe {
  margin: 10px 0;
  line-height: 1.6;
  color: #ffffff;
}

strong {
  color: #ef3801;
}
</style>
