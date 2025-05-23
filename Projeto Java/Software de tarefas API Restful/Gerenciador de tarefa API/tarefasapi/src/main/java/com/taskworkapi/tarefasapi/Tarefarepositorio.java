package com.taskworkapi.tarefasapi;

import com.fasterxml.jackson.core.type.TypeReference;
import com.fasterxml.jackson.databind.ObjectMapper;

import java.io.File;
import java.io.IOException;
import java.util.ArrayList;
import java.util.List;

public class Tarefarepositorio {

    private static final String FILE_NAME = "tarefas.json";
    private ObjectMapper mapper = new ObjectMapper();

    public Tarefarepositorio() {
        verificarOuCriarArquivo();
    }

    private void verificarOuCriarArquivo() {
        File arquivo = new File(FILE_NAME);
        if (!arquivo.exists()) {
            try {
                arquivo.createNewFile();
                salvarTodasTarefas(new ArrayList<>());
            } catch (IOException e) {
                e.printStackTrace();
            }
        }
    }

    private List<Tarefa> carregarTarefas() {
        try {
            return mapper.readValue(new File(FILE_NAME), new TypeReference<List<Tarefa>>() {});
        } catch (IOException e) {
            return new ArrayList<>();
        }
    }

    private void salvarTodasTarefas(List<Tarefa> tarefas) {
        try {
            mapper.writerWithDefaultPrettyPrinter().writeValue(new File(FILE_NAME), tarefas);
        } catch (IOException e) {
            e.printStackTrace();
        }
    }

    public List<Tarefa> listarTarefas() {
        return carregarTarefas();
    }
    
    public int obterProximoId() {
        List<Tarefa> tarefas = carregarTarefas();
        int maiorId = 0;
        for (Tarefa tarefa : tarefas) {
            if (tarefa.getId() > maiorId) {
                maiorId = tarefa.getId();
            }
        }
        return maiorId + 1;
    }

    public void adicionarTarefa(Tarefa tarefa) {
        List<Tarefa> tarefas = carregarTarefas();
        tarefa.setId(obterProximoId());
        tarefas.add(tarefa);
        salvarTodasTarefas(tarefas);
    }
    public boolean editarTarefa(int id, Tarefa novaTarefa) {
        List<Tarefa> tarefas = carregarTarefas();
        for (int i = 0; i < tarefas.size(); i++) {
            if (tarefas.get(i).getId() == id) {
                tarefas.set(i, novaTarefa);
                salvarTodasTarefas(tarefas);
                return true;
            }
        }
        return false;
    }

    public boolean removerTarefa(int id) {
        List<Tarefa> tarefas = carregarTarefas();
        boolean removido = tarefas.removeIf(t -> t.getId() == id);
        if (removido) {
            salvarTodasTarefas(tarefas);
        }
        return removido;
    }
}