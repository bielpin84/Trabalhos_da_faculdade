#include <stdio.h>
#include <string.h>
#include <ctype.h>

// ====== VARIAVEL GLOBAL ======
int totalGeral = 0; // acessada por multiplas funcoes

// ====== CONSTANTES ======
#define TAM 4 // quantidade de tamanhos (RN, P, M, G)

// ====== DECLARACOES ======
void inicializarVetores(int fraldas[], int pacotes[]);
void registrarPacotes(int fraldas[], int pacotes[]);
void exibirResumo(int fraldas[], int pacotes[]);
int calcularTotal(int fraldas[]);
void mostrarMenu();
int confirmarSaida();

// ====== FUNCAO PRINCIPAL ======
int main() {
    int fraldas[TAM]; // vetor com total de fraldas por tamanho
    int pacotes[TAM]; // vetor com total de pacotes por tamanho
    int opcao;

    inicializarVetores(fraldas, pacotes);

    do {
        mostrarMenu();
        printf("\nEscolha uma opcao: ");
        scanf("%d", &opcao);

        switch (opcao) {
            case 1:
                registrarPacotes(fraldas, pacotes);
                break;
            case 2:
                exibirResumo(fraldas, pacotes);
                break;
            case 3:
                if (confirmarSaida()) {
                    printf("\nEncerrando o programa...\n");
                    return 0;
                }
                break;
            default:
                printf("Opcao invalida! Tente novamente.\n");
        }
    } while (1);

    return 0;
}

// ====== PROCEDIMENTO: inicializar vetores ======
void inicializarVetores(int fraldas[], int pacotes[]) {
    for (int i = 0; i < TAM; i++) { // escopo de bloco
        fraldas[i] = 0;
        pacotes[i] = 0;
    }
}

// ====== PROCEDIMENTO: exibir menu ======
void mostrarMenu() {
    printf("\n=======================================\n");
    printf("       CONTADOR DE FRALDAS v2.0\n");
    printf("=======================================\n");
    printf("1 - Registrar novos pacotes\n");
    printf("2 - Exibir resumo atual\n");
    printf("3 - Sair do programa\n");
    printf("=======================================\n");
}

// ====== FUNcaO: confirmar saida ======
int confirmarSaida() {
    char resposta;
    printf("Deseja realmente sair? (S/N): ");
    scanf(" %c", &resposta);
    resposta = toupper(resposta);
    return (resposta == 'S');
}

// ====== PROCEDIMENTO: registrar pacotes ======
void registrarPacotes(int fraldas[], int pacotes[]) {
    int qtdPacotes, qtdFraldas;
    int indice;
    char tamanhoChar;

    while (1) {
        printf("\nSelecione o tamanho da fralda:\n");
        printf("1 - RN\n2 - P\n3 - M\n4 - G\n5 - Voltar ao menu\n");
        printf("Opcao: ");
        scanf(" %c", &tamanhoChar);

        if (!isdigit(tamanhoChar)) {
            printf("Entrada invalida! Digite um numero entre 1 e 5.\n");
            continue;
        }

        int opcaoTamanho = tamanhoChar - '0';

        if (opcaoTamanho == 5) {
            printf("\nVoltando ao menu principal...\n");
            break;
        }

        if (opcaoTamanho < 1 || opcaoTamanho > 4) {
            printf("Opcao invalida! Escolha entre 1 e 4.\n");
            continue;
        }

        printf("Quantidade de pacotes: ");
        scanf("%d", &qtdPacotes);

        if (qtdPacotes <= 0) {
            printf("Numero de pacotes invalido! Deve ser maior que zero.\n");
            continue;
        }

        printf("Quantidade de fraldas por pacote: ");
        scanf("%d", &qtdFraldas);

        if (qtdFraldas <= 0) {
            printf("Numero de fraldas invalido! Deve ser maior que zero.\n");
            continue;
        }

        indice = opcaoTamanho - 1;
        int totalGrupo = qtdPacotes * qtdFraldas;

        fraldas[indice] += totalGrupo;
        pacotes[indice] += qtdPacotes;
        totalGeral += totalGrupo;

        // Feedback continuo
        char *tamanhos[TAM] = {"RN", "P", "M", "G"};
        printf("\n>>> %d pacotes de %s registrados (%d fraldas).\n", qtdPacotes, tamanhos[indice], totalGrupo);

        // Exibe um resumo parcial
        int somaAtual = calcularTotal(fraldas);
        printf("Total atual de fraldas: %d\n", somaAtual);
        for (int i = 0; i < TAM; i++) {
            float perc = (somaAtual > 0) ? (fraldas[i] * 100.0 / somaAtual) : 0;
            printf(" - %s: %d fraldas (%.2f%%)\n", tamanhos[i], fraldas[i], perc);
        }

        printf("---------------------------------------\n");
    }
}

// ====== FUNCAO: calcular total ======
int calcularTotal(int fraldas[]) {
    int soma = 0;
    for (int i = 0; i < TAM; i++) {
        soma += fraldas[i];
    }
    return soma;
}

// ====== PROCEDIMENTO: exibir resumo detalhado ======
void exibirResumo(int fraldas[], int pacotes[]) {
    char *tamanhos[TAM] = {"RN", "P", "M", "G"};
    int soma = calcularTotal(fraldas);

    if (soma == 0) {
        printf("\nNenhum pacote registrado ainda.\n");
        return;
    }

    printf("\n============= RESUMO FINAL =============\n");
    printf("Tamanho | Pacotes | Fraldas | %% do total\n");
    printf("----------------------------------------\n");

    for (int i = 0; i < TAM; i++) {
        float perc = (soma > 0) ? (fraldas[i] * 100.0 / soma) : 0;
        printf("%6s   | %7d | %7d | %7.2f%%\n", tamanhos[i], pacotes[i], fraldas[i], perc);
    }

    printf("----------------------------------------\n");
    printf("TOTAL   | %7d | %7d | 100.00%%\n", 
           pacotes[0] + pacotes[1] + pacotes[2] + pacotes[3], soma);
    printf("========================================\n");
    printf("Total geral de fraldas registradas: %d\n", soma);
    printf("========================================\n");
}

