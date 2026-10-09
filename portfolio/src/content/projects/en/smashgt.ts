import type { ProjectContent } from "../../types";

export default {
  title: "Smash GT",
  theme: "dark",
  tags: ["php", "mysql", "javascript"],
  videoBorder: false,
  live: "https://rankingsmashbros.com",
  description:
    "A community ranking for Super Smash Bros. Ultimate players in Guatemala. Every week it collects the results of in-person tournaments from start.gg, rates players with a regularized Bradley-Terry model whose rules are published on the site, and publishes the new standings automatically.<br/><br/>Players sign in with their start.gg account to see their profile, tournament history and record against each rival. A supporter subscription adds a rival analysis built from real sets and games: who beats them, which characters work against their main, and how they play a set.",
  components: [
    {
      type: "list",
      props: {
        title: "What it does",
        items: [
          "Weekly ranking with public method, eligibility rules and every set that counted",
          "Accounts with start.gg sign-in, without storing passwords or tokens",
          "Profile, tournament history and head-to-head record for every player",
          "Rival analysis: win probability, counters, set patterns and common opponents",
          "Agenda of upcoming tournaments, with a near-me order computed on the device",
          "Subscriptions through a hosted payment page, with signed webhooks",
          "Private owner panel with visit statistics that never stores an IP address",
        ],
      },
    },
    {
      type: "list",
      props: {
        title: "How it is built",
        items: [
          "Python pipeline on GitHub Actions: capture, rating, validation and atomic publication",
          "PHP and MariaDB on shared hosting, with versioned migrations and a signed weekly import",
          "Plain HTML, CSS and JavaScript on the front end, with no framework or third-party scripts",
          "Automated tests on MySQL and MariaDB for the rating, the importers, the accounts and the payments",
        ],
      },
    },
  ],
} as const satisfies ProjectContent;
