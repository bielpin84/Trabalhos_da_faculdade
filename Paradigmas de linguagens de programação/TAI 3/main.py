from functools import reduce
from copy import deepcopy

# ==========================
# DADOS IMUTÁVEIS (BASE)
# ==========================
# Tupla (imutável) como estrutura base
# Cada item é um dicionário (não será alterado — apenas copiado/derivado)
apps_uso = (
    {"app": "Instagram", "minutos": 120},
    {"app": "YouTube", "minutos": 95},
    {"app": "WhatsApp", "minutos": 40},
    {"app": "Spotify", "minutos": 80},
    {"app": "LinkedIn", "minutos": 25},
)

# ==========================
# FUNÇÕES PURAS
# ==========================

def minutos_para_horas(dados):
    """
    Função pura:
    - Não altera a entrada.
    - Retorna uma nova lista.
    - Sempre produz o mesmo resultado para a mesma entrada.
    """
    return [{"app": d["app"], "horas": round(d["minutos"] / 60, 2)} for d in dados]


def filtrar_acima_de(dados, limite_horas):
    """
    Função pura:
    - Usa 'filter' explicitamente.
    - Retorna nova lista sem alterar o original.
    """
    return list(filter(lambda d: d["horas"] > limite_horas, dados))


# ==========================
# FUNÇÃO DE ORDEM SUPERIOR
# ==========================

def aplicar(lista, func):
    """
    Recebe uma lista e uma função, aplicando-a a cada elemento.
    Exemplo: aplicar(dados, lambda x: x["horas"] * 2)
    """
    return list(map(func, lista))


def criar_multiplicador(fator):
    """
    Closure (retorna uma função).
    Retorna uma função que multiplica o tempo de uso por 'fator'.
    """
    def multiplicar(d):
        return {"app": d["app"], "horas": round(d["horas"] * fator, 2)}
    return multiplicar


# ==========================
# REDUCE (AGREGAÇÃO)
# ==========================

def total_horas(dados):
    """
    Função pura que usa reduce para somar total de horas.
    """
    return reduce(lambda acc, d: acc + d["horas"], dados, 0)


# ==========================
# FUNÇÃO AUXILIAR DE EXIBIÇÃO
# ==========================

def exibir_lista_formatada(lista):
    """Exibe cada dicionário em uma linha formatada."""
    for item in lista:
        print(f"- {item}")


# ==========================
# MAIN / DEMONSTRAÇÃO
# ==========================
if __name__ == "__main__":

    print("=== Dados originais ===")
    exibir_lista_formatada(apps_uso)  # Tuple original (imutável)

    # Transformação: minutos -> horas
    dados_em_horas = minutos_para_horas(apps_uso)
    print("\n=== Apos transformacao (min -> horas) ===")
    exibir_lista_formatada(dados_em_horas)

    # Verificando imutabilidade
    print("\nOriginal continua o mesmo (imutavel):")
    exibir_lista_formatada(apps_uso)  # Tuple original (imutável)

    # Referential transparency (mesma entrada → mesma saída)
    print("\n=== Teste de referential transparency ===")
    print(minutos_para_horas(apps_uso) == minutos_para_horas(apps_uso))  # True

    # Filtrar apps com mais de 1h de uso
    acima_1h = filtrar_acima_de(dados_em_horas, 1)
    print("\n=== Apps com mais de 1h de uso ===")
    exibir_lista_formatada(acima_1h)

    # Função de ordem superior: aplicar() + closure multiplicadora
    dobrar_tempo = criar_multiplicador(2)
    uso_dobrado = aplicar(dados_em_horas, dobrar_tempo)

    print("\n=== Apos aplicar funcao multiplicadora (fator 2) ===")
    exibir_lista_formatada(uso_dobrado)

    # Reduce: total de horas
    total = total_horas(dados_em_horas)
    print("\n=== Total de horas de uso (reduce) ===")
    print(f"Total: {total} horas")

    # Confirmando que a estrutura original segue intacta
    print("\nVerificacao final: dados originais inalterados?")
    exibir_lista_formatada(apps_uso)
