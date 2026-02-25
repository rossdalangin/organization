# Organization Ecosystem - Shortcode Cookbook

A detailed guide to using the theme's modular shortcode system to build custom pages.

---

## 1. Member Directory (`[org_directory]`)
The core of the ecosystem. Displays a filterable grid of active members.

*   **Parameters:**
    *   `columns`: (int) 2, 3, or 4.
    *   `count`: (int) Total items per page.
    *   `industry`: (slug) Filter by specific industry.
*   **Sample Usage:**
    `[org_directory columns="3" count="12"]`

---

## 2. Product Marketplace (`[org_product_grid]`)
Showcase the best solutions from your vendors.

*   **Parameters:**
    *   `featured`: (bool) `true` to show only featured products.
    *   `count`: (int) Total items.
*   **Sample Usage:**
    `[org_product_grid featured="true" count="4"]`

---

## 3. Dynamic Pricing Table (`[org_pricing_table]`)
Automatically pulls prices from your Customizer settings.

*   **Sample Usage:**
    `[org_pricing_table]`

---

## 4. Organization Announcements (`[org_latest_announcements]`)
Keep your community informed with a structured alert grid.

*   **Parameters:**
    *   `count`: (int) Number of announcements to display.
*   **Sample Usage:**
    `[org_latest_announcements count="3"]`

---

## 5. Community Fundraising (`[org_donation_form]`)
An integrated form for collecting community contributions.

*   **Sample Usage:**
    `[org_donation_form]`

---

## 6. Job Board & Listings (`[org_job_list]`)
A specialized list layout for professional opportunities.

*   **Sample Usage:**
    `[org_job_list]`
