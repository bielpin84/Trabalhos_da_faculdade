// ============================================
// TAI 4 - Recursividade, Ausência de efeitos colaterais e Transparência Referencial
// Tema: Processamento Recursivo de Texto
// Autor: Gabriel Pinheiro da Silva Guerra
// ============================================

public class App {

    // --------------------------------------------
    // Função Recursiva 1: contar occurrences
    // --------------------------------------------
    public static int contarCaractere(String texto, char alvo, int idx) {
        if (idx == texto.length()) {
            return 0; // caso base
        }

        int incremento = (texto.charAt(idx) == alvo) ? 1 : 0;
        return incremento + contarCaractere(texto, alvo, idx + 1);
    }

    // Versão simplificada (para ser chamada sem idx manual)
    public static int contarCaractere(String texto, char alvo) {
        return contarCaractere(texto, alvo, 0);
    }

    // --------------------------------------------
    // Função Recursiva 2: remover caractere
    // --------------------------------------------
    public static String removerCaractere(String texto, char alvo, int idx) {
        if (idx == texto.length()) {
            return ""; // caso base
        }

        String resto = removerCaractere(texto, alvo, idx + 1);
        return (texto.charAt(idx) == alvo) ? resto : texto.charAt(idx) + resto;
    }

    public static String removerCaractere(String texto, char alvo) {
        return removerCaractere(texto, alvo, 0);
    }

    // --------------------------------------------
    // Testes / Demonstração
    // --------------------------------------------
    public static void main(String[] args) {

        String textoOriginal = "recursao funcional pura";

        System.out.println("=== Texto original ===");
        System.out.println(textoOriginal);

        // Transparência referencial
        System.out.println("\n=== Teste de transparencia referencial ===");
        System.out.println(contarCaractere(textoOriginal, 'a') == contarCaractere(textoOriginal, 'a')); // sempre true

        System.out.println("\n=== Contagem de 'a' no texto ===");
        System.out.println(contarCaractere(textoOriginal, 'a'));

        System.out.println("\n=== Remover letra 'a' ===");
        String textoSemA = removerCaractere(textoOriginal, 'a');
        System.out.println(textoSemA);

        System.out.println("\n=== Confirmando que o original permanece intacto ===");
        System.out.println(textoOriginal);
    }
}
