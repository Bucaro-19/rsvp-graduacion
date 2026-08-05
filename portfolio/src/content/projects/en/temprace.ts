import type { ProjectContent } from "../../types";

export default {
  title: "TempRace",
  theme: "dark",
  tags: ["swift", "swiftui", "storekit"],
  videoBorder: false,
  description:
    "A party game for iPhone played by two teams on a single phone: one player writes five words against the clock, and the rival team gets exactly the same amount of time to guess them.<br/><br/>Built entirely in native SwiftUI with no third-party dependencies. Every illustration — the Tempo mascot and its seven expressions, the roulette, the floating balloons — is drawn as vector code with Canvas and Shape, so it stays sharp at any size and ships without image assets.<br/><br/>It includes a Premium tier with StoreKit 2 (monthly subscription or lifetime purchase), match history synced through iCloud, an audio layer that respects the silent switch, and full support for Reduce Motion, Dynamic Type and dark mode.",
  components: [],
} as const satisfies ProjectContent;
