export type TagVariant =
  | "three"
  | "websockets"
  | "react"
  | "redis"
  | "gray"
  | "html"
  | "css"
  | "javascript"
  | "node"
  | "php"
  | "mysql"
  | "tailwind"
  | "vue"
  | "typescript"
  | "next"
  | "kubernetes"
  | "postgresql"
  | "ogl"
  | "glsl"
  | "swift"
  | "swiftui"
  | "storekit";

export const tagLabels = {
  three: "Three.js",
  websockets: "WebSockets",
  react: "React",
  redis: "Redis",
  gray: "Gray",
  html: "HTML",
  css: "CSS",
  javascript: "JavaScript",
  node: "Node.js",
  php: "PHP",
  mysql: "MySQL",
  tailwind: "Tailwind",
  vue: "Vue",
  typescript: "TypeScript",
  next: "Next.js",
  kubernetes: "Kubernetes",
  postgresql: "PostgreSQL",
  ogl: "OGL.js",
  glsl: "GLSL",
  swift: "Swift",
  swiftui: "SwiftUI",
  storekit: "StoreKit 2",
} as const satisfies Record<TagVariant, string>;
