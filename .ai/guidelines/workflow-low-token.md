# Low-Token Agentic Workflow

**Use this guide when working on implementation tasks to minimize token usage while maintaining correctness.**

## Two-Stage Execution

### Stage 1: Discovery (No Edits)
- Read only files **directly relevant** to the task
- Find **one analogous implementation** in the same domain
- Write a **short plan** with exact files and test commands before editing

### Stage 2: Execution
- Apply **minimal patch set** following discovered patterns
- Stop broad exploration once execution starts
- Reuse existing helpers/components before creating new abstractions

## Context Budget Rules

| Pattern | Do | Don't |
|---------|-----|--------|
| **File reads** | Targeted line ranges `read_file(1-30)` | Full-file reads unless necessary |
| **Searches** | One high-quality `grep_search` | Multiple speculative searches |
| **Docs** | `search-docs` once with broad query | Repeat equivalent doc searches |
| **Skills** | Activate only relevant skill | Load all skills upfront |
| **Scope** | Load only relevant `.ai/guidelines/*` | Import unrelated conventions |

## Verification Protocol

1. Run **only** tests impacted by your change:
   ```bash
   php artisan test --compact --filter=ChangedBehavior
   ```

2. Report: changed files, test command, test results

3. If behavior is untested → state the gap and propose smallest new test

## Pattern Library (Search Before Building)

Before writing new code:

1. Check sibling files for the pattern
2. Check related domain files (e.g., other Actions, other Resources)
3. Reuse or lightly adapt the pattern
4. Only create new abstraction if pattern appears 3+ times

## Token Guardrails (Non-Negotiable)

- ❌ Do NOT re-read files already understood unless content changed
- ❌ Do NOT run full test suite—use `--compact --filter=`
- ❌ Do NOT skip the discovery plan phase
- ❌ Do NOT create documentation files outside `.ai/guidelines/`
- ❌ Do NOT modify regenerated files (AGENTS.md, boost.json, .mcp.json)

## Quick Reference

```
Discovery → Plan → Execute (minimal patches) → Verify (focused tests)
```

Keep token spend visible in your working notes. Escalate only with one clear blocking question.
