# Organization Ecosystem - Administrator & User Manual

Welcome to the Organization Ecosystem. This manual will guide you through configuring and using the system to its full potential.

---

## 1. Quick Start Guide for Administrators

### Step 1: Branding and Identity
1. Go to **Appearance > Customize**.
2. Navigate to **Brand Identity & Colors**.
3. Upload your organization's logo and select your primary brand colors.
4. Set your typography in the **Typography & Fonts** section.

### Step 2: Configuring Membership Tiers
1. Go to **Org Settings > Membership**.
2. Review the default tiers (Free, Basic, Premium, Corporate, Lifetime).
3. Set your pricing in **Appearance > Customize > Membership Plans**.

### Step 3: Setting Up Payments
1. Go to **Org Settings > Payments**.
2. Enter your **Stripe Secret Key** or **PayPal Email**.
3. Configure **GCash Number** for mobile payments.
4. Configure **Offline Payment Instructions** for members who prefer bank transfers.
5. **Note on Transactions:** This theme provides a complete Ledger and Payout system. For production server-to-server security (Webhook verification), we recommend installing a dedicated gateway plugin like "WooCommerce" or "Stripe for WordPress" and linking it to our Transaction API if advanced fraud detection is required.

---

## 2. Managing the Member Directory

### Adding Members Manually
1. Go to **Members > Add New**.
2. Enter the member's name, bio, and business details.
3. Assign an **Industry** and **Location** taxonomy.
4. Set the **Membership Status** to "Active" to show them in the directory.

### Approving Registered Members
1. When a user registers on the frontend, their profile is set to "Pending".
2. Go to **Org Settings > Membership**.
3. Click **Approve Member** to publish their profile and grant them access to the dashboard.

---

## 3. Increasing Revenue (Profitability Features)

### Lead Gating (The #1 Revenue Driver)
1. Navigate to **Appearance > Customize > Revenue & Lead Protection**.
2. Check **Enable Lead Gating**.
3. This hides contact buttons from guests and Basic members, encouraging them to upgrade to a higher tier.

### Featured Listings
1. Charge members a fee (e.g., ₱500) to be featured.
2. Once paid, edit their Member profile and check the **Featured Badge** box.
3. They will now appear at the top of the directory with a "Partner Spotlight" badge.

### Sidebar Sponsor Ads
1. Go to **Appearance > Customize > Sidebar Sponsor Ads**.
2. Upload a banner from a local partner.
3. Set the target URL. This provides a consistent stream of advertising revenue.

---

## 4. Member Dashboard Features

Members can log in to their dashboard to:
*   **Edit Profile:** Update their business name, bio, and social links.
*   **Manage Products:** Add or edit services they offer to the community.
*   **Register for Events:** See upcoming organization events and sign up.
*   **Billing History:** View past payments and download receipts.
*   **Support Tickets:** Communicate directly with organization admins.

---

## 5. Troubleshooting & Support

*   **Email Not Sending:** Ensure you have an SMTP plugin configured if your server's default mail function is disabled.
*   **CSS Not Updating:** Clear your browser cache or any server-side caching plugins.
*   **Member Not Showing in Directory:** Ensure the member's post status is set to "Publish" and their Membership Status meta is set to "Active".
