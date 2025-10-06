**Note:** Please avoid modifying the **HTML** and **CSS** as these may be customized for the current site.

---

# 🛠️ Update Instructions

1. Navigate to the theme folder:  
   `shortcodes/tseg-faq.php`
2. Locate the **schema** section of the code (approx. **line 24** up to the end of the closing `</script>` tag, or before the opening `<style>` tag).
<img width="506.5" height="536" alt="image" src="https://github.com/user-attachments/assets/c990f2b9-0fb7-4e7c-b755-596df37c5e10" />

3. Replace that section with this code.  
   *(See the full code reference in [tseg-faq.php](https://github.com/renzpcloud816/tseg-faq/blob/main/tseg-faq.php) for guidance.)*
```php
<?php
$faq_rows = get_field('tseg_content_faqs');
$include_speakable_property = get_field('faq_speakable_schema');

if (!empty($faq_rows)) {
    
    $faq_items_for_schema = []; // This will hold the Question objects

    // Loop through our array of rows
    foreach ($faq_rows as $index => $row) {
        
        // Skip this row if the "include in schema" checkbox is not checked
        if (empty($row['include_in_schema'])) {
            continue;
        }

        // Get the question and answer for this row
        $question = $row['faq_title'];
        $answer   = wp_strip_all_tags($row['faq_answer']);
        $item_number = $index + 1; // Counter for unique CSS selectors

        // Start building the Question object
        $current_question = [
            '@type'          => 'Question',
            'name'           => $question,
            'acceptedAnswer' => [
                '@type' => 'Answer',
                'text'  => $answer,
            ],
        ];
        
        // As requested, add the 'speakable' property directly to the Question object
        if ($include_speakable_property) {
            $current_question['speakable'] = [
                '@type'       => 'SpeakableSpecification',
                'cssSelector' => [
                    ".tseg-accordion-item-{$item_number} .tseg-accordion-header",
                    ".tseg-accordion-item-{$item_number} .tseg-accordion-body",
                ],
            ];
        }
        
        // Add the completed Question object to our main array
        $faq_items_for_schema[] = $current_question;
    }

    // --- 3. BUILD AND OUTPUT THE FINAL SCHEMA ---
    // Only output the script if there is at least one FAQ to include
    if (!empty($faq_items_for_schema)) {
        
        // Build the final schema as a direct FAQPage type
        $final_schema = [
            '@context'   => 'https://schema.org',
            '@type'      => 'FAQPage',
            'mainEntity' => $faq_items_for_schema,
        ];

        // Safely encode and output the final JSON-LD script
        echo '<script type="application/ld+json">' . json_encode($final_schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</script>';
    }
}
?>
```

---

# ✅ QA Checklist

Visit a page where the **FAQ shortcode** has been added and perform the following checks:

### 1. FAQ Accordion
- [ ] Verify that the FAQ accordion works properly and there are no UI/UX issues.
<img width="560.5" height="263.5" alt="image" src="https://github.com/user-attachments/assets/59f9f99f-a3ee-4f94-9b50-0dacbb4f70b1" />

### 2. ACF Fields
- [ ] Confirm that the **Include/Exclude Schema** options function correctly from the backend.
<img width="712.5" height="258" alt="image" src="https://github.com/user-attachments/assets/72b03697-2ac3-46c7-a7e3-ccdea450b0f4" />

### 3. FAQ Schema
- [ ] Ensure that **HTML tags** (e.g., `<a href="">`) inside FAQ content are **stripped/removed** from the schema.  
- [ ] Test FAQ content containing **single quotes** (`'`) and **double quotes** (`"`) to verify they are properly **escaped**.
<img width="233" height="130" alt="image" src="https://github.com/user-attachments/assets/8c9dd372-cf5f-4a0b-9488-50d679205f08" />

### 4. Validate Schema
- [ ] Validate the FAQ Schema using the [Google Structured Data Testing Tool](https://developers.google.com/search/docs/appearance/structured-data).
<img width="468.5" height="497" alt="image" src="https://github.com/user-attachments/assets/5ba4ee50-8eac-4bb2-9555-7a50bb400ec8" />
