# ============================================
# TAI 4 - Recursividade, Ausência de efeitos
# colaterais e Transparência Referencial
# Tema: Processamento Recursivo de Texto
# Autor: Gabriel Pinheiro da Silva Guerra
# ============================================

# --------------------------------------------
# Função Recursiva 1: contar ocorrências
# --------------------------------------------

def contar_caractere(texto, alvo, idx=0):
    """
    Retorna quantas vezes o caractere 'alvo' ocorre em 'texto'.
    - Pura (não modifica nada externo)
    - Recursiva (sem loops)
    - Transparência referencial (mesma entrada => mesma saída)
    """
    if idx == len(texto):  # caso base
        return 0

    incremento = 1 if texto[idx] == alvo else 0
    return incremento + contar_caractere(texto, alvo, idx + 1)


# --------------------------------------------
# Função Recursiva 2: remover caractere
# --------------------------------------------

def remover_caractere(texto, alvo, idx=0):
    """
    Retorna uma nova string sem o caractere alvo.
    - Não altera o original (imutabilidade)
    - Pura (só retorna valor)
    - Recursiva (sem loops)
    """
    if idx == len(texto):  # caso base
        return ""

    resto = remover_caractere(texto, alvo, idx + 1)
    if texto[idx] == alvo:
        return resto
    return texto[idx] + resto


# --------------------------------------------
# Testes / Demonstração
# --------------------------------------------
if __name__ == "__main__":

    texto_original = "recursao funcional pura"

    print("=== Texto original ===")
    print(texto_original)

    # Transparência referencial (mesma entrada → mesma saída)
    print("\n=== Teste de transparencia referencial ===")
    print(contar_caractere(texto_original, "a") == contar_caractere(texto_original, "a"))  # sempre True

    # Contagem recursiva
    print("\n=== Contagem de 'a' no texto ===")
    print(contar_caractere(texto_original, "a"))

    # Remoção recursiva
    print("\n=== Remover letra 'a' ===")
    texto_sem_a = remover_caractere(texto_original, "a")
    print(texto_sem_a)

    # Comprovar imutabilidade
    print("\n=== Confirmando que o original permanece intacto ===")
    print(texto_original)
