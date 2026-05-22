# CodeIgniter 3.1.13 Quick Start Testing Guide
## CMS Sekolahku v2.4.13

**Update Status:** ✅ COMPLETE  
**Date:** May 11, 2026  
**Framework:** CodeIgniter 3.1.13 (Latest Stable v3)

---

## 🚀 Quick Start (5 Minutes)

### Step 1: Verify Update Installation
```bash
# Navigate to project directory
cd /Users/lukmanhakim/Documents/percobaan/cms-sekolahku-v2.4.13

# List system components
ls -la system/
ls -la application/
ls -la views/

# Should see:
# ✓ system/              - Updated CI 3.1.13 files
# ✓ application/         - All custom CMS code intact
# ✓ views/               - All templates intact
# ✓ system.backup.*/     - Original backup (safe to delete after testing)
```

### Step 2: Database Setup (One-time)
```bash
# Ensure database exists
mysql -u root -p -e "CREATE DATABASE IF NOT EXISTS db_cms_sekolahku;"

# Import schema (if needed)
mysql -u root -p db_cms_sekolahku < db_cms_sekolahku.sql
```

### Step 3: Verify Permissions
```bash
# Check writable directories
ls -la application/logs/           # Should be writable
ls -la application/cache/          # Should be writable
ls -la media_library/              # Should be writable

# If not writable, fix:
chmod 755 application/logs/
chmod 755 application/cache/
chmod 755 media_library/
```

### Step 4: Start Local Server
```bash
# Using built-in PHP server
cd /Users/lukmanhakim/Documents/percobaan/cms-sekolahku-v2.4.13
php -S localhost:8080

# OR using Apache (if configured)
# Access: http://localhost/cmssekolahku

# Output should show:
# [timestamp] PHP Development Server started at http://localhost:8080
```

### Step 5: Access Application
```
Open browser to:
✓ Homepage:     http://localhost:8080
✓ Login:        http://localhost:8080/login
✓ Dashboard:    http://localhost:8080/dashboard (after login)
```

---

## 🧪 Basic Testing (15 Minutes)

### Test 1: Homepage Load
```
URL: http://localhost:8080
Expected: 
  ✓ Page loads without errors
  ✓ All assets load (CSS, JS, images)
  ✓ Layout renders correctly
  ✓ Navigation menus visible
```

### Test 2: Login Functionality
```
URL: http://localhost:8080/login
Credentials (default):
  Username: administrator
  Password: administrator

Expected:
  ✓ Login form renders
  ✓ Credentials accepted
  ✓ Session created
  ✓ Redirected to dashboard
```

### Test 3: Dashboard Access
```
URL: http://localhost:8080/dashboard
Expected:
  ✓ Dashboard loads
  ✓ Widgets display correctly
  ✓ Database data appears
  ✓ Navigation menu functional
```

### Test 4: Check Logs
```bash
# View error logs
tail -50 application/logs/log-*.php

# Should be clean or show only info messages
# NO critical errors expected
```

### Test 5: Database Connection
```
From Dashboard:
  ✓ User list loads
  ✓ Posts list loads
  ✓ Settings load
  ✓ No "database connection" errors
```

---

## 🔍 Detailed Testing (1-2 Hours)

### Phase 1: Core Framework
```javascript
// Test Framework Loading
- [ ] index.php executes without errors
- [ ] BASE constants defined correctly
- [ ] System files load successfully
- [ ] Autoloader working
```

### Phase 2: Routing & Controllers
```javascript
// Test URL Routing
- [ ] Direct route access works
- [ ] Custom routes functional
- [ ] 404 handling works
- [ ] Parameter passing works

Examples to test:
- http://localhost:8080/home
- http://localhost:8080/login
- http://localhost:8080/dashboard
- http://localhost:8080/nonexistent (404)
```

### Phase 3: Views & Templates
```javascript
// Test View Rendering
- [ ] Views render without errors
- [ ] Template inheritance works
- [ ] Partial views load
- [ ] Variables pass correctly
- [ ] All CSS classes apply
```

### Phase 4: Database Operations
```javascript
// Test Database Access
- [ ] SELECT queries work
- [ ] INSERT operations successful
- [ ] UPDATE operations successful
- [ ] DELETE operations safe
- [ ] Query builder functional
```

### Phase 5: Session & Authentication
```javascript
// Test Session Management
- [ ] Session starts on login
- [ ] Session persists across requests
- [ ] Session data accessible
- [ ] Logout clears session
- [ ] Login check prevents unauthorized access
```

