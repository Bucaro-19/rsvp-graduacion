export const social = [
  { url: "mailto:joseaurelioporras97@gmail.com", name: "mail" },
  { url: "https://github.com/joseaurelioporras", name: "github" },
  { url: "https://www.linkedin.com/in/joseaurelioporras/", name: "linkedin" },
] as const satisfies { url: string; name: "mail" | "github" | "instagram" | "linkedin" | "x" }[];
