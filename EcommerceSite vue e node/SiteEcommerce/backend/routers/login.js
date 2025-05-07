const express = require('express');
const fs = require('fs');
const path = require('path');

const router = express.Router();
const dbPath = path.join(__dirname, '..', 'db', 'cadastro.json');


router.post('/', (req, res) => {
  const { email, senha } = req.body;

  fs.readFile(dbPath, 'utf8', (err, data) => {
    if (err) {
      return res.status(500).json({ mensagem: 'Erro está' });
    }

    const usuarios = JSON.parse(data);
    const usuarioEncontrado = usuarios.find(
      user => user.email === email && user.senha === senha
    );

    if (usuarioEncontrado) {
      const { name = 'Usuário', saldo: rawSaldo = '0.00', idcargo = '0' } = usuarioEncontrado;
      const saldo = parseFloat(rawSaldo) || 0.00;
      
    
      res.json({
        sucesso: true,
        mensagem: 'Login realizado com sucesso',
        name,
        saldo,
        idcargo
      });
    }else{
      res.status(401).json({ sucesso: false, mensagem: 'Usuário ou senha inválidos' });
    }
  });
});

module.exports = router;
