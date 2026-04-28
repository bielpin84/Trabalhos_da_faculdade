// Classe Abstrata (Pai)
abstract class Personagem {

    protected String nome;
    protected int vida;
    protected int forca;

    public Personagem(String nome, int vida, int forca) {
        this.nome = nome;
        this.vida = vida;
        this.forca = forca;
    }

    public void mostrarStatus() {
        System.out.println("Nome: " + nome);
        System.out.println("Vida: " + vida);
        System.out.println("Força: " + forca);
    }

    // Método abstrato (polimórfico)
    public abstract void atacar();
}


// Classe Derivada 1
class Guerreiro extends Personagem {

    private int armadura;

    public Guerreiro(String nome, int vida, int forca, int armadura) {
        super(nome, vida, forca);
        this.armadura = armadura;
    }

    public void golpeEspada() {
        System.out.println(nome + " realizou um golpe de espada!");
    }

    @Override
    public void atacar() {
        System.out.println(nome + " atacou com a espada causando " + forca * 2 + " de dano!");
    }
}


// Classe Derivada 2
class Mago extends Personagem {

    private int mana;

    public Mago(String nome, int vida, int forca, int mana) {
        super(nome, vida, forca);
        this.mana = mana;
    }

    public void lancarFeitico() {
        System.out.println(nome + " lançou um feitiço poderoso!");
    }

    @Override
    public void atacar() {
        System.out.println(nome + " atacou com magia causando " + (forca + mana) + " de dano!");
    }
}


// Classe Derivada 3
class Arqueiro extends Personagem {

    private int flechas;

    public Arqueiro(String nome, int vida, int forca, int flechas) {
        super(nome, vida, forca);
        this.flechas = flechas;
    }

    public void atirarFlecha() {
        if (flechas > 0) {
            flechas--;
            System.out.println(nome + " atirou uma flecha! Flechas restantes: " + flechas);
        } else {
            System.out.println(nome + " não tem mais flechas!");
        }
    }

    @Override
    public void atacar() {
        System.out.println(nome + " atacou à distância causando " + (forca + 3) + " de dano!");
    }
}


// Classe Principal
public class App {
    public static void main(String[] args) {

        Personagem p1 = new Guerreiro("Arthur", 100, 15, 10);
        Personagem p2 = new Mago("Merlin", 80, 10, 30);
        Personagem p3 = new Arqueiro("Robin", 90, 12, 5);

        p1.atacar(); // Chama atacar() da classe Guerreiro
        p2.atacar(); // Chama atacar() da classe Mago
        p3.atacar(); // Chama atacar() da classe Arqueiro

        System.out.println("\n--- Ações específicas ---");
        ((Guerreiro)p1).golpeEspada();
        ((Mago)p2).lancarFeitico();
        ((Arqueiro)p3).atirarFlecha();
    }
}
