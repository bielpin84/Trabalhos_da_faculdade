from abc import ABC, abstractmethod


# Classe Abstrata (Pai)
class Personagem(ABC):

    def __init__(self, nome, vida, forca):
        self.nome = nome
        self.vida = vida
        self.forca = forca

    def mostrar_status(self):
        print(f"Nome: {self.nome}")
        print(f"Vida: {self.vida}")
        print(f"Força: {self.forca}")

    @abstractmethod
    def atacar(self):
        pass


# Classe Derivada 1
class Guerreiro(Personagem):

    def __init__(self, nome, vida, forca, armadura):
        super().__init__(nome, vida, forca)
        self.armadura = armadura

    def golpe_espada(self):
        print(f"{self.nome} realizou um golpe de espada!")

    def atacar(self):
        print(f"{self.nome} atacou com a espada causando {self.forca * 2} de dano!")


# Classe Derivada 2
class Mago(Personagem):

    def __init__(self, nome, vida, forca, mana):
        super().__init__(nome, vida, forca)
        self.mana = mana

    def lancar_feitico(self):
        print(f"{self.nome} lançou um feitiço poderoso!")

    def atacar(self):
        print(f"{self.nome} atacou com magia causando {self.forca + self.mana} de dano!")


# Classe Derivada 3
class Arqueiro(Personagem):

    def __init__(self, nome, vida, forca, flechas):
        super().__init__(nome, vida, forca)
        self.flechas = flechas

    def atirar_flecha(self):
        if self.flechas > 0:
            self.flechas -= 1
            print(f"{self.nome} atirou uma flecha! Flechas restantes: {self.flechas}")
        else:
            print(f"{self.nome} não tem mais flechas!")

    def atacar(self):
        print(f"{self.nome} atacou à distância causando {self.forca + 3} de dano!")


# Programa Principal
if __name__ == "__main__":

    p1 = Guerreiro("Arthur", 100, 15, 10)
    p2 = Mago("Merlin", 80, 10, 30)
    p3 = Arqueiro("Robin", 90, 12, 5)

    p1.atacar() # Chama atacar() da classe Guerreiro
    p2.atacar() # Chama atacar() da classe Mago
    p3.atacar() # Chama atacar() da classe Arqueiro

    print("\n--- Ações específicas ---")
    p1.golpe_espada()
    p2.lancar_feitico()
    p3.atirar_flecha()
