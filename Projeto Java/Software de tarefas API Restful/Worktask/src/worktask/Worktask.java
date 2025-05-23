/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Classes/Main.java to edit this template
 */
package worktask;
import javax.swing.SwingUtilities;

/**
 *
 * @author vitor
 */
public class Worktask {

    /**
     * @param args the command line arguments
     */
    public static void main(String[] args) {
        
        // Garantir que a GUI será criada na Thread de Eventos do Swing
        SwingUtilities.invokeLater(new Runnable() {
            @Override
            public void run() {
                Menutarefa menu = new Menutarefa();
                menu.setVisible(true);
            }
        });
    }
    
}
