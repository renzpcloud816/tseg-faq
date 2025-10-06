<?php
if(have_rows('tseg_content_faqs')): 
    $faq_title_tag = get_field('faq_title_tag') ? 'span' : 'h3';
    $faq_counter = 1;
?>
<div class="tseg-accordion tseg-accordion-mh">
	<?php while( have_rows('tseg_content_faqs')) : the_row();
	    $faq_active = $faq_counter == 1 ? 'active' : '';
		$faq_title = get_sub_field('faq_title');
		$faq_answer = get_sub_field('faq_answer');
	?>
	<div class="tseg-accordion-item tseg-accordion-item-<?php echo $faq_counter .' '. $faq_active; ?>">
		<<?= $faq_title_tag; ?> class="tseg-accordion-header">
		    <span><?php echo $faq_title; ?></span>
		    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M212.7 363.3c6.2 6.2 16.4 6.2 22.6 0l160-160c6.2-6.2 6.2-16.4 0-22.6s-16.4-6.2-22.6 0L224 329.4 75.3 180.7c-6.2-6.2-16.4-6.2-22.6 0s-6.2 16.4 0 22.6l160 160z"/></svg>
		</<?= $faq_title_tag; ?>>
		<div class="tseg-accordion-body">
			<div class="tseg-accordion-content"><?php echo $faq_answer; ?></div>
		</div>
	</div>
	<?php $faq_counter++; endwhile; ?>
</div>


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

<style>
.tseg-accordion {
    max-width: 100%;
    margin: 25px 0;
}
.tseg-accordion.tseg-accordion-mh {
    position: relative;
    overflow-y: auto;
    max-height: 500px;
    padding-right: 4px;
}

.tseg-accordion::-webkit-scrollbar {
    width: 6px;
    padding-left: 10px;
}
.tseg-accordion::-webkit-scrollbar-track {
    border-radius: 0;
    background-color: #0001;
}
.tseg-accordion::-webkit-scrollbar-thumb {
    background: #c9b373;
    border-radius: 0;
}
.tseg-accordion-body {
	overflow: hidden;
	display: grid; 
	grid-template-rows: 0fr;
	transition: 350ms grid-template-rows ease;
}
.tseg-accordion-item {
    max-width: 100%;
    margin-bottom: 8px;
    border: 1px solid #b3242a;
}
.tseg-accordion-item:last-of-type {
    margin-bottom: 0;
}
.tseg-accordion-header {
    display: flex;
	justify-content: space-between;
	gap: 16px;
    margin: 0 !important;
	padding: 16px!important;
	background-color: #003764;
	color: white;
	cursor: pointer;
	font-size: 1.2rem;
	transition: 0.4s;
}
.tseg-accordion-header svg {
	width: 1em;
	min-width: 20px;
	fill: #FFFFFF;
	transition: 0.4s;
}
.tseg-accordion-body > div {
    overflow: hidden;
}
.tseg-accordion-item.active .tseg-accordion-header {
    background-color: #b3242a;
}
.tseg-accordion-item.active .tseg-accordion-header svg {
    transform: rotate(180deg);
}
.tseg-accordion-item.active .tseg-accordion-body {
    grid-template-rows: 1fr;
}
.tseg-accordion-item .tseg-accordion-content {
    padding: 16px 16px 10px;
}
.tseg-accordion-item:not(.active) .tseg-accordion-body {
    width: 1px !important;
    height: 1px !important;
    padding: 0 !important;
    margin: -1px !important;
    overflow: hidden !important;
    clip: rect(0, 0, 0, 0) !important;
    white-space: nowrap !important;
    border: 0 !important;
}

.tseg-accordion-item .tseg-accordion-content p {
    margin-bottom: 10px;
}

@media (min-width: 768px) {
    .tseg-accordion-header {
        font-size: 1.4rem;
    }
}
</style>

<script>
const accordionContainer = document.querySelector('.tseg-accordion.tseg-accordion-mh');

document.querySelectorAll('.tseg-accordion .tseg-accordion-header').forEach(header => {
	header.addEventListener('click', function(e) {
		const accordionItem = this.parentElement;
		const allItems = document.querySelectorAll('.tseg-accordion .tseg-accordion-item');
		
		// Close all other accordions
		allItems.forEach(item => {
			if (item !== accordionItem) {
				item.classList.remove('active');
			}
		});
		
		// Toggle the clicked accordionif
		accordionItem.classList.toggle('active');
	});
});
</script>
<?php endif; // If have rows faqs ?>