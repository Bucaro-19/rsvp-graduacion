import thumbnailTempRace from "../../../assets/thumbnails/temprace.svg";

import type { ProjectPreview } from "../../types";

export default [
  {
    title: "TempRace",
    slug: "temprace",
    thumbnail: thumbnailTempRace,
    description: "Party game for iPhone, native SwiftUI",
  },
] as const satisfies ProjectPreview[];
