import java.util.Scanner;

public class ContadorDeFraldas {

    // ===== VARIÁVEL GLOBAL =====
    static int totalGeral = 0; // acessada por várias funções

    // ===== CONSTANTES =====
    static final String[] TAMANHOS = {"RN", "P", "M", "G"};

    // ===== MÉTODO PRINCIPAL =====
    public static void main(String[] args) {
        Scanner sc = new Scanner(System.in);

        // ===== VARIÁVEIS LOCAIS =====
        int[] fraldas = new int[TAMANHOS.length];
        int[] pacotes = new int[TAMANHOS.length];

        int opcao;

        do {
            mostrarMenu();
            System.out.print("\nEscolha uma opcao: ");

            while (!sc.hasNextInt()) {
                System.out.println("Entrada invalida! Digite um numero entre 1 e 3.");
                sc.next();
                System.out.print("\nEscolha uma opcao: ");
            }

            opcao = sc.nextInt();
            sc.nextLine(); // Limpa o buffer

            switch (opcao) {
                case 1:
                    registrarPacotes(sc, fraldas, pacotes);
                    break;
                case 2:
                    exibirResumo(fraldas, pacotes);
                    break;
                case 3:
                    if (confirmarSaida(sc)) {
                        System.out.println("\nEncerrando o programa... Ate logo!");
                        sc.close();
                        return;
                    }
                    break;
                default:
                    System.out.println("Opcao invalida! Tente novamente.");
                    break;
            }

        } while (true);
    }

    // ===== PROCEDIMENTO: mostrar menu =====
    public static void mostrarMenu() {
        System.out.println("\n=======================================");
        System.out.println("       CONTADOR DE FRALDAS v2.0");
        System.out.println("=======================================");
        System.out.println("1 - Registrar novos pacotes");
        System.out.println("2 - Exibir resumo atual");
        System.out.println("3 - Sair do programa");
        System.out.println("=======================================");
    }

    // ===== FUNÇÃO: confirmar saída =====
    public static boolean confirmarSaida(Scanner sc) {
        System.out.print("Deseja realmente sair? (S/N): ");
        String resposta = sc.nextLine().trim().toUpperCase();
        return resposta.equals("S");
    }

    // ===== PROCEDIMENTO: registrar pacotes =====
    public static void registrarPacotes(Scanner sc, int[] fraldas, int[] pacotes) {
        while (true) {
            System.out.println("\nSelecione o tamanho da fralda:");
            System.out.println("1 - RN");
            System.out.println("2 - P");
            System.out.println("3 - M");
            System.out.println("4 - G");
            System.out.println("5 - Voltar ao menu");

            System.out.print("Opção: ");
            int opcaoTamanho;

            while (!sc.hasNextInt()) {
                System.out.println("Entrada invalida! Digite um número entre 1 e 5.");
                sc.next();
                System.out.print("Opcao: ");
            }

            opcaoTamanho = sc.nextInt();
            sc.nextLine(); // limpar buffer

            if (opcaoTamanho == 5) {
                System.out.println("\nVoltando ao menu principal...");
                break;
            }

            if (opcaoTamanho < 1 || opcaoTamanho > 4) {
                System.out.println("Opcao invalida! Escolha entre 1 e 4.");
                continue;
            }

            System.out.print("Quantidade de pacotes: ");
            int qtdPacotes = lerInteiroPositivo(sc);

            System.out.print("Quantidade de fraldas por pacote: ");
            int qtdFraldas = lerInteiroPositivo(sc);

            int indice = opcaoTamanho - 1;
            int totalGrupo = qtdPacotes * qtdFraldas;

            fraldas[indice] += totalGrupo;
            pacotes[indice] += qtdPacotes;
            totalGeral += totalGrupo;

            // Feedback contínuo
            System.out.println("\n>>> " + qtdPacotes + " pacotes de " + TAMANHOS[indice]
                    + " registrados (" + totalGrupo + " fraldas).");
            mostrarResumoParcial(fraldas);
        }
    }

    // ===== FUNÇÃO: ler número positivo =====
    public static int lerInteiroPositivo(Scanner sc) {
        int valor;
        while (true) {
            while (!sc.hasNextInt()) {
                System.out.println("Entrada invalida! Use apenas numeros inteiros.");
                sc.next();
                System.out.print("Digite novamente: ");
            }
            valor = sc.nextInt();
            sc.nextLine(); // limpar buffer
            if (valor > 0) {
                return valor;
            } else {
                System.out.print("O valor deve ser maior que zero! Digite novamente: ");
            }
        }
    }

    // ===== FUNÇÃO: calcular total =====
    public static int calcularTotal(int[] vetor) {
        int soma = 0;
        for (int i = 0; i < vetor.length; i++) {
            soma += vetor[i];
        }
        return soma;
    }

    // ===== PROCEDIMENTO: mostrar resumo parcial =====
    public static void mostrarResumoParcial(int[] fraldas) {
        int somaAtual = calcularTotal(fraldas);
        System.out.println("\n--- Resumo Parcial ---");
        System.out.println("Total atual de fraldas: " + somaAtual);

        for (int i = 0; i < TAMANHOS.length; i++) {
            double perc = (somaAtual > 0) ? (fraldas[i] * 100.0 / somaAtual) : 0;
            System.out.printf(" - %s: %d fraldas (%.2f%%)\n", TAMANHOS[i], fraldas[i], perc);
        }
        System.out.println("-----------------------");
    }

    // ===== PROCEDIMENTO: exibir resumo completo =====
    public static void exibirResumo(int[] fraldas, int[] pacotes) {
        int soma = calcularTotal(fraldas);

        if (soma == 0) {
            System.out.println("\nNenhum pacote registrado ainda.");
            return;
        }

        System.out.println("\n============= RESUMO FINAL =============");
        System.out.println("Tamanho | Pacotes | Fraldas | % do total");
        System.out.println("----------------------------------------");

        for (int i = 0; i < TAMANHOS.length; i++) {
            double perc = (soma > 0) ? (fraldas[i] * 100.0 / soma) : 0;
            System.out.printf("%7s | %8d | %8d | %7.2f%%\n",
                    TAMANHOS[i], pacotes[i], fraldas[i], perc);
        }

        System.out.println("----------------------------------------");
        System.out.printf("TOTAL   | %8d | %8d | 100.00%%\n", somarVetor(pacotes), soma);
        System.out.println("========================================");
        System.out.println("Total geral de fraldas registradas: " + soma);
        System.out.println("========================================");
    }

    // ===== FUNÇÃO: somar elementos de vetor =====
    public static int somarVetor(int[] vetor) {
        int soma = 0;
        for (int valor : vetor) {
            soma += valor;
        }
        return soma;
    }
}
