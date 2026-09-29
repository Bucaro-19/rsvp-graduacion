import thumbnailTempRace from "../../../assets/thumbnails/temprace.svg";

import type { ProjectPreview } from "../../types";

export default [
  {
    title: "TempRace",
    slug: "temprace",
    thumbnail: thumbnailTempRace,
    description: "Juego de fiesta para iPhone en SwiftUI",
  },
] as const satisfies ProjectPreview[];
