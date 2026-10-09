import type { ProjectContent } from "../../types";

export default {
  title: "Smash GT",
  theme: "dark",
  tags: ["php", "mysql", "javascript"],
  videoBorder: false,
  live: "https://rankingsmashbros.com",
  description:
    "Un ranking de la comunidad para jugadores de Super Smash Bros. Ultimate en Guatemala. Cada semana recoge los resultados de torneos presenciales desde start.gg, califica a los jugadores con un modelo Bradley-Terry regularizado cuyas reglas estan publicadas en el sitio, y publica las posiciones nuevas de forma automatica.<br/><br/>Los jugadores entran con su cuenta de start.gg para ver su perfil, su historial de torneos y su record contra cada rival. Una suscripcion de apoyo agrega un analisis de rival hecho con sets y games reales: quien le gana, que personajes funcionan contra su main y como juega un set.",
  components: [
    {
      type: "list",
      props: {
        title: "Que hace",
        items: [
          "Ranking semanal con metodo publico, reglas de elegibilidad y cada set que conto",
          "Cuentas con inicio de sesion de start.gg, sin guardar claves ni tokens",
          "Perfil, historial de torneos y record cara a cara de cada jugador",
          "Analisis de rival: probabilidad, counters, patrones del set y rivales en comun",
          "Agenda de torneos por venir, con orden por cercania calculado en el dispositivo",
          "Suscripciones con pagina de pago externa y avisos firmados",
          "Panel privado del propietario con visitas, sin guardar direcciones IP",
        ],
      },
    },
    {
      type: "list",
      props: {
        title: "Como esta hecho",
        items: [
          "Flujo en Python sobre GitHub Actions: captura, calculo, validacion y publicacion atomica",
          "PHP y MariaDB en hosting compartido, con migraciones versionadas y carga semanal firmada",
          "HTML, CSS y JavaScript sin framework ni scripts de terceros en el sitio",
          "Pruebas automaticas en MySQL y MariaDB para el calculo, los importadores, las cuentas y los pagos",
        ],
      },
    },
  ],
} as const satisfies ProjectContent;
