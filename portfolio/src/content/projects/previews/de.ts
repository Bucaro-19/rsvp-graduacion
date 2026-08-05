import thumbnailTempRace from "../../../assets/thumbnails/temprace.svg";
import thumbnailCubeWar from "../../../assets/thumbnails/cubewar.webp";
import thumbnailQuibbo from "../../../assets/thumbnails/quibbo.webp";
//import thumbnailParticles from "../../../assets/thumbnails/particles.webp";
import thumbnailPokedex from "../../../assets/thumbnails/pokedex.webp";
import thumbnailSharkie from "../../../assets/thumbnails/sharkie.webp";
import thumbnailStreakon from "../../../assets/thumbnails/streakon.webp";

import type { ProjectPreview } from "../../types";

export default [
  {
    title: "TempRace",
    slug: "temprace",
    thumbnail: thumbnailTempRace,
    description: "Juego de fiesta para iPhone en SwiftUI",
  },
  {
    title: "RSVP Graduacion",
    slug: "streakon",
    thumbnail: thumbnailStreakon,
    description: "Invitacion personalizada con confirmaciones",
  },
  {
    title: "Dashboard Invitados",
    slug: "cubewar",
    thumbnail: thumbnailCubeWar,
    description: "Panel privado para seguimiento de respuestas",
  },
  {
    title: "Flujo de Pagos",
    slug: "quibbo",
    thumbnail: thumbnailQuibbo,
    description: "Registro de aportes y metodos de pago",
  },
  {
    title: "Mensajes Automatizados",
    slug: "sharkie",
    thumbnail: thumbnailSharkie,
    description: "Copys listos para WhatsApp e invitados",
  },
  /**  {
    title: "WebGL Partikel",
    slug: "particles",
    thumbnail: thumbnailParticles,
    description: "Dynamische 3D Partikel",
  }, */
  {
    title: "Portafolio 2025",
    slug: "pokedex",
    thumbnail: thumbnailPokedex,
    description: "Sitio personal interactivo basado en Vue",
  },
] as const satisfies ProjectPreview[];
