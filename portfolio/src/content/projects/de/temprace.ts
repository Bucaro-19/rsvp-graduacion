import type { ProjectContent } from "../../types";

export default {
  title: "TempRace",
  theme: "dark",
  tags: ["swift", "swiftui", "storekit"],
  videoBorder: false,
  description:
    "Un juego de fiesta para iPhone que se juega entre dos equipos en un solo telefono: alguien escribe cinco palabras contra reloj y el equipo rival tiene exactamente ese mismo tiempo para adivinarlas.<br/><br/>Esta hecho por completo en SwiftUI nativo, sin dependencias externas. Cada ilustracion —la mascota Tempo y sus siete expresiones, la ruleta, los globos flotantes— esta dibujada como codigo vectorial con Canvas y Shape, asi que se ve nitida a cualquier tamano y viaja sin archivos de imagen.<br/><br/>Incluye una capa Premium con StoreKit 2 (suscripcion mensual o pago unico), historial de partidas sincronizado por iCloud, una capa de audio que respeta el switch de silencio, y soporte completo para Reducir movimiento, Texto grande y modo oscuro.",
  components: [
    {
      type: "list",
      props: {
        title: "Que hace",
        items: [
          "Dos equipos en un solo telefono: una ruleta elige quien juega, corre el reloj y el equipo rival adivina",
          "Guia interactiva de como jugar en la pantalla de inicio, con ejemplos de todo el flujo",
          "Capa Premium con StoreKit 2: suscripcion mensual o pago unico, con restauracion de compras",
          "Historial de partidas con puntajes y puntos por jugador, sincronizado por el iCloud de cada persona",
          "Funciona completamente sin internet; la version gratis muestra anuncios no personalizados y Premium no muestra ninguno",
          "Tema claro y oscuro, vibracion tactil, y soporte para Reducir movimiento y Texto grande",
        ],
      },
    },
    {
      type: "list",
      props: {
        title: "Como esta hecho",
        items: [
          "SwiftUI nativo para iPhone, sin dependencias externas en el juego",
          "Mascota, ruleta y globos dibujados como codigo vectorial con Canvas y Shape, sin archivos de imagen",
          "StoreKit 2 para compras y suscripciones, e iCloud para sincronizar el historial",
          "Google AdMob solo en la version gratis, siempre no personalizado y sin pedir permiso de rastreo",
          "Sin analiticas, sin cuentas y sin datos personales; politica de privacidad y pagina de soporte publicadas en ingles y espanol",
        ],
      },
    },
  ],
} as const satisfies ProjectContent;
