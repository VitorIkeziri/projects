  <script setup>
  import { reactive, onMounted } from 'vue'
  import { useRouter } from 'vue-router'
  
  const router = useRouter()
  
  const usuario = reactive({
    idcargo: null
  })
  
  onMounted(() => {
    const dados = sessionStorage.getItem('usuarioLogado')
    if (dados) {
      const parsed = JSON.parse(dados)
      usuario.idcargo = parsed.idcargo
    }
  })
  
  function irParaEdicao() {
    router.push('/prodedit')
  }

  </script>
  

  <template>
    <div class="app">  
      <ul>
        <li><RouterLink class="btn-mn" to="SCasual">Casual</RouterLink></li>
        <li><RouterLink class="btn-mn" to="SPromo">Promoção</RouterLink></li>
        <li><RouterLink class="btn-mn" to="SSport">Sportes</RouterLink></li>
        <li><RouterLink class="btn-mn" to="SOutlet">Outlet</RouterLink></li>
        <li v-if="usuario.idcargo == 699">
          <button class="btn-mn" @click="irParaEdicao">Editar Produto</button>
        </li>
      </ul>
    </div>
  </template>
  