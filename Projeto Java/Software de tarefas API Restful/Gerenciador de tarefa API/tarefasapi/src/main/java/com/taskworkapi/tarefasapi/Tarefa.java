package com.taskworkapi.tarefasapi;

public class Tarefa {
    private int id;
    private String nomeTarefa;     
    private String conteudo;
    private String dataInsercao;
    private String dataExecucao;
    private String prioridade;

    public Tarefa() { }

    public Tarefa(int id, String nomeTarefa, String conteudo, String dataInsercao, String dataExecucao, String prioridade) {
        this.id = id;
        this.nomeTarefa = nomeTarefa;   
        this.conteudo = conteudo;
        this.dataInsercao = dataInsercao;
        this.dataExecucao = dataExecucao;
        this.prioridade = prioridade;
    }

    // Getters e Setters
    public int getId() { return id; }
    public void setId(int id) { this.id = id; }

    public String getNomeTarefa() { return nomeTarefa; }
    public void setNomeTarefa(String nomeTarefa) { this.nomeTarefa = nomeTarefa; }

    public String getConteudo() { return conteudo; }
    public void setConteudo(String conteudo) { this.conteudo = conteudo; }

    public String getDataInsercao() { return dataInsercao; }
    public void setDataInsercao(String dataInsercao) { this.dataInsercao = dataInsercao; }

    public String getDataExecucao() { return dataExecucao; }
    public void setDataExecucao(String dataExecucao) { this.dataExecucao = dataExecucao; }
    
    public String getprioridade() { return prioridade; }
    public void setprioridade(String prioridade) { this.prioridade = prioridade; }
}
