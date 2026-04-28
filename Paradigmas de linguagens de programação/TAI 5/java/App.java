public class App {
    public static void main(String[] args) {

        // ===== TESTANDO AS CLASSES =====
        Livro livro1 = new Livro("Dom Casmurro", "Machado de Assis", 1899);
        Livro livro2 = new Livro("1984", "George Orwell", 1949);
        Livro livro3 = new Livro("O Senhor dos Anéis", "J.R.R. Tolkien", 1954);
        Ebook ebook1 = new Ebook("Neuromancer", "William Gibson", 1984, "PDF", 2.5);
        Ebook ebook2 = new Ebook("Snow Crash", "Neal Stephenson", 1992, "EPUB", 3.0);
        Ebook ebook3 = new Ebook("The Martian", "Andy Weir", 2011, "MOBI", 1.8);

        livro1.mostrarInformacoes();
        livro2.mostrarInformacoes();
        livro3.mostrarInformacoes();
        ebook1.mostrarInformacoes();
        ebook2.mostrarInformacoes();
        ebook3.mostrarInformacoes();
    }
}


// ==================== CLASSE BASE ====================
class Livro {
    private String titulo;
    private String autor;
    private int ano;

    public Livro(String titulo, String autor, int ano) {
        setTitulo(titulo);
        setAutor(autor);
        setAno(ano);
    }

    // ----- GET -----
    public String getTitulo() {
        return titulo;
    }

    public String getAutor() {
        return autor;
    }

    public int getAno() {
        return ano;
    }

    // ----- SET com validação simples -----
    public void setTitulo(String titulo) {
        if (titulo == null || titulo.trim().isEmpty()) {
            System.out.println("Título inválido.");
        } else {
            this.titulo = titulo;
        }
    }

    public void setAutor(String autor) {
        if (autor == null || autor.trim().isEmpty()) {
            System.out.println("Autor inválido.");
        } else {
            this.autor = autor;
        }
    }

    public void setAno(int ano) {
        if (ano <= 0) {
            System.out.println("Ano inválido.");
        } else {
            this.ano = ano;
        }
    }

    // ----- Método de instância -----
    public void mostrarInformacoes() {
        System.out.println("Livro: " + titulo + " | Autor: " + autor + " | Ano: " + ano);
    }
}


// ==================== CLASSE DERIVADA ====================
class Ebook extends Livro {

    private String formato;
    private double tamanhoMB;

    public Ebook(String titulo, String autor, int ano, String formato, double tamanhoMB) {
        super(titulo, autor, ano);
        setFormato(formato);
        setTamanhoMB(tamanhoMB);
    }

    // ----- GET -----
    public String getFormato() {
        return formato;
    }

    public double getTamanhoMB() {
        return tamanhoMB;
    }

    // ----- SET com validação -----
    public void setFormato(String formato) {
        if (formato == null || formato.trim().isEmpty()) {
            System.out.println("Formato inválido.");
        } else {
            this.formato = formato;
        }
    }

    public void setTamanhoMB(double tamanhoMB) {
        if (tamanhoMB <= 0) {
            System.out.println("Tamanho inválido.");
        } else {
            this.tamanhoMB = tamanhoMB;
        }
    }

    // ----- Método sobrescrito -----
    @Override
    public void mostrarInformacoes() {
        System.out.println(
            "Ebook: " + getTitulo() +
            " | Autor: " + getAutor() +
            " | Ano: " + getAno() +
            " | Formato: " + formato +
            " | Tamanho: " + tamanhoMB + "MB"
        );
    }
}

