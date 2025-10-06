> **Note:** The **Mass Torts Template** already includes an existing FAQ Layout.  
> This update only adds new fields and integrates the FAQ Schema functionality.  
> Avoid modifying unrelated fields or layouts.

# 🧩 ACF Configuration

1. Navigate to **ACF › Mass Torts Template › Mass Tort Flexible Content › FAQs Layout**.  
2. Under **“FAQs Layout”**, add the following two fields:
   1. **Section Content** — *WYSIWYG*
   2. **Section Bottom Content** — *WYSIWYG*
<img width="626" height="284" alt="image" src="https://github.com/user-attachments/assets/317c9b5a-02c7-4f19-8127-bb9f216bb237" />


---

# 💻 Code Update

1. Go to the **`mass-tort-content-blocks`** directory → open **`faq-layouts.php`**, and update the file with the latest code.
```php
<?php 
	$dark_bg = get_sub_field('dark_background');
	$title = get_sub_field('section_title');
	$content = get_sub_field('section_content');
	$content_bottom = get_sub_field('section_bottom_content');
	$cta = get_sub_field('faq_cta_button');
	
	$faq_rows = get_sub_field('faq_repeater');
?>
<section class="faq-section<?php if($dark_bg): ?> dark-background<?php endif; ?>">
	<div class="container">
		<h2 class="title text-center mb-4 text-uppercase"><?php echo $title; ?></h2>
		
		<?php if($content): ?>
		    <div class="mb-5 text-center">
		        <?= $content; ?>
		    </div>
		<?php endif; ?>
        
        <?php
        if( $faq_rows ):
        
            $faq_items = [];
            foreach( $faq_rows as $schema_index => $row ) {
                $schema_counter = $schema_index + 1;
                $question = $row['faq_title'];
                $answer   = wp_strip_all_tags( $row['faq_content'] );
        
                // This creates the structure you requested
                $faq_items[] = [
                    '@type'          => 'Question',
                    'name'           => $question,
                    'acceptedAnswer' => [
                        '@type' => 'Answer',
                        'text'  => $answer,
                    ],
                    'speakable'      => [
                        '@type'       => 'SpeakableSpecification',
                        'cssSelector' => [
                            '.faq-item-'.$schema_counter.' .faq-title',
                            '.faq-item-'.$schema_counter.' .faq-content',
                        ],
                    ],
                ];
            }
            
            $schema = [
                '@context'   => 'https://schema.org',
                '@type'      => 'FAQPage', // This schema type is correct
                'mainEntity' => $faq_items,
            ];
        
            echo '<script type="application/ld+json">' . json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</script>';
        ?>
        
            <div class="accordion" id="accordion">
                <?php foreach( $faq_rows as $index => $row ): 
                    $counter = $index + 1;
                    // Access sub-fields for display
                    $title = $row['faq_title'];
                    $content = $row['faq_content']; // Full content with HTML for display
                ?>
                    <div class="faq-item faq-item-<?= $counter; ?> card">
                        <div class="card-header p-0" id="heading<?php echo $counter; ?>">
                            <button class="btn btn-link w-100 m-0 justify-content-between text-left d-flex gap-3 text-decoration-none<?php if($index > 0): ?> collapsed<?php endif; ?>" data-bs-toggle="collapse" data-bs-target="#collapse<?php echo $counter; ?>" aria-expanded="true" aria-controls="collapse<?php echo $counter; ?>">
                                <h3 class="faq-title m-0 text-start"><?php echo $title; ?></h3>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M233.4 406.6c12.5 12.5 32.8 12.5 45.3 0l192-192c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L256 338.7 86.6 169.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l192 192z"/></svg>
                            </button>
                        </div>
        
                        <div id="collapse<?php echo $counter; ?>" class="collapse<?php if($index == 0): ?> show<?php endif; ?>" aria-labelledby="heading<?php echo $counter; ?>" data-bs-parent="#accordion">
                            <div class="faq-content card-body">
                                <?php echo $content; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
		
		<?php if($content_bottom): ?>
		    <div class="my-5 text-center">
		        <?= $content_bottom; ?>
		    </div>
		<?php endif; ?>
		
		<?php if($cta): ?>
			<div class="cta-btn-cont d-flex justify-content-center mt-4">
				<a href="<?php echo $cta['url']; ?>" class="cta-button btn btn-primary text-decoration-none"><?php echo $cta['title']; ?></a>
			</div>
		<?php endif; ?>
	</div>
</section>
```



---

# 🧪 Test Implementation

1. Open any **Mass Torts** page, add the **FAQ Layout**, and test all newly added fields.
<img width="702" height="405" alt="image" src="https://github.com/user-attachments/assets/aa2801c2-1019-4af0-8a2c-09241c70e9a6" />
<img width="703" height="279" alt="image" src="https://github.com/user-attachments/assets/45b7aff8-33f5-4411-8581-b5a4f7922674" />

2. Adjust the **styling** to match the current theme and ensure font sizes are properly optimized for **both mobile and desktop**.
<img width="950" height="582" alt="image" src="https://github.com/user-attachments/assets/171a4b93-23d2-45c0-bd8a-8cc538ff9a91" />
   
3. Confirm that the **JSON-LD schema code** is being correctly generated and displayed.
<img width="580" height="188" alt="image" src="https://github.com/user-attachments/assets/a4962068-f2ac-4f7b-9f5f-3aad848e1b6e" />


---

# ✅ QA Checklist

### 1. FAQ Accordion
- [ ] Verify the FAQ Accordion UI for any layout or style issues (on both mobile and desktop).

### 2. Field Functionality
- [ ] Confirm all fields work as intended.  
- [ ] Test possible HTML tags within the FAQ content — e.g. `<a>`, `<ul>`, `<ol>` — to ensure they render and style correctly.

### 3. Schema Validation
- [ ] Validate the generated JSON-LD schema using the [Google Structured Data Testing Tool](https://developers.google.com/search/docs/appearance/structured-data).
