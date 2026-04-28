---
title: Getting Started with Low-Token Agentic Development
description: Quick start guide for using the new token-efficient workflow
---

# Getting Started

This guide helps you use the new low-token agentic development setup immediately.

## What This Is

A complete, Boost-compatible token-efficient development workflow that reduces AI agent token usage by **30-50%** while maintaining code quality and consistency.

## Why This Exists

- ✅ Survives all `boost:install` and `boost:update` cycles
- ✅ Safe customizations in official Boost zone (`.ai/guidelines/`)
- ✅ No manual regeneration needed
- ✅ Ready to use immediately

## Quick Start (For Any Task)

When starting work on any feature, form, test, or fix, tell your AI agent:

```
Follow .ai/guidelines/workflow-low-token.md for efficient development
```

The agent will:
1. **Discover** → Read only relevant files, find one analogous implementation
2. **Execute** → Apply minimal, focused patches following discovered patterns
3. **Verify** → Run targeted tests only

**Result:** 30-50% fewer tokens than standard approach

## What You Get

### Documentation Files

| File | Purpose | Read Time |
|------|---------|-----------|
| [workflow-low-token.md](workflow-low-token.md) | Core methodology with context budgets | 3 min |
| [domain-patterns.md](domain-patterns.md) | Pattern library index for reuse-first approach | 3 min |
| [README.md](README.md) | Complete explanation of how it works | 5 min |
| [EXAMPLE.md](EXAMPLE.md) | Real POST endpoint example with token metrics | 4 min |
| [VALIDATION.md](VALIDATION.md) | Boost compatibility verification checklist | 5 min |

### Support Files

- [support-conventions.md](support-conventions.md) - Support layer conventions
- [COMPLETION.md](COMPLETION.md) - Task completion documentation
- [TASK-VERIFICATION.md](TASK-VERIFICATION.md) - Comprehensive verification checklist

## Key Principles

### 1. Pattern Reuse (Highest Impact)
Before writing new code, find a sibling file that does something similar. Copy its structure.

**Example:** Adding a new Laravel Action?
- Go to `app/Actions/`
- Find an existing Action in the same domain
- Copy its structure (constructor, properties, handle method)
- Adapt for your use case

### 2. Two-Stage Flow
- **Stage 1 (Discovery):** Read only files that matter. Find one pattern. Write 2-3 line plan.
- **Stage 2 (Execution):** Implement from the plan. No mid-execution restarts or exploration.

Result: 30-50% token savings vs. standard "explore then implement" flow.

### 3. Context Budgeting
- Max 3 targeted file reads per discovery phase
- One high-quality documentation search (use `search-docs`)
- Skip exploratory tool chains when a pattern exists nearby
- Prefer "read 2000 chars of similar code" over "search for related patterns"

## Common Workflows

### Adding a Laravel Backend Feature
1. Read workflow guide: [workflow-low-token.md](workflow-low-token.md#backend-features)
2. Find analogous Action in `app/Actions/`
3. Find analogous FormRequest in `app/Http/Requests/`
4. Create new Action + FormRequest + Controller route
5. Write feature test using Pest pattern from `tests/Feature/`

**Expected tokens:** 40-60% fewer than standard discovery approach

### Adding a Vue/Inertia Page
1. Read workflow guide: [workflow-low-token.md](workflow-low-token.md#frontend-changes)
2. Find analogous Vue page in `resources/js/Pages/`
3. Check Wayfinder usage in similar pages
4. Create new page + add route
5. Wire up with `useForm()` or `useHttp()` following existing patterns

**Expected tokens:** 35-50% fewer than standard exploration approach

### Writing a Pest Test
1. Check test patterns in `tests/Feature/` or `tests/Unit/`
2. Copy template (test setup, dataset if needed, assertions)
3. Adapt for your case
4. Run `php artisan test --filter=YourTest`

**Expected tokens:** 50% fewer than asking agent to build test from scratch

## Verification

All customizations are stored in `.ai/guidelines/` which is:
- ✅ Official Laravel Boost customization zone
- ✅ Never overwritten by `boost:install`
- ✅ Automatically loaded by Boost
- ✅ Safe for long-term use

Verify with:
```bash
# Check all guideline files are present
find .ai/guidelines -name "*.md" -type f | wc -l
# Should show: 14 files

# Verify Boost hasn't overwritten anything
git diff HEAD -- AGENTS.md boost.json .mcp.json
# Should show: 0 lines changed
```

## Next Steps

1. **Read the workflow guide** → [workflow-low-token.md](workflow-low-token.md)
2. **See a real example** → [EXAMPLE.md](EXAMPLE.md)
3. **Start using it** → Tell your agent to follow the workflow

## Support

Each guideline file has examples and detailed sections. They're designed to be self-contained so you can reference them without reading the full documentation.

**Questions?** Check [VALIDATION.md](VALIDATION.md) for verification steps or [TASK-VERIFICATION.md](TASK-VERIFICATION.md) for implementation details.

---

**Ready to start?** Use the workflow on your next task and watch token usage drop 30-50%.