### Phase 6: Forms & Validation
```javascript
// Test Form Processing
- [ ] Form validation rules apply
- [ ] Error messages display
- [ ] Successful submissions process
- [ ] File uploads work (if used)
- [ ] XSS protection active
```

---

## ⚠️ Common Issues & Solutions

### Issue: "Application folder path not correct"
```
Cause: system folder not found or misconfigured
Fix: Verify system/ folder exists and has correct permissions
  chmod 755 system/
```

### Issue: "Database connection error"
```
Cause: database.php credentials incorrect
Fix: 
  1. Check database exists: mysql -u root -p -e "SHOW DATABASES;"
  2. Update application/config/database.php with correct credentials
  3. Verify MySQL service running
```

### Issue: "No suitable wrapper could be found"
```
Cause: PHP stream wrapper issue
Fix: Usually resolves after system upgrade, restart PHP server
```

### Issue: "_sessions table not found"
```
Cause: Session table not created
Fix: 
  1. Import database: mysql -u root -p db_cms_sekolahku < db_cms_sekolahku.sql
  2. Verify settings table exists
```

### Issue: "Cannot write to logs directory"
```
Cause: Permission denied on application/logs/
Fix: chmod 755 application/logs/
```

---

## 📊 Performance Check

### Load Time Targets
- Homepage load: < 2 seconds
- Dashboard load: < 1 second
- Form submission: < 1 second

### Monitor During Testing
```bash
# Watch error logs in real-time
tail -f application/logs/log-*.php
```

---

## ✅ Acceptance Criteria

**Minimum Requirements to Pass:**
- [ ] No PHP errors on homepage
- [ ] Login works with default credentials
- [ ] Dashboard accessible after login
- [ ] All navigation menus functional
- [ ] At least one form submission successful
- [ ] No database connection errors
- [ ] Sessions working correctly
- [ ] Logout clears session

---

## 📝 Testing Log Template

Use this to document your testing:

```markdown
# Testing Log
Date: 
Tester: 
Environment: PHP version X.X.X, MySQL version X.X.X

## Tests Performed
- [ ] Test 1: Homepage - Result: PASS/FAIL
- [ ] Test 2: Login - Result: PASS/FAIL
- [ ] Test 3: Dashboard - Result: PASS/FAIL
- [ ] Test 4: Database - Result: PASS/FAIL
- [ ] Test 5: Forms - Result: PASS/FAIL

## Issues Found
1. Issue: 
   Severity: LOW/MEDIUM/HIGH
   Status: NEW/IN-PROGRESS/RESOLVED

## Sign-Off
All tests passed: YES/NO
Ready for deployment: YES/NO
```

---

## 🔙 Rollback Instructions

**If Critical Issues Found:**
```bash
cd /Users/lukmanhakim/Documents/percobaan/cms-sekolahku-v2.4.13

# Stop application
(Press Ctrl+C if using php -S)

# Restore backup
rm -rf system
mv system.backup.20260511_213255 system

# Restart server
php -S localhost:8080
```

---

## 📞 Next Steps

### After Successful Testing (Local)
1. **Document Results**
   - Note any issues found and fixed
   - Record test completion time
   - Save testing log

2. **Deploy to Staging** (if available)
   - Copy updated code to staging server
   - Run same tests on staging
   - Get stakeholder approval

3. **Deploy to Production**
   - Backup production database
   - Copy system/ folder to production
   - Update index.php on production
   - Run smoke tests on production
   - Monitor for 24-48 hours

---

## 📚 Documentation Reference

- **UPDATE_REPORT.md** - Comprehensive update details
- **CHANGELOG_CI_3.1.13.md** - Technical changelog
- **VERIFICATION_CHECKLIST.md** - Complete testing checklist
- **PANDUAN.txt** - Original installation guide
- **CodeIgniter Docs** - https://codeigniter.com/userguide3/

---

## 💡 Tips

1. **Use Incognito/Private browser mode** to bypass cached credentials
2. **Clear PHP OPcache** if you get "function not found" errors: `php -r "opcache_reset();"`
3. **Check error logs first** for any issues: `tail -50 application/logs/log-*.php`
4. **Test one feature at a time** for easier debugging
5. **Keep backup available** until production stability confirmed

---

**Status:** Ready for Testing ✅  
**Backup Location:** system.backup.20260511_213255/  
**Support:** Check error logs → Review VERIFICATION_CHECKLIST.md → Consult CodeIgniter docs

