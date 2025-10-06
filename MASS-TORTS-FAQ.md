# 🧩 ACF Configuration

1. Navigate to **ACF › Mass Torts Template › Mass Tort Flexible Content › FAQs Layout**.  
2. Under **“FAQs Layout”**, add the following two fields:
   1. **Section Content** — *WYSIWYG*
   2. **Section Bottom** — *WYSIWYG*

---

# 💻 Code Update

1. Go to the **`mass-torts`** directory → open **`faq-layouts.php`**, and update the file with the latest code.  
2. Adjust the **styling** to match the current theme and ensure font sizes are properly optimized for **both mobile and desktop**.

---

# 🧪 Test Implementation

1. Open any **Mass Torts** page, add the **FAQ Layout**, and test all newly added fields.  
2. Confirm that the **JSON-LD schema code** is being correctly generated and displayed.

---

# ✅ QA Checklist

### 1. FAQ Accordion
- [ ] Verify the FAQ Accordion UI for any layout or style issues (on both mobile and desktop).

### 2. Field Functionality
- [ ] Confirm all fields work as intended.  
- [ ] Test possible HTML tags within the FAQ content — e.g. `<a>`, `<ul>`, `<ol>` — to ensure they render and style correctly.

### 3. Schema Validation
- [ ] Validate the generated JSON-LD schema using the [Google Structured Data Testing Tool](https://developers.google.com/search/docs/appearance/structured-data).

---

> **Note:** Only update the specified sections of the code. The rest may contain site-specific customizations and should remain unchanged.