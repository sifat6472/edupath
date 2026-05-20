# 🤝 Contributing to EduPath

Welcome team! This document explains **exactly how to contribute** to EduPath without breaking the `main` branch.

> ⚠️ **GOLDEN RULE: Never push directly to `main`. Always work on your own branch and open a Pull Request.**

---

## 🌳 Branch Naming Convention

Use clear, descriptive branch names with these prefixes:

| Prefix | Use For | Example |
|--------|---------|---------|
| `feature/` | New features | `feature/scholarship-filter` |
| `fix/` | Bug fixes | `fix/login-validation` |
| `backend/` | Backend work | `backend/application-service` |
| `frontend/` | UI/styling work | `frontend/dashboard-cards` |
| `database/` | Schema/DB work | `database/add-reviews-table` |
| `docs/` | Documentation | `docs/update-readme` |

**Per-member suggested branches:**
- Sifat → `backend/api-integration`, `feature/*`
- Junayed → `backend/*`
- Shadik → `frontend/*`
- Juhaer → `frontend/*`
- Nirob → `database/*`

---

## 📋 Step-by-Step Workflow

### 1. Clone the repo (first time only)
```bash
git clone https://github.com/YOUR_USERNAME/edupath.git
cd edupath
```

### 2. Always start from an updated `main`
```bash
git checkout main
git pull origin main
```

### 3. Create your own branch
```bash
git checkout -b feature/your-feature-name
```

### 4. Make your changes
Edit code, test it locally:
```bash
php -S localhost:8000 -t public
```

### 5. Stage and commit your work
```bash
git add .
git commit -m "Add: clear description of what you did"
```

**Commit message format:**
- `Add: new feature` — for new functionality
- `Fix: bug description` — for bug fixes
- `Update: what changed` — for modifications
- `Refactor: what improved` — for code cleanup

### 6. Push your branch
```bash
git push origin feature/your-feature-name
```

### 7. Open a Pull Request (PR)
1. Go to the repo on GitHub
2. Click **"Compare & pull request"**
3. Add a clear title and description
4. Request a review from a teammate (preferably Nafis/Lead)
5. Wait for approval

### 8. After approval
The PR is merged into `main` by the reviewer. Then:
```bash
git checkout main
git pull origin main          # Get the merged changes
git branch -d feature/your-feature-name   # Delete local branch
```

---

## 🔄 Keeping Your Branch Updated

If `main` changes while you're working, sync your branch:
```bash
git checkout main
git pull origin main
git checkout feature/your-feature-name
git merge main
```

---

## ⚠️ Important Rules

1. ❌ **NEVER** commit directly to `main`
2. ❌ **NEVER** force-push to `main`
3. ✅ **ALWAYS** create a new branch for new work
4. ✅ **ALWAYS** test before pushing
5. ✅ **ALWAYS** write clear commit messages
6. ✅ **ALWAYS** get at least 1 review before merging
7. ✅ **Pull `main` regularly** to avoid conflicts

---

## 🆘 Resolving Merge Conflicts

If you see a conflict during merge:
1. Open the conflicted files (marked with `<<<<<<<`, `=======`, `>>>>>>>`)
2. Decide which code to keep
3. Remove the conflict markers
4. Save, then:
   ```bash
   git add .
   git commit -m "Resolve merge conflict"
   ```

Ask the team lead if unsure — never guess on conflicts.

---

## 📞 Questions?

Reach out to the team lead (Nafis) or post in the team group chat.

Happy coding! 🚀
