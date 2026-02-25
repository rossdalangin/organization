# Org Ecosystem - Comprehensive Technical System Manual

This document provides in-depth technical documentation for the Organization Ecosystem WordPress theme. It covers the data architecture, custom systems, and deployment workflows.

---

## 1. System Architecture Overview
The Organization Ecosystem is built on a "Member-Centric" data model. Every standard WordPress User is linked to a corresponding **Member** Custom Post Type (CPT) record via metadata.

### Core Data Relationships
*   **User -> Member Profile:** Linked via `_member_profile_id` (User Meta).
*   **Member -> Business:** Linked via `post_author` (One Member can own one Business Profile).
*   **Business -> Products:** Linked via `_product_business_id` (Post Meta).
*   **Member -> Transactions:** Linked via `_txn_user_id` (Post Meta).

---

## 2. Advanced Custom Fields & Meta
Instead of relying on external plugins, the theme implements a robust meta system using native WordPress `update_post_meta` and custom meta boxes.

### Member Profile Meta (`member` CPT)
| Meta Key | Data Type | Purpose |
|---|---|---|
| `_member_bio` | Textarea | Professional biography. |
| `_member_status` | String | `active`, `pending`, `expired`. Controls directory visibility. |
| `_member_is_featured`| Boolean | Toggles "Featured" badge and top-of-list sorting. |
| `_member_view_count` | Integer | Increments every time the single profile page is loaded. |

---

## 3. The "Unified Checkout" System
The theme features a standalone checkout engine (`page-checkout.php`) that handles multiple transaction types through a single UI.

### Transaction Lifecycle
1.  **Initiation:** Triggered by `checkout_type` (e.g., `membership`, `promotion`, `donation`).
2.  **Ledger Entry:** A `org_transaction` record is created with status `pending`.
3.  **Gateway Handover:** User selects Stripe, PayPal, GCash, or Offline.
4.  **Verification:**
    *   *Automatic:* Future API webhooks (Stripe/PayPal).
    *   *Manual:* Administrator marks transaction as `completed` in the Ledger.
5.  **Side Effects:** Upon completion, `org_ecosystem_complete_transaction()` triggers:
    *   Role upgrades.
    *   Badge activation.
    *   Commission distribution to referrers.

---

## 4. Administrative "Quick Start" Command Library
Administrators can manage the entire system without leaving the dashboard.

### Shortcode Implementation Samples
**Member Directory with Filters:**
`[org_directory columns="3" count="12"]`

**Featured Solutions Grid:**
`[org_product_grid featured="true" count="4"]`

**Donation Call-to-Action:**
`[org_donation_form title="Support Our Growth" button_text="Give Now"]`

---

## 5. Security & Scaling
*   **AJAX Hardening:** All dashboard actions (messaging, chat, filtering) are protected by WordPress Nonces.
*   **Access Control:** `org_ecosystem_restrict_admin_access()` ensures members are redirected to the frontend dashboard, keeping `wp-admin` exclusive to staff.
*   **REST API:** Custom meta fields are registered with `'show_in_rest' => true` for future mobile app compatibility.

---

## 6. Developer "Bypass" Tool
On `localhost` environments, use the **Bypass Payment** button on the Checkout page to simulate a successful Stripe/PayPal response. This allows for rapid testing of membership features without needing active API keys.
