# ------------------------------------------------------------
# CLASSE BASE: Produto
# ------------------------------------------------------------
class Produto:
    def __init__(self, codigo, nome, preco, categoria, descricao, estoque):
        # Encapsulamento: atributos iniciados com "_"
        self._codigo = codigo
        self._nome = nome
        self._preco = preco
        self._categoria = categoria
        self._descricao = descricao
        self._estoque = estoque

    # Métodos getters (encapsulamento)
    def get_codigo(self): return self._codigo
    def get_nome(self): return self._nome
    def get_preco(self): return self._preco
    def get_categoria(self): return self._categoria
    def get_descricao(self): return self._descricao

    # Controle de estoque (regra de negócio)
    def debitar_estoque(self, qtd):
        if self._estoque >= qtd:
            self._estoque -= qtd
            return True
        print("Estoque insuficiente.")
        return False

    # Método que pode ser sobrescrito (polimorfismo)
    def calcular_valor_final(self):
        return self._preco

    # Representação textual do objeto
    def __str__(self):
        return f"[{self._codigo}] {self._nome} - R${self._preco:.2f} ({self._categoria}) | Estoque: {self._estoque}"


# ------------------------------------------------------------
# HERANÇA: ProdutoFisico
# Sobrescreve o método calcular_valor_final (polimorfismo)
# ------------------------------------------------------------
class ProdutoFisico(Produto):
    def calcular_valor_final(self):
        # Acrescenta frete fixo de R$10
        return self.get_preco() + 10


# ------------------------------------------------------------
# HERANÇA: ProdutoDigital
# Não possui frete → mantém o preço original
# ------------------------------------------------------------
class ProdutoDigital(Produto):
    def calcular_valor_final(self):
        return self.get_preco()


# ------------------------------------------------------------
# COMPOSIÇÃO: ItemCarrinho contém um Produto
# ------------------------------------------------------------
class ItemCarrinho:
    def __init__(self, produto, qtd):
        self.produto = produto
        self.qtd = qtd

    # Subtotal usa polimorfismo do produto
    def subtotal(self):
        return self.produto.calcular_valor_final() * self.qtd


# ------------------------------------------------------------
# COMPOSIÇÃO: Carrinho contém vários ItemCarrinho
# ------------------------------------------------------------
class Carrinho:
    def __init__(self):
        self.itens = []

    # Adiciona item ao carrinho e debita estoque
    def adicionar(self, produto, qtd=1):
        if produto.debitar_estoque(qtd):
            self.itens.append(ItemCarrinho(produto, qtd))
            return True
        return False

    # Remove item e devolve estoque
    def remover(self, codigo):
        for item in self.itens:
            if item.produto.get_codigo() == codigo:
                item.produto._estoque += item.qtd  # devolve estoque
                self.itens = [i for i in self.itens if i.produto.get_codigo() != codigo]
                return True  # remoção bem-sucedida

        return False  # código não encontrado


    # Soma total usando subtotal (polimorfismo)
    def calcular_total(self):
        return sum(i.subtotal() for i in self.itens)

    # Limpa carrinho após compra
    def limpar(self):
        self.itens = []


# ------------------------------------------------------------
# Classe simples representando o cliente
# ------------------------------------------------------------
class Cliente:
    def __init__(self, nome, email):
        self.nome = nome
        self.email = email


# ------------------------------------------------------------
# CLASSE ABSTRATA: Pagamento
# ------------------------------------------------------------
class Pagamento:
    def processar_pagamento(self, valor):
        # Método abstrato → deve ser sobrescrito
        raise NotImplementedError()


# ------------------------------------------------------------
# POLIMORFISMO: cada forma de pagamento implementa o método
# ------------------------------------------------------------
class PagamentoPix(Pagamento):
    def processar_pagamento(self, valor):
        print(f"Pagamento de R${valor:.2f} via Pix realizado.")


class PagamentoCartao(Pagamento):
    def processar_pagamento(self, valor):
        print(f"Pagamento de R${valor:.2f} via Cartão aprovado.")


class PagamentoBoleto(Pagamento):
    def processar_pagamento(self, valor):
        print(f"Boleto gerado no valor de R${valor:.2f}.")


# ------------------------------------------------------------
# Pedido usa composição: contém Cliente, Carrinho e Pagamento
# ------------------------------------------------------------
class Pedido:
    def __init__(self, cliente, carrinho, pagamento):
        self.cliente = cliente
        self.itens = carrinho.itens.copy()
        self.total = carrinho.calcular_total()
        self.pagamento = pagamento
        self.status = "Pendente"

    # Confirma pedido e processa pagamento
    def confirmar_pedido(self):
        if len(self.itens) == 0 or self.total == 0:
            print("Não é possível confirmar um pedido vazio.")
            return

        self.pagamento.processar_pagamento(self.total)
        self.status = "Pago"

    # Exibe resumo do pedido
    def mostrar_resumo(self):
        print("\n===== RESUMO DO PEDIDO =====")
        print(f"Cliente: {self.cliente.nome} ({self.cliente.email})")
        for item in self.itens:
            print(f"{item.qtd}x {item.produto.get_nome()} - R${item.subtotal():.2f}")
        print(f"Total: R${self.total:.2f}")
        print(f"Status: {self.status}")
        print("============================")
