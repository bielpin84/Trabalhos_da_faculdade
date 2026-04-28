/******************************************************************************

                            Online C Compiler.
                Code, Compile, Run and Debug C program online.
Write your code in this editor and press "Run" button to compile and execute it.

*******************************************************************************/

#include <stdio.h>

int main() {
	int qtdPacotes;       // número de pacotes de um mesmo tipo
	int qtdFraldas;       // quantidade de fraldas em cada pacote
	char tamanho[3];      // tamanho da fralda (RN, P, M ou G)

	// contadores por tamanho
	int totalRN = 0, totalP = 0, totalM = 0, totalG = 0;
	int totalPacotes = 0, totalGeral = 0;

	// variáveis para porcentagem
	float percRN = 0, percP = 0, percM = 0, percG = 0;

	printf("=== CONTADOR DE FRALDAS DO CHA DE BEBE ===\n\n");
	printf("Siga as instrucoes para contar a quantidade de pacotes ganhos.\n");

	while (1) {
		printf("\nInforme o tamanho da fralda (RN, P, M ou G): ");
		scanf("%s", tamanho);

		printf("Quantos pacotes desse tamanho voce recebeu (0 para encerrar)? ");
		scanf("%d", &qtdPacotes);

		// condição de parada
		if (qtdPacotes == 0) {
			printf("\nEncerrando o registro de pacotes...\n");
			break;
		}

		if (qtdPacotes < 0) {
			printf("Quantidade invalida! Tente novamente.\n");
			continue;
		}

		printf("Quantas fraldas ha em cada pacote desse tipo? ");
		scanf("%d", &qtdFraldas);

		if (qtdFraldas <= 0) {
			printf("Quantidade de fraldas invalida! Tente novamente.\n");
			continue;
		}

		// cálculo total de fraldas para este grupo
		int totalFraldasGrupo = qtdPacotes * qtdFraldas;

		// estrutura condicional para acumular os totais
		if (tamanho[0] == 'R' || tamanho[0] == 'r') {
			totalRN += totalFraldasGrupo;
		} else if (tamanho[0] == 'P' || tamanho[0] == 'p') {
			totalP += totalFraldasGrupo;
		} else if (tamanho[0] == 'M' || tamanho[0] == 'm') {
			totalM += totalFraldasGrupo;
		} else if (tamanho[0] == 'G' || tamanho[0] == 'g') {
			totalG += totalFraldasGrupo;
		} else {
			printf("Tamanho invalido informado! Grupo ignorado.\n");
			continue; // ignora grupo inválido
		}

		// atualização dos totais
		totalGeral += totalFraldasGrupo;
		totalPacotes += qtdPacotes;

		printf(">>> %d pacotes de tamanho %s registrados! (%d fraldas no total)\n",
		       qtdPacotes, tamanho, totalFraldasGrupo);
	}

	// cálculo das porcentagens (se houver fraldas)
	if (totalGeral > 0) {
		percRN = (totalRN * 100.0) / totalGeral;
		percP  = (totalP  * 100.0) / totalGeral;
		percM  = (totalM  * 100.0) / totalGeral;
		percG  = (totalG  * 100.0) / totalGeral;
	}

	// saída dos resultados
	printf("\n=== RESULTADO FINAL ===\n");
	printf("Total de fraldas RN: %d (%.2f%%)\n", totalRN, percRN);
	printf("Total de fraldas P : %d (%.2f%%)\n", totalP,  percP);
	printf("Total de fraldas M : %d (%.2f%%)\n", totalM,  percM);
	printf("Total de fraldas G : %d (%.2f%%)\n", totalG,  percG);

	printf("\nTotal geral de fraldas recebidas: %d\n", totalGeral);
	printf("Total de pacotes contabilizados: %d\n", totalPacotes);

	printf("\nObrigado por usar o contador de fraldas!\n");

	return 0;
}

