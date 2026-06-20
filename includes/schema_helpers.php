<?php
/**
 * schema_helpers.php — dependency-free JSON-LD builders for static pages
 * (service / industry / location landing pages).
 *
 * Mirrors the hand-built schema pattern already proven in blog-post.php:
 * each function returns a JSON string encoded with
 * JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT, ready to drop into the
 * $schema_extra array that header.php loops into <script type="application/ld+json">.
 *
 * Usage (root OR subdirectory page), set BEFORE include of header.php:
 *
 *   require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/schema_helpers.php';
 *   $breadcrumbs = [
 *       ['name' => 'Home',     'url' => 'https://appverra.co/'],
 *       ['name' => 'Services', 'url' => 'https://appverra.co/our-services'],
 *       ['name' => 'iOS App Development', 'url' => 'https://appverra.co/services/ios-app-development'],
 *   ];
 *   $schema_extra = [
 *       build_service_schema([...]),
 *       build_breadcrumb_schema($breadcrumbs),
 *       build_faq_schema($faqs),   // optional
 *   ];
 *
 * The global Organization + LocalBusiness + WebSite schema lives in header.php
 * and is inherited by every page — do NOT re-emit it here.
 */

if (!function_exists('build_service_schema')) {

    /**
     * Service schema for a service / industry / location landing page.
     *
     * @param array $cfg Keys:
     *   - name         (required) e.g. "iOS App Development"
     *   - description  (required) one-paragraph summary
     *   - url          (required) absolute canonical URL of the page
     *   - serviceType  (optional) default "Mobile App Development"
     *   - areaServed   (optional) array of country codes; default US/CA/GB
     *   - areaServedCity (optional) City name string — overrides areaServed with a City object (location pages)
     *   - audience     (optional) BusinessAudience audienceType string (industry pages)
     *   - offers       (optional) array of ['name','price','description'(opt),'priceCurrency'(opt)]
     */
    function build_service_schema(array $cfg): string {
        $schema = [
            '@context'    => 'https://schema.org',
            '@type'       => 'Service',
            'name'        => $cfg['name'],
            'serviceType' => $cfg['serviceType'] ?? 'Mobile App Development',
            'provider'    => [
                '@type' => 'Organization',
                'name'  => 'Appverra',
                'url'   => 'https://appverra.co/',
                'logo'  => 'https://appverra.co/assets/images/logo.webp',
            ],
            'url'         => $cfg['url'],
            'description' => $cfg['description'],
            'areaServed'  => $cfg['areaServed'] ?? ['US', 'CA', 'GB'],
        ];

        if (!empty($cfg['areaServedCity'])) {
            $schema['areaServed'] = ['@type' => 'City', 'name' => $cfg['areaServedCity']];
        }

        if (!empty($cfg['audience'])) {
            $schema['audience'] = ['@type' => 'BusinessAudience', 'audienceType' => $cfg['audience']];
        }

        if (!empty($cfg['offers']) && is_array($cfg['offers'])) {
            $schema['offers'] = array_map(function ($o) {
                $offer = [
                    '@type'         => 'Offer',
                    'name'          => $o['name'],
                    'price'         => (string)$o['price'],
                    'priceCurrency' => $o['priceCurrency'] ?? 'USD',
                ];
                if (!empty($o['description'])) $offer['description'] = $o['description'];
                return $offer;
            }, $cfg['offers']);
        }

        return json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
    }

    /**
     * BreadcrumbList schema from an ordered array of crumbs.
     *
     * @param array $crumbs [['name' => '…', 'url' => 'https://…'], …]
     *                      Include the current page as the final crumb (with its own URL).
     */
    function build_breadcrumb_schema(array $crumbs): string {
        $items = [];
        $pos   = 1;
        foreach ($crumbs as $c) {
            if (empty($c['name'])) continue;
            $items[] = [
                '@type'    => 'ListItem',
                'position' => $pos++,
                'name'     => $c['name'],
                'item'     => $c['url'] ?? '',
            ];
        }
        return json_encode([
            '@context'        => 'https://schema.org',
            '@type'           => 'BreadcrumbList',
            'itemListElement' => $items,
        ], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
    }

    /**
     * FAQPage schema from Q&A pairs.
     *
     * @param array $faqs [['question' => '…', 'answer' => '…'], …]
     *                    Pair shape matches post_extract_faqs() output, so callers may pass
     *                    that directly. Returns '' when there are no pairs (skip the block).
     */
    function build_faq_schema(array $faqs): string {
        $faqs = array_values(array_filter($faqs, fn($f) => !empty($f['question']) && !empty($f['answer'])));
        if (!$faqs) return '';
        return json_encode([
            '@context'   => 'https://schema.org',
            '@type'      => 'FAQPage',
            'mainEntity' => array_map(fn($f) => [
                '@type'          => 'Question',
                'name'           => $f['question'],
                'acceptedAnswer' => ['@type' => 'Answer', 'text' => $f['answer']],
            ], $faqs),
        ], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
    }
}
