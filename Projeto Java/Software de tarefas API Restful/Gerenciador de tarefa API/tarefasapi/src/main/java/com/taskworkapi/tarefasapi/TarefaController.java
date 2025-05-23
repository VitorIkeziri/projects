package com.taskworkapi.tarefasapi;

import org.springframework.web.bind.annotation.*;

import java.time.LocalDateTime;
import java.time.format.DateTimeFormatter;
import java.util.List;

@RestController
@RequestMapping("/tarefas")
public class TarefaController {

    private Tarefarepositorio repositorio = new Tarefarepositorio();

    @GetMapping
    public List<Tarefa> listarTarefas() {
        return repositorio.listarTarefas();
    }

    @PostMapping
    public String adicionarTarefa(@RequestBody Tarefa tarefa) {
        tarefa.setDataInsercao(dataAtual());
        repositorio.adicionarTarefa(tarefa);
        return "Tarefa adicionada!";
    }

    @PutMapping("/{id}")
    public String editarTarefa(@PathVariable int id, @RequestBody Tarefa novaTarefa) {
        if (repositorio.editarTarefa(id, novaTarefa)) {
            return "Tarefa editada com sucesso!";
        }
        return "Tarefa não encontrada.";
    }

    @DeleteMapping("/{id}")
    public String removerTarefa(@PathVariable int id) {
        if (repositorio.removerTarefa(id)) {
            return "Tarefa removida.";
        }
        return "Tarefa não encontrada.";
    }

    private String dataAtual() {
        return LocalDateTime.now().format(DateTimeFormatter.ofPattern("yyyy-MM-dd HH:mm:ss"));
    }
}