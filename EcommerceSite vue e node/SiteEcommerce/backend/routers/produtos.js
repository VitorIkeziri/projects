const express = require('express');
const fs = require('fs');
const path = require('path');

const router = express.Router();
const dbPath = path.join(__dirname, '..', 'db', 'produtos.json');

// GET todos os produtos
router.get('/', (req, res) => {
  fs.readFile(dbPath, 'utf8', (err, data) => {
    if (err) return res.status(500).json({ error: 'Erro na leitura do arquivo' });
    res.json(JSON.parse(data));
  });
});

// POST: cria novo ou substitui existente
router.post('/', (req, res) => {
  const produto = req.body;

  fs.readFile(dbPath, 'utf8', (err, data) => {
    if (err) return res.status(500).json({ error: 'Erro ao ler o arquivo' });

    let produtos = [];
    try {
      produtos = JSON.parse(data);
    } catch (e) {
      produtos = [];
    }

    const index = produtos.findIndex(p => p.id === produto.id);

    if (index !== -1) {
      // Produto existe: substituir
      produtos[index] = produto;
    } else {
      // Produto novo: adicionar
      produto.id = produtos.length > 0 ? produtos[produtos.length - 1].id + 1 : 1;
      produtos.push(produto);
    }

    fs.writeFile(dbPath, JSON.stringify(produtos, null, 2), (err) => {
      if (err) return res.status(500).json({ error: 'Erro ao salvar o produto' });

      const msg = index !== -1 ? 'Produto atualizado com sucesso' : 'Produto cadastrado com sucesso';
      res.status(200).json({ message: msg });
    });
  });
});

router.delete('/:id', (req, res) => {
  const id = parseInt(req.params.id)

  fs.readFile(dbPath, 'utf8', (err, data) => {
    if (err) return res.status(500).json({ error: 'Erro ao ler o arquivo' })

    let produtos = []
    try {
      produtos = JSON.parse(data)
    } catch (e) {
      return res.status(500).json({ error: 'Erro ao analisar os dados' })
    }

    const index = produtos.findIndex(p => p.id === id)
    if (index === -1) return res.status(404).json({ error: 'Produto não encontrado' })

    produtos.splice(index, 1)

    fs.writeFile(dbPath, JSON.stringify(produtos, null, 2), (err) => {
      if (err) return res.status(500).json({ error: 'Erro ao salvar após remoção' })
      res.status(200).json({ message: 'Produto removido com sucesso' })
    })
  })
})

module.exports = router;