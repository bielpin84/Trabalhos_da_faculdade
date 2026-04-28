from produtos import listar_produtos, escolher_produto, produtos
from modelos import Carrinho, Cliente, PagamentoPix, PagamentoCartao, PagamentoBoleto, Pedido
from funcoes_funcionais import calcular_total_carrinho, aplicar_desconto, filtrar_por_categoria

carrinho = Carrinho()
cliente = Cliente("Joao das Coves", "joaodascoves@email.com")  # cliente fixo para simplificar

def mostrar_carrinho():
    print("\n--- Seu Carrinho ---")
    if len(carrinho.itens) == 0:
        print("Carrinho vazio.")
    else:
        for item in carrinho.itens:
            print(f"{item.qtd}x {item.produto.get_nome()} - R${item.subtotal():.2f}")
        total = calcular_total_carrinho(carrinho)
        print(f"Total: R${total:.2f}")


def menu():
    while True:
        print("\n=== Loja Online ===")
        print("1. Listar produtos")
        print("2. Listar produtos por categoria")
        print("3. Adicionar produto ao carrinho")
        print("4. Remover produto do carrinho")
        print("5. Ver carrinho (itens e total)")
        print("6. Finalizar compra (Pedido)")
        print("7. Sair")

        opcao = input("Escolha uma opção: ")

        match opcao:
            case "1":
                listar_produtos()

            case "2":
                categoria = input("Categoria: ")
                filtrados = filtrar_por_categoria(produtos, categoria)

                if not filtrados:
                    print("Nenhum produto encontrado.")
                else:
                    for p in filtrados:
                        print(p)
                        
            case "3":
                while True:   # LOOP INTERNO PARA COMPRAS SEQUENCIAIS
                    listar_produtos()
                    codigo = input("Código: ")
                    produto = escolher_produto(codigo)

                    if produto:
                        carrinho.adicionar(produto, 1)

                    print("\n1. Continuar comprando")
                    print("2. Voltar ao menu")

                    escolha = input("Opção: ")

                    if escolha == "1":
                        continue   # volta ao início do loop interno

                    elif escolha == "2":
                        break      # retorna ao menu principal

                    else:
                        print("Opção inválida.")
                        break
                        
            case "4":
                mostrar_carrinho()
                if len(carrinho.itens) == 0:
                    continue
                else:
                    codigo = input("Digite o código do produto para remover: ")
                    if carrinho.remover(codigo):
                        print("Produto removido!")
                    else:
                        print("Código não encontrado no carrinho.")

            case "5":
                print("\n--- Seu Carrinho ---")

                if len(carrinho.itens) == 0:
                    print("Carrinho vazio.")
                else:
                    for item in carrinho.itens:
                        print(f"{item.qtd}x {item.produto.get_nome()} - R${item.subtotal():.2f}")

                    # PARADIGMA FUNCIONAL: reduce para somar valores
                    total = calcular_total_carrinho(carrinho)
                    print(f"Total: R${total:.2f}")

            case "6":
                total = calcular_total_carrinho(carrinho)
                print(f"Valor final: R${total:.2f}")
                print("Escolha forma de pagamento:")
                print("Pagamentos com Pix têm 10% de desconto!")
                print("1. Pix\n2. Cartão\n3. Boleto")

                forma = input("Opção: ")
                if forma not in ["1", "2", "3"]:
                    print("Forma inválida!")
                    continue

                forma = int(forma)

                if forma == 1:
                    pagamento = PagamentoPix()
                    print("Aplicando desconto de 10%.")
                    desconto10 = aplicar_desconto(lambda v: v * 0.9)
                    total = desconto10(total)
                    print(f"Total com desconto: R${total:.2f}")
                elif forma == 2:
                    pagamento = PagamentoCartao()
                else:
                    pagamento = PagamentoBoleto()

                pedido = Pedido(cliente, carrinho, pagamento)
                pedido.total = total
                pedido.confirmar_pedido()
                pedido.mostrar_resumo()
                
                # Limpa carrinho após finalizar
                carrinho.limpar()


            case "7":
                print("Saindo...")
                break
            case _:
                print("Opção inválida!")

menu()
