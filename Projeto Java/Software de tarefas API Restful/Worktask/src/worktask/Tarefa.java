package worktask;

import java.util.Date;

public class Tarefa {
    
    private final String prioridade;
    private final Date dataExecucao; // usa java.util.Date
    private final String nomeTarefa;
    private final String conteudo;
    
    public Tarefa(String prioridade, Date dataExecucao, String nomeTarefa, String conteudo) {
        if (prioridade == null || prioridade.isEmpty())
            throw new IllegalArgumentException("Prioridade não pode ser nula ou vazia.");
        if (dataExecucao == null)
            throw new IllegalArgumentException("Data de execução não pode ser nula.");
        if (nomeTarefa == null || nomeTarefa.isEmpty())
            throw new IllegalArgumentException("Nome da tarefa não pode ser nulo ou vazio.");
        if (conteudo == null)
            throw new IllegalArgumentException("Conteúdo não pode ser nulo.");
        
        this.prioridade = prioridade;
        this.dataExecucao = dataExecucao;
        this.nomeTarefa = nomeTarefa;
        this.conteudo = conteudo;
    }

    public String getPrioridade() { return prioridade; }
    public Date getDataExecucao() { return dataExecucao; } // retorna java.util.Date
    public String getNomeTarefa() { return nomeTarefa; }
    public String getConteudo() { return conteudo; }

    @Override
    public String toString() {
        return "Tarefa{" +
                "prioridade='" + prioridade + '\'' +
                ", dataExecucao=" + dataExecucao +
                ", nomeTarefa='" + nomeTarefa + '\'' +
                ", conteudo='" + conteudo + '\'' +
                '}';
    }
}