# Paradigma Funcional
from functools import reduce

def filtrar_por_categoria(produtos, categoria):
    return list(filter(lambda p: p.get_categoria() == categoria, produtos))

def nomes_produtos(produtos):
    return list(map(lambda p: p.get_nome(), produtos))

def calcular_total_carrinho(carrinho):
    return reduce(lambda acc, item: acc + item.subtotal(), carrinho.itens, 0)

# Função de ordem superior
def aplicar_desconto(funcao_desconto):
    def desconto(preco):
        return funcao_desconto(preco)
    return desconto
