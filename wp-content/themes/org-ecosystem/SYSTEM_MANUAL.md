# Org Ecosystem - Technical System Manual

This document explains the data flow, content management, and operational processes of the Organization Ecosystem theme.

---

## 1. Administrative Setup
### Admin Account Setup
In WordPress, anyone with the **Administrator** role has full access. For staff, use the **Organization Admin** role which is optimized for managing the ecosystem.
*   **Manage Staff:** Go to **Users > All Users** and assign the appropriate role.
*   **Permissions:** You can fine-tune what each role can do in **Org Plugin Settings > Roles**.

## 2. Page Content Management
Most page content is managed through the **Org Plugin Settings > Page Content** menu.

| Page Template | Content Managed In | Data Flow |
|---|---|---|
| **About Us** | Org Plugin Settings > Page Content | `org_about_text` option is queried. |
| **Our Mission** | Org Plugin Settings > Page Content | `org_mission_text` and `org_vision_text` options are queried. |
| **Contact Us** | Org Plugin Settings > Page Content | `org_contact_info` option and Customizer settings (Address, Phone, Email) are queried. |
| **Payment Methods**| Org Plugin Settings > Page Content | `org_payments_intro` is used for the header. |
| **FAQ Page** | **Org Plugin > FAQs** (Custom Post Type) | All published FAQ records are looped into an accordion. |
| **Membership Plans**| Org Plugin Settings > Page Content | `org_plans_intro` is used for the header. Prices are set in **Appearance > Customize > Monetization**. |
| **Referral Program**| Org Plugin Settings > Page Content | `org_referral_intro` is used for the header. |
| **Governance** | `page-governance.php` | Dedicated modern layout for leadership showcase. |
| **Partner With Us** | `page-partners.php` | Strategic layout for partnership tiers. |
| **Legal Pages** | `page-privacy.php`, `page-terms.php` | Dark-themed, focus-oriented legal layouts. |

---

## 3. Shortcode Library (Strict Visibility)
The theme provides powerful shortcodes for building custom ecosystem sections. **Note:** Members, Businesses, and Products only appear if the member status is **Active** (Upgraded).

| Shortcode | Purpose | Renders |
|---|---|---|
| `[org_directory]` | Main member directory | Searchable AJAX list of active members. |
| `[org_business_grid]`| Business directory | Grid of all active member-owned businesses. |
| `[org_product_grid]` | Product marketplace | Grid of active member products/services. |
| `[org_event_grid]` | Upcoming events | Chronological grid of organization events. |
| `[org_resource_grid]`| Resource library | Grid of downloadable member resources. |
| `[org_job_list]` | Job board | Structured list of active job openings. |
| `[org_pricing_table]`| Membership plans | 5-tier responsive pricing table. |
| `[org_donation_form]`| Support our mission | Integrated AJAX donation form. |
| `[org_latest_announcements]` | Grid of news | Top 3 latest announcements. |

---

## 4. Ecosystem Automation (Setup Tool)
The **Org Plugin Settings > System Setup** tool automates the creation and configuration of 19 essential pages.

---

## 5. Membership & Payment Process

### Step 1: Registration
A user fills the form at `/join`. This creates:
1.  A standard WordPress **User** (Role: Subscriber).
2.  A **Member** Custom Post Type record (Status: Pending).

### Step 2: Payment & Upgrade
Members can choose a plan. Payments are currently processed through a unified ledger.
*   **Upgrade Action:** Logged-in users can initiate a yearly upgrade via the Dashboard > Billing tab.
*   **Admin Review:** Go to **Org Plugin Settings > Transactions** to view and approve payments.
*   **Upgraded Status:** Once a payment is marked "Completed", the member's meta `_member_status` is set to **Active**.

### Step 3: Visibility
Only **Active** members are visible in the public directory and marketplace grids.

---

## 6. Login Redirection
*   **Administrators/Admins:** Redirected to `wp-admin` Command Center.
*   **Standard Members:** Redirected to their frontend Member Dashboard.
