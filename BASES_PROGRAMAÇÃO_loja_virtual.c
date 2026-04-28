/*  
    Disciplina: Bases de Programação - 2025/2
    Professor: Kilmer Boente
    Atividade A4 - Loja Virtual
    Data: Dezembro de 2025
    Descrição: Implementa uma loja virtual simples com catálogo de produtos,
    carrinho de compras, cálculo de frete e prazo de entrega conforme região.
    Autores: Alice Lima da Silva - 1250118146
             Allan Gustavo Alves Silva - 1250105015
             Dylan França Pereira - 1250109992
             Gabriel Pinheiro da Silva Guerra - 1250116465
             Guilherme Alves Medeiros - 1250111527
             Juliette da Silva Diniz - 1250118426
*/


#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <time.h>
#include <locale.h>

#define MAX_PRODUTOS 20
#define MAX_ITENS_CARRINHO 100
#define NOME_COMP 64

/* Região */
enum Regiao { REGIAO_SUL = 1, REGIAO_SUDESTE = 2, REGIAO_NORTE = 3, REGIAO_NORDESTE = 4 };

typedef struct {
    int codigo;   /* código do produto */
    char nome[NOME_COMP]; /* nome do produto */
    double preco;   /* R$ */
    double peso;  /* kg */
} Produto;

typedef struct {
    Produto produto;
    int qtde;
} ItemCarrinho;

/* Catálogo de exemplo */
void iniciarCatalogo(Produto produtos[], int *n) {
    *n = 8;
    produtos[0] = (Produto){1001, "Camiseta Algodao P", 49.90, 0.25};
    produtos[1] = (Produto){1002, "Tênis Running", 249.90, 0.9};
    produtos[2] = (Produto){1003, "Mochila 20L", 129.50, 0.6};
    produtos[3] = (Produto){1004, "Fone Bluetooth", 199.00, 0.15};
    produtos[4] = (Produto){1005, "Livro: Programação C", 89.90, 0.8};
    produtos[5] = (Produto){1006, "Cafeteira", 359.90, 2.5};
    produtos[6] = (Produto){1007, "Smartphone", 1499.00, 0.18};
    produtos[7] = (Produto){1008, "Smart TV 43\"", 1899.00, 6.5};
}

/* Buscar índice de produto pelo código. Retorna -1 se não existir */
int encontrarIndiceProdutoPeloCodigo(Produto produtos[], int n, int codigo) {
    for (int i = 0; i < n; ++i) {
        if (produtos[i].codigo == codigo) return i;
    }
    return -1;
}

/* Adiciona produto ao carrinho (se já existir, incrementa quantidade) */
void adcAoCarrinho(ItemCarrinho carrinho[], int *tamanhoCarrinho, Produto p, int qtde) {
    if (qtde <= 0) return;
    for (int i = 0; i < *tamanhoCarrinho; ++i) {
        if (carrinho[i].produto.codigo == p.codigo) {
            carrinho[i].qtde += qtde;
            printf("Quantidade atualizada: %s x%d\n", p.nome, carrinho[i].qtde);
            return;
        }
    }
    if (*tamanhoCarrinho < MAX_ITENS_CARRINHO) {
        carrinho[*tamanhoCarrinho].produto = p;
        carrinho[*tamanhoCarrinho].qtde = qtde;
        (*tamanhoCarrinho)++;
        printf("Produto adicionado ao carrinho: %s x%d\n", p.nome, qtde);
    } else {
        printf("Carrinho cheio. Não foi possivel adicionar.\n");
    }
}

/* Remove item do carrinho por código */
void removerDoCarrinho(ItemCarrinho carrinho[], int *tamanhoCarrinho, int codigo) {
    for (int i = 0; i < *tamanhoCarrinho; ++i) {
        if (carrinho[i].produto.codigo == codigo) {
            /* deslocar à esquerda */
            for (int j = i; j < *tamanhoCarrinho - 1; ++j) carrinho[j] = carrinho[j+1];
            (*tamanhoCarrinho)--;
            printf("Item removido do carrinho (codigo %d).\n", codigo);
            return;
        }
    }
    printf("Item com código %d não encontrado no carrinho.\n", codigo);
}

/* Exibe produtos disponíveis */
void listaProdutos(Produto produtos[], int n) {
    printf("=== Catálogo de Produtos ===\n");
    printf("%-6s %-25s %-8s %-6s\n", "Código", "Nome", "Preço(R$)", "Peso(kg)");
    for (int i = 0; i < n; ++i) {
        printf("%-6d %-25s %8.2f %8.2f\n", produtos[i].codigo, produtos[i].nome, produtos[i].preco, produtos[i].peso);
    }
}

