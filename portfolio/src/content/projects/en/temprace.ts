import type { ProjectContent } from "../../types";

export default {
  title: "TempRace",
  theme: "dark",
  tags: ["swift", "swiftui", "storekit"],
  videoBorder: false,
  description:
    "A party game for iPhone played by two teams on a single phone: one player writes five words against the clock, and the rival team gets exactly the same amount of time to guess them.<br/><br/>Built entirely in native SwiftUI with no third-party dependencies. Every illustration — the Tempo mascot and its seven expressions, the roulette, the floating balloons — is drawn as vector code with Canvas and Shape, so it stays sharp at any size and ships without image assets.<br/><br/>It includes a Premium tier with StoreKit 2 (monthly subscription or lifetime purchase), match history synced through iCloud, an audio layer that respects the silent switch, and full support for Reduce Motion, Dynamic Type and dark mode.",
  components: [
    {
      type: "list",
      props: {
        title: "What it does",
        items: [
          "Two teams on a single phone: a roulette picks who plays, the clock runs and the rival team guesses",
          "Interactive how-to-play guide on the home screen, with examples of the whole flow",
          "Premium tier with StoreKit 2: monthly subscription or lifetime purchase, with purchase restore",
          "Match history with scores and points per player, synced through the player's own iCloud",
          "Works fully offline; the free version shows non-personalized ads and Premium shows none",
          "Light and dark theme, haptics, Reduce Motion and Dynamic Type support",
        ],
      },
    },
    {
      type: "list",
      props: {
        title: "How it is built",
        items: [
          "Native SwiftUI for iPhone, with no third-party dependencies in the game itself",
          "Mascot, roulette and balloons drawn as vector code with Canvas and Shape, with no image assets",
          "StoreKit 2 for purchases and subscriptions, and iCloud for history sync",
          "Google AdMob in the free version only, always non-personalized and without tracking permission",
          "No analytics, no accounts and no personal data collected; privacy policy and support page published in English and Spanish",
        ],
      },
    },
  ],
} as const satisfies ProjectContent;
