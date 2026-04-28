// ==========================================
// DADOS IMUTÁVEIS (BASE)
// ==========================================
// Usando const + Object.freeze() para garantir imutabilidade
const appsUso = Object.freeze([
  Object.freeze({ app: "Instagram", minutos: 120 }),
  Object.freeze({ app: "YouTube", minutos: 95 }),
  Object.freeze({ app: "WhatsApp", minutos: 40 }),
  Object.freeze({ app: "Spotify", minutos: 80 }),
  Object.freeze({ app: "LinkedIn", minutos: 25 })
]);

// ==========================================
// FUNÇÕES PURAS
// ==========================================

//  Converte minutos em horas — pura e determinística
function minutosParaHoras(dados) {
  return dados.map(d => ({
    app: d.app,
    horas: +(d.minutos / 60).toFixed(2)
  }));
}

//  Filtra apps com tempo acima de um limite (usa filter)
function filtrarAcimaDe(dados, limiteHoras) {
  return dados.filter(d => d.horas > limiteHoras);
}

// ==========================================
// FUNÇÕES DE ORDEM SUPERIOR
// ==========================================

//  Recebe uma lista e uma função, aplicando-a a cada item (usa map)
function aplicar(lista, func) {
  return lista.map(func);
}

//  Closure: retorna uma função multiplicadora (retorna função)
function criarMultiplicador(fator) {
  return function (d) {
    return { app: d.app, horas: +(d.horas * fator).toFixed(2) };
  };
}

// ==========================================
// REDUCE (AGREGAÇÃO)
// ==========================================

//  Soma total de horas — função pura
function totalHoras(dados) {
  return dados.reduce((acc, d) => acc + d.horas, 0);
}

// ==========================================
// DEMONSTRAÇÃO / MAIN
// ==========================================
console.log("=== Dados originais ===");
console.log(appsUso);

// Transformação pura (map)
const dadosEmHoras = minutosParaHoras(appsUso);
console.log("\n=== Após transformação (min -> horas) ===");
console.log(dadosEmHoras);

// Verificando imutabilidade
console.log("\nOriginal continua o mesmo (imutável):");
console.log(appsUso);

// Referential transparency — mesma entrada → mesma saída
console.log("\n=== Referential transparency ===");
console.log(
  JSON.stringify(minutosParaHoras(appsUso)) ===
  JSON.stringify(minutosParaHoras(appsUso))
); // true

// filter() → apps com mais de 1h
const acimaDe1h = filtrarAcimaDe(dadosEmHoras, 1);
console.log("\n=== Apps com mais de 1h de uso ===");
console.log(acimaDe1h);

// map() → função de ordem superior + closure multiplicadora
const dobrarTempo = criarMultiplicador(2);
const usoDobrado = aplicar(dadosEmHoras, dobrarTempo);
console.log("\n=== Após aplicar função multiplicadora (fator 2) ===");
console.log(usoDobrado);

// reduce() → total de horas
const total = totalHoras(dadosEmHoras);
console.log("\n=== Total de horas de uso (reduce) ===");
console.log(total);

// Confirmando que o original segue intacto
console.log("\nVerificação final: dados originais inalterados?");
console.log(appsUso);
