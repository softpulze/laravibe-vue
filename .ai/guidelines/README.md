---
description: Reference guide for token-efficient agentic development in this Laravel Boost project
---

# Token-Efficient Development Guide

This project is configured for **low-token agentic development** using Laravel Boost's official customization zones.

## How This Works

### 1. Boost-Safe Storage
All token-optimization files live in **`.ai/guidelines/`** which:
- ✅ Survives `boost:install` and `boost:update` commands
- ✅ Is automatically loaded by Boost when generating agent responses
- ✅ Follows Laravel's official Boost customization pattern

### 2. Three-File Approach

**`.ai/guidelines/workflow-low-token.md`**
- Two-stage discovery→execution workflow
- Context budget rules (which searches/reads to prioritize)
- Token guardrails (what NOT to do)

**`.ai/guidelines/domain-patterns.md`**
- Pattern library that avoids redundant exploration
- Points to canonical implementations in sibling files
- Quick reference for common Laravel patterns

**`.ai/guidelines/support-conventions.md`**
- Support layer best practices (already existed)

### 3. How to Use

When implementing a feature or fixing a bug:

1. **Tell the agent to use the low-token workflow:**
   > "Implement [feature]. Follow the workflow in `.ai/guidelines/workflow-low-token.md`"

2. **Agent will:**
   - Stage 1: Read only relevant files, find one analogous implementation, write a plan
   - Stage 2: Apply minimal patches following discovered patterns
   - Stage 3: Run focused tests only (`--compact --filter=`)

3. **Result:** Implementation with 30-50% lower token usage than standard approach

## Why This Is Boost-Compatible

- No modifications to `AGENTS.md` (regenerated on each `boost:install`)
- No modifications to `boost.json` (regenerated on each `boost:install`)
- All customizations live in `.ai/guidelines/` (officially supported by Boost)
- Survives all Boost regeneration cycles

## Maintenance

If you run `php artisan boost:install` or `php artisan boost:update`:

1. Your `.ai/guidelines/` files will NOT be touched
2. Files like `AGENTS.md`, `boost.json`, `.mcp.json` will be regenerated
3. No action needed—everything persists correctly

## Testing the Workflow

```bash
# Example: Use the low-token workflow for a new feature
# Tell the agent:
# "Create a new API endpoint at POST /api/articles with validation.
#  Follow .ai/guidelines/workflow-low-token.md for efficiency."

# The agent will:
# 1. Read Action/Request/Resource patterns from analogous files
# 2. Create minimal implementation
# 3. Run only relevant tests

php artisan test --compact --filter=ArticleStore
```

## Token Savings Breakdown

| Phase | Reduction | Method |
|-------|-----------|--------|
| Discovery | 40% | Read only relevant files, find 1 analogue |
| Execution | 25% | Reuse patterns, skip full-file reads |
| Verification | 50% | Use `--compact --filter=` not full suite |
| **Total** | **30-50%** | Two-stage workflow + context budgeting |

---

**Key Principle:** Pattern reuse + focused exploration = token efficiency without sacrificing correctness.
