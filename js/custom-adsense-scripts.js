// custom-adsense-scripts.js

jQuery(document).ready(function($) {
    // Get the AdSense placement from the localized variable
    var adsensePlacement = adsensePlacement.placement;

    // Your AdSense code
    var adSenseCode = '<!-- Replace this with your AdSense code -->';

    // Insert the AdSense code based on the selected placement
    switch (adsensePlacement) {
        case 'top':
            $('#hubwebz-custom-adsense-code').prepend(adSenseCode);
            break;
        case 'below_title':
            $('.single-post header').append('<div class="hubwebz-custom-adsense-code">' + adSenseCode + '</div>');
            break;
        case 'after_featured_image':
            $('.single-post .post-thumbnail').after('<div class="hubwebz-custom-adsense-code">' + adSenseCode + '</div>');
            break;
        case 'after_second_paragraph':
            $('.single-post p:nth-of-type(2)').after('<div class="hubwebz-custom-adsense-code">' + adSenseCode + '</div>');
            break;
        case 'middle':
            var paragraphs = $('.single-post p');
            var middleIndex = Math.floor(paragraphs.length / 2);
            $(paragraphs[middleIndex]).after('<div class="hubwebz-custom-adsense-code">' + adSenseCode + '</div>');
            break;
        case 'bottom':
            $('.single-post').append('<div class="hubwebz-custom-adsense-code">' + adSenseCode + '</div>');
            break;
        case 'after_author_box':
            $('.single-post .author-box').after('<div class="hubwebz-custom-adsense-code">' + adSenseCode + '</div>');
            break;
    }
});
