# Org Ecosystem - Comprehensive Technical System Manual

A technical guide for the Organization Ecosystem WordPress theme—covering data architecture, payment logic, and administrative systems.

---

## 1. System Architecture & Data Relationships

The Organization Ecosystem is built on a "Member-Centric" data model, linking standard WordPress Users to professional metadata.

### Core CPT Relationships
| Source CPT | Linked To | Meta Key / Linking Logic |
|---|---|---|
| **User** | Member | `_member_profile_id` (User Meta) |
| **Member** | User | `post_author` (Each Member is owned by a User) |
| **Member** | Business | `post_author` (One Member can own one Business) |
| **Business** | Product | `_product_business_id` (Post Meta) |
| **User** | Transaction | `_txn_user_id` (Post Meta) |

### Custom Post Types (CPTs)
*   `member`: The core professional profile.
*   `business`: A business or organization owned by a member.
*   `product`: Individual marketplace listings.
*   `event`: Calendar items for the organization.
*   `announcement`: Official alerts and updates.
*   `org_transaction`: The unified ledger for all ecosystem payments.
*   `org_newsletter`: A list of subscribers and sent campaigns.

---

## 2. Advanced Meta Fields System

The theme uses native WordPress `update_post_meta` and custom meta boxes (`inc/meta-fields.php`, `inc/membership.php`) instead of bulky plugins.

### Important Meta Keys (Member CPT)
*   `_member_status`: `active`, `pending`, `expired`. Controls directory visibility.
*   `_member_is_featured`: `1` (Featured) or `0` (Standard). Triggers homepage placement.
*   `_member_is_verified`: `1` (Verified) or `0` (Unverified). Displays the trust badge.
*   `_member_view_count`: Increments on single profile loads.
*   `_member_renewal_date`: Format: `YYYY-MM-DD`. Used by the automation cron.

---

## 3. The "Unified Checkout" & Payment Engine

Located in `page-checkout.php` and `inc/transactions.php`, this system handles all ecosystem revenue.

### Transaction Process
1.  **Initiation:** Triggered via query parameters (`checkout_type`, `amount`, `plan_id`).
2.  **Ledger Entry:** A `org_transaction` post is created with status `pending`.
3.  **Payment Processing:**
    *   **Stripe:** Handled via Stripe.js and a frontend bridge (`assets/js/main.js`).
    *   **PayPal:** Redirect-based flow.
    *   **Manual/Offline:** Admin must approve the transaction from the Ledger.
4.  **Completion Logic (`complete_transaction`):**
    *   Updates transaction status to `completed`.
    *   Upgrades the user's `_membership_level` (User Meta).
    *   Approves the linked `member` CPT profile.
    *   Triggers 10% referral commission for the referrer (via `org_referral` cookie).

---

## 4. Automation & Maintenance

### Daily Expiration Check (`inc/membership.php`)
*   **Hook:** `org_ecosystem_daily_expiration_check`
*   **Schedule:** Runs daily via WP-Cron.
*   **Logic:** Finds members whose `_member_renewal_date` is today or in 7 days.
    *   **Expired:** Sets status to `expired`, hides from directory, sends "Expired" email.
    *   **Reminder:** Sends "7-Day Warning" email to the member.

### Admin Tools (`inc/admin-panel.php`)
*   **Setup Tool:** Automatically creates the 19 required ecosystem pages (Dashboard, Checkout, Directory, etc.) if they are missing.
*   **Demo Import:** Injects 20+ sample records for rapid staging.
*   **System Reset:** Securely wipes all ecosystem CPTs and demo users.

---

## 5. Security & Access Control

*   **AJAX Integrity:** All frontend actions (filters, messages, chat) are secured via `check_ajax_referer` and WordPress Nonces.
*   **Admin Restriction:** `org_ecosystem_restrict_admin_access()` ensures that only roles with `edit_posts` (Admins/Staff) can access `/wp-admin/`. Standard members are redirected to their User Dashboard.
*   **Data Scoping:** In `page-dashboard.php`, all data (messages, wallet, stats) is strictly scoped to the `get_current_user_id()`.

---

## 6. Developer Bypass Tool (Localhost)
For rapid testing on `localhost`, use the **Bypass Payment** button on the Checkout page. This simulates a successful Stripe response and triggers all transaction logic (approvals, role changes) without requiring API keys.