/* Exibe carrinho */
void verCarrinho(ItemCarrinho carrinho[], int tamanhoCarrinho) {
    if (tamanhoCarrinho == 0) {
        printf("Carrinho vazio.\n");
        return;
    }
    double total = 0.0;
    printf("=== Carrinho de Compras ===\n");
    printf("%-6s %-20s %-6s %-10s %-10s\n", "Código", "Nome", "Qtd", "Preço unit.", "Subtotal");
    for (int i = 0; i < tamanhoCarrinho; ++i) {
        double subtotal = carrinho[i].produto.preco * carrinho[i].qtde;
        printf("%-6d %-20s %-6d %10.2f %10.2f\n",
               carrinho[i].produto.codigo, carrinho[i].produto.nome, carrinho[i].qtde, carrinho[i].produto.preco, subtotal);
        total += subtotal;
    }
    printf("Subtotal dos produtos: R$ %.2f\n", total);
}

/* Calcula total dos produtos */
double calcProdutosTotal(ItemCarrinho carrinho[], int tamanhoCarrinho) {
    double total = 0.0;
    for (int i = 0; i < tamanhoCarrinho; ++i) total += carrinho[i].produto.preco * carrinho[i].qtde;
    return total;
}

/* Calcula peso total */
double calcPesoTotal(ItemCarrinho carrinho[], int tamanhoCarrinho) {
    double total = 0.0;
    for (int i = 0; i < tamanhoCarrinho; ++i) total += carrinho[i].produto.peso * carrinho[i].qtde;
    return total;
}

/* Calcula o preço do frete conforme tabela (enunciado) */
double calcFrete(int regiao, double pesoTotal) {
    int pesado = (pesoTotal > 2.0) ? 1 : 0;
    switch (regiao) {
        case REGIAO_SUL:
            return pesado ? 50.0 : 30.0;
        case REGIAO_SUDESTE:
            return pesado ? 45.0 : 25.0;
        case REGIAO_NORTE:
            return pesado ? 55.0 : 35.0;
        case REGIAO_NORDESTE:
            return pesado ? 60.0 : 40.0;
        default:
            return 0.0;
    }
}

/* Calcula prazo de entrega (dias) por região; adiciona +1 dia se peso > 2kg */
int calcTempoEntrega(int regiao, double pesoTotal) {
    int base;
    switch (regiao) {
        case REGIAO_SUL: base = 3; break;
        case REGIAO_SUDESTE: base = 2; break;
        case REGIAO_NORTE: base = 7; break;
        case REGIAO_NORDESTE: base = 5; break;
        default: base = 7; break;
    }
    if (pesoTotal > 2.0) base += 1;
    return base;
}

/* Obtem data/hora atual em string formato YYYY-MM-DD HH:MM:SS */
void formatarData(time_t t, char *buf, size_t len) {
    struct tm tmstruct;
    localtime_r(&t, &tmstruct); /* funciona em POSIX; no Windows, usar localtime_s */
    strftime(buf, len, "%Y-%m-%d %H:%M:%S", &tmstruct);
}

/* Soma dias a time_t e formata */
void adcDias(int dias, char *buf, size_t len) {
    time_t agora = time(NULL);
    time_t futuro = agora + (time_t)dias * 24 * 3600;
    formatarData(futuro, buf, len);
}

