# 💰 Google AdSense Configuration Guide

## ⚠️ Important Status Check
Your ads are currently blank because of two reasons shown in your Google Console:
1.  **Ads.txt Status: Not Found** (Critical Fix)
2.  **Site Status: Getting Ready** (Waiting for Approval)

**Until both of these are fixed/approved by Google, no ads will show.**

---

## ✅ Step 1: Fix Ads.txt (Mandatory)

Google **requires** this file to verify you own the site.

1.  Log in to your **Google AdSense** account.
2.  Click on **"Sites"** in the sidebar.
3.  Click on your site (`jaldhakamart.com`) or look for the "Fix now" alert.
4.  Copy the code snippet that looks like:
    ```
    google.com, pub-XXXXXXXXXXXXXXXX, DIRECT, f08c47fec0942fa0
    ```
5.  **Go to your Website Admin Panel**:
    - URL: `https://jaldhakamart.com/admin/settings`
    - Tab: **Google AdSense**
    - Field: **ads.txt Content**
    - **Paste the code here.**
    - Click **Save Changes**.
6.  **Verify**: Visit `https://jaldhakamart.com/ads.txt` in your browser. You should see the code.

*Note: Google takes up to 24 hours to re-crawl this file.*

---

## 🎨 Step 2: Creating Proper Ad Units

For your layout, you need specific types of ads. Here is how to create them in AdSense:

### 1. Left & Right Sidebars (Tall Ads)
*These go in "Home Left Sidebar Ad" and "Home Right Sidebar Ad"*

1.  In AdSense, go to **Ads > By ad unit**.
2.  Click **Display ad**.
3.  Name it: `Home-Sidebar-Left` (and another for Right).
4.  **Ad Shape**: Select **Vertical**.
5.  **Ad Size**: Select **Responsive**.
6.  Click **Create**.
7.  Copy the code snippet (`<script>...</script>` and `<ins>...</ins>`).
8.  Paste it into the Admin Panel → **Home Left/Right Sidebar Ad**.

### 2. Top Banner (Wide Ad)
*This goes in "Home Top Ad"*

1.  Click **Display ad**.
2.  Name it: `Home-Top-Banner`.
3.  **Ad Shape**: Select **Horizontal**.
4.  Click **Create**.
5.  Paste code into Admin Panel → **Home Top Ad**.

### 3. Bottom Banner (Wide Ad)
*This goes in "Home Bottom Ad"*

1.  Click **Display ad**.
2.  Name it: `Home-Bottom-Banner`.
3.  **Ad Shape**: Select **Horizontal**.
4.  Click **Create**.
5.  Paste code into Admin Panel → **Home Bottom Ad**.

---

## ⚙️ Step 3: Header Code (Auto Ads)

This allows Google to place ads automatically in other places (like popups or vignettes).

1.  In AdSense, go to **Ads > Overview**.
2.  Click **Get Code**.
3.  Copy the script `<script async src="...crossorigin="anonymous"></script>`.
4.  Paste it into Admin Panel → **Auto Ads Code / Header Script**.

---

## ❓ Troubleshooting "Gray/Blank" Ads

If you see the gray area on your site (as in your screenshot), **CONGRATULATIONS!** 🎉
This means:
1.  Your website is correctly configured.
2.  The code is communicating with Google.
3.  The space is reserved.

**Why is it blank?**
Google refused to fill the slot. This usually happens when:
- Site is not approved yet ("Getting Ready").
- Ads.txt is missing.
- Ad unit was created less than 1 hour ago.
- No relevant ad was found for the visitor.

**Start Verification:**
1.  Right-click the gray area → **Inspect**.
2.  Look for `<ins class="adsbygoogle" ... data-ad-status="unfilled">`.
3.  If you see `unfilled`, it confirms the system is working perfectly, but Google decided not to show an ad.

---

## 🚀 Final Checklist

- [ ] Ads.txt content saved in Admin Panel.
- [ ] `/ads.txt` URL link works.
- [ ] Publisher ID saved in Admin Panel.
- [ ] 4 Manual Ad Units created and codes saved.
- [ ] Header Script saved.
- [ ] **Wait 24-48 hours** for Google to clear flags.
