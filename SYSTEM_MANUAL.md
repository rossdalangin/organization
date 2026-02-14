# Org Ecosystem - Technical System Manual

This document explains the data flow, content management, and operational processes of the Organization Ecosystem theme.

---

## 1. Page Content Management
Most page content is managed through the **Org Plugin Settings > Page Content** menu.

| Page Template | Content Managed In | Data Flow |
|---|---|---|
| **About Us** | Org Plugin Settings > Page Content | `org_about_text` option is queried. |
| **Our Mission** | Org Plugin Settings > Page Content | `org_mission_text` and `org_vision_text` options are queried. |
| **Contact Us** | Org Plugin Settings > Page Content | `org_contact_info` option and Customizer settings (Address, Phone, Email) are queried. |
| **FAQ Page** | **Org Plugin > FAQs** (Custom Post Type) | All published FAQ records are looped into an accordion. |
| **Membership Plans**| Org Plugin Settings > Page Content | `org_plans_intro` is used for the header. Prices are set in **Appearance > Customize > Monetization**. |
| **Referral Program**| Org Plugin Settings > Page Content | `org_referral_intro` is used for the header. |

---

## 2. Forms and Data Submission

| Form | Action Handler | Redirection Target |
|---|---|---|
| **Member Registration** | `org_ecosystem_handle_registration` | Member Dashboard (after creating Member CPT and User). |
| **Contact Form** | `org_ecosystem_handle_contact_form` | Contact Page with `?contact_sent=true`. |
| **Donation Form** | `org_ecosystem_handle_donation` | Donation Page with `?thanks=true`. |
| **Inquiry Form** | `org_ecosystem_handle_inquiry` | Back to the Member/Product/Business profile with `?inquiry=sent`. |
| **Newsletter Signup** | `org_ecosystem_handle_newsletter` | Home Page with `?subscribed=true`. |
| **Support Ticket** | `org_ecosystem_handle_ticket_submission`| Member Dashboard (Support tab). |
| **Internal Message** | `org_ecosystem_handle_send_message` | Member Dashboard (Messages tab). |

---

## 3. Membership & Payment Process

### Step 1: Registration
A user fills the form at `/join`. This creates:
1.  A standard WordPress **User** (Role: Subscriber).
2.  A **Member** Custom Post Type record (Status: Pending).

### Step 2: Payment (Optional but Recommended)
Members can choose a plan. Payments are currently processed through a unified ledger.
*   **Production Note:** Stripe/PayPal transactions are initially set to **Pending**.
*   **Management:** Go to **Org Plugin Settings > Transactions** to view and approve payments.

### Step 3: Approval
Once payment is confirmed or manual review is complete:
1.  Admin goes to **Org Plugin Settings > Membership**.
2.  Click **Approve & Activate**.
3.  The User Role changes to **Member**, and the Member Profile is published to the directory.

---

## 4. Referral System
*   **Cookie Tracking:** When someone visits `?ref=CODE`, a cookie is set for 30 days.
*   **Commission Calculation:** When a logged-in member makes a sale (e.g., product), the system checks for the `org_referral` cookie.
*   **Credit:** A 10% commission transaction is created for the referrer.
*   **Payout:** referrers can request a withdrawal from their dashboard. Admins manage this in **Org Plugin Settings > Withdrawals**.

---

## 5. Troubleshooting 404s
If you see 404 errors on any page or button:
1.  Go to **Org Plugin Settings > System Setup**.
2.  Click **Auto-Create Required Pages**.
3.  Go to **Settings > Permalinks** and click **Save Changes**.
