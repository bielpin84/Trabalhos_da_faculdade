import java.util.List;
import java.util.Map;
import java.util.function.Function;
import java.util.stream.Collectors;

// Record garante imutabilidade (campos finais, sem setters)
record AppUso(String app, int minutos) {}
record AppHoras(String app, double horas) {}

public class App {

    // ==========================
    // FUNÇÕES PURAS
    // ==========================

    //  Converte minutos em horas — pura, determinística
    public static List<AppHoras> minutosParaHoras(List<AppUso> dados) {
        return dados.stream()
                .map(d -> new AppHoras(d.app(), Math.round((d.minutos() / 60.0) * 100.0) / 100.0))
                .toList(); // cria nova lista (imutável)
    }

    //  Filtra apps acima de determinado limite de horas — usa filter()
    public static List<AppHoras> filtrarAcimaDe(List<AppHoras> dados, double limiteHoras) {
        return dados.stream()
                .filter(d -> d.horas() > limiteHoras)
                .toList();
    }

    // ==========================
    // FUNÇÕES DE ORDEM SUPERIOR
    // ==========================

    //  Recebe uma função e aplica sobre a lista — equivalente ao "aplicar" em Python/JS
    public static <T, R> List<R> aplicar(List<T> lista, Function<T, R> func) {
        return lista.stream()
                .map(func)
                .toList();
    }

    //  Retorna uma função multiplicadora — closure equivalente
    public static Function<AppHoras, AppHoras> criarMultiplicador(double fator) {
        return d -> new AppHoras(d.app(), Math.round((d.horas() * fator) * 100.0) / 100.0);
    }

    // ==========================
    // REDUCE (AGREGAÇÃO)
    // ==========================

    //  Soma total de horas — função pura com reduce()
    public static double totalHoras(List<AppHoras> dados) {
        return dados.stream()
                .map(AppHoras::horas)
                .reduce(0.0, Double::sum);
    }

    // ==========================
    // MAIN / DEMONSTRAÇÃO
    // ==========================
    public static void main(String[] args) {

        // Lista imutável base
        List<AppUso> appsUso = List.of(
                new AppUso("Instagram", 120),
                new AppUso("YouTube", 95),
                new AppUso("WhatsApp", 40),
                new AppUso("Spotify", 80),
                new AppUso("LinkedIn", 25)
        );

        System.out.println("=== Dados originais ===");
        appsUso.forEach(System.out::println);

        // Transformação pura (map)
        List<AppHoras> dadosEmHoras = minutosParaHoras(appsUso);
        System.out.println("\n=== Apos transformacao (min -> horas) ===");
        dadosEmHoras.forEach(System.out::println);

        // Imutabilidade
        System.out.println("\nOriginal continua o mesmo (imutável):");
        appsUso.forEach(System.out::println);

        // Referential transparency
        System.out.println("\n=== Referential transparency ===");
        boolean iguais = minutosParaHoras(appsUso).equals(minutosParaHoras(appsUso));
        System.out.println("Mesma entrada → mesma saida? " + iguais);

        // filter() → apps com mais de 1h
        List<AppHoras> acima1h = filtrarAcimaDe(dadosEmHoras, 1);
        System.out.println("\n=== Apps com mais de 1h de uso ===");
        acima1h.forEach(System.out::println);

        // Função de ordem superior: aplicar() + closure multiplicadora
        Function<AppHoras, AppHoras> dobrarTempo = criarMultiplicador(2);
        List<AppHoras> usoDobrado = aplicar(dadosEmHoras, dobrarTempo);
        System.out.println("\n=== Apos aplicar funcao multiplicadora (fator 2) ===");
        usoDobrado.forEach(System.out::println);

        // reduce() → total de horas
        double total = totalHoras(dadosEmHoras);
        System.out.println("\n=== Total de horas de uso (reduce) ===");
        System.out.println(total);

        // Verificação final: dados originais intactos
        System.out.println("\nVerificacao final: dados originais inalterados?");
        appsUso.forEach(System.out::println);
    }
}
