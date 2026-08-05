import type { ProjectContent } from "../../types";

export default {
  title: "TempRace",
  theme: "dark",
  tags: ["swift", "swiftui", "storekit"],
  videoBorder: false,
  description:
    "Un juego de fiesta para iPhone que se juega entre dos equipos en un solo telefono: alguien escribe cinco palabras contra reloj y el equipo rival tiene exactamente ese mismo tiempo para adivinarlas.<br/><br/>Esta hecho por completo en SwiftUI nativo, sin dependencias externas. Cada ilustracion —la mascota Tempo y sus siete expresiones, la ruleta, los globos flotantes— esta dibujada como codigo vectorial con Canvas y Shape, asi que se ve nitida a cualquier tamano y viaja sin archivos de imagen.<br/><br/>Incluye una capa Premium con StoreKit 2 (suscripcion mensual o pago unico), historial de partidas sincronizado por iCloud, una capa de audio que respeta el switch de silencio, y soporte completo para Reducir movimiento, Texto grande y modo oscuro.",
  components: [],
} as const satisfies ProjectContent;
