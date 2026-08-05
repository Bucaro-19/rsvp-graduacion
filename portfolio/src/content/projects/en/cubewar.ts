import type { ProjectContent } from "../../types";

export default {
  title: "Guest Dashboard",
  theme: "dark",
  tags: ["php", "mysql", "javascript"],
  videoBorder: false,
  description:
    "A private panel for managing guests, reviewing confirmations, editing statuses, and copying personalized messages without leaving the dashboard.<br/><br/>The interface focuses on quick actions, scannable data, and simple tracking for pending, confirmed, and declined responses.",
  components: [],
} as const satisfies ProjectContent;
