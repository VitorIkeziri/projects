const express = require('express');
const fs = require('fs');
const path = require('path');

const router = express.Router();
const dbPath = path.join(__dirname, '..', 'db', 'cadastro.json');

// Listar cadastros
router.get('/', (req, res) => {
  fs.readFile(dbPath, 'utf8', (err, data) => {
    if (err) return res.status(500).json({ error: 'Erro ao ler o arquivo' });
    res.json(JSON.parse(data));
  });
});

// Cadastrar novo usuário
router.post('/', (req, res) => {
  const novoUsuario = req.body;

  fs.readFile(dbPath, 'utf8', (err, data) => {
    if (err) return res.status(500).json({ error: 'Erro ao ler o arquivo' });

    let usuarios = [];
    try {
      usuarios = JSON.parse(data);
    } catch (e) {
      usuarios = [];
    }

    novoUsuario.id = usuarios.length > 0 ? usuarios[usuarios.length - 1].id + 1 : 1;
    usuarios.push(novoUsuario);

    fs.writeFile(dbPath, JSON.stringify(usuarios, null, 2), (err) => {
      if (err) return res.status(500).json({ error: 'Erro ao salvar o usuário' });
      res.status(201).json({ message: 'Usuário cadastrado com sucesso' });
    });
  });
});

module.exports = router;
