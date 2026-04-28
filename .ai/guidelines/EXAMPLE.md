---
description: Example workflow showing how to use the low-token setup
---

# Example: Implementing a Feature with Low-Token Workflow

## Scenario
You want to create a new API endpoint to fetch user articles with validation and resource serialization.

## Using the Setup

### Step 1: Invoke with the Workflow
```
"Create an endpoint POST /api/articles with title/body validation and ArticleResource.
Follow .ai/guidelines/workflow-low-token.md for efficiency."
```

### Step 2: Agent Executes Two-Stage Flow

**Discovery Stage (No edits yet):**
```
1. Read existing patterns:
   - app/Http/Controllers/ArticleController.php (similar endpoint)
   - app/Http/Requests/StoreArticleRequest.php (validation pattern)
   - app/Http/Resources/ArticleResource.php (serialization pattern)

2. Find one analogue:
   - UserController::store() with StoreUserRequest

3. Plan:
   - Create StoreArticleRequest (copy pattern from StoreUserRequest)
   - Create ArticleResource (copy pattern from UserResource)
   - Update ArticleController::store() (follow existing methods)
   - Create ArticleTest::testCanStoreArticle() (minimal test)
```

**Execution Stage (Minimal patches):**
```
- Create StoreArticleRequest (follow discovered pattern)
- Create ArticleResource (follow discovered pattern)
- Add handle() method to ArticleController
- Add test (follow existing test structure)
```

**Verification Stage (Focused tests):**
```bash
php artisan test --compact --filter=ArticleTest
```

### Step 3: Result

✅ Endpoint implemented in ~50% fewer tokens than standard approach
✅ Follows existing project patterns exactly
✅ Minimal code, maximum reuse
✅ Only relevant tests executed

## Token Savings Example

| Task | Standard | With Workflow | Savings |
|------|----------|---------------|---------|
| Explore patterns | 3 full-file reads | 1 focused read + 1 analogue search | 60% |
| Implement | Multiple edits, full-file checks | Minimal patches only | 30% |
| Test | Full test suite | `--compact --filter=Article` | 80% |
| **Total** | ~2000 tokens | ~1200 tokens | **40%** |

## Key Principles Applied

1. **Discovery First**: Find the pattern before building
2. **One Analogue**: Only need one similar implementation
3. **Minimal Patches**: Apply smallest possible changes
4. **Focused Testing**: Run only affected tests
5. **No Re-exploration**: Once pattern is found, stop searching

---

See `.ai/guidelines/workflow-low-token.md` for the complete workflow.
