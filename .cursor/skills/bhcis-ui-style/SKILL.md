---
name: bhcis-ui-style
description: BHCIS Sta. Ana frontend style guide. Use when adding or changing UI (Blade views, forms, buttons, tables, login, dashboard). Ensures typography, colors, motion, and layout stay consistent with the established "clinical warmth" design system.
---

# BHCIS UI Style Guide

Apply this guide whenever creating or editing frontend views so the app stays visually consistent.

## Design direction

- **Tone**: Refined, calm, editorial — "clinical warmth." Trustworthy healthcare without cold hospital feel.
- **Avoid**: Generic AI look (Inter, Roboto, Arial; purple/sky gradients on white; evenly distributed timid palettes).

## Typography

- **Display (headings)**: Fraunces — `font-display` or `font-family: var(--font-display);`
- **Body**: Source Sans 3 — `font-sans` or default in layout
- **Page titles**: `class="font-display font-semibold text-2xl lg:text-3xl"` with `style="color: var(--ink);"`
- **Subtitles / descriptions**: `class="text-sm mt-1"` with `style="color: var(--ink-muted);"`

Do not introduce Inter, Roboto, Arial, or system-ui as primary fonts.

## Colors (CSS variables)

Use variables from `resources/views/layouts/app.blade.php`; do not hardcode hex/rgb for brand or UI.

| Variable | Use |
|----------|-----|
| `--bg-page` | Page background (warm cream) |
| `--bg-surface` | Cards, form areas, secondary panels |
| `--bg-surface-elevated` | Tables, dropdowns, modals |
| `--ink` | Primary text, headings |
| `--ink-muted` | Secondary text, labels |
| `--ink-subtle` | Hints, placeholders |
| `--border` | Dividers, input borders |
| `--primary` | Links, primary actions, teal accent (trust) |
| `--accent` | Main CTAs: Register, Sign in, Logout (terracotta) |
| `--teal-soft` | Soft teal fill (badges, table header, summary strips) |
| `--accent-soft` | Soft accent fill (e.g. referred status) |
| `--shadow-sm`, `--shadow-md`, `--shadow-lg` | Elevation |

**Primary actions**: `style="background: var(--accent);"` for buttons like "Register", "Sign in".  
**Secondary / neutral actions**: `style="background: var(--primary);"` for "Search", "Apply", "View".

## Motion

- **Page / section entrance**: `class="animate-in opacity-0"`; add `delay-1` … `delay-6` for staggered items (see layout).
- **Hover**: Prefer `transition-colors`, `transition-all duration-200`, or `hover:scale-[1.01]` / `hover:shadow-md` on cards.
- **Easing**: `cubic-bezier(0.4, 0, 0.2, 1)` (layout defines `--transition`).

## Backgrounds

- **Page**: Layout provides grain overlay (`.grain`) and a soft gradient; main content sits in a rounded card with `--bg-surface-elevated` and light shadow.
- **Cards / panels**: `style="background: var(--bg-surface); border-color: var(--border);"` with `rounded-xl` and optional `border`.

## Components (patterns)

- **Primary button**: `class="... rounded-xl text-white font-semibold text-sm transition ..."` + `style="background: var(--accent);"` (and optional `box-shadow`).
- **Inputs**: `class="... rounded-lg border ... focus:outline-none focus:ring-2 transition"` + `style="border-color: var(--border); color: var(--ink); --tw-ring-color: var(--primary);"`.
- **Labels**: `style="color: var(--ink-muted);"` with `class="text-xs font-medium mb-1"` (or similar).
- **Status badges**: Completed → `style="background: var(--teal-soft); color: var(--primary);"`. Referred / warning → `style="background: var(--accent-soft); color: var(--accent);"`. Neutral → `style="background: rgba(0,0,0,0.06); color: var(--ink-muted);"`.
- **Table header**: `style="background: var(--teal-soft);"`; header cells `style="color: var(--ink-muted);"`.
- **Links in content**: `style="color: var(--primary);"` with `hover:underline` or `transition hover:underline`.

## Layout

- Content lives inside the main layout card; use `@extends('layouts.app')` and `@section('content')`.
- Page structure: optional title block (font-display + subtitle), then sections with consistent `space-y-5 lg:space-y-6`.

## Source of truth

- **Variables and motion**: `resources/views/layouts/app.blade.php` (`:root` and `<style>`).
- **Standalone pages** (e.g. login): Mirror the same `:root` variables, fonts, grain, and button/input patterns in that file.

## Checklist for new or edited views

- [ ] Headings use `font-display` and `var(--ink)`.
- [ ] Body/secondary text use `var(--ink-muted)` or `var(--ink-subtle)`.
- [ ] Buttons use `var(--accent)` or `var(--primary)` (no raw sky/emerald/purple).
- [ ] Inputs and borders use `var(--border)` and focus ring `var(--primary)`.
- [ ] Cards/panels use `var(--bg-surface)` or `var(--bg-surface-elevated)` and `var(--border)`.
- [ ] No new font families unless they match this direction; no Inter/Roboto/Arial as primary.
