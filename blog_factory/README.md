# AppVerra Blog Factory

Zero-cost automated blog publishing pipeline. Uses Claude Code (your subscription) as the agent runtime, Git as the queue, Hostinger auto-pull as the delivery layer.

## How it works

```
You type:                          /publish-blog "react native testing tools"

Claude Code runs 5 agents:         researcher → keyword strategist
                                     → drafter → seo packager → editor

If editor passes:                  writes markdown + image to queue/pending/
                                     git add → commit → push to GitHub

Hostinger auto-pulls (~30 sec):    files appear on live server

You visit:                         https://appverra.co/admin/import-pending
                                     click Import → post inserted as draft

You open in admin:                 review → hit Publish → live at appverra.co/<slug>
```

Total cost per post: **$0**. Total time: **~10 minutes**, mostly waiting.

## One-time setup

1. **Sign up for Unsplash API** (2 min, free): https://unsplash.com/developers
2. **Copy `.env.example` to `.env`** and paste your Unsplash key
3. **Delete the `olor` lorem-ipsum post** in `/admin/posts/` (one click, one time)

The 5 subagent files and the `/publish-blog` slash command live in your `~/.claude/` config — not in this repo, since they're part of your Claude Code setup.

## Daily use

```
# In Claude Code, with the appverra repo open:
/publish-blog "your topic here"

# Or, pick from the topic backlog:
/publish-blog
```

The agents run, you watch progress, the markdown file lands in `queue/pending/<slug>.md`. Then visit `/admin/import-pending` on the live site to import it.

## File layout

```
blog_factory/
├── voice/
│   ├── style_guide.md      ← drafter reads this every run
│   └── examples/           ← 2 existing posts as voice anchors
├── queue/
│   ├── topics.yaml         ← backlog of starter topics
│   ├── pending/            ← drafts waiting for import (and images/)
│   └── imported/           ← archived markdown after import
├── .env.example
└── README.md
```

## Safety rails

- Bot writes only drafts — never auto-publishes. You're always in the loop.
- Editor agent hard-fails on: word count out of range, missing FAQ, dead citations, slug collisions, voice red flags.
- Pending drafts on the server are blocked from public web access via `.htaccess`.
- HTML sanitized twice: once by drafter prompt discipline, once server-side by `post_sanitize_html()`.
