import { createMemoryHistory, createRouter } from 'vue-router'



const routes = [
  { path: '/home', component: ()=> import('../views/contatos.vue')},
  { path: '/login', component: ()=> import('../views/Menulogin.vue') },
  { path: '/cadastro', component: ()=> import('../views/cadastro.vue') },
  { path: '/contato', component: ()=> import('../views/contatos.vue')},
  { path: '/produto', component: ()=> import('../views/produto.vue')},
  { path: '/prodedit', component: ()=> import('../views/produtosedit.vue')},
  { path: '/Procurarprouto', component: ()=> import('../components/Procurarproduto.vue')},
  { path: '/Adicionaproduto', component: ()=> import('../components/Adicionaproduto.vue')},
  { path: '/Editarproduto', component: ()=> import('../components/Editarproduto.vue')},
  { path: '/Removerproduto', component: ()=> import('../components/Removerproduto.vue')},
  { path: '/SCasual', component: ()=> import('../views/SCasual.vue')},
  { path: '/SPromo', component: ()=> import('../views/SPromo.vue')},
  { path: '/SSport', component: ()=> import('../views/SSport.vue')},
  { path: '/SOutlet', component: ()=> import('../views/SOutlet.vue')}, 
]

const router = createRouter({
  history: createMemoryHistory(),
  routes,
})

export default router;