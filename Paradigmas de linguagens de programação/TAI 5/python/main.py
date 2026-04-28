# ===== Classe Base =====
class Livro:
    def __init__(self, titulo, autor, ano):
        self._titulo = None
        self._autor = None
        self._ano = None

        self.set_titulo(titulo)
        self.set_autor(autor)
        self.set_ano(ano)

    # ----- Métodos GET -----
    def get_titulo(self):
        return self._titulo

    def get_autor(self):
        return self._autor

    def get_ano(self):
        return self._ano

    # ----- Métodos SET com validação simples -----
    def set_titulo(self, titulo):
        if len(titulo.strip()) == 0:
            print("Título inválido.")
        else:
            self._titulo = titulo

    def set_autor(self, autor):
        if len(autor.strip()) == 0:
            print("Autor inválido.")
        else:
            self._autor = autor

    def set_ano(self, ano):
        if ano <= 0:
            print("Ano inválido.")
        else:
            self._ano = ano

    # ----- Método de instância -----
    def mostrar_informacoes(self):
        print(f"Livro: {self._titulo} | Autor: {self._autor} | Ano: {self._ano}")


# ===== Classe Derivada =====
class Ebook(Livro):
    def __init__(self, titulo, autor, ano, formato, tamanho_mb):
        super().__init__(titulo, autor, ano)

        self._formato = None
        self._tamanho_mb = None

        self.set_formato(formato)
        self.set_tamanho_mb(tamanho_mb)

    # ----- GET -----
    def get_formato(self):
        return self._formato

    def get_tamanho_mb(self):
        return self._tamanho_mb

    # ----- SET com validação -----
    def set_formato(self, formato):
        if len(formato.strip()) == 0:
            print("Formato inválido.")
        else:
            self._formato = formato

    def set_tamanho_mb(self, tamanho):
        if tamanho <= 0:
            print("Tamanho inválido.")
        else:
            self._tamanho_mb = tamanho

    # ----- Método sobrescrito para incluir mais dados -----
    def mostrar_informacoes(self):
        print(
            f"Ebook: {self._titulo} | Autor: {self._autor} | Ano: {self._ano} | "
            f"Formato: {self._formato} | Tamanho: {self._tamanho_mb}MB"
        )


# ======= TESTANDO OS OBJETOS =======
livro1 = Livro("Dom Casmurro", "Machado de Assis", 1899)
livro2 = Livro("1984", "George Orwell", 1949)
livro3 = Livro("O Senhor dos Anéis", "J.R.R. Tolkien", 1954)
ebook1 = Ebook("Neuromancer", "William Gibson", 1984, "PDF", 2.5)
ebook2 = Ebook("Snow Crash", "Neal Stephenson", 1992, "EPUB", 3.0)
ebook3 = Ebook("The Martian", "Andy Weir", 2011, "MOBI", 1.8)

livro1.mostrar_informacoes()
livro2.mostrar_informacoes()
livro3.mostrar_informacoes()
ebook1.mostrar_informacoes()
ebook2.mostrar_informacoes()
ebook3.mostrar_informacoes()

