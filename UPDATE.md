> **Note:** Please avoid modifying the **HTML** and **CSS** as these may be customized for the current site.

---

# 🛠️ Update Instructions

1. Navigate to the theme folder:  
   `shortcodes/tseg-faq.php`
2. Locate the **schema** section of the code (approximately **line 25** up to the end of the closing `</script>` tag, or before the opening `<style>` tag).
3. Replace that section with the contents of `tseg-faq-schema.php`.  
   *(See the full code reference in `tseg-faq.php` for guidance.)*

---

# ✅ QA Checklist

Visit a page where the **FAQ shortcode** has been added and perform the following checks:

### 1. FAQ Accordion
- [ ] Verify that the FAQ accordion works properly and there are no UI/UX issues.

### 2. ACF Fields
- [ ] Confirm that the **Include/Exclude Schema** options function correctly from the backend.

### 3. FAQ Schema
- [ ] Ensure that **HTML tags** (e.g., `<a href="">`) inside FAQ content are **stripped/removed** from the schema.  
- [ ] Test FAQ content containing **single quotes** (`'`) and **double quotes** (`"`) to verify they are properly **escaped**.

### 4. Validate Schema
- [ ] Validate the FAQ Schema using the [Google Structured Data Testing Tool](https://developers.google.com/search/docs/appearance/structured-data).

---

📌 **Reminder:** Always double-check the schema output before pushing any updates.