/* Imprime resumo final */
void imprimeResumo(ItemCarrinho carrinho[], int tamanhoCarrinho, int regiao) {
    char horaDaCompra[64], horaDaEntrega[64];
    time_t agora = time(NULL);
    formatarData(agora, horaDaCompra, sizeof(horaDaCompra));

    double totalProd = calcProdutosTotal(carrinho, tamanhoCarrinho);
    double pesoTotal = calcPesoTotal(carrinho, tamanhoCarrinho);
    double frete = calcFrete(regiao, pesoTotal);
    int dias = calcTempoEntrega(regiao, pesoTotal);
    adcDias(dias, horaDaEntrega, sizeof(horaDaEntrega));
    double totalCompra = totalProd + frete;

    printf("\n=== RESUMO DA COMPRA ===\n");
    printf("Data/Hora da compra: %s\n", horaDaCompra);
    printf("Data prevista de entrega (+%d dias): %s\n\n", dias, horaDaEntrega);

    printf("%-6s %-20s %-6s %-10s %-8s %-10s\n", "Código", "Nome", "Qtd", "Preço unit.", "Peso", "Subtotal");
    for (int i = 0; i < tamanhoCarrinho; ++i) {
        double subtotal = carrinho[i].produto.preco * carrinho[i].qtde;
        double pesoDoItem = carrinho[i].produto.peso * carrinho[i].qtde;
        printf("%-6d %-20s %-6d %10.2f %6.2f %10.2f\n",
               carrinho[i].produto.codigo, carrinho[i].produto.nome, carrinho[i].qtde,
               carrinho[i].produto.preco, pesoDoItem, subtotal);
    }
    printf("\nPeso total: %.2f kg\n", pesoTotal);
    printf("Preco dos produtos: R$ %.2f\n", totalProd);
    /* traduzir região */
    const char *regiaoNome = "";
    switch (regiao) {
        case REGIAO_SUL: regiaoNome = "Sul"; break;
        case REGIAO_SUDESTE: regiaoNome = "Sudeste"; break;
        case REGIAO_NORTE: regiaoNome = "Norte"; break;
        case REGIAO_NORDESTE: regiaoNome = "Nordeste"; break;
        default: regiaoNome = "Desconhecida"; break;
    }
    printf("Região de entrega: %s\n", regiaoNome);
    printf("Preço do frete: R$ %.2f\n", frete);
    printf("TOTAL A PAGAR: R$ %.2f\n", totalCompra);
    printf("========================\n");
}

/* Menu principal */
void menuLoop(Produto produtos[], int ContagemProdutos) {
    ItemCarrinho carrinho[MAX_ITENS_CARRINHO];
    int tamanhoCarrinho = 0;
    int opcao;
    do {
        printf("\n=== Loja Virtual - Menu ===\n");
        printf("1 - Listar produtos\n");
        printf("2 - Ver carrinho\n");
        printf("3 - Remover item do carrinho\n");
        printf("4 - Finalizar compra\n");
        printf("0 - Sair\n");
        printf("Escolha uma opção: ");
        if (scanf("%d", &opcao) != 1) { fflush(stdin); opcao = -1; }
        if (opcao == 1) {
            listaProdutos(produtos, ContagemProdutos);
            printf("Digite o código do produto para adicionar (0 para voltar): ");
            int codigo; scanf("%d", &codigo);
            if (codigo == 0) continue;
            int indice = encontrarIndiceProdutoPeloCodigo(produtos, ContagemProdutos, codigo);
            if (indice == -1) {
                printf("Código inválido.\n");
                continue;
            }
            printf("Quantidade: ");
            int qtde; scanf("%d", &qtde);
            if (qtde <= 0) { printf("Quantidade inválida.\n"); continue; }
            adcAoCarrinho(carrinho, &tamanhoCarrinho, produtos[indice], qtde);
        } else if (opcao == 2) {
            verCarrinho(carrinho, tamanhoCarrinho);
        } else if (opcao == 3) {
            verCarrinho(carrinho, tamanhoCarrinho);
            printf("Digite código do item a remover (0 volta): ");
            int codigo; scanf("%d", &codigo);
            if (codigo == 0) continue;
            removerDoCarrinho(carrinho, &tamanhoCarrinho, codigo);
        } else if (opcao == 4) {
            if (tamanhoCarrinho == 0) {
                printf("Carrinho vazio. Adicione produtos antes de finalizar.\n");
                continue;
            }
            verCarrinho(carrinho, tamanhoCarrinho);
            printf("Escolha a região de entrega: \n");
            printf("1 - Sul\n2 - Sudeste\n3 - Norte\n4 - Nordeste\n");
            int regiao; scanf("%d", &regiao);
            if (regiao < 1 || regiao > 4) { printf("Região inválida. Voltando ao menu.\n"); continue; }
            imprimeResumo(carrinho, tamanhoCarrinho, regiao);
            printf("Compra finalizada. Obrigado!\n");
            /* Após finalizar, esvazia carrinho e volta ao menu. */
            tamanhoCarrinho = 0;
        } else if (opcao == 0) {
            printf("Saindo...\n");
        } else {
            printf("Opção inválida. Tente novamente.\n");
        }
    } while (opcao != 0);
}

int main(void) {
    setlocale(LC_ALL, "Portuguese");
    Produto produtos[MAX_PRODUTOS];
    int contagemProdutos = 0;
    iniciarCatalogo(produtos, &contagemProdutos);
    menuLoop(produtos, contagemProdutos);
    return 0;
}
