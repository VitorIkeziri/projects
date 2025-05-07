const express = require('express');
const cors = require('cors');
const bodyParser = require('body-parser');

const cadastroRoutes = require('./routers/cadastro');
const loginRoutes = require('./routers/login');
const ProdutosRoutes = require('./routers/produtos');

const app = express();
const PORT = 3000;

app.use(cors());

app.use(bodyParser.json({ limit: '10mb' }));
app.use(bodyParser.urlencoded({ limit: '10mb', extended: true }));

// Usando as rotas
app.use('/cadastro', cadastroRoutes);
app.use('/login', loginRoutes);
app.use('/produtos', ProdutosRoutes);

// Iniciar o servidor
app.listen(PORT, () => {
  console.log(`Servidor rodando em http://localhost:${PORT}`);
});
