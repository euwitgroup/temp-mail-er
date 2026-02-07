# Fix Apache Directory Listing - Enable .htaccess

## Problem
You're seeing a directory listing at `http://localhost/mail-er/` instead of the Laravel application.

## Why This Happens
Apache's `.htaccess` files are being IGNORED because `AllowOverride` is set to `None` in the Apache configuration.

---

## Solution: Enable AllowOverride

### Step 1: Open Apache Configuration
1. Open: `c:\xampp\apache\conf\httpd.conf` in a text editor (as Administrator)
2. OR use XAMPP Control Panel → Config → Apache (httpd.conf)

### Step 2: Find the Directory Configuration
Search for this section (around line 220-250):

```apache
<Directory "C:/xampp/htdocs">
    #
    # Possible values for the Options directive are "None", "All",
    # or any combination of:
    #   Indexes Includes FollowSymLinks SymLinksifOwnerMatch ExecCGI MultiViews
    #
    Options Indexes FollowSymLinks Includes ExecCGI
    AllowOverride None          ← THIS IS THE PROBLEM!
    Require all granted
</Directory>
```

### Step 3: Change AllowOverride
**Change this line:**
```apache
AllowOverride None
```

**To this:**
```apache
AllowOverride All
```

### Step 4: Make Sure mod_rewrite is Enabled
In the SAME file (`httpd.conf`), search for this line (around line 150):

```apache
#LoadModule rewrite_module modules/mod_rewrite.so
```

**Make sure it's UNCOMMENTED** (no # at the start):
```apache
LoadModule rewrite_module modules/mod_rewrite.so
```

### Step 5: Restart Apache
1. Open XAMPP Control Panel
2. Click **Stop** on Apache
3. Wait 2 seconds
4. Click **Start** on Apache

---

## After Restart

Visit: `http://localhost/mail-er/`

You should now see the **Premium Gaming Theme** welcome page! 🎮

---

## If You Still See Directory Listing

The .htaccess might not be working. Use **Solution 2** below instead.
