document.addEventListener("DOMContentLoaded", () => {
  const contatoForm = document.getElementById("contatoForm");

  if (contatoForm) {
    // Formatador de telefone enquanto digita
    const telefoneInput = document.getElementById("telefone");
    if (telefoneInput) {
      telefoneInput.addEventListener("input", function (e) {
        // Formata o telefone automaticamente
        let valor = e.target.value.replace(/\D/g, "");

        // Limita a quantidade de dígitos
        if (valor.length > 11) {
          valor = valor.substring(0, 11); // Limita a 11 dígitos (DDD + 9 dígitos)
        }

        if (valor.length > 0) {
          if (valor.length <= 2) {
            // Só DDD
            valor = `(${valor}`;
          } else if (valor.length <= 6) {
            // DDD + início do número
            valor = `(${valor.substring(0, 2)}) ${valor.substring(2)}`;
          } else {
            // Formato completo
            valor = `(${valor.substring(0, 2)}) ${valor.substring(
              2,
              valor.length - 4
            )}-${valor.substring(valor.length - 4)}`;
          }
          e.target.value = valor;
        }
      });

      // Prevenir colagem de texto muito longo
      telefoneInput.addEventListener("paste", function (e) {
        // Pega o texto colado
        let paste = (e.clipboardData || window.clipboardData).getData("text");
        // Mantém apenas números
        paste = paste.replace(/\D/g, "");

        // Se for maior que 11 dígitos, corta
        if (paste.length > 11) {
          paste = paste.substring(0, 11);
          e.preventDefault(); // Impede a colagem original

          // Coloca o valor formatado manualmente
          setTimeout(() => {
            if (paste.length <= 2) {
              this.value = `(${paste}`;
            } else if (paste.length <= 6) {
              this.value = `(${paste.substring(0, 2)}) ${paste.substring(2)}`;
            } else {
              this.value = `(${paste.substring(0, 2)}) ${paste.substring(
                2,
                paste.length - 4
              )}-${paste.substring(paste.length - 4)}`;
            }
          }, 0);
        }
      });

      // O formato máximo seria (99) 99999-9999 = 15 caracteres
      telefoneInput.setAttribute("maxlength", "15");
    }

    // Validação no envio do formulário
    contatoForm.addEventListener("submit", function (event) {
      if (!this.checkValidity()) {
        event.preventDefault();
        event.stopPropagation();
      }

      this.classList.add("was-validated");
    });
  }
});
