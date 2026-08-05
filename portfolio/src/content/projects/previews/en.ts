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
    description: "Party game for iPhone, native SwiftUI",
  },
  {
    title: "Graduation RSVP",
    slug: "streakon",
    thumbnail: thumbnailStreakon,
    description: "Personal invitation with confirmations",
  },
  {
    title: "Guest Dashboard",
    slug: "cubewar",
    thumbnail: thumbnailCubeWar,
    description: "Private response tracking panel",
  },
  {
    title: "Payment Flow",
    slug: "quibbo",
    thumbnail: thumbnailQuibbo,
    description: "Gift contributions and payment methods",
  },
  {
    title: "Message Automation",
    slug: "sharkie",
    thumbnail: thumbnailSharkie,
    description: "Ready-to-send WhatsApp invitation copy",
  },
  /**  {
    title: "WebGL Particles",
    slug: "particles",
    thumbnail: thumbnailParticles,
    description: "Dynamic 3D particles",
  }, */
  {
    title: "Portfolio 2025",
    slug: "pokedex",
    thumbnail: thumbnailPokedex,
    description: "Interactive personal site based on Vue",
  },
] as const satisfies ProjectPreview[];
