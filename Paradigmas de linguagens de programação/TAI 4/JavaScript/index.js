// ============================================
// TAI 4 - Recursividade, Ausência de efeitos colaterais e Transparência Referencial
// Tema: Processamento Recursivo de Texto
// Autor: Gabriel Pinheiro da Silva Guerra
// ============================================

// --------------------------------------------
// Função Recursiva 1: contar occurrences
// --------------------------------------------

function contarCaractere(texto, alvo, idx = 0) {
    if (idx === texto.length) return 0; // caso base

    const incremento = texto[idx] === alvo ? 1 : 0;
    return incremento + contarCaractere(texto, alvo, idx + 1);
}

// --------------------------------------------
// Função Recursiva 2: remover caractere
// --------------------------------------------

function removerCaractere(texto, alvo, idx = 0) {
    if (idx === texto.length) return ""; // caso base

    const resto = removerCaractere(texto, alvo, idx + 1);
    return texto[idx] === alvo ? resto : texto[idx] + resto;
}

// --------------------------------------------
// Testes / Demonstração
// --------------------------------------------

const textoOriginal = "recursao funcional pura";

console.log("=== Texto original ===");
console.log(textoOriginal);

// Transparência referencial
console.log("\n=== Teste de transparencia referencial ===");
console.log(contarCaractere(textoOriginal, "a") === contarCaractere(textoOriginal, "a")); // sempre true

console.log("\n=== Contagem de 'a' no texto ===");
console.log(contarCaractere(textoOriginal, "a"));

console.log("\n=== Remover letra 'a' ===");
const textoSemA = removerCaractere(textoOriginal, "a");
console.log(textoSemA);

console.log("\n=== Confirmando que o original permanece intacto ===");
console.log(textoOriginal);
