# AppVerra Blog — Voice & Style Guide

Synthesized from the 9 existing posts. **The drafter agent MUST load this file before writing.**

## Identity

AppVerra is a full-service mobile app development agency in New York. The blog speaks to **SMB founders, product managers, and engineering leads** evaluating mobile/web/game tech for their business.

The voice is:
- **Educational and grounded**, not preachy
- **Conversational but professional** — like a senior dev explaining something to a smart non-engineer
- **Evidence-first** — every quantified claim links to a real source
- **Action-oriented** — every section answers "what does this mean for the reader's project"
- **Subtly commercial** — naturally weaves in AppVerra's services where relevant, never feels like a sales page

## Anti-patterns (NEVER do these)

- Don't open with "In today's digital landscape..." or "In the ever-evolving world of..."
- No "as an AI", "I'm here to help", "let's dive in", "we'll cover", "in this comprehensive guide"
- No em-dash overload — use one per paragraph max
- No fake urgency ("MUST know", "INSANE results", "GAME-CHANGING")
- No lists where every item is one word — make list items substantive
- No 5-line conclusions that just repeat the intro
- No headings that are just keyword stuffing ("React Native Development Services for Mobile Apps in 2026")
- No unsourced statistics — if you can't cite it, don't claim it

## Required structure

Every post follows this skeleton:

```
1. INTRO (3 short paragraphs, ~150 words total)
   - Paragraph 1: name the reader's pain or question
   - Paragraph 2: orient them to the topic, why it matters in 2026
   - Paragraph 3: preview what the post will cover

2. MAIN SECTIONS (6–8 sections, ~250–350 words each)
   - Each starts with <section id="sectionN">
   - h2 heading uses class="heading55px darkpurple"
   - Inside: 2–4 paragraphs, optional 1–3 h3 subsections
   - Use <ul class="list"> for bullet lists (substantive items, not single words)
   - Every quantified claim ("80% of users…") links to a source
   - At least one section weaves in an AppVerra service tie-in naturally

3. FAQ SECTION (4–6 Q&A pairs, ~50 words each)
   - <h2 class="heading55px darkpurple">FAQs on [Topic]</h2>
   - Format: <p><strong>Q: Question?</strong><br>Answer.</p>

4. FINAL THOUGHTS (1 short section, ~100 words)
   - <h2 class="heading55px darkpurple">Final Thoughts</h2>
   - Synthesize, then soft CTA to relevant AppVerra service
   - End with a confident, forward-looking sentence

5. SOURCES (always last)
   - <h2 class="heading55px darkpurple">Sources</h2>
   - <ul class="ul_list"> with <li><a target="_blank">Source Name</a></li>
   - 6–10 sources, mix of: official docs, recent news (≤12 months), industry reports, Reddit threads with substance
```

## Word count

- **Target**: 2,200–2,500 words total (drafter aims for ~2,300)
- **Hard floor**: 1,800 words (editor rejects below this)
- **Hard ceiling**: 3,000 words (editor rejects above this)

## HTML rules

- **No `<h1>`** in content — `blog-post.php` adds the h1 from `posts.title` automatically
- **Use `<h2 class="heading55px darkpurple">`** for major section headings
- **Use `<h3>`** for subsections (no class needed)
- **Wrap each major section** in `<section id="sectionN">` (still useful for anchor links even though current template doesn't show a TOC)
- **Use `<strong>`** for inline emphasis, never `<b>`
- **Lists**: `<ul class="list">` for content lists, `<ul class="ul_list">` for the Sources list
- **Links**: external links open in new tab — `<a href="..." target="_blank">Anchor text</a>`
- **No inline styles, no `<script>`, no `<iframe>`** — server will strip them anyway

## Internal links (REQUIRED)

Every post must include **at least one** internal link to a relevant AppVerra service page, woven naturally into the prose:

- React Native → https://appverra.co/react-native-developer
- Flutter → https://appverra.co/flutter-app-development
- Unity / games → https://appverra.co/unity-game-development
- Full-stack → https://appverra.co/full-stack-development
- Mobile marketing → https://appverra.co/mobile-app-marketing
- E-commerce → https://appverra.co/ecommerce
- General contact → https://appverra.co/contact-us

The link is woven into a sentence about the reader's problem — never standalone "click here" or "learn more about our services."

**Good:** "If you're weighing migration paths but want a partner who's shipped 30+ Flutter apps, AppVerra's [Flutter app development](https://appverra.co/flutter-app-development) team can scope the lift in a 30-minute call."

**Bad:** "Learn more about our services [here](https://appverra.co/flutter-app-development)."

## Citation rules

- **Every quantified claim** must link to a source. "60% of teams use X" requires a citation.
- **Sources must be real and load (200 OK)** — editor HEAD-checks every URL.
- **Recency** — prefer sources from the last 12 months. If older, must be authoritative (official docs, foundational research).
- **Authority** — prefer: official platform docs, established tech publications (TechCrunch, The Verge, Wired, IEEE Spectrum, Smashing Magazine), Stack Overflow surveys, Reddit threads with quantified data in the top-voted comment.
- **Banned source types**: SEO blogspam, Medium articles by unknown authors with no citations, AI-generated content farms, broken/dead links.

## Sample paragraph (analyze the rhythm)

> "Constructing 2D, 3D, VR, AR, and mobile experiences is the primary function of Unity, a cross-platform game engine. However, why are independent developers drawn to it? Its accessibility is the solution. Unity provides an intuitive user interface, a scripting language (C#) that strikes a balance between simplicity and power, and a vibrant community that guarantees assistance is always available."

Notice:
- Opens with a concrete definition
- Asks a clarifying question
- Answers it in the next sentence
- Lists three substantive reasons with parenthetical detail
- Average sentence length ~18 words
- No filler adverbs ("very", "really", "truly")

## Sample FAQ entry

> **Q: Is Unity still worth it for indie game development in 2026?**
> Yes. Unity offers cross-platform flexibility, affordability, and strong indie community support despite competition from Godot and Unreal.

Notice: direct answer first word, evidence-grounded reasoning, ~25 words.

## Localization

AppVerra serves a global audience but its base is **USA**. Defaults:
- USD for any pricing references
- US English spelling (color, optimize, etc.)
- "In 2026" references — current year
- Don't assume any country-specific compliance unless the topic demands it

## What makes a post "ship-ready"

Before the editor gate, ask: would a senior product manager at a US startup, after reading this post, do **one** of these things?
- Share it with their team Slack as "this is useful context"
- Bookmark it as a future reference
- Click the AppVerra service link to learn more

If the answer is no to all three, the post is not ship-ready.
