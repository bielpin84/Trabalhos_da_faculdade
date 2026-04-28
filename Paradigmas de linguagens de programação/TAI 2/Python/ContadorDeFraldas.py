# ====== VARIÁVEL GLOBAL ======
total_geral = 0  # acessada por múltiplas funções

# ====== CONSTANTES ======
TAMANHOS = ["RN", "P", "M", "G"]


# ====== FUNÇÃO PRINCIPAL ======
def main():
    # ====== VARIÁVEIS LOCAIS ======
    fraldas = [0] * len(TAMANHOS)
    pacotes = [0] * len(TAMANHOS)

    while True:
        mostrar_menu()
        try:
            opcao = int(input("\nEscolha uma opção: "))
        except ValueError:
            print("Entrada inválida! Digite um número entre 1 e 3.")
            continue

        if opcao == 1:
            registrar_pacotes(fraldas, pacotes)
        elif opcao == 2:
            exibir_resumo(fraldas, pacotes)
        elif opcao == 3:
            if confirmar_saida():
                print("\nEncerrando o programa... Até logo!")
                break
        else:
            print("Opção inválida! Tente novamente.")


# ====== PROCEDIMENTO: mostrar menu ======
def mostrar_menu():
    print("\n=======================================")
    print("       CONTADOR DE FRALDAS v2.0")
    print("=======================================")
    print("1 - Registrar novos pacotes")
    print("2 - Exibir resumo atual")
    print("3 - Sair do programa")
    print("=======================================")


# ====== FUNÇÃO: confirmar saída ======
def confirmar_saida():
    resposta = input("Deseja realmente sair? (S/N): ").strip().upper()
    return resposta == "S"


# ====== PROCEDIMENTO: registrar pacotes ======
def registrar_pacotes(fraldas, pacotes):
    global total_geral  # variável GLOBAL usada aqui

    while True:
        print("\nSelecione o tamanho da fralda:")
        print("1 - RN\n2 - P\n3 - M\n4 - G\n5 - Voltar ao menu")

        try:
            opcao_tamanho = int(input("Opção: "))
        except ValueError:
            print("Entrada inválida! Digite um número entre 1 e 5.")
            continue

        if opcao_tamanho == 5:
            print("\nVoltando ao menu principal...")
            break

        if opcao_tamanho < 1 or opcao_tamanho > 4:
            print("Opção inválida! Escolha entre 1 e 4.")
            continue

        try:
            qtd_pacotes = int(input("Quantidade de pacotes: "))
            qtd_fraldas = int(input("Quantidade de fraldas por pacote: "))
        except ValueError:
            print("Entrada inválida! Use apenas números inteiros.")
            continue

        if qtd_pacotes <= 0 or qtd_fraldas <= 0:
            print("Os valores devem ser maiores que zero!")
            continue

        indice = opcao_tamanho - 1
        total_grupo = qtd_pacotes * qtd_fraldas

        fraldas[indice] += total_grupo
        pacotes[indice] += qtd_pacotes
        total_geral += total_grupo

        # Feedback contínuo
        print(f"\n>>> {qtd_pacotes} pacotes de {TAMANHOS[indice]} registrados ({total_grupo} fraldas).")
        mostrar_resumo_parcial(fraldas)


# ====== FUNÇÃO: calcular total ======
def calcular_total(fraldas):
    soma = 0
    for i in range(len(fraldas)):
        soma += fraldas[i]
    return soma


# ====== PROCEDIMENTO: mostrar resumo parcial ======
def mostrar_resumo_parcial(fraldas):
    soma_atual = calcular_total(fraldas)
    print("\n--- Resumo Parcial ---")
    print(f"Total atual de fraldas: {soma_atual}")
    for i, tam in enumerate(TAMANHOS):
        perc = (fraldas[i] * 100 / soma_atual) if soma_atual > 0 else 0
        print(f" - {tam}: {fraldas[i]} fraldas ({perc:.2f}%)")
    print("-----------------------")


# ====== PROCEDIMENTO: exibir resumo completo ======
def exibir_resumo(fraldas, pacotes):
    soma = calcular_total(fraldas)

    if soma == 0:
        print("\nNenhum pacote registrado ainda.")
        return

    print("\n============= RESUMO FINAL =============")
    print("Tamanho | Pacotes | Fraldas | % do total")
    print("----------------------------------------")

    for i, tam in enumerate(TAMANHOS):
        perc = (fraldas[i] * 100 / soma) if soma > 0 else 0
        print(f"{tam:^7} | {pacotes[i]:^8} | {fraldas[i]:^8} | {perc:7.2f}%")

    print("----------------------------------------")
    print(f"TOTAL   | {sum(pacotes):^8} | {soma:^8} | 100.00%")
    print("========================================")
    print(f"Total geral de fraldas registradas: {soma}")
    print("========================================")


# ====== EXECUÇÃO ======
if __name__ == "__main__":
    main()
