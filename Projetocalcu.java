/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Classes/Main.java to edit this template
 */
package projetocalcu;

import java.util.Scanner;

/**
 *
 * @author vitor ikeziri
 */
package projetocalcu;

import java.util.Scanner;

'public class Projetocalcu {

    public static void main(String[] args) {
        Scanner sc = new Scanner(System.in); 
        
        double v1, v2, Resultado;
        String operador;
        
        // Estrutura em ASCII
        System.out.println("******************************");
        System.out.println("          CALCULADORA         ");
        System.out.println("******************************");
        System.out.println("*********@VITOR*Ikeziri*******");
        
        System.out.print("Digite o primeiro valor: ");
        v1 = sc.nextDouble();
        
        System.out.print("Digite o segundo valor: ");
        v2 = sc.nextDouble();
        
        System.out.println("Escolha a operação desejada:");
        System.out.println("+  - Soma");
        System.out.println("-  - Subtração");
        System.out.println("*  - Multiplicação");
        System.out.println("/  - Divisão");
        
        // O usuário escolhe o operador
        System.out.print("Digite o operador: ");
        operador = sc.next();
        
        switch (operador) {
            case "+" -> {
                Resultado = v1 + v2;
                System.out.println("Resultado: " + Resultado);
            }
            case "-" -> {
                Resultado = v1 - v2;
                System.out.println("Resultado: " + Resultado);
            }
            case "*" -> {
                Resultado = v1 * v2;
                System.out.println("Resultado: " + Resultado);
            }
            case "/" -> {
                if (v2 != 0) {
                    Resultado = v1 / v2;
                    System.out.println("Resultado: " + Resultado);
                } else {
                    System.out.println("Erro! Divisão por zero.");
                }
            }
            default -> System.out.println("Operador inválido.");
        }
        
        System.out.println("******************************");
    }
}
