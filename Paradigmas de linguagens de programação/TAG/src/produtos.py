
# Paradigma Estruturado: funções e controle clássico
from modelos import ProdutoFisico, ProdutoDigital
        
produtos = [
    ProdutoFisico("P001", "Livro Python", 50, "Livros", "Aprenda Python", 10),
    ProdutoDigital("P002", "Curso Online JS", 100, "Cursos", "Curso completo de JS", 5),
    ProdutoFisico("P003", "Notebook", 3000, "Eletrônicos", "Notebook gamer", 2)
]

def listar_produtos():
    print("\n--- Produtos Disponíveis ---")
    for p in produtos:
        print(p)

def escolher_produto(codigo):
    for p in produtos:
        if p.get_codigo() == codigo:
            return p
    print("Código inválido!")
    return None