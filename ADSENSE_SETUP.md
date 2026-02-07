# 💰 Google AdSense Setup Guide

## 🛑 Critical Step: Fix "Ads.txt Not Found"

Your AdSense dashboard shows **"Ads.txt status: Not found"**. This is the main reason ads are not showing.

### Option 1 (Recommended): Admin Panel
1. Log in to your Admin Panel (`/admin/settings`).
2. Go to the **Google AdSense** tab.
3. Scroll down to **"ads.txt Content"**.
4. Paste your line from Google AdSense (e.g., `google.com, pub-1234567890, DIRECT, ...`).
5. Click **Save Changes**.
6. **Verify**: Visit `https://jaldhakamart.com/ads.txt`. You should see the line you pasted.

### Option 2 (Fallback): Manual File
If Option 1 doesn't work (e.g., due to server caching):
1. **Create a file** named `ads.txt` on your computer.
2. Paste the content inside.
3. **Upload** this file to the `public/` folder of your hosting (same folder where `index.php` and `robots.txt` are).
4. **Verify**: Visit `https://jaldhakamart.com/ads.txt`.

---

## 🛠️ Configuration Checklist

### 1. Header Script (Auto Ads)
1. Go to Admin Panel → **Google AdSense**.
2. Find **"Auto Ads Code / Header Script"**.
3. Paste the `<script>...</script>` tag provided by Google.
   - *Ensure you copy the entire tag!*

### 2. Ad Units (Manual Placements)
You have 4 zones defined:
- **Home Top**: Just below the "Secure Disposable Email" title.
- **Home Bottom**: Just above the footer.
- **Left Sidebar**: visible on Desktop.
- **Right Sidebar**: visible on Desktop.

**To fill these:**
1. Create a "Display Ad" unit in Google AdSense.
2. Copy the HTML code (usually `<ins class="adsbygoogle" ...></ins>` + script).
3. Paste it into the corresponding field in Admin Panel.

---

## ❓ Troubleshooting Blank Ads

**Issue**: "Home screen taking ads area but not display ads"

**Causes:**
1.  **Site Not Approved**: Your screenshot says **"Getting ready"**. Until Google changes this to **"Ready"**, ads will mostly be blank spaces. This is normal.
2.  **Ads.txt Missing**: Google stops serving ads if this is missing for too long.
3.  **New Ad Units**: Newly created ad units can take **1-2 hours** to start determining what to show.

**Solution:**
1.  **Fix Ads.txt** (Priority #1).
2.  **Wait for Approval**: You typically cannot force this. It takes days to 2 weeks.
3.  **Verify Code**: Right-click the blank space on your site -> Inspect Element.
    - If you see `<ins ... data-ad-status="unfilled">`, it means code is working, but Google has no ad for you (yet).

---

## 🚀 Deployment

Since we added new database settings keys for AdSense, run this on your server:

```bash
# 1. Update Database Seeder (if you haven't)
php artisan db:seed --class=AdSenseSeeder --force

# 2. Clear Caches to ensure new routes load
php artisan route:clear
php artisan config:clear
php artisan view:clear
```
