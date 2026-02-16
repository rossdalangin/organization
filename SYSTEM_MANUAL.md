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

## 3. Shortcode Library
The theme provides powerful shortcodes for building custom ecosystem sections.

| Shortcode | Purpose | Renders |
|---|---|---|
| `[org_directory]` | Main member directory | Searchable AJAX list of members. |
| `[org_business_grid]`| Business directory | Grid of all member-owned businesses. |
| `[org_product_grid]` | Product marketplace | Grid of member products/services. |
| `[org_event_grid]` | Upcoming events | Chronological grid of organization events. |
| `[org_resource_grid]`| Resource library | Grid of downloadable member resources. |
| `[org_job_list]` | Job board | Structured list of active job openings. |
| `[org_pricing_table]`| Membership plans | 5-tier responsive pricing table. |
| `[org_donation_form]`| Support our mission | Integrated AJAX donation form. |
| `[org_latest_announcements]` | Grid of news | Top 3 latest announcements. |

---

## 4. Ecosystem Automation (Setup Tool)
The **Org Plugin Settings > System Setup** tool automates the creation and configuration of 19 essential pages:
1.  **Member Dashboard** (Template: `page-dashboard.php`)
2.  **Contact Us** (Template: `page-contact.php`)
3.  **Join Us** (Template: `page-join.php`)
4.  **Support Our Mission** (Shortcode: `[org_donation_form]`)
5.  **About Us** (Template: `page-about.php`)
6.  **Our Mission** (Template: `page-mission.php`)
7.  **Membership Plans** (Shortcode: `[org_pricing_table]`)
8.  **Referral Program** (Template: `page-referrals.php`)
9.  **FAQ** (Template: `page-faq.php`)
10. **Member Directory** (Shortcode: `[org_directory]`)
11. **Governance & Leadership** (Template: `page-governance.php`)
12. **Partner With Us** (Template: `page-partners.php`)
13. **Privacy Policy** (Template: `page-privacy.php`)
14. **Terms & Conditions** (Template: `page-terms.php`)
15. **Business Showcase** (Shortcode: `[org_business_grid]`)
16. **Upcoming Events** (Shortcode: `[org_event_grid]`)
17. **Member Resources** (Shortcode: `[org_resource_grid]`)
18. **Product Marketplace** (Shortcode: `[org_product_grid]`)
19. **Job Board** (Shortcode: `[org_job_list]`)

---

## 5. Forms and Data Submission
Forms are handled by `admin-post.php` hooks in `inc/template-functions.php` and `inc/membership.php`.
*   **Redirects:** Successful submissions typically redirect back with a `?success=true` or similar query parameter.
*   **Permalinks:** The theme uses `org_ecosystem_get_page_url()` to resolve template paths to live permalinks dynamically.

---

## 6. Troubleshooting 404s
If you see 404 errors on any page or button:
1.  Go to **Org Plugin Settings > System Setup**.
2.  Click **Auto-Create Required Pages** (to ensure pages exist).
3.  Go to **Settings > Permalinks** and click **Save Changes** (to flush rules).
