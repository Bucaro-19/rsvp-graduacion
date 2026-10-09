import thumbnailTempRace from "../../../assets/thumbnails/temprace.svg";
import thumbnailSmashGt from "../../../assets/thumbnails/smashgt.jpg";

import type { ProjectPreview } from "../../types";

export default [
  {
    title: "TempRace",
    slug: "temprace",
    thumbnail: thumbnailTempRace,
    description: "Juego de fiesta para iPhone en SwiftUI",
  },
  {
    title: "Smash GT",
    slug: "smashgt",
    thumbnail: thumbnailSmashGt,
    description: "Ranking de la comunidad de Smash Ultimate en Guatemala",
  },
] as const satisfies ProjectPreview[];
