import thumbnailTempRace from "../../../assets/thumbnails/temprace.svg";
import thumbnailSmashGt from "../../../assets/thumbnails/smashgt.jpg";

import type { ProjectPreview } from "../../types";

export default [
  {
    title: "TempRace",
    slug: "temprace",
    thumbnail: thumbnailTempRace,
    description: "Party game for iPhone, native SwiftUI",
  },
  {
    title: "Smash GT",
    slug: "smashgt",
    thumbnail: thumbnailSmashGt,
    description: "Community ranking for Smash Ultimate in Guatemala",
  },
] as const satisfies ProjectPreview[];
