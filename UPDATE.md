> **Note:** Please avoid modifying the **HTML** and **CSS** as these may be customized for the current site.

---

# 🛠️ Update Instructions

1. Navigate to the theme folder:  
   `shortcodes/tseg-faq.php`
2. Locate the **schema** section of the code (approximately **line 25** up to the end of the closing `</script>` tag, or before the opening `<style>` tag).
<img width="1013" height="1072" alt="image" src="https://github.com/user-attachments/assets/c990f2b9-0fb7-4e7c-b755-596df37c5e10" />
3. Replace that section with the contents of `tseg-faq-schema.php`.  
   *(See the full code reference in `tseg-faq.php` for guidance.)*

---

# ✅ QA Checklist

Visit a page where the **FAQ shortcode** has been added and perform the following checks:

### 1. FAQ Accordion
- [ ] Verify that the FAQ accordion works properly and there are no UI/UX issues.
<img width="1121" height="527" alt="image" src="https://github.com/user-attachments/assets/59f9f99f-a3ee-4f94-9b50-0dacbb4f70b1" />

### 2. ACF Fields
- [ ] Confirm that the **Include/Exclude Schema** options function correctly from the backend.
<img width="1425" height="516" alt="image" src="https://github.com/user-attachments/assets/72b03697-2ac3-46c7-a7e3-ccdea450b0f4" />

### 3. FAQ Schema
- [ ] Ensure that **HTML tags** (e.g., `<a href="">`) inside FAQ content are **stripped/removed** from the schema.  
- [ ] Test FAQ content containing **single quotes** (`'`) and **double quotes** (`"`) to verify they are properly **escaped**.
<img width="233" height="130" alt="image" src="https://github.com/user-attachments/assets/8c9dd372-cf5f-4a0b-9488-50d679205f08" />

### 4. Validate Schema
- [ ] Validate the FAQ Schema using the [Google Structured Data Testing Tool](https://developers.google.com/search/docs/appearance/structured-data).
<img width="937" height="994" alt="image" src="https://github.com/user-attachments/assets/5ba4ee50-8eac-4bb2-9555-7a50bb400ec8" />